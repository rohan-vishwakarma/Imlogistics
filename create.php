<?php
session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    
 
if(!isset($_SESSION["user"])){
    header("location: index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOMEPAGE</title>
    <?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    include 'cdnlinks.php';
    ?>
</head>
<body>
    <?php
    include 'connection.php';
    include 'Partials/navbar2.php';


        menus(2);
    ?>


<?php

$con->close();

?>
</body>
</html>