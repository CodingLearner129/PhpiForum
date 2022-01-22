<?php
    // Script to connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "iforum";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if(!$conn){
        // die("Sorry, Connection failed due to : " . mysqli_connect_error());
        die("Sorry, Connection failed!");
    }
?>