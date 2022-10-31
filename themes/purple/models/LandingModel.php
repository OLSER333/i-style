<?php

namespace Themes\Purple\Models;

use const App\SITE_NAME;

use function App\app;
use function App\db;
use function App\get_text;

class LandingModel extends PurpleModel
{
    function __construct(array $variables = [])
    {
        $landingVariables = [];
        $i = 0;
        foreach(app()->categories as $item) {
            $i++;
            if($i <= 7) {
                $landingVariables['categories_menu'][] = $item;
            } else {
                if(count(app()->categories) === 8) {
                    $landingVariables['categories_menu'][] = $item;
                } else {
                    $landingVariables['additional_categories_menu'][] = $item;
                }
            }
        }
        $questions = app()->db->find('faq', [], '*', 'CASE WHEN `sort_number` > 0 THEN `sort_number` = 0 ELSE `faq_id` END ', false);
        $questions = array_slice($questions, 0, 5);
        
        foreach($questions as $question) {
            $landingVariables['faq'][] = new FaqQuestionModel($question);
        }

        $landingVariables['header'] = new HeaderModel();
        $landingVariables['footer'] = new FooterModel();

        $masters_count = 0;
        $salons_count = 0;
        if(!empty(app()->masters)) {
            $masters_count = count(app()->masters);
        }
        if(!empty(app()->salons)) {
            $salons_count = count(app()->salons);
        }
        $landingVariables['offers_count'] = $masters_count+$salons_count;
        
        $best_salons = array_slice(app()->salons, 0, 4);
        $best_masters = array_slice(app()->masters, 0, 4);

        
        $salonWorks = db()->select(
            "SELECT
                `user`.`user_id`,
                `user`.salon_name,
                `user`.first_name,
                `user`.last_name,
                `user`.user_avatar,
                `user`.user_role,
                `service`.`service_name`,
                `service`.`service_slug`,
                `service`.`lang_key`,
                `user_service`.`user_service_id`,
                user_service_photo.photo_path
            FROM user_service
            LEFT JOIN `user_service_photo`
            ON `user_service`.user_service_id = user_service_photo.user_service_id
            LEFT JOIN `service`
            ON `service`.service_id = user_service.service_id
            RIGHT JOIN `user`
            ON user_service.user_id = `user`.user_id
            WHERE user_service.user_service_status = 'active'
            AND `user`.user_role = 'salon'
            ORDER BY user_service.user_service_rating
        ");
        $masterWorks = db()->select(
            "SELECT
                `user`.`user_id`,
                `user`.salon_name,
                `user`.first_name,
                `user`.last_name,
                `user`.user_avatar,
                `user`.user_role,
                `service`.`service_name`,
                `service`.`service_slug`,
                `service`.`lang_key`,
                `user_service`.`user_service_id`,
                user_service_photo.photo_path
            FROM user_service
            LEFT JOIN `user_service_photo`
            ON `user_service`.user_service_id = user_service_photo.user_service_id
            LEFT JOIN `service`
            ON `service`.service_id = user_service.service_id
            RIGHT JOIN `user`
            ON user_service.user_id = `user`.user_id
            WHERE user_service.user_service_status = 'active'
            AND `user`.user_role = 'master'
            ORDER BY user_service.user_service_rating
        ");
            
        $landingVariables['best_works'] = [];
        foreach($salonWorks as $key => $work) {
            if(count($landingVariables['best_works']) >= 8) {
                break;
            }
            // $workOrders = db()->find('order', ['order_status' => 'complete', 'user_service_id' => $work['user_service_id']]);
            $work['name'] = $work['salon_name'];
            $landingVariables['best_works'][] = $work;
            if(isset($masterWorks[$key])) {
                $masterWorks[$key]['name'] = $masterWorks[$key]['first_name'].' '.$masterWorks[$key]['last_name'];
                $landingVariables['best_works'][] = $masterWorks[$key]; 
            }
        }

        $landingVariables['best_salons'] = [];
        $landingVariables['best_masters'] = [];

        if(!empty($best_salons)) {
            foreach($best_salons as $salon) {
                $salonModel = new SalonCardModel($salon, 'components/salon_card_landing');
                if(!empty($salonModel->variables['services'])) {
                    $landingVariables['best_salons'][] = $salonModel;
                }
            }
        }
        
        if(!empty($best_masters)) {
            foreach($best_masters as $master) {
                $masterModel = new SalonCardModel($master, 'components/master_card_landing');
                if(!empty($masterModel->variables['services'])) {
                    $landingVariables['best_masters'][] = $masterModel;
                }
            }
        }

        $variables['title'] = get_text(app()->options['frontpage_title']).' - '.SITE_NAME;
        $variables['content'] = new PurpleModel('content/landing', $landingVariables);
        parent::__construct('layout', $variables);
    }
}
