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
    <title>JOB</title>
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


        menus(1, 'job.php');
        
$alert_class = "";
$alert_message = "";



    ?>
<form method="post">    
    <div class="container mt-4">

        <div class="row">
            <div class="col-sm-2">
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
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="jobno">Job No</label>
                    <input type="number" class="form-control form-control-sm" style="width: max-content !important;"  id="jobno" name="jobno" value="<?php echo isset($_POST['jobno']) ? $_POST['jobno'] : ''; ?>" required >
                </div>
            </div>
            
            <div class="col-sm-3">
                <div class="form-group">
                    
                    <button type="submit" class="btn btn-primary mt-3" name="getjob">SUBMIT</button>
                    
                </div>
            </div>
            
        </div>

    </div>
 


<main class="container mt-4">
    
    <div class="row">
    
        <div class="col-sm-5">  
            <h6 class="border-bottom pb-2 mb-0">Recent updates</h6>
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <?php
                
                
                if(isset($_POST['jobno'])){
                    
                   $companyname=$_POST['companyname'];
                   $jobno = $_POST['jobno'];
                   
                   ?>
                   
                   <div class="">
                        <?php
                        
                        $insql = "Select * from entry where companyname='$companyname' and jobno='$jobno'";
                        $ex1 = $con->query($insql);
                        if(mysqli_num_rows($ex1)){
                           
                           while($r1 = mysqli_fetch_assoc($ex1)){
                               
                               ?>
                               <p><b>Customer name:</b> <?php echo  $r1['customername']; ?></p>
                               <p><b>Indate :</b><?php echo $r1['indate']; ?></p>
                               <p><b>EDC :</b> <?php echo $r1['edc']; ?></p>
                               <p><b>Invoice no:</b> <?php echo $r1['invoice_no']; ?></p>
                               <?php
                               
                               
                           }
                           
                        }
                        
                        
                        
                        ?>
                        
                        
                    </div>
                   
                   <?php
                   
                   
                   
                   
                   $sql =" select * from jobmodules where companyname='$companyname' and jobno='$jobno'";
                   $ex = $con->query($sql);
                   if(mysqli_num_rows($ex)>0){
                       
                       while($r = mysqli_fetch_assoc($ex)){
                           
                           
                           
                           
                           ?>
                            <div class="d-flex text-body-secondary">
                              <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
                                  <title>Placeholder</title>
                                  <span>
                                    <button type="submit" style="border: none;background: none;" value="<?php echo $r['id']; ?>" name="viewpdf">
                                        <i class="fa fa-file-text" aria-hidden="true" style="font-size: 42px;margin-right: 18px;"></i>
                                            
                                    </button>
                                  </span>
                              <p class="pb-3 mb-0 small lh-sm border-bottom">
                                <strong class="d-block mb-1" style="color: blue"><?php echo $r['modulename']; ?> </strong>
                                <span style="display: block; color: black">PDF UPLOADED : <?php echo date('d-m-Y | h:i:s', strtotime( $r['datetime'])); ?></span>
                                <span style="display: block; color: black">APPROVAL : <?php echo $r['approve']; ?></span>
                                <span style="display: block; color: black"></span>
                                
                              </p>
                            </div>
    
                           
                           <?php
                           
                           
                       }
                       
                       
                   }else{
                       
                       ?>
                       <p style="color: red">Modules are pending</p>
                       <?php
                   }
                   
                   
                    
                }
                
                
                ?>
            </div>
        </div> 
        
        <div  class="col-sm-7">
            <?php
            if(isset($_POST['viewpdf'])){
                $id =  $_POST['viewpdf'];
                
                $sql = "SELECT attachment FROM jobmodules WHERE id = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->bind_result($pdf_data);
                $stmt->fetch();
                $stmt->close();
                
                // Output PDF data to iframe source
                echo '<iframe id="pdfFrame" src="data:application/pdf;base64,'.base64_encode($pdf_data).'" width="100%" height="500" style="border: none;background-color: white;"></iframe>';
                
            }
            ?>
        </div>
    </div>
</main>

</form>








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

        input , select {
            border: 1px solid black !important;
                color: black !important;
                font-weight: 600 !important;
                    
        }
        .es-visible  {
            font-size: smaller !important; /* Inherit font size from parent */
            font-weight: 500;
        }
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
<?php

$con->close();

?>
</body>
</html>