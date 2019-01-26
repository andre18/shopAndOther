<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 10.09.2018
 * Time: 17:55
 */

class Product
{
    const SHOW_BY_DEFAULT = 6;

    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT) {
        $count = intval($count);

        $db = Db::getConnection();

        $productsList = array();

        $result = $db->query('SELECT id, name, price, image, is_new 
                                        FROM product 
                                        WHERE status = 1 
                                        ORDER BY id DESC 
                                        LIMIT '.$count);

        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['image'] = $row['image'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $productsList;
    }

    public static function getProductsListByCategory($categoryId = false, $page = 1) {
        if ($categoryId) {

            $page = intval($page);
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT; // -1, т.к. смещение для первой страницы не требуется

            $db = Db::getConnection();
            $products = array();
            $result = $db->query("SELECT id, name, price, image, is_new 
                                            FROM product
                                            WHERE status = 1
                                            AND category_id = $categoryId
                                            ORDER BY id DESC
                                            LIMIT ".self::SHOW_BY_DEFAULT.
                                            " OFFSET ".$offset);

            $i = 0;
            while ($row = $result->fetch()) {
                $products[$i]['id'] = $row['id'];
                $products[$i]['name'] = $row['name'];
                $products[$i]['image'] = $row['image'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['is_new'] = $row['is_new'];
                $i++;
            }

            return $products;
        }
    }

    public static function getProductById($id) {
        $id = intval($id);

        if ($id) {
            $db = Db::getConnection();
            $db->query("SET NAMES utf8"); //без этого запроса знаки ???? вызванные какими-то проблемами с кодировкой

            $result = $db->query("SELECT * FROM product WHERE id=".$id);
            $result->setFetchMode(PDO::FETCH_ASSOC);

            return $result->fetch();
        }
    }

    public static function getTotalProductsInCategory($categoryId) {
        $db = Db::getConnection();
        $db->query("SET NAMES utf8");

        $result = $db->query("SELECT count(id) AS count FROM product WHERE status=1 AND category_id=$categoryId");
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    public static function getProductsByIds($idsArray) {
        $products = array();

        $db = Db::getConnection();
        $db->query("SET NAMES utf8");

        $idsString = implode(',', $idsArray);

        $sql = "SELECT * FROM product WHERE status='1' AND id IN ($idsString)";

        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $i++;
        }

        return $products;
    }

    public static function getProductsList() {

        $db = Db::getConnection();

        //Получение и возврат результатов
        $result = $db->query("SELECT id, name, price, code FROM product ORDER BY id ASC");
        $productsList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['code'] = $row['code'];
            $i++;
        }

        return $productsList;
    }

    /**
     * Добавляет новый товар
     * @param array $option <p>Массив с информацией о товаре</p>
     * @return int <p>id добавленной в таблицу записи</p>
     */
    public static function createProduct($option) {

        $db = Db::getConnection();

        $sql = "INSERT INTO product "
            ."(name, code, price, category_id, brand, availability, description, is_new, is_recommended, status) VALUE "
            ."(:name, :code, :price, :category_id, :brand, :availability, :description, :is_new, :is_recommended, :status)";

        //Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(":name", $option['name'], PDO::PARAM_STR);
        $result->bindParam(":code", $option['code'], PDO::PARAM_INT);
        $result->bindParam(":price", floatval($option['price']), PDO::PARAM_STR);
        $result->bindParam(":category_id", $option['category_id'], PDO::PARAM_INT);
        $result->bindParam(":brand", $option['brand'], PDO::PARAM_STR);
        $result->bindParam(":availability", $option['availability'], PDO::PARAM_INT);
        $result->bindParam(":description", $option['description'], PDO::PARAM_STR);
        $result->bindParam(":is_new", $option['is_new'], PDO::PARAM_INT);
        $result->bindParam(":is_recommended", $option['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(":status", $option['status'], PDO::PARAM_INT);
        if ($result->execute()) {
//            echo "eeeeeeeeeeeeee";
//            die();
            //Если запрос выполнен успешно, возвращаем id добавленной записи
            return $db->lastInsertId();
        }

        //Иначе возвращаем 0
        return 0;
    }

    /**
     * Обновляет данные существующего товара
     * @param $id <p>id редактируемой записи</p>
     * @param array $option <p>Массив с обновленной информацией о товаре</p>
     * @return boolean <p>id добавленной в таблицу записи</p>
     */
    public static function updateProduct($id, $option) {

        $db = Db::getConnection();

        $sql = "INSERT INTO product "
            ."(name, code, price, category_id, brand, availability, description, is_new, is_recommended, status) VALUE "
            ."(:name, :code, :price, :category_id, :brand, :availability, :description, :is_new, :is_recommended, :status)";

        $sql = "UPDATE product SET "
            ."name = :name, code = :code, price = :price, category_id = :category_id, brand = :brand, "
            ."availability = :availability, description = :description, is_new = :is_new, "
            ."is_recommended = :is_recommended, status = :status WHERE id = :id";

        //Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_STR);
        $result->bindParam(":name", $option['name'], PDO::PARAM_STR);
        $result->bindParam(":code", $option['code'], PDO::PARAM_INT);
        $result->bindParam(":price", floatval($option['price']), PDO::PARAM_STR);
        $result->bindParam(":category_id", $option['category_id'], PDO::PARAM_INT);
        $result->bindParam(":brand", $option['brand'], PDO::PARAM_STR);
        $result->bindParam(":availability", $option['availability'], PDO::PARAM_INT);
        $result->bindParam(":description", $option['description'], PDO::PARAM_STR);
        $result->bindParam(":is_new", $option['is_new'], PDO::PARAM_INT);
        $result->bindParam(":is_recommended", $option['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(":status", $option['status'], PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Удаляет товар с указанным id
     * @param integer $id <p>id товара</p>
     * @return bool <p>Результат выполнения метода</p>
     */
    public static function deleteProductById($id) {
        echo $id;

        $db = Db::getConnection();

        $sql = "DELETE FROM product WHERE id = :id";

        //Получение и возврат результатов. Используется готовый запрос
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        return $result->execute();
    }
}