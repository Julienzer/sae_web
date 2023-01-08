<?php

// Inclure la bibliothèque de JWT de Firebase
require_once 'C:/Users/julie/vendor/firebase/php-jwt/src/JWT.php'; // à changer en fonction du dossier d'installation

// Clé secrète utilisée pour vérifier les JWT
$secret_key = 'your_secret_key';

// Vérifier si un JWT a été envoyé dans l'en-tête d'autorisation
if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    // Extraire le JWT de l'en-tête d'autorisation
    $jwt = explode(' ', $_SERVER['HTTP_AUTHORIZATION'])[1];

    // Vérifier le JWT (remplacez ceci par votre propre logique de vérification de JWT)
    try {
        $token = JWT::decode($jwt, $secret_key, array('HS256'));

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

        // Préparer et exécuter la requête SQL pour récupérer les informations de l'utilisateur
        $stmt = $pdo->prepare('SELECT * FROM User WHERE username = :username');
        $stmt->execute(array(
            ':username' => $token->username,
        ));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Renvoyer les informations de l'utilisateur au client de l'API
        header('Content-type: application/json');
        echo json_encode(array(
            'user' => $user,
        ));
    } catch (Exception $e) {
        // JWT non valide, renvoyer une erreur
        header('HTTP/1.1 401 Unauthorized');
        echo 'Invalid JWT';
    }
} else {
    // Aucun JWT n'a été envoyé, renvoyer une erreur
    header('HTTP/1.1 401 Unauthorized');
    echo 'No JWT provided';
}
