<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use MongoDB\Client;

echo "Test 1 : connexion et insertion dans MongoDB.\n";
try {
    $client = new Client("mongodb://localhost:27017");
    $collection = $client->viteEtGourmand->statistiquesCommandes;

    $resultat = $collection->insertOne([
        "menu_id" => 1,
        "date_commande" => date("Y-m-d"),
        "prix_paye" => "60.00"
    ]);

    echo "OK - Document inséré avec l'id : " . $resultat->getInsertedId() . "\n";
} catch (Exception $e) {
    echo "ECHEC - " . $e->getMessage() . "\n";
}
?>