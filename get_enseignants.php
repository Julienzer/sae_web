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

// check if user is authenticated
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(array("error" => "Access denied"));
    exit;
}

// check if user have the right permissions
if(!$_SESSION['user']['privilege'] == "enseignant"){
    echo json_encode(array("error" => "Access denied"));
    exit;
}

// get the enseignant id
if (!isset($_POST['id'])) {
    echo json_encode(array("error" => "Invalid request"));
    exit;
}

$id = $_POST['id'];

//query the enseignant table
$query = "SELECT * FROM enseignant, cours WHERE cours.id_enseignant = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

//fetch the data
$course = $result->fetch_assoc();

//return the data as JSON
header('Content-Type: application/json');
if($course)
    echo json_encode($course);
else
    echo json_encode(array("error" => "No enseignant found with this id"));

$conn->close();