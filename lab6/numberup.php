<?php
session_start(); // (1)
$num = $_SESSION["number"]; // (2)
$num++; // increment the value
$_SESSION["number"] = $num; // update the session variable
header("location:number.php"); // redirect to number.php
?>