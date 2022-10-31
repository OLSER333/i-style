<?php

namespace App;

use App\System\Core\Variables;
use App\Controllers\Error404;

const BASEPATH      = __DIR__;
const DISPLAY_LOGS  = 0;

const DB_CHARSET    = 'utf8mb4';
const DB_HOST       = '127.0.0.1';
const DB_USER       = 'root';
const DB_PASS       = '';
const DB_NAME       = 'style_proj';
const DB_SETUP_KEY  = '1';

const SITE_NAME = 'iStyle';
const SITE_URL = 'istyle.com';
const FULL_SITE_URL = 'http://istyle.com';
const ADMIN_EMAIL = 'admin@'.SITE_URL;
const ADMIN_PASS = 'admin';

const DEFAULT_THEME = 'purple';

const MIN_PASS_LENGTH   = 6,
      MAX_PASS_LENGTH   = 64,
      MAX_BAD_LOGIN     = 5;

const TABLE_DATETIME_FORMAT = 'd.m.Y H:i';
const DATETIME_FORMAT = 'd.m.Y H:i';


define('VIDEO_MIME_TYPES', [
    'video/x-msvideo',
    'video/mpeg',
    'video/ogg',
    'video/webm',
    'video/3gpp',
    'video/3gpp2',
    'video/mp4',
    'video/quicktime',
    'video/x-ms-wmv'
]);

define('IMAGE_MIME_TYPES', [
    'image/png',
    'image/bmp',
    'image/png',
    'image/gif',
    'image/tiff',
    'image/bmp',
    'image/jpeg',
    'image/jpg'
]);

include_once __DIR__.'/libraries/composer/vendor/autoload.php';
include_once __DIR__.'/system/config.php';
include_once __DIR__.'/App.php';
include_once __DIR__.'/functions.php';

$app = new App();
Variables::add($app, 'app');

$app->action('set_values');
$app->action('set_tables');
$app->action('options');
$app->action('set_user');
// $app->action('set_lang');
$app->action('set_currency');

$app->data('icons');
$app->data('text');
$app->data('app_data');

$app->action('set_menu');
$app->action('set_routes');

$app->router->set_current_route();

if(!isset($app->router->current_controller)) {
    new Error404();
}

if(DISPLAY_LOGS) {
    $app->view('logs');
}
