<!DOCTYPE html>
<html>

<head>
	<meta http-equiv=content-type content=text/html; charset=utf-8 />
	<meta name="description" content="web Development :: Lab 3" />
	<meta name="keywords" content="web,development" />
	<title>Perfect Palindrome Task 3</title>
</head>

<body>
	<h1>Web Development – Lab 3</h1>
	<?php
	$input = $_POST['input'];
	//save copy of orignal string
	$original = $input;
		//if input is blank go back to html
	if (strlen($input) == 0) {
		header("Location: perfectpalindrome.html");
		exit();
	}
	//get string count
	$length = strlen($input);
	// Removing non-alphanumeric characters and converting to lower case
	$input = strtolower(preg_replace('/[^A-Za-z0-9]/', '', $input));
	//If theres no character after remvoing, error
	if (strlen($input) == 0) {
		echo "<p>There are no valid characters in the input.</p>";
		exit();
	}
	// Reversing the string
	$reverse = strrev($input);

	//if reverse is same length and length
	if (strlen($input) == $length) {
		echo "<p>" . $original . " is a perfect palindrome!</p>";
	} else if (strcmp($input, $reverse) == 0) {
		echo "<p>" . $original . " is a standard palindrome!</p>";
	} else {
		echo "<p>" . $original . " is not a standard palindrome.</p>";
	}
	?>
</body>

</html>