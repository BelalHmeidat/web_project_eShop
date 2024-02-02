<?php 
    $mode = $_SESSION["mode"];
    $products = ProductDB::getAllProducts();
    $search; $priceBegin; $priceEnd; $searchId;
    if (isset($_POST["search"]) || isset($_POST["price_begin"]) || isset($_POST["price_end"]) || isset($_POST["searchId"])) {
        $search = $_POST["search"];
        $priceBegin = $_POST["price_begin"];
        $priceEnd = $_POST["price_end"];
        if (isset($_POST["searchId"])){
            $searchId = $_POST["searchId"];
            $products = ProductDB::searchProduct($search, $priceBegin, $priceEnd, $searchId);
        }
        else {
            $products = ProductDB::searchProduct($search, $priceBegin, $priceEnd);
        }
    }
?>

<header class='search-bar'>
    <form action = "./index.php?page=search" method= "post">
        <?php if ($mode == 2){?>
            <input type="text" name="searchId" id="searchId" placeholder="ID" value="<?php if(isset($search)) echo $searchId?>" pattern='[0-9]+' title="Only numbers allowed">
        <?php }?>
        <input type="text" name="search" id="search" placeholder="Search" value="<?php if(isset($search)) echo $search?>">
        <label for="price_begin">Priced From</label>
        <input type="number" name="price_begin" id="price_begin" placeholder="0.00" step="0.5" value="<?php if(isset($search)) echo $priceBegin?>">
        <label for="price_end">To</label>
        <input type="number" name="price_end" id="price_end" placeholder="0.00" step="0.5" value="<?php if(isset($search)) echo $priceEnd?>">
        <input type="submit" value="Search">
    </form>
</header>
<main class="table">
    <?php if ($mode == 1 || $mode == 0){?>
    <h2>Search Results</h2>
    <?php } else {?>
    <h2>Inventory</h2>
    <?php }?>
    <table>
        <tr>
            <?php if ($mode == 1 || $mode == 0){?>
                <td><input type="checkbox" name="shortlist" />&nbsp;</td>
            <?php }?>
            <th>Reference No.</th>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Quantity</th>
        </tr>
        <?php if ($mode == 1 || $mode == 0){?>
        Click the check box to add to shortlist
        <?php } else {?>
            <div><a href="./index.php?page=addProduct"><button type="button">Add Product</button></a></div>
        <?php }?>
        <?php if ($products == null){?>
            <tr>
                <td colspan="5">No results found</td>
            </tr>
        <?php } else foreach ($products as $product){
            $category = CategoryDB::getCategory($product->getCategory())?>
            <tr>
            <?php if ($mode == 1 || $mode == 0){?>
                    <td><input type="checkbox" name="shortlist" />&nbsp;</td>
            <?php }?>
                <td><a href="./index.php?page=product&id=<?php echo $product->getId();?>"><?php echo $product->getId();?></a></td>
                <td><?php echo $product->getName();?></td>
                <td><?php echo $product->getPrice();?></td>
                <td><?php echo $category;?></td>
                <td><?php echo $product->getAmount();?></td>
            </tr>
        <?php }?>
    </table>
</main>
