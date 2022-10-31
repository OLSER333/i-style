<?php

namespace App\Controllers;

use App\Classes\JsonTrait;
use App\System\Core\Controller;
use Themes\Purple\Models\CatalogServiceModel;
use Themes\Purple\Models\FaqQuestionModel;
use Themes\Purple\Models\PageModel;
use Themes\Purple\Models\PurpleModel;
use Themes\Purple\Models\ReviewModel;
use Themes\Purple\Models\SalonCardModel;

use const App\ROOT\SYSTEM_MODE;

use function App\app;
use function App\db;
use function App\get_text;
use function App\getPagination;
use function App\is_logged_in;
use function App\replaceToBr;
use function App\user;

class Seller extends Controller
{
    use JsonTrait;

    function __construct()
    {
        $this->loadTheme('purple');
        $this->currency = app()->currency['currency_symbol'];
    }

    function main($seller_id)
    {
        $seller_id = intval($seller_id);

        if (!$seller_id or $seller_id === 0) {
            return false;
        }

        $seller = db()->find_one("SELECT * FROM `user` WHERE `user_id` = $seller_id AND user_status = 'active' AND user_role = 'salon' OR `user_id` = $seller_id AND user_status = 'active' AND user_role = 'master'");

        if (empty($seller)) {
            return false;
        }

        $this->_addReview($seller_id);

        $variables['seller'] = new SalonCardModel($seller, 'components/salon_page', true);

        $breadcrumbs = [
            [
                'title' => get_text('home'),
                'link' => '/',
                'active' => false
            ],
            [
                'title' => get_text($seller['user_role']),
                'link' => '',
                'active' => true,
                'arrow' => true
            ],
            [
                'title' => $variables['seller']->data['name'],
                'link' => '',
                'active' => true
            ]
        ];

        $this->model = new PageModel($variables['seller']->data['name'], new PurpleModel('content/seller', $variables), null, $breadcrumbs, 'body-salon', 'default-page-wrapper', '/catalog', [], [], false);
        $this->model->load();
    }

    private function _addReview(int $seller_id): void
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
            db()->insert('review', [
                'review_text' => $text,
                'review_rating' => $rate,
                'user_id' => user()->user_id,
                'review_date_add' => time(),
                'review_status' => 'active',
                'review_object' => 'seller',
                'review_object_id' => $seller_id
            ]);
            $this->_updateRating($seller_id);
            $this->_returnStatusMessage('review_added_successfully');
        }
    }

    private function _updateRating(int $seller_id): void
    {
        $reviews = db()->find('review', [
            'review_object_id' => $seller_id,
            'review_object' => 'seller'
        ]);
        $all_rate = 0;
        $rate_count = count($reviews);
        foreach ($reviews as $review) {
            $all_rate = $all_rate + $review['review_rating'];
        }
        $newRating = $all_rate / $rate_count;
        db()->update('user', ['user_rating' => $newRating], $seller_id);
    }
}
