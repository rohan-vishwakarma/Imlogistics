  <?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
$client = $_SESSION['client'];


if(!isset($_SESSION["client"])){
    header("location: /Imlogistics/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELCOME CLIENT</title>
        <link href="/Imlogistics/Assets/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Link Bootstrap JavaScript file -->
    <script src="/Imlogistics/Assets/bootstrap/bootstrap.bundle.min.js"></script>

    
  
</head>
<body>
    
    <style>
        
        body {
            background-image : url("/Imlogistics/Assets/images/logistics.jpg");
                background-size: cover;
            
        }
        
        @media only screen and (max-width: 600px) {
          body, html {
            background-repeat: no-repeat; /* Prevent background repeat */
            
          }
         
        }
        
        .h {
                text-align: center;
                color: ghostwhite;
                font-family: monospace;
        }
    </style>
    
    <?php
    include '../connection.php';
    
    include '../Partials/clientnavbar.php';
    
    menus(1, 'index.php');
    
    $sql = " select name from customers where  user='$client'  ";
    $ex = $con->query($sql);
    if(mysqli_num_rows($ex)>0){
        while($r = mysqli_fetch_assoc($ex)){
            ?>
            <h2 style="text-align: center" class="mt-4 h"><?php echo $r['name']; ?></h2>
            <?php
        }
    }
    
    
    
    ?>
    
    
  

</body>
</html>