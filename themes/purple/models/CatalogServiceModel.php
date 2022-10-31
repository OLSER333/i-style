<?php

namespace Themes\Purple\Models;

use function App\db;
use function App\get_text;
use function App\getPrice;
use function App\getUserAvatar;
use function App\is_logged_in;
use function App\user;

class CatalogServiceModel extends PurpleModel
{
    function __construct(array $service, bool $displaySubCategory = false, string $view = 'components/service_card', bool $isCatalogService = true, bool $isServicePage = false)
    {

        $variables = [];

        $variables['type'] = 'service';
        $user_service_id = $service['user_service_id'];
        if($isCatalogService === true) {
            $user_id = $service['user_id'];
            $variables['user_url'] = "/sellers/$user_id";
            $variables['user_role'] = get_text($service['user_role']);
            if($service['user_role'] === 'salon') {
                $variables['user_name'] = $service['salon_name'];
            } else if($service['user_role'] === 'master') {
                $variables['user_name'] = $service['first_name'].' '.$service['last_name'];
            }
            if($isServicePage === true) {
                $variables['logo'] = getUserAvatar($service['user_avatar'], $variables['user_name']);
                $variables['desc'] = $service['user_service_desc'];
                if($variables['desc'] === '' or !$variables['desc']) {
                    $variables['desc'] = get_text('no_description');
                }
            }
            $variables['adress'] = $service['contact_adress'];
        }

        $variables['in_favorites'] = '';
        $variables['in_favorites_icon'] = 'fa-regular';
        if($isServicePage === true) {
            $variables['in_favorites_text'] = 'add_service_to_wishlist';
        }
        
        if(is_logged_in() and user()->user_role === 'customer') {
            if(!empty(user()->favorites)) {
                foreach(user()->favorites as $favoriteItem) {
                    if($favoriteItem['user_favorite_type'] === 'service' and $favoriteItem['object_id'] === $user_service_id) {
                        $variables['in_favorites'] = 'active';
                        $variables['in_favorites_icon'] = 'fa-solid';
                        if($isServicePage === true) {
                            $variables['in_favorites_text'] = 'remove_service_from_wishlist';
                        }
                        break;
                    }
                }
            }
        }

        $variables['service_url'] = "/services/$user_service_id";

        $variables['discount'] = false;
        if(time() < $service['user_service_discount_expire']) {
            if($isServicePage === true) {
                $discountPercent = $service['user_service_discount'].'%';
                $variables['discount'] = get_text('discount_for_the_procedure', false, $discountPercent);
                $variables['discount'].= ' '.date('d.m.Y', $service['user_service_discount_expire']);
                $variables['default_price'] = getPrice($service['user_service_price']);
                $service['user_service_price'] = $service['user_service_price']-$service['user_service_price']/100*$service['user_service_discount'];
            } else {
                $variables['real_discount'] = $service['user_service_discount'];
                $variables['discount'] = '-'.$service['user_service_discount'].'%';
                $service['user_service_price'] = $service['user_service_price']-$service['user_service_price']/100*$service['user_service_discount'];
            }
        }

        $variables['name'] = $service['user_service_name'];
        $variables['id'] = $service['user_service_id'];

        $variables['rating'] = floatval($service['user_service_rating']);
        $variables['price'] = getPrice($service['user_service_price']);
        $variables['real_price'] = $service['user_service_price'];
        $variables['time'] = $service['user_service_time'].' '.mb_strtolower(mb_substr(get_text($service['time_unit'].'s'), 0 ,1));

        $images = db()->find('user_service_photo', ['user_service_id' => $user_service_id, 'user_service_photo_status' => 'active']);
        foreach($images as $image) {
            $variables['images'][] = $image['photo_path'];
        }

        if($isServicePage === true) {
            $variables['review_topup'] = new TopupModel(new ReviewFormModel($variables['name'], 'leave_a_review_about_the_service', 'describe_your_experience_about_the_service', true), 'review-button-js');
        }

        $variables['reviews_count'] = db()->select(
            "SELECT `review`.review_id FROM `review`
            WHERE review.review_object_id = $user_service_id
            AND review.review_object = 'service'
            AND review.review_status = 'active'"
        );
        if(!empty($variables['reviews_count']) and is_array($variables['reviews_count'])) {
            $variables['reviews_count'] = count($variables['reviews_count']);
        } else {
            $variables['reviews_count'] = 0;
        }

        if($displaySubCategory === true) {
            if($isCatalogService === true) {
                $serviceSubSlugPreUrl = '/catalog/'.$service['service_category_slug'].'/';
            } else {
                $serviceSubSlugPreUrl = '?subcategory=';
            }
            $variables['categories'][] = [
                'url' => $serviceSubSlugPreUrl.$service['service_subcategory_slug'],
                'name' => get_text($service['subcategory_lang_key'], $service['service_subcategory_name'])
            ];   
        }

        if($isCatalogService === true) {
            $serviceSlugPreUrl = '/catalog/'.$service['service_category_slug'].'/'.$service['service_subcategory_slug'].'/';
        } else {
            $serviceSlugPreUrl = '?service=';
        }

        $variables['categories'][] = [
            'url' => $serviceSlugPreUrl.$service['service_slug'],
            'name' => get_text($service['lang_key'], $service['service_name'])
        ];

        $this->data = $variables;

        parent::__construct($view, $variables);
    }
}
