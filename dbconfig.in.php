<?php 
    class DatabaseHelper {
        public static $connectionStr = "mysql:host=127.0.0.1;dbname=souvenir_store";
        public static $user = "root";
        public static $password = "*fsnjSGSE0eEhSU6";

        private static $connection = null;

         public static function createConnection() {
            self::$connection = new PDO(
                DatabaseHelper::$connectionStr,
                DatabaseHelper::$user,
                DatabaseHelper::$password
            );
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // return self::$connection;
         }

         public static function endConnection() {
            self::$connection = null;
         }

         public static function runQuery($sql, $parameters = null) {
            if (isset($parameters) && !empty($parameters)) {
                $statement = self::$connection->prepare($sql);
                $executedOk = $statement->execute($parameters);
                if (! $executedOk) {
                    throw new PDOException;
                }
                return $statement;
            }
            else {
                $statement = self::$connection->query($sql);
                return $statement;
            }
         }
    }