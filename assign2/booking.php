<?php
// Harrison Raynes 20121017
// The server-side PHP file for processing booking form submissions.
ob_start();

// Include the database connection configuration file
require_once "../../conf/sqlinfo.inc.php";

// Establish a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create the BookingRequests table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS BookingRequests (
    booking_ref VARCHAR(8) PRIMARY KEY,
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

if ($conn->query($sql) === true) {
  echo "Table BookingRequests created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Retrieve the last ID from the table
  $result = $conn->query("SELECT COALESCE(MAX(CAST(SUBSTRING(booking_ref, 4) AS UNSIGNED)), 0) AS max_id FROM BookingRequests");

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_id = $row['max_id'] + 1;

    // Generate the booking reference
    $booking_ref = "BRN" . str_pad($last_id, 5, "0", STR_PAD_LEFT);

    // Prepare the INSERT statement
    $stmt = $conn->prepare("INSERT INTO BookingRequests (booking_ref, cname, phone, unumber, snumber, stname, sbname, dsbname, pickup_date, pickup_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind the parameters to the prepared statement
    $stmt->bind_param("ssssssssss", $booking_ref, $cname, $phone, $unumber, $snumber, $stname, $sbname, $dsbname, $pickup_date, $pickup_time);

    // Retrieve form data from $_POST array
    $cname = $_POST["cname"];
    $phone = $_POST["phone"];
    $unumber = $_POST["unumber"];
    $snumber = $_POST["snumber"];
    $stname = $_POST["stname"];
    $sbname = $_POST["sbname"];
    $dsbname = $_POST["dsbname"];
    $pickup_date = $_POST["date"];
    $pickup_time = $_POST["time"];

    // Execute the prepared statement
    if ($stmt->execute()) {
      ob_end_clean();

      // Return the booking reference, pickup date, and pickup time as JSON response
      echo json_encode([
        "booking_ref" => $booking_ref,
        "pickup_date" => $pickup_date,
        "pickup_time" => $pickup_time,
      ]);
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the prepared statement
    $stmt->close();
  }
}

// Close the database connection
$conn->close();
?>