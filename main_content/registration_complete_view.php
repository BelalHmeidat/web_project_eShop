<?php
    $user;
    $payment;
    if (isset($_SESSION["user"]) && isset($_SESSION["payment"])){
        $user = $_SESSION["user"];
        $payment = $_SESSION["payment"];
    }
    else {
        header("Location: ./error_pages/error_page.html.php");
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
        $id = UserDB::getUserByUsername($user->getUsername())->getId();
    }
    else {
        header("Location: ./error_pages/error_page.html.php");
        return;
    }
?>
<p>
    Registration Complete!
</p>
<p>
    Your ID is: <?php echo $id; ?>
<p>
    Click here to <a href="./index.php?page=login">login</a>!
</p>