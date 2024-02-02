<?php 
$user; $products; $productCount;
if (!isset($_SESSION["user"])){
    header("Location: ./error_pages/unauthorized_page.html");
    return;
}
$user = $_SESSION["user"];
$cartItems = UserDB::getCart($user->getId());
$_SESSION['cartItems'] = $cartItems;
$changedProductId; $changedCount;
if (isset($_POST['id'])){
    $changedProductId = $_POST['id'];
    $changedCount = $_POST['count'];
    if($changedCount > ProductDB::getProduct($changedProductId)->getAmount()){
        echo "Not enough products in stock!";
        $changedCount = ProductDB::getProduct($changedProductId)->getAmount();
    }
    UserDB::updateProductQuantityInCart($user->getId(), $changedProductId, $changedCount);
}
// $_SESSION['products'] = $products;
// $_SESSION['productCount'] = $productCount;

?>
<div class="orders-checkout">
    <div class='table'>
        <h2>Your Orders</h2>
        <table>
            <tr>
                <th>Reference No.</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Remove</th>
            </tr>
            <?php if (empty($cartItems)){?>
                <tr>
                    <td colspan="5">No products in cart.</td>
                </tr>
            <?php } else foreach ($cartItems as $item){
                $product = ProductDB::getProduct($item['productId']); $count = $item['quantity']; $productId = $product->getId();
                if(isset($changedProductId) && $productId == $changedProductId){
                    $count = $changedCount;
                }
                ?>
                <tr>
                    <td><a href="./index.php?page=product&id=<?php echo $product->getId();?>"><?php echo $product->getId();?></a></td>
                    <td><?php echo $product->getName();?></td>
                    <td><?php echo $product->getPrice();?></td>
                    <td><form method="POST">
                        <input type='number' name="count" value="<?php echo $count?>" max="<?php echo $product->getAmount()?>" onblur="this.form.submit()">
                        <input type="hidden" name="id" value="<?php echo $productId?>">
                    </form></td>
                    <td><a href="./actions/delete.php?id=<?php echo $productId;?>"><button><img alt='delete' src='./icons/delete.jpeg' width='30' height='30'></button></a></td>
                </tr>
            <?php }?>
        </table>
    </div>
    <div class='checkout'>
        <h2>Checkout</h2>
        <?php $total = UserDB::getCartTotal($user->getId());?>
        <p> Your total is: <strong class='price'>₪ <?php echo $total;?></strong></p>
        <form method="POST" action="./index.php?page=checkout">
            <!-- <input type="hidden" name="userId" value="<?php echo $user->getId()?>"> -->
            <!-- <input type="hidden" name="cartItems" value="<?php echo serialize($cartItems)?>"> -->
            <input type="hidden" name="total" value="<?php echo $total?>">
            <input type="submit" value="Checkout" <?php echo empty($cartItems) ? 'disabled' : ''?>>
        </form>
    </div>
</div>
