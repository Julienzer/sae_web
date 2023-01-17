<?php


$conn = include __DIR__ . '/includes/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    return;
}
//récupération du token.
$tokenData = include __DIR__ . '/includes/check_token.php';

//vérification du statut utilisateur.
require_once('./includes/check_privilege.php');
$verif_privilege = check_privilege('etudiant');
if (!$verif_privilege) {
    return;
}
// récupération de l'identifiant utilisateur.
$id = $tokenData['id_utilisateur'];

//récupération des cours de l'enseignant
$query = 'SELECT * FROM COURS WHERE cours.id_regroupement IN (SELECT id_regroupement FROM Appartient WHERE Appartient.id_utilisateur = ? );';
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
$cours_etudiant = $result->fetch_assoc();

//affichage du résultat.
header('Content-Type: application/json');
if($cours_etudiant)
    echo json_encode($cours_etudiant);
else
    echo json_encode(array("error" => "No etudiant found with this id"));

$conn->close();

