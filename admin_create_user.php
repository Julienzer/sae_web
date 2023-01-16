<?php
/** @var mysqli $conn */
$conn = include __DIR__ . '/includes/database_connection.php';

/** @var array $tokenData = [
 *      'id_user' => '1',
 *      'username' => 'user',
 *      'privilege' => 'admin'
 * }
 */

//vérification du statut d'administrateur et de la connexion grâce au token.
$tokenData = include __DIR__ . '/includes/check_token.php';
if ('administrateur' !== $tokenData['nom_privilege']) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Insufisant permissions 🤓'
    ]);
    return;
}

// récupération des variables entrées avec la méthode post.
$nom = $_POST['nom_new_user'];
$prenom = $_POST['prenom_new_user'];
$mail = $_POST['email_new_user'];
$privilege = $_POST['id_new_privilege'];
$regroupement = $_POST['id_regroupement'];
$password = $_POST['pwd'];

$query = "SELECT * FROM utilisateur WHERE email_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();
//fetch the data
$course = $result->fetch_assoc();
if ($course){
    http_response_code(1802);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Utilisateur déjà créé'
    ]);
    return;
}


$query = "INSERT INTO utilisateur (nom_user,prenom_user,email_user,id_privilege,pwd) VALUES (?,?,?,?,?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssis",$nom,$prenom, $mail, $privilege, $password);
$stmt->execute();

$query = "SELECT nom_privilege FROM privilege WHERE id_privilege = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s',$privilege);
$stmt->execute();
$result = $stmt->get_result();
//fetch the data
$result_privilege = $result->fetch_assoc();


$query = "SELECT id_user FROM utilisateur WHERE email_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();
//fetch the data
$result_id = $result->fetch_assoc();




if ($result_privilege['nom_privilege'] == 'etudiant') {
    $query = "INSERT INTO Appartient values(?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii',$result_id['id_user'],$regroupement);
    $stmt->execute();
}

//TODO -> Ajouter contraintes d'intégrités entre appartient et utilisateur, cours et user

header('Content-Type: application/json');
echo json_encode([
    'success' => 'Utilisateur créé'
]);

return;






?>