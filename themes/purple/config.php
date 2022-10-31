<?php

namespace Themes\Purple;

use function App\app;

const THEME_PATH = __DIR__;

include_once __DIR__.'/PurpleTheme.php';
include_once __DIR__.'/functions.php';

$theme = new PurpleTheme();
app()->theme = $theme;