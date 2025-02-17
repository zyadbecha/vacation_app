<?php
// Inclusion de l'autoload de Composer (assurez-vous d'avoir installé mongodb/mongodb via Composer)
require_once __DIR__ . '/../vendor/autoload.php';

// Connexion à MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$db = $mongoClient->vacation_db;
?>
