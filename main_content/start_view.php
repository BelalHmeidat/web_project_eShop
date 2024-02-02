<?php 
    // include '../model_db/product_db.php';
    // include '../model_db/category_db.php';
    
    $newItems;
    $discountedItems;

    $newItems = ProductDB::getNewProducts();
    $discountedItems = ProductDB::getDiscountedProducts();

?>

<h1>Latest Deals</h1>
<h2>These deals are available for a limited time only!</h2>
<div class='deals'>
<?php foreach($newItems as $product){?>
    <div class="item">
        <figure>
        <?php $photos = ProductDB::getProductPhotos($product->getId());?>
        <a href="./home.php?page=product&id=<?php echo $product->getId();?>"><img src="<?php echo ProductDB::$imagesPath . "/" . $photos[0]['name'];?>" alt="<?php echo $product->getName();?>" ></a>
        <figcaption><?php echo $product->getName();?></figcaption>
        </figure>
        <p><?php echo "Current Price: <span class='price'>" . $product->getPrice() . "₪";?></span></p>
        <p><?php echo "Discount: -" . $product->getDiscount() . "%";?></p>
    </div>
<?php }?>
</div>
<h1>Newest Products</h1>
<div class='deals'>
<?php foreach($discountedItems as $product){?>
    <div class="item">
        <figure>
        <?php $photos = ProductDB::getProductPhotos($product->getId());?>
        <a href="./product_view.php?id=<?php echo $product->getId();?>"><img src="<?php echo ProductDB::$imagesPath . "/" . $photos[0]['name'];?>" alt="<?php echo $product->getName();?>" ></a>
        <figcaption><?php echo $product->getName();?></figcaption>
        </figure>
        <p><?php echo "Current Price: <span class='price'> ". $product->getPrice() . "₪";?></span></p>
    </div>
<?php }?>
</div>