<?php

// start the app session to store variables
session_start();

// send the appropriate headers
header('Content-type: text/html; charset=utf-8');

// require the db configuration file to make the PDO connection to the db
require 'dbconfig.php';

// function to connect to the database
require 'connection.php';

// construct the pdo object to connect to the database
$pdo = connect($host, $db, $user, $password);
?>

<!DOCTYPE html>
<html>

<head>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>
        Φόρμα εισόδου
    </title>
</head>

<div class="container">

    <body>
        <?php
        if (isset($_POST['submit'])) {
            echo '<h1>Η φόρμα υποβλήθηκε, έλεγχος στοιχείων</h1>';

            //save form data
            $fm_username = trim($_POST['username']);
            $fm_password = trim($_POST['password']);

            // retrieve password from db
            // first create the sql statement with placeholders ?
            $sql = "SELECT username, password, name, role FROM users WHERE username=? AND password=?";
            // prepare the pdo statement
            $statement = $pdo->prepare($sql);
            // execute the statement
            $statement->execute([$fm_username, $fm_password]);
            // fetch (if it exists) the single row of the statement
            $row = $statement->fetch();

            // if the row containts a result, then the password and the username are correct
            if ($row) {
                echo '<h2>Το username και ο κωδικός είναι σωστός, ανακατεύθυνση στη σελίδα της εφαρμογής</h2>';
                $_SESSION['username'] = $fm_username;
                $_SESSION['name'] = $row['name'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['logged_in'] = true;
                header("refresh:3;url=mainapp.php");
            } else {
                echo '<h2>Δώσατε λανθασμένα στοιχεία εισόδου';
                session_destroy();
                echo '</h2><a href="login.php">Επιστροφή στη σελίδα εισόδου</a></h2>';
            }
        } else {
        ?>
        <h1>Φόρμα εισόδου</h1>
        <h2>Παρακαλώ εισάγεται τα στοιχεία σας</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

            <label for="username">Πληκτρολογήστε το όνομα χρήστη: </label>
            <input type="text" name="username" id="username" required>
            <br><br>
            <label for="password">Πληκτρολογήστε τον κωδικό σας: </label>
            <input type="password" name="password" id="password" required>
            <br><br>
            <button type="submit" name="submit" class="btn btn-primary">Είσοδος</button>
        </form>

    </body>
</div>

</html>
<?php
        }
        $pdo = null;
?>