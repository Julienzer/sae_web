<?php

/** @var mysqli $conn */
$conn = include __DIR__ . '/database_connection.php';
$token = $_SERVER['HTTP_AUTH'];

$tokenQ = <<<EOF
    SELECT user.id_user, user.username, user.privilege
    FROM token
    LEFT JOIN user
    ON token.user_id = user.id_user
    WHERE token = ?
    LIMIT 1;
EOF;


$stmt = $conn->prepare($tokenQ);
$stmt->bind_param('s', $token);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();

if (null === $data) {
    echo json_encode([
        'error' => 'Aucun token trouvé.'
    ]);
}

return $data;