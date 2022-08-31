<?php
    $servername = "localhost:3307";
    $username = "root";
    $password = "";

    try {   //try connecting to database
        $conn = new PDO("mysql:host=$servername;dbname=lms_attendance_tracker", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
        $conn->query("use lms_attendance_tracker");
        //echo "Connected successfully";
        } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
   
?>
