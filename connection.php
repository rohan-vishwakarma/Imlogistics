<?php

     $server="localhost";
     $dbusername="a1622eoz_Imlogistics";
     $dbpassword="Dhruv@Khush@1809";

    
    $dbname="a1622eoz_Imlogistics";
    $con = mysqli_connect($server, $dbusername, $dbpassword,$dbname);
    if(!$con){
        die("connection failed due to reaason" . mysqli_connect_error());
            }
    //echo "connection established";

?>
