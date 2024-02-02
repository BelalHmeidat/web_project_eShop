<?php
$errorMessage = "";

if (!isset($_SESSION["user"]) || !isset($_SESSION["payment"])){
    session_destroy(); //reset session data if user or payment is not set
    header("Location: ./error_pages/unauthorized_page.html");
    return;
}
$user = $_SESSION["user"];
$payment = $_SESSION["payment"];


function checkAllFields(){
    global $errorMessage, $user, $payment;

    if (!isset($_POST["username"]) || empty($_POST["username"])) return false;
    $user->setUsername($_POST["username"]);

    if (!isset($_POST["password"]) || empty($_POST["password"])) return false;
    $user->setPassword($_POST["password"]);
    if (!isset($_POST['password2']) || $_POST["password"] != $_POST["password2"]){
        $errorMessage = "Passwords do not match!";
        return false;
    }
    if (!UserDB::usernameUnique($user->getUsername())){
        $errorMessage = "Username already exists!";
        return false;
    }
    $user->setPayment($payment->getCreditCardNo());

    return true;
}

if (checkAllFields()){
    $_SESSION["user"] = $user;
    header("Location: ./index.php?page=confirmation");
}

?>

<form method="post" action="./index.php?page=register2">
    <fieldset>
        <legend>Account Information</legend>        
    <label for="username">Username:</label>
    <input type="text" name="username" id="username"required value="<?php echo $user->getUsername() ?? '' ?>" minlength="6" maxlength="13">
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required value="<?php echo $user->getPassword() ?? '' ?>" minlength="8" maxlength="12">
    <br>
    <label for="password2">Confirm Password:</label>
    <input type="password" name="password2" id="password2" required value="<?php echo $user->getPassword() ?? '' ?>" minlength="8" maxlength="12">
    <br>
    </fieldset>
    <input type="submit" value="Complete Registration">
    <a href="./index.php?page=register"><button type="button" formnovalidate>Back</button></a>
    <br>
    <?php if(isset($errorMessage)) echo "<label style='color:red'>$errorMessage</label>" ?>
</form>

