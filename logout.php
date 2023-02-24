<?php
  // Start the session
  session_start();
  
  // If the user clicks the logout link, unset the session variables and destroy the session
  if(isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php"); // Redirect the user to the login page
  }
?>