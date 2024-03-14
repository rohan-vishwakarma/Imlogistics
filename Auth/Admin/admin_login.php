<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN LOGIN</title>
    <link rel="stylesheet" href="../../Assets/bootstrap/bootstrap.min.css">
   <script src="../../Assets/bootstrap/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../Assets/css/style.css"><link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400&display=swap" rel="stylesheet">





</head>
<body>
    
    <style>
        
        body {
            background-image : url("/Imlogistics/Assets/images/logistics.jpg");
                background-size: cover;
            
        }
    </style>
    
    
    <?php

    include '../../Partials/navbar.php';
    
    $message = "";
    
    if(isset($_POST['submit'])) {
        include '../../connection.php';
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql ="Select * from users where username='$username' and otp_verified ='YES' ";
        $ex = $con->query($sql);
        if(mysqli_num_rows($ex)>0){
            
            while($r = mysqli_fetch_assoc($ex)){
              $p =  $r['password'];
            }
            
             if(password_verify($password, $p )){

                  $_SESSION['user'] = $username;
                  
                  ?>
                  <script>alert("login successfull"); window.location.href='/Imlogistics/welcome.php';</script>
                  
                  <?php
                 
                    
                }else{
                    $message =" Invalid Credentials";
                    
                }
           
        }else{
            $message = "Username is not valid";
        }
        
        
    }

    ?>

    
    <div class="container mt-4">
        
        

        <div class="row">
            <div class="col-sm-8">
                
                
                
                <!--<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">-->
                <!--      <ol class="carousel-indicators">-->
                <!--        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>-->
                <!--        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>-->
                <!--        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>-->
                <!--      </ol>-->
                <!--      <div class="carousel-inner">-->
                <!--        <div class="carousel-item active" data-bs-interval="1000">-->
                <!--          <img class="d-block w-100" src="../../Assets/images/img1.jpg" alt="First slide">-->
                <!--        </div>-->
                <!--        <div class="carousel-item"  data-bs-interval="1000">-->
                <!--          <img class="d-block w-100" src="../../Assets/images/logi.jpg" alt="Second slide">-->
                <!--        </div>-->
                <!--        <div class="carousel-item"  data-bs-interval="1000">-->
                <!--          <img class="d-block w-100" src="../../Assets/images/logi2.jpg" alt="Third slide">-->
                <!--        </div>-->
                <!--      </div>-->
                <!--      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">-->
                <!--        <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
                <!--        <span class="sr-only">Previous</span>-->
                <!--      </a>-->
                <!--      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">-->
                <!--        <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
                <!--        <span class="sr-only">Next</span>-->
                <!--      </a>-->
                <!--    </div>-->
            

            </div>

            <div class="col-sm-4" style="border: 1px solid;border-radius: 6px;padding: 36px; background-color: white">
                
                <div class="icon" style="margin: auto; width: max-content">
                    <img src="/Imlogistics/Assets/images/icons8-male-user.gif" alt="Admin login gif">
                </div>
                
                <?php
                
                if(!empty($message)):
                
                ?>
                <div class="alert alert-warning" role="alert">
                  <?php echo $message;  ?>
                </div>
                
                <?php
                
                endif
                ?>

                <form method="post">
                    <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username'])? $_POST['username']: ''; ?>" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">Login</button>
                   <p>or Dont have an accont?<span><a href="admin_register.php">Signup</a> </span></p>  
                </form>

            </div>
        </div>
        
    </div>
    
    
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

</body>
</html>