<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 19.09.2018
 * Time: 18:51
 */

class CabinetController
{

    public function actionIndex() {

        $userId = User::checkLogged();

        $user = User::getUserById($userId);

        require_once (ROOT.'/views/cabinet/index.php');

        return true;
    }

    public function actionEdit() {

        //Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();

        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        $name = $user['name'];
        $password = $user['password'];

        $result = false;

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];

            $errors = false;

            if (!User::checkName($name)) {
                $errors[] = 'Bмя не должно быть короче 2-х символов';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            if ($errors == false) {
                $result = User::edit($userId, $name, $password);
            }
        }

        require_once (ROOT.'/views/cabinet/edit.php');

        return true;
    }
}