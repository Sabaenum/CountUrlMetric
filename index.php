<?php
require_once './vendor/autoload.php';
require_once './app/autoload.php';
$config = include 'conf.php';
use app\Boot as Boot;

$api = new Boot($config);
$api->run();
