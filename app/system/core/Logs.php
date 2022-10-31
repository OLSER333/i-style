<?php

namespace App\System\Core;

use function App\System\show;

class Logs
{
    public static array $data;

    static function error(string|array|object $message)
    {
        return self::message($message, "Error", true);
    }

    static function message(string|array|object $message, string|null $title = null, bool $error = false)
    {
        if(is_array($message) or is_object($message))
            $message = implode('<br>', $message);
        if(!is_null($title)) {
            if($error)
                $style = 'color: red';
            else
                $style = 'color: green';
            $message = "<strong style='$style'>$title</strong><br>$message";
        }
        self::$data[] = $message;
    }

    static function display(string|null $title = null)
    {
        if(!empty(self::$data)) {
            echo "<div style='background-color: black; color: white; padding: 10px;'>";
            if(!is_null($title))
                show("<strong>$title:</strong>");
            foreach(self::$data as $row)
                show($row);
            echo '</div>';
        }
    }
}