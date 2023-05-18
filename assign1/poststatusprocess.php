<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Status Process</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="content">
        <?php
        require_once("../../conf/sqlinfo.inc.php");
        // Database connection
        
        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Create table if not exists
        $sql = "CREATE TABLE IF NOT EXISTS status_posts (
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

        $status_code = $_POST['statuscode'];
        $status = $_POST['status'];
        $share = $_POST['share'];
        $date = $_POST['date'];
        $permissions = isset($_POST['permission']) ? implode(', ', $_POST['permission']) : '';

        // Validate date
        $date_parts = explode('-', $date);
        if (!checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
            echo "<p><b>Invalid date format! </b></p><br>";
            echo "div class='button-container'>";
            echo "<a class='button-link' href='index.html'>Return to Home Page</a><br>";
            echo "<a class='button-link' href='poststatus.php'>Post Status</a>";
            echo "</div>";
            exit();
        }

        $sql = "INSERT INTO status_posts (status_code, status, share, date, permissions) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $status_code, $status, $share, $date, $permissions);

        if ($stmt->execute()) {
            echo "<div class='content-container'>";
            echo "<p><b>Congratulations! The status has been posted!</b></p>";
            echo "</div>";
        } else {
            if ($conn->errno === 1062) {
                echo "<div class='content-container'>";
                echo "<p><b>The status code already exists. Please try another one!</b></p>";
                echo "</div>";
            } else {
                echo "<div class='content-container'>";
                echo "<p><b>An error occurred while saving your status. Please try again.</b></p>";
                echo "</div>";
            }
        }
        $stmt->close();
        $conn->close();

        echo "<div class='button-container'><a href='index.html' class='button-link'>Return to Home Page</a></div>";
        ?>
    </div>
</body>

</html>