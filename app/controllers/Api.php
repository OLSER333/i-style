<?php

namespace App\Controllers;

use App\Classes\JsonTrait;
use App\System\Core\Controller;

use function App\db;
use function App\is_logged_in;
use function App\user;

class Api extends Controller
{
    use JsonTrait;

    public function __construct()
    {

    }

    public function favorite()
    {
        if(isset($_POST['action'])) {
            $action = $_POST['action'];
            $id = intval($_POST['id']);
            $type = $_POST['type'];
            if(!in_array($type, ['seller', 'service']) or !in_array($action, ['add', 'delete']) or $id === 0) {
                $this->_returnError('invalid_data');
            }
            if(!is_logged_in()) {
                $this->_returnError('login_or_register_to_take_this_action');
            }
            if(user()->user_role !== 'customer') {
                $this->_returnError('login_as_a_user_to_perform_this_action');
            }

            if($type === 'service') {
                $table = 'user_service';
                $id_column = 'user_service_id';
                $status_column = 'user_service_status';
            } else if($type === 'seller') {
                $table = 'user';
                $id_column = 'user_id';
                $status_column = 'user_status';
            }
            $favoriteObject = db()->findOne($table, [
                $id_column => $id,
                $status_column => 'active'
            ]);

            if($type === 'seller') {
                if($favoriteObject['user_role'] !== 'master' and $favoriteObject['user_role'] !== 'salon') {
                    $this->_returnError('element_not_found');
                }
            }

            if(empty($favoriteObject)) {
                $this->_returnError('element_not_found');
            }

            $favoriteReaction = db()->findOne('user_favorite', [
                'user_favorite_type' => $type,
                'object_id' => $id,
                'user_id' => user()->user_id
            ]);

            if($action === 'add') {
                if(!empty($favoriteReaction)) {
                    $this->_returnError('you_have_already_added_this_item_to_your_favorites');  
                }
                db()->insert('user_favorite', [
                    'user_favorite_type' => $type,
                    'object_id' => $id,
                    'user_id' => user()->user_id,
                    'user_favorite_date_add' => time()
                ]);
                $this->_returnStatusMessage(db()->insert_id);
            } else if($action === 'delete') {
                if(empty($favoriteReaction)) {
                    $this->_returnError('element_not_found_in_your_favorites');  
                }
                $favoriteReactionID = $favoriteReaction['user_favorite_id'];
                db()->do("DELETE FROM user_favorite WHERE user_favorite_id = $favoriteReactionID");
            }
            $this->_returnStatusMessage();
        }
        $this->_returnError();

    }
}
