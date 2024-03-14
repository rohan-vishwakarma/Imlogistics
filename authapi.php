<?php

include 'connection.php';

$sql = "SELECT * FROM users";

$result = $con->query($sql);

$rows = array();
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

// Close the connection
$con->close();

// Set the Content-Type header to JSON
header('Content-Type: application/json');


echo json_encode($rows);


?>
