
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>

<?php
    include 'dbconfig.in.php';
    include 'student.php';
    $user = null;
    $id= null;

    $departments = null;
    // StudentDB::createConnection()
    // $student = StudentDB::getStudent(1202295);
    $resultFlag = false;
    $errorMessage = "";

    if(isset($_GET["id"])){
        $id = $_GET["id"];
        ProductDB::createConnection();
        $user = ProductDB::getProduct($id);
    }

    else if(isset($_POST['id'])){
        $id = $_POST["id"];
        ProductDB::createConnection();
        $user = ProductDB::getProduct($id);
    
        if(isset($_POST['name']) && !empty($_POST['name'])){ //name and gender are required
            $user->setStdName($_POST['name']);
        }

        if(isset($_POST['gender']) && !empty($_POST['gender'])){ // gender is required
            $user->setGender($_POST['gender']);
        }

        if(isset($_POST['dob']) && !empty($_POST['dob'])){
            $user->setDob($_POST['dob']);
        }
        else {
            $user->setDob(null); //dob is not required
        }

        if(isset($_POST['average']) && !empty($_POST['average'])){
            $user->setAverage($_POST['average']);
        }
        else {
            $user->setAverage(null); //average is not required
        }

        if(isset($_POST['department']) && !empty($_POST['department'])){ //if department is not selected, it will be null
            $user->setDepId($_POST['department']);
        }
        else {
            $user->setDepId(null);
        }

        if(isset($_POST['address'])){
            $user->setAddress($_POST['address']);
        }

        if(isset($_POST['city'])){
            $user->setCity($_POST['city']);
        }

        if(isset($_POST['country'])){
            $user->setCountry($_POST['country']);
        }

        if(isset($_POST['tel'])){
            $user->setTel($_POST['tel']);
        }

        if(isset($_POST['email'])){
            $user->setEmail($_POST['email']);
        }

        if (!empty($_FILES['photo']['name'])){
            $photoName  = $id . '.jpeg';
           $user->setPhoto($photoName);
       }

        $target_dir = ProductDB::$imagesPath;
        $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $newFileName = $id . '.' . $extension;
        $uploadfile = $target_dir . '/' . $newFileName;
        $move = move_uploaded_file($_FILES['photo']['tmp_name'],$uploadfile);

        if (ProductDB::updateProduct(
            id: $user->getId(),
            name: $user->getStdName(),
            gender: $user->getGender(),
            dob: $user->getDob(),
            depId: $user->getDepId(),
            average:$user->getAverage(),
            address:$user->getAddress(),
            city: $user->getCity(),
            country: $user->getCountry(),
            tel: $user->getTel(),
            email: $user->getEmail(),
            photo: $user->getPhoto()
            ) > 0 ||$move){
            $resultFlag = true;
            $errorMessage = "Student updated successfully!";
        }
        else{
            $resultFlag = false;
            $errorMessage = "Nothing changed."; //update query did not update anything
        }
    }
    else {
        header("Location: provide_id_page.html");
    }


    if (isset($user)){ 
       ?>
        <form action= "<?php echo $_SERVER["PHP_SELF"]?>" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Student Record</legend>
                <div>
                    <label for='id'>Student ID:</label>
                    <input type='text' name='id' id='id'value="<?php echo $user->getId()?>" required pattern="[0-9]+" title="Please enter only numbers." readonly/>
                </div>
                <br>
                <div>
                    <label for='name'>Name:</label>
                    <input type='text' name='name' id='name' value="<?php echo $user->getStdName()?>" required pattern="[A-Za-z ]+" title='Name has to consist of only letters!'/>
                </div>
                <br>

                <div> 
                    <label for='gender'>Gender:</label>

                    <input type='radio' id="gender" name='gender' value="Male" <?php if($user->getGender() == 'Male') echo 'checked'?> required/>
                    <label for='Male'>Male</label>

                    <input type='radio' id='female' name='gender' value='Female'<?php if($user->getGender() == 'Female') echo 'checked'?> required/>
                    <label for='Female'>Female</label>
                </div>
                <br>

                <div>
                    <label>Date of Birth:</label>
                    <input type='date' name='dob' id='dob' value="<?php echo $user->getDob()?>" max="<?php echo date('Y-m-d');?>" min="1900-01-01"/>
                </div>
                <br>

                <div>
                <label>Department:</label>
                <select name='department' id='department'>
                    <option value=''>Select Department</option>
                    <?php
                        $departments = ProductDB::getCategory();
                        while ($row = $departments->fetch()) {
                            $depId = $row['depId'];
                            $depName = $row['depName'];
                            echo "<option value='$depId' ";
                            if ($user->getDepId() == $depId) echo "selected";
                            echo ">$depName</option>";
                        }
                    ?>  
                </select> 
                </div>
                <br>

                <div>
                <label>Average:</label>
                <input type='number' name='average' min='0' max='100' step='0.1' id='average' value="<?php echo $user->getAverage()?>"/> 
                </div>
                <br>

                <div>
                <label>Address:</label>
                <input type='text' name='address' id='address' value="<?php echo $user->getAddress()?>"/>
                </div>
                <br>

                <div>
                <label>City:</label>
                <input type='text' name='city' id='city' value="<?php echo $user->getCity()?>" pattern="[A-Za-z ]+" title='City name has to consist of only letters!'/>

                <label>Country:</label>
                <input type='text' name='country' id='country' value="<?php echo $user->getCountry()?>" pattern="[A-Za-z ]+" title='Country name has to consist of only letters!'/>
                </div>
                <br>

                <div>
                <label>Tel:</label>
                <input type='tel' name='tel' id='tel' value="<?php echo $user->getTel()?>"/>
                </div>
                <br>

                <div>
                <label>Email:</label>
                <input type='email' name='email' id='email' value="<?php echo $user->getEmail()?>"/>
                </div>
                </br>

                <div>
                <label>Student Photo:</label>
                <input type='file' name='photo' id='photo' accept="image/jpeg" value="<?php $photoURL = $user->getPhoto(); echo ProductDB::$imagesPath . "/" . $photoURL?>"/>
                </div>
                <br>

                <input type="submit" name="action" value="update"/>
                <input type="button" value="back" onclick="window.location.href='students.php'"/>
                <br>

                <div>
                    <label style='<?php if($resultFlag) echo "color:green"; else echo "color:orange"?>'><?php echo $errorMessage?></label>
                </div>
                <br>
            </fieldset>
        </form>
  <?php  }
    else {
        header("Location: not_found_page.php?id=$id");
    }
?>

</body>
</html>