<?php

namespace App\Classes\Database;

use App\System\Core\Variables;

use function App\app;
use function App\get_text;
use function App\getPrice;
use function App\tofloat;

class Value
{
    public function __construct($key, array $args)
    {
        $this->key = $key;
        set_object_properties($this, $args);
    }

    public static function get($value_key, $value, $convert = true, bool $getText = true)
    {
        $Values = app()->values;
        $value_obj = $Values->$value_key;
        if($convert)
            $value = self::convert_value($value_obj, $value);
        if($value_obj->type == 'string' and isset($value_obj->html_chars)) {
            $value = htmlspecialchars_decode($value);
        }
        if($value_obj->key == 'money') {
            $value = getPrice($value);
        } else if($value_obj->key == 'percent') {
            $value = $value.'%';
        } else if($value != '') {
            if($getText === true and isset(app()->data['text'][$value])) {
                $value = get_text($value);
            }
        }
        return $value;
    }

    public static function check(string $value_key, $value, $convert = false)
    {
        $errors = [];
        $Values = app()->values;
       
        $value_obj = $Values->$value_key;
        if(!isset($value_obj)) {
            $errors['value_not_exists'] = true;
            return;
        }
        $value_type = $Values->$value_key->type;
        switch ($value_type) {
            case 'string':
                // if(!is_string($value))
                //     $value = strval($value);
                break;
            case 'int':
                if(!is_int($value) and $value != "0")
                    $value = intval($value);
                else
                    $value = 0;
                if(ValueValidator::int($value_key, $value) === false) {
                    $errors['value'] = true;
                }
                break;
            case 'float':
                $value = tofloat($value);
                $value = number_format($value, $Values->$value_key->float[1], '.', '');
                if(ValueValidator::int($value_key, $value) === false) {
                    $errors['value'] = true;
                }
                break;
            case 'bool':
                if($value == true) {
                    return 1;
                } else {
                    return 0;
                }
                break;
            case 'array':
                if(!is_array($value))
                    $errors['type'] = true;
                break;
            case 'text':
                break;
        }

        if(ValueValidator::length($value_key, $value) === false) {
            $errors['length'] = true;
            $errors['length_val'] =  $value;
            $errors['length_val_key'] =  $value_key;
        }
        if(ValueValidator::select($value_key, $value) === false) {
            $errors['select'] = true;
            $errors['select_val'] =  $value;
            $errors['select_val_key'] =  $value_key;
        }
        $value = ValueValidator::filter($value_key, $value);
        if($value === false) {
            $errors['filter'] = true;
            $errors['filter_val'] =  $value;
            $errors['filter_val_key'] =  $value_key;
        }
        if(!empty($errors)) {
            // show($errors);
            return false;
        }
        if($convert)
           $value = Value::convert_value($value_obj, $value);
        return $value;
    }

    public static function convert_value($value_obj, $value)
    {
        if(isset($value_obj->public_value)) {
            $ValueConverter = Variables::get('app')->values->converter;
            $function_name = $value_obj->key.'_to_'.$value_obj->public_value;
            return $ValueConverter->convert($function_name, $value);
        }
        if(isset($value_obj->app_value)) {
            $ValueConverter = Variables::get('app')->values->converter;
            $function_name = $value_obj->key.'_to_'.$value_obj->app_value;
            return $ValueConverter->convert($function_name, $value);
        }
        return $value;
    }
}


function set_object_properties($object, array $data) {
    if(empty($data))
        return false;
    foreach($data as $key => $value) {
        $object->$key = $value;
    }
    return true;
}

