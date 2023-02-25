<?php
session_start();
header('Content-type: text/html; charset=utf-8');
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
        session_destroy();
        echo '<h2>Έχετε αποσυνδεθεί από την εφαρμογή.
        <br><a href="index.php">Επιστροφή στην σελίδα εισόδου</a></h2>';
        ?>
    </body>
</div>

</html>