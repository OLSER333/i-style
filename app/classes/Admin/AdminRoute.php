<?php

namespace App\Classes\Admin;

use App\Classes\Database\Value;
use Themes\Regular\Models\DashboardContentModel;
use Themes\Regular\Models\DashboardModel;

use const App\ROOT\ABSPATH;
use const App\TABLE_DATETIME_FORMAT;

use function App\app;
use function App\db;
use function App\get_text;
use function App\is_admin;

class AdminRoute
{
    public function __construct(string $table_name, array $control, string $main_control_key = '', $status_key = '', $name_key = '', callable $tabledata_handler = null, public string|null $slug = null, public array|null $where = null, public array|null $create_default_columns = null)
    {

        if(!is_admin())
            return;

        $themeConfig = ABSPATH."/themes/regular/config.php";
        include_once $themeConfig;

        $database = app()->tables;
        if(!isset($database->$table_name))
            die("Database error. Table <strong>$table_name</strong> not exist.");


        if($this->slug === null) {
            $this->slug = $table_name;
        }

        
        if($this->where !== null) {
            $this->whereAnd = ' AND '.implode(' AND ', $this->where);
            $this->whereWhere = ' WHERE '.implode(' AND ', $this->where);
        } else {
            $this->whereAnd = '';
            $this->whereWhere = '';
        }

        $this->table_name = $table_name;

        if($tabledata_handler !== null) {
            $this->tabledata_handler = $tabledata_handler;
        }

        if($main_control_key == '')
            $this->control_key = $table_name.'_id';
        else 
            $this->control_key = $main_control_key;

        if($status_key == '')
            $this->status_key = $table_name.'_status';
        else 
            $this->status_key = $status_key;

        if($name_key == '')
            $this->name_key = $table_name.'_name';
        else 
            $this->name_key = $name_key;

        $this->tabledata['table_control_key'] = $this->control_key;
        
        foreach($control as $control_key => $control_array) {
            $control_columns = $control_key.'_columns';
            if($control_key == 'default' and !is_array($control_array)) {
                $newcolumns = [];
                foreach($database->$table_name as $key => $column) {
                    if($key == '_i')
                        continue;
                    $newcolumns[] = $key;
                }
                $this->$control_columns = $newcolumns;
            } else if(is_array($control_array)) {
                $this->$control_columns = $control_array;
            } else if(is_array($this->default_columns)) {
                $this->$control_columns = $this->default_columns;
            }
 
            $control_str_prop_name = $control_key.'_tablecolumn_arr';
            foreach($this->$control_columns as $column) {
                $this->$control_str_prop_name[] = $table_name.'.'.$column;
            }

            if($control_key == 'create')
                $this->tabledata['table_add_button'] = true;
            else if($control_key == 'trash')
                $this->tabledata['table_trash_button'] = true;

            $control_str_prop_name = $control_columns.'_str';
            $this->$control_str_prop_name = implode(', ', $this->$control_columns);

            if($control_key == 'table'
                or $control_key == 'create'
                    or $control_key == 'edit'
                        or $control_key == 'delete'
                            or $control_key == 'view'
                                or $control_key == 'trash')
                $this->$control_key();
        }
        $control_key_prop = $this->control_key;
        $control_prop_type = $database->$table_name->$control_key_prop->value->type;
        if($control_prop_type == 'int' or $control_prop_type == 'float' or $control_prop_type == 'bool')
            $this->where_clause = "WHERE $control_key_prop = {value} {$this->whereAnd}";
        else
            $this->where_clause = "WHERE $control_key_prop = '{value}' {$this->whereAnd}";
        
        if(isset($control['view'])) {
            $this->tabledata['table_control'][] = 'info';
            $this->trash_tabledata['table_control'][] = 'info';
        }
        if(isset($control['edit'])) {
            $this->tabledata['table_control'][] = 'edit';
            $this->trash_tabledata['table_control'][] = 'edit';
        }
        if(isset($control['delete'])) {
            $this->tabledata['table_control'][] = 'delete';
        }
    }

