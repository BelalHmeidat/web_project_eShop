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
    <h1>Student with ID: <?php echo $id?> not found!</h1>
    <p>
        <a href="students.php">Back to Students</a>
    </p>
</body>
</html>
