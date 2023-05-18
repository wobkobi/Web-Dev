<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Using file functions</title>
</head>

<body>
    <h1>Web Development - Lab05</h1>
    <?php
require_once ("../../conf/settings.php"); //please make sure the path is correct

// Connect to the database
$conn = new mysqli($host, $user, $pswd, $dbnm);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select car_id, make, model, and price from the car table
$sql = "SELECT car_id, make, model, price FROM car";
$result = $conn->query($sql);

// Display the result in an HTML table
if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Car ID</th><th>Make</th><th>Model</th><th>Price</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["car_id"] . "</td>";
        echo "<td>" . $row["make"] . "</td>";
        echo "<td>" . $row["model"] . "</td>";
        echo "<td>" . $row["price"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();
?>
</body>

</html>