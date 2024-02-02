<?php
if (!isset($_SESSION['user']) || !isset($_SESSION['mode']) || $_SESSION['mode'] != 2){
    header("Location: ./error_pages/unauthorized_page.html");
    return;
}

$inventory = ProductDB::getAllProducts();
?>


<div class='put-left'>
    <a href="./index.php?page=addProduct"><button type="button">Add Product</button></a>
</div>
<div class='table'>
    <h2>Inventory</h2>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Category</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Remarks</th>
        </tr>
        <?php foreach ($inventory as $product){?>
            <tr>
                <td><?php echo $product->getId();?></td>
                <td><?php echo $product->getName();?></td>
                <td><?php echo $product->getPrice();?></td>
                <td><?php echo $product->getStock();?></td>
                <td><?php echo $product->getCategory();?></td>
            </tr>
        <?php }?>
    </table>