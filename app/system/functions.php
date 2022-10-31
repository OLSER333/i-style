<?php

namespace App\System;

function import(string $filepath, array $variables = []) : void
{
    if(!empty($variables))
        foreach($variables as $key => $value)
            $$key = $value;
    include $filepath;
}

function setProperties(object $object, array $properties) : object
{
    if(!empty($properties))
        foreach($properties as $key => $value)
            $object->$key = $value;
    return $object;
}

function clearPath(string $path, string $separator = '/') : string
{
    return str_replace(['/', '//', '\\', '\\\\'], $separator, $path);
}

function arrayToPath(array $parts) : string
{
    $path = implode('/', $parts);
    $path = clearPath($path);
    return $path;
}

function getPath(string ...$part) : string
{
    $path = arrayToPath(func_get_args());
    return $path;
}

function strReplaceFirst($search, $replace, $subject) : string
{
    $search = '/'.preg_quote($search, '/').'/';
    return preg_replace($search, $replace, $subject, 1);
}

function show(...$data) : void
{
    $args = func_get_args();
    echo '<div style="margin: 10px;">';
    foreach($args as $arg)
        printf('<pre>%s</pre>', print_r($arg, true));
    echo '</div>';
}

function writelog(string|array|object $message, string|null $title = null, bool $error = false) : void
{
    Core\Logs::message($message, $title, $error);
}

function displaylog()
{
    Core\Logs::display();
}
