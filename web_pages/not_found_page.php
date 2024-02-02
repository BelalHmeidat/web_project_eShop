<?php
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Not Found</title>
</head>
<body>
    <h1>Product with ID: <?php echo $id?> not found!</h1>
    <p>
        <a href="./index.php">Back to Home</a>
    </p>
</body>
</html>
