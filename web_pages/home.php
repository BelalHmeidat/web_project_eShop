<?php 
    include '../models/user.php';
    include '../model_db/user_db.php';

   session_start();
   $user;
   $mode = 0; // guest 1: customer 2: manager

   if (isset($_SESSION["user"])){
       $user = $_SESSION["user"];
       $mode = 1;
       if (UserDB::isManager($user->username)){
            $mode = 2;
       }
   }

?>


<!DOCTYPE html>
<html>
<head>
    <title>Catalog</title>
</head>


<body>
    <header>
        <img src="../images/Store_Logo.jpg" alt="Store Logo" width="40" height="40">
        <h1><a href="<?php $_SERVER['PHP_SELF']?>">Belal Antique Store</a></h1>
        <h2><a href="./about_us.php">About Us</a></h2>
        <?php if($mode == 1 || $mode == 2) {?>
            <h2><a href="./profile.php">Catalog</a></h2>
            <h2><a href="../actions/logout.php">Logout</a></h2> 
        <?php }?>
        <?php if($mode == 1){?>
            <h2><a href="./cart.php">Cart</a></h2>
        <?php } else if($mode == 0) {?>
            <h2><a href="./login.php">Login</a></h2>
            <h2><a href="./register.php">Register</a></h2>
        <?php }?>
    </header>
    <nav>
        <?php
        if ($mode == 0){
            include '../navigation/guest_nav.php';
        }
        else if ($mode == 1){
            include '../navigation/customer_nav.php';
        }
        else if ($mode == 2){
            include '../navigation/manager_nav.php';
        }
        ?>
    </nav>
    <main>
    </main>
    <footer>
    </footer>

</body>
</html>