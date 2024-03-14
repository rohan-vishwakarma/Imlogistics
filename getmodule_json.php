<?php

include 'connection.php';

// Validate inputs
if(empty($_POST['companyname']) || empty($_POST['customername']) || empty($_POST['jobno'])) {

    echo json_encode(array('error' => 'One or more required parameters are missing.'));
    exit; // Stop further execution
}

$companyname = $_POST['companyname'];
$customername = $_POST['customername'];
$jobno = $_POST['jobno'];

$outsql = "SELECT name FROM modules";
$ex = $con->query($outsql);

if(mysqli_num_rows($ex) > 0) {
    $moduledata = array();

    while ($row = mysqli_fetch_assoc($ex)) {
        $modulename = $row['name'];

        $sql = "SELECT * FROM jobmodules WHERE companyname = '$companyname' AND customername = '$customername' AND modulename = '$modulename' AND jobno = '$jobno'";
        $ex2 = $con->query($sql);
        
        if(mysqli_num_rows($ex2) == 0) {
            $moduledata[] = $modulename;
        }
    }
}

echo json_encode($moduledata);
?>
