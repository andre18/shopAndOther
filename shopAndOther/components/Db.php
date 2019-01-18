<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 09.09.2018
 * Time: 00:38
 */

class Db
{

    public static function getConnection() {
        $paramsPath = ROOT.'/config/db_params.php';
        $params = include($paramsPath);

//        print_r($params);

        $dsn = "mysql:host={$params['host']};dbname={$params['dname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);

        $db->query("SET NAMES utf8");

        return $db;
    }
}