    public function table()
    {
        app()->url("/admin/{$this->slug}", function(){
            
            $database = app()->tables;
            $db = db();

            $table_name = $this->table_name;
            $data = $this->tabledata;
            $data['table_control_key'] = $this->control_key;

            $table_columns_str = $this->table_columns_str;
            $status_key = $this->status_key;

            if($data['table_trash_button']) {
                $rows = $db->select("SELECT $table_columns_str FROM `$table_name` WHERE $status_key != 'deleted' {$this->whereAnd};");
                $trash = $db->select("SELECT * FROM `$table_name` WHERE $status_key = 'deleted' {$this->whereAnd};");
                if(is_array($trash))
                    $data['trash_count'] = count($trash);
                else
                    $data['trash_count'] = 0;
            } else {
                $rows = $db->select("SELECT $table_columns_str FROM `$table_name` {$this->whereWhere};");
            }
            
            if(is_array($rows)) foreach($rows as $row) {
                $rowdata = array();
                foreach($row as $column_name => $value) {
                    $value_object = $database->$table_name->$column_name->value;
                    if($value_object->key == 'pass')
                        $rowdata[$column_name] = '*****';
                    else if($value_object->key == 'unix') 
                        $rowdata[$column_name] = date(TABLE_DATETIME_FORMAT, $value);
                    else
                        $rowdata[$column_name] = Value::get($value_object->key, $value, true, false);

                }
                $data['table_data'][] = $rowdata;
                unset($rowdata);
            }
            if(isset($this->tabledata_handler)) {
                $func_name = $this->tabledata_handler;
                $data['table_data'] = $func_name($data['table_data']);
            }

            $data['table_name'] = $table_name;
            $data['table_prepend_url'] = '/admin/'.$this->slug.'/';

            $model = new DashboardModel(get_text($this->slug), new DashboardContentModel('content/table', ['data' => $data]));
            $model->load();

        });
    }

    public function edit()
    {
        app()->url("/admin/{$this->slug}/edit/{id}", function($item_id){

            if(!is_numeric($item_id))
                return false;

            $table_name = $this->table_name;
            $db = db();

            if(isset($_GET['return']) and $_GET['return'] == 'true') {
                header('Location: /admin/'.$this->slug);
                exit;
            }

            $edit_columns_str = $this->edit_columns_str;
            $where_query = str_replace('{value}', $item_id, $this->where_clause);
            $data['edit_data'] = $db->find_one("SELECT $edit_columns_str FROM `$table_name` $where_query;");
            
            if(empty($data['edit_data']))
                return false;
            
            $columns = $this->edit_tablecolumn_arr;
            $form = new Form($columns, $data['edit_data']);
            if(isset($form->clientdata) and !$form->error) {
                $db->update($table_name, $form->clientdata, $item_id);
                $form->true = true;
            }

            $model = new DashboardModel(get_text($this->slug).' - редактирование', new DashboardContentModel('content/form', ['form' => $form]), [], [
                [
                    'title' => 'Главная',
                    'link' => '/',
                    'active' => false
                ],
                [
                    'title' => 'Админ',
                    'link' => '/admin',
                    'active' => false
                ],
                [
                    'title' => get_text($this->slug),
                    'link' => "/admin/{$this->slug}",
                    'active' => false
                ],
                [
                    'title' => "ID$item_id",
                    'link' => "/admin/{$this->slug}/$item_id",
                    'active' => true
                ],
                [
                    'title' => 'Редактирование',
                    'link' => "/admin/{$this->slug}/edit/$item_id",
                    'active' => true
                ]
            ]);
            $model->load();
        });
    }

