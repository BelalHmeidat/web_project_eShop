<?php 
    include './models/user.php';
    include './models/product.php';
    include './model_db/user_db.php';
    include './model_db/product_db.php';
    include './model_db/category_db.php';
    include './dbconfig.in.php';
    include './models/payment_info.php';
    include './model_db/payment_info_db.php';

   session_start();
   $user;
   $mode = 0; // guest 1: customer 2: manager

   if (isset($_SESSION["user"])){
       $user = $_SESSION["user"];
    //    $payment = PaymentDB::getPaymentByNO($user->getPayment());
    //    $_SESSION["payment"] = $payment;
       $mode = 1;
       if (UserDB::isManager($user->getUsername())){
            $mode = 2;
       }
   }
   $_SESSION["mode"] = $mode;
   $page = "start";
   if (isset($_GET['page'])){
         $page = $_GET['page'];
    }

?>


<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="./styling/common_style.css">
</head>


<body>
    <header>
            <div class='logo-title'>
                <img class='logo' src="./images/Store_Logo.jpg" alt="Store Logo">
                <a class="title" href="./index.php">Belal Antique Store</a></div>
            </div>
            <nav>
            <a href="./index.php?=about">About Us</a>
            <?php if($mode == 1){?>
                <a href="./index.php?page=cart">Cart</a>
            <?php }?>
            <?php if($mode == 1 || $mode == 2) {?>
                <a href="./actions/logout.php">Logout</a>
            <?php } else if($mode == 0) {?>
                <a href="./index.php?page=login">Login</a>
                <a href="./index.php?page=register">Register</a>
            <?php }?>
            </nav>
    </header>
    <div class='nav-main'>
    <nav>
        <?php
        if ($mode == 0){
            include './navigation/guest_nav.php';
        }
        else if ($mode == 1){
            include './navigation/customer_nav.php';
        }
        else if ($mode == 2){
            include './navigation/employee_nav.php';
        }
        ?>
    </nav>
    <main>
        <?php
        if ($page == "search"){
            include './main_content/search_view.php';
        }
        else if ($page == "cart"){
            include './main_content/cart_view.php';
        }
        else if ($page == "product"){
            include './main_content/product_view.php';
        }
        else if ($page == "login"){
            include './main_content/login_view.php';
        }
        else if ($page == "register"){
            include './main_content/register_view.php';
        }
        else if ($page == "register2"){
            include './main_content/register2_view.php';
        }
        else if ($page == "confirmation"){
            include './main_content/confirmation_view.php';
        }
        else if ($page == 'registrationComp'){
            include './main_content/registration_complete_view.php';
        }
        else if ($page == "checkout"){
            include './main_content/checkout_view.php';
        }
        else if ($page == 'placeOrder'){
            include './main_content/place_order_view.php';
        }
        else if ($page == 'pastOrders'){
            include './main_content/past_orders_view.php';
        }
        else if ($page == 'addProduct'){
            include './main_content/add_product_view.php';
        }
        else if ($page == 'about'){
            include './main_content/about_view.php';
        }
        else if ($page == 'contact'){
            include './main_content/contact_view.php';
        }
        else {
            include './main_content/start_view.php';
        }
        ?>
    </main>
    </div>
    <footer>
        <div>
            <img src="./images/Store_Logo.jpg" alt="Store Logo" width="100" height="100">
            <p>&copy; <?php echo date("Y"); ?> Belal Antique Store</p>
        </div>
        <div>
            <address>
            Email: <a href="mailto:dontemail@email.com">dontemail@email.com</a><br>
            Location:<br>
            123 King Faisal St.<br>
            Hebron<br>
            Palestine
            </address>
            <p>Phone: 222-222-2222</p>
        </div>
        <div>
            <h2>Links:</h2>
            <ul>
                <li><a href="./index.php?page=about">About Us</a></li>
                <li><a href="./index.php?page=contact">Contact Us</a></li>
            </ul>
        </div>
    </footer>

</body>
</html>