<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Veikals</title>

    <nav>
                <a class="homehome" href="home.php">Preču katalogs</a>
                <a class="homeievietot" href="ievietot.php">Ievietot</a>
                <a class="homesignout" href="logout.php">Iziet</a>
    </nav>
</head>
<body>

    <?php
    include "db.php";
    $sql = "select * from BLOGS_main";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="homeboxmain">'; // Start the main container

        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="homebox1">
                <div class="Nosaukums"><?php echo $row["virsraksts"] ?></div>
                <div class="Kategorija"><?php echo $row["teksts"] ?></div>
                <img class="resize" src="<?php echo $row["img_url"]; ?>"/>
            </div>
            <?php
        }

        echo '</div>'; // End the main container
    }
    ?>


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