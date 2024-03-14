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
    <meta http-equiv="refresh" content="300">
    <title>MODULE UPLOADS</title>
    <?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include 'connection.php';
    include 'cdnlinks.php';
    
    
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" >
    <script src="Assets/bootstrap/editableselect/jquery-1.12.4.min.js"></script>
    <script src="Assets/bootstrap/editableselect/jquery-editable-select.min.js"></script>
    <link href="Assets/bootstrap/editableselect/jquery-editable-select.min.css" rel="stylesheet">
    <link href="Assets/bootstrap/datatable/bootstrap.css" rel="stylesheet">

</head>
<body>
    <?php
    include 'connection.php';
    include 'Partials/navbar2.php';


        menus(1, 'entry.php');
      
    ?>
    
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
        
        .icon {
                width: max-content;
    color: steelblue;
    background: whitesmoke;
        }
        
        
        
    </style>
    <?php


echo $message = "";

// if (isset($_POST['submit'])) {
//     $data = $_POST['submit'];
//     $attachment = $_FILES['attachment'];
//     $modulename = $_POST['modulename'];

//     // Loop through each submitted module
//     for ($i = 0; $i < count($data); $i++) {
//         if ($data[$i] != "") {
            
//             $file_tmp = $attachment['tmp_name'][$i];
//             $file_size = $attachment['size'][$i];
//             $file_type = $attachment['type'][$i];
//             $module = $modulename[$i];
            
//             if (!empty($file_tmp) && is_uploaded_file($file_tmp)) {
                
//                 if ($file_size > 200000) { // 200000 bytes = 200KB
//                     $message = "File size exceeds the limit of 200KB for $data[$i]";
//                     $type = "danger";
//                 } else {
//                     $file_content = file_get_contents($file_tmp);

//                     if (empty($file_content)) {
//                         $message = "Please upload a file";
//                         $type = "danger";
//                     } else {

//                         $escaped_companyname = mysqli_escape_string($con, $_GET['companyname']);
//                         $escaped_customername = mysqli_escape_string($con, $_GET['customername']);
//                         $escaped_jobno = mysqli_escape_string($con, $_GET['jobno']);
//                         $escaped_modulename = mysqli_escape_string($con, $module);

//                         $query = "INSERT INTO `jobmodules`(`companyname`, `customername`, `jobno`, `modulename`, `attachment`)
//                                     VALUES (?, ?, ?, ?, ?)";
//                         $stmt = $con->prepare($query);
//                         $stmt->bind_param('sssss', $escaped_companyname, $escaped_customername, $escaped_jobno, $escaped_modulename, $file_content);

//                         if ($stmt->execute()) {
//                             $message = "File uploaded successfully.";
//                             $type = "success";
//                             $params = http_build_query($_GET);
//                             header("Location: modules_upload.php?$params");
//                         } else {
//                             $message = "Error uploading file: " . $stmt->error;
//                             $type = "danger";
                            
//                             break;
//                         }
//                     }
//                 }
//             } else {

//                 $message = "Error uploading file";
//                 $type = "danger";
//             }
//         }
//     }
// }





if(isset($_POST['submit'])){
    
    
    $attachment = $_FILES['attachment'];
    $modulename = $_POST['modulename'];
    
    for($i=0; $i<count($modulename); $i++){
        
        
        if(!empty($attachment['name'][$i])){
            
            
            if($attachment['type'][$i] == 'application/pdf'){
               
                if($attachment['size'][$i] > 400000){
                    
                    $message = "File size exceeds the limit of 200KB for $modulename[$i]";
                    $type = "danger";
                    
                }else{
            
                    $modulename[$i];
                    $attachment['name'][$i];
                    $attachment['type'][$i];
                    $attachment['size'][$i];
                    $file_tmp = $attachment['tmp_name'][$i];
                    $file_content = file_get_contents($file_tmp);
                   
                    
                    $escaped_companyname = mysqli_escape_string($con, $_GET['companyname']);
                    $escaped_customername = mysqli_escape_string($con, $_GET['customername']);
                    $escaped_jobno = mysqli_escape_string($con, $_GET['jobno']);
                    $escaped_modulename = mysqli_escape_string($con, $modulename[$i]);
                    
                    $query = "INSERT INTO `jobmodules`(`companyname`, `customername`, `jobno`, `modulename`, billoflading)
                                VALUES (?, ?, ?, ?, ?)";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param('sssss', $escaped_companyname, $escaped_customername, $escaped_jobno, $escaped_modulename, $file_content);
                    if ($stmt->execute()) {
                        $message = "File uploaded successfully.";
                        $type = "success";
                        $params = http_build_query($_GET);
                        header("Location: modules_upload.php?$params");
                    } else {
                        $message = "Error uploading file: " . $stmt->error;
                        $type = "danger";
                        
                        break;
                    }
                    
                }
                
            }else{
                $message  ="Please upload pdf only";
                $type="danger";
            }
            
            
        }
    }

    
}


