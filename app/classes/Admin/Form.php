<?php

namespace App\Classes\Admin;

use App\Classes\Database\Value;

use const App\MAX_PASS_LENGTH;
use const App\MIN_PASS_LENGTH;
use const App\ROOT\ABSPATH;

use function App\app;
use function App\check_email;
use function App\get_slug;
use function App\get_text;
use function App\user;

class Form
{
    public function __construct(array $elements, array $formdata = array(),
        array $args = array(
            'method' => 'POST',
            'action' => '',
            'wrapper' => 'content',
            'buttons' => ['cancel', 'save'],
            'css' => [
                'form' => 'default-form',
                'input' => 'form-control',
                'select' => 'form-select',
                'textarea' => 'form-control',
                'checkbox_p' => 'checbox-p',
                'checkbox' => 'form-check-input',
                'radio_p' => 'checbox-p',
                'radio' => 'form-check-input',
                'error' => 'text-red',
                'save_button' => 'btn btn-primary',
                'cancel_button' => 'btn btn-secondary',
                'label' => 'form-label',
                'saved-text' => 'text-green'
            ]
        ), public string $save_button_text = 'Сохранить'
    )
    {
        $database = app()->tables;
        $values = app()->values;

        $this->css = $args['css'];
        $this->method = $args['method'];
        $this->buttons = $args['buttons'];
        $this->action = $args['action'];
        $this->wrapper = $args['wrapper'];
        $this->formdata = $formdata;
        if(isset($_POST['formname']))
            $oldformname = $_POST['formname'];
        else
            $oldformname = '';
        if($oldformname != '') {
            $this->formname = $_POST['formname'];
        } else {
            $this->formname = md5(mt_rand(100000, 999999));
        }
        foreach($elements as $element) {
            if(is_string($element)) {
                $element_arr = explode('.', $element);
                $table_name = $element_arr[0];
                $column_name = $element_arr[1];
                $element_value = $database->$table_name->$column_name->value;
                if($element_value == '1')
                    $element_value = $values->id;
                if($element_value) {
                    if(isset($formdata[$column_name]))
                        $col = $formdata[$column_name];
                    else
                        $col = '';
                    $this->elements[$column_name] = new FormInput($table_name, $column_name, $col);
                }
            } else {
                $column_name = $element->column_name;
                $this->elements[$column_name] = $element;
            }
            if($this->elements[$column_name]->type === 'file') {
                $this->miltipart = true;
            }
        }
        $this->data_check();
    }

    public function callback($callback)
    {
        $this->callback = $callback;
    }

    public function addHTML($input_name, $html, $place = 'after') {
        switch ($place) {
            case 'after':
                $this->elements[$input_name]->after_html = $html;
                break;

            case 'before':
                $this->elements[$input_name]->before_html = $html;
                break;
        }
    }

