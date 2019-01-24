<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 1/23/19
 * Time: 12:50 PM
 */

class AdminController extends AdminBase
{

    public function actionIndex() {

        //Проверка доступа
        self::checkAdmin();

        //Подключаем вид
        require_once (ROOT."/views/admin/index.php");
        return true;
    }
}