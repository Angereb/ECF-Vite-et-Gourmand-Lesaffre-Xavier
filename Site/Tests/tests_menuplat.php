<?php 
require_once __DIR__ . "/../Modeles/MenusPlats/MenuPlatModele.php";

$modele = new MenuPlatModele();

echo "Test 1 : créer un lien qui existe déjà (menu 1, plat 1)\n";
try {
    $modele->ajouter(1, 1);
    echo "ECHEC - aurait dû lever une exception\n";
} catch (Exception $e) {
    echo "OK - exception attrapée : " . $e->getMessage() . "\n";
}

echo "\nTest 2 : rechercherParMenu(1)\n";
$plats = $modele->rechercherParMenu(1);
echo count($plats) . " plat(s) trouvé(s) : " . implode(", ", $plats) . "\n";

echo "\nTest 3 : rechercherParPlat(1)\n";
$menus = $modele->rechercherParPlat(1);
echo count($menus) . " menu(s) trouvé(s) : " . implode(", ", $menus) . "\n";

echo "\nTest 4 : supprimer le lien (1, 1)\n";
try {
    $modele->supprimer(1, 1);
    echo "OK - suppression réussie\n";
} catch (Exception $e) {
    echo "ECHEC - " . $e->getMessage() . "\n";
}

echo "\nTest 5 : supprimer à nouveau le même lien (devrait échouer)\n";
try {
    $modele->supprimer(1, 1);
    echo "ECHEC - aurait dû lever une exception\n";
} catch (Exception $e) {
    echo "OK - exception attrapée : " . $e->getMessage() . "\n";
}

echo "\nTest 6 : recréer le lien (1, 1)\n";
try {
    $modele->ajouter(1, 1);
    echo "OK - lien recréé\n";
} catch (Exception $e) {
    echo "ECHEC - " . $e->getMessage() . "\n";
}
?>