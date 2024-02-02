<?php
if(!isset($_SESSION['user'])) header("Location: ../error_pages/unauthorized_page.html");
if(!isset($_SESSION['cartItems'])) header("Location: ../web_pages/error_page.html");
if(!isset($_POST['total'])) header("Location: ../web_pages/error_page.html");
$user = $_SESSION['user'];
$payment = paymentDB::getPaymentByNO($user->getPayment());
$cartItems = $_SESSION['cartItems'];
foreach ($cartItems as $item){
    echo $item['productId'];
    echo $item['quantity'];
}
$totalPrice = $_POST['total'];
// $products = [];
// $productCount = [];
// foreach ($cartItems as $item){
//     $product = ProductDB::getProduct($item['id']);
//     $productCount[] = $item['count'];
//     $products[] = $product;
// }
?>
<h1>Confirm Your Information</h1>
    <!-- <form method="post" action=".../web_pages/home.php?page=placeOrder"> -->
    <!-- <form> -->
    <fieldset>
        <legend>Personal Information</legend>
        <input type="hidden" name="userId" value="<?php echo $user->getId() ?? '' ?>">
        <input type="hidden" name="paymentId" value="<?php echo $payment->getId() ?? '' ?>">

        <label for="name">Name</label>
        <input type="text" name="name" id="name" pattern="[\u0600-\u06FF\u0750-\u077F A-Za-z]+" title="Only English and Arabic characters allowed" required value="<?php echo $user->getName() ?? ''?>" readonly>
        <br>
        <label for="houseNO">House Number</label>
        <input type="text" name="houseNO" id="houseNO" required value="<?php echo $user->getHouseNO() ?? '' ?>" readonly>
        <br>
        <label for="street">Street</label>
        <input type="text" name="street" id="street" required value="<?php echo $user->getStreet() ?? '' ?>" readonly>
        <br>
        <label for="city">City</label>
        <input type="text" name="city" id="city" pattern="[\u0600-\u06FF\u0750-\u077F A-Za-z]+" title="Only English and Arabic characters allowed" required value="<?php echo $user->getCity() ?? '' ?>" readonly>
        <br>
        <label for="country">Country</label>
        <input type="text" name="country" id="country" pattern="[\u0600-\u06FF\u0750-\u077F A-Za-z]+" title="Only English and Arabic characters allowed" required value="<?php echo $user->getCountry() ?? '' ?>" readonly>
        <br>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required value="<?php echo $user->getEmail() ?? '' ?>" readonly>
        <br>
        <label for="phone">Phone</label>
        <input type="tel" name="tel" id="tel" required value="<?php echo $user->getTel() ?? '' ?>" readonly>
        <br>
    </fieldset>
    <fieldset>
        <legend>Payment Information</legend>
        <label for="cardNO">Card Number</label>
        <input type="text" name="cardNO" id="cardNO" pattern="[0-9 -]+"  title="Only numbers, spaces, and hyphens allowed" required value="<?php echo $payment->getCreditCardNo() ?? '' ?>" readonly>
        <br>
        <label for="cardExpiration">Expiration Date</label>
        <input type="date" name="cardExpiration" id="cardExpiration"  min="<?php echo date('Y-m-d') ?>" required value="<?php echo $payment->getCardExpiration() ?? '' ?>" readonly>
        <br>
        <label for="holderName">Holder Name</label>
        <input type="text" name="holderName" id="holderName" pattern="[\u0600-\u06FF\u0750-\u077F A-Za-z]+" title="Only English and Arabic characters allowed" required value="<?php echo $payment->getHolderName() ?? '' ?>" readonly>
        <br>
        <label for="bank">Issuing Bank</label>
        <input type="text" name="bank" id="bank" pattern="[A-Za-z0-9]+" title="Only alphanumeric characters allowed" required value="<?php echo $payment->getBank() ?? '' ?>" readonly>
        <br>
    </fieldset>
    <fieldset>
        <table>
            <tr>
                <th>Reference No.</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            <?php foreach ($cartItems as $item){
                $product = ProductDB::getProduct($item['productId']); $count = $item['quantity']; $productId = $product->getId(); ?>
            <tr>
                <td><a href="../web_pages/home.php?page=product&id=<?php echo $product->getId();?>"><?php echo $product->getId();?></a></td>
                <input type="hidden" name="productId[]" value="<?php echo $productId?>">
                <input type="hidden" name="productCount[]" value="<?php echo $count?>">
                <td><?php echo $product->getName();?></td>
                <td><?php echo $product->getPrice();?></td>
                <td><?php echo $count?></td>
            </tr>
            <?php }?>
            <tr>
                <td colspan="2">Total</td>
                <td colspan="2"><?php echo $totalPrice?></td>
            </tr>
        </table>
    </fieldset>
    <!-- <input type="submit" value="confirm"> -->
    <a href="../web_pages/home.php?page=placeOrder&total=<?php echo $totalPrice?>"><button>Confirm</button></a>
    <a href="../web_pages/home.php?page=cart"><button>Back</button></a>
    <br>
    <!-- </form> -->