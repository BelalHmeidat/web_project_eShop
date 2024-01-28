<?php 

include 'dbconfig.in.php';
include 'student.php';

if (isset($_GET['id'])){

    $id = $_GET['id'];
    ProductDB::createConnection();
    $user = ProductDB::getProduct($id);
    if (isset($user)){
        $result = ProductDB::deleteProduct($id);
        if (isset($result)){
            echo "Student deleted successfully";
            header("Location: students.php"); //redirecting to students.php
        }
        else {
            echo "Error deleting student";
            echo "<a href='students.php'>Back to Students</a>";
        }
    }
    else {
        header("Location: not_found_page.php?id=$id");
    }
}
else {
    header("Location: provide_id_page.html");
}
