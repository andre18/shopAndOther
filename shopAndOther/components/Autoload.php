<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 14.09.2018
 * Time: 07:40
 */

//function __autoload($class_name) {
//    $array_paths = array(
//        '/models/',
//        '/components/'
//    );
//
//    foreach ($array_paths as $path) {
//        $path = ROOT.$path.$class_name.'.php';
//        if (is_file($path)) {
//            include_once $path;
//        }
//    }
//}

spl_autoload_register('autoload');

function autoload($class_name) {
    $array_paths = array(
        '/models/',
        '/components/'
    );

    foreach ($array_paths as $path) {
        $path = ROOT.$path.$class_name.'.php';
        if (is_file($path)) {
            include_once $path;
        }
    }
}