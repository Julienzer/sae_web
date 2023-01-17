<?php
//connexion à la base.
$conn = include __DIR__ . '/includes/database_connection.php';

/**
 * variables nécessaires :
 * token admin valide dans $_SERVEUR['AUTH'] (créer variable dans header sur postman)
 * $_POST[id_utilisateur_delete]
 *
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
    !isset($_POST['id_utilisateur_delete'])
) {
    http_response_code(401);
    return;
}


//récupération du mail de l'utilisateur à supprimer.
$mail = $_POST['id_utilisateur_delete'];

// Vérifie que l'utilisateur existe bien dans la base.
$query = "SELECT * FROM utilisateur WHERE id_utilisateur = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();
//fetch the data
$exist = $result->fetch_assoc();
if (!$exist){
    http_response_code(1802);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Utilisateur inexistant'
    ]);
    return;
}

//suppresion de l'utilisateur.
$query = "DELETE FROM utilisateur where id_utilisateur = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s',$mail);

$stmt -> execute();

header('Content-Type: application/json');
echo json_encode([
    'success' => 'Utilisateur supprimé'
]);

return;
?>