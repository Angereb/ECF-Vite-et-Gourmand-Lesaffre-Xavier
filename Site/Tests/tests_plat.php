<?php 
require_once __DIR__ . "/../Modeles/Plats/PlatModele.php";
require_once __DIR__ . "/../Modeles/Plats/Plat.php";

$modele = new PlatModele();

echo "Test 1 : rechercherParId sur un plat existant\n";
$plat = $modele->rechercherParId(1);
if ($plat !== null) {
    echo "OK - " . $plat->getTitre() . "\n";
} else {
    echo "ECHEC - plat non trouvé\n";
}

echo "\nTest 2 : rechercherParId sur un id inexistant\n";
$plat = $modele->rechercherParId(9999);
echo ($plat === null) ? "OK - null retourné comme attendu\n" : "ECHEC - devrait être null\n";

echo "\nTest 3 : rechercherFiltrer avec catégorie\n";
$resultats = $modele->rechercherFiltrer(categorie: "Plat");
echo count($resultats) . " plat(s) trouvé(s)\n";
foreach ($resultats as $m) {
    echo "- " . $m->getTitre() . " : " . $m->getCategorie() . "\n";
}

echo "\nTest 4 : rechercherFiltrer après désactivation\n";
$modele->modifierActif(1, false);
$resultats = $modele->rechercherFiltrer(categorie: "Plat");
echo count($resultats) . " plat(s) trouvé(s)\n";
foreach ($resultats as $m) {
    echo "- " . $m->getTitre() . " : " . $m->getCategorie() . "\n";
}

echo "\nTest 5 : création d'un nouveau plat\n";
$plats2 = new Plat(null, "lasagnes", "Plat", null, true, 1);
$modele->ajouter($plats2);
$resultats = $modele->rechercherFiltrer(categorie: "Plat");
echo count($resultats) . " plat(s) trouvé(s)\n";
foreach ($resultats as $m) {
    echo "- " . $m->getTitre() . " : " . $m->getCategorie() . "\n";
}

echo "\nTest 6 : création d'un nouveau plat avec un mauvais régime\n";
try{
    $plats3 = new Plat(null, "Moules Marinières", "Plat", null, true, 889);
    $modele->ajouter($plats3);
    echo "ECHEC - devrait lever une exception\n";
} catch (Exception $e) {
    echo "OK - exception attrapée : " . $e->getMessage() . "\n";
}

echo "\nTest 7 : création d'un nouveau plat avec un titre existant\n";
try{
    $plats3 = new Plat(null, "lasagnes", "Plat", null, true, 1);
    $modele->ajouter($plats3);
    echo "ECHEC - devrait lever une exception\n";
} catch (Exception $e) {
    echo "OK - exception attrapée : " . $e->getMessage() . "\n";
}

echo "\nTest 8 : modification d'un plat puis vérification par rechercherFiltrer\n";
$platsExistant = $modele->rechercherFiltrer(categorie: "Plat");
$idLasagnes = null;
foreach ($platsExistant as $p) {
    if ($p->getTitre() === "lasagnes") {
        $idLasagnes = $p->getPlatsId();
    }
}
$plats4 = new Plat($idLasagnes, "lasagnes", "Entrée", null, true, 1);
$modele->modifier($plats4);
$resultats = $modele->rechercherFiltrer(categorie: "Entrée");
echo count($resultats) . " plat(s) trouvé(s) en catégorie Entrée\n";
foreach ($resultats as $m) {
    echo "- " . $m->getTitre() . " : " . $m->getCategorie() . "\n";
}
?>