<?php

namespace App\Controllers;

use App\Classes\Admin\Form;
use App\Classes\FileUpload;
use App\Classes\Menu\Menu;
use App\Classes\Menu\MenuItem;
use App\Classes\Thumbs;
use Themes\Regular\Models\DashboardContentModel;
use Themes\Regular\Models\DashboardModel;
use App\System\Core\Controller;
use Themes\Purple\Models\CatalogServiceModel;
use Themes\Purple\Models\PageModel;
use Themes\Purple\Models\PurpleModel;
use Themes\Purple\Models\ReviewModel;
use Themes\Purple\Models\SalonCardModel;

use const App\DATETIME_FORMAT;
use const App\MAX_PASS_LENGTH;
use const App\MIN_PASS_LENGTH;
use const App\ROOT\ABSPATH;
use const App\ROOT\SYSTEM_MODE;

use function App\check_email;
use function App\clear_input;
use function App\db;
use function App\get_request_url;
use function App\get_text;
use function App\getUserAvatar;
use function App\is_admin;
use function App\is_logged_in;
use function App\redirect;
use function App\user;

class UserProfile extends Controller
{

    function __construct()
    {
        if (SYSTEM_MODE === 'production') {
            if (is_admin() and get_request_url() === 'profile/settings') {
                redirect('admin/profile/settings');
            }
            if (is_admin()) {
                redirect('admin');
            }
            if (!is_logged_in() or user()->user_role !== 'customer' and user()->user_role !== 'user') {
                redirect('sign_in');
            }
        } else if (!is_logged_in() and !is_admin()) {
            redirect('sign_in');
        }

        $this->variables['profile_name'] = user()->full_name;
        $this->variables['profile_first_name'] = user()->first_name;
        $this->variables['profile_last_name'] = user()->last_name;
        $this->variables['profile_avatar'] = getUserAvatar(user()->user_avatar, user()->full_name);
        $this->variables['profile_menu'] = new Menu(
            'profile_menu',
            new MenuItem(get_text('my_service_records'), '/dashboard', '', '', 'active', ''),
            new MenuItem(get_text('personal_data'), '/profile/settings', '', '', 'active', ''),
            new MenuItem(get_text('favorites'), '/profile/favorites', '', '', 'active', ''),
            new MenuItem(get_text('my_reviews'), '/profile/reviews', '', '', 'active', '')
        );

        if (isset($_FILES['photo_upload']) and exif_imagetype($_FILES['photo_upload']['name'])) {

            $current_user_id = user()->user_id;
            $folderPath = "/assets/uploads/$current_user_id";
            $folder = ABSPATH . $folderPath;

            $photo = new FileUpload($_FILES['photo_upload'], $folderPath, IMAGE_MIME_TYPES, 5, false);
            $photo->upload();
            $image = new Thumbs(ABSPATH . '/' . $photo->uploadPath);
            $image->resize(800, 0);
            $image->cut(640, 640);
            $fname = time() . '-800.png';
            $fpath = $folderPath . '/' . $fname;
            $image->save($folder . '/' . $fname);

            db()->update('user', ['user_avatar' => $fpath], $current_user_id);
            header('Location: /' . get_request_url());
            exit;
        }

        $this->loadTheme('purple');
    }

    function dashboard()
    {
        $this->_loadModel('profile/content/dashboard', t('my_service_records'), $this->variables, t('all_records'));
    }

