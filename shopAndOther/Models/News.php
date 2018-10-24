<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 06.09.2018
 * Time: 21:00
 */

//include_once ROOT.'/Components/Db.php';

class News
{


    public static function getNewsItemById($id) {
        $id = intval($id);

        if ($id) {
//            $host = 'localhost';
//            $dbname = 'shopAndOther';
//            $user = 'root';
//            $password = '';
//            $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

            $db = Db::getConnection();

            $result = $db->query('SELECT * FROM news WHERE id='.$id);
            $result->setFetchMode(PDO::FETCH_ASSOC);

            $newsItem = $result->fetch();
            return $newsItem;
        }
    }

    public static function getNewsList() {

//        $host = 'localhost';
//        $dbname = 'shopAndOther';
//        $user = 'root';
//        $password = '';
//        $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

        $db = Db::getConnection();

        $newsList = array();

        $result = $db->query('SELECT id, title, date, short_content, author_name '
            .'FROM news '
            .'ORDER BY date DESC '
            .'LIMIT 10');

        $i = 0;
        while ($row = $result->fetch()) {
            $newsList[$i]['id'] = $row['id'];
            $newsList[$i]['title'] = $row['title'];
            $newsList[$i]['date'] = $row['date'];
            $newsList[$i]['short_content'] = $row['short_content'];
            $newsList[$i]['author_name'] = $row['author_name'];
            $i++;
        }

//        echo '<pre>';
//        print_r($newsList);
//        echo '</pre>';

        return $newsList;
    }
}