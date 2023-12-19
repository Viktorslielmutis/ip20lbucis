<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to the login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$id = $_SESSION["id"];
require_once "db.php";

if(isset($_POST['submit'])){
    $target_dir = "uploads/"; // Specify the target directory where you want to store the uploaded files
    $target_file = $target_dir . basename($_FILES["Img_URL"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["Img_URL"]["tmp_name"]);
    if($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (adjust as needed)
    if ($_FILES["Img_URL"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload the file
        if (move_uploaded_file($_FILES["Img_URL"]["tmp_name"], $target_file)) {
            // Insert data into the database
            $sql = "INSERT INTO BLOGS_main (user_id, virsraksts, teksts, img_url) VALUES ('$id', '".$_POST['Virsraksts']."','".$_POST['Teksts']."', '$target_file')";

            if($conn->query($sql)){
                echo "";
            } else {
                echo $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Ievade</title>

    <nav>
    <a class="ievietothome" href="home.php">Preču katalogs</a>
        <a href="ievietot.php">Ievietot</a>
        <a href="logout.php">Iziet</a>
    </nav>

</head>
<body>

    <div class="ievietotboxmain">
        <div class="teksts">
            <form class="formievietot" method="post" enctype="multipart/form-data">
                <div class="ievietotbox1">
                    <label id="first">Visraksts</label>
                    <input type="text" name="Virsraksts" required>
                </div>
                
                <div class="ievietotbox2">
                    <label id="first">Teksts</label>
                    <input type="text" name="Teksts" required>
                </div>

                <div class="ievietotbox2">
                    <label for="file">Choose an image:</label>
                    <input type="file" name="Img_URL" id="file" accept="image/*" required>
                </div>

                <div class="ievietotbox2">
                    <input id="insertbutton" type="submit" name="submit" value="Ievietot">
                </div>
            </form>
            <?if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Ievietots";}?>
        </div>
    </div>

    <footer>
        <div class="social-icons">
            <a href="#" target="_blank">Facebook</a>
            <a href="#" target="_blank">Twitter</a>
            <a href="#" target="_blank">Instagram</a>
        </div>
        &copy; 2023 Lauris Būcis
    </footer>

</body>
</html>