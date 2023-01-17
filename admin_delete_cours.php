<?php

$conn = include __DIR__ . '/includes/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    return;
}
//vérification du statut d'administrateur.
require_once('./includes/check_privilege.php');
$verif_privilege = check_privilege('administrateur');
if (!$verif_privilege) {
    return;
}
//vérifie que toutes les variables ont été initialisées.
if (
    !isset($_POST['id_cours'])
) {
    http_response_code(401);
    return;
}

// récupération des variables entrées avec la méthode post.
$cours = $_POST['id_cours'];


//Insertion de la contrainte sur un prof par l'administrateur.
$query = "DELETE FROM cours WHERE `cours`.`id_cours` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $cours);
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: application/json');
echo json_encode([
    'success' => 'Cours supprimé.'
]);

return;

?>