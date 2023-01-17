<?php
/** @var mysqli $conn */
$conn = include __DIR__ . '/includes/database_connection.php';

/** @var array $tokenData = [
 *      'id_utilisateur' => '1',
 *      'privilege' => 'administrateur'
 * }
 */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    return;
}

//vérification du rôle d'administrateur.
require_once('./includes/check_privilege.php');
$verif_privilege = check_privilege('administrateur');
if (!$verif_privilege) {
    return;
}

//vérifie que toutes les variables ont été initialisées.
if (
    !isset($_POST['id_contrainte'])
) {
    http_response_code(401);
    return;
}

//récupération de l'id de la contrainte à supprimer.
$id_contrainte = $_POST['id_contrainte'];

// Vérifie que la contrainte existe bien dans la base.
$query = "SELECT * FROM contrainte WHERE id_contrainte = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $id_contrainte);
$stmt->execute();
$result = $stmt->get_result();

if (!$result){
    http_response_code(1802);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Contrainte inexistante'
    ]);
    return;
}

// Supprime la contrainte de la base.
$query = "DELETE FROM contrainte WHERE `contrainte`.`id_contrainte` = ? ";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $id_contrainte);
$stmt->execute();
$result = $stmt->get_result();


header('Content-Type: application/json');
echo json_encode([
    'success' => 'Contrainte supprimée'
]);

return;
?>