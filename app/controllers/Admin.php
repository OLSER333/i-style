<?php

namespace App\Controllers;

use App\Classes\Admin\Form;
use Themes\Regular\Models\RegularModel;
use Themes\Regular\Models\DashboardContentModel;
use Themes\Regular\Models\DashboardModel;
use App\System\Core\Controller;

use function App\app;
use function App\db;
use function App\getPrice;
use function App\is_admin;
use function App\option;
use function App\redirect;
use function App\user;

class Admin extends Controller
{
    
    function __construct()
    {
        if(!is_admin())
            $this->is_current_url = false;

        $this->loadTheme('regular');
    }

    function dashboard()
    {

        $subs = db()->find('order', ['order_status' => 'done'], 'order_amount');
        $total_subs_money = 0;
        if(!empty($subs)) foreach($subs as $sub) {
            $total_subs_money = $total_subs_money+$sub['order_amount'];
        }
        // $subs_count = count($subs);

        // $topups = db()->find('topup', ['topup_status' => 'done'], 'topup_amount');
        // $total_topups_money = 0;
        // if(!empty($topups)) foreach($topups as $topup) {
        //     $total_topups_money = $total_topups_money+$topup['topup_amount'];
        // }
        
        $users_count = count(db()->find('user', [], 'user_id'));
        // $total_links = count(db()->find('link', [], 'link_id'));
        // $total_clicks = count(db()->find('click', [], 'click_id'));

        $data = [
            // 'subs_count' => $subs_count,
            'users_count' => $users_count,
            'total_subs_money' => getPrice($total_subs_money)
            // 'total_topup_money' => getPrice($total_topups_money),
            // 'total_links' => $total_links,
            // 'total_clicks' => $total_clicks
        ];
        $this->model = new DashboardModel('Статистика', new RegularModel('content/admin-stats', $data));
        $this->model->load();
    }
    
    function settings()
    {

        if(isset($_POST['option'])) {
            foreach($_POST['option'] as $key => $option) {
                option($key, $option);
            }
            redirect('admin/settings?true');
        }

        if(isset($_GET['true'])) {
            $message = 'Данные успешно сохранены';
        } else {
            $message = '';
        }
        
        $this->model = new DashboardModel('Настройки сайта', new DashboardContentModel('content/admin-settings', ['inputs' => app()->options, 'message' => $message]));
        $this->model->load();
    }

    function profile()
    {
        $form = new Form([
            'user.first_name',
            'user.last_name',
            'user.user_phone',
            'user.user_email',
            'user.user_pass',
            'user.user_gender'
        ], user()->user_array);

        if(isset($form->clientdata) and !empty($form->clientdata)) {
            if(!$form->error) {
                $user_email = $form->clientdata['user_email'];
                $emailExists = db()->findOne('user', ['user_email' => $user_email]);
                if($user_email !== user()->user_email and !empty($emailExists)) {
                    $form->error = 'email_is_busy_by_another_user';
                }
                $user_phone = $form->clientdata['user_phone'];
                $phoneExists = db()->findOne('user', ['user_phone' => $user_phone]);
                if(intval($user_phone) !== intval(user()->user_phone) and !empty($phoneExists)) {
                    $form->error = 'phone_is_busy_by_another_user';
                }
                if(!$form->error) {
                    db()->update('user', $form->clientdata, user()->user_id);
                    $form->true = true;
                }
            }
        }

        $this->model = new DashboardModel('Настройки профиля', new DashboardContentModel('content/form', ['form' => $form]));
        $this->model->load();
    }
    
    // function inbox()
    // {
    //     $this->model = new DashboardModel('Сообщения', new DashboardContentModel('content/admin-inbox'));
    //     $this->model->load();
    // }
}
