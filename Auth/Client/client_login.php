<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if(isset($_SESSION['client'])){
    header('location: /Imlogistics/Client/index.php');
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLIENT LOGIN</title>
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
    include '../../connection.php';

    include '../../Partials/navbar.php';
    ?>
    <?php $message ="";
        if(isset($_POST['submit'])){
            
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $sql =" Select name, pass from customers where user='$username' ";
            $ex = $con->query($sql);
            if(mysqli_num_rows($ex)>0){
                while($r = mysqli_fetch_assoc($ex)){
                    $pass =  $r['pass'];
                    if($pass == ''){
                        header("location: client_verification.php?username=$username");
                    }else{
                        if(password_verify($password, $pass)){
                            $_SESSION['client'] = $username;
                            header("location: /Imlogistics/Client/index.php");
                        }else{
                            $message = "Incorrect password";
                        }
                    }
                }
            }else{
                $message = "Username not exist. please try again";
            }
        }
        ?>
    <div class="container mt-4">
        <form method="post">
            <div class="row">
                <div class="col-sm-8">
                </div>
                <div class="col-sm-4" style="border: 1px solid;border-radius: 6px;padding: 36px; background-color: white">
                <h2 class="text-center mb-4 mt-4" >
                    <img src="/Imlogistics/Assets/images/icons8-male-user.gif" alt="Admin login gif">
                    Client Login</h2>
                    <?php
                        if(!empty($message)){
                        ?>
                        <div class="alert alert-warning" role="alert">
                          <?php echo $message;  ?>
                        </div>
                        <?php
                        }
                        ?>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username'])?$_POST['username'] : ""; ?>" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password"  placeholder="Enter password">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">Login</button>

                </div>
            </div>
        </form>
    </div>
        
        
        
        
        
        

</body>
</html>