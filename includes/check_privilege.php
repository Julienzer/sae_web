<?php
function check_privilege($privilege)
{
//vérification du statut d'administrateur et de la connexion grâce au token.
    $tokenData = include __DIR__ . '/check_token.php';
    if ($privilege !== $tokenData['nom_privilege']) {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'Insufisant permissions 🤓'
        ]);
        return false;
    }
    return true;
}



?>