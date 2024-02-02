<?php 

    $products = ProductDB::getAllProducts();
    $search; $priceBegin; $priceEnd;
    if (isset($_POST["search"]) || isset($_POST["price_begin"]) || isset($_POST["price_end"])) {
        $search = $_POST["search"];
        $priceBegin = $_POST["price_begin"];
        $priceEnd = $_POST["price_end"];
        $products = ProductDB::searchProduct($search, $priceBegin, $priceEnd);
    }
?>

<header class='search-bar'>
    <form action = "../web_pages/home.php?page=search" method= "post">
        <input type="text" name="search" id="search" placeholder="Search" value="<?php if(isset($search)) echo $search?>">
        <label for="price_begin">Priced From</label>
        <input type="number" name="price_begin" id="price_begin" placeholder="0.00" step="0.5" value="<?php if(isset($search)) echo $priceBegin?>">
        <label for="price_end">To</label>
        <input type="number" name="price_end" id="price_end" placeholder="0.00" step="0.5" value="<?php if(isset($search)) echo $priceEnd?>">
        <input type="submit" value="Search">
    </form>
</header>
<main class="table">
    <h2>Search Results</h2>
    <table>
        <tr>
            <td><input type="checkbox" name="shortlist" />&nbsp;</td>
            <th>Reference No.</th>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Quantity</th>
        </tr>
        Click the check box to add to shortlist
        <?php if ($products == null){?>
            <tr>
                <td colspan="5">No results found</td>
            </tr>
        <?php } else foreach ($products as $product){
            $category = CategoryDB::getCategory($product->getCategory())?>
            <tr>
                <td><input type="checkbox" name="shortlist" />&nbsp;</td>
                <td><a href="../web_pages/home.php?page=product&id=<?php echo $product->getId();?>"><?php echo $product->getId();?></a></td>
                <td><?php echo $product->getName();?></td>
                <td><?php echo $product->getPrice();?></td>
                <td><?php echo $category;?></td>
                <td><?php echo $product->getAmount();?></td>
            </tr>
        <?php }?>
    </table>
</main>
