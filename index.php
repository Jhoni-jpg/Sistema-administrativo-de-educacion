<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/core/controllerViews.php';
require __DIR__ . '/src/core/app.php';

$app = new App();