<?php

session_start();

ini_set('display_error',1);
error_reporting(E_ALL);


define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Autoload.php');

$router = new Router();
$router->run();