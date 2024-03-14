<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    
 
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
    <title>Entry</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" >
    <script src="/Imlogistics/Assets/bootstrap/editableselect/jquery-1.12.4.min.js"></script>
    <script src="/Imlogistics/Assets/bootstrap/editableselect/jquery-editable-select.min.js"></script>
    <link href="/Imlogistics/Assets/bootstrap/editableselect/jquery-editable-select.min.css" rel="stylesheet">
    <link href="/Imlogistics/Assets/bootstrap/bootstrap.min.css" rel="stylesheet">
    <script src="/Imlogistics/Assets/bootstrap/bootstrap.bundle.min.js"></script>
    
    <script src="/Imlogistics/Assets/bootstrap/datatable/js/jquery-3.7.0.js"></script>
    <script src="/Imlogistics/Assets/bootstrap/datatable/js/dataTables.min.js"></script>
    <script src="/Imlogistics/Assets/bootstrap/datatable/js/bootstrap4.min.js"></script>

</head>
<body>
    <?php
    include '../connection.php';
    include '../Partials/clientnavbar.php';
    
    
    $client = $_SESSION['client'];
    $sql = " select name, companyname from customers where  user='$client'  ";
    $ex = $con->query($sql);
    if(mysqli_num_rows($ex)>0){
        while($r = mysqli_fetch_assoc($ex)){
         
           $customer =  $r['name'];
           $company = $r['companyname'];
            
        }
    }


       
