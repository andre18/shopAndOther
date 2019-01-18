<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 24.09.2018
 * Time: 06:50
 */

class CartController
{

    public function actionAdd($id) {

        Cart::addProduct($id);

        //Перенаправляем пользователя на страницу, с которой он пришел
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }

    public function actionAddAjax($id) {
        //Добавляем товар в корзину
        echo Cart::addProduct($id);
        return true;
    }

    public function actionIndex() {
        $categories = array();
        $categories = Category::getCategoriesList();

        $productsInCart = Cart::getProducts();

        if ($productsInCart) {
            // Получаем полную информацию о товарах для списка
            $productsIds = array_keys($productsInCart);
            $products = Product::getProductsByIds($productsIds);

            // Получаем общую стоимость товаров
            $totalPrice = Cart::getTotalPrice($products);
        }

        require_once(ROOT.'/views/cart/index.php');

        return true;
    }

    public function actionCheckout() {

        // categories list for left menu
        $categories = array();
        $categories = Category::getCategoriesList();

        // статус успешного оформления заказа
        $result = false;

        // Форма отправлена?
        if (isset($_POST['submit'])) {
            //Форма отправлена? - да

            //считываем данные формы
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];

            // Валидация полей
            $errors = false;
            if (User::checkName($userName))
                $errors[] = 'Неправильное имя';
            if (User::checkPhone($userPhone)) //TODO
                $errors[] = 'Неправильный телефон';

            //форма заполнена корректно?
            if ($errors == false) {
                //форма заполнена корректно?
                //сохраняем заказ в БД

                //собираем информацию о заказе
                $productsInCart = Cart::getProducts();
                if (User::isGuest()) {
                    $userId = false;
                } else {
                    $userId = User::checkLogged();
                }

                $result = Order::save();

                if ($result) {
                    //оповещаем администратора о новом заказе
                    $adminEmail = 'sherlock1914@gmail.com';
                    $message = 'http://shop:8080';
                    $subject = 'Новый заказ!';
                    mail($adminEmail, $subject, $message);

                    //очищаем корзину
                    Cart::clear();
                }
            } else {
                //форма заполнена корректно? - нет

                //итоги, общая стоимость, количество товаров
                $productsInCart = Cart::getProducts();
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
            }
        } else {
            // Поллучвем данне из корзины
            $productsInCart = Cart::getProducts();

            // В корзине есть товары?
            if ($productsInCart == false) {
                // В корзине есть товары? - нет
                // Отправляем пользователя на главную искать товары
                header("Location: /");
            } else {
                // В корзине есть товары? - Да

                // Итоги: общая стоимость, количество товаров
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();

                $userName = false;
                $userPhone = false;
                $userComment = false;

                if (User::isGuest()) {
                    // нет
                    // Значения для формы пустые
                } else {
                    // да, авторизирован
                    // Получаем информацию о пользователе из БД по id
                    $userId = User::checkLogged();
                    $user = User::getUserById($userId);
                    // Подставляем в форму
                    $userName = $user['name'];
                }
            }
        }
    }
}