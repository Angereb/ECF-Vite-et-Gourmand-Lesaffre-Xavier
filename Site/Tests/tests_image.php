<?php
require_once __DIR__ . "/../Modeles/BaseDeDonnees.php";

/*
$pdo = BaseDeDonnees::connexion();
$contenuImage = file_get_contents(__DIR__ . "/../Publique/Images/Photo-Nancy-Ingersoll-Unsplash-1.png");

$requete = $pdo->prepare("UPDATE images SET photo = ? WHERE imagesId = 1");
$requete->execute([$contenuImage]);

echo "Image mise à jour.\n";
*/

require_once __DIR__ . "/../Modeles/Images/ImageModele.php";
require_once __DIR__ . "/../Publique/Images/Photo-Orkun-Orcan-Unsplash-1.png";

$imageModele = new ImageModele;
$photo1 = file_get_contents(__DIR__ . "/../Publique/Images/Photo-Corey-Watson-Unsplash-1.png");
$image1 = new Image(null, "Salade de Crevettes", $photo1, 1);
try {
    $imageModele->ajouter($image1);
    echo "OK - ajout dans la galerie réussie";
} catch (Exception $e) {
    echo "ECHEC - Pas de nouvelle photo dans la galerie";
}
