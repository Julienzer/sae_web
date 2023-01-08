<?php

// Inclure la bibliothèque de JWT de Firebase
require_once 'path/to/firebase/php-jwt/src/JWT.php';

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

        // Vérifier que l'utilisateur est un administrateur (remplacez ceci par votre propre logique de vérification de privilèges)
        if ($token->privilege == 'admin') {
            // Récupérer les nouvelles informations de l'utilisateur envoyées par le client
            $new_username = $_POST['username'];
            $new_email = $_POST['email'];

            // Préparer et exécuter la requête SQL pour mettre à jour les informations de l'utilisateur
            $stmt = $pdo->prepare('UPDATE User SET username = :new_username, email = :new_email WHERE username = :username');
            $stmt->execute(array(
                ':new_username' => $new_username,
                ':new_email' => $new_email,
                ':username' => $token->username,
            ));

            // Renvoyer un message de succès au client de l'API
            header('Content-type: application/json');
            echo json_encode(array(
                'message' => 'User information updated successfully',
            ));
        } else {
            // L'utilisateur n'a pas les privilèges nécessaires, renvoyer une erreur
            header('HTTP/1.1 403 Forbidden');
            echo 'You do not have the necessary privileges to update user information';
        }
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
