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
</head>
<body>
    <?php
    include 'connection.php';
    include 'Partials/navbar2.php';
    
    
    $success_message = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate and sanitize input data
            if (!empty($_POST["name"])) {
                $name = trim($_POST["name"]);
        
                $stmt_check = $con->prepare("SELECT id FROM modules WHERE name = ?");
                $stmt_check->bind_param("s", $name);
                $stmt_check->execute();
                $stmt_check->store_result();
                if ($stmt_check->num_rows > 0) {
                    $error_message = "Module '$name' already exists.";
                } else {
                    $stmt_insert = $con->prepare("INSERT INTO modules (name) VALUES (?)");
                    if ($stmt_insert) {
                        $stmt_insert->bind_param("s", $name);
                        if ($stmt_insert->execute()) {
                            $success_message = "Module '$name' added successfully.";
                        } else {
                            $error_message = "Error: " . $stmt_insert->error;
                        }
                    } else {
                        $error_message = "Error in preparing statement: " . $con->error;
                    }
                }
            } else {
                $error_message = "Module name cannot be empty.";
            }
        }

        menus(2, 'modules.php');
    ?>
    
    
    <div class="container-fluid mt-4">
        
        <div class="row">
            <div class="col-sm-6" style="border-right: 2px solid;     border-radius: 3px;">
                <h3 style="border-bottom: 2px solid;    background-color: #78d0ab !important">Modules</h3>
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger" style="padding: 7px" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success" style="padding: 7px" role="alert">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="th">Module name</th>
                                    <th class="th">Created at</th>
                                    <th class="th">Updated at</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql ="Select * from modules ";
                                    $ex = $con->query($sql);
                                    if(mysqli_num_rows($ex)>0){
                                        while($r = mysqli_fetch_assoc($ex)){
                                            ?>
                                            
                                            <tr>
                                                <th><?php echo $r['name'];?></th>
                                                <th><?php echo $r['created_at'];?></th>
                                                <th><?php echo $r['updated_at'];?></th>
                                            </tr>
                                            
                                            <?php
                                        }
                                    }
                                ?>
                                
                               
                            </tbody>
                            
                        </table>
                                
                
            </div>
             <div class="col-sm-6">
                 <h3 style="border-bottom: 2px solid;background-color: #78d0ab !important;     border-radius: 3px;">Add Modules</h3>
                    <form method="post">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="name">Module Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary mt-4">Submit</button>
                            </div>
                        </div>
                    </form>
                                    
            </div>
        </div>
    </div>
    
    
    <script src="Assets/bootstrap/datatable/js/jquery-3.7.0.js"></script>
    <script src="Assets/bootstrap/datatable/js/dataTables.min.js"></script>
    <script src="Assets/bootstrap/datatable/js/bootstrap4.min.js"></script>
    
    
    <script src="Assets/bootstrap/editableselect/select2.min.js"></script>
    <script src="Assets/bootstrap/datatable/js/select2.min.css"></script>
    
    <script>
        new DataTable('#example');
        $(document).ready(function() {
                $('#modules').select2({
                    tags: true // Allow adding new options not present in the list
                });
            });
    </script>
    <style>
        #example {
                font-size: 73%;
                width: 100%;
                font-weight: 600;
        }
        
        .th{
                background-color: #78d0ab !important;
        }
    </style>
<?php

$con->close();

?>
</body>
</html>