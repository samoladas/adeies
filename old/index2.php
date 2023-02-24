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


<!doctype html>
<html lang="el">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.104.2">
  <title>Signin Template · Bootstrap v5.2</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">

  <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="./sign-in/signin.css" rel="stylesheet">
</head>

<body class="text-center">
  <?php
  if (isset($_POST['submit'])) {
    echo '<h1>Η φόρμα υποβλήθηκε, έλεγχος στοιχείων</h1>';
    // save form data
    $form_email = $_POST['user_email'];
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
          header("refresh:3;url=main.php");
          break;
        case 2:
          echo '<h1>Ο χρήστης πιστοποιήθηκε επιτυχώς, ανακατεύθυνση στη σελίδα της εφαρμογής</h1>';
          header("refresh:3;url=mains.php");
          break;
        case 3:
          echo '<h1>Ο χρήστης πιστοποιήθηκε επιτυχώς, ανακατεύθυνση στη σελίδα της εφαρμογής</h1>';
          header("refresh:3;url=maind.php");
          break;
      }
    } else {
      ?>
      <main class="form-signin w-100 m-auto">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <img class="mb-4" src="./assets/brand/dpe-logo-login.png" alt="" width="100" height="100">
          <h1 class="h3 mb-3 fw-normal">Τα στοιχεία που δώσατε ήταν λάθος, παρακαλώ εισάγετε τα σωστά στοιχεία εισόδου σας
          </h1>

          <div class="form-floating">
            <input type="email" name="user_email" class="form-control" id="user_email" placeholder="name@example.com">
            <label for="user_email">Διεύθυνση email</label>
          </div>
          <div class="form-floating">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            <label for="password">ΑΦΜ</label>
          </div>
          <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Είσοδος</button>
          <p class="mt-5 mb-3 text-muted">&copy; 2023</p>
        </form>
      </main>
    <?php 
    }

  } else {
    ?>


    <main class="form-signin w-100 m-auto">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <img class="mb-4" src="./assets/brand/dpe-logo-login.png" alt="" width="100" height="100">
        <h1 class="h3 mb-3 fw-normal">Εισάγετε τα στοιχεία εισόδου σας</h1>

        <div class="form-floating">
          <input type="email" name="user_email" class="form-control" id="user_email" placeholder="name@example.com">
          <label for="user_email">Διεύθυνση email</label>
        </div>
        <div class="form-floating">
          <input type="password" name="password" class="form-control" id="password" placeholder="Password">
          <label for="password">ΑΦΜ</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Είσοδος</button>
        <!-- input class="w-100 btn btn-lg btn-primary" type="submit" id="submit" name="sumbmit" value="Είσοδος">
        <p class="mt-5 mb-3 text-muted">&copy; 2023</p>
      </form>
    </main>



  </body>

  </html>
<?php 
} 
?>