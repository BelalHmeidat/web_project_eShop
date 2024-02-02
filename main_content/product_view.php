<?php 
    $user;
    $mode = 0; // guest 1: customer 2: manager
    if (isset($_SESSION["user"])){
        $user = $_SESSION["user"];
        $mode = $_SESSION["mode"];
    }
    $product; $category; $photos; $mainImg;
    if (!isset($_GET["id"])) { //id of the product visited
        header("Location: ./web_pages/error_page.html");
        return;
    }
    $product = ProductDB::getProduct($_GET["id"]);
    if($product == null) {
        header("Location: ./web_pages/not_found_page.php?id=" . $_GET["id"]);
        return;
    }
    $photos = ProductDB::getProductPhotos($product->getId());
    if (isset($_GET["img"])){
        $mainImg = $_GET["img"];
    }
    else {
        $mainImg = $photos[0]['name'] ?? "";
    }

    $category = CategoryDB::getCategory($product->getCategory());
    $message; $flag; $id;
    if(isset($_POST['id'])){
        $id = $_POST['id']; // id of the product to be added to cart
        if (!UserDB::addOneToCart($user->getId(), $id)){
            $message = "Couldn't add product to cart!";
            $flag = false;
        }
        else {
            $flag = true;
            $message = "Product added to cart!";
        }
    }
    if (isset($_POST['amount'])){
        $id = $_GET['id'];
        $amount = $_POST['amount'];
        if (!ProductDB::changeAmount($id, $amount)){
            $message = "Couldn't change the amount!";
            $flag = false;
        }
        else {
            $flag = true;
            $message = "Amount changed!";
            $product = ProductDB::getProduct($_GET["id"]);
        }
    }
    ?>
<h1><?php echo $product->getName();?></h1>
<p>Reference No.: <?php echo $product->getId();?></p>
<div class="img-desc-area">
    <div class="img-catalog">
        <div class="main-img">
            <img src="./images/<?php echo $mainImg?>" alt="<?php echo $mainImg;?>" width="400" height="400">
        </div>
        <div class="thumbnails">
        <?php foreach ($photos as $photo){?>
            <?php $imageName = $photo['name'];
            $id = $_GET['id']?>
            <a href="./index.php?page=product&id=<?php echo $id?>&img=<?php echo $imageName?>"><img src="./images/<?php echo $imageName;?>" alt="<?php echo $product->getName();?>" width="100" height="100"></a>
        <?php }?>
        </div>
    </div>
    <div>
        <h3>Description: </h3>
        <p>$<?php echo $product->getDescription();?></p>
    </div>
</div>
<div class='product-info'>
    <div class="price-discount">
        <p class='price'>Price: $<?php echo $product->getPrice();?></p>
        <?php if($product->getDiscount() > 0){?>
            <p class='discount'>Discount: -<?php echo $product->getDiscount();?>%</p>
        <?php }?>
        <p>Category: <?php echo $category;?></p>
        <p>Quantity: <?php echo $product->getAmount();?></p>
    </div>
    <div>
        Remarks: <br><?php echo $product->getRemarks();?>
    </div>
    <div>
        <?php if($mode == 0){
            $buttonText = "Login to place an order";
            $link = "./index.php?page=login";
            ?>
            <a href="<?php echo $link?>"><button><?php echo $buttonText?></button></a>
        <?php }else if ($mode == 1){?>
                <form method="POST" action="./index.php?page=product&id=<?php echo $id?>">
                    <input type="hidden" name="id" value="<?php echo $product->getId();?>">
                    <input type='submit' name="submit" value="Add to Cart">
                </form>
                <?php } else if ($mode == 2){?>
                <form method="POST" action="./index.php?page=product&id=<?php echo $id?>">
                    <label for='amount'>Quantity: </label>
                    <input type='number' name = 'amount' value="<?php echo $product->getAmount();?>" min='0'>
                    <input type='submit' name="submit" value="Change">
                </form>
                    <?php }
                $class ='success';
                if (isset($flag)){
                    if (!$flag) $class = 'error';
                }
                ?>
                <p class='<?php echo $class?>'><?php echo $message ?? ''?></p>
                
    </div>
</div>