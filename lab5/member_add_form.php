<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Add New Member Form</title>
</head>

<body>
  <h1>Add New Member</h1>
  <form action="member_add.php" method="post">
    First Name: <input type="text" name="fname" required><br>
    Last Name: <input type="text" name="lname" required><br>
    Gender: <input type="radio" name="gender" value="M" required> Male
    <input type="radio" name="gender" value="F" required> Female <br>
    Email: <input type="email" name="email" required><br>
    Phone: <input type="text" name="phone" required><br>
    <input type="submit" value="Submit">
  </form>
</body>

</html>