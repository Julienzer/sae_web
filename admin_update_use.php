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

$id = $_POST['id_user_update'];

// Build the update query
$query = "UPDATE $table SET ";
foreach ($data as $key => $value) {
    $query .= "$key = '$value',";
}
$query = rtrim($query, ",");
$query .= " WHERE $condition";

// Execute the query
$result = $db->query($query);

// Check for errors
if (!$result) {
    die("Error: " . $db->error);
}



?>