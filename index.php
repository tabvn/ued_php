<?php
$mysqli = new mysqli("127.0.0.1","root","root","ued");
// Check connection
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}

$sql = "SELECT first_name, last_name FROM teachers";
$result  = $mysqli -> query($sql);
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