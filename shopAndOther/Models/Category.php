<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 10.09.2018
 * Time: 13:05
 */

class Category
{

    public static function getCategoriesList() {
        $db = Db::getConnection();

        $categoryList = array();

        $result = $db->query("SELECT id, name FROM category ORDER BY sort_order ASC");

        $i = 0;
        while ($row = $result->fetch()) {
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $i++;
        }

        return $categoryList;
    }
}