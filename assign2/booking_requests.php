<?php
require_once("../../conf/sqlinfo.inc.php");

// Create connection
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

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
  echo "Table BookingRequests created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $cname = $_POST['cname'];
  $phone = $_POST['phone'];
  $unumber = $_POST['unumber'];
  $snumber = $_POST['snumber'];
  $stname = $_POST['stname'];
  $sbname = $_POST['sbname'];
  $dsbname = $_POST['dsbname'];
  $pickup_date = $_POST['date'];
  $pickup_time = $_POST['time'];

  $sql = "INSERT INTO BookingRequests (cname, phone, unumber, snumber, stname, sbname, dsbname, pickup_date, pickup_time)
    VALUES ('$cname', '$phone', '$unumber', '$snumber', '$stname', '$sbname', '$dsbname', '$pickup_date', '$pickup_time')";

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    $booking_ref = "BRN" . str_pad($last_id, 5, "0", STR_PAD_LEFT);

    $sql = "UPDATE BookingRequests SET booking_ref='$booking_ref' WHERE id=$last_id";
    if ($conn->query($sql) === TRUE) {
      echo $booking_ref;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
?>