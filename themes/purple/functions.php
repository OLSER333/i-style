<?php

use function App\get_text as get_text;

function t(string|null $key, string|false|null $default = false, string|int|false $dynamic = false)
{
    if($key === null) {
        $key = '';
    }
    if($default === null)
        $default = false;
    return get_text($key, $default, $dynamic);
}

if(!function_exists('mb_ucfirst')) {
    function mb_ucfirst($string, $enc = 'UTF-8')
    {
        return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc) . mb_substr($string, 1, mb_strlen($string, $enc), $enc);
    }
}

function getStars(float $rating = 3.44): string
{
    $html = '<span class="stars-rating flex flex-start">';
    $i = 0.5;
    while($i < $rating) {
        $i++;
        $html.= '<span class="star-active"><i class="fa-solid fa-star"></i></span>';
    }
    $inactive_start_count = 5-$i;
    $j = 0;
    while($j < $inactive_start_count) {
        $j++;
        $html.= '<span class="star-inactive"><i class="fa-solid fa-star"></i></span>'; 
    }
    $html.= '</span>';

    return $html;
}

function selected($currentVal, $optionVal)
{
    if($currentVal === $optionVal) {
        return 'selected';
    }
    return '';
}