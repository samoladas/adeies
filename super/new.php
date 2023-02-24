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

$deptname = return_dept($_SESSION['departmentid'], $pdo);
$types = list_leavetypes($pdo);
$_SESSION['supervisor'] = return_supervisor($_SESSION['departmentid'], $pdo);

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
        <h1>Αίτηση νέας άδειας</h1>
        <h2>Συμπληρώστε τα στοιχεία της αίτησής σας:</h2>
        <div class="form-container">
            <form id="add_new_form" class="pure-form pure-form-aligned" action="" method="post">
                <fieldset>
                    <div class="pure-control-group">
                        <label for="name">Όνομα</label>
                        <input type="text" class="pure-input-1-3" id="name" name="name"
                            value="<?php echo $_SESSION['name']; ?>" readonly>
                        <!--span class="pure-form-message-inline">This is a required field.</span-->
                    </div>
                    <div class="pure-control-group">
                        <label for="surname">Επίθετο</label>
                        <input type="text" class="pure-input-1-3" id="surname" name="surname"
                            value="<?php echo $_SESSION['surname']; ?>" readonly>
                    </div>
                    <div class="pure-control-group">
                        <label for="department">Τμήμα</label>
                        <input type="text" class="pure-input-1-3" id="department" name="department"
                            value="<?php echo $deptname; ?>" readonly>
                    </div>
                    <div class="pure-control-group">
                        <label for="protocol">Αριθμός Πρωτ.</label>
                        <input type="text" class="pure-input-1-3" id="protocol" name="protocol">
                    </div>
                    <div class="pure-control-group">
                        <label for="protocoldate">Ημερομηνία Πρωτ.</label>
                        <input type="date" class="pure-input-1-3" id="protocoldate" name="protocoldate">
                    </div>
                    <div class="pure-control-group">
                        <label for="leavetype">Είδος άδειας</label>
                        <select id="leavetype" name="leavetype" class="pure-input-1-3">
                            <option value="">Επιλέξτε είδος άδειας</option>
                            <?php
                            foreach ($types as $typeid => $type) {
                                echo '<option value="' . $typeid . '">' . $type . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="pure-control-group">
                        <label for="startdate">Ημερομηνία έναρξης</label>
                        <input type="date" class="pure-input-1-3" id="startdate" name="startdate">
                    </div>
                    <div class="pure-control-group">
                        <label for="days">Αριθμός ημερών</label>
                        <input type="text" class="pure-input-1-3" id="days" name="days">
                    </div>
                    <div class="pure-control-group">
                        <label for="decription">Περιγραφή</label>
                        <textarea class="pure-input-1-3" id="description" name="description" form="add_new_form" 
                            placeholder="Γράψτε μια περιγραφή της άδειας"></textarea>
                        <div class="pure-controls">
                            <button type="submit" class="pure-button pure-button-primary">Υποβολή</button>
                        </div>
                </fieldset>
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2023 Δ.Π.Ε. Σερρών - Τμήμα Δ' Πληροφορικής και Νέων Τεχνολογιών.</p>
    </div>

    <script src="../js/form_new.js"></script>

</body>

</html>