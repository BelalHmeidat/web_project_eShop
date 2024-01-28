<?php 
    include 'dbconfig.in.php';
    include 'product.php';
    ProductDB::createConnection();
?>


<!DOCTYPE html>
<html>
<style>
    table, th, td {
    border: 1px solid black;
    }
</style>
<head>
    <title>Product Manager</title>
</head>

<body>
    <p>
        To Register a new product click the following link: <a href="register.php">Register</a>
    </p>
    <p>
        Use the table below to edit or delete existing students.
    </p>
    <h3>All Products</h3>
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Product ID</th>
                <th>Student Name</th>
                <th>Average</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <?php 
        $students = ProductDB::getAllProducts();
        foreach ($students as $user) {
            ?>
            <tr>
                <?php $photoURL = $user->getPhoto(); ?>
                <td> <img src= '<?php echo ProductDB::$imagesPath . "/"; echo (isset($photoURL) && !empty($photoURL)) ? $photoURL : ProductDB::$defaultPhoto; ?>' alt= 'Student Photo' width='100' height='100'></td>
                <?php $id = $user->getId();?> <!-- all students have an id -->
                <td><a href= 'view.php?id=<?php echo $id;?>'> <?php echo $id; ?> </a></td>
                <td> <?php echo $user->getStdName();?> </td> <!-- all students have a name -->
                <?php $average = $user->getAverage();?>
                <td> <?php if(isset($average)) echo $user->getAverage();?> </td> <!--  average could be empty -->
                <?php $depId = $user->getDepId(); ?> 
                <td> <?php if (isset($depId)) echo ProductDB::getCatName($depId);?> </td> <!-- dep could be empty -->
                <td>
                    <a href="edit.php?id=<?php echo $id;?>"><button><img alt='edit' src='./icons/edit.jpeg' width='30' height='30'></button></a>
                    <a href="delete.php?id=<?php echo $id;?>"><button><img alt='delete' src='./icons/delete.jpeg' width='30' height='30'></button></a>
                </td>
            </tr>
        <?php }
        ?>
    </table>

</body>
</html>