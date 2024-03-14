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



// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $companyname = $_POST["companyname"];
    $address1 = $_POST["address1"];
    $address2 = $_POST["address2"];
    $address3 = $_POST["address3"];
    $address4 = $_POST["address4"];
    $contactperson = $_POST["contactperson"];
    $contactname = $_POST["contactname"];
    $email = $_POST["email"];
    $website = $_POST["website"];
    $fromdate = $_POST["fromdate"];
    $tilldate = $_POST["tilldate"];
    $lotsuffix = $_POST["lotsuffix"];
    $billsuffix = $_POST["billsuffix"];
    $stno = $_POST["stno"];
    $servicetax = $_POST["servicetax"];

    // Check if companyname already exists
    $check_stmt = $con->prepare("SELECT * FROM company WHERE companyname = ?");
    $check_stmt->bind_param("s", $companyname);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    if ($check_result->num_rows > 0) {
        $isError = true;
        $message = "Company already exists.";
    } else {
        // Prepare and bind SQL statement
        $stmt = $con->prepare("INSERT INTO company (companyname, address1, address2, address3, address4, contactperson, contactname, email, website, fromdate, tilldate, lotsuffix, billsuffix, stno, servicetax) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssssss", $companyname, $address1, $address2, $address3, $address4, $contactperson, $contactname, $email, $website, $fromdate, $tilldate, $lotsuffix, $billsuffix, $stno, $servicetax);

        // Execute SQL statement
        if ($stmt->execute()) {
            $message = "Data inserted successfully";
        } else {
            $isError = true;
            $message = "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }

    // Close check statement and result
    $check_stmt->close();
    $check_result->close();
}

// Close connection

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
    include 'Partials/navbar2.php';


        menus(2, 'company.php');
    ?>
   
    <h3 class="mt-3 text-center">Create Company</h3>
    <div>
        <nav class="breadcrumb" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="company.php"><i class="fa fa-chevron-circle-left" style="font-size: 26px" aria-hidden="true"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page" >Create company</li>
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
                    <label for="companyName">Company</label>
                    <input type="text" class="form-control form-control-sm" id="companyname" name="companyname" placeholder="Company Name" required>
        
                    <p class="bg mt-3">POSTAL INFORMATION</p>
        
                    <label for="address1">Address</label>
                    <input type="text" class="form-control form-control-sm" id="address1" name="address1" placeholder="Address" required>
        
                    <label for="address2">Address 2</label>
                    <input type="text" class="form-control form-control-sm" id="address2" name="address2" placeholder="Address 2" required>
        
                    <label for="address3">Address 3</label>
                    <input type="text" class="form-control form-control-sm" id="address3" name="address3" placeholder="Address 3" required>
        
                    <label for="address4">Address 4</label>
                    <input type="text" class="form-control form-control-sm" id="address4" name="address4" placeholder="Address 4" required>
                </div>
        
                <div class="col-sm-4">
                    <p class="bg">CONTACT INFORMATION</p>
        
                    <label for="contactPerson">Contact Person</label>
                    <input type="text" class="form-control form-control-sm" id="contactperson" name="contactperson" placeholder="Contact Person" required>
        
                    <label for="contactName">Contact Name</label>
                    <input type="text" class="form-control form-control-sm" id="contactname" name="contactname" placeholder="Contact Name" required>
        
                    <label for="email">Email</label>
                    <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email" required>
        
                    <label for="website">Website</label>
                    <input type="text" class="form-control form-control-sm" id="website" name="website" placeholder="Website" required>
                </div>
        
                <div class="col-sm-4">
                    <p class="bg">Accounting period</p>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="fromDate">From Date</label>
                            <input type="date" class="form-control form-control-sm" id="fromDate" name="fromdate" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="tillDate">Till Date</label>
                            <input type="date" class="form-control form-control-sm" id="tillDate" name="tilldate" required>
                        </div>
                    </div>
        
                    <div class="row mt-3">
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
                        <p class="bg">Taxation period</p>
                        <div class="col-sm-6">
                            <label for="stNo">S.T. No</label>
                            <input type="text" class="form-control form-control-sm" id="stNo" name="stno" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="serviceTax">Service Tax@</label>
                            <input type="text" class="form-control form-control-sm" id="serviceTax" name="servicetax" required>
                        </div>
                    </div>
                  
                    
                    
                </div>
                
                  
                    <div class="row mt-4" style="margin: auto;width: min-content;">
                        <button class="btn btn-primary" type="submit">SUBMIT</button>
                    </div>
            </div>
        </form>

    </div>
    
   
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