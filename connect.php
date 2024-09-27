<?php
    $host = 'localhost'; 
    $dbname = 'byaheros';
    $username = 'root'; 
    $password = ''; 

    $conn = new mysqli($host, $username, $password, $dbname);


    if($conn === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>