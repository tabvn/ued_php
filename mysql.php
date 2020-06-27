<?php
function connect()
{
	$mysqli = new mysqli(HOST, DB_USER, DB_PASSWORD, DB);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
		exit();
	}
	return $mysqli;
}