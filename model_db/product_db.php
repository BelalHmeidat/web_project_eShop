<?php
    include 'dbconfig.in.php';
    include 'product.php';
class ProductDB {
        public static $imagesPath = "./images"; //path to the images folder
        public static $defaultPhoto = "default.jpeg"; //default photo for students who don't have a photo set
        public static function createConnection() {
            DatabaseHelper::createConnection();
            // User::$idCounter = ProductDB::getMaxId() ?? User::$idCounter; //if there are no students in the database, the idCounter will have initial value
        }
        public static function getAllProducts() {
            // $connection = DatabaseHelper::createConnection();
            $sql = "SELECT S.id, S.name, S.description, S.category, S.price, S.amount, S.remarks FROM product S";
            $statement = DatabaseHelper::runQuery($sql, null);
            $students = array();
            while ($student = $statement->fetchObject('Product')) {
                $students[] = $student;
            }
            return $students;
            // return $statement->fetchAll(PDO::FETCH_CLASS, 'Student');
        }

        public static function getProduct($id){
            $sql = "SELECT S.id, S.name, S.description, S.category, S.price, S.amount, S.remarks FROM product S WHERE S.id = :id";
            $parameters = array(':id' => $id);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else
                return $statement->fetchObject('Product');
        }

        public static function updateProduct($id, $name, $description, $category, $price, $amount, $remarks){
            $sql = "UPDATE product SET name = :name, description = :description, category = :category, price = :price, amount = :amount, remarks = :remarks WHERE id = :id";
            $parameters = array(':id' => $id, ':name' => $name, ':description' => $description, ':category' => $category, ':price' => $price, ':amount' => $amount, ':remarks' => $remarks);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else return $statement->rowCount();
        }

        public static function getCategory() {
            $sql = "SELECT * FROM category";
            $statement = DatabaseHelper::runQuery($sql, null);
            // $departments = array();
            // while ($department = $statement->fetchObject('Department')) {
            //     $departments[] = $department;
            // }
            // return $departments;
            return $statement;
        }

        public static function getCatName($id) {
            $sql = "SELECT name from category WHERE id = :id";
            $parameters = array(':id' => $id);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else return $statement->fetch()['name'];
        }

        public static function addProduct($id, $name, $description, $category, $price, $amount, $remarks){
            $sql = "INSERT INTO product (id, name, description, category, price, amount, remarks) VALUES (:id, :name, :description, :category, :price, :amount, :remarks)";
            $parameters = array(':id' => $id, ':name' => $name, ':description' => $description, ':category' => $category, ':price' => $price, ':amount' => $amount, ':remarks' => $remarks);
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
            $sql = "DELETE FROM product WHERE id = :id";
            $parameters = array(':id' => $id);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else
                return $statement;
        }
    }