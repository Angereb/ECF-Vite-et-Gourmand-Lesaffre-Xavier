<?php
require_once __DIR__ . "/../Modeles/Menus/MenuModele.php";
require_once __DIR__ . "/../Modeles/Menus/Menu.php";

$modele = new MenuModele();

echo "Test 1 : rechercherParId sur un menu existant\n";
$menu = $modele->rechercherParId(1);
if ($menu !== null) {
    echo "OK - " . $menu->getTitre() . "\n";
} else {
    echo "ECHEC - menu non trouvé\n";
}

echo "\nTest 2 : rechercherParId sur un id inexistant\n";
$menu = $modele->rechercherParId(9999);
echo ($menu === null) ? "OK - null retourné comme attendu\n" : "ECHEC - devrait être null\n";

echo "\nTest 3 : rechercherFiltrer avec prixMax\n";
$resultats = $modele->rechercherFiltrer(prixMax: 70);
echo count($resultats) . " menu(s) trouvé(s)\n";
foreach ($resultats as $m) {
    echo "- " . $m->getTitre() . " : " . $m->getPrix() . "€\n";
}

echo "\nTest 4 : rechercherFiltrer après désactivation\n";
$modele->modifierActif(1, false);
$resultats = $modele->rechercherFiltrer(prixMax: 70);
echo count($resultats) . " menu(s) trouvé(s)\n";
foreach ($resultats as $m) {
    echo "- " . $m->getTitre() . " : " . $m->getPrix() . "€\n";
}
?>