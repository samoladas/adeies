<?php
// Check if the value parameter was passed
if (isset($_GET['value'])) {
    // Get the value passed as a parameter
    $value = $_GET['value'];

    echo $value;

    /*
    // Connect to the database using PDO
    $dsn = 'mysql:host=localhost;dbname=your_database_name';
    $username = 'your_database_username';
    $password = 'your_database_password';
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    $pdo = new PDO($dsn, $username, $password, $options);

    // Prepare the SQL query
    $stmt = $pdo->prepare("INSERT INTO your_table_name (column_name) VALUES (?)");

    // Bind the value to the parameter and execute the query
    $stmt->bindParam(1, $value);
    $stmt->execute();

    // Close the database connection
    $pdo = null; 
    */
}
?>
