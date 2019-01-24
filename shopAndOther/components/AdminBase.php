<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 1/23/19
 * Time: 12:17 PM
 */

abstract class AdminBase
{

    /**
     * Метод, который проверяет пользователя на то, является ли он администратором
     * @return bool
     */
    public static function checkAdmin() {

        //Проверяем авторизирован ли пользователь. Если нет, он будет переадресован
        $userId = User::checkLogged();

        //Получаем информацию о текущем пользователе
        $user = User::getUserById($userId);

        //Если роль текущего пользователя "admin", пускаем его в админпанель
        if ($user['role'] == 'admin') {
            return true;
        }

        //Иначе завершаем работу с соообщением о закрытом доступе
        die('Access denied');
    }
}