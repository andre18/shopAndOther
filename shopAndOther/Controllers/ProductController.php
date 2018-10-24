<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 05.09.2018
 * Time: 07:01
 */

include_once ROOT.'/Models/Category.php';
include_once ROOT.'/Models/Product.php';

class ProductController
{
    public function actionView($productId) {
        $categories = array();
        $categories = Category::getCategoriesList();

        $product = Product::getProductById($productId);

        require_once (ROOT.'/views/product/view.php');

        return true;
    }
}