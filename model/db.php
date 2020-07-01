<?php

require 'config/config.php';

function OpenCon() {
    $conn = null;

    try {
        $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USERNAME, PASSWORD);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "<script> console.log('Connection successfull!') </script>";
    }
    catch (PDOException $e) {
        echo "<script> console.log('Connection failed: " . $e->getMessage() . "') </script>";
    }

    return $conn;
}