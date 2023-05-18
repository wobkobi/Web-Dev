<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../conf/settings.php');

// Create connection
$conn = new mysqli($host, $user, $pswd, $dbnm);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table SQL
$sql = "CREATE TABLE IF NOT EXISTS BookingRequests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  booking_ref VARCHAR(8),
  cname VARCHAR(100) NOT NULL,
  phone VARCHAR(12) NOT NULL,
  unumber VARCHAR(100),
  snumber VARCHAR(100) NOT NULL,
  stname VARCHAR(100) NOT NULL,
  sbname VARCHAR(100),
  dsbname VARCHAR(100),
  pickup_date DATE NOT NULL,
  pickup_time TIME NOT NULL,
  booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  booking_status VARCHAR(50) DEFAULT 'unassigned'
)";

if ($conn->query($sql) === TRUE) {
    echo "Table BookingRequests created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Insert dummy data into table
$sql = "INSERT INTO BookingRequests (booking_ref, cname, phone, unumber, snumber, stname, sbname, dsbname, pickup_date, pickup_time)
VALUES ('ABCDEFGH', 'John Doe', '1234567890', '100', '100', 'Main St', 'Suburb1', 'Suburb2', '2023-05-18', '14:00:00')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}

// Retrieve data from table
$sql = "SELECT * FROM BookingRequests";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["cname"]. " - Phone: " . $row["phone"]. "<br>";
    }
} else {
    echo "0 results<br>";
}

// Drop table
$sql = "DROP TABLE BookingRequests";

if ($conn->query($sql) === TRUE) {
    echo "Table BookingRequests dropped successfully<br>";
} else {
    echo "Error dropping table: " . $conn->error . "<br>";
}

$conn->close();
?>