    function favorites()
    {
        $favoritesArray = [];
        if (!empty(user()->favorites)) {
            foreach (user()->favorites as $favoriteItem) {
                $type = $favoriteItem['user_favorite_type'];
                $id = $favoriteItem['object_id'];
                if ($type === 'service') {
                    $favoriteObject = db()->find_one(
                        "SELECT
                            `user`.`user_id`,
                            `user`.`user_role`,
                            `user`.`first_name`,
                            `user`.`last_name`,
                            `user`.`salon_name`,
                            `user`.`contact_adress`,
                            `user_service`.`user_service_id`,
                            `user_service`.`user_service_name`,
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
                            `service_category`.`service_category_slug`
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
                        AND user_service.user_service_id = $id
                        AND user_service.user_service_status = 'active'"
                    );
                } else if ($type === 'seller') {
                    $table = 'user';
                    $id_column = 'user_id';
                    $status_column = 'user_status';
                    $favoriteObject = db()->findOne($table, [
                        $id_column => $id,
                        $status_column => 'active'
                    ]);
                }
                if (!empty($favoriteObject)) {
                    if ($type === 'service') {
                        $favoritesArray[] = new CatalogServiceModel($favoriteObject, true);
                    } else if ($type === 'seller') {
                        $favoritesArray[] = new SalonCardModel($favoriteObject);
                    }
                }
            }
            if (isset($_GET['filters'])) {
                $view = $_GET['view'];
                $search = trim(clear_input($_GET['search']));
                $sort = $_GET['sort'];
                if (in_array($view, ['all', 'salons', 'masters', 'services']) and in_array($sort, ['recent', 'price', 'discount', 'rating'])) {
                    foreach ($favoritesArray as $key => $item) {
                        $unset = false;
                        if ($view === 'salons' and $item->data['type'] !== 'salon') {
                            $unset = true;
                        } else if ($view === 'masters' and $item->data['type'] !== 'master') {
                            $unset = true;
                        } else if ($view === 'services' and $item->data['type'] !== 'service') {
                            $unset = true;
                        }
                        if ($search !== '' and mb_stripos($item->data['name'], $search) === false) {
                            $unset = true;
                        }
                        if ($unset === true) {
                            unset($favoritesArray[$key]);
                        }
                    }
                    if ($sort === 'rating') {
                        usort($favoritesArray, function ($a, $b) {
                            return $a->data['rating'] < $b->data['rating'];
                        });
                    } else if ($sort === 'price') {
                        usort($favoritesArray, function ($a, $b) {
                            return $a->data['real_price'] > $b->data['real_price'];
                        });
                    } else if ($sort === 'discount') {
                        usort($favoritesArray, function ($a, $b) {
                            return $a->data['real_discount'] < $b->data['real_discount'];
                        });
                    }
                }
            }
        }
        $this->variables['favorites'] = $favoritesArray;
        $this->_loadModel('profile/content/favorites', t('favorites'), $this->variables);
    }

    function reviews()
    {
        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $item = db()->findOne('review', [
                'user_id' => user()->user_id,
                'review_status' => 'active',
                'review_id' => $id
            ]);
            if (!empty($item)) {
                db()->update('review', ['review_status' => 'deleted'], $id);
                $this->variables['message'] = get_text('review_successfully_deleted');
            } else {
                $this->variables['error'] = get_text('review_deletion_error');
            }
        }

        $reviews = db()->find('review', [
            'user_id' => user()->user_id,
            'review_status' => 'active'
        ], '*', 'review_date_add', true);
        foreach ($reviews as $key => $review) {
            $review['first_name'] = user()->first_name;
            $review['last_name'] = user()->last_name;
            $reviews[$key] = new ReviewModel($review, 'review_profile');
        }

