<?php
session_start();
if (!isset($_SESSION['guesses']))
    $_SESSION['guesses'] = 0;
if (!isset($_SESSION['number']))
    $_SESSION['number'] = rand(0, 100);

$guess = isset($_POST['guess']) ? $_POST['guess'] : null;
$message = '';

if ($guess !== null) {
    $_SESSION['guesses']++;
    if ($guess > $_SESSION['number'])
        $message = 'Your guess is too high!';
    elseif ($guess < $_SESSION['number'])
        $message = 'Your guess is too low!';
    else
        $message = 'Congratulations! You guessed the number!';
}
?>
<html>

<head>
    <title>Guessing Game</title>
</head>

<body>
    <h1>Guessing Game</h1>
    <p>Guess a number between 0 and 100</p>
    <p>
    <form method="post">
        <input type="number" name="guess" min="0" max="100" required>
        <input type="submit" value="Guess">
    </form>
    </p>
    <p>
        <?php echo $message; ?>
    </p>
    <p>Guesses:
        <?php echo $_SESSION['guesses']; ?>
    </p>
    <p><a href="giveup.php">Give Up</a></p>
    <p><a href="startover.php">Start Over</a></p>
</body>

</html>