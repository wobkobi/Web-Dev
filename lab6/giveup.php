<?php
session_start();
if (!isset($_SESSION['number']))
    header("location:guessinggame.php");
?>
<html>

<head>
    <title>Give Up</title>
</head>

<body>
    <h1>Give Up</h1>
    <p>The number was:
        <?php echo $_SESSION['number']; ?>
    </p>
    <p><a href="startover.php">Start Over</a></p>
</body>

</html>