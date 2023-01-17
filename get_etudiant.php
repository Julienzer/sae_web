<?php

/** @var mysqli $conn */
$conn = include __DIR__ . '/includes/database_connection.php';

/** @var array $tokenData = [
 *      'id_user' => '1',
 *      'username' => 'user',
 *      'privilege' => 'admin'
 * }
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    return;
}

$tokenData = include __DIR__ . '/includes/check_token.php';

require_once('./includes/check_privilege.php');
$verif_privilege = check_privilege('etudiant');
if (!$verif_privilege) {
    return;
}

//query the etudiant table
$query = 'SELECT * FROM COURS WHERE cours.id_regroupement IN (SELECT id_regroupement FROM Appartient WHERE Appartient.id_user = ? );';
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $tokenData['id_user']);
$stmt->execute();
$result = $stmt->get_result();

//fetch the data
$course = $result->fetch_assoc();

//return the data as JSON
header('Content-Type: application/json');
if($course)
    echo json_encode($course);
else
    echo json_encode(array("error" => "Aucun étudiant trouvé avec cet id."));

$conn->close();

