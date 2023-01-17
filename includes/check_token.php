<?php

/** @var mysqli $conn */
$conn = include __DIR__ . '/database_connection.php';
$token = $_SERVER['HTTP_AUTH'];

$tokenQ= <<<EOF
    select u.id_utilisateur,p.nom_privilege
    from utilisateur u ,privilege p 
    where p.id_privilege = u.id_privilege 
    and u.id_utilisateur 
            in (select id_utilisateur 
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