<?php

namespace App\Controllers;

use App\System\Core\Controller;

use function App\db;
use function App\is_logged_in;
use function App\redirect;
use function App\user;

class Profile extends Controller
{

    function __construct()
    {
        if(!is_logged_in())
            redirect('sign_in');
    }

    function profile_logout()
    {
        setcookie('auth_token', '', time()-3600*24*30, '/');
        db()->update('user_auth', ['user_auth_status' => 'inactive'], user()->user_auth_id);
        redirect('');
    }
}
