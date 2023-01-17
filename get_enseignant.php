<?php

/** @var mysqli $conn */
$conn = include __DIR__ . '/includes/database_connection.php';

/** @var array $tokenData = [
 *      'id_user' => '1',
 *      'privilege' => 'admin'
 * }
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    return;
}

require_once('./includes/check_privilege.php');
$verif_privilege = check_privilege('enseignant');
if (!$verif_privilege) {
    return;
}

$tokenData = include __DIR__ . '/includes/check_token.php';

//query the etudiant table
$query = "SELECT * FROM cours WHERE cours.id_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $tokenData['id_user']);
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

