<?php

namespace App;

use App\Classes\Database\Driver;
use App\Classes\User;
use App\System\Core\Variables;

use const App\ROOT\ABSPATH;

function app() : App
{
    return Variables::get('app');
}

function db() : Driver
{
    return Variables::get('app')->db;
}

function user() : User
{
    return Variables::get('app')->user;
}

function option(string $key, string|int|float|null $value = null, bool $returnArray = false)
{
    $db = db();
    $option = $db->findOne('option', ['option_key' => $key]);
    if($value !== null) {
        if(empty($option)) {
            $db->insert('option', [
                'option_key' => $key,
                'option_value' => $value
            ]);
        } else {
            $db->update('option', [
                'option_value' => $value
            ], $option['option_id']);
        }
        $option['option_value'] = $value;
    }
    
    if($returnArray)
        return $option;
    else
        return $option['option_value'];
}

function get_request_url()
{
    return app()->router->path;
}


function getPrice(string|int|float|null $amount, bool $decimals = true)
{
    if(is_null($amount))
        $amount = 0;
    if($decimals)
        $decimalsCount = 2;
    else
        $decimalsCount = 0;
    $amount = number_format($amount, $decimalsCount, '.', ' ');
    $symbol = app()->currency['currency_symbol'];
    if(app()->currency['symbol_position'] === 'right') {
        $amount.= ' '.$symbol;
    } else {
        $amount = $symbol.' '.$amount;
    }
    return $amount;
}



function getUserAvatar(string|null $photoPath, string|null $name): string
{
    if(!$photoPath or $photoPath === '' or !file_exists(ABSPATH.$photoPath)) {
        $letter = mb_substr($name, 0, 1);
        if(!$letter) {
            $letter = 'N';
        }
        $color = get_letter_color($letter);
        return '<span style="background-color: '.$color.';">'.ucfirst($letter).'</span>';
    } else {
        return "<img src='$photoPath'>";
    }
}


function get_user_avatar(string $name, bool $get_name = false, $class = 'user-circle', $circle_before = '', $circle_after = '') : string {

    $letter = mb_substr($name, 0, 1);
    if(!$letter) {
        $letter = 'N';
    }
    
    $color = get_letter_color($letter);
    $html = '<span style="background-color: '.$color.';" class="'. $class .'">'.ucfirst($letter).'</span>';
    $html = $circle_before.$html.$circle_after;
    
    if($get_name == true) {
        $html.='<span class="user-circle-name">'.$name.'</span>';
    }
    return $html;
}

function get_letter_color($letter) {
    $default = 'rgb(41, 40, 44)';
    $colors = array(
        'a' => 'rgb(114 97 167)',
        'b' => 'rgb(114 97 167)',
        'c' => 'rgb(114 97 167)',
        'd' => 'rgb(114 97 167)',
        'e' => 'rgb(90 179 95)',
        'f' => 'rgb(90 179 95)',
        'g' => 'rgb(90 179 95)',
        'h' => 'rgb(90 179 95)',
        'i' => 'rgb(179 90 166)',
        'j' => 'rgb(179 90 166)',
        'k' => 'rgb(179 90 166)',
        'l' => 'rgb(179 90 166)',
        'm' => 'rgb(179 90 166)',
        'n' => 'rgb(224 62 62)',
        'o' => 'rgb(224 62 62)',
        'p' => 'rgb(224 62 62)',
        'q' => 'rgb(224 62 62)',
        'r' => 'rgb(62 152 150)',
        's' => 'rgb(62 152 150)',
        't' => 'rgb(62 152 150)',
        'u' => 'rgb(62 152 150)',
        'v' => 'rgb(62 152 150)',
        'w' => 'rgb(94 100 111)',
        'x' => 'rgb(94 100 111)',
        'y' => 'rgb(94 100 111)',
        'z' => 'rgb(94 100 111)',

        'а' => 'rgb(114 97 167)',
        'б' => 'rgb(114 97 167)',
        'в' => 'rgb(114 97 167)',
        'г' => 'rgb(114 97 167)',
        'д' => 'rgb(90 179 95)',
        'е' => 'rgb(90 179 95)',
        'ё' => 'rgb(90 179 95)',
        'ж' => 'rgb(90 179 95)',
        'з' => 'rgb(179 90 166)',
        'и' => 'rgb(179 90 166)',
        'й' => 'rgb(179 90 166)',
        'к' => 'rgb(179 90 166)',
        'л' => 'rgb(179 90 166)',
        'м' => 'rgb(224 62 62)',
        'н' => 'rgb(224 62 62)',
        'о' => 'rgb(224 62 62)',
        'п' => 'rgb(224 62 62)',
        'р' => 'rgb(62 152 150)',
        'с' => 'rgb(62 152 150)',
        'т' => 'rgb(62 152 150)',
        'у' => 'rgb(62 152 150)',
        'ф' => 'rgb(62 152 150)',
        'х' => 'rgb(94 100 111)',
        'ц' => 'rgb(94 100 111)',
        'ч' => 'rgb(94 100 111)',
        'ш' => 'rgb(94 100 111)',

        'щ' => 'rgb(94 100 111)',
        'ъ' => 'rgb(94 100 111)',
        'ш' => 'rgb(224 62 62)',

        'ы' => 'rgb(94 100 111)',
        'ь' => 'rgb(94 100 111)',
        'э' => 'rgb(94 100 111)',
        'ю' => 'rgb(94 100 111)',
        'я' => 'rgb(224 62 62)'

    );
    $letter = mb_strtolower($letter);
    if(isset($colors[$letter])) {
        return $colors[$letter];
    } else {
        return $default;
    }
}


