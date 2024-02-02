<?php
include '../dbconfig.in.php';
include '../model_db/user_db.php';

if (!isset($_GET['id'])){
    header("Location: ../web_pages/error_page.html");
    return;
}
$orderId = $_GET['id'];
$order = UserDB::getOrder($orderId);
$items = UserDB::getOrderItems($orderId);
if (!isset($order) || !isset($items)){
    header("Location: ../web_pages/error_page.html");
    return;
}
$totalPrice = $order['total'];
?>
<h1>Order Details</h1>
<div>
    <fieldset>
        <table>
            <tr>
                <th>Reference No.</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            <?php foreach ($items as $product){ ?>
            <tr>
                <td><a href="../web_pages/home.php?page=product&id=<?php echo $product['id'];?>"><?php echo $product['id'];?></a></td>
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
    </fieldset>
</div>