?>
    
    
    
    
    <div class="container-fluid  d-flex mt-3"  style="border-bottom: 1px solid;padding-bottom: 20px;">
        
        
        <div class="cust" style="width: 15% !important">
            <div class="goback" style="padding-left: 37px;padding-top: 23px;">
                <div class="icon">
                    <a href="/Imlogistics/entry.php">
                         <img src="/Imlogistics/Assets/images/back.png">
                    </a>
                </div>
            </div>
        </div>
        
        <div class="cust w-15" style="padding-right: 11px">
            <label>Company</label>
            <input class="form-control form-control-sm" type="text" value="<?php echo isset($_POST['companyname'])? $_POST['companyname']: $_GET['companyname']; ?>" name="companyname" id="companyname" readonly>
        </div>
        
        <div class="cust w-15" style="padding-right: 11px">
            <label>Customer</label>
            <input class="form-control form-control-sm" type="text" value="<?php echo isset($_POST['customername'])? $_POST['customername']: $_GET['customername']; ?>" name="customername" id="customername" readonly>
        </div>
        
        <div class="cust w-15" style="padding-right: 11px">
            <label>Jobno</label>
            <input class="form-control form-control-sm" type="text" value="<?php echo isset($_POST['jobno'])? $_POST['jobno']: $_GET['jobno']; ?>" name="jobno" id="jobno" readonly>
        </div>
        
        
        <div class="cust w-15" style="padding-right: 11px">
            <?php
                if($message !=''){
                    
                    ?>
                    
                   <div class="alert alert-<?php echo $type; ?> mt-3" role="alert">
                        <?php echo $message; ?>
                    </div>
                    <?php
                    
                }
                ?>
        </div>

        
        
    </div>
    
    
<div class="container-fluid mt-3" style="">
    
    <div class="row">
        <div class="col-sm-5">
            <?php
            
            if(isset($_POST['delete'])){
                
                $id = $_POST['delete'];
                
                ?>  
                <form method="post" >
                    <p style="color: blue">Are you sure you want to delete  <?php echo $id ; ?></p>
                    <button type="submit" name="confirm_delete" value="<?php echo $id ; ?>" class="btn btn-success">YES</button>
                    <button type="submit" onclick="()=>{window.location.href='';}" class="btn btn-danger">NO</button>
                </form>
                <?php
                
            }
             if(isset($_POST['confirm_delete'])){
                    $jobno = $_POST['confirm_delete'];
                    $sql ="delete from jobmodules where id='$jobno'";
                    echo $sql;
                    $ex = $con->query($sql);
                    if($ex==true){
                        ?>
                        <div class="alert alert-info" role="alert">
                            Deleted
                        </div>
                        <?php
                    }
                }
            
            
            
            
            ?>
            
            <form method="post" enctype="multipart/form-data">  
                <table id="mydatatable" class="display" style="white-space: nowrap; width: 100%" >
                    <thead>
                        <tr style="background: #7de0bc;">
                          
                            <th>Jobno</th>
                            <th>Modulename</th>
                            <th>Attachment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <?php
                        
                        $companyname = $_GET['companyname'];
                        $customername = $_GET['customername'];
                        $jobno = $_GET['jobno'];
                        
                        $sql =" select * from modules";
                        
                        $ex = $con->query($sql);
                        if(mysqli_num_rows($ex)>0){
                            while($r = mysqli_fetch_assoc($ex)){
                                
                                $module_nam = $r['name'];
                                
                                
                                $insql = "Select * from jobmodules where modulename='$module_nam' and companyname='$companyname' and customername='$customername' and jobno='$jobno'  ";
                                $inex = $con->query($insql);
                                if(mysqli_num_rows($inex)>0){
                                    while($r1 = mysqli_fetch_assoc($inex)){
                                        ?>
                                        <tr>
                                           
                                            <td><?php  echo $r1['jobno']; ?></td>
                                            <td><?php  echo $r1['modulename']; ?></td>
                                            <td style=" color: green; font-weight: bold">
                                                <button type="submit" style="border: none;background: none;" value="<?php echo $r1['id']; ?>" name="viewpdf"><img src="/Imlogistics/Assets/images/pdf.png"></button>
                                            </td>
                                            <td><button type="submit" class="btn btn-info" value="<?php echo $r1['id'] ?>" name="delete">Delete </button></td>
                                            
                                        </tr>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <tr>
                                       
                                        <td><?php  echo $jobno; ?></td>
                                        <td><input style="width: min-content;font-size: 12px;border: hidden !important;" name="modulename[]" value="<?php  echo $module_nam;  ?>" class="form-control form-control-sm" readonly> </td>
                                        <td><input style="width: min-content;font-size: 12px;border: 1px solid red !important;" class="form-control form-control-sm" accept="application/pdf"  type="file" name="attachment[]"></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                }
                                
                            }
                        }
                        
                        
                        ?>
                       
                    </tbody>
                    
                </table>
                <div style="margin: auto;width: max-content;">
                    <button type="submit" class="btn btn-info" name="submit">Upload<i class="fa fa-upload" aria-hidden="true"></i></button>
                </div>
             </form>     
        </div>
        <div class="col-sm-7">
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
  
</div>



    
    


<?php

$con->close();

?>

<script src="Assets/bootstrap/datatable/js/jquery-3.7.0.js"></script>
<script src="Assets/bootstrap/datatable/js/dataTables.min.js"></script>
<script src="Assets/bootstrap/datatable/js/bootstrap4.min.js"></script>

<script>
    new DataTable('#mydatatable', {
    // ajax: '../ajax/data/arrays.txt'
});
</script>
    
</body>
</html>