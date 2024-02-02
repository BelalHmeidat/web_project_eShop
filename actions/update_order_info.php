<? 
include '../models/user.php';
include '../model_db/user_db.php';

session_start();
    if (!isset($_SESSION["user"]) || !isset($_SESSION["mode"]) || $_SESSION["mode"] != 2){
        header("Location: ../error_pages/unauthorized_page.html");
    }
    if (!isset($_POST['id']) || !isset($_POST['status'])){
        header("Location: ../error_pages/error_page.html");
    }
    $id = $_POST['id'];
    $status = $_POST['status'];
    $shipping = $_POST['shipping'];
    if (empty($shipping) && $status == "shipped"){
        header("Location: ../error_pages/error_page.html");
    }
    if (empty($shipping)){
        $shipping = null;
    }
    if (!UserDB::setOrderInfo($id, $status, $shipping)){
        header("Location: ../error_pages/error_page.html");
    }
    header ("Location: ../web_pages/order_page.php?id=$id");