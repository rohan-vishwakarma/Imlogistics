<?php


try {
    function fetch_table($tablename, $column){
    include 'connection.php';
    
    // Perform query
    $sql = "SELECT $column FROM $tablename";
    $ex = $con->query($sql);
    
    if (!$ex) {
        return []; 
    }
    
    if ($ex->num_rows > 0) {
        $rows = [];
        while ($row = $ex->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    } else {
        return []; 
    }
}
    
}catch(Exception $ex){
                            echo $e;
                        }


?>
