<?php
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

        public static function updateProductQuantityInCart($userID, $productID, $quantity){
            self::createConnection();
            if (!self::alreadyInCart($userID, $productID)) return false;
            $sql = "UPDATE cart SET quantity = :quantity WHERE userId = :userId AND productId = :productId";
            $parameters = array(':userId' => $userID, ':productId' => $productID, ':quantity' => $quantity);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return false;
            else
                return true;
        }

        public static function addOneToCart($userID, $productID){ //called when the user clicks the add to cart button from the product page
            self::createConnection();
            if (self::alreadyInCart($userID, $productID)){
                $sql = "UPDATE cart SET quantity = quantity + 1 WHERE userId = :userId AND productId = :productId";
            }
            else {
                $sql = "INSERT INTO cart (userId, productId, quantity) VALUES (:userId, :productId, 1)";
            }
            $parameters = array(':userId' => $userID, ':productId' => $productID);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return false;
            else
                return true;
        }

        private static function alreadyInCart($userID, $productID){
            $sql = "SELECT * FROM cart WHERE userId = :userId AND productId = :productId";
            $parameters = array(':userId' => $userID, ':productId' => $productID);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return false;
            else
                return true;
        }

        public static function deleteFromCart($userID, $productID){
            self::createConnection();
            $sql = "DELETE FROM cart WHERE userId = :userId AND productId = :productId";
            $parameters = array(':userId' => $userID, ':productId' => $productID);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return false;
            else
                return true;
        }

        public static function getCart($id){
            self::createConnection();
            $sql = "SELECT productId, quantity FROM cart WHERE userId = :id";
            $parameters = array(':id' => $id);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            $products = array();
            while ($product = $statement->fetch()) {
                $products[] = $product;
            }
            if (empty($products))
                return null;
            else
                return $products;
        }

        public static function getCartTotal($id){
            self::createConnection();
            $sql = "SELECT SUM(price * quantity) FROM cart JOIN product ON cart.productId = product.id WHERE userId = :id";
            $parameters = array(':id' => $id);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            return $statement->fetch()[0];
        }

        public static function placeAnOrder($userId, $date, $total){
            self::createConnection();
            $sql = "INSERT INTO userOrderTb (userId, status, date, total) VALUES (:userId, 'waiting', :date, :total)";
            $parameters = array(':userId' => $userId, ':date' => $date, ':total' => $total);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else {
                $sql = "SELECT id FROM userOrderTb WHERE userId = :userId AND date = :date AND total = :total AND status = 'waiting'";
                $parameters = array(':userId' => $userId, ':date' => $date, ':total' => $total);
                $statement = DatabaseHelper::runQuery($sql, $parameters);
                return $statement->fetch()[0];
            }
        }

        public static function addProductToOrder($productId, $orderId, $quantity){
            self::createConnection();
            $sql = "INSERT INTO productOrderTb (productId, orderId, quantity) VALUES (:productId, :orderId, :quantity)";
            $parameters = array(':productId' => $productId, ':orderId' => $orderId, ':quantity' => $quantity);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return false;
            else return true;
        }

        public static function getOrder($id){
            self::createConnection();
            $sql = "SELECT * FROM userOrderTb WHERE id = :id";
            $parameters = array(':id' => $id);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return null;
            else
                return $statement->fetch();
        }

        public static function getOrderItems($id){
            self::createConnection();
            $sql = "SELECT * FROM productOrderTb JOIN product ON productOrderTb.productId = product.id WHERE orderId = :id";
            $parameters = array(':id' => $id);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            $products = array();
            while ($product = $statement->fetch()) {
                $products[] = $product;
            }
            if (empty($products))
                return null;
            else
                return $products;
        }

        public static function emptyCart($id){
            self::createConnection();
            $sql = "DELETE FROM cart WHERE userId = :id";
            $parameters = array(':id' => $id);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return false;
            else
                return true;
        }
    }