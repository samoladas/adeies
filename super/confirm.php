<?php
// start the app session to store variables
session_start();
// send the appropriate headers
header('Content-type: text/html; charset=utf-8');
// require the db configuration file to make the PDO connection to the db
require '../dbconfig.php';
// function to connect to the database
require '../connection.php';

//include the functions
include('functions.php');

// construct the pdo object to connect to the database
$pdo = connect($host, $db, $user, $password);

// Check if the value parameter was passed
if (isset($_GET['idleaves'])) {
    // Get the value passed as a parameter
    $value = $_GET['idleaves'];

    echo $value;

    /*
    // Connect to the database using PDO
    $dsn = 'mysql:host=localhost;dbname=your_database_name';
    $username = 'your_database_username';
    $password = 'your_database_password';
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    $pdo = new PDO($dsn, $username, $password, $options);

    // Prepare the SQL query
    $stmt = $pdo->prepare("INSERT INTO your_table_name (column_name) VALUES (?)");

    // Bind the value to the parameter and execute the query
    $stmt->bindParam(1, $value);
    $stmt->execute();

    // Close the database connection
    $pdo = null; 
    */
}
?>
