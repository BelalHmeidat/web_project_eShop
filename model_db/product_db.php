<?php
    // include '../dbconfig.in.php';
    // include '../models/product.php';
class ProductDB {
        public static $imagesPath = "../images"; //path to the images folder
        public static $defaultPhoto = "default.jpeg"; //default photo for students who don't have a photo set
        private static function createConnection() {
            DatabaseHelper::createConnection();
            // User::$idCounter = ProductDB::getMaxId() ?? User::$idCounter; //if there are no students in the database, the idCounter will have initial value
        }
        public static function getAllProducts() {
            self::createConnection();
            $sql = "SELECT * FROM product";
            $statement = DatabaseHelper::runQuery($sql, null);
            $students = array();
            while ($student = $statement->fetchObject('Product')) {
                $students[] = $student;
            }
            return $students;
            // return $statement->fetchAll(PDO::FETCH_CLASS, 'Student');
        }

        public static function getProduct($id){
            self::createConnection();
            $sql = "SELECT * FROM product S WHERE S.id = :id";
            $parameters = array(':id' => $id);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else
                return $statement->fetchObject('Product');
        }

        public static function updateProduct($id, $name, $description, $category, $price, $amount, $remarks, $discount){
            self::createConnection();
            $sql = "UPDATE product SET name = :name, description = :description, category = :category, price = :price, amount = :amount, remarks = :remarks, discountPercent = :discount WHERE id = :id";
            $parameters = array(':id' => $id, ':name' => $name, ':description' => $description, ':category' => $category, ':price' => $price, ':amount' => $amount, ':remarks' => $remarks , ':discount' => $discount);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else return $statement->rowCount();
        }

        public static function searchProduct($name, $beginPrice, $endPrice){
            self::createConnection();
            // if(empty($beginPrice)){
            //     $beginPrice = 0; //if the begin price is empty, search from 0 and above
            // }
            if(empty($endPrice)){
                $endPrice = self::getMostExpensive() + 1; //if the end price is empty, search to the most expensive product
            }
            $name = "%" . $name . "%";
            $sql = "SELECT * FROM product WHERE name LIKE :name AND price BETWEEN :beginPrice AND :endPrice";
            $parameters = array(':name' => $name, ':beginPrice' => $beginPrice, ':endPrice' => $endPrice);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else return $statement->fetchAll(PDO::FETCH_CLASS, 'Product');
        }
        private static function getMostExpensive(){
            $sql = "SELECT MAX(price) FROM product";
            $statement = DatabaseHelper::runQuery($sql, null);
            return $statement->fetch()[0];
        }

        public static function getProductPhotos($id){
            self::createConnection();
            $sql = "SELECT name FROM productPhoto WHERE product = :id";
            $parameters = array(':id' => $id);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            $photos = array();
            while ($photo = $statement->fetch()) {
                $photos[] = $photo;
            }
            return $photos;
        }

        // public static function getCategory() {
        //     $sql = "SELECT * FROM category";
        //     $statement = DatabaseHelper::runQuery($sql, null);
        //     // $departments = array();
        //     // while ($department = $statement->fetchObject('Department')) {
        //     //     $departments[] = $department;
        //     // }
        //     // return $departments;
        //     return $statement;
        // }

        // public static function getCatName($id) {
        //     $sql = "SELECT name from category WHERE id = :id";
        //     $parameters = array(':id' => $id);
        //     $statement = DatabaseHelper::runQuery($sql, $parameters);
        //     if ($statement->rowCount() == 0)
        //         return null;
        //     else return $statement->fetch()['name'];
        // }

        public static function addProduct($name, $description, $category, $price, $amount, $remarks, $discount){
            self::createConnection();
            $sql = "INSERT INTO product (name, description, category, price, amount, remarks) VALUES (:name, :description, :category, :price, :amount, :remarks, :discount)";
            $parameters = array(':name' => $name, ':description' => $description, ':category' => $category, ':price' => $price, ':amount' => $amount, ':remarks' => $remarks, ':discount' => $discount);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else return $statement->rowCount();
        }            

        // public static function getMaxId(){
        //     $sql = "SELECT MAX(stdId) FROM Student";
        //     $statement = DatabaseHelper::runQuery($sql, null);
        //     return $statement->fetch()[0];
        // }

        public static function deleteProduct($id){
            self::createConnection();
            $sql = "DELETE FROM product WHERE id = :id";
            $parameters = array(':id' => $id);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else
                return $statement;
        }

        public static function getNewProducts(){
            self::createConnection();
            $sql = "SELECT * FROM product ORDER BY id DESC LIMIT 3";
            $statement = DatabaseHelper::runQuery($sql, null);
            $products = array();
            while ($product = $statement->fetchObject('Product')) {
                $products[] = $product;
            }
            return $products;
        }

        public static function getDiscountedProducts(){
            self::createConnection();
            $sql = "SELECT * FROM product WHERE discountPercent > 0 ORDER BY id DESC LIMIT 3";
            $statement = DatabaseHelper::runQuery($sql, null);
            $products = array();
            while ($product = $statement->fetchObject('Product')) {
                $products[] = $product;
            }
            return $products;
        }
    }