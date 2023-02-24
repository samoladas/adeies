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

include('functions.php');

//fetch user data from the database
$sql = "SELECT * FROM users WHERE afm=?";
$statement = $pdo->prepare($sql);
$statement->execute([$_SESSION['userid']]);
$row = $statement->fetch();

//check if the user data is correct
if ($row) {
    $user = $_SESSION['userid'] = $row['afm'];
    $username = $_SESSION['name'] = $row['name'];
    $usersurname = $_SESSION['surname'] = $row['surname'];
    $deptid = $_SESSION['departmentid'] = $row['departmentid'];
}


$super = return_supervisor($deptid, $pdo);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Example Page</title>
    <!--link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/pure-min.css" -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/basic.css">
</head>

<body>
    <div class="header" style="height: 80px;">
        <div class="pure-menu pure-menu-horizontal pure-menu-scrollable" style="font-size: 24px;">
            <!-- img class="pure-menu-heading" src="./images/dpe-logo-login.png" alt="" width="70" height="70" -->
            <p class="pure-menu-heading">Δ.Π.Ε. ΣΕΡΡΩΝ</p>
            <ul class="pure-menu-list">
                <li class="pure-menu-item">Χρήστης:
                    <?php echo $_SESSION['name'] . ' ' . $_SESSION['surname'] ?>
                </li>
                <li class="pure-menu-item"><a href="new.php" class="pure-menu-link">Αίτηση</a></li>
                <li class="pure-menu-item"><a href="history.php" class="pure-menu-link">Ιστορικό</a></li>
                <li class="pure-menu-item"><a href="../logout.php?logout=true" class="pure-menu-link">Αποσύνδεση</a>
                </li>
            </ul>
        </div>
    </div>


    <div class="content">
        <div class="spacer"></div>
        <h1>Ιστορικό αδειών</h1>
        <?php
        //print_r($_SESSION);
        $sql = "SELECT * FROM leaves WHERE userid = ? ORDER BY protocoldate DESC";
        $statement = $pdo->prepare($sql);
        $statement->execute([$user]);
        $rows = $statement->fetchAll();

        echo '<table class="pure-table pure-table-bordered">';
        echo '<thead><tr><th>Αρ. Πρωτ.</td><td>Ημ/νία Πρωτ.</td><td>Είδος άδειας</td><td>Ημ/νία έναρξης</td><td>Διάρκεια</td><td>Έγκριση Προϊστ/νου</td><td>Έγκριση Δ/ντη</td><td></td><tr></thead>';
        echo '<tbody>';
        
        foreach ($rows as $row) {
            echo '<tr>';
            echo '<td>'.$row['protocolnum'].'</td><td>'.$row['protocoldate'].'</td>';
            echo '<td>'.return_leavedesc($row['leavetypeid'],$pdo).'</td><td>'.$row['startdate'].'</td><td>'.$row['days'].' μέρα/μέρες </td>';
            echo '<td>'.yesno($row['supervisor_approved']).'</td><td>'.yesno($row['admin_approved']).'</td>';
            echo '<td><a href="print_adeia.php?id='.$row['idleaves'].'" target="_blank">Εκτύπωση</a></td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        ?>

        <div class="spacer"></div>


    </div>

    <div class="footer">
        <p>&copy; 2023 Δ.Π.Ε. Σερρών - Τμήμα Δ' Πληροφορικής και Νέων Τεχνολογιών.</p>
    </div>

    <!--script src="./js/main.js"></script>
    <script src="./js/form_new.js"></script-->

</body>

</html>