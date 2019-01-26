<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 1/24/19
 * Time: 4:11 PM
 */

class AdminProductController extends AdminBase
{

    public function actionIndex() {

        //Проверка доступа
        self::checkAdmin();

        //Получаем список товаров
        $productsList = Product::getProductsList();

        //Подключаем вид
        require_once (ROOT."/views/admin_product/index.php");
        return true;
    }

    public function actionCreate() {

        self::checkAdmin();

        //Получаем список категорий для выпадающего списка
        $categoriesList = Category::getCategoriesListAdmin();

        $options = array();

        //Если форма была отправлена
        if (isset($_POST['submit'])) {
            //Если форма отправлена, получаем данные из нее
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            //Флаг ошибок в форме
            $errors = false;

            if (!isset($_POST['name']) || empty($_POST['name'])) {
                $errors[] = "Заполните поля";
            }

            if ($errors == false) {
                //Если ошибок нет, добавляем новый товар
                $id = Product::createProduct($options);

                //TODO if for images

                //Перенаправляем пользователя на страницу управления товарами
                header("Location: /admin/product");
            }
        }

        require_once (ROOT."/views/admin_product/create.php");
        return true;
    }

    public function actionUpdate($id) {

        //Проверка доступа
        self::checkAdmin();

        $categoriesList = Category::getCategoriesListAdmin();

        //Получаем данные о редактируемом товаре
        $product = Product::getProductById($id);

        //Обработка формы
        if (isset($_POST['submit'])) {
            //Если форма отправлена, получаем данные из формы редактирования
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            //Сохраняем изменения
            Product::updateProduct($id, $options);

            header("Location: /admin/product");
        }

        require_once (ROOT."/views/admin_product/update.php");
        return true;
    }

    public function actionDelete($id) {

        self::checkAdmin();

        //Обработка формы
        if (isset($_POST['submit'])) {

            //Если форма отправлена
            //Удаляем товар
            Product::deleteProductById($id);

            //Перенаправляем пользователя на страницу управления товарами
            header("Location: /admin/product");
        }

        require_once (ROOT."/views/admin_product/delete.php");
        return true;
    }
}