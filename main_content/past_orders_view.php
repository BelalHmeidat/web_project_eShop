<?php 
if (!isset($_SESSION["user"]) || !isset($_SESSION["mode"])){
    header("Location: ./error_pages/unauthorized_page.html");
    return;
}
$orders;
$mode = $_SESSION["mode"];
$user = $_SESSION["user"];
if ($mode == 1){
    $orders = UserDB::getOrders($user->getId());
}
if ($mode == 2){
    $orders = UserDB::getOrdersForEmployees();
}

?>

<div class='table'>
    <h2>Your Orders</h2>
    <table>
        <tr>
            <th>Reference No.</th>
            <th>Date</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
        <?php if (empty($orders)){?>
            <tr>
                <td colspan="4">You don't have any past orders.</td>
            </tr>
        <?php } else foreach ($orders as $order){
            $statusClass = $order['status'];
            ?>
            <tr class='order-row-<?php echo $statusClass?>'>
                <td><a target="_blank" href="./web_pages/order_page.php?id=<?php echo $order['id'];?>"><?php echo $order['id'];?></a></td>
                <td><?php echo $order['date'];?></td>
                <td><?php echo $order['total'];?></td>
                <td><?php echo $order['status'];?></td>
            </tr>
        <?php }?>
    </table>
</div>