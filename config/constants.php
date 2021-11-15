<?php
    // start session
    ob_start();
    session_start();

    // Create Constate to store Non Repeating Values
    define('SITEURL', 'http://localhost/siaton-market/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'siaton-market');


    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn)); //Database connection
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn)); //Selecting Database
?>