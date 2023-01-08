<?php

// Connexion à la base de données MySQL
$host = 'localhost';
$dbname = 'sae';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    // Erreur de connexion à la base de données, renvoyer une erreur
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error connecting to database: ' . $e->getMessage();
    exit;
}

// Préparer et exécuter la requête SQL pour récupérer les enseignants
$stmt = $pdo->prepare('SELECT * FROM Enseignant');
$stmt->execute();
$enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Renvoyer les enseignants au client de l'API
header('Content-type: application/json');
echo json_encode(array(
    'enseignants' => $enseignants,
));
