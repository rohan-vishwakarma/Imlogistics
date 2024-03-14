<?php



include 'connection.php';

if(isset($_GET['entry_id'])) {
    $entry_id = $_GET['entry_id'];
    
    // Fetch the entry from the database
        $stmt = $con->prepare("SELECT upload_file_name, attachment FROM entry WHERE id = ?");
    $stmt->bind_param("i", $entry_id);
    $stmt->execute();
    $stmt->bind_result($file_name, $file_content);
    
    if($stmt->fetch()) {
        // Output the appropriate HTTP headers for a PDF file
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=".$file_name);
        
        // Output the BLOB data
        echo $file_content;
        
        exit; // Stop further execution
    } else {
        // Entry not found
        echo "Entry not found.";
    }
    
    $stmt->close();
} else {
    // No entry ID provided
    echo "No entry ID provided.";
}
?>
