<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    return;
}

if (
    !isset($_POST['login'], $_POST['password'])
) {
    http_response_code(401);
    return;
}


/** @var mysqli $conn */
$conn = include __DIR__ . '/includes/database_connection.php';

$login = $_POST['login'];
$password = $_POST['password'];

// todo : use crypt function, do NOT store plain password in database : https://www.php.net/manual/en/function.crypt.php
$q = <<<EOF
    SELECT u.id_user, u.username, u.privilege
    FROM user u
    WHERE username = ?
    AND password = ?
    LIMIT 1;
EOF;

$stmt = $conn->prepare($q);
$stmt->bind_param('ss', $login, $password);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();

if (null === $data) {
    http_response_code(401);
    return;
}

$userId = (int) $data['id_user'];

$tokenQ = <<<EOF
    SELECT *
    FROM token
    WHERE token.user_id = ?
EOF;

$stmt = $conn->prepare($tokenQ);
$stmt->bind_param('d', $userId);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();

if (null === $data) {
    # generate new token
    $token = bin2hex(random_bytes(16));

    $insertTokenQ = <<<EOF
        INSERT INTO token (user_id, token)
        VALUES (?, ?)
EOF;

    $stmt = $conn->prepare($insertTokenQ);
    $stmt->bind_param('ds', $userId, $token);
    $stmt->execute();
} else {
    $token = $data['token'];
}

header('Content-Type: application/json');
echo json_encode([
    'token' => $token
]);