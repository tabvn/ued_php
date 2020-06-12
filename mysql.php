<?php
function connect(){
    $mysqli = new mysqli("localhost","root","root","ued");

// Check connection
    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
    return $mysqli;
}