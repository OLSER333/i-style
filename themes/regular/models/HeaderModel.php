<?php

namespace Themes\Regular\Models;

use App\Classes\Database\Value;
use Themes\Regular\Models\RegularModel;

use const App\SITE_NAME;

use function App\app;
use function App\get_user_avatar;
use function App\is_admin;
use function App\is_logged_in;

class HeaderModel extends RegularModel
{
    function __construct(bool $dispay_menu_button = true)
    {

        if(is_logged_in()) {
            
            $new_messages_count = '';

            $messages = [];

            if(app()->user->new_messages_count > 0) {
                $new_messages_count.= '<span class="badge bg-success badge-number">'.app()->user->new_messages_count.'</span>';

                $headerMessages = array_slice(app()->user->new_messages_array, 0, 3);
                foreach($headerMessages as $message) {
                    if(!isset($message['first_name']) or is_null($message['first_name']))
                        $name = 'u'.$message['user_id'];
                    else
                        $name = $message['first_name'].' '.$message['last_name'];

                    $messages[] = new RegularModel('blocks/header-message-item', [
                        'chat_url' => '/inbox/'.$message['chat_id'],
                        'avatar' => get_user_avatar($name, 0, 'user-circle rounded-circle'),
                        'name' => $name,
                        'message' => mb_strimwidth(htmlspecialchars_decode($message['chat_message_text']), 0, 200, '...'),
                        'date' => Value::get('unix', $message['chat_message_date_add'])
                    ]);
                }
            }

            if(is_admin()) {
                $wallet_link = '/admin/order';
                $inbox_link = '/inbox';
            } else {
                $wallet_link = '/wallet';
                $inbox_link = '/inbox';
            }
            
            $controls = new RegularModel('blocks/header-user-controls', [
                'balance' => app()->user->balance_rur,
                'new_messages_count' => $new_messages_count,
                'new_messages_count_number' => app()->user->new_messages_count,
                'wallet_link' => $wallet_link,
                'inbox_link' => $inbox_link,
                'messages' => $messages,
                'full_name' => app()->user->full_name,
                'short_name' => app()->user->short_name,
                'email' => app()->user->user_email,
                'avatar' => get_user_avatar(app()->user->full_name, 0, 'user-circle rounded-circle')
            ]);
        } else {
            $controls = new RegularModel('blocks/header-guest-controls');
        }
        
        $menu_button = '';
        if($dispay_menu_button === true)
            $menu_button.= '<i class="bi bi-list toggle-sidebar-btn hover-opacity"></i>';

        $variables = [
            'site_name' => SITE_NAME,
            'menu_button' => $menu_button,
            'controls' => $controls
        ];
        parent::__construct("blocks/header", $variables);
    }
}
