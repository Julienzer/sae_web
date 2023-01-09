<?php

// Inclure la bibliothèque de JWT de Firebase
require_once 'C:/Users/julie/vendor/firebase/php-jwt/src/JWT.php'; // à changer en fonction du dossier d'installation

// Clé secrète utilisée pour signer les JWT
$secret_key = 'G+KbPeShVkYp3s6v9y$B&E)H@McQfTjW';

// Vérifier si une demande de connexion a été envoyée
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Récupérer les identifiants de connexion envoyés par le client
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier les identifiants de connexion (remplacez ceci par votre propre logique d'authentification)
    if ($username == 'your_username' && $password == 'your_password') {
        // Générer un JWT contenant les informations d'identification de l'utilisateur
        $token = array(
            'username' => $username,
            'privilege' => 'admin', // Niveau de privilège de l'utilisateur (par exemple, admin ou user)
        );
        $jwt = JWT::encode($token, $secret_key);

        // Renvoyer le JWT au client de l'API
        header('Content-type: application/json');
        echo json_encode(array(
            'jwt' => $jwt,
        ));
    } else {
        // Les identifiants de connexion sont incorrects, renvoyer une erreur
        header('HTTP/1.1 401 Unauthorized');
        echo 'Invalid username or password';
    }
} else {
    // Aucune demande de connexion n'a été envoyée, renvoyer une erreur
    header('HTTP/1.1 400 Bad Request');
    echo 'Missing username or password';
}
