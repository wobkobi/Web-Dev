<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Status</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Post a New Status</h1>
    <form action="poststatusprocess.php" method="POST">
        <label for="statuscode">Status Code:</label>
        <?php
        require_once("../../conf/sqlinfo.inc.php");

        $conn = new mysqli($host, $user, $password, $database);
        $next_status_code = "S0001";

        if (!$conn->connect_error) {
            $sql = "SELECT status_code FROM status_posts ORDER BY status_code DESC LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $current_number = intval(substr($row['status_code'], 1));
                $next_number = str_pad(($current_number + 1), 4, "0", STR_PAD_LEFT);
                $next_status_code = "S" . $next_number;
            }
            $conn->close();
        }
        ?>
        <input type="text" name="statuscode" id="statuscode" required pattern="S\d{4}"
            value="<?php echo $next_status_code; ?>">
        <br><br>
        <label for="status">Status:</label>
        <textarea name="status" id="status" rows="2" required pattern="^[\w\s,.\-?!]+$"></textarea>
        <br><br>
        <label>Share:</label>
        <label>
            <input type="radio" name="share" value="Public" required> Public
        </label>
        <label>
            <input type="radio" name="share" value="Friends"> Friends
        </label>
        <label>
            <input type="radio" name="share" value="Only Me"> Only Me
        </label>
        <br><br>
        <label for="date">Date:</label>
        <?php
        $current_date = new DateTime();
        $current_date = $current_date->format("Y-m-d");
        ?>
        <input type="date" name="date" id="date" required value="<?php echo $current_date; ?>">
        <br><br>
        <label>Permission:</label>
        <label>
            <input type="checkbox" name="permission[]" value="Allow Like"> Allow Like
        </label>
        <label>
            <input type="checkbox" name="permission[]" value="Allow Comments"> Allow Comments
        </label>
        <label>
            <input type="checkbox" name="permission[]" value="Allow Share"> Allow Share
        </label>
        <br><br>
        <input type="submit" value="Submit">
    </form>
    <div class="button-container">
        <p><a class="button-link" href="index.html">Return to Home Page</a></p>
    </div>
</body>

</html>