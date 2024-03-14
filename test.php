<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'connection.php';
// Assuming you have already established a database connection
$entry_id = 23;

// Assuming $con is your MySQLi connection object
$query = "SELECT attachment, upload_file_name FROM entry WHERE id = " . intval($entry_id);
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $file_content = $row['attachment'];
    $upload_file_name = $row['upload_file_name'];
    
    header("Content-type: application/pdf");
    header('Content-disposition: inline; filename="' . $upload_file_name . '"');
    header('Content-length: ' . strlen($file_content));
    
    echo $file_content;
} else {
    echo "Error: Entry not found.";
}

mysqli_close($con);
?>
