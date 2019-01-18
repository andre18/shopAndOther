<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 28.08.2018
 * Time: 07:13
 */

//общие настройки
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$string = '30-01-2018';
$pattern = '/([0-9]{2})-([0-9]{2})-([0-9]{4})/';
$replacement = 'Month: $2, Day: $1, Year: $3';
//echo preg_replace($pattern, $replacement, $string);

//Подключение файлов системы
define('ROOT', dirname(__FILE__));
//echo __FILE__;
require_once (ROOT.'/components/Autoload.php');
//echo ROOT.'/components/Autoload.php';
//require_once (ROOT.'/Core/Router.php');
//require_once (ROOT.'/Components/Db.php');

//Установка соединения с БД


//Вызов Router
$router = new Router();
$router->run();