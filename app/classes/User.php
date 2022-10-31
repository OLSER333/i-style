<?php

namespace App\Classes;

use const App\SITE_NAME;

use function App\app;
use function App\Classes\Database\set_object_properties;
use function App\db;
use function App\generatePassword;
use function App\getPrice;
use function App\isValidMd5;
use function App\redirect;
use function App\sendMail;

class User
{

    public array $favorites = [];

    function __construct()
    {
        if(isset($_COOKIE['auth_token'])) {
            $auth = $this->checkAuth();
            if(is_array($auth)) {
                set_object_properties($this, $auth);
                if($this->user_auth_status !== 'wait_confirm_code') {
                    setcookie('auth_token', $_COOKIE['auth_token'], time()+3600*24*30, '/');
                }
                $this->balance_rur = getPrice(floatval($this->user_balance));
                if(!$this->first_name) {
                    $this->first_name = 'u'.$this->user_id;
                }
                if($this->last_name) {
                    $this->short_name = trim(mb_substr(strval($this->first_name), 0, 1).'. '.$this->last_name);
                } else {
                    $this->short_name = $this->first_name;
                }
                $this->full_name = trim($this->first_name.' '.$this->last_name);

                if(isset($this->subscription_expire) and !is_null($this->subscription_expire)) {
                    
                    if($this->subscription_expire > time()) {
                        $this->subscription = 'Активна до '.date('d.m.Y', $this->subscription_expire);
                        $this->subscription_active = true;
                    } else {
                        $this->subscription = 'Истекла '.date('d.m.Y', $this->subscription_expire);
                        $this->subscription_active = false;
                    }
                } else {
                    $this->subscription = 'Отсутствует';
                    $this->subscription_active = false;
                }

                $this->setMessages();
                $this->setFavorites();

                // $this->new_notice_count = 4;
                $this->new_messages_count = count($this->new_messages_array);

                // dd($this->new_messages_array);
            }
        }
        if(!isset($this->user_id)) {
            $this->user_role = 'guest';
            $this->user_auth_status = 'guest';
        }
    }

    function checkAuth()
    {
        $token = $_COOKIE['auth_token'];
        if(!isValidMd5($token)) {
            return false;
        }
        $currTime = time();
        $auth = db()->find_one("SELECT * FROM `user_auth` LEFT JOIN `user` ON `user_auth`.`user_id` = `user`.`user_id` WHERE `user_auth`.`user_auth_token` = '$token' AND `user_auth`.`user_auth_expire_date` > $currTime ORDER BY user_auth_date_add DESC");
        if(empty($auth) or $auth['user_auth_status'] === 'inactive' or $auth['user_status'] !== 'active') {
            return false;
        }
        $this->user_array = $auth;
        return $auth;
    }

    function auth(array $user, bool $firstAuth = false)
    {
        set_object_properties($this, $user);
        if($this->confirm_login == 1) {
            $auth_status = 'wait_confirm_code';
            $auth_expire_date = time()+3600*2;
            $confirm_code = mt_rand(100000000000, 999999999999);
            $redirect = 'auth/confirm';
            sendMail($this->user_email, SITE_NAME.' - Код подтверждения', "Ваш код подтверждения: <strong>$confirm_code</strong><br>Код действителен в течении 2 часов.");
        } else {
            $auth_status = 'active';
            $auth_expire_date = time()+3600*24*30;
            $confirm_code = 0;
            if($firstAuth === true) {
                $redirect = 'profile/settings';
            } else {
                $redirect = 'dashboard';
            }
        }
        $token = md5($this->user_id.'-'.time());
        setcookie('auth_token', $token, $auth_expire_date, '/');
        db()->insert('user_auth', [
            'user_auth_token' => $token,
            'user_auth_status' => $auth_status,
            'user_auth_expire_date' => $auth_expire_date,
            'user_id' => $this->user_id, 
            'confirm_code' => $confirm_code,
            'user_auth_date_add' => time()
        ]);
        redirect($redirect);
    }

    function create(string $email, string $pass, string $first_name, string $last_name, int $user_phone, $user_role = 'customer')
    {
        db()->insert('user', [
            'user_email' => $email,
            'user_pass' => md5($pass),
            'user_status' => 'active',
            'first_name' => $first_name,
            'last_name' => $last_name,
            'user_phone' => $user_phone,
            'user_role' => $user_role,
            'user_balance' => 0.00,
            'confirm_login' => intval(app()->options['confirm_login']),
            'user_date_add' => time()
        ]);

        $user_id = db()->insert_id;
        // db()->update('user', ['first_name' => 'user '.$user_id], $user_id);
        
        // db()->insert('chat', array(
        //     'chat_status' => 'active',
        //     'chat_date_add' => time()
        // ));
        // $user_chat_id = db()->insert_id;
        
        // db()->insert('chat_user', array(
        //     'chat_id' => $user_chat_id,
        //     'user_id' => $user_id,
        //     'chat_user_date_add' => time()
        // ));
        // db()->insert('chat_user', array(
        //     'chat_id' => $user_chat_id,
        //     'user_id' => app()->options['default_support_user'],
        //     'chat_user_date_add' => time()
        // ));

        $user = db()->findOne('user', ['user_id' => $user_id]);
        if(empty($user) or !$user) {
            // dd(db(), [
            //     'user_email' => $email,
            //     'user_pass' => md5($pass),
            //     'user_status' => 'active',
            //     'first_name' => $first_name,
            //     'last_name' => $last_name,
            //     'user_phone' => $user_phone,
            //     'user_role' => $user_role,
            //     'user_balance' => 0.00,
            //     'confirm_login' => intval(app()->options['confirm_login']),
            //     'user_date_add' => time()
            // ]);
            die('sigup error');
        }
        $this->auth($user, true);
    }

    function setMessages()
    {
        $uid = $this->user_id;
        $chats = db()->find('chat_user', ['user_id' => $uid]);
        $this->new_messages_array = [];
        foreach($chats as $chat) {
            $chat_id = $chat['chat_id'];
            $newMessages = db()->select("SELECT chat_message.chat_message_id, chat_message.chat_id, chat_message.chat_message_text, chat_message.chat_message_date_add, user.first_name, user.last_name, user.user_id FROM chat_message LEFT JOIN `user` ON chat_message.user_id = `user`.user_id WHERE message_viewed = 0 AND chat_message.`user_id` != $uid AND chat_message.chat_id = $chat_id ORDER BY chat_message.chat_message_date_add DESC");
            $this->new_messages_array = array_merge($this->new_messages_array, $newMessages);
        }
        // dd($this->new_messages_array);
    }
    
    function setFavorites()
    {
        if($this->user_role !== 'customer') {
            return;
        }
        $uid = $this->user_id;
        $this->favorites = db()->find('user_favorite', ['user_id' => $uid], '*', 'user_favorite_date_add', true);
    }

    static function reset(array $user)
    {
        $newPass = generatePassword(8);
        db()->update('user', [
            'user_pass' => md5($newPass)
        ], $user['user_id']);
        sendMail($user['user_email'], SITE_NAME.' - Восстановление доступа', "Ваш новый пароль: <strong>$newPass</strong><br>После входа в аккаунт настоятельно рекомендуем сменить данный пароль.");
        setcookie('reset_pwd', '1', time()+3600);
        redirect('login');
    }
}
