<?php
session_start(); // start the session
session_unset(); // (8) unset all session variables
session_destroy(); // (9) destroy all data associated with the session
header("location:number.php"); // (10) redirect to number.php
?>