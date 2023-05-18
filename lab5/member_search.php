<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Search Member</title>
</head>

<body>
  <h1>Search Member</h1>
  <form action="member_search.php" method="post">
    Last Name: <input type="text" name="lname" required>
    <input type="submit" value="Search">
  </form>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../conf/settings.php");

    $conn = new mysqli($host, $user, $pswd, $dbnm);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $lname = $_POST["lname"];

    $sql = "SELECT member_id, fname, lname, email FROM vipmember WHERE lname LIKE '%$lname%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<table border='1'>";
      echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["member_id"] . "</td>";
        echo "<td>" . $row["fname"] . "</td>";
        echo "<td>" . $row["lname"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "0 results";
    }
    $conn->close();
  }
  ?>
</body>

</html>