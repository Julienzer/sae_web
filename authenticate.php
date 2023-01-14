<?php
//connect to the database
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_dbname";

$conn = new mysqli($servername, $username, $password, $dbname);

//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//check if the login form has been submitted
if (isset($_POST['submit'])) {
    //get the login data
    $username = $_POST['username'];
    $password = $_POST['password'];

    //query the database to check if the user exists
    $query = "SELECT * FROM user WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    //if the user exists
    if ($user) {
        //store the user data in a session
        session_start();
        $_SESSION['user'] = $user;

        //redirect the user to the protected page
        header("Location: protected.php");
    } else {
        //if the user doesn't exist, show an error message
        echo "Invalid username or password.";
    }
}

$conn->close();
?>