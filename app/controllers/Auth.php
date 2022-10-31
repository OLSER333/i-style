<?php

namespace App\Controllers;

use App\Classes\User;
use App\System\Core\Controller;
use Themes\Purple\Models\PageModel;
use Themes\Purple\Models\PurpleModel;

use function App\check_email;
use function App\db;
use function App\get_text;
use function App\is_logged_in;
use function App\redirect;
use function App\user;

use const App\MAX_BAD_LOGIN;
use const App\MAX_PASS_LENGTH;
use const App\MIN_PASS_LENGTH;

class Auth extends Controller
{
    
    function __construct()
    {
        if(is_logged_in()) {
            redirect('dashboard');
        }
        $this->loadTheme('purple');
    }

    private function _getUserByEmailOrPhone(string $emailOrPhone)
    {
        if(check_email($emailOrPhone)) {
            $user = db()->findOne('user', ['user_email' => $emailOrPhone]);
        } else if(intval($emailOrPhone) > 100) {
            $user = db()->findOne('user', ['user_phone' => $emailOrPhone]);
        } else {
            return false;
        }
        if(empty($user)) {
            return false;
        }
        return $user;
    }

    function login()
    {
        $data = [
            'user_email' => '',
            'user_pass' => '',
            'error' => ''
        ];
        $error = '';
        if(isset($_COOKIE['bad_login']) and intval($_COOKIE['bad_login']) >= MAX_BAD_LOGIN){
            $data['error'] = get_text('failed_login_attempts_error');
        }
        if(isset($_POST['user_email']) and $data['error'] === '') {
            $email = $_POST['user_email'];
            $pass = $_POST['user_pass'];
            $user = $this->_getUserByEmailOrPhone($email);
            if($user === false) {
                $error = get_text('incorrect_login');
            } else {
                if($user['user_pass'] !== md5($pass)) {
                    $error = get_text('incorrect_login_or_password');
                    if(!isset($_COOKIE['bad_login'])) {
                        setcookie('bad_login', 1, time()+3600*24, '/');
                    } else {
                        setcookie('bad_login', intval($_COOKIE['bad_login'])+1, time()+3600*1, '/');
                    }
                } else {
                    user()->auth($user);
                }
            }

            $data = [
                'user_email' => $email,
                'user_pass' => $pass,
                'error' => $error
            ];
        }
        if(isset($_COOKIE['reset_pwd'])) {
            $data['message'] = get_text('send_new_password_to_email');
            setcookie('reset_pwd', '', time()-3600);
        } else {
            $data['message'] = '';
        }
        $data['enable_social'] = true;
        $this->_loadModel('forms/login', get_text('login'), $data);
    }
    
    function sign_up()
    {
        $data = [
            'first_name' => '',
            'last_name' => '',
            'user_phone' => '',
            'user_email' => '',
            'user_pass' => '',
            'error' => '',
            'agree_checked' => ''
        ];
        if(isset($_POST['user_email'])) {
            $email = $_POST['user_email'];
            $pass = $_POST['user_pass'];
            $first_name = trim(strip_tags($_POST['first_name']));
            $last_name = trim(strip_tags($_POST['last_name']));
            $user_phone = intval($_POST['user_phone']);
            if(check_email($email)) {
                $user = db()->findOne('user', ['user_email' => $email]);
                if(!empty($user)) {
                    $error = 'account_already_exists';
                } else if(strlen($pass) < MIN_PASS_LENGTH or strlen($pass) > MAX_PASS_LENGTH) {
                    $error = 'incorrect_password_length';
                } else {
                    if($user_phone < 10000) {
                        $error = get_text('incorrect_phone'); 
                    } else {
                        $userByPhone = db()->findOne('user', ['user_phone' => $user_phone]);
                        if(!empty($userByPhone)) {
                            $error = 'account_already_exists';
                        } else if($first_name === '' or $last_name === '') {
                            $error = get_text('incorrect_name'); 
                        } else {
                            user()->create($email, $pass, $first_name, $last_name, $user_phone);
                        }
                    }
                }
            } else {
                $error = 'incorrect_email';
            }
            
            $data = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'user_phone' => $user_phone,
                'user_email' => $email,
                'user_pass' => $pass,
                'error' => $error,
                'agree_checked' => 'checked'
            ];
        }
        $data['enable_social'] = true;
        $this->_loadModel('forms/registration', get_text('account_registration'), $data);
    }

    function business()
    {
        $data['enable_social'] = true;
        $this->_loadModel('forms/business', get_text('business_registration'), $data);
    }
      
    function reset()
    {
        $data = [
            'user_email' => '',
            'error' => ''
        ];
        if(isset($_POST['user_email'])) {
            $email = $_POST['user_email'];
            if(check_email($email)) {
                $user = db()->findOne('user', ['user_email' => $email]);
                if(empty($user) or $user['user_role'] === 'admin') {
                    $error = 'account_does_not_exists';
                } else {
                    User::reset($user);
                }
            } else {
                $error = 'incorrect_email';
            }
            $data = [
                'user_email' => $email,
                'error' => $error
            ];
        }
        $this->_loadModel('forms/recovery', get_text('reset_password'), $data);
    }
      
    function auth_confirm()
    {
        if(user()->user_auth_status !== 'wait_confirm_code') {
            redirect('sign_in');
        }
        $data = [
            'email' => user()->user_email,
            'error' => '',
            'confirm_code' => ''
        ];
        if(isset($_POST['confirm_code'])) {
            $code = intval($_POST['confirm_code']);
            if($code === intval(user()->confirm_code)) {
                db()->update('user_auth', [
                    'user_auth_status' => 'active',
                    'user_auth_expire_date' => time()+3600*24*30
                ], user()->user_auth_id);
                redirect('dashboard');
            } else {
                $data['error'] = 'incorrect_code';
            }
            $data['confirm_code'] = $code;
        }
        $this->_loadModel('forms/confirm', get_text('login_confirm'), $data);
    }

    private function _loadModel(string $viewName, string $title, array $variables = [])
    {
        $this->model = new PageModel($title, new PurpleModel($viewName, $variables), display_title: false);
        $this->model->load();
    }
}
