<?php
//connexion à la base de donnée.
$conn = include __DIR__ . '/includes/database_connection.php';
/**
 * variables nécessaires :
 * token admin valide dans $_SERVEUR['AUTH'] (créer variable dans header sur postman)
 * $_POST[table_update] : le nom de la table à mettre à jour. (ex : utilisateur)
 * autant de variable POST['nom_champ']  que de champ à modifier. (ex : POST[email_utilisateur] = j.durieux@etud.picardie.fr)
 *
 *  $_POST['id_update']; : identifiant de la ligne à modifier (ex : 2)
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    return;
}

if (
    !isset($_POST['table_update'])
) {
    http_response_code(401);
    return;
}

//vérification du statut d'administrateur.
require_once('./includes/check_privilege.php');
$verif_privilege = check_privilege('administrateur');
if (!$verif_privilege) {
    return;
}
//récupération des colonnes de la table entrée en paramètre.
$table_upddate = $_POST['table_update'];
$resultat = array();
//récupère les colonnes de la table utilisateur.
$query ="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_upddate'" ;
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

//récupération du résultat de la requête.
while($row=$result->fetch_assoc()){
    $resultat[]=$row;
}
//conversion dans un array
$nom_colonnes=array_column($resultat,'COLUMN_NAME');

//listes des colonnes à mettre à jour.
$colonnes_update = array();
//liste de toutes les variables POST.
$variables_POST = array();
foreach ($_POST as $key => $value)
{
    //récupération des clés de variables PHP.
    $variables_POST[] = $key;
}

//compare les colonnes de la table au variables POST entrées
foreach ($nom_colonnes as $colonne){
        if (in_array($colonne,$variables_POST,TRUE)) {
            $colonnes_update[] = $colonne;
        }
}
//liste des variables contenant le nom de la colonne et la valeur à entrer.
$variables_POST_update = array();
foreach ($_POST as $key =>$value){
    if(in_array($key,$colonnes_update,TRUE)){
        $variables_POST_update[$key] = $value;
    }
}
//récupération de l'identifiant de la ligne à modifier.
$id = $_POST['id_update'];

//création de la requete de mise à jour.
$query = "UPDATE utilisateur SET ";

foreach ($variables_POST_update as $key => $value) {
    $query .= "$key = '$value',";
}
$query = rtrim($query, ",");
$query .= " WHERE id_$table_upddate = ?";

// Execution de la requete.
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);

$stmt->execute();
$result = $stmt->get_result();

?>