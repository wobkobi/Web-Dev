<?php
require_once "../../conf/settings.php";

// Get POST data
$name = $_POST['name'];
$pwd = $_POST['pwd'];

// Connect to the database
$db = new mysqli($host, $user, $pswd, $dbnm);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Create table if not exists
$sql = "CREATE TABLE IF NOT EXISTS ajax (
        name VARCHAR(255) PRIMARY KEY,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL
    )";
$db->query($sql);

// Prepare and bind statement
$stmt = $db->prepare("SELECT name, password, email FROM ajax WHERE name = ?");
$stmt->bind_param("s", $name);

// Execute the statement
$stmt->execute();

// Bind result variables
$stmt->bind_result($db_name, $db_password, $db_email);

// Fetch the data
$found = false;
while ($stmt->fetch()) {
    if ($pwd == $db_password) {
        echo "Email address: " . $db_email;
        $found = true;
        break;
    } else {
        echo "Incorrect password.";
        $found = true;
        break;
    }
}

if (!$found) {
    echo "Name not found in the database.";
}

// Close the statement and connection
$stmt->close();
$db->close();
?>
