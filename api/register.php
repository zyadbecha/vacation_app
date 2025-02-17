<?php
header("Content-Type: application/json");
require 'config.php';

// Récupération des données JSON envoyées
$data = json_decode(file_get_contents("php://input"), true);

if(!isset($data["name"], $data["email"], $data["password"])) {
    echo json_encode(["message" => "Données manquantes."]);
    exit;
}

// Vérifier si l'utilisateur existe déjà
$existingUser = $db->users->findOne(["email" => $data["email"]]);
if($existingUser) {
    echo json_encode(["message" => "Cet email est déjà utilisé."]);
    exit;
}

// Hashage du mot de passe
$passwordHash = password_hash($data["password"], PASSWORD_BCRYPT);

// Insertion du nouvel utilisateur dans la collection
$result = $db->users->insertOne([
    "name" => $data["name"],
    "email" => $data["email"],
    "password" => $passwordHash,
    "role" => "client"
]);

echo json_encode([
    "message" => "Inscription réussie.",
    "insertedId" => (string)$result->getInsertedId()
]);
?>
