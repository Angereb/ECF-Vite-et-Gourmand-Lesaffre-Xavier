<?php 
require_once __DIR__ . "/../Modeles/Themes/ThemesModele.php";
require_once __DIR__ . "/../Modeles/Themes/Theme.php";

$modele = new ThemesModele();

echo "Test 1 : créer un nouveau thème.\n";
$themeNouveau = new Theme(null, "St Valentin");
try {
    $modele->ajouter($themeNouveau);
    echo "OK - Nouveau thème ajouter.\n";
} catch (Exception $e) {
    echo "ECHEC - exception attrapée : " . $e->getMessage() . "\n";
}

echo "Test 2 : créer un nouveau thème existant.\n";
$themeNouveau2 = new Theme(null, "St Valentin");
try {
    $modele->ajouter($themeNouveau2);
    echo "ECHEC - Nouveau thème ajouter.\n";
} catch (Exception $e) {
    echo "OK - exception attrapée : " . $e->getMessage() . "\n";
}

echo "Test 3 : rechercher un thème.\n";
$theme1 = $modele->rechercherParId(1);
if ($theme1 !== null) {
    echo "OK - " . $theme1->getLibelle() . "\n";
} else {
    echo "ECHEC - thème non trouvé.\n";
}

echo "Test 4 : rechercher un thème inexistant.\n";
$theme2 = $modele->rechercherParId(985);
if ($theme2 !== null) {
    echo "Echec - " . $theme1->getLibelle() . "\n";
} else {
    echo "Ok - thème non trouvé.\n";
}

echo "Test 5 : rechercher tous les thèmes\n";
$resultats = $modele->recherchertous();
echo count($resultats) . " menu(s) trouvé(s)\n";
foreach ($resultats as $m) {
    echo "- " . $m->getLibelle() . ".\n";
}

echo "Test 6 : Modification d'un thème.\n";
$theme3 = $modele->rechercherParId(2);
$themeModifier = new Theme($theme3->getThemesId(), "St Patrick");
try {
    $modele->modifier($themeModifier);
    echo "OK - Modifiaction du thème réussi.\n";
} catch (Exception $e) {
    echo "ECHEC - exception attrapée : " . $e->getMessage() . "\n";
}

echo "Test 7 : Suppression d'un thème.\n";
try {
    $modele->supprimer(2);
    echo "OK - Suppression de thème réussi.\n";
} catch (Exception $e) {
    echo "ECHEC - exception attrapée : " . $e->getMessage() . "\n";
}

?>