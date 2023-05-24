<!-- Harrison Raynes 20121017
The server-side PHP file for processing admin panel requests. -->
<?php

// Include the database connection configuration file
require_once "../../conf/sqlinfo.inc.php";

// Establish a database connection
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

    $sql = "SELECT * FROM BookingRequests WHERE ";
    if (empty($bsearch)) {
        $sql .= "pickup_date >= CURDATE() AND pickup_time BETWEEN CURTIME() AND DATE_ADD(CURTIME(), INTERVAL 2 HOUR) AND booking_status = 'unassigned' ORDER BY pickup_date, pickup_time";
    } else {
        $sql .= "booking_ref = '$bsearch'";
    }

    // Execute the query
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

    $sql = "UPDATE BookingRequests SET booking_status = 'assigned' WHERE booking_ref = '$assignRef'";

    if ($conn->query($sql) === true) {
        echo "Congratulations! Booking request " . $assignRef . " has been assigned!";
    } else {
        echo "Error assigning booking request: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>