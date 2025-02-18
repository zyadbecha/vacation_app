<?php
require '../vendor/autoload.php';

// Connexion à MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->reservation_app;
$usersCollection = $database->users;

// Vérifier si la requête est en POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['email']) && isset($data['password'])) {
        $user = $usersCollection->findOne(['email' => $data['email']]);

        if ($user && password_verify($data['password'], $user['password'])) {
            echo json_encode([
                "success" => true,
                "message" => "Connexion réussie",
                "user" => [
                    "id" => (string)$user['_id'],
                    "name" => $user['name'],
                    "email" => $user['email'],
                    "role" => $user['role']
                ]
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Identifiants incorrects"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Données incomplètes"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}
?>
