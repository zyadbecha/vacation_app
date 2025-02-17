<?php
header("Content-Type: application/json");
require 'config.php';

// Récupération de la chaîne de recherche passée en GET
$query = isset($_GET['query']) ? $_GET['query'] : "";

// Utilisation d'une expression régulière pour une recherche insensible à la casse
$regex = new MongoDB\BSON\Regex($query, "i");
$offersCursor = $db->offers->find(["name" => $regex]);

$offers = [];
foreach ($offersCursor as $offer) {
    // Conversion de l'ObjectId en string pour faciliter l'utilisation en front-end
    $offer["_id"] = (string)$offer["_id"];
    $offers[] = $offer;
}
echo json_encode($offers);
?>
