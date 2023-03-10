<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    return;
}
/**
 * variables nécessaires :
 * POST['email_utilisateur'] et POST['mdp_utilisateur']
 */

//vérifie que les variables sont initialisées.
if (
    !isset($_POST['email_utilisateur'], $_POST['mdp_utilisateur'])
) {
    http_response_code(401);
    return;
}


/** @var mysqli $conn */
$conn = include __DIR__ . '/includes/database_connection.php';

//récupération du mail et mot de passe entré en variables POST.
$login = $_POST['email_utilisateur'];
$password = $_POST['mdp_utilisateur'];


// todo : use crypt function, do NOT store plain password in database : https://www.php.net/manual/en/function.crypt.php
$q = <<<EOF
    SELECT u.id_utilisateur
    FROM utilisateur u
    WHERE  u.email_utilisateur = ?
    AND u.mdp_utilisateur = ?
    LIMIT 1;
EOF;
$stmt = $conn->prepare($q);
$stmt->bind_param('ss', $login, $password);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();

//vérifie les données entrées correspondent bien à un utilisateur présent dans la base.
if (null === $data) {
    http_response_code(401);
    echo json_encode([
        'utilisateur inexistant ou identifiants incorrects.'
    ]);
    return;
}
// récupération de l'identifiant utilisateur.
$userId =  $data['id_utilisateur'];
// récupération d'un token lié à l'utilisateur.
$tokenQ = <<<EOF
    SELECT *
    FROM token
    WHERE token.id_utilisateur = ?
EOF;
$stmt = $conn->prepare($tokenQ);
$stmt->bind_param('d', $userId);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();

if (null === $data) {
    // génération d'un nouveau token.
    $token = bin2hex(random_bytes(16));
    //insertion dans la base du nouveau token.
    $insertTokenQ = <<<EOF
        INSERT INTO token (id_utilisateur,token)
        VALUES (?, ?)
EOF;
    $stmt = $conn->prepare($insertTokenQ);
    $stmt->bind_param('ds', $userId, $token);
    $stmt->execute();
} else {
    $token = $data['token'];
}

$_SERVER['HTTP_AUTH'] = $token;
header('Content-Type: application/json');
echo json_encode([
    'token' => $token
]);