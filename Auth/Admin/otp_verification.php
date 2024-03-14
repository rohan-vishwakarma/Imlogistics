<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otp verification</title>
    <link rel="stylesheet" href="../../Assets/bootstrap/bootstrap.min.css">
       <script src="../../Assets/bootstrap/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../../Assets/css/style.css">
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
    
    
     ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

$errors ="";
if (isset($_POST['submit'])) {
    include '../../connection.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    $sql ="Select * from users where username='$username' and email='$email' and otp='$otp'  ";
    $ex = $con->query($sql);
    if(mysqli_num_rows($ex)>0){
           
            $up =" update users SET otp_verified='YES' where  username='$username' and email='$email' and otp='$otp'  ";
            $ex = $con->query($up);
            if($ex == true){
                session_start();
                $_SESSION["user"] = $username;
                ?>
                <script>alert("Verification Successfull"); window.location.href='/Imlogistics/welcome.php'; </script>
                
                <?php
            }else{
               
                
                $message = "Error $con->error;";
            }
    }else{
        
        $message = "Invalid otp , please try again";
        
    }
    
    
}
?>


<?php

    include '../../Partials/navbar.php';

?>
    <div class="container mt-4">

        <div class="row">
            <div class="col-sm-8">
               
            </div>

            <div class="col-sm-4" style="border: 1px solid;border-radius: 6px;padding: 36px; background-color: white">
                <div class="icon" style="margin: auto; width: max-content">
                    <img src="/Imlogistics/Assets/images/otp.png" alt="Admin login gif">
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


                <form id="signupForm" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" value="<?php echo $_GET['username']; ?>"  id="username" name="username" required readonly>
                        <div class="" id="usernameerror" ></div>

                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email"  class="form-control" value="<?php echo $_GET['email']; ?>" id="email" name="email" required readonly>
                        <div class="" id="emailerror" ></div>

                    </div>
                    <div class="form-group">
                        <label for="mobile">Otp:</label>
                        <input type="text" class="form-control" id="otp" name="otp" placeholder="Please Enter Otp" required>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">Signup</button>
                </form>

            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>


</body>


</html>