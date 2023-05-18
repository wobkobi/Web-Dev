<!DOCTYPE html>
<html>

<head>
    <meta http-equiv=content-type content=text/html; charset=utf-8 />
    <meta name="description" content="web Development :: Lab 3" />
    <meta name="keywords" content="web,development" />
    <title>Perfect Palindrome Task 2</title>
</head>

<body>
    <h1>Web Development – Lab 3</h1>
    <?php
    $input = $_POST['input'];

    // Converting to lower case
    $input = strtolower($input);
    //If theres no character after remvoing, error
    if (strlen($input) == 0) {
        echo "<p>There are no valid characters in the input.</p>";
        exit();
    }
    // Reversing the string
    $reverse = strrev($input);

    if (strcmp($input, $reverse) == 0) {
        echo "<p>" . $input . " is a perfect palindrome!</p>";
    } else {
        echo "<p>" . $input . " is not a perfect palindrome.</p>";
    }
    ?>
</body>

</html>