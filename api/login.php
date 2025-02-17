<?php
header("Content-Type: application/json");
session_start();
require 'config.php';

// Récupération des données JSON envoyées
$data = json_decode(file_get_contents("php://input"), true);
if(!isset($data["email"], $data["password"])) {
    echo json_encode(["message" => "Données manquantes."]);
    exit;
}

// Recherche de l'utilisateur par email
$user = $db->users->findOne(["email" => $data["email"]]);
if(!$user) {
    echo json_encode(["message" => "Utilisateur non trouvé."]);
    exit;
}

// Vérification du mot de passe
if(password_verify($data["password"], $user["password"])) {
    // Mise en place d'une session (vous pourrez adapter pour un système de jeton JWT si besoin)
    $_SESSION["user_id"] = (string)$user["_id"];
    $_SESSION["role"] = $user["role"];
    echo json_encode(["success" => true, "message" => "Connexion réussie."]);
} else {
    echo json_encode(["message" => "Mot de passe incorrect."]);
}
?>
