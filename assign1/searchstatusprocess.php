<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Status Result</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div class="content">
    <?php
    $search = trim($_GET['status']);

    if (empty($search)) {
      echo "<div class='content-container'>";
      echo "<p><b>The search string is empty. Please enter a keyword to search. </p></b><br>";
      echo "</div>";
      echo "<div class='button-container'>";
      echo "<a class='button-link', 'href='index.html'>Return to Home Page</a><br>";
      echo "<a class='button-link';'href='searchstatusform.html'>Search Status</a>";
      echo "</div>";
      exit();
    }

    require_once("../../conf/sqlinfo.inc.php");
    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM status_posts WHERE status LIKE '%$search%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<h1>Status Information</h1>";
      echo "<div class='result-container'>";
      echo "<table>";
    
      $counter = 0;
    
      while ($row = $result->fetch_assoc()) {
        if ($counter % 5 == 0) {
          echo "<tr>";
        }
    
        echo "<td>";
        echo "<div class='content-result'>";
        echo "Status: " . $row['status'] . "<br>";
        echo "Status Code: " . $row['status_code'] . "<br>";
        echo "Share: " . $row['share'] . "<br>";
        echo "Date Posted: " . $row['date'] . "<br>";
        echo "Permission: " . $row['permissions'] . "<br>";
        echo "</div>";
        echo "</td>";
    
        $counter++;
    
        if ($counter % 5 == 0) {
          echo "</tr>";
        }
      }
    
      if ($counter % 5 != 0) {
        echo "</tr>";
      }
    
      echo "</table>";
      echo "</div>";
      echo "<div class='button-container'>";
      echo "<a class='button-link' href='searchstatusform.html'>Search for another status</a>";
      echo "<a class='button-link' href='index.html'>Return to Home Page</a>";
      echo "</div>";
    } else {
      echo "<div class='content-container'>";
      echo "<p><b>Status not found. Please try a different keyword.</b></p>";
      echo "</div>";
      echo "<div class='button-container'>";
      echo "<a class='button-link' href='searchstatusform.html'>Search for another status</a>";
      echo "<a class='button-link' href='index.html'>Return to Home Page</a>";
      echo "</div>";
    }
    



    $conn->close();
    ?>
  </div>
</body>

</html>