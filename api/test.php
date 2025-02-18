<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';

try {
    // Essayer de récupérer un document de la collection "offers"
    $document = $db->offers->findOne();
    if ($document) {
        echo "Connexion réussie ! Document trouvé :<br>";
        print_r($document);
    } else {
        echo "Connexion réussie, mais aucune donnée n'a été trouvée dans la collection 'offers'.";
    }
} catch (Exception $e) {
    echo "Erreur lors de la requête : " . $e->getMessage();
}
?>
