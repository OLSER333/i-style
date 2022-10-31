<?php

namespace Themes\Regular;

use function App\app;

const THEME_PATH = __DIR__;

include_once __DIR__.'/RegularTheme.php';
include_once __DIR__.'/functions.php';

$theme = new RegularTheme();
app()->theme = $theme;