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
<html lang="el">

<head>
  <title>Εισάγετε τα στοιχεία εισόδου σας</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
    integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/login.css">
</head>

<body>
  <?php
  if (isset($_POST['submit'])) {
    echo '<h1>Η φόρμα υποβλήθηκε, έλεγχος στοιχείων</h1>';
    // save form data
    $form_email = $_POST['username'];
    $form_password = $_POST['password'];

    // retrieve user data from db
    $sql = "SELECT afm, email, role FROM users WHERE email = ? AND afm = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$form_email, $form_password]);
    $row = $statement->fetch();

    // check if user exists
    if ($row) {
      $_SESSION['userid'] = $row['afm'];
      $_SESSION['role'] = $row['role'];

      // redirect to page according to role
      switch ($_SESSION['role']) {
        case 1:
          echo '<h1>Ο χρήστης πιστοποιήθηκε επιτυχώς, ανακατεύθυνση στη σελίδα της εφαρμογής</h1>';
          header("refresh:1;url=./user/main.php");
          break;
        case 2:
          echo '<h1>Ο χρήστης πιστοποιήθηκε επιτυχώς, ανακατεύθυνση στη σελίδα της εφαρμογής</h1>';
          header("refresh:1;url=mains.php");
          break;
        case 3:
          echo '<h1>Ο χρήστης πιστοποιήθηκε επιτυχώς, ανακατεύθυνση στη σελίδα της εφαρμογής</h1>';
          header("refresh:1;url=maind.php");
          break;
      }
    } else {
      ?>
      <div class="pure-g">
        <div class="pure-u-1 pure-u-md-1-3"></div>
        <div class="pure-u-1 pure-u-md-1-3">
          <div class="form-container">
            <img src="./images/dpe-logo-login.png" alt="" width="120" height="120">
            <h2>Εισάγετε τα στοιχεία εισόδου σας</h2>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="pure-form pure-form-aligned">
              <fieldset>
                <div class="pure-control-group">
                  <label for="username">Email</label>
                  <input id="username" type="text" name="username" placeholder="Email">
                </div>
                <div class="pure-control-group">
                  <label for="password">Α.Φ.Μ.</label>
                  <input id="password" type="password" name="password" placeholder="Α.Φ.Μ.">
                </div>
                <div class="pure-controls">
                  <button type="submit" id="submit" name="submit" class="pure-button pure-button-primary">Είσοδος</button>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
        <div class="pure-u-1 pure-u-md-1-3"></div>
      </div>
      <?php
    }

  } else {
    ?>


    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"></div>
      <div class="pure-u-1 pure-u-md-1-3">
        <div class="form-container">
          <img src="./images/dpe-logo-login.png" alt="" width="120" height="120">
          <h2>Εισάγετε τα στοιχεία εισόδου σας</h2>
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="pure-form">
            <fieldset>
              <div class="pure-control-group">
                <label for="username">Email</label>
                <input id="username" type="text" name="username" placeholder="Email">
              </div>
              <div class="pure-control-group">
                <label for="password">Α.Φ.Μ.</label>
                <input id="password" type="password" name="password" placeholder="Α.Φ.Μ.">
              </div>
              <div class="pure-controls">
                <button type="submit" id="submit" name="submit" class="pure-button pure-button-primary">Είσοδος</button>
              </div>
            </fieldset>
          </form>
        </div>
        <footer>
          <p>&copy; 2023 Δ.Π.Ε. Σερρών - Τμήμα Δ' Πληροφορικής και Νέων Τεχνολογιών.</p>
        </footer>
      </div>
      <div class="pure-u-1 pure-u-md-1-3"></div>
    </div>


  </body>

  </html>

  <?php
  }
  ?>