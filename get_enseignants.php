<?php

/** @var mysqli $conn */
$conn = include __DIR__ . '/includes/database_connection.php';

/** @var array $tokenData = [
 *      'id_user' => '1',
 *      'username' => 'user',
 *      'privilege' => 'admin'
 * }
 */
$tokenData = include __DIR__ . '/includes/check_token.php';

if ('admin' !== $tokenData['privilege']) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Infufifant permissions 🤓'
    ]);
    return;
}


switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $data = $_POST['data'];
        break;
    case 'DELETE':
        $id = $_GET['id'];
        break;
    case 'PUT':
        $data = $_POST['data'];
        break;
    default:

}

// get the etudiant id
if (!isset($_GET['id'])) {
    echo json_encode(array("error" => "Invalid request"));
    exit;
}

$id = $_GET['id'];

//query the etudiant table
$query = "SELECT * FROM enseignant, cours WHERE enseignant.id_enseignant = cours.id_enseignant";
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

