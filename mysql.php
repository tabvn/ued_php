<?php
function connect(){
    $mysqli = new mysqli("127.0.0.1","root","root","ued");
// Check connection
    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
    return $mysqli;
}