    public function create()
    {
        app()->url("/admin/{$this->slug}/create", function(){
            $db = db();
            $table_name = $this->table_name;
            if(isset($_GET['return']) and $_GET['return'] == 'true') {
                header('Location: /admin/'.$this->slug);
                exit;
            }
          
            $columns = $this->create_tablecolumn_arr;
            $form = new Form($columns, array());
            if(isset($form->clientdata) and !empty($form->clientdata) and !$form->error) {
                if($this->create_default_columns !== null) {
                    $form->clientdata = array_merge($form->clientdata, $this->create_default_columns);
                }
                $db->insert($table_name, $form->clientdata);
                if(!$db->insert_id) {
                    $form->error = 'invalid_data';
                } else {
                    $form->true = true;
                    header('Location: /admin/'.$this->slug);
                    exit;
                }
            }
            // $wrapper = $form->wrapper; 
            $model = new DashboardModel(get_text($this->slug).' - создание', new DashboardContentModel('content/form', ['form' => $form]), [], [
                [
                    'title' => 'Главная',
                    'link' => '/',
                    'active' => false
                ],
                [
                    'title' => 'Админ',
                    'link' => '/admin',
                    'active' => false
                ],
                [
                    'title' => get_text($this->slug),
                    'link' => "/admin/{$this->slug}",
                    'active' => false
                ],
                [
                    'title' => 'Создание',
                    'link' => "/admin/{$this->slug}/create",
                    'active' => true
                ]
            ]);
            $model->load();
        });
    }

    public function view()
    {
        app()->url("/admin/{$this->slug}/{id}", function($item_id){

            if(!is_numeric($item_id))
                return false;
       
            $database = app()->tables;
            $db = db();
            $table_name = $this->table_name;

            $title = get_text($this->slug).": ID$item_id";
           
            $view_columns_str = $this->view_columns_str;
            
            $where_query = str_replace('{value}', $item_id, $this->where_clause);
            $data = $db->find_one("SELECT $view_columns_str FROM `$table_name` $where_query;");

            if(empty($data))
                return false;

            $view_data['view_data'] = [];
            foreach($data as $column_name => $value) {
                $value_object = $database->$table_name->$column_name->value;
                if($value_object->key == 'pass')
                    $view_data['view_data'][$column_name] = '********';
                else
                    $view_data['view_data'][$column_name] = Value::get($value_object->key, $value, true, false);
                
            }
            
            $model = new DashboardModel($title, new DashboardContentModel('content/view', ['data' => $view_data['view_data']]), [], [
                [
                    'title' => 'Главная',
                    'link' => '/',
                    'active' => false
                ],
                [
                    'title' => 'Админ',
                    'link' => '/admin',
                    'active' => false
                ],
                [
                    'title' => get_text($this->slug),
                    'link' => "/admin/{$this->slug}",
                    'active' => false
                ],
                [
                    'title' => 'Просмотр записи',
                    'link' => "/admin/{$this->slug}/$item_id",
                    'active' => true
                ]
            ]);
            $model->load();
        });
    }

    public function delete()
    {
        app()->url("/admin/{$this->slug}/delete/{id}", function($item_id){
            
            if(!is_numeric($item_id))
                return false;
       
            $db = db();
            $database = app()->tables;
            $table_name = $this->table_name;

            if($table_name == 'user') {
                if($item_id == app()->user->user_id) {
                    echo 'Can\' delete current user. <a href="/admin/'.$this->slug.'/"> <<< Return </a>';
                    exit;
                } 
            }

            $status_key = $this->status_key;
            $where_query = str_replace('{value}', $item_id, $this->where_clause);
            $view_columns_str = $this->view_columns_str;

            $item = $db->find_one("SELECT $view_columns_str FROM `$table_name` $where_query;");
            
            if(empty($item))
                return false;

            $view_data['view_data'] = [];
            foreach($item as $column_name => $value) {
                $value_object = $database->$table_name->$column_name->value;
                if($value_object->key == 'pass')
                    $item[$column_name] = '********';
                else
                    $item[$column_name] = Value::get($value_object->key, $value, true, false);
                
            }
       
            if($item[$status_key] == 'deleted')
                $message = 'confirm_full_delete';
            else if(!isset($this->trash_columns))
                $message = 'confirm_full_delete';
            else
                $message = 'confirm_delete';

            if(isset($_GET['conf']) and $_GET['conf'] == 'true' and isset($item)) {
         
                if(isset($this->trash_columns)) {
                    if($item[$status_key] == 'deleted')
                        $db->do("DELETE FROM `$table_name` $where_query;");
                    else
                        $db->update($table_name, array($status_key => 'deleted'), $item_id);
                } else {
                    $db->do("DELETE FROM `$table_name` $where_query;");
                }
                header("Location: /admin/{$this->slug}");
                exit;
            } else if(!$item) {
                $message = 'invalid_data';
            } else {
                $data = $item;
            }
             
            $model = new DashboardModel('Подтвердите удаление', new DashboardContentModel('content/message', ['data' => $data, 'message' => get_text($message)]), [], [
                [
                    'title' => 'Главная',
                    'link' => '/',
                    'active' => false
                ],
                [
                    'title' => 'Админ',
                    'link' => '/admin',
                    'active' => false
                ],
                [
                    'title' => get_text($this->slug),
                    'link' => "/admin/{$this->slug}",
                    'active' => false
                ],
                [
                    'title' => "ID$item_id",
                    'link' => "/admin/{$this->slug}/$item_id",
                    'active' => true
                ],
                [
                    'title' => 'Удаление записи',
                    'link' => "/admin/{$this->slug}/$item_id/delete",
                    'active' => true
                ]
            ]);
            $model->load();

        });
    }
    

    public function trash()
    {
        $table_name = $this->slug;
        app()->url("/admin/$table_name/trash", function(){
            $database = app()->tables;
            $db = db();
            $table_name = $this->table_name;

            $title = get_text('admin').' - '.get_text($this->slug);
            
            $table_columns_str = $this->table_columns_str;
            if($table_columns_str == '') {
                $table_columns_str = $this->trash_columns_str;
            }
            $status_key = $this->status_key;
            $data = $db->select("SELECT $table_columns_str FROM `$table_name` WHERE $status_key = 'deleted' {$this->whereAnd};");
            
            if(is_array($data)) foreach($data as $row) {
                $rowdata = array();
                foreach($row as $column_name => $value) {
                    $value_object = $database->$table_name->$column_name->value;
                    if($value_object->key == 'pass')
                        $rowdata[$column_name] = '*****';
                    else
                        $rowdata[$column_name] = Value::get($value_object->key, $value, true, false);
                }
                $data['table_data'][] = $rowdata;
                unset($rowdata);
            }
            
            $data['table_control_key'] = $this->control_key;


            $data['table_control'] = $this->trash_tabledata['table_control'];
            $data['table_name'] = $table_name;
            $data['table_prepend_url'] = '/admin/'.$this->slug.'/';

            $model = new DashboardModel($title, new DashboardContentModel('content/table', ['data' => $data]), [], [
                [
                    'title' => 'Главная',
                    'link' => '/',
                    'active' => false
                ],
                [
                    'title' => 'Админ',
                    'link' => '/admin',
                    'active' => false
                ],
                [
                    'title' => get_text($this->slug),
                    'link' => "/admin/{$this->slug}",
                    'active' => false
                ],
                [
                    'title' => "Корзина",
                    'link' => "/admin/{$this->slug}/trash",
                    'active' => true
                ]
            ]);
            $model->load();

        });

        app()->url("/admin/{$this->slug}/trash/edit/{item_id}", function($item_id){
            header("Location: /admin/{$this->slug}/edit/$item_id");
            exit;
        });

        app()->url("/admin/{$this->slug}/trash/{item_id}", function($item_id){
            header("Location: /admin/{$this->slug}/$item_id");
            exit;
        });

        
        app()->url("/admin/{$this->slug}/trash/delete/{item_id}", function($item_id){
            header("Location: /admin/{$this->slug}/delete/$item_id");
            exit;
        });
    }
}