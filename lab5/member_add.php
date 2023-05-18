<?php
require_once ("../../conf/settings.php");

$conn = new mysqli($host, $user, $pswd, $dbnm);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS vipmember (
  member_id INT AUTO_INCREMENT PRIMARY KEY,
  fname VARCHAR(40),
  lname VARCHAR(40),
  gender VARCHAR(1),
  email VARCHAR(40),
  phone VARCHAR(20)
)";

if (!$conn->query($sql)) {
  die("Error creating table: " . $conn->error);
}

//trim all

$fname = trim($_POST["fname"]);
$lname = trim($_POST["lname"]);
$gender = trim($_POST["gender"]);
$email = trim($_POST["email"]);
$phone = trim($_POST["phone"]);

$name_pattern = '/^[a-zA-Z]+$/';
$gender_pattern = '/^[MF]{1}$/';
$email_pattern = '/^[^\s@]+@[^\s@]+.[^\s@]+$/';
$phone_pattern = '/^[0-9]+$/';


if (!preg_match($name_pattern, $fname)) {
  die("Invalid first name");
}

if (!preg_match($name_pattern, $lname)) {
  die("Invalid last name");
}

if (!preg_match($gender_pattern, $gender)){
  die("Invalid Gender");
}

if (!preg_match($email_pattern, $email)){
  die("Invalid Email");
}

if (!preg_match($phone_pattern, $phone)){
  die("Invalid Phone");
}


$sql = "INSERT INTO vipmember (fname, lname, gender, email, phone)
VALUES ('$fname', '$lname', '$gender', '$email', '$phone')";

if ($conn->query($sql)) {
  echo "New member added successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>