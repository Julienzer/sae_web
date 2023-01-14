<?php
//connect to the database
$servername = "127.0.0.1";
$username = "sae";
$password = "sae";
$dbname = "sae";

$conn = new mysqli($servername, $username, $password, $dbname);

//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

return $conn;