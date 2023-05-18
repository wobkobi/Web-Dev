<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Display All Members</title>
</head>

<body>
    <h1>Display All Members</h1>
    <?php
require_once ("../../conf/settings.php");

$conn = new mysqli($host, $user, $pswd, $dbnm);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT member_id, fname, lname FROM vipmember";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<table border='1'>";
  echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th></tr>";
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["member_id"] . "</td>";
    echo "<td>" . $row["fname"] . "</td>";
    echo "<td>" . $row["lname"] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
} else {
  echo "0 results";
}
$conn->close();
?>
</body>

</html>