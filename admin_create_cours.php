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
    !isset($_POST['heure_debut'],
        $_POST['heure_fin'],
        $_POST['id_user'],
        $_POST['id_salle'],
        $_POST['id_matiere'],
        $_POST['id_regroupement'],
        $_POST['id_type_cours'])
) {
    http_response_code(401);
    return;
}

// récupération des variables entrées avec la méthode post.
$debut = $_POST['heure_debut'];
$fin = $_POST['heure_fin'];
$user = $_POST['id_user'];
$salle = $_POST['id_salle'];
$matiere = $_POST['id_matiere'];
$regroupement = $_POST['id_regroupement'];
$type_cours = $_POST['id_type_cours'];

//Insertion d'un cours par l'administrateur.
$query = "INSERT INTO `cours` (`heure_debut`, `heure_fin`, `id_user`, `id_salle`, `id_matiere`, `id_regroupement`, `id_type_cours`) VALUES (?,?,?,?,?,?,?);";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssiiiii", $debut, $fin, $user, $salle, $matiere, $regroupement, $type_cours);
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: application/json');
echo json_encode([
    'success' => 'Cours ajouté.'
]);

return;

?>