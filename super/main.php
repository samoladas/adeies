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
?>

<!DOCTYPE html>
<html>

<head>
    <title>Περιβάλλον Προϊσταμένου</title>
    <!--link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/pure-min.css" -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/basic.css">
    <link rel="stylesheet" href="../css/modal.css">
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
                <li class="pure-menu-item"><a href="history_dept.php" class="pure-menu-link">Ιστορικό τμήματος</a></li>
                <li class="pure-menu-item"><a href="../logout.php?logout=true" class="pure-menu-link">Αποσύνδεση</a>
                </li>
            </ul>
        </div>
    </div>


    <div class="content">
        <div class="spacer"></div>
        <div style="text-align: center">
            <img src="../images/dpe-logo-login.png" alt="" width="120" height="120">
            <h1>Διεύθυνση Π.Ε. Σερρών</h1>
            <h2>Σύστημα υποβολής αδειών υπαλλήλων Δ.Π.Ε. Σερρών</h2>
            <hr>
        </div>
        <div class="spacer"></div>
        <h2>Άδειες προς έγκριση για το τμήμα
            <?php echo return_dept($deptid, $pdo); ?>
        </h2>
        <div class="spacer"></div>
        <?php
        // $sql = "SELECT * FROM `leaves` WHERE userid IN (SELECT afm FROM users WHERE departmentid = ?)";
        $sql = "SELECT u.surname, u.name, u.sex, u.specialty, l.idleaves, l.protocolnum, l.protocoldate, l.leavetypeid, l.startdate, l.days, l.description, l.supervisor_approved, l.admin_approved
                FROM users as u
                INNER JOIN leaves as l 
                ON l.userid = u.afm and l.userid IN (SELECT afm FROM users WHERE departmentid = ?)";
        $statement = $pdo->prepare($sql);
        $statement->execute([$deptid]);
        $rows = $statement->fetchAll();

        // print all un - approved leaves
        echo '<table class="pure-table pure-table-bordered">';
        echo '<thead><tr><th>Αρ. Πρωτ.</td><td>Ημ/νία Πρωτ.</td><td>Όνομα</td><td>Επίθετο</td><td>Είδος άδειας</td><td>Ημ/νία έναρξης</td><td>Διάρκεια</td><td>Έγκριση Προϊστ/νου</td><td>Έγκριση Δ/ντη</td><td></td><tr></thead>';
        echo '<tbody>';

        foreach ($rows as $row) {
            echo '<tr>';
            echo '<td>' . $row['protocolnum'] . '</td><td>' . $row['protocoldate'] . '</td>';
            echo '<td>' . $row['name'] . '</td><td>' . $row['surname'] . '</td>';
            echo '<td>' . return_leavedesc($row['leavetypeid'], $pdo) . '</td><td>' . $row['startdate'] . '</td><td>' . $row['days'] . ' μέρα/μέρες </td>';
            echo '<td>'; // . yesno($row['supervisor_approved']) . '</td>';
            if ($row['supervisor_approved'] == 1) {
                echo 'ΝΑΙ</td>';
            } else {
                echo '<a href="#myModal" class="modal-link" data-value="' . $row['idleaves'] . '">Έγκριση</a>';

            }
            echo '<td>' . yesno($row['admin_approved']) . '</td>';
            if ($row['admin_approved'] == 1 && $row['supervisor_approved'] == 1) {
                echo '<td><a href="../printouts/print_a4.php?id=' . $row['idleaves'] . '" target="_blank">Εκτύπωση</a></td>';
            } else {
                echo '<td>Εκτύπωση</td>';
            }
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '<div class="spacer"></div>';

        //print all department users
        $sql = "SELECT afm, surname, name FROM users WHERE departmentid = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$deptid]);
        $rows = $statement->fetchAll();
        
        echo '<h2>Υπάλληλοι τμήματος '.return_dept($deptid, $pdo).'</h2>';
        echo '<table class="pure-table pure-table-bordered">';
        echo '<thead><tr><th>Όνομα</th><th>Επίθετο</th><th></th></tr></thead>';
        echo '<tbody>';

        foreach ($rows as $row) {
            echo '<tr>';
            echo '<td>'.$row['name'].'</td><td>'.$row['surname'].'</td>';
            echo '<td><a href=print_history.php?id='.$row['afm'].'>Εκτύπωση ιστορικού</a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        ?>
        <div class="spacer"></div>
    </div>

    <!-- Modal HTML -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span id="modal-close" class="close">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>


    <div class="footer">
        <p>&copy; 2023 Δ.Π.Ε. Σερρών - Τμήμα Δ' Πληροφορικής και Νέων Τεχνολογιών.</p>
    </div>

    <!--script src="./js/main.js"></script>
    <script src="./js/form_new.js"></script-->
    <script src="../js/modal.js"></script>

</body>

</html>