<?php
session_start(); 
$user;
if (isset($_SESSION["user"])){
    $user = $_SESSION["user"];
    session_destroy();
    header("Location: ../index.php");
}
else {
    header("Location: ../error_pages/unauthorized_page.html");
    return;
}