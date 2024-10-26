<?php

    $host = 'localhost';
    $db = 'fms4_db';
    $username = 'root';
    $password = '';
    
    try {

        $conn = new PDO("mysql:host=$host;dbname=$db;", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {

        echo "failed: " . $e->getMessage();

    }

    


?>