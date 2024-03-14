<?php

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $companyname = $_POST["companyname"];
    $customername = $_POST["customername"];
    $jobno = $_POST["jobno"];
    $modulename = $_POST["modulename"];

    // File upload handling
    $attachment = $_FILES["attachment"]["tmp_name"];
    if (!empty($attachment)) {
        $fileType = $_FILES["attachment"]["type"];
        $allowedTypes = array("application/pdf");
        
        // Check if the file is a PDF
        if (!in_array($fileType, $allowedTypes)) {
            echo "Error: Only PDF files are allowed.";
            exit();
        }

        // Read the file content
        $attachmentData = file_get_contents($attachment);
        $attachmentData = mysqli_real_escape_string($con, $attachmentData);
    } else {
        echo "Error: No file uploaded.";
        exit();
    }

    // Assuming you have sanitized your input to prevent SQL injection
    
    $insertSql = "INSERT INTO jobmodules (companyname, customername, jobno, modulename, attachment) VALUES ('$companyname', '$customername', '$jobno', '$modulename', '$attachmentData')";
    if ($con->query($insertSql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $con->error;
    }
}
?>
