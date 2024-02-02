<?php
    include '../models/user.php';
    include '../model_db/user_db.php';
    include '../models/payment_info.php';
    include '../model_db/payment_info_db.php';

    session_start();

    $user = null;
    if (isset($_SESSION["user"])){
        $user = $_SESSION["user"];
    }
    else {
        $user = new User();
    }

    $payment = null;
    if (isset($_SESSION["payment"])){
        $payment = $_SESSION["payment"];
    }
    else {
        $payment = new PaymentInfo();
    }

    $errorMessage;

    function checkAllFields(){ //checks fields are not empty then checks if unique fields are unique. This order is important
        global $errorMessage, $user, $payment;

        if(!isset($_POST['name']) || empty($_POST['name'])) return false;
        $user->setName($_POST['name']);

        if(!isset($_POST['identificationNO']) && !empty($_POST['identificationNO'])) return false;
        $user->setIdentificationNO($_POST['identificationNO']);

        if(!isset($_POST['dob']) || empty($_POST['dob'])) return false;
        $user->setDob($_POST['dob']);

        if(!isset($_POST['houseNO']) || empty($_POST['houseNO'])) return false;
        $user->setHouseNO($_POST['houseNO']);

        if(!isset($_POST['street']) || empty($_POST['street'])) return false;
        $user->setStreet($_POST['street']);

        if(!isset($_POST['city']) || empty($_POST['city'])) return false;
        $user->setCity($_POST['city']);

        if(!isset($_POST['country']) || empty($_POST['country'])) return false;
        $user->setCountry($_POST['country']);

        if(!isset($_POST['tel']) || empty($_POST['tel'])) return false;
        $user->setTel($_POST['tel']);

        if(!isset($_POST['email']) || empty($_POST['email'])) return false;
        $user->setEmail($_POST['email']);

        if (!isset($_POST["cardNO"]) || empty($_POST["cardNO"])) return false;

        $payment = new PaymentInfo();
        $payment->setCreditCardNo(formatCardNo($_POST["cardNO"]));
        $payment->setCardExpiration($_POST["cardExpiration"]);
        $payment->setHolderName($_POST["holderName"]);
        $payment->setBank($_POST["bank"]);

        $_SESSION["user"] = $user;
        $_SESSION["payment"] = $payment;

        if (!UserDB::identificationUnique($user->getIdentificationNO())){
            $errorMessage = "Identification number already exists!";
            return false;
        }

        if (!UserDB::telUnique($user->getTel())){
            $errorMessage = "Telephone number already exists!";
            return false;
        }
        if (!UserDB::emailUnique($user->getEmail())){
            $errorMessage = "Email already exists!";
            return false;
        }

        if (strlen(formatCardNo($_POST["cardNO"])) != 16){
            $errorMessage = "Card number must be 16 digits!";
            return false;
        }

        return true;
    }

    
    if(checkAllFields()){
        header("Location: ../actions/register2.php"); 
    }

    function formatCardNo($cardNo){
        $cardNo = str_replace('-', '', $cardNo);
        $cardNo = str_replace(' ', '', $cardNo);
        return $cardNo;
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="../styling/common_style.css">
    </head>
    <body>
        <h1>Register</h1>
        <h2>Enter your information</h2>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <fieldset>
            <legend>Personal Information</legend>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" pattern="[\u0600-\u06FF\u0750-\u077F A-Za-z]+" title="Only English and Arabic characters allowed" required value="<?php echo $user->getName() ?? ''?>">
            <br>
            <label for="houseNO">House Number</label>
            <input type="text" name="houseNO" id="houseNO" required value="<?php echo $user->getHouseNO() ?? '' ?>">
            <br>
            <label for="street">Street</label>
            <input type="text" name="street" id="street" required value="<?php echo $user->getStreet() ?? '' ?>">
            <br>
            <label for="city">City</label>
            <input type="text" name="city" id="city" pattern="[\u0600-\u06FF\u0750-\u077F A-Za-z]+" title="Only English and Arabic characters allowed" required value="<?php echo $user->getCity() ?? '' ?>">
            <br>
            <label for="country">Country</label>
            <input type="text" name="country" id="country" pattern="[\u0600-\u06FF\u0750-\u077F A-Za-z]+" title="Only English and Arabic characters allowed" required value="<?php echo $user->getCountry() ?? '' ?>">
            <br>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required value="<?php echo $user->getEmail() ?? '' ?>">
            <br>
            <label for="phone">Phone</label>
            <input type="tel" name="tel" id="tel" required value="<?php echo $user->getTel() ?? '' ?>">
            <br>
            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" id="dob" max="<?php echo date('Y-m-d') ?>" required value="<?php echo $user->getDob() ?? '' ?>">
            <br>
            <label for="identificationNO">Identification Number</label>
            <input type="text" name="identificationNO" id="identificationNO" required value="<?php echo $user->getIdentificationNO() ?? '' ?>">
            <br>
        </fieldset>
        <fieldset>
            <legend>Payment Information</legend>
            <label for="cardNO">Card Number</label>
            <input type="text" name="cardNO" id="cardNO" pattern="[0-9 -]+"  title="Only numbers, spaces, and hyphens allowed" required value="<?php echo $payment->getCreditCardNo() ?? '' ?>">
            <br>
            <label for="cardExpiration">Expiration Date</label>
            <input type="date" name="cardExpiration" id="cardExpiration"  min="<?php echo date('Y-m-d') ?>" required value="<?php echo $payment->getCardExpiration() ?? '' ?>">
            <br>
            <label for="holderName">Holder Name</label>
            <input type="text" name="holderName" id="holderName" pattern="[\u0600-\u06FF\u0750-\u077F A-Za-z]+" title="Only English and Arabic characters allowed" required value="<?php echo $payment->getHolderName() ?? '' ?>">
            <br>
            <label for="bank">Issuing Bank</label>
            <input type="text" name="bank" id="bank" pattern="[a-zA-Z0-9 ]*"" title="Only alphanumeric characters allowed" required value="<?php echo $payment->getBank() ?? '' ?>">
            <br>
        </fieldset>
        <!-- <button type="submit">Register</button> -->
        <input type="submit" value="continue">
        <input type="button" value="back" onclick="window.location.href='../web_pages/home.php?page=login'"/>
        <br>
        <?php if(isset($errorMessage)) echo "<label style='color:red'>$errorMessage</label>" ?>
        </form>
    </body>
    </html>
