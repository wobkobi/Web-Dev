<html>

<head> 
		<meta http-equiv=content-type content=text/html; charset=utf-8 />
		<meta name="description" content="web Development :: Lab 2" />
		<meta name="keywords" content="web,development" />
	<title>Days Array</title>
</head>

<body>
	<h1>Days of the week in English</h1>
	<?php
			/* Using array() function */
			$days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
			//print all days
			echo "The Days of the week in english are: ";
			for ($i = 0; $i < count($days); $i++) {
				echo "$days[$i], ";
			}
			?>

	<h2>Days of the week in french </h2>
	<?php
			/* Using array() function */
			$days = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
			//print all days
			echo "The Days of the week in french are: ";
			for ($i = 0; $i < count($days); $i++) {
				echo "$days[$i], ";
			}
		
		?>
</body>

</html>