        if (isset($_GET['filters'])) {
            $view = $_GET['view'];
            $search = trim(clear_input($_GET['search']));
            if (in_array($view, ['all', 'salons', 'masters', 'services'])) {
                foreach ($reviews as $key => $item) {
                    $unset = false;
                    if ($view === 'services' and $item->data['review_object'] !== 'service') {
                        $unset = true;
                    } else if ($view === 'salons' or $view === 'masters') {
                        if ($item->data['review_object'] === 'service') {
                            $unset = true;
                        } else {
                            $objectItem = db()->findOne('user', [
                                'user_id' => $item->data['review_object_id']
                            ]);
                            if (empty($objectItem)) {
                                $unset = true;
                            } else if ($view === 'salons' and $objectItem['user_role'] !== 'salon') {
                                $unset = true;
                            } else if ($view === 'masters' and $objectItem['user_role'] !== 'master') {
                                $unset = true;
                            }
                        }
                    }
                    if ($search !== '' and mb_stripos($item->data['review_text'], $search) === false) {
                        $unset = true;
                    }
                    if ($unset === true) {
                        unset($reviews[$key]);
                    }
                }
            }
        }
        $this->variables['reviews'] = $reviews;
        $this->_loadModel('profile/content/reviews', t('my_reviews'), $this->variables);
    }

    function settings()
    {
        if (isset($_POST['password_form'])) {
            $this->variables['settings_form_hidden'] = 'hidden';
            $this->variables['password_form_hidden'] = '';

            $pass = $_POST['user_pass'];
            $pass_confirm = $_POST['user_pass_confirm'];

            if (strlen($pass) < MIN_PASS_LENGTH or strlen($pass) > MAX_PASS_LENGTH) {
                $error = 'incorrect_password_length';
            } else if ($pass !== $pass_confirm) {
                $error = 'passwords_do_not_match';
            }

            if (!empty($error)) {
                $this->variables['error'] = get_text($error);
            } else {
                db()->update('user', ['user_pass' => md5($pass)], user()->user_id);
                $this->variables['message'] = get_text('password_changed_successfully');
            }
        } else {
            $this->variables['settings_form_hidden'] = '';
            $this->variables['password_form_hidden'] = 'hidden';

            $form = new Form([
                'user.first_name',
                'user.last_name',
                'user.user_email',
                'user.user_phone',
                'user.user_gender',
                'user.contact_adress',
                'user.user_birthday'
            ], user()->user_array);

            if (isset($form->clientdata) and !empty($form->clientdata)) {
                $this->variables = $this->variables + $form->clientdata;
                if (isset($form->clientdata['user_birthday']) and !is_null($form->clientdata['user_birthday'])) {
                    $this->variables['user_birthday'] = date('d.m.Y', $form->clientdata['user_birthday']);
                } else {
                    $this->variables['user_birthday'] = '';
                }
                if (!$form->error) {
                    $user_email = $form->clientdata['user_email'];
                    $emailExists = db()->findOne('user', ['user_email' => $user_email]);
                    if ($user_email !== user()->user_email and !empty($emailExists)) {
                        $form->error = 'email_is_busy_by_another_user';
                    }
                    $user_phone = $form->clientdata['user_phone'];
                    $phoneExists = db()->findOne('user', ['user_phone' => $user_phone]);
                    if (intval($user_phone) !== intval(user()->user_phone) and !empty($phoneExists)) {
                        $form->error = 'phone_is_busy_by_another_user';
                    }
                    if (!$form->error) {
                        db()->update('user', $form->clientdata, user()->user_id);
                        $form->true = true;
                        $this->variables['message'] = get_text('changes_saved');
                    }
                }
                $this->variables['error'] = get_text($form->error);
            } else {
                $this->variables['first_name'] = user()->first_name;
                $this->variables['last_name'] = user()->last_name;
                $this->variables['user_email'] = user()->user_email;
                $this->variables['user_phone'] = user()->user_phone;
                $this->variables['user_gender'] = user()->user_gender;
                if (isset(user()->user_birthday) and !is_null(user()->user_birthday)) {
                    $this->variables['user_birthday'] = date('d.m.Y', user()->user_birthday);
                } else {
                    $this->variables['user_birthday'] = '';
                }
                $this->variables['contact_adress'] = user()->contact_adress;
            }
            $this->variables['formname'] = $form->formname;
        }

        $this->_loadModel('profile/content/settings', t('personal_data'), $this->variables);
    }

    private function _loadModel(string $viewName, string $title, array $variables = [], string|null $slash_title = null)
    {
        $breadcrumbs = [
            [
                'title' => get_text('home'),
                'link' => '/',
                'active' => false
            ],
            [
                'title' => get_text('personal_profile'),
                'link' => '',
                'active' => true,
                'arrow' => true
            ],
            [
                'title' => user()->full_name,
                'link' => '',
                'active' => true
            ]
        ];
        $variables['profile_content'] = new PurpleModel($viewName, $variables);
        $variables['profile_content_title'] = $title;
        if ($slash_title !== null) {
            $variables['profile_content_slash_title'] = $slash_title;
        }
        $this->model = new PageModel($title, new PurpleModel('profile/layout', $variables), breadcrumbs: $breadcrumbs, display_title: false);
        $this->model->load();
    }
}
