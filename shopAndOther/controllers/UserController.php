<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 14.09.2018
 * Time: 15:47
 */

class UserController
{
    public function actionRegister() {

        $name = '';
        $email = '';
        $password = '';
        $result = false;

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = false;

            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            if (User::checkEmailExists($email)) {
                $errors[] = 'Tакой email уже используется';
                echo 'Tакой email уже используется';
            }

            if ($errors == false) {
                //При успешной регстрации:
                //Добавляем данные пользователя в БД
                $userId = User::register($name, $email, $password);

                //Запоминаем пользователя (сессия)
                User::auth($userId);

                //Перенаправляем пользователя в закрытую часть - кабинет
                header("Location: /cabinet/");
            }
        }

        require_once (ROOT.'/views/user/register.php');

        return true;
    }

    public function actionLogin() {
        $email = '';
        $password = '';

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = false;

            //валидация полей
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6 символов';
            }

            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                //данные введены правильно - запоминаем пользователя (сессия)
                User::auth($userId);

                //Перенаправляем пользователя в закрытую часть - кабинет
                header("Location: /cabinet/");
            }
        }

        require_once (ROOT.'/views/user/login.php');

        return true;
    }

    public function actionLogout() {

        unset($_SESSION['user']);
        header("Location: /");
    }
}