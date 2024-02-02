<?php
session_start(); 
$user;
if (isset($_SESSION["user"])){
    $user = $_SESSION["user"];
    session_destroy();
    header("Location: ../web_pages/home.php");
}
else {
    header("Location: ../web_pages/unauthorized_page.html");
    return;
}