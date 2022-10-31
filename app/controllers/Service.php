<?php

namespace App\Controllers;

use App\Classes\FileUpload;
use App\Classes\JsonTrait;
use App\Classes\Thumbs;
use App\System\Core\Controller;
use Themes\Purple\Models\CatalogServiceModel;
use Themes\Purple\Models\PageModel;
use Themes\Purple\Models\PurpleModel;
use Themes\Purple\Models\ReviewModel;

use const App\ROOT\ABSPATH;
use const App\ROOT\SYSTEM_MODE;

use function App\app;
use function App\db;
use function App\get_text;
use function App\getPagination;
use function App\is_logged_in;
use function App\reArrayFiles;
use function App\replaceToBr;
use function App\user;

class Service extends Controller
{
    use JsonTrait;

    function __construct()
    {
        $this->loadTheme('purple');
        $this->currency = app()->currency['currency_symbol'];
    }

    function main($service_id)
    {
        $service_id = intval($service_id);

        if (!$service_id or $service_id === 0) {
            return false;
        }

        $service = db()->find_one(
            "SELECT
                `user`.`user_id`,
                `user`.`user_role`,
                `user`.`first_name`,
                `user`.`last_name`,
                `user`.`salon_name`,
                `user`.`user_avatar`,
                `user`.`contact_adress`,
                `user_service`.`user_service_id`,
                `user_service`.`user_service_name`,
                `user_service`.`user_service_desc`,
                `user_service`.`user_service_rating`,
                `user_service`.`user_service_price`,
                `user_service`.`user_service_discount`,
                `user_service`.`user_service_discount_expire`,
                `user_service`.`user_service_time`,
                `user_service`.`time_unit`,
                `service`.`service_name`,
                `service`.`service_slug`,
                `service`.`lang_key`,
                `service_subcategory`.`service_subcategory_slug`,
                `service_subcategory`.`service_subcategory_name`,
                `service_subcategory`.`lang_key` AS subcategory_lang_key,
                `service_category`.`service_category_slug`,
                `service_category`.`service_category_name`,
                `service_category`.`lang_key` AS category_lang_key
            FROM `user_service`
            LEFT JOIN `service`
            ON `user_service`.service_id = `service`.service_id
            LEFT JOIN `service_subcategory`
            ON `service`.service_subcategory_id = `service_subcategory`.service_subcategory_id
            LEFT JOIN `service_category`
            ON `service_subcategory`.service_category_id = `service_category`.service_category_id
            RIGHT JOIN `user`
            ON user_service.user_id = `user`.`user_id`
            WHERE user.user_status = 'active'
            AND user_service.user_service_status = 'active'
            AND user_service.user_service_id = $service_id
        "
        );

        if (empty($service)) {
            return false;
        }

        $this->_addReview($service_id);

        $variables['service'] = new CatalogServiceModel($service, false, 'components/service_page', true, true);

        // if (!empty($best_masters)) {
        //     foreach ($best_masters as $master) {
        //         $masterModel = new SalonCardModel($master, 'components/master_card_landing');
        //         if (!empty($masterModel->variables['services'])) {
        //             $landingVariables['best_masters'][] = $masterModel;
        //         }
        //     }
        // }

        $breadcrumbs = [
            [
                'title' => get_text('home'),
                'link' => '/',
                'active' => false
            ],
            [
                'title' => get_text('service_catalog'),
                'link' => '/catalog',
                'active' => false
            ],
            [
                'title' => get_text($service['category_lang_key'], $service['service_category_name']),
                'link' => "/catalog/" . $service['service_category_slug'],
                'active' => false
            ],
            [
                'title' => get_text($service['subcategory_lang_key'], $service['service_subcategory_name']),
                'link' => "/catalog/" . $service['service_category_slug'] . '/' . $service['service_subcategory_slug'],
                'active' => false
            ],
            [
                'title' => get_text($service['lang_key'], $service['service_name']),
                'link' => "/catalog/" . $service['service_category_slug'] . '/' . $service['service_subcategory_slug'] . '/' . $service['service_slug'],
                'active' => true
            ]
        ];

        $titleBread = [get_text('all_services'), get_text($service['category_lang_key'], $service['service_category_name']), get_text($service['subcategory_lang_key'], $service['service_subcategory_name']), get_text($service['lang_key'], $service['service_name'])];

        $this->model = new PageModel($variables['service']->data['name'], new PurpleModel('content/service', $variables), get_text('service_catalog'), $breadcrumbs, 'body-service', 'default-page-wrapper', '/catalog', $titleBread, [], true);
        $this->model->load();
    }

    private function _addReview(int $service_id): void
    {
        if (isset($_POST['action'])) {
            $text = nl2br(trim(strip_tags($_POST['review_text'])), false);
            $rate = intval($_POST['review_rate']);
            if (!is_logged_in()) {
                $this->_returnError('login_or_register_to_take_this_action');
            }
            if (user()->user_role !== 'customer' and SYSTEM_MODE === 'production') {
                $this->_returnError('login_as_a_user_to_perform_this_action');
            }
            if ($text === '') {
                $this->_returnError('type_text');
            }
            if (strlen($text) > 1000) {
                $this->_returnError('max_1000_charasters');
            }
            if ($rate < 1 or $rate > 5) {
                $this->_returnError('choise_rate');
            }
            if (!empty($_FILES)) {
                $files = reArrayFiles($_FILES['review_photos']);
                if (count($files) > 10) {
                    $this->_returnError('max_10_photos');
                }
            }

            db()->insert('review', [
                'review_text' => $text,
                'review_rating' => $rate,
                'user_id' => user()->user_id,
                'review_date_add' => time(),
                'review_status' => 'active',
                'review_object' => 'service',
                'review_object_id' => $service_id
            ]);
            $review_id = db()->insert_id;

            if (isset($files) and !empty($files)) {
                $folderPath = "/assets/uploads/" . user()->user_id;
                $folder = ABSPATH . $folderPath;
                foreach ($files as $key => $file) {
                    if (empty($file['name'])) {
                        break;
                    }
                    if (exif_imagetype($file['name'])) {
                        continue;
                    }
                    $photo = new FileUpload($file, $folderPath, IMAGE_MIME_TYPES, 5, false);
                    $photo->upload();
                    $image = new Thumbs(ABSPATH . '/' . $photo->uploadPath);
                    $image->resize(800, 0);
                    $fname = time() . '-' . $key . '-800.png';
                    $fpath = $folderPath . '/' . $fname;
                    $image->save($folder . '/' . $fname);
                    db()->insert('review_photo', [
                        'review_id' => $review_id,
                        'review_photo_status' => 'active',
                        'photo_path' => $fpath,
                        'review_photo_date_add' => time()
                    ]);
                }
            }
            $this->_updateRating($service_id);
            $this->_returnStatusMessage('review_added_successfully');
        }
    }

    private function _updateRating(int $service_id): void
    {
        $reviews = db()->find('review', [
            'review_object_id' => $service_id,
            'review_object' => 'service'
        ]);
        $all_rate = 0;
        $rate_count = count($reviews);
        foreach ($reviews as $review) {
            $all_rate = $all_rate + $review['review_rating'];
        }
        $newRating = $all_rate / $rate_count;
        db()->update('user_service', ['user_service_rating' => $newRating], $service_id);
    }
}
