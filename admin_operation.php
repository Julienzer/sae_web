<?php

// Inclure la bibliothèque de JWT de Firebase
require_once 'C:/Users/julie/vendor/firebase/php-jwt/src/JWT.php'; // à changer en fonction du dossier d'installation

// Clé secrète utilisée pour vérifier les JWT
$secret_key = 'G+KbPeShVkYp3s6v9y$B&E)H@McQfTjW';

// Vérifier si un JWT a été envoyé dans l'en-tête d'autorisation
if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    // Extraire le JWT de l'en-tête d'autorisation
    $jwt = explode(' ', $_SERVER['HTTP_AUTHORIZATION'])[1];

    // Vérifier le JWT (remplacez ceci par votre propre logique de vérification de JWT)
    try {
        $token = JWT::decode($jwt, $secret_key, array('HS256'));

        // Vérifier que l'utilisateur est un administrateur (remplacez ceci par votre propre logique de vérification de privilèges)
        if ($token->privilege == 'admin') {
            // Récupérer l'opération administrative demandée par le client
            $operation = $_POST['operation'];

            // Exécuter l'opération administrative demandée
            switch ($operation) {
                case 'reset_database':
                    // Exécuter le script de réinitialisation de la base de données
                    reset_database();
                    break;
                case 'create_user':
                    // Récupérer les informations de l'utilisateur à créer
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $email = $_POST['email'];
                    $privilege = $_POST['privilege'];

                    // Créer l'utilisateur
                    create_user($username, $password, $first_name, $last_name, $email, $privilege);
                    break;
                case 'delete_user':
                    // Récupérer le nom d'utilisateur de l'utilisateur à supprimer
                    $username = $_POST['username'];

                    // Supprimer l'utilisateur
                    delete_user($username);
                    break;
                default:
                    // Opération administrative non valide, renvoyer une erreur
                    header('HTTP/1.1 400 Bad Request');
                    echo 'Invalid admin operation';
                    break;
            }
        } else {
            // L'utilisateur n'a pas les privilèges nécessaires, renvoyer une erreur
            header('HTTP/1.1 403 Forbidden');
            echo 'You do not have the necessary privileges to perform this operation';
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

// Fonction pour réinitialiser la base de données
function reset_database() {
    // Écrivez ici votre logique de réinitialisation de base de données
    // Assurez-vous de gérer les erreurs de requête SQL et d'autres erreurs potentielles
}

// Fonction pour créer un utilisateur
function create_user($username, $password, $first_name, $last_name, $email, $privilege) {
    // Écrivez ici votre logique de création d'utilisateur
    // Assurez-vous de gérer les erreurs de requête SQL et d'autres erreurs potentielles

    // Si l'utilisateur a été créé avec succès, renvoyer une réponse 201 Created
    http_response_code(201);
}

// Fonction pour supprimer un utilisateur
function delete_user($username) {
    // Écrivez ici votre logique de suppression d'utilisateur
    // Assurez-vous de gérer les erreurs de requête SQL et d'autres erreurs potentielles

    // Si l'utilisateur a été supprimé avec succès, renvoyer une réponse 200 OK
    http_response_code(200);
}


