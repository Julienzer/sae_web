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
    !isset($_POST['nom_utilisateur_create'], $_POST['prenom_utilisateur_create'], $_POST['email_utilisateur_create'],
        $_POST['id_privilege_create'], $_POST['id_regroupement_create'], $_POST['mdp_utilisateur_create'])
) {
    http_response_code(401);
    return;
}


// récupération des variables entrées avec la méthode post.
$nom = $_POST['nom_utilisateur_create'];
$prenom = $_POST['prenom_utilisateur_create'];
$mail = $_POST['email_utilisateur_create'];
$privilege = $_POST['id_privilege_create'];
$regroupement = $_POST['id_regroupement_create'];
$password = $_POST['mdp_utilisateur_create'];


//vérifie que l'utilisateur n'est pas déjà présent dans la base en comparant l'adresse mail.
$query = "SELECT * FROM utilisateur WHERE email_utilisateur = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();
//fetch the data
$check = $result->fetch_assoc();
if ($check){
    http_response_code(1802);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Utilisateur déjà créé'
    ]);
    return;
}

//Insertion du nouvel utilisateur dans la base.
$query = "INSERT INTO utilisateur (nom_utilisateur,prenom_utilisateur,email_utilisateur,id_privilege,mdp_utilisateur) VALUES (?,?,?,?,?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssis",$nom,$prenom, $mail, $privilege, $password);
$stmt->execute();

//récupération du rôle de l'utilisateur pour les opérations suivantes.
$query = "SELECT nom_privilege FROM privilege WHERE id_privilege = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s',$privilege);
$stmt->execute();
$result = $stmt->get_result();
//fetch the data
$result_privilege = $result->fetch_assoc();

//récupération de l'id de l'utilisateur pour l'affectation d'un etudiant à un groupe.
$query = "SELECT id_utilisateur FROM utilisateur WHERE email_utilisateur = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();
//fetch the data
$result_id = $result->fetch_assoc();



// affectation d'un etudiant à un groupe entré en paramètre POST.
if ($result_privilege['nom_privilege'] == 'etudiant') {
    $query = "INSERT INTO Appartient values(?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii',$result_id['id_utilisateur'],$regroupement);
    $stmt->execute();
}

//TODO -> Ajouter contraintes d'intégrités entre appartient et utilisateur, cours et user
// Ajouter des vérifications de BDD, par exemple : ne pas pouvoir mettre dans un groupe qui n'existe pas etc..

header('Content-Type: application/json');
echo json_encode([
    'success' => 'Utilisateur créé'
]);

return;

?>