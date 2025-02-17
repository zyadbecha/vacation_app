<?php
header("Content-Type: application/json");
session_start();
require 'config.php';

// Vérifier que l'utilisateur est connecté
if(!isset($_SESSION["user_id"])) {
    echo json_encode(["message" => "Non autorisé."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if(!isset($data["offer_id"])) {
    echo json_encode(["message" => "Données manquantes."]);
    exit;
}

// Création de la réservation dans la collection 'reservations'
$result = $db->reservations->insertOne([
    "user_id" => new MongoDB\BSON\ObjectId($_SESSION["user_id"]),
    "offer_id" => new MongoDB\BSON\ObjectId($data["offer_id"]),
    "date" => new MongoDB\BSON\UTCDateTime(),
    "status" => "confirmé"
]);

echo json_encode([
    "message" => "Réservation réussie.",
    "reservation_id" => (string)$result->getInsertedId()
]);
?>
