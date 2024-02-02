<?php
// if (!isset($_SESSION['user']) || !isset($_GET['total'])){
//     header("Location: ../web_pages/error_page.html");
//     return;
// }
// if ((!isset($_SESSION['cartItems']) || empty($_SESSION['$cartItems']))){
//     header("Location: ../web_pages/error_page.html");
//     return;
// }
$userId = $_SESSION['user']->getId();
$total = $_GET['total'];
$cartItems = $_SESSION['cartItems'];
$datetime = date("Y-m-d H:i:s");

$orderId = UserDB::placeAnOrder($userId, $datetime, $total);
if (!isset($orderId)){
    header("Location: ../web_pages/error_page.html");
    return;
}

foreach ($cartItems as $item){
    if (!ProductDB::addProductToOrder($item['productId'], $orderId, $item['quantity'])){
        header("Location: ./error_pages/error_page.html");
        return;
    }
    if (!ProductDB::updateProductAmount($item['productId'], $item['quantity'])){
        header("Location: ./error_pages/error_page.html");
        return;
    }
}
UserDB::emptyCart($userId);
unset($_SESSION['cartItems']);

?>

<p>Order successfully placed! Ref No.: <a href='./web_pages/order_page.php?id=<?php echo $orderId?>' target="_blank"><?php echo $orderId?></p>

