<?php
require_once "../../conf/sqlinfo.inc.php";

// Get the database connection
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the search request
if (isset($_GET["bsearch"])) {
    $bsearch = $_GET["bsearch"];

    // Validate the booking reference number format
    if (!empty($bsearch) && !preg_match("/^BRN\d{5}$/", $bsearch)) {
        die("Invalid booking reference number format");
    }

    // Prepare the SQL query
    $sql = "SELECT * FROM BookingRequests WHERE ";
    if (empty($bsearch)) {
        $sql .= "pickup_date >= CURDATE() AND pickup_time >= CURTIME() AND ";
    } else {
        $sql .= "booking_ref = '$bsearch' AND ";
    }
<<<<<<< HEAD
    $sql .= "booking_status IN ('unassigned', 'assigned') ORDER BY pickup_date, pickup_time";

    // Execute the query
=======
    $sql .=
        "booking_status IN ('unassigned', 'assigned') ORDER BY pickup_date, pickup_time";

    // Execute the query
    // Execute the query
>>>>>>> 1ea1b2c8290a9422a237b3ca86957b9e7f4be0f8
    $result = $conn->query($sql);

    // Check if any results were found
    if ($result->num_rows > 0) {
        $resultsArray = [];
        while ($row = $result->fetch_assoc()) {
            $resultsArray[] = $row;
        }
        echo json_encode($resultsArray);
    } else {
        echo json_encode(["error" => "Booking not found"]);
    }
}

// Handle the assignment request
if (isset($_GET["assign"])) {
    $assignRef = $_GET["assign"];

    // Update the booking status in the database
    $sql = "UPDATE BookingRequests SET booking_status = 'assigned' WHERE booking_ref = '$assignRef'";

    if ($conn->query($sql) === true) {
<<<<<<< HEAD
        echo "Congratulations! Booking request " . $assignRef . " has been assigned!";
=======
        echo "Congratulations! Booking request " .
            $assignRef .
            " has been assigned!";
>>>>>>> 1ea1b2c8290a9422a237b3ca86957b9e7f4be0f8
    } else {
        echo "Error assigning booking request: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>