<?php

/** @var mysqli $conn */
$conn = include __DIR__ . '/database_connection.php';
$token = $_SERVER['HTTP_AUTH'];

$tokenQ = <<<EOF
    select * 
    from utilisateur,privilege 
    where privilege.id_privilege = utilisateur.id_privilege 
    and utilisateur.id_user 
            in (select id_user 
                from token 
                where token = ?);
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