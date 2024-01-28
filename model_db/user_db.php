<?php
    include '../dbconfig.in.php';
    // include '../models/user.php';
class UserDB {
        private static function createConnection() {
            DatabaseHelper::createConnection();
            // User::$idCounter = ProductDB::getMaxId() ?? User::$idCounter; //if there are no students in the database, the idCounter will have initial value
        }
        public static function getAllUsers() {
            self::createConnection();
            // $connection = DatabaseHelper::createConnection();
            $sql = "SELECT * FROM user";
            $statement = DatabaseHelper::runQuery($sql, null);
            $students = array();
            while ($student = $statement->fetchObject('Product')) {
                $students[] = $student;
            }
            return $students;
            // return $statement->fetchAll(PDO::FETCH_CLASS, 'Student');
        }

        public static function getUser($id){
            self::createConnection();
            $sql = "SELECT * FROM user WHERE id = :id";
            $parameters = array(':id' => $id);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else
                return $statement->fetchObject('User');
        }

        public static function getUserByUsername($username){
            self::createConnection();
            $sql = "SELECT * FROM user WHERE username = :username";
            $parameters = array(':username' => $username);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else
                return $statement->fetchObject('User');
        }

        public static function updateUser($id, $name, $houseNO, $street, $city, $country, $tel, $email, $dob, $payment, $identificationNO, $password, $username){
            self::createConnection();
            $sql = "UPDATE user SET name = :name, houseNO = :houseNO, street = :street, city = :city, country = :country, tel = :tel, email = :email, dob = :dob, payment = :payment, identificationNO = :identificationNO, password = :password, username = :username WHERE id = :id";
            $parameters = array(':id' => $id, ':name' => $name, ':houseNO' => $houseNO, ':street' => $street, ':city' => $city, ':country' => $country, ':tel' => $tel, ':email' => $email, ':dob' => $dob, ':payment' => $payment, ':identificationNO' => $identificationNO, ':password' => $password, ':username' => $username);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else return $statement->rowCount();
        }

        public static function addUser($name, $houseNO, $street, $city, $country, $tel, $email, $dob, $payment, $identificationNO, $password, $username){
            self::createConnection();
            $sql = "INSERT INTO user (name, houseNO, street, city, country, tel, email, dob, payment, identificationNO, password, username) VALUES (:name, :houseNO, :street, :city, :country, :tel, :email, :dob, :payment, :identificationNO, :password, :username)";
            $parameters = array(':name' => $name, ':houseNO' => $houseNO, ':street' => $street, ':city' => $city, ':country' => $country, ':tel' => $tel, ':email' => $email, ':dob' => $dob, ':payment' => $payment, ':identificationNO' => $identificationNO, ':password' => $password, ':username' => $username);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else return $statement->rowCount();
        }

        public static function isManager($username){
            self::createConnection();
            $sql = "SELECT * FROM manager WHERE username = :username";
            $parameters = array(':username' => $username);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return false;
            else if ($statement->rowCount() == 1)
                return true;
        }

        public static function deleteUser($id){
            self::createConnection();
            $sql = "DELETE FROM user WHERE id = :id";
            $parameters = array(':id' => $id);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else
                return $statement;
        }

        public static function usernameUnique($username){
            self::createConnection();
            $sql = "SELECT * FROM user WHERE username = :username";
            $parameters = array(':username' => $username);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return true;
            else
                return false;
        }

        public static function identificationUnique($identificationNO){
            self::createConnection();
            $sql = "SELECT * FROM user WHERE identificationNO = :identificationNO";
            $parameters = array(':identificationNO' => $identificationNO);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return true;
            else
                return false;
        }

        public static function emailUnique($email){
            self::createConnection();
            $sql = "SELECT * FROM user WHERE email = :email";
            $parameters = array(':email' => $email);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return true;
            else
                return false;
        }

        public static function telUnique($tel){
            self::createConnection();
            $sql = "SELECT * FROM user WHERE tel = :tel";
            $parameters = array(':tel' => $tel);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return true;
            else
                return false;
        } 

        public static function passwordCorrect($username, $password){
            self::createConnection();
            $sql = "SELECT * FROM user WHERE username = :username AND password = :password";
            $parameters = array(':password' => $password, ':username' => $username);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 1)
                return true;
            else
                return false;
        }
    }