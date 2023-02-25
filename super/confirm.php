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

    $sql = "UPDATE leaves SET supervisor_approved = 1 WHERE idleaves = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$value]);

    echo '<h1>Η άδεια εγκρίθηκε επιτυχώς</h1>';

    $pdo = null; 
}
?>
