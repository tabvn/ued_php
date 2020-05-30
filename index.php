<?php
require('./mysql.php');
$conn = connect();
$sql = "SELECT email, password FROM users";
$result  = $conn -> query($sql);
// Numeric array
$row = $result -> fetch_array(MYSQLI_NUM);
printf ("%s (%s)\n", $row[0], $row[1]);
$teachers = array();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Home</title>
</head>
<body>
</body>
</html>