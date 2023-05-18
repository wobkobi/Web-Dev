<?php
//leap year function
include 'leapyear.html';
if (isset($_GET['year'])) {
	$year = $_GET['year'];
}

if (is_leap_year($year)) {
	echo "<h3>$year is a leap year</h3>";
} else {
	echo "<h3>$year is not a leap year</h3>";
}

function is_leap_year($year) {
	if ($year % 4 == 0) {
		if ($year % 100 == 0) {
			if ($year % 400 == 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	} else {
		return false;
	}
}
?>