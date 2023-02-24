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

//fetch user data from the database
$sql = "SELECT * FROM users WHERE afm=?";
$statement = $pdo->prepare($sql);
$statement->execute([$_SESSION['userid']]);
$row = $statement->fetch();

//check if the user data is correct
if ($row) {
    $_SESSION['userid'] = $row['afm'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['surname'] = $row['surname'];
    $_SESSION['departmentid'] = $row['departmentid'];
}
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
                <li class="pure-menu-item"><a href="history_dept.php" class="pure-menu-link">Ιστορικό τμήματος</a></li>
                <li class="pure-menu-item"><a href="../logout.php?logout=true" class="pure-menu-link">Αποσύνδεση</a></li>
            </ul>
        </div>
    </div>


    <div class="content">
        <div class="spacer"></div>
        <div style="text-align: center">
            <img src="../images/dpe-logo-login.png" alt="" width="120" height="120">
            <h1>Διεύθυνση Π.Ε. Σερρών</h1>
            <h2>Σύστημα υποβολής αδειών υπαλλήλων Δ.Π.Ε. Σερρών</h2>
            <p>This is an example page using Pure CSS for the navigation menu and footer.</p>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2023 Δ.Π.Ε. Σερρών - Τμήμα Δ' Πληροφορικής και Νέων Τεχνολογιών.</p>
    </div>

    <!--script src="./js/main.js"></script>
    <script src="./js/form_new.js"></script-->

</body>

</html>