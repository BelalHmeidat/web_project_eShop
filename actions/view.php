<!DOCTYPE html>
<html>
<head>
    <title>Student View</title>
</head>
<?php 

    $user = null;
    if (isset($_GET["id"])){
        $id = $_GET["id"];
        ProductDB::createConnection();
        $user = ProductDB::getProduct($id);

        if (isset($user)) {
            ?>
            <body>
                <div>
                <img src= '<?php $photoURL = $user->getPhoto(); echo ProductDB::$imagesPath . "/"; echo (isset($photoURL) && !empty($photoURL)) ? $photoURL : ProductDB::$defaultPhoto; ?>' alt= 'Student Photo' width='100' height='100'>
                </div>
                <h3>
                    Student ID: <?php echo $user->getId()?>, Student Name:  <?php echo $user->getStdName()?>
                </h3>
                <ul>
                    <li>Average: <?php echo $user->getAverage() ?? "" ?></li>
                    <li>Department: <?php echo  !is_null($user->getDepId()) ? ProductDB::getCatName($user->getDepId())  : ""?></li>
                    <li>Date of Birth: <?php echo !is_null($user->getDob()) ? $user->getDob() : ""?></li>        
                </ul>
    
                <h3>Contact</h3>
                <div>
                    <?php $email = $user->getEmail(); echo !is_null($email) && !empty($email) ? '<a href="mailto:' . $email. '">Email: ' . $email . '</a>': "Email: "?>
                </div>
                <div>
                    <?php $tel = $user->getTel(); echo !is_null($tel) && !empty($tel) ? '<a href="tel:' . $tel. '">Phone: ' . $tel . '</a>': "Phone: "?>
                </div>
                <?php $address = $user->getAddress(); $city = $user->getCity(); $country = $user->getCountry()?>
                <div>Address: <?php if(!is_null($address) && !empty($address)) echo $address . " ";
                    if(!is_null($city) && !empty($city)) echo $city . " ";
                    if(!is_null($country) && !empty($country)) echo $country;
                ?></div>
            </body>
        <?php 
        }
        else {
            header("Location: not_found_page.php?id=$id");
        }
    }
    else {
        header("Location: provide_id_page.html");
    } 
    ?>

</html>
