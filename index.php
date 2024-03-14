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
    session_start();
    ?>
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
    </style>
    <?php

    include 'Partials/navbar.php';

    ?>

</body>
</html>