<?php
require '../vendor/autoload.php';

// Connexion à MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->reservation_app;
$usersCollection = $database->users;

// Vérifier si la requête est en POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['name']) && isset($data['email']) && isset($data['password'])) {
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $newUser = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $hashedPassword,
            'role' => 'client'
        ];

        // Insérer dans la collection users
        $result = $usersCollection->insertOne($newUser);

        if ($result->getInsertedCount() > 0) {
            echo json_encode(["success" => true, "message" => "Inscription réussie"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de l'inscription"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Données incomplètes"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}
?>
