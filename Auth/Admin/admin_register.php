<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN LOGIN</title>
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
    require '../../PHPMailer/PHPMailer/src/Exception.php';
    require '../../PHPMailer/PHPMailer/src/PHPMailer.php';
    require '../../PHPMailer/PHPMailer/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    

    function send_otp($user, $otp){
        $email = "dhirenshah50@gmail.com";
        $message_body = "Congrats $user Registration successfull. this is your otp : $otp";
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = 'tls'; // tls or ssl
        $mail->Port     = "587";
        $mail->Username   = 'waresys.outboxx@gmail.com';                     // SMTP username
        $mail->Password   = 'durjabbfydftyzlx';                               // SMTP password
        $mail->Host     = "smtp.gmail.com";
        $mail->Mailer   = "smtp";
        $mail->SetFrom("waresys.outboxx@gmail.com", "IM LOGISTICS");    
        $mail->AddAddress($email);
        $mail->Subject = "OTP FOR NEW REGISTRATION";
        $mail->MsgHTML($message_body);
        $mail->IsHTML(true);  
        $result = $mail->Send();
        
        if($result){
            
        }else{
            
        }
        return $result;
    }
    

    ?>

<?php

if(isset($_POST['submit'])) {

    try {

        include '../../connection.php';
        include'../../functions.php';
    
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql ="Select * from users where username='$username' or  email='$email' and otp_verified !='YES' ";
        $ex = $con->query($sql);
        if(mysqli_num_rows($ex)>0){
                
                while($r = mysqli_fetch_assoc($ex)){
                    $otp_verified = $r['otp_verified'];
                    $eemail= $r['email'];
                }
                if($otp_verified != 'YES'){
                    
                    $otp = rand(100000, 999999);
            
                        $insert ="UPDATE users SET  `password` = '$hashedPassword', `otp` = '$otp', otp_verified='', email='$email'   where email='$eemail' and username='$username' ";
                        $ex2 = $con->query($insert);
                        if($ex2 == false){
                            echo $con->error;
                        }
                        if($ex2 == true){
                            send_otp($username, $otp);
                            
                            ?>
                            <script>alert("USER FOUND, OTP SENDED SUCCESSFULLY . PLEASE VERIFY !"); 
                            window.location.href='otp_verification.php?username=<?php echo $username?>&email=<?php echo $email ?>&company_name=<?php echo $company; ?>'; 
                            </script>
                            <?php
                        }
                }
                
                
        }else{
            
            $otp = rand(100000, 999999);
            
            $insert =" insert into users (`username`, `email`, `password`, `otp`) VALUES ('$username','$email','$hashedPassword', '$otp') ;";
            $ex2 = $con->query($insert);
            if($ex2 == false){
                echo $con->error;
            }
            if($ex2 == true){
                send_otp($username, $otp);
                
                ?>
                <script>alert("OTP SENDED SUCCESSFULLY . PLEASE VERIFY !"); 
                window.location.href='otp_verification.php?username=<?php echo $username?>&email=<?php echo $email; ?>'; 
                </script>
                <?php
            }
            
        }
    } catch (\Throwable $th) {
        throw $th;
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
                    <img src="/Imlogistics/Assets/images/icons8-male-user.gif" alt="Admin login gif">
                </div>
                
                <form id="signupForm" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" onchange="checkUser()"  id="username" name="username" required>
                        <div class="" id="usernameerror" ></div>

                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" onchange="checkEmail()" class="form-control" id="email" name="email" required>
                        <div class="" id="emailerror" ></div>

                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number:</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        <div class="invalid-feedback" id="passwordError" style="display: none;">Passwords do not match.</div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">Signup</button>
                    <p>Already have an account? <span><a href="admin_login.php">Login</a></span></p>
                </form>

            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="../../Assets/js/script.js"></script>


</body>


</html>