function is_logged_in()
{
    $user = app()->user;
    if($user->user_role === 'guest' or $user->user_auth_status !== 'active')
        return false;
    return true;
}

function is_admin()
{
    $user = app()->user;
    if($user->user_role === 'admin')
        return true;
    return false;
}

function redirect(string $url)
{
    if(!filter_var($url, FILTER_VALIDATE_URL)) {
        $url = '/'.trim($url, '/');
    }
    header("Location: $url");
    exit;
}


function check_email($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

function sendMail(string $to, string $subject, string $message)
{
    $headers = 'Content-type: text/html'. "\r\n" .
               'From: ' . ADMIN_EMAIL . "\r\n" .
               'Reply-To: ' . ADMIN_EMAIL . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
}

function isValidMd5(string $md5)
{
    return preg_match('/^[a-f0-9]{32}$/', $md5);
}

function generatePassword($length = 8){
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string;
}


function get_text(string|null $key, string|false|null $default = false, string|int|false $dynamic = false) {
    if(isset(app()->data['text'][$key]))
        $value = app()->data['text'][$key];
    else {
        if(is_string($default))
            $value = $default;
        else
            $value = ucfirst(
                str_replace(
                    "_" ,
                    " ",
                    $key
                )
            );
    }
    if($dynamic !== false) {
        $value = str_replace('{value}', $dynamic, $value);
        if(is_int($dynamic)) {
            try {
                $newValue = valueWordEnding($value, intval($dynamic));
                $value = $newValue;
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
    return $value;
} 

function valueWordEnding(string $value, int $number)
{
    $words = [
        'салонов' => [
            'default' => 'салонов',
            1 => 'салон',
            2 => 'салона',
            3 => 'салона',
            4 => 'салона'
        ],
        'услуг' => [
            'default' => 'услуг',
            1 => 'услуга',
            2 => 'услуги',
            3 => 'услуги',
            4 => 'услуги'
        ],
        'отзывов' => [
            'default' => 'отзывов',
            1 => 'отзыв',
            2 => 'отзыва',
            3 => 'отзыва',
            4 => 'отзыва'
        ],
        'предложений' => [
            'default' => 'предложений',
            1 => 'предложения'
        ]
    ];
    foreach($words as $word => $variables) {
        if(mb_stristr($value, $word)) {
            if(isset($variables[$number])) {
                $currentWord = $variables[$number];
            } else if($number < 20) {
                $currentWord = $variables['default'];
            } else {
                $lastTwoNum = mb_substr(strval($number), -1, 2);
                if(isset($variables[$lastTwoNum])) {
                    $currentWord = $variables[$lastTwoNum];
                } else if($lastTwoNum < 20) {
                    $currentWord = $variables['default'];
                } else {
                    $lastNum = intval(mb_substr(strval($number), -1));
                    if(isset($variables[$lastNum])) {
                        $currentWord = $variables[$lastNum];
                    }
                }
            }
            if(!isset($currentWord)) {
                $currentWord = $variables['default'];
            }
            $value = str_replace($word, $currentWord, $value);
            return $value;
        }
    }
    return $value;
}



function get_icon($key) {
    if(isset(app()->data['icons'][$key])) {
        return app()->data['icons'][$key];
    } else {
        return app()->data['icons']['default'];
    }
}

function isUrl(string $url)
{
    return filter_var($url, FILTER_VALIDATE_URL);
}

function get_ip() : string
{
    $server = $_SERVER;
    $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
    ];
    foreach($keys as $key) {
        if(!empty($server[$key])) {
            $ip = explode(',', $server[$key]);
            $ip = trim(end($ip));
            if(filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
}

function get_domain() : string
{
    return $_SERVER['HTTP_HOST'];
}

function get_site_url() : string
{

    $server = $_SERVER;
    $protocol = (!empty($server['HTTPS']) && $server['HTTPS'] !== 'off' || $server['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domain_name = $server['HTTP_HOST'];
    return $protocol.$domain_name;
}

function get_baseurl($basepath) : string
{
    $baseurl = explode($_SERVER['HTTP_HOST'], $basepath)[1];
    $baseurl = trim($baseurl, DIRECTORY_SEPARATOR);
    $baseurl = '/'.str_replace(['/', '\\'], '/', $baseurl);
    return $baseurl;
}

function get_request_time() : int
{
    return round(microtime(true) * 1000) - $_SERVER['REQUEST_TIME_FLOAT'] * 1000;
}

function getStatLink(string $url, int|string $id)
{
    return FULL_SITE_URL.'/url/?r='.urlencode($url).'&i='.$id;
}

function createRange($start, $end, $format = 'Y-m-d') {
    $start  = new \DateTime($start);
    $end    = new \DateTime($end);
    $invert = $start > $end;

    $dates = array();
    $dates[] = $start->format($format);
    while ($start != $end) {
        $start->modify(($invert ? '-' : '+') . '1 day');
        $dates[] = $start->format($format);
    }
    return $dates;
}


function clear_input($text) {
    return preg_replace('/[^a-zA-Zа-яА-Я0-9\s]/ui', '', $text);
}


function text_translate($text) {
    return strtr($text, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>'', 'А'=>'A','Б'=>'B','В'=>'V','Г'=>'G','Д'=>'D','Е'=>'E','Ё'=>'E','Ж'=>'J','З'=>'Z','И'=>'I','Й'=>'Y','К'=>'K','Л'=>'L','М'=>'M','Н'=>'N','О'=>'O','П'=>'P','Р'=>'R','С'=>'S','Т'=>'T','У'=>'U','Ф'=>'F','Х'=>'H','Ц'=>'C','Ч'=>'CH','Ш'=>'SH','Щ'=>'SHCH','Ы'=>'Y','Э'=>'E','Ю'=>'YU','Я'=>'YA','Ъ'=>'','Ь'=>''));
}


function checkLang(string $langCode): array|false
{
    $langs = [];
    foreach(app()->languages as $id => $lang) {
        if(strtoupper($lang['language_code']) === strtoupper($langCode)) {
            $langs['id'] = intval($id);
            $langs['code'] = $langCode;
            break;
        }
    }
    if(!empty($langs))
        return $langs;
    else
        return false;
}

function setUserCookie(string $key, mixed $value, int $expires = 60*60*24*30)
{
    setcookie($key, $value, time()+$expires, '/');
}


function addLangToData(array|null $data, string|null $newColl = null)
{
    if($data === null) {
        return null;
    }
    $returnData = [];
    foreach($data as $row) {
        $code = app()->languages[$row['language_id']]['language_code'];
        if($newColl === null) {
            $row['language_id'] = $code;
        } else {
            $row[$newColl] = $code;
            unset($row['language_id']);
        }
        $returnData[] = $row;
    }
    return $returnData;
}



function tofloat($num, int|bool $decimals = false) {
    $dotPos = strrpos($num, '.');
    $commaPos = strrpos($num, ',');
    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
        ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
  
    if (!$sep) {
        return floatval(preg_replace("/[^0-9]/", "", $num));
    }

    $value = floatval(
        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
        preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
    );
    if($decimals === false) {
        return $value;
    }
    return number_format($value, $decimals, '.', '');
}

function getRefer()
{
    if(isset($_SERVER['HTTP_REFERER'])) {
        $link = $_SERVER['HTTP_REFERER'];
    } else {
        $link = '/';
    }
    return $link;
}



function isDateRange(string $dateRange): bool
{
    $valueArr = explode(' - ', $dateRange);
    if(count($valueArr) !== 2) {
        return false;
    }
    if(isValidDate($valueArr[0], 'H:i') === false) {
        return false;
    }
    if(isValidDate($valueArr[1], 'H:i') === false) {
        return false;
    }
    if($valueArr[0] > $valueArr[1]) {
        return false;
    }
    return true;
}

function isValidDate(string $date, string $format = 'Y-m-d'): bool
{
    $dateObj = \DateTime::createFromFormat($format, $date);
    return $dateObj && $dateObj->format($format) == $date;
}

function get_slug($text, string $divider = '_', int $maxLength = 200) {
    $text = mb_strtolower($text);
    // replace non letter or digits by divider
    $text = text_translate($text);
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, $divider);
    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);
    // lowercase
    $text = mb_strimwidth($text, 0, $maxLength, '');
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

function getPagination(int $count, string $linkAdditional = ''): array
{
    $pagination = [];
    $limit = 9;
    $offset = 0;
    $currentPag = 1;
    $pagLimit = 5;
    if(isset($_GET['page'])) {
        $currentPag = intval($_GET['page']);
        $offset = $currentPag*$limit-$limit; 
    }
    $pagination['limit'] = $limit;
    $pagination['offset'] = $offset;
    
    if($count < $limit) {
        return $pagination;
    }

    $items = [];
    $pagCount = intval(ceil($count/$limit));
    $i = 0;
    while($i !== $pagCount) {
        $i++;
        $pagItem = [
            'href' => '?page='.$i,
            'class' => '',
            'num' => $i
        ];
        $pagItem['href'].= $linkAdditional;
        if($i === $currentPag) {
            $pagItem['class'] = 'active-pag-item';
            if($i+1 <= $pagCount) {
                $pagination['next_page'] = '?page='.$i+1;
            } else {
                $pagination['next_page'] = '?page=1';
            }
            if($i-1 >= 1) {
                $pagination['prev_page'] = '?page='.$i-1;
            } else {
                $pagination['prev_page'] = '?page='.$pagCount;
            }
            $pagination['prev_page'].= $linkAdditional;
            $pagination['next_page'].= $linkAdditional;
        }
        $items[] = $pagItem;
    }
    if($pagCount > $pagLimit) {
        $pagBreak = [
            'href' => '',
            'class' => 'pag-break',
            'num' => '...'
        ];
        if($currentPag === 1) {
            $limitedItems[] = $items[0];
            $limitedItems[] = $items[1];
            $limitedItems[] = $items[2];
            $limitedItems[] = $pagBreak;
            $limitedItems[] = $items[$pagCount-1];
        } else if($currentPag === $pagCount) {
            $limitedItems[] = $items[0];
            $limitedItems[] = $pagBreak;
            $limitedItems[] = $items[$pagCount-3];
            $limitedItems[] = $items[$pagCount-2];
            $limitedItems[] = $items[$pagCount-1];
        } else {
            $limitedItems[] = $items[0];
            if($currentPag-1 > 2) {
                $limitedItems[] = $pagBreak;
            }
            if($currentPag !== 2) {
                $limitedItems[] = $items[$currentPag-2];
            }
            $limitedItems[] = $items[$currentPag-1];
            $limitedItems[] = $items[$currentPag];
            if($currentPag+1 < $pagCount-1) {
                $limitedItems[] = $pagBreak;
            }
            if($currentPag !== $pagCount-1) {
                $limitedItems[] = $items[$pagCount-1];
            }
        }
    } else {
        $limitedItems = $items;
    }
    $pagination['items'] = $limitedItems;
    return $pagination;
}

function replaceToBr(string $text)
{
    return str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $text);
}

function reArrayFilesOld(array $file_post): array
{
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

function reArrayFiles(array $file_post): array
{
    $isMulti        = is_array($file_post['name']);
    $file_count     = $isMulti?count($file_post['name']):1;
    $file_keys      = array_keys($file_post);

    $file_ary    = []; 
    for($i=0; $i<$file_count; $i++)
        foreach($file_keys as $key)
            if($isMulti)
                $file_ary[$i][$key] = $file_post[$key][$i];
            else
                $file_ary[$i][$key]    = $file_post[$key];

    return $file_ary;
}