<?php

    include '../models/user.php';
    include '../model_db/user_db.php';
    include '../models/payment_info.php';
    include '../model_db/payment_info_db.php';

    session_start();
    $user;
    $payment;
    if (isset($_SESSION["user"]) && isset($_SESSION["payment"])){
        $user = $_SESSION["user"];
        $payment = $_SESSION["payment"];
    }
    else {
        header("Location: ./error_page.html.php");
        return;
    }

    function checkAddingUser(){
        global $user, $payment;
        if (paymentDB::cardExist($payment->getCreditCardNo())){
            $payment = paymentDB::getPaymentByNO($payment->getCreditCardNo());
        }
        else if (!paymentDB::addPaymentInfo($payment)){
            return false;
        }
        if(UserDB::addUser(
            name: $user->getName(),
            dob: $user->getDob(),
            houseNO: $user->getHouseNO(),
            street: $user->getStreet(),
            city: $user->getCity(),
            country: $user->getCountry(),
            tel: $user->getTel(),
            email: $user->getEmail(),
            payment: $payment->getCreditCardNo(),
            identificationNO: $user->getIdentificationNO(),
            password: $user->getPassword(),
            username: $user->getUsername()
            ) == 0){
            return false;
        }
        return true;
    }

    if (checkAddingUser()){
        session_destroy();
        $id = UserDB::getUserByUsername($user->getUsername())->getUserId();
    }
    else {
        header("Location: ./error_page.html.php");
        return;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration Complete</title>
    <link rel="stylesheet" href="../styling/common_style.css">
</head>
<body>
    <p>
        Registration Complete!
    </p>
    <p>
        Your ID is: <?php echo $id; ?>
    <p>
        Click here to <a href="../actions/login.php">login</a>!
    </p>
</body>