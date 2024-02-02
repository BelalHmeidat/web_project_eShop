<?php
include '../dbconfig.in.php';
include '../model_db/user_db.php';
include '../model_db/product_db.php';
include '../models/user.php';

session_start();
if (!isset($_SESSION["user"]) || !isset($_SESSION["mode"])){
    header("Location: ./error_pages/unauthorized_page.html");
    return;
}
if (!isset($_GET['id'])){
    header("Location: ../error_pages/error_page.html");
    return;
}
$user = $_SESSION["user"];
$orderId = $_GET['id'];

$mode = $_SESSION["mode"];

if ($mode == 1){//customer
    $order = UserDB::getOrder($user->getId(), $orderId);
    if(!isset($order)){
        header("Location: ../error_pages/unauthorized_page.html");
        return;
    }
}
else if ($mode == 2){
    $order = UserDB::getOrderForEmployee($orderId);
    if(!isset($order)){
        header("Location: ../error_pages/unauthorized_page.html");
        return;
    }
    $status; $shipping;
    if (isset($_POST['status'])){
        $status = $_POST['status'];
    }
    if (isset($_POST['shipping'])){
        $shipping = $_POST['shipping'];
    }
    // if (empty($shipping) && $status == "shipped"){
    //     header("Location: ../error_pages/error_page.html");
    // }
    if (empty($shipping) || !isset($shipping)){
        $shipping = null;
    }
    if (isset($status)){
        UserDB::setOrderInfo($orderId, $status, $shipping);
    }

}
else { //guest or wrong mode number
    header("Location: ../error_pages/unauthorized_page.html");
    return;

}

$items = ProductDB::getOrderItems($orderId);
if (!isset($order) || !isset($items)){
    header("Location: ../error_pages/error_page.html");
    return;
}

$totalPrice = $order['total'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Order Details</title>
        <link rel="stylesheet" type="text/css" href="../styling/common_style.css">
    </head>
    <body>
        <h1>Order Details</h1>
        <div class='centered-table'>
            <fieldset class='centered-table'>
                <table>
                    <tr>
                        <th>Reference No.</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                    <?php foreach ($items as $product){ ?>
                    <tr>
                        <td><a href="../index.php?page=product&id=<?php echo $product['id'];?>"><?php echo $product['id'];?></a></td>
                        <td><?php echo $product['name'];?></td>
                        <td><?php echo $product['price'];?></td>
                        <td><?php echo $product['quantity']?></td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td colspan="2">Total</td>
                        <td colspan="2"><?php echo $totalPrice?></td>
                    </tr>
                </table>
                <?php if ($mode == 2){
                    $disabled; $required?>
                    <form action="../web_pages/order_page.php?id=<?php echo $orderId?>" method="POST">
                    <label for='shipping'>Shipping Date: </label>
                    <?php if ($order['status'] == "waiting"){
                        $status = 'In Processing';
                        $disabled = 'disabled';
                        $required = '';
                        $btDisabled = '';
                    }
                    else if ($order['status'] == "In Processing"){
                        $status = 'shipped';
                        $disabled = '';
                        $required = 'required';
                        $btDisabled = '';
                    } else if ($order['status'] == "Shipped"){
                        $status = 'N/A';
                        $shipping = $order['shippingDate'];
                        $disabled = " disabled";
                        $required = '';
                        $btDisabled = "disabled";
                    }
                        ?>
                    <input type="date" name="shipping" value="<?php echo $shipping?? ""?>"<?php echo $disabled?> <?php $required?>>
                    <input type="hidden" name="status" value="<?php echo $status?>">
                    <input type="submit" value="Set to <?php echo $status?>" <?php echo $btDisabled?>>
                </form>
                <?php }?>
            </fieldset>
        </div>
    </body>
</html>