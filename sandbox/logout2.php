<?php
session_start();
header('Content-type: text/html; charset=utf-8');
?>

<?php
echo '<div class="spacer"></div>';
echo '<h2>Έχετε αποσυνδεθεί από την εφαρμογή. Επιστροφή στην σελίδα εισόδου</h2>';
session_destroy();
header("Location=index.php", true, 301);
exit;
?>