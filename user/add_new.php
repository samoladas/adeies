<?php
// start the app session to store variables
session_start();
// send the appropriate headers
header('Content-type: text/html; charset=utf-8');
// require the db configuration file to make the PDO connection to the db
require '../dbconfig.php';
// function to connect to the database
require '../connection.php';
// construct the pdo object to connect to the database
$pdo = connect($host, $db, $user, $password);

// include the basic functions
include('functions.php');

//print_r($_SESSION); 
echo '<br>';
//print_r($_POST);

$sql = "INSERT INTO leaves(userid, protocolnum, protocoldate, leavetypeid, startdate, days, description) VALUES (?,?,?,?,?,?,?)";
$statement = $pdo->prepare($sql);
$statement -> execute([$_SESSION['userid'], $_POST['protocol'], $_POST['protocoldate'], $_POST['leavetype'], $_POST['startdate'], $_POST['days'], $_POST['description']]);

echo '<h2>Η άδεια του χρήστη: '.$_SESSION['name'].' '.$_SESSION['surname'].' με στοιχεία:</h2>';
echo '<table class="pure-table">';
echo '<tr><td>Αρ. Πρωτ.</td><td>'.$_POST['protocol'].'</td></tr>';
echo '<tr><td>Ημ/νία Πρωτ.</td><td>'.$_POST['protocoldate'].'</td></tr>';
echo '<tr><td>Διάρκεια</td><td>'.$_POST['days'].'</td></tr>';
echo '<tr><td>Είδος</td><td>'.return_leavedesc($_POST['leavetype'], $pdo).'</td></tr>';
echo '<tr><td>Περιγραφή</td><td>'.$_POST['description'].'</td></tr>';
echo '</table>';

echo '<h2>Καταχωρήθηκε επιτυχώς</h2>';

$_SESSION['post_add_new'] = $_POST;
//print_r($_SESSION); 

?>