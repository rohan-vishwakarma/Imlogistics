<?php
include 'connection.php';

$companyname = $_GET['companyname'];

$sql = "SELECT MAX(jobno) AS max_jobno FROM entry WHERE companyname = '$companyname'";

$result = $con->query($sql);

if ($result) {
    $row = $result->fetch_assoc();

    $max_jobno = $row['max_jobno'];

    // Check if max_jobno is NULL or empty string
    if ($max_jobno === null || $max_jobno === '') {
        // If no records found, set job number to 1
        echo 1;
    } else {
        // Increment the maximum job number by 1
        echo $max_jobno + 1;
    }
} else {
    echo "Error: " . $con->error;
}

$con->close();
?>
