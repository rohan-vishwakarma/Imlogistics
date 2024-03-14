<?php
session_start();


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
    <title>Entry</title>
    <?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    include 'cdnlinks.php';
    
    
    ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" >
<script src="Assets/bootstrap/editableselect/jquery-1.12.4.min.js"></script>
<script src="Assets/bootstrap/editableselect/jquery-editable-select.min.js"></script>
<link href="Assets/bootstrap/editableselect/jquery-editable-select.min.css" rel="stylesheet">




</head>
<body>
    <?php
    include 'connection.php';
    include 'Partials/navbar2.php';


       
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

            $jobno = $_POST['jobno'];
            
            $indate = $_POST['indate'];
            $edc = $_POST['edc'];
            $rate = $_POST['rate'];
            $billed = isset($_POST['billed']) ? true : 0;
            $invoice_no = $_POST['invoice_no'];
            $approve = isset($_POST['approve']) ? true : 0;

            // Insert data into database
            $stmt = $con->prepare("INSERT INTO entry (jobno, companyname, customername, indate, edc, rate, billed, invoice_no, approve) VALUES (?, ? , ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $jobno, $companyname,  $customername, $indate, $edc, $rate, $billed, $invoice_no, $approve);

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

 menus(1, 'entry.php');
        

    ?>
    
    
    <div class="container-fluid mt-4">

        <div class="row">
            <div class="col-sm-7" style="border-right: 2px solid;     border-radius: 3px;">
                <h3 style="border-bottom: 2px solid;    background-color: #78d0ab !important">Entries</h3>
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
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="th">Job no</th>
                                    <th class="th">Company</th>
                                    <th class="th">Customer</th>
                                    <th class="th">Indate</th>
                                    <th class="th">Invoice no</th>
                                    
                                    <th class="th">ACTION</th>
                                    <th class="th">UPLOAD MODULES </th>
                                    <th class="th">STATUS</th>
                                    <th class="th">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql ="Select * from entry ";
                                    $ex = $con->query($sql);
                                    if(mysqli_num_rows($ex)>0){
                                        while($r = mysqli_fetch_assoc($ex)){
                                            ?>
                                                <tr>
                                                    <th><?php echo $r['jobno'];?></th>
                                                    <th><?php echo $r['companyname'];?></th>
                                                    <th><?php echo $r['customername'];?></th>
                                                    <th><?php echo $r['indate'];?></th>
                                                    <th><?php echo $r['invoice_no'];?></th>
                                                    

                                                    <th style="color: red"><button style="border: hidden" type="submit" name="deleteentry" value="<?php echo $r['id'];?>"><i class="fa fa-trash" style="color: red; font-size: 21px" aria-hidden="true"></i></button></th>
                                                    <th><a style="font-size: 22px;" href="modules_upload.php?companyname=<?php echo $r['companyname']; ?>&customername=<?php echo $r['customername'] ?>&jobno=<?php echo $r['jobno'] ?>"><i class="fa-solid fa-upload"></i></a></th>
                                                    <th><?php echo $r['approve']==1? "Approved" : "Pending";?> </th>
                                                    <?php
                                                    if($r['approve'] == 1){
                                                        ?>
                                                        <td>
                                                            <button type="submit" class="b-none" style="background: none; border: none" name="submit_approve">
                                                                <i class="fa fa-thumbs-down" aria-hidden="true" style="color: blue"></i>    
                                                            </button>
                                                        </td>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <td>
                                                            <button type="submit" style="background: none; border: none" name="submit_approve">
                                                                <i class="fa fa-thumbs-up" aria-hidden="true" style="color: blue"></i>
                                                            </button>
                                                        </td>
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
                </form>
                
                <?php
                //delete entry 
                
                
                
                ?>
                
                
                
                
                
                        
                        
                            <div class="modal fade" id="myModal">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                            
                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                    <h5 class="modal-title">Job number: <span id="jobNo"></span></h5>
                                    | <h5 class="modal-title">Pdf name : <span id="pdfname"></span></h5>
                                    
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                  </div>
                            
                                  <!-- Modal body -->
                                  <div class="modal-body">
                                       <iframe id="pdfFrame" width="100%" height="500" style="border: none;"></iframe>
                                  </div>
                            
                                  <!-- Modal footer -->
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                  </div>
                            
                                </div>
                              </div>
                            </div>
                            
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            var viewPdfButtons = document.querySelectorAll('.view-pdf');
                                            viewPdfButtons.forEach(function (button) {
                                                button.addEventListener('click', function () {
                                                    var jobNo = button.getAttribute('data-jobno');
                                                    var pdflink = button.getAttribute('data-pdflink');
                                                    var pdfname = button.getAttribute('data-pdfname');
                                                    var pdfid = button.getAttribute('data-id');
                                                    
                                                    document.getElementById('jobNo').innerText = jobNo;
                                                    document.getElementById('pdfname').innerText = pdfname;
                                                    
                                                    // Set the source of the iframe to a PHP script that retrieves the PDF content
                                                    document.getElementById('pdfFrame').src = 'get_pdf.php?entry_id=' + pdfid;
                                                });
                                            });
                                        });
                                    </script>



                                
                
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
                 
                 <h3 style="border-bottom: 2px solid;background-color: #78d0ab !important;     border-radius: 3px;">Add Entry</h3>
                <form method="post" id="entryform" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="jobno">Company name</label>
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
                                 
                                 <script>
                                      
                                $('#companyname')
                                    .editableSelect()
                                    .on('select.editable-select', function (e, li) {
                                        $('#last-selected').html(li.val() + '. ' + li.text());
                                
                                        var companyname = $('#companyname').val()
                                        $.ajax({
                                            url: 'jobno_json.php',
                                            type: 'GET',
                                            data: { companyname: companyname },
                                            success: function(response) {
                                                $('#jobno').val(response);
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error:', error);
                                                $('#jobno').val("");
                                                
                                            }
                                        });
                                    });
                                 </script>
                                 
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="jobno">Customer name</label>
                                <select type="text" class="form-control form-control-sm" id="customername" name="customername" value="<?php echo isset($_POST['customername']) ? $_POST['customername'] : ''; ?>" required>

                                    <?php
                                        
                                        $array = fetch_table('customers','*');

                                         foreach($array  as $cust){
                                            ?>
                                            <option><?php echo $cust['name']; ?></option>
                                            <?php
                                        }
                                    
                                    ?>
                                    
                                 </select>
                                 <script>
                             
                                 
                                $('#customername')
                                    .editableSelect();

                                     
                                 </script>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="jobno">Job No</label>
                                <input type="number" class="form-control form-control-sm" id="jobno" name="jobno" value="<?php echo isset($_POST['jobno']) ? $_POST['jobno'] : ''; ?>" required readonly>
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
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="billed" style="display: block !important;">Billed</label>
                                <input type="checkbox" class="form-check-input" id="billed" name="billed" >
                            </div>
                        </div>
                        
                         
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="approve" style="display: block !important;">Approve</label>
                                <input type="checkbox"  class="form-check-input" id="approve" name="approve" >
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
    </style>
    

    <script src="Assets/bootstrap/datatable/js/jquery-3.7.0.js"></script>
    <script src="Assets/bootstrap/datatable/js/dataTables.min.js"></script>
    <script src="Assets/bootstrap/datatable/js/bootstrap4.min.js"></script>

    

    <script>
        new DataTable('#example');
       
    </script>
    <style>
        #example {
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