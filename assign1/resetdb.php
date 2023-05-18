<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Database</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div class="content">
    <?php
    require_once("../../conf/sqlinfo.inc.php");

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Drop table if exists
    $sql = "DROP TABLE IF EXISTS status_posts";

    if (!$conn->query($sql)) {
      die("Error dropping table: " . $conn->error);
    }

    // Recreate table
    $sql = "CREATE TABLE status_posts (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    status_code VARCHAR(5) UNIQUE NOT NULL,
                    status TEXT NOT NULL,
                    share ENUM('Public', 'Friends', 'Only Me') NOT NULL,
                    date DATE NOT NULL,
                    permissions TEXT
                )";

    if (!$conn->query($sql)) {
      die("Error creating table: " . $conn->error);
    }
    echo "<div class='content-container'>";
    echo "<p><b>Database has been reset successfully!</b></p><br>";
    echo "</div>";
    echo "<div class='button-container'><a href='index.html' class='button-link'>Return to Home Page</a></div>";


    $conn->close();
    ?>
  </div>
</body>

</html>