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
//vérifie que les paramètres entrés correspondent bien à des colonnes de
//récupération des champs de la table utilisateur.
//query the etudiant table
$query = "SELECT *
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = utilisateur
 ";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

//fetch the data
$course = $result->fetch_assoc();

var_dump($course);





//vérifie que toutes les variables ont été initialisées.
//if (
  //  !isset($_POST['test'])
//) {
    //http_response_code(401);
  //  return;
//}

//foreach ($_POST as $champ_update) {


//}
//$id = $_POST['id_user_update'];

// Build the update query
//$query = "UPDATE user SET ";
//foreach ($data as $key => $value) {
   // $query .= "$key = '$value',";
//}
//$query = rtrim($query, ",");
//$query .= " WHERE $condition";

// Execute the query
//$result = $db->query($query);

// Check for errors
//if (!$result) {
    //die("Error: " . $db->error);
//}



?>