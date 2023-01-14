<?php
//connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sae";

$conn = new mysqli($servername, $username, $password, $dbname);

//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//query the Cours table
$query = "SELECT * FROM cours";
$result = $conn->query($query);

//fetch the data
$courses = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

//return the data as JSON
header('Content-Type: application/json');
echo json_encode($courses);

$conn->close();
?>