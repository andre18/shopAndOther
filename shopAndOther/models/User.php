<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 14.09.2018
 * Time: 23:34
 */

class User
{
     public static function register($name, $email, $password) {

         $db = Db::getConnection();

         $sql = 'INSERT INTO user (name, email, password) VALUES (:name, :email, :password)';

         $result = $db->prepare($sql);
         $result->bindParam(':name', $name, PDO::PARAM_STR);
         $result->bindParam(':email', $email, PDO::PARAM_STR);
         $result->bindParam(':password', $password, PDO::PARAM_STR);
         $result->execute();

         return self::checkUserData($email, $password);
     }

     public static function checkName($name) {
         if (strlen($name) >= 2) {
             return true;
         }
         return false;
     }

     public static function checkPassword($password) {
         if (strlen($password) >= 6) {
             return true;
         }
         return false;
     }

     public static function checkEmail($email) {
         if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
             return true;
         }
         return false;
     }

     public static function checkEmailExists($email) {
         $db = Db::getConnection();

         $sql = 'SELECT COUNT(*) FROM user WHERE email=:email';

         $result = $db->prepare($sql);
         $result->bindParam(':email', $email, PDO::PARAM_STR); //заменяем placeholder параметром $email для избежания проблем с безопасностью (например, sql иньекций)
         $result->execute();

         if ($result->fetchColumn()) {
             return true;
         }
         return false;
     }

     public static function checkUserData($email, $password) {
         $db = Db::getConnection();

         $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';

         $result = $db->prepare($sql);
         $result->bindParam(':email', $email, PDO::PARAM_STR);
         $result->bindParam(':password', $password, PDO::PARAM_STR);
         $result->execute();

         $user = $result->fetch();
         if ($user) {
             return $user['id'];
         }

         return false;
     }

    /**
     * запоминаем пользователя
     * @param $userId
     */
     public static function auth($userId) {

         $_SESSION['user'] = $userId;
     }

     public static function checkLogged() {

         // если сессия есть, вернем идентификатор пользователя
         if (isset($_SESSION['user'])) {
             return $_SESSION['user'];
         }

         header("Location: /user/login");
     }

     public static function isGuest() {

         if (isset($_SESSION['user'])) {
             return false;
         }

         return true;
     }

     public static function getUserById($id) {
         if ($id) {
             $db = Db::getConnection();
             $sql = 'SELECT *FROM user WHERE id = :id';

             $result = $db->prepare($sql);
             $result->bindParam(':id', $id, PDO::PARAM_STR);

             $result->setFetchMode(PDO::FETCH_ASSOC);
             $result->execute();

             return $result->fetch();
         }
     }

     public static function edit($id, $name, $password) {
         $db = Db::getConnection();

         $sql = "UPDATE user SET name = :name, password = :password WHERE id = :id";

         $result = $db->prepare($sql);
         $result->bindParam(':id', $id, PDO::PARAM_STR);
         $result->bindParam(':name', $name, PDO::PARAM_STR);
         $result->bindParam(':password', $password, PDO::PARAM_STR);
         return $result->execute();
     }
}