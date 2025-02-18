<?php
require '../vendor/autoload.php';

// Connexion à MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->reservation_app;
$offersCollection = $database->offers;

// Vérification du paramètre de recherche
$query = isset($_GET['query']) ? $_GET['query'] : "";

// Construction de la requête de recherche
$filter = [];
if (!empty($query)) {
    $filter = [
        '$or' => [
            ['name' => new MongoDB\BSON\Regex($query, 'i')],
            ['description' => new MongoDB\BSON\Regex($query, 'i')]
        ]
    ];
}

// Récupération des offres
$offers = $offersCollection->find($filter)->toArray();

// Conversion en format JSON
echo json_encode($offers);
?>
