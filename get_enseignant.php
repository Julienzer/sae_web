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
//récupération du token
$tokenData = include __DIR__ . '/includes/check_token.php';

//vérification du statut d'administrateur.
require_once('./includes/check_privilege.php');
$verif_privilege = check_privilege('enseignant');
if (!$verif_privilege) {
    return;
}

//récupération de l'id utilisateur.
$id = $tokenData['id_utilisateur'];

//récupère les cours de l'utilisateur.
$query = "SELECT * FROM cours WHERE cours.id_utilisateur = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$cours_enseignant = $result->fetch_assoc();

//return the data as JSON
header('Content-Type: application/json');
if($cours_enseignant)
    echo json_encode($cours_enseignant);
else
    echo json_encode(array("error" => "Aucun enseignant trouvé avec cet identifiant, ou pas de cours enregistré"));

$conn->close();

