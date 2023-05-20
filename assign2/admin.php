<?php
require_once "../../conf/sqlinfo.inc.php";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['bsearch'])) {
  $bsearch = $conn->real_escape_string($_GET['bsearch']);

  if (!empty($bsearch)) {
    $query = "SELECT * FROM bookings WHERE reference = '$bsearch'";
  } else {
    $query = "SELECT * FROM bookings WHERE pickupTime >= NOW() AND pickupTime < DATE_ADD(NOW(), INTERVAL 2 HOUR) AND status = 'unassigned'";
  }
  
  $result = $conn->query($query);

  $bookings = array();
  while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
  }
  
  echo json_encode($bookings);

} elseif (isset($_GET['assign'])) {
  $assign = $conn->real_escape_string($_GET['assign']);
  $query = "UPDATE bookings SET status = 'assigned' WHERE reference = '$assign'";
  
  if ($conn->query($query) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $conn->error;
  }
}

$conn->close();
?>
