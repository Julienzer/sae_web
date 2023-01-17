<?php
/**
 * variables nécessaires :
 * token admin valide dans $_SERVEUR['AUTH'] (créer variable dans header sur postman)
 * POST['heure_debut_contrainte']
 * POST['heure_fin_contrainte']
 * POST['id_utilisateur']
 */

//connexion base de donnée.
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
    !isset($_POST['heure_debut_contrainte'], $_POST['heure_fin_contrainte'], $_POST['id_utilisateur'])
) {
    http_response_code(401);
    return;
}

// récupération des variables entrées avec la méthode post.
$debut = $_POST['heure_debut_contrainte'];
$fin = $_POST['heure_fin_contrainte'];
$id_utilisateur = $_POST['id_utilisateur'];

//Insertion de la contrainte d'un prof par l'administrateur.
$query = "INSERT INTO `contrainte` (`heure_debut_contrainte`, `heure_fin_contrainte`, `id_utilisateur`) VALUES (?,?,?);";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $debut, $fin, $id_utilisateur);
$stmt->execute();
$result = $stmt->get_result();

//affichage du résultat.
header('Content-Type: application/json');
echo json_encode([
    'success' => 'Contrainte ajoutée.'
]);

return;

?>