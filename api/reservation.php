<?php
require '../vendor/autoload.php';

// Connexion à MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->reservation_app;
$reservationsCollection = $database->reservations;

// Vérifier si la requête est en POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données JSON envoyées
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['offerId']) && isset($data['userId'])) {
        $newReservation = [
            'userId' => $data['userId'],
            'offerId' => new MongoDB\BSON\ObjectId($data['offerId']),
            'status' => 'en attente',
            'date' => new MongoDB\BSON\UTCDateTime()
        ];

        // Insérer la réservation dans MongoDB
        $result = $reservationsCollection->insertOne($newReservation);

        if ($result->getInsertedCount() > 0) {
            echo json_encode(["success" => true, "message" => "Réservation effectuée"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la réservation"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Données incomplètes"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}
?>
