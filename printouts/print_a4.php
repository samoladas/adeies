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

//print_r($_SESSION);
$prnum = $_GET['id'];
//echo $prnum;

$sql = "SELECT surname, name, sex, specialty, protocolnum, protocoldate, leavetypeid, startdate, days, description, supervisor_approved, admin_approved
        FROM users
        INNER JOIN leaves 
        ON leaves.userid = afm 
        AND idleaves = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$prnum]);
$row = $stmt->fetch();

$adeia_desc = return_leavedesc($row['leavetypeid'], $pdo);

?>
<!DOCTYPE html>
<html lang="el">

<head>
  <meta charset="UTF-8">
  <title>ΑΠΟΦΑΣΗ ΧΟΡΗΓΗΣΗΣ ΑΔΕΙΑΣ ΥΠΑΛΛΗΛΟΥ</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
    integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/printouts.css">
</head>

<body>
  <div class="formal-document">
    <div class="pure-g">

      <div class="pure-u-1-2">
        <div style="text-align: center;">
          <img src="../images/ethnosimo.jpg" height="60" width="60">
          <p>
            <b>
              Ελληνική Δημοκρατία <br>
              Υποργείο Παιδείας και Θρησκευμάτων <br>
              Περ/κή Δ/νση Π.Ε. και Δ.Ε. Κ. Μακεδονίας <br>
              Διεύθυνση Π.Ε. Σερρών
            </b>
          </p>
        </div>
        <br><br>
        <table class="formal-info">
          <tr>
            <td>Ταχ. Δ/νση</td>
            <td>: Κερασούντος 2</td>
          </tr>
          <tr>
            <td>Τ.Κ. - Πόλη</td>
            <td>: 62100, Σέρρες</td>
          </tr>
          <tr>
            <td>Πληροφορίες</td>
            <td>: Μ. Πετρά</td>
          </tr>
          <tr>
            <td>Τηλ.</td>
            <td>: 23210 47512</td>
          </tr>
          <tr>
            <td>Email</td>
            <td>: mail@dipe.ser.sch.gr</td>
          </tr>
          <tr>
            <td>Ιστοσελίδα</td>
            <td>: https://dipe.ser.sch.gr</td>
          </tr>
        </table>
      </div>
      <div class="pure-u-1-2">

        <div style="text-align: center;">
          <img src="../images/dpe-logo-login.png" height="100" width="100">
        </div>
        <p>
          <b>
            Σέρρες
            <?php echo date('d-m-Y', strtotime($row['protocoldate'])) ?><br>
            Αρ. Πρωτ.: Φ.12.1/
            <?php echo $row['protocolnum'] ?><br>
          </b>
        </p>
        <br><br><br><br><br>
        <h3>ΑΠΟΦΑΣΗ</h3>

      </div>

      <div class="pure-u-1">

        <h3>Θέμα: Χορήγηση άδειας</h3>
        <p><b>Ο Διευθυντής Εκπαίδευσης Σερρών, έχοντας υπόψη:</b></p>
        <ol>
          <li>Τις διατάξεις των άρθρων 48 και 49 του Ν.3528/2007 (ΦΕΚ 26/9-2-2007 τ. Α'), με θέμα "Κύρωση του Κώδικα
            κατάστασης Δημοσίων Πολιτικών Διοικητικών Υπαλλήλων και άλλες διατάξεις".
          </li>
          <li>
            Την αριθμ. ΔΙΔΑΔ/Φ.35.14/916/0ικ.4084/15-2-2007 εγκ. του Υπουρ. Εσωτερικών
          </li>
          <li>
            Την αριθμ. 170405/ΓΓ1/28-12-2021 (ΦΕΚ 6273/2021 τ. Β’) Απόφαση της Υπουργού Παιδείας και Θρησκευμάτων με
            θέμα: «Καθορισμός των ειδικότερων καθηκόντων και αρμοδιοτήτων των Διευθυντών Εκπαίδευσης».
          </li>
          <li>
            Την από
            <?php echo date('d-m-Y', strtotime($row['protocoldate'])) ?> αίτηση
            <?php
            if ($row['sex'] == 1) {
              echo ' της ' . $row['name'] . ' ' . $row['surname'] . '.';
            } else {
              echo ' του ' . rtrim($row['name'], 'Σ') . ' ' . rtrim($row['surname'], 'Σ') . '.';
            }
            ?>
          </li>
        </ol>
        <h3 style="text-align: center;">Αποφασίζουμε</h3>
        <p>Χορηγούμε
          <?php
          if ($row['sex'] == 1) {
            echo ' στην κ. ' . $row['name'] . ' ' . $row['surname'] . '.';
          } else {
            echo ' στον κ. ' . rtrim($row['name'], 'Σ') . ' ' . rtrim($row['surname'], 'Σ') . '.';
          }
          ?>
          διοικητικού υπαλλήλου κλάδου
          <?php echo $row['specialty']; ?>,
          άδεια με αποδοχές, <?php echo mb_convert_case($adeia_desc, MB_CASE_LOWER, "UTF-8"); ?> 
          <?php
          if ($row['days'] == 1){
            echo ' μίας (1) μέρας στις ';
            echo date('d-m-Y', strtotime($row['startdate'])).'.';
          }
          else {
            echo ' από '.date('d-m-Y', strtotime($row['startdate']));
            echo ' και διάρκειας '.$row['days'].' ημερών.';
          }
          ?>
        </p>

      </div>

      <div class="pure-u-1-2">
        
      </div>

      <div class="pure-u-1-2">

        <p class="text-align: center;">
          <b>Ο Διευθυντής Π.Ε. Σερρών</b>
          <br><br><br><br><br>
          <b>Ιωάννης Καραβασίλης</b>
        </p>

      </div>
    </div>

  </div>

</body>

</html>