<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Nester\Application;

$config = require __DIR__ . '/../app/config/config.php';
$app = new Application($config);
$app->run();
