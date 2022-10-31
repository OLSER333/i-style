<?php

namespace Themes\Purple\Models;

use function App\db;
use function App\get_text;
use function App\getPrice;
use function App\getUserAvatar;
use function App\is_logged_in;
use function App\option;
use function App\user;

class SalonCardModel extends PurpleModel
{
    function __construct(array $salon, string $view = 'components/salon_card', bool $isSalonPage = false)
    {
        $salon_id = $salon['user_id'];

        $variables = [];
        $variables['type'] = $salon['user_role'];
        $variables['url'] = "/sellers/$salon_id";
        if ($salon['user_role'] === 'salon') {
            $variables['name'] = $salon['salon_name'];
        } else if ($salon['user_role'] === 'master') {
            $variables['name'] = $salon['first_name'] . ' ' . $salon['last_name'];
        }

        $variables['in_favorites'] = '';
        $variables['in_favorites_icon'] = 'fa-regular';
        if ($isSalonPage === true) {
            $variables['in_favorites_text'] = 'add_' . $variables['type'] . '_to_wishlist';
        }
        if (is_logged_in() and user()->user_role === 'customer') {
            if (!empty(user()->favorites)) {
                foreach (user()->favorites as $favoriteItem) {
                    if ($favoriteItem['user_favorite_type'] === 'seller' and $favoriteItem['object_id'] === $salon_id) {
                        $variables['in_favorites'] = 'active';
                        $variables['in_favorites_icon'] = 'fa-solid';
                        if ($isSalonPage === true) {
                            $variables['in_favorites_text'] = 'remove_' . $variables['type'] . '_from_wishlist';
                        }
                        break;
                    }
                }
            }
        }

        $variables['logo'] = getUserAvatar(strval($salon['user_avatar']), $variables['name']);
        $variables['adress'] = $salon['contact_adress'];
        $variables['rating'] = floatval($salon['user_rating']);
        $images = db()->find('user_photo', ['user_id' => $salon_id, 'user_photo_status' => 'active']);
        foreach ($images as $image) {
            $variables['images'][] = $image['photo_path'];
        }
        $services = db()->select(
            "SELECT
                `service`.`service_id`,
                `service`.`service_name`,
                `service`.service_slug,
                `service_subcategory`.service_subcategory_slug,
                `service_category`.service_category_slug,
                `service`.lang_key
            FROM `service_category`
            LEFT JOIN `service_subcategory`
            ON `service_category`.service_category_id = `service_subcategory`.service_category_id
            LEFT JOIN `service`
            ON `service_subcategory`.service_subcategory_id = `service`.service_subcategory_id
            LEFT JOIN `user_service`
            ON `service`.service_id = `user_service`.service_id
            WHERE user_service.user_id = $salon_id
            AND user_service.user_service_status = 'active'"
        );

        $reviews = db()->find('review', [
            'review_object_id' => $salon_id
        ], '*', 'review_date_add', true);
        foreach ($reviews as $key => $review) {
            $review['first_name'] = user()->first_name;
            $review['last_name'] = user()->last_name;
            $reviews[$key] = new ReviewModel($review);
        }

        $variables['reviews'] = $reviews;

        $variables['services'] = [];
        foreach ($services as $service) {
            $variables['all_services'][$service['service_id']]['url'] = '?service=' . $service['service_slug'];
            $variables['all_services'][$service['service_id']]['name'] = get_text($service['lang_key'], $service['service_name']);
            if (count($variables['services']) >= 6) {
                continue;
            }
            $variables['services'][$service['service_id']]['url'] = '/catalog/' . $service['service_category_slug'] . '/' . $service['service_subcategory_slug'] . '/' . $service['service_slug'];
            $variables['services'][$service['service_id']]['name'] = get_text($service['lang_key'], $service['service_name']);
        }
        $servicePrices = db()->select(
            "SELECT user_service.user_service_price FROM `user_service`
            WHERE user_service.user_id = $salon_id
            AND user_service.user_service_status = 'active'
            ORDER BY user_service.user_service_price ASC"
        );
        $variables['real_price'] = 0;
        if (!empty($servicePrices)) {
            $min = $servicePrices[0]['user_service_price'];
            $max = $servicePrices[array_key_last($servicePrices)]['user_service_price'];
            $variables['min_price'] = getPrice($min);
            if ($min !== $max) {
                $variables['max_price'] = getPrice($max);
            } else {
                $variables['max_price'] = false;
            }
            $variables['real_price'] = $min;
        } else {
            $variables['min_price'] = getPrice(0);
            $variables['max_price'] = getPrice(0);
        }

        $variables['id'] = $salon_id;
        $variables['more_services'] = 0;
        if (!empty($servicePrices)) {
            $variables['more_services'] = count($servicePrices);
        }

        $variables['reviews_count'] = db()->select(
            "SELECT `review`.review_id FROM `review`
            WHERE review.review_object_id = $salon_id
            AND review.review_object = 'seller'
            AND review.review_status = 'active'"
        );
        if (!empty($variables['reviews_count']) and is_array($variables['reviews_count'])) {
            $variables['reviews_count'] = count($variables['reviews_count']);
        } else {
            $variables['reviews_count'] = 0;
        }

        if ($isSalonPage === true) {

            $salonServices = db()->select(
                "SELECT
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
                AND user_service.user_service_status = 'active'
                AND `user`.`user_id` = $salon_id"
            );

            $variables['salon_services'] = [];
            $variables['additional_services'] = [];
            if (!empty($salonServices)) {
                $objectServices = [];
                foreach ($salonServices as $salonService) {
                    $objectServices[] = new CatalogServiceModel($salonService, false, 'components/salon_page_service_card', false);
                }
                if (count($objectServices) > 7) {
                    $variables['salon_services'] = array_slice($objectServices, 0, 7);
                    $variables['additional_services'] = array_slice($objectServices, 6);
                } else {
                    $variables['salon_services'] = $objectServices;
                }
            }

            $dayOff = get_text('day_off');
            $variables['worktime'] = [
                'monday' => $dayOff,
                'tuesday' => $dayOff,
                'wednesday' => $dayOff,
                'thursday' => $dayOff,
                'friday' => $dayOff,
                'saturday' => $dayOff,
                'sunday' => $dayOff
            ];
            if ($salon['mon_worktime'] !== '' and $salon['mon_worktime'] !== null) {
                $variables['worktime']['monday'] = str_replace(' ', '', $salon['mon_worktime']);
            }
            if ($salon['tue_worktime'] !== '' and $salon['tue_worktime'] !== null) {
                $variables['worktime']['tuesday'] = str_replace(' ', '', $salon['tue_worktime']);
            }
            if ($salon['wed_worktime'] !== '' and $salon['wed_worktime'] !== null) {
                $variables['worktime']['wednesday'] = str_replace(' ', '', $salon['wed_worktime']);
            }
            if ($salon['thu_worktime'] !== '' and $salon['thu_worktime'] !== null) {
                $variables['worktime']['thursday'] = str_replace(' ', '', $salon['thu_worktime']);
            }
            if ($salon['fri_worktime'] !== '' and $salon['fri_worktime'] !== null) {
                $variables['worktime']['friday'] = str_replace(' ', '', $salon['fri_worktime']);
            }
            if ($salon['sat_worktime'] !== '' and $salon['sat_worktime'] !== null) {
                $variables['worktime']['saturday'] = str_replace(' ', '', $salon['sat_worktime']);
            }
            if ($salon['sun_worktime'] !== '' and $salon['sun_worktime'] !== null) {
                $variables['worktime']['sunday'] = str_replace(' ', '', $salon['sun_worktime']);
            }

            $variables['social'] = [];
            if ($salon['facebook_link'] !== '' and $salon['facebook_link'] !== null) {
                $variables['social'][] = [
                    'link' => $salon['facebook_link'],
                    'icon' => option('facebook_icon')
                ];
            }
            if ($salon['youtube_link'] !== '' and $salon['youtube_link'] !== null) {
                $variables['social'][] = [
                    'link' => $salon['youtube_link'],
                    'icon' => option('youtube_icon')
                ];
            }
            if ($salon['linkedin_link'] !== '' and $salon['linkedin_link'] !== null) {
                $variables['social'][] = [
                    'link' => $salon['linkedin_link'],
                    'icon' => option('linkedin_icon')
                ];
            }
            if ($salon['instagram_link'] !== '' and $salon['instagram_link'] !== null) {
                $variables['social'][] = [
                    'link' => $salon['instagram_link'],
                    'icon' => option('instagram_icon')
                ];
            }
            if ($salon['pinterest_link'] !== '' and $salon['pinterest_link'] !== null) {
                $variables['social'][] = [
                    'link' => $salon['pinterest_link'],
                    'icon' => option('pinterest_icon')
                ];
            }

            $variables['phones'] = [];
            $variables['additional_phones'] = [];
            if ($salon['contact_phone'] !== '' and $salon['contact_phone'] !== null) {
                $variables['phones'][] = [
                    'full_phone' => $salon['contact_phone'],
                    'first_number' => '+' . mb_substr($salon['contact_phone'], 0, 1),
                    'additional_numbers' => mb_substr($salon['contact_phone'], 1)
                ];
            }
            if ($salon['contact_phone_2'] !== '' and $salon['contact_phone_2'] !== null) {
                $variables['phones'][] = [
                    'full_phone' => $salon['contact_phone_2'],
                    'first_number' => '+' . mb_substr($salon['contact_phone_2'], 0, 1),
                    'additional_numbers' => mb_substr($salon['contact_phone_2'], 1)
                ];
            }
            if ($salon['contact_phone_3'] !== '' and $salon['contact_phone_3'] !== null) {
                $variables['additional_phones'][] = [
                    'full_phone' => $salon['contact_phone_3'],
                    'first_number' => '+' . mb_substr($salon['contact_phone_3'], 0, 1),
                    'additional_numbers' => mb_substr($salon['contact_phone_3'], 1)
                ];
            }
            if ($salon['contact_phone_4'] !== '' and $salon['contact_phone_4'] !== null) {
                $variables['additional_phones'][] = [
                    'full_phone' => $salon['contact_phone_4'],
                    'first_number' => '+' . mb_substr($salon['contact_phone_4'], 0, 1),
                    'additional_numbers' => mb_substr($salon['contact_phone_4'], 1)
                ];
            }

            $variables['relative_salons'] = [];
            $servicesQueryList = [];
            foreach ($variables['all_services'] as $serviceId => $serviceItem) {
                $servicesQueryList[] = '`user_service`.`service_id` = ' . $serviceId . " AND `user`.`user_id` != $salon_id";
            }
            $servicesQuery = implode(' OR ', $servicesQueryList);

            $relativeSalons = db()->select(
                "SELECT * FROM `user`
                LEFT JOIN `user_service`
                ON `user`.`user_id` = `user_service`.`user_id`
                WHERE $servicesQuery
                LIMIT 4 OFFSET 0
            "
            );

            if (!empty($relativeSalons)) {
                foreach ($relativeSalons as $relativeSalon) {
                    $variables['relative_salons'][] = new SalonCardModel($relativeSalon, 'components/master_card_landing');
                }
            }
            $variables['review_topup'] = new TopupModel(new ReviewFormModel($variables['name'], 'leave_a_review_about_the_' . $variables['type'], 'describe_your_experience_at_the_' . $variables['type'], false), 'review-button-js');
        }
        $this->data = $variables;

        parent::__construct($view, $variables);
    }
}



// new Column('mon_worktime', 'time_range'),
// new Column('tue_worktime', 'time_range'),
// new Column('wed_worktime', 'time_range'),
// new Column('thu_worktime', 'time_range'),
// new Column('fri_worktime', 'time_range'),
// new Column('sat_worktime', 'time_range'),
// new Column('sun_worktime', 'time_range'),
// new Column('contact_phone', 'full_phone'),
// new Column('contact_phone_2', 'full_phone'),
// new Column('contact_phone_3', 'full_phone'),
// new Column('contact_phone_4', 'full_phone'),
// new Column('facebook_link', 'url'),
// new Column('youtube_link', 'url'),
// new Column('linkedin_link', 'url'),
// new Column('instagram_link', 'url'),
// new Column('pinterest_link', 'url'),