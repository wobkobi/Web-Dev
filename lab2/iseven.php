<html>

<head> 
		<meta http-equiv=content-type content=text/html; charset=utf-8 />
		<meta name="description" content="web Development :: Lab 3" />
		<meta name="keywords" content="web,development" />
	<title>Is Even</title>
	
</head>

<body>
	<?php
//Use a conditional operator to determine whether the variable contains an integer
//and whether the integer is even.
//random number on reload of pag
		$number = rand(1, 100);
		//number as header 1
		echo "<h1>$number</h1>";

		if (is_int($number) && $number % 2 == 0) {
			echo "The number is even";
		} //if its not a int
		else if (!is_int($number)) {
			echo "The number is not an integer";
		} 
		else {
			echo "The number is odd";
		}
	?>

</body>

</html>