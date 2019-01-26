<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 28.08.2018
 * Time: 07:22
 */

return array(

    'product/([0-9]+)' => 'product/view/$1',

    'catalog' => 'catalog/index',

    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2',
    'category/([0-9]+)' => 'catalog/category/$1',

    'cart/add/([0-9]+)' => 'cart/add/$1',

    'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1',
    'cart/deleteAjax/([0-9]+)' => 'cart/deleteAjax/$1',
    'cart' => 'cart/index',

    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',

    'cabinet/edit' => 'cabinet/edit',
    'cabinet' => 'cabinet/index',

    //Управление товарами:
    'admin/product/create' => 'adminProduct/create',
    'admin/product/update/([0-9]+)' => 'adminProduct/update/$1',
    'admin/product/delete/([0-9]+)' => 'adminProduct/delete/$1',
    'admin/product' => 'adminProduct/index',

    //Управление категориями:
    'admin/category/create' => 'adminCategory/create',
    'admin/category/update/([0-9]+)' => 'adminCategory/update/$1',
    'admin/category/delete/([0-9]+)' => 'adminCategory/delete/$1',
    'admin/category' => 'adminCategory/index',

    'admin' => 'admin/index',

    '' => 'site/index',
);