<?php
    include 'dbconfig.in.php';

class CategoryDB {


    public static function createConnection() {
        DatabaseHelper::createConnection();
        // User::$idCounter = ProductDB::getMaxId() ?? User::$idCounter; //if there are no students in the database, the idCounter will have initial value
    }

    public static function getAllCategories() {
        // $connection = DatabaseHelper::createConnection();
        $sql = "SELECT * FROM category";
        $statement = DatabaseHelper::runQuery($sql, null);
        $catagories = array();
        while ($category = $statement->fetch()) {
            $catagories[] = $category;
        }
        return $catagories;
        // return $statement->fetchAll(PDO::FETCH_CLASS, 'Student');
    }

    public static function getCategory($id){
        $sql = "SELECT * FROM category WHERE id = :id";
        $parameters = array(':id' => $id);
        $statement = DatabaseHelper::runQuery($sql, $parameters);
        if ($statement->rowCount() == 0)
            return null;
        else
            return $statement->fetch()["name"];
    }

    public static function updateCategory($id, $name){
        $sql = "UPDATE category SET name = :name WHERE id = :id";
        $parameters = array(':id' => $id, ':name' => $name);
        $statement = DatabaseHelper::runQuery($sql, $parameters);
        if ($statement->rowCount() == 0)
            return null;
        else return $statement->rowCount();
    }

    public static function addCategory($id, $name){
        $sql = "INSERT INTO category (id, name) VALUES (:id, :name)";
        $parameters = array(':id' => $id, ':name' => $name);
        $statement = DatabaseHelper::runQuery($sql, $parameters);
        if ($statement->rowCount() == 0)
            return null;
        else return $statement->rowCount();
    }


    public static function deleteCategory($id){
        $sql = "DELETE FROM category WHERE id = :id";
        $parameters = array(':id' => $id);
        $statement = DatabaseHelper::runQuery($sql, $parameters);
        if ($statement->rowCount() == 0)
            return null;
        else
            return $statement;
    }


}