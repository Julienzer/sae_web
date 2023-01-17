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
    !isset($_POST['heure_debut_contrainte'], $_POST['heure_fin_contrainte'], $_POST['id_user'])
) {
    http_response_code(401);
    return;
}

// récupération des variables entrées avec la méthode post.
$debut = $_POST['heure_debut_contrainte'];
$fin = $_POST['heure_fin_contrainte'];
$id_user = $_POST['id_user'];

//Insertion de la contrainte sur un prof par l'administrateur.
$query = "INSERT INTO `contrainte` (`heure_debut_contrainte`, `heure_fin_contrainte`, `id_user`) VALUES (?,?,?);";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $debut, $fin, $id_user);
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: application/json');
echo json_encode([
    'success' => 'Contrainte ajoutée.'
]);

return;

?>