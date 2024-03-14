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


$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $customername = trim($_POST["customername"]);
    $address1 = trim($_POST["address1"]);
    $address2 = trim($_POST["address2"]);
    $address3 = trim($_POST["address3"]);
    $address4 = trim($_POST["address4"]);
    $pincode = trim($_POST["pincode"]);
    $state = trim($_POST["state"]);
    $gstin = trim($_POST["gstin"]);
    $contactperson = trim($_POST["contactperson"]);
    $contactname = trim($_POST["contactname"]);
    $email = trim($_POST["email"]);
    $user = trim($_POST['userid']);
    $companyname = trim($_POST['companyname']);

    
    
    // Check if customer name already exists
    $stmt_check = $con->prepare("SELECT id FROM customers WHERE name = ?");
    $stmt_check->bind_param("s", $customername);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    if ($result_check->num_rows > 0) {
        $error_message = "$customername already exists.";
    } else {
        // Insert data into the database
        $stmt_insert = $con->prepare("INSERT INTO customers (name, companyname, cust_add1, cust_add2, cust_add3, pin_code, state, gstin, contact_person, contact_name, email, user) VALUES (?, ?, ?, ?,  ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("sssssissssss", $customername, $companyname, $address1, $address2, $address3, $pincode, $state, $gstin, $contactperson, $contactname, $email,  $user);
        if ($stmt_insert->execute()) {
            $success_message = "$customername created successfully";
        } else {
            $error_message = "Error in submitting data.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create customers</title>
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
   <?php if (!empty($error_message)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<?php if (!empty($success_message)): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $success_message; ?>
    </div>
<?php endif; ?>
    <h3 class="mt-3 text-center">Create Customer</h3>
    <div>
        <nav class="breadcrumb" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="customers.php"><i class="fa fa-chevron-circle-left" style="font-size: 26px" aria-hidden="true"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page" >Create customer</li>
          </ol>
        </nav>
    </div>
    
    
    <?php if (!empty($message)) { ?>
            <div class="alert <?php echo $isError ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
              
            </div>
        <?php } ?>
    
    
    <div class="container-fluid mt-4">
        <form method="post">
            <div class="row mt-3">
                

                
                <div class="col-sm-4">
                    <p class="bg">Company</p>
                    <label for="companyName">Customer name</label>
                    <input type="text" class="form-control form-control-sm" id="customername" name="customername" placeholder="" required>
        
                    <label for="companyName">Associated with</label>
                    <select type="text" class="form-control form-control-sm" id="companyname" value="<?php echo  isset($_POST['companyname'])? $_POST['companyname']:""; ?>" name="companyname" required>

                                    <?php
                                        
                                        include 'functions.php';
                                        $commpanyarray = fetch_table('company','*');
                                        
                                        foreach($commpanyarray  as $comp){
                                            ?>
                                            <option><?php echo $comp['companyname']; ?></option>
                                            <?php
                                        }

                                         
                                    
                                    ?>
                                    
                                 </select>        
        
                    <p class="bg mt-3">POSTAL INFORMATION</p>
        
                    <label for="address1">Address</label>
                    <input type="text" class="form-control form-control-sm" id="address1" name="address1"  required>
        
                    <label for="address2">Address 2</label>
                    <input type="text" class="form-control form-control-sm" id="address2" name="address2"  required>
        
                    <label for="address3">Address 3</label>
                    <input type="text" class="form-control form-control-sm" id="address3" name="address3"  required>
        
                    <label for="address4">Address 4</label>
                    <input type="text" class="form-control form-control-sm" id="address4" name="address4"  required>
                    
                    <label for="address4">Pincode</label>
                    <input type="text" class="form-control form-control-sm" id="pincode" name="pincode" required>
                </div>
        
                <div class="col-sm-4">
                    <p class="bg">CONTACT INFORMATION</p>
        
                    <label for="contactPerson">Contact Person</label>
                    <input type="text" class="form-control form-control-sm" id="contactperson" name="contactperson"  required>
        
                    <label for="contactName">Contact no</label>
                    <input type="text" class="form-control form-control-sm" id="contactname" name="contactname"  required>
        
                    <label for="email">Email</label>
                    <input type="email" class="form-control form-control-sm" id="email" name="email"  required>
                    
                    <?php
                        $stmt = $con->prepare("SELECT `StCode`, `StateName` FROM `state`");
                        $stmt->execute();
                        $result = $stmt->get_result();
                    
                    ?>
                    
                    <label for="email">State</label>
                    <select id="state" class="form-control form-control-sm" name="state" required>
                        <option value="">Select State</option>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <option value="<?php echo $row['StCode']; ?>"><?php echo $row['StateName']; ?></option>
                        <?php } ?>
                    </select>
                    
                    <label for="gstin">GSTIN</label>
                <input type="text" class="form-control form-control-sm" id="gstin" name="gstin" required>
                <small id="gstinHelp" class="form-text text-muted" style="color: red">GSTIN must be exactly 15 digits long.</small>

                </div>
        
                <div class="col-sm-4">
                    
                    <div class="row ">
                        <p class="bg">Prefix information</p>
                        <div class="col-sm-6">
                            <label for="lotSuffix">Lot Suffix</label>
                            <input type="text" class="form-control form-control-sm" id="lotSuffix" name="lotsuffix" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="billSuffix">Bill Suffix</label>
                            <input type="text" class="form-control form-control-sm" id="billSuffix" name="billsuffix" required>
                        </div>
                    </div>
        
                    <div class="row mt-3">
                        <p class="bg">Online information</p>
                        <div class="col-sm-6">
                            <label for="stNo">User Id</label>
                            <input type="text" class="form-control form-control-sm" id="userid" name="userid" required>
                        </div>
                        
                    </div>
                  
                    
                    
                </div>
                
                  
                    <div class="row mt-4" style="margin: auto;width: min-content;">
                        <button class="btn btn-primary" type="submit">SUBMIT</button>
                    </div>
            </div>
        </form>

    </div>
    
    <script>
       document.addEventListener('DOMContentLoaded', function() {
            // Get input element
            const gstinInput = document.getElementById('gstin');

            // Add event listener for input changes
            gstinInput.addEventListener('input', function() {
                // Check GSTIN length
                if (gstinInput.value.length !== 15) {
                    // Display error message
                    document.getElementById('gstinHelp').textContent = "GSTIN must be exactly 15 digits long.";
                    // Set input border color to red to indicate error
                    gstinInput.style.borderColor = 'red';
                } else {
                    // Clear error message
                    document.getElementById('gstinHelp').textContent = "";
                    // Reset input border color
                    gstinInput.style.borderColor = '';
                }
            });
        });
    </script>
    
   
   <style>
        .bg {
                background: lightblue;
        }
        
        input, select {
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
        
        thead {
            border: 2px solid;
            background: #54cbe4;
        }
        
        .breadcrumb {
                background: aliceblue;
                padding-top: 7px;
                padding-bottom: 2px;
                padding-left: 21px;

        }
        
                
        .col-sm-4 {
           
        }
    </style>


<?php

$con->close();

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</body>
</html>