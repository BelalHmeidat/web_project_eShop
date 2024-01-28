<?php
    include '../models/user.php';
    include '../models/payment_info.php';

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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmation</title>
    <link rel="stylesheet" href="../styling/common_style.css">
</head>
<body>
<body>
        <h1>Confirm Your Information</h1>
        <form method="post" action="registration_complete.php">
        <fieldset>
            <legend>Personal Information</legend>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" pattern="[\u0600-\u06FF\u0750-\u077F A-Za-z]+" title="Only English and Arabic characters allowed" required value="<?php echo $user->getName() ?? ''?>" readonly>
            <br>
            <label for="houseNO">House Number</label>
            <input type="text" name="houseNO" id="houseNO" required value="<?php echo $user->getHouseNO() ?? '' ?>" readonly>
            <br>
            <label for="street">Street</label>
            <input type="text" name="street" id="street" required value="<?php echo $user->getStreet() ?? '' ?>" readonly>
            <br>
            <label for="city">City</label>
            <input type="text" name="city" id="city" pattern="[\u0600-\u06FF\u0750-\u077F A-Za-z]+" title="Only English and Arabic characters allowed" required value="<?php echo $user->getCity() ?? '' ?>" readonly>
            <br>
            <label for="country">Country</label>
            <input type="text" name="country" id="country" pattern="[\u0600-\u06FF\u0750-\u077F A-Za-z]+" title="Only English and Arabic characters allowed" required value="<?php echo $user->getCountry() ?? '' ?>" readonly>
            <br>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required value="<?php echo $user->getEmail() ?? '' ?>" readonly>
            <br>
            <label for="phone">Phone</label>
            <input type="tel" name="tel" id="tel" required value="<?php echo $user->getTel() ?? '' ?>" readonly>
            <br>
            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" id="dob" max="<?php echo date('Y-m-d') ?>" required value="<?php echo $user->getDob() ?? '' ?>" readonly>
            <br>
            <label for="identificationNO">Identification Number</label>
            <input type="text" name="identificationNO" id="identificationNO" required value="<?php echo $user->getIdentificationNO() ?? '' ?>" readonly>
            <br>
        </fieldset>
        <fieldset>
            <legend>Payment Information</legend>
            <label for="cardNO">Card Number</label>
            <input type="text" name="cardNO" id="cardNO" pattern="[0-9 -]+"  title="Only numbers, spaces, and hyphens allowed" required value="<?php echo $payment->getCreditCardNo() ?? '' ?>" readonly>
            <br>
            <label for="cardExpiration">Expiration Date</label>
            <input type="date" name="cardExpiration" id="cardExpiration"  min="<?php echo date('Y-m-d') ?>" required value="<?php echo $payment->getCardExpiration() ?? '' ?>" readonly>
            <br>
            <label for="holderName">Holder Name</label>
            <input type="text" name="holderName" id="holderName" pattern="[\u0600-\u06FF\u0750-\u077F A-Za-z]+" title="Only English and Arabic characters allowed" required value="<?php echo $payment->getHolderName() ?? '' ?>" readonly>
            <br>
            <label for="bank">Issuing Bank</label>
            <input type="text" name="bank" id="bank" pattern="[A-Za-z0-9]+" title="Only alphanumeric characters allowed" required value="<?php echo $payment->getBank() ?? '' ?>" readonly>
            <br>
        </fieldset>
        <fieldset>
            <legend>Account Information</legend>        
            <label for="username">Username:</label>
            <input type="text" name="username" id="username"required value="<?php echo $user->getUsername() ?? '' ?>" readonly>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required value="<?php echo $user->getPassword() ?? '' ?>" readonly>
            <br>
            <label for="password2">Confirm Password:</label>
            <input type="password" name="password2" id="password2" required value="<?php echo $user->getPassword() ?? '' ?>" readonly>
            <br>
        </fieldset>
        <!-- <button type="submit">Register</button> -->
        <input type="submit" value="confirm">
        <input type="button" value="back" onclick="window.location.href='../actions/register.php'"/>
        <br>
        <?php if(isset($errorMessage)) echo "<label style='color:red'>$errorMessage</label>" ?>
        </form>
</body>
</html>

