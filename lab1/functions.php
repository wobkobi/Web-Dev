<html>

<head>
	<title>PHP Functions</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>
	<h1>Using PHP built-in Functions</h1>
	<?php
            /*Using abs() and pow() functions, and echo */
            echo "<p> Absolute value of -69 is: " . abs(-69) . "</p>";
            echo "<p> 2 to the power of 10 is: " . pow(2, 10) . "</p>";
        ?>

	<?php
            /* Using decbin() and bindec() functions */
            echo "<p>1101 decimal representation is " . bindec(1101) . "</p>";
            echo "<p>Binary representation of 14 is " . decbin(14) . "</p>";
        ?>
</body>

</html>