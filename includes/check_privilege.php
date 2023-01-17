<?php
function check_privilege($privilege)
{
//vérification du statut d'administrateur et de la connexion grâce au token.
    $tokenData = include __DIR__ . '/check_token.php';
    if ($tokenData['nom_privilege']!= $privilege) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => "Vous ne possédez pas le privilège nécessaire à cette fonction."
        ]);
        return false;
    }
    return true;

}



?>