<?php

// include the mathfunctions.php file
include 'mathfunctions.php';

// include the factorialform.html file
include 'factorialform.html';

if (isset($_GET['number'])) {
    $some_number = $_GET['number'];
} else {
    $some_number = 5;
}

echo "<h3>The factorial of $some_number is " . factorial($some_number) . "</h3>";

?>