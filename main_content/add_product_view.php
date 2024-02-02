<?php 
    if (!isset($_SESSION["user"]) || !isset($_SESSION["mode"]) || $_SESSION["mode"] != 2){
        header("Location: ./error_pages/unauthorized.php");
        return;
    }

    $errorMessage;
    $product = new Product(); 
    $categories;

    $categories = CategoryDB::getAllCategories();

    function checkAllFields(){
        global $product;
        if(!isset($_POST['name']) || empty($_POST['name'])) return false;
        if(!isset($_POST['description']) || empty($_POST['description'])) return false;
        if(!isset($_POST['category']) || empty($_POST['category'])) return false;
        if(!isset($_POST['price']) || empty($_POST['price'])) return false;
        if(!isset($_POST['quantity']) || empty($_POST['quantity'])) return false;
        $category = CategoryDB::getCategory($_POST['category']);
        // if ($category == null) return false;
        $product->setName($_POST['name']);
        $product->setDescription($_POST['description']);
        $product->setCategory($_POST['category']);
        $product->setPrice($_POST['price']);
        $product->setAmount($_POST['quantity']);
        if (isset($_POST['discount']) || !empty($_POST['discount']))
            $product->setDiscount($_POST['discount']);
        else 
            $product->setDiscount(0);
        if (isset($_POST['remarks']) || !empty($_POST['remarks']))
            $product->setRemarks($_POST['remarks']);
        else
            $product->setRemarks("");
        return true;
    }

    if (checkAllFields()){
        $result = ProductDB::addProduct($product->getName(), $product->getDescription(), $product->getCategory(), $product->getPrice(), $product->getAmount(), $product->getRemarks(), $product->getDiscount());
        if ($result != null){
            $id = ProductDB::getMaxId();
            $target_dir = ProductDB::$imagesPath; // ./images
            $files = $_FILES['photo'];
            if (!file_exists($target_dir)){
                mkdir($target_dir);
            }
            for ($i = 0; $i < count($files["name"]); $i++){
                $file = $files["name"][$i];
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $newFileName = 'item' . $id . 'img' . $i . '.' . $extension;
                $uploadfile = $target_dir . '/' . $newFileName;
                $move = move_uploaded_file($files['tmp_name'][$i],$uploadfile);
                ProductDB::addProductPhoto($id, $newFileName);
            }
            $message = "Product added!";
            return;
        }
        else {
            $errorMessage = "Couldn't add product!";
        }

    }
    else {
        $errorMessage = "Please fill in all fields!";
    }

?>

<form method="POST" action="./index.php?page=addProduct" enctype="multipart/form-data">
    <fieldset>
        <legend>Product Information</legend>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required value='<?php echo isset($product) ? $product->getName() ?? "" : ""?>'>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?php echo isset($product) ? $product->getDescription() ?? "" : ""?></textarea>
        <br>
        <label for="category">Category:</label>
        <select name="category" id="category" required>
            <?php foreach ($categories as $category){?>
                <option value="<?php echo $category['id']?>"><?php echo $category['name']?></option>
            <?php }?>
        </select>
        <br>
        <label for="price">Price:</label>
        <input type="number" name="price" id="price" required value='<?php echo isset($product) ? $product->getPrice() ?? "" : ''?>' step="0.01">
        <br>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" required value='<?php echo isset($product) ? $product->getAmount() ?? "": ""?>'>
        <br>
        <label for="discount">Discount:</label>
        <input type="number" name="discount" id="discount" value='<?php echo isset($product) ? $product->getDiscount() ?? "0" : "0"?>' min="0" max="100">
        <br>
        <label for="remarks">Remarks:</label>
        <textarea name="remarks" id="remarks"><?php echo isset($product) ? $product->getRemarks() ?? " " : ' '?></textarea>
        <br>
        <label for="photo">Photo:</label>
        <input type="file" name="photo[]" id="photo" multiple accept="image/jpeg">
    </fieldset>
    <input type="submit" value="Add Product">
    <a href="./index.php?page=search"><button type="button" formnovalidate>Back</button></a>
    <br>
    <?php if(isset($errorMessage)) echo "<label style='color:red'>$errorMessage</label>" ?>
</form>