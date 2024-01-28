<?php
    // include '../dbconfig.in.php'; 
    // include '../models/payment_info.php';
    class paymentDB {
        // public static function getAllPaymentInfo() {
        //     $sql = "SELECT * FROM paymentInfo";
        //     $statement = DatabaseHelper::runQuery($sql, null);
        //     // $departments = array();
        //     // while ($department = $statement->fetchObject('Department')) {
        //     //     $departments[] = $department;
        //     // }
        //     // return $departments;
        //     return $statement;
        // }

        private static function createConnection() {
            DatabaseHelper::createConnection();
        }

        public static function getPaymentByNO($NO) {
            self::createConnection();
            $sql = "SELECT * FROM paymentInfo WHERE creditCardNo = :NO";
            $parameters = array(':NO' => $NO);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            // if ($statement->rowCount() == 0)
            //     return null;
            // else
             return $statement->fetchObject('PaymentInfo');
        }

        public static function addPaymentInfo($paymentInfo) {
            self::createConnection();
            $sql = "INSERT INTO paymentInfo (creditCardNo, cardExpiration, holderName, bank) Values (:creditCardNo, :cardExpiration, :holderName, :bank)";
            $parameters = array(':creditCardNo' => $paymentInfo->getCreditCardNo(), ':cardExpiration' => $paymentInfo->getCardExpiration(), ':holderName' => $paymentInfo->getHolderName(), ':bank' => $paymentInfo->getBank());
            return DatabaseHelper::runQuery($sql, $parameters);
        }

        public static function deletePaymentInfo($NO) {
            self::createConnection();
            $sql = "DELETE FROM paymentInfo WHERE creditCardNo = :NO";
            $parameters = array(':NO' => $NO);
            return DatabaseHelper::runQuery($sql, $parameters);
        }

        public static function cardExist($cardNo) {
            self::createConnection();
            $sql = "SELECT * FROM paymentInfo WHERE creditCardNo = :cardNo";
            $parameters = array(':cardNo' => $cardNo);
            $statement = DatabaseHelper::runQuery($sql, $parameters);
            if ($statement->rowCount() == 0)
                return false;
            else
                return true;
        }

    }