    public function data_check()
    {
        if(isset($_POST['formname']) and $_POST['formname'] == $this->formname) {
            
            $clientdata = array();
            foreach($this->elements as $column_name => $form_element) {
                if($_POST[$column_name] !== '') {
                    if(isset($form_element->value->input) and $form_element->value->input === 'file' and isset($_FILES[$column_name])) {
                        if(empty($_FILES[$column_name]['tmp_name'])) {
                            // $this->formdata[$column_name];
                            continue;
                        }
                        $file = $_FILES[$column_name];
                        $info = new \SplFileInfo($file['name']);
                        $ext = $info->getExtension();
                        $basename = $info->getBasename('.'.$ext);
                        $name = get_slug($basename).'.'.$ext;
                        $tpmName = $file['tmp_name'];
                        $uid = user()->user_id;
                        $dir = "/assets/uploads/$uid";
                        \mkdir(ABSPATH.$dir, 0777, true);
                        $newPath = "$dir/$name";
                        $newPathBase = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $newPath);
                        // if(file_exists(ABSPATH.$newPath)) {
                        //     $newPath = "/assets/uploads/$uid/".mt_rand(1000, 9999)."$name";
                        // }
                        if(move_uploaded_file($tpmName, ABSPATH.$newPathBase) === false) {
                            $this->error = 'invalid_data';
                            $this->errors[$column_name] = 'invalid_data';
                            $this->error_columns[] = get_text($column_name);
                        } else {
                            $clientdata[$column_name] = $newPath;
                        }
                    } else if($form_element->value->key == 'unix') {
                        $value = strtotime($_POST[$column_name]);
                        $clientdata[$column_name] = $value;
                    } else if ($form_element->value->key == 'pass') {
                        if($_POST[$column_name] != '') {
                            if(strlen($_POST[$column_name]) > MAX_PASS_LENGTH or strlen($_POST[$column_name]) < MIN_PASS_LENGTH) {
                                $this->error = 'incorrect_pass';
                            } else {
                                $value = md5($_POST[$column_name]);
                            }
                            $clientdata[$column_name] = $value;
                        } 
                    } else if ($form_element->value->key == 'email') {
                        if($_POST[$column_name] != '')
                            if(!check_email($_POST[$column_name])) {
                                $this->error = 'incorrect_email';
                            }
                        $value = $_POST[$column_name];
                        if(!$_POST[$column_name])
                            $clientdata[$column_name] = ' ';
                        else
                            $clientdata[$column_name] = $value;




                            
                    } else if ($form_element->value->key == 'content') {
                        $value = $_POST[$column_name];
                        if(!$_POST[$column_name])
                            $clientdata[$column_name] = '';
                        else
                            $clientdata[$column_name] = htmlspecialchars($value);





                    } else {
                        $value = Value::check($form_element->value->key, $_POST[$column_name]);
                        if($_POST[$column_name] !== '' and $value === false) {
                            $this->error = 'invalid_data';
                            $this->errors[$column_name] = 'invalid_data';
                            $this->error_columns[] = get_text($column_name);
                        }
                        if($value !== false)
                            $clientdata[$column_name] = $value;
                        else if($form_element->value->key == 'bool' and !$value)
                            $clientdata[$column_name] = 0;
                        else
                            $clientdata[$column_name] = $_POST[$column_name];
                    }
                }
            }
            $this->clientdata = $clientdata;
            $this->formdata = array_merge($this->formdata, $clientdata);
            if(isset($this->callback)) {
                $callback = $this->callback;
                $callback($clientdata);
            }
        }
    }

    public function print()
    {
        // style="min-width: 100%;" 

        if(isset($this->miltipart) and $this->miltipart === true) {
            $multipart = 'enctype="multipart/form-data"';
        } else {
            $multipart = '';
        }

        $tables = app()->tables;
        $html = '<form '.$multipart.' class="'.$this->css['form'].'" action="'.$this->action.'" method="'.$this->method.'">';
        if(isset($this->true)) {
            $html.= '<p class="mt10 '.$this->css['saved-text'].'">'.get_text('saved').'</p>';
        }
        if(isset($this->error)) {
            if(!empty($this->error_columns)) {
                $cols = ': '.implode(', ', $this->error_columns);
            } else {
                $cols = '';
            }
            $html.= '<p class="mt10 '.$this->css['error'].'">'.get_text($this->error).$cols.'</p>';
        }
        foreach($this->elements as $key => $element) {
            if(isset($element->before_html)) {
                $html.= $element->before_html;
            }
            if(isset($element->value->mask)) {
                $maskClass = $element->value->mask;
            } else {
                $maskClass = '';
            }

            if(isset($element->value->length)) {
                $maxLen = $element->value->length;
                $minLen = $element->value->length;
            } else {
                if(isset($element->value->min_length)) {
                    $minLen = $element->value->min_length;
                } else {
                    $minLen = '';
                }
                if(isset($element->value->max_length)) {
                    $maxLen = $element->value->max_length;
                }  else {
                    $maxLen = '';
                }
            }

            $tb = $element->table_name;
            if(isset($tables->$tb->$key->sql['not_null'])) {
                $required = 'required';
                $optional = ' *';
            } else {
                $required = '';
                $optional = '';
            }
            if($element->type != 'checkbox')
                $html.= '<label class="'.$this->css['label'].'"><p>'.get_text($key).$optional.'</p>';
            else
                $html.= '<label class="'.$this->css['label'].'">';
            switch ($element->type) {
                case 'select':
                    $html.= '<select '.$required.' name="'.$key.'" class="'.$this->css['select'].'">';
                    $select_data = $element->data;
                    foreach($select_data as $option_val => $item) {
                        $selected = '';
                        if($this->formdata[$key] == $option_val)
                            $selected.= "selected='selected'";
                        $html.= "<option $selected value='".$option_val."'>".$item."</option>";
                        // $html.= "<option $selected value='".$option_val."'>".get_text($item)."</option>";
                    }
                    $html.= '</select>';
                    break;
                
                case 'checkbox':
                    $checked = '';
                    if($this->formdata[$key] == 1)
                        $checked.= 'checked';
                    $html.= '<input type="hidden" name="'.$key.'" value="0">';
                    $html.= '<p class="'.$this->css['checkbox_p'].'"><input '.$checked.' '.$required.'  name="'.$key.'" class="'.$this->css['checkbox'].'" value="1" type="checkbox">'.get_text($key).$optional.'</p>';
                    break;

                case 'datetime-local':
                    if(!$this->formdata[$key])
                        $this->formdata[$key] = time();
                    $html.= '<input  '.$required.' name="'.$key.'" type="datetime-local" value="'.str_replace(' ', 'T', date('Y-m-d H:i', $this->formdata[$key])).'" class="'.$this->css['input'].'">';
                    break;

                case 'textarea-editor':
                    $html.= "<script id=''>
                    tinymce.init({
                      selector: '#editor_textarea_$key',
                      language: 'ru',
                      content_css: [
                          '/public/assets/js/tiny/tiny.css',
                          'https://fonts.googleapis.com/css?family=Rubik',
                          'https://fonts.googleapis.com/css?family=Work Sans',
                          'https://fonts.googleapis.com/css?family=Mulish',
                          'https://fonts.googleapis.com/css?family=Maven Pro',
                          'https://fonts.googleapis.com/css?family=Jost',
                          'https://fonts.googleapis.com/css?family=Ibarra Real Nova',
                        ],
                    font_formats: 'Ibarra Real Nova=ibarra real nova; Work Sans=work sans; Mulish=mulish; Maven Pro=maven pro; Jost=jost; Rubik=rubik; Arial Black=arial black,avant garde;Times New Roman=times new roman,times;',
                      height: 500,
                    plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste imagetools wordcount'
                    ],
                    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                    content_style: 'body { font-family:Helvetica,Arial,sans-serif, Roboto; font-size:14px }',
                    image_advtab: true ,
                   
                    filemanager_crossdomain: true,
                   external_filemanager_path:'/public/assets/js/tiny/fm/filemanager/',
                   filemanager_title:'Файловый менеджер' ,
                   external_plugins: { 'filemanager' : '/public/assets/js/tiny/fm/filemanager/plugin.min.js'}
                });
                </script>".'<textarea minlength="'.$minLen.'" maxlength="'.$maxLen.'" '.$required.' id="editor_textarea_'.$key.'" name="'.$key.'" class="'.$this->css['textarea'].'">'.htmlspecialchars_decode($this->formdata[$key]).'</textarea>';
                    break;

                case 'textarea':
                    $html.= '<textarea minlength="'.$minLen.'" maxlength="'.$maxLen.'" '.$required.'  name="'.$key.'" class="'.$this->css['textarea'].' '.$maskClass.'">'.htmlspecialchars_decode($this->formdata[$key]).'</textarea>';
                    break;
                
                case 'email':
                    $html.= '<input minlength="'.$minLen.'" maxlength="'.$maxLen.'" '.$required.' name="'.$key.'" value="'.$this->formdata[$key].'" type="email" class="'.$this->css['input'].' '.$maskClass.'">';
                    break;

                case 'password':
                    $html.= '<input minlength="'.$minLen.'" maxlength="'.$maxLen.'" name="'.$key.'" type="password" class="'.$this->css['input'].' '.$maskClass.'">';
                    break;

                case 'file':

                    if($element->value->multi) {
                        $multiple = 'multiple';
                    } else {
                        $multiple = '';
                    }
                    if(isset($element->value->mime)) {
                        $accept = 'accept="'.$element->value->mime.'"';
                    } else {
                        $accept = '';
                    }

                    $html.= '<input '.$accept.' '.$multiple.' type="file" name="'.$key.'" class="'.$this->css['input'].'">';
                    if(isset($this->formdata[$key])) {
                        $file = $this->formdata[$key];
                        if(isset($element->value->image)) {
                            $html.= "<p style='margin-top: 10px;'><img src='$file' style='max-width: 300px;'></p>";
                        } else {
                            $html.= "<p style='margin-top: 10px;>$file</p>";
                        }
                    }
                    break;

                case 'text':
                    if($element->value->key == 'slug') {
                        $tablename = $element->table_name;
                        $title_key = $tablename.'_title';
                        if(!isset(app()->tables->$tablename->$title_key)) {
                            $title_key = $tablename.'_name';
                        }
                        $this->addHTML($key,
                            "
                            <script>
                            $(document).ready(function(){
                                $('input[name=\"$title_key\"]').on('input', function(){
                                    var val = $(this).val();
                                    var slug = string_to_slug(translit(val));
                                    $('#js_$key').val(slug);
                                    $('#slug_preview_js_$key').text(slug);
                                });
                                $('#slug_preview_js_$key').text($('#js_$key').val());
                                $('#js_$key').on('input', function(){
                                    var val = $(this).val();
                                    var slug = string_to_slug(translit(val));
                                    $(this).val(slug);
                                    $('#slug_preview_js_$key').text(slug);
                                });
                            });
                            </script>
                            <div style='margin-top: 5px;' class='post-url-preview'>
                                <p><strong>.../<span id='slug_preview_js_$key'></span></strong></p>
                            </div>
                        ");
                    }
                    if(isset($this->formdata[$key]))
                        $val = $this->formdata[$key];
                    else
                        $val = '';
                    $html.= '<input minlength="'.$minLen.'" maxlength="'.$maxLen.'" '.$required.' id="js_'.$key.'" name="'.$key.'" value="'.htmlspecialchars($val).'" type="text" class="'.$this->css['input'].' '.$maskClass.'">';
                    break;
            }
            if(isset($this->errors[$key])) {
                $html.= '<p class="mt10 '.$this->css['error'].'">'.get_text($this->errors[$key]).'</p>';
            }
            $html.= '</label>';
            
            if(isset($element->after_html)) {
                $html.= $element->after_html;
            }
        }
        $html.= "<input type='hidden' name='formname' value='".$this->formname."'>";
        $html.= '<div class="buttons">';
        if(is_array($this->buttons)) foreach($this->buttons as $button) {
            if($button == 'save') {
                $html.= '<button class="'.$this->css['save_button'].'">'.$this->save_button_text.'</button>';
            } else if($button == 'cancel') {
                $html.= '<a href="?return=true" class="'.$this->css['cancel_button'].'">Отменить</a>';
            }
        }
        $html.= '</div></form>';
        echo $html;
    }
}