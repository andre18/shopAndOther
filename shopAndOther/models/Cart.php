<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 24.09.2018
 * Time: 06:56
 */

class Cart
{

    public static function addProduct($id) {
        $id = intval($id);

        //Пустой массив для товаров в корзине
        $productsInCart = array();

        //Если в корзине уже есть товары (они хранятся в сессии)
        if (isset($_SESSION['products'])) {
            //То заполним наш массив товарами
            $productsInCart = $_SESSION['products'];
        }

        //Если товар есть в корзине, но был добавлен еще раз, увеличим количество
        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id] ++;
        } else {
            //Добавляем новый товар в корзину
            $productsInCart[$id] = 1;
        }

        $_SESSION['products'] = $productsInCart;

        return self::countItems();
    }

    public static function deleteProduct($id) {
        $id = intval($id);

        //Берем все товары из корзины
        $productsInCart = $_SESSION['products'];

        //Удаляем товар, выбранный клиентом
        $productsInCart[$id]--;

        //Удаляемая строка
        $deleteRow = -1;
        //Кол-во продукта выбранного товара
        $productCount = 0;
        //Информация о товаре
//        $product = Product::getProductById($id)['price'];
        //Цена товара
        $price = Product::getProductById($id)['price'];

        //Если был удален последний товар с выбранным id из корзины,
        //удаляем его из массива $productsInCart
        if ($productsInCart[$id] == 0) {
            $deleteRow = $productsInCart[$id];
            unset($productsInCart[$id]);
        } else {
            $productCount = $productsInCart[$id];
        }

        //Перезаписываем сессию обновленными данными
        $_SESSION['products'] = $productsInCart;

        //Записываем json строку, которую передадим в ответе ajax запросу
        $info = json_encode(array('cartCount' => self::countItems(), 'deleteRow' => $deleteRow, 'productCount' => $productCount, 'productPrice' => $price));

        return $info;
    }

    public static function getProducts() {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }

        return false;
    }

    public static function countItems() {
        if (isset($_SESSION['products'])) {
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }

    public static function getTotalPrice($products) {
        $productsInCart = self::getProducts();

        $total = 0;

        if ($productsInCart) {
            foreach ($products as $item) {
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }

        return $total;
    }

    public static function clear() {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }
}