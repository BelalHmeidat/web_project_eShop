<?php

    if (isset($_SESSION["user"])){
        $user = $_SESSION["user"];
        header("Location: ../web_pages/home.php");
        return;
    }

    $errorMessage;
    function checkCredentials(){
        global $errorMessage;
        if (!isset($_POST["username"]) || empty($_POST["username"])){
            return false;
        }
        $_SESSION["username"] = $_POST["username"];
        if (!isset($_POST["password"]) || empty($_POST["password"])){
            return false;
        }
        $_SESSION["password"] = $_POST["password"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        if (UserDB::usernameUnique($username)){ //reusing the function used to check if the username is unique in register2.php
            $errorMessage = "Username does not exist!";
            return false;
        }

        if (!UserDB::passwordCorrect($username, $password)){
            $errorMessage = "Password is incorrect!";
            return false;
        }

        $user = UserDB::getUserByUsername($username);

        if (isset($user)){
            $_SESSION["user"] = $user;
        }
        else {
            $errorMessage = "Error fetching user data!";
            return false;
        }

        return true;

    }

    if (checkCredentials()){
        header("Location: ../web_pages/home.php");
    }
    else {
        session_destroy();
    }

?>
    <h1 class='login'>Login</h1>
    <h2 class='login'>Enter your username and password</h2>
<main>
<form action="../web_pages/home.php?page=login" method="post">
    <fieldset>
        <legend>Login Information</legend>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Login">
    </fieldset>
    <?php if(isset($errorMessage)) echo "<label style='color:red'>$errorMessage</label>" ?>
</form>
<p>
    Don't have an account? <a href="register.php">Register</a>
</p>
<p>
    <a href="catalog.php">Continue as guest</a>
</p>
</main>
<footer>
    <a href="admin_login.php">Admin Login</a>
</footer>


