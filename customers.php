<?php
session_start();

    include 'connection.php';

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
    <title>Customers</title>
    <?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    include 'cdnlinks.php';
    ?>
</head>
<body>
    <?php
    include 'Partials/navbar2.php';


        menus(2, 'customers.php');
    ?>
    <style>
        .bg {
                background: lightblue;
        }
        
        input {
                font-weight: 600 !important;
                border: 1px solid !important;
        }
        
        .alert {
                margin: auto;
                width: max-content;
                padding-top: 0;
                padding-bottom: 0;
                color: black;
                background: #00cb74;
        }
        
        tr{
            border: 1px solid black;
        }
        td{
            border: 1px solid black;
        }
        
        table{
            border: 1px solid black;
            width: 100%;
        }
        
        .th {
                background-color: #78d0ab !important;
        }
        
       
    </style>
    
    <div style="display: flex;">
        <div style="width: 50%">
            <h3 class="mt-3 text-center  btn-primary"><a href="create_customer.php" style="text-decoration: none">Add Customer</a></h3>
        </div>

    </div>
    
    
    
    <div class="container">
        
        
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th class="th">Customer name</th>
                <th class="th">Address</th>
                <th class="th">Email</th>
                <th class="th">pincode</th>
                <th class="th">UserId</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql ="Select * from customers ";
                $ex = $con->query($sql);
                if(mysqli_num_rows($ex)>0){
                    while($r = mysqli_fetch_assoc($ex)){
                        ?>
                        
                        <tr>
                            <th><?php echo $r['name'];?></th>
                            <th><?php echo $r['cust_add1'];?></th>
                            <th><?php echo $r['email'];?></th>
                            <th><?php echo $r['pin_code'];?></th>
                            <th><?php echo $r['user'];?> </th>
                        </tr>
                        
                        <?php
                    }
                }
            ?>
            
           
        </tbody>
        
    </table>
        
    </div>
    
    
    
    <script src="Assets/bootstrap/datatable/js/jquery-3.7.0.js"></script>
    <script src="Assets/bootstrap/datatable/js/dataTables.min.js"></script>
    <script src="Assets/bootstrap/datatable/js/bootstrap4.min.js"></script>
    <script>
        new DataTable('#example');
    </script>
    <style>
        #example {
                font-size: 85%;
                width: 100%;
                font-weight: 600;
        }
    </style>
    

   
  


<?php

$con->close();

?>


</body>
</html>