$alert_class = "";
$alert_message = "";
$companyname ="";
$customername ="";
if (isset($_POST['addentry'])) {
    // Check if customer exists
$companyname=$_POST['companyname'];
$customername = $_POST['customername'];

// Check if company exists
$check_company_stmt = $con->prepare("SELECT COUNT(*) FROM company WHERE companyname = ?");
$check_company_stmt->bind_param("s", $companyname);
$check_company_stmt->execute();
$check_company_stmt->bind_result($company_count);
$check_company_stmt->fetch();
$check_company_stmt->close();

if ($company_count == 0) {
    // Company doesn't exist, display error message
    $alert_class = "alert-danger";
    $alert_message = "Company does not exist. Please create the company first.";
} else {
    // Company exists, proceed with checking customer
    $check_customer_stmt = $con->prepare("SELECT COUNT(*) FROM customers WHERE name = ?");
    $check_customer_stmt->bind_param("s", $customername);
    $check_customer_stmt->execute();
    $check_customer_stmt->bind_result($customer_count);
    $check_customer_stmt->fetch();
    $check_customer_stmt->close();

    if ($customer_count == 0) {
        // Customer doesn't exist, display error message
        $alert_class = "alert-danger";
        $alert_message = "Customer does not exist. Please create the customer first.";
    } else {
        
        
            $billoflading = $_FILES['billoflading'];
            if($billoflading['size'] > 400000){
                $alert_message = "File size excedded. should be less than 400kb";
                $alert_class = "alert-danger";
            }else{
                
                if($billoflading['type'] != 'application/pdf'){
                    $alert_message = "only support pdf format";
                    $alert_class = "alert-danger";
                }else{
                    
                    $file_tmp = $billoflading['tmp_name'];
                    $file_content = file_get_contents($file_tmp);
                    
                    
                    $jobno = $_POST['jobno'];
            
                    $indate = $_POST['indate'];
                    $edc = $_POST['edc'];
                    $rate = $_POST['rate'];
                    $invoice_no = $_POST['invoice_no'];
        
                    // Insert data into database
                    $stmt = $con->prepare("INSERT INTO entry (jobno, companyname, customername, indate, edc, rate, invoice_no, created_by, billoflading) VALUES (?, ? , ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssssss", $jobno, $companyname,  $customername, $indate, $edc, $rate, $invoice_no, $client, $file_content );
        
                    if ($stmt->execute()) {
                        $alert_class = "alert-success";
                        $alert_message = "Entry Added Successfully";
                        ?>
                        
                        <script>document.getElementById("entryform").reset();</script>
                        <?php
                      
                    } else {
                        $alert_class = "alert-danger";
                        $alert_message = "Error inserting data: " . $stmt->error;
                    }
                    $stmt->close();
                }
                
            }
            

           
        
    }
}

}
 menus(1, 'entry.php');
    ?>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-7" style="border-right: 2px solid;     border-radius: 3px;">
                <h3 style="border-bottom: 2px solid; font-size: 19px;"><i  style="color: tomato;" class="fa fa-building" aria-hidden="true"></i><?php echo $customer; ?></h3>
                <?php
                if(isset($_POST['deleteentry'])){
                    
                    ?>          <form method="post" style="margin-left: auto;width: 50%;">
                                    <p style="color: blue">Are you sure you want to delete this job no: <?php echo $_POST['deleteentry'] ; ?></p>
                                    <button type="submit" name="confirm_delete" value="<?php echo $_POST['deleteentry'] ; ?>" class="btn btn-success">YES</button>
                                    <button type="submit" onclick="()=>{window.location.href='';entry.php}" class="btn btn-danger">NO</button>
                                </form>
                    <?php
                }
                if(isset($_POST['confirm_delete'])){
                    $jobno = $_POST['confirm_delete'];
                    $sql ="delete from entry where id='$jobno'";
                    $ex = $con->query($sql);
                    if($ex==true){
                        ?>
                        <p style=" margin-top: 0;margin-bottom: 1rem;color: #000000;border: 1px solid;text-align: -webkit-center;width: inherit;background: #e8feff;">
                            Job no <?php echo $jobno; ?> Deleted</p>
                        <?php
                    }
                }
                ?>
                <form method="post">
                        <table id="mytable" class="table table-striped table-bordered" style="width:100%; font-size: 12px;">
                            <thead>
                                <tr>
                                    <th class="th" style="text-align: center">Job no</th>
                                    <th class="th" style="text-align: center">Indate</th>
                                    <th class="th" style="text-align: center">Invoice no</th>
                                    <th class="th" style="text-align: center">Approve</th>
                                    <th class="th" style="text-align: center">ACTION</th>
                                    <th class="th" style="text-align: center">UPLOAD MODULES </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql ="Select * from entry where customername='$customer' and companyname='$company' ";
                                    $ex = $con->query($sql);
                                    if(mysqli_num_rows($ex)>0){
                                        while($r = mysqli_fetch_assoc($ex)){
                                            ?>
                                                <tr>
                                                    <th style="text-align: center"><?php echo $r['jobno'];?></th>
                                                    <th style="text-align: center"><?php echo date('d-m-Y', strtotime($r['indate']));?></th>
                                                    <th style="text-align: center"><?php echo $r['invoice_no'];?></th>
                                                    <th style="text-align: center"><?php echo $r['approve'];?> </th>
                                                    <?php
                                                    
                                                    if($r['approve'] == 1){
                                                        
                                                        ?>
                                                        <th style="text-align: center">--</th>
                                                        <th style="text-align: center;     padding: 0;"><a style="font-size: 22px;" href="modules_upload.php?companyname=<?php echo $r['companyname']; ?>&customername=<?php echo $r['customername'] ?>&jobno=<?php echo $r['jobno'] ?>"><i class="fa-solid fa-upload" style="font-size: 17px;"></i></a></th>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <th style="color: red; text-align: center"><button style="border: hidden" type="submit" name="deleteentry" value="<?php echo $r['id'];?>"><i class="fa fa-trash" style="color: red; font-size: 15px" aria-hidden="true"></i></button></th>
                                                        <th style="midnightblue;text-align: center">Wait for approval</th>
                                                        <?php
                                                        
                                                    }
                                                    
                                                    ?>

                                                </tr>
                                           
                                            <?php
                                        }
                                    }
                                ?>
                                
                               
                            </tbody>
                            
                        </table>
                        <script>
                            new DataTable('#mytable');
                           
                        </script>
                </form>
            </div>
             <div class="col-sm-5">
                 
                 <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Error message -->
                <?php
                if($alert_message !=''){
                    
                    ?>
                    
                   <div class="alert <?php echo $alert_class; ?>" role="alert">
                        <?php echo $alert_message; ?>
                    </div>
                    <?php
                    
                }
                ?>
                 
                 <h3 style="border-bottom: 2px solid;     border-radius: 3px; font-size: 19px">Add Entry</h3>
                <form method="post" id="entryform" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="jobno">Company name</label>
                                <input type="text" class="form-control form-control-sm" id="companyname" value="<?php echo $company; ?>" name="companyname" readonly>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="jobno">Customer name</label>
                                <input type="text" class="form-control form-control-sm" id="customername" name="customername" value="<?php echo $customer; ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?php
                                    $client = $_SESSION['client'];
                                    $sql = " select jobno from entry where companyname='$company' ";
                                    $ex = $con->query($sql);
                                    if(mysqli_num_rows($ex)>0){
                                        while($r = mysqli_fetch_assoc($ex)){
                                         
                                           $jobno =  $r['jobno'] + 1;
                                        }
                                    }else{
                                        $jobno = 1;
                                    }
                                ?>
                                <label for="jobno">Job No</label>
                                <input type="number" class="form-control form-control-sm" id="jobno" name="jobno" value="<?php echo $jobno; ?>" required readonly>
                            </div>
                        </div>
                       

                    </div>
                    <div class="row">
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="indate">In Date</label>
                                <input type="date" class="form-control" id="indate" name="indate" value="<?php echo isset($_POST['indate']) ? $_POST['indate'] : date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="edc">EDC</label>
                                <input type="date" class="form-control form-control-sm" id="edc" name="edc" value="<?php echo isset($_POST['edc']) ? $_POST['edc'] : ''; ?>" required readonly>
                            </div>
                        </div>
                        
                        <script>
                            document.getElementById('indate').addEventListener('change', function() {
                                var indate = new Date(this.value);
                                var edc = new Date(indate.getTime() + (30 * 24 * 60 * 60 * 1000)); // Adding 30 days
                                var edcFormatted = edc.toISOString().slice(0,10);
                                document.getElementById('edc').value = edcFormatted;
                            });
                            
                             function calculateEDC() {
                                    var indate = new Date(document.getElementById('indate').value);
                                    var edc = new Date(indate.getTime() + (30 * 24 * 60 * 60 * 1000)); // Adding 30 days
                                    var edcFormatted = edc.toISOString().slice(0,10);
                                    document.getElementById('edc').value = edcFormatted;
                                }
                            
                                document.getElementById('indate').addEventListener('change', calculateEDC);
                            
                                // Calculate EDC when the page loads
                                window.addEventListener('load', function() {
                                    calculateEDC();
                                });
                        </script>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="rate">Rate</label>
                                <input type="number" class="form-control form-control-sm" id="rate" name="rate" value="<?php echo isset($_POST['rate']) ? $_POST['rate'] : ''; ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="invoice_no">Invoice No</label>
                                <input type="number" class="form-control form-control-sm" id="invoice_no" name="invoice_no" value="<?php echo isset($_POST['invoice_no']) ? $_POST['invoice_no'] : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="invoice_no">Bill of lading</label>
                                <input type="file" class="form-control form-control-sm" accept="application/pdf" id="billoflading" name="billoflading" required>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    <div style="margin: auto; width: 50%">
                                            <button type="submit" name="addentry" class="btn btn-primary mt-3">Add entry</button>

                    </div>
        
                </form>

            </div>
        </div>
        
    </div>
    <style>
    th, td{
        border: 1px solid;
    }
    
    thead{
        border: 1px solid;
    }
        .th {
                background-color: #78d0ab !important;
        }
        #mytable {
                font-size: 77%;
                width: 100%;
                font-weight: 600;
        }
        input {
            border: 1px solid black !important;
                color: black !important;
                font-weight: 600 !important;
        }
        .es-visible  {
            font-size: smaller !important; /* Inherit font size from parent */
            font-weight: 500;
        }
    </style>

<?php

$con->close();

?>
</body>
</html>