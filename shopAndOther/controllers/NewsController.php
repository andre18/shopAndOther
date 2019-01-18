<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 05.09.2018
 * Time: 07:02
 */

class NewsController
{
    public function actionIndex() {
        $newsList = array();
        $newsList = News::getNewsList();

        require_once (ROOT.'/views/news/index.php');

        return true;
    }

    public function actionView($category, $id) {
//        echo '<br>'.$category;
//        echo '<br>'.$id;

        if ($id) {
            $newsItem = News::getNewsItemById($id);

//            echo '<pre>';
//            echo print_r($newsItem);
//            echo '</pre>';
        }
        return true;
    }
}