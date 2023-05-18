<?php
session_start(); // (3)
$num = $_SESSION["number"]; // (4)
$num--; // (5) decrement the value
$_SESSION["number"] = $num; // (6) update the session variable
header("location:number.php"); // (7) redirect to number.php
?>