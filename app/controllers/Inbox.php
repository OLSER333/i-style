<?php

namespace App\Controllers;

use App\Models\DashboardContentModel;
use App\Models\DashboardModel;
use App\System\Core\Controller;

use function App\db;
use function App\user;

class Inbox extends Controller
{
        
    function main($page_chat_id = null){
        
        $new_messages_array = user()->new_messages_array;

        if(!is_null($page_chat_id) and !is_numeric($page_chat_id))
            return false;

        $current_user_id = user()->user_id;

        $user_chats = db()->select(
            "SELECT
                chat.chat_id,
                chat.chat_status,
                chat.chat_date_add,
                user.user_email,
                user.first_name,
                user.last_name,
                user.user_role
            FROM chat
            LEFT JOIN chat_user
            ON chat.chat_id = chat_user.chat_id
            LEFT JOIN user
            ON chat_user.user_id = user.user_id
            WHERE chat_user.user_id = $current_user_id
            ORDER BY user.first_name ASC
            ;");
        $user_chats_array = [];
        if(!empty($user_chats)) {

            foreach($user_chats as $chat) {
                $chat_id = $chat['chat_id'];
                $chat_messages = db()->select(
                    "SELECT 
                        chat_message.chat_message_id,
                        chat_message.chat_message_text,
                        chat_message.user_id,
                        chat_message.chat_message_date_add
                    FROM chat_message
                    WHERE chat_id = $chat_id
                    ORDER BY chat_message.chat_message_date_add ASC
                ;");
                $chat_users = db()->select(
                    "SELECT user.user_id, user.first_name, user.last_name, user.user_email, user.user_role FROM chat_user
                    LEFT JOIN user
                    ON chat_user.user_id = user.user_id
                    WHERE chat_user.chat_id = $chat_id
                    ;"
                );
    
                $page_data['chat_users_arr'] = [];
                $chat['chat_users_name_arr'] = [];

                foreach($chat_users as $chat_user) {
                    if($chat_user['user_id'] != $current_user_id) {
                        if(is_null($chat_user['first_name']) or $chat_user['first_name'] === '') {
                            $chat_user['full_name'] = 'u'.$chat_user['user_id'];
                        } else {
                            $chat_user['full_name'] = $chat_user['first_name'].' '.$chat_user['last_name'];
                        }
                        $chat['chat_users_name_arr'][] = $chat_user['full_name'];
                        $page_data['chat_users_arr'][] = $chat_user;
                    }
                }
                
                $chat_messages_output = [];
                $new_messages_chat_array = [];
                
                if(is_array($chat_messages)) foreach($chat_messages as $message) {
                    $message_id = $message['chat_message_id'];

                    if(is_array($new_messages_array)) foreach($new_messages_array as $array_message) {
                        $array_message_id = $array_message['chat_message_id'];
                        if($array_message_id == $message_id) {
                            $message['is_new'] = true;
                            $new_messages_chat_array[] = $message_id;
                        }
                    }
                
                    foreach($page_data['chat_users_arr'] as $chat_user) {
                        if($chat_user['user_id'] == $message['user_id'] and $message['user_id'] != $current_user_id) {
                            $message['message_user'] = $chat_user;
                        }
                    }
                    $chat_messages_output[] = $message;
                }
                $chat['new_messages_count'] = count($new_messages_chat_array);
                $chat['messages'] = $chat_messages_output;
                if($page_chat_id === $chat['chat_id']) {
                    $page_data['page_chat_id'] = $chat['chat_id'];
                    $page_data['page_chat_array'] = $chat;
                    foreach($chat['messages'] as $message) {
                        if($message['user_id'] !== $current_user_id)
                            db()->update('chat_message', ['message_viewed' => 1], $message['chat_message_id']);
                    }
                }
                
                $user_chats_array[] = $chat;
                unset($chat);
            }
        } 
        if(isset($page_chat_id) and !$page_data['page_chat_id']) {
            return false;
        }
        $page_data['chats'] = $user_chats_array;
        if(isset($_POST['new_message'])) {
            $message = str_replace("\r\n", "<br>", $_POST['new_message']);
            $message = htmlspecialchars($message);
            if($message != '') {
                $user_chat_id = $page_chat_id;
                db()->insert('chat_message', array(
                    'chat_id' => $user_chat_id,
                    'user_id' => $current_user_id,
                    'chat_message_text' => $message,
                    'message_viewed' => 0,
                    'chat_message_date_add' => time()
                ));
                $message_id = db()->insert_id;

                $user_chat_users = db()->select(
                    "SELECT chat_user.user_id FROM chat_user
                    WHERE chat_user.chat_id = $user_chat_id;"
                );
                if(is_array($user_chat_users))
                    foreach($user_chat_users as $user) {
                        if($user['user_id'] != $current_user_id) {
                            // db()->insert('user_notice', array(
                            //     'user_id' => $user['user_id'],
                            //     'user_notice_code' => 'new_message',
                            //     'user_notice_data' => $message_id,
                            //     'user_notice_date_add' => time()
                            // ));
                        }
                    }
                header('Location: /inbox/'.$user_chat_id);
                exit;
            }
        }
        usort( 
            $page_data['chats'],
            function($a,$b) {
                return -($a["new_messages_count"] - $b["new_messages_count"]);
            }
        );

        $this->model = new DashboardModel('Сообщения', new DashboardContentModel('content/inbox', ['page_data' => $page_data, 'current_user_id' => $current_user_id]));
        $this->model->load();
        
    }
}