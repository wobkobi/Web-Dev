<?php
require_once("../../conf/assign2.php");
$db = new mysqli($host, $user, $password, $dbName);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bsearch = $_POST['bsearch'];
    if (!empty($bsearch)) {
        // Handle searching by booking number
        $query = "SELECT * FROM bookings WHERE booking_number='$bsearch'";
    } else {
        // Handle searching for unassigned bookings within 2 hours
        $twoHoursFromNow = date("Y-m-d H:i:s", strtotime("+2 hours"));
        $query = "SELECT * FROM bookings WHERE status='unassigned' AND booking_date_time <= '$twoHoursFromNow'";
    }
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        $bookings = array();
        while ($row = $result->fetch_assoc()) {
            array_push($bookings, $row);
        }
        echo json_encode($bookings);
    } else {
        echo "No bookings found";
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Handle assigning a booking
    parse_str(file_get_contents("php://input"), $put_vars);
    $bookingNumber = $put_vars['bookingNumber'];
    $query = "UPDATE bookings SET status='assigned' WHERE booking_number='$bookingNumber'";
    if ($db->query($query) === TRUE) {
        echo "Booking " . $bookingNumber . " has been assigned";
    } else {
        echo "Error: " . $query . "<br>" . $db->error;
    }
}
$db->close();
?>