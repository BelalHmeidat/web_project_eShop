<?php 

include '../dbconfig.in.php';
include '../model_db/user_db.php';
include '../models/user.php';

session_start();

if (!isset($_SESSION['user'])){
    header("Location: ../error_pages/unauthorized_page.html");
    return;
}

if (!isset($_GET['id'])){ //product id
    header("Location: ../web_pages/provide_id_page.html");
    return;
}
$user = $_SESSION['user'];
$productId = $_GET['id']; 

if(!UserDB::deleteFromCart($user->getId(), $productId)){
    echo "Error deleting product from cart";
    echo "<a href='../web_pages/home.php?page=cart'>Back to Cart</a>";
    return;
}

header("Location: ../web_pages/home.php?page=cart");