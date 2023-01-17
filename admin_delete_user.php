<?php
/** @var mysqli $conn */
$conn = include __DIR__ . '/includes/database_connection.php';

/** @var array $tokenData = [
 *      'id_utilisateur' => '1',
 *      'privilege' => 'administrateur'
 * }
 */
/**
 * variables nécessaires :
 * $_POST[email_utilisateur_delete]
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
    !isset($_POST['email_utilisateur_delete'])
) {
    http_response_code(401);
    return;
}


//récupération du mail de l'utilisateur à supprimer.
$mail = $_POST['email_utilisateur_delete'];

// Vérifie que l'utilisateur existe bien dans la base.
$query = "SELECT * FROM utilisateur WHERE email_utilisateur = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();
//fetch the data
$course = $result->fetch_assoc();
if (!$course){
    http_response_code(1802);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Utilisateur innexistant'
    ]);
    return;
}
//TODO -> créer une fonction de vérification de rôle.
// récupération du privilège
$query = <<<EOF
    select * 
    from utilisateur,privilege 
    where privilege.id_privilege = utilisateur.id_privilege 
    and utilisateur.email_utilisateur = ?
EOF;
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $mail);
$stmt->execute();
$result = $stmt->get_result();

//fetch the data
$course = $result->fetch_assoc();
//TODO -> appeler fonction privilege.
if($course['nom_privilege'] == 'enseignant'){
    $query = "DELETE FROM cours where id_utilisateur = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s',$course['id_utilisateur']);

    $stmt -> execute();
}elseif ($course['nom_privilege'] == 'etudiant'){
    $query = "DELETE FROM Appartient where id_utilisateur = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s',$course['id_utilisateur']);

    $stmt -> execute();
}

$query = "DELETE FROM token where id_utilisateur = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s',$course['id_utilisateur']);
$stmt -> execute();

$query = "DELETE FROM utilisateur where id_utilisateur = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s',$course['id_utilisateur']);

$stmt -> execute();

header('Content-Type: application/json');
echo json_encode([
    'success' => 'Utilisateur supprimé'
]);

return;
?>