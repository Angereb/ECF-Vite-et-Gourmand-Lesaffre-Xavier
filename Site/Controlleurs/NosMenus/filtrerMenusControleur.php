<?php
require_once __DIR__ . "/../../Modeles/Menus/MenuModele.php";
require_once __DIR__ . "/../../Modeles/Regimes/Regime.php";
require_once __DIR__ . "/../../Modeles/Regimes/RegimeModele.php";

// indication au navigateur que le résultat sera du json
header("Content-Type: application/json"); 
// initialisation des variables de filtrage
$prixMax = isset($_GET["prixMax"]) ? (float)$_GET["prixMax"] : null;
$prixMin = isset($_GET["prixMin"]) ? (float)$_GET["prixMin"] : null;
$themesId = isset($_GET["themesId"]) ? (int)$_GET["themesId"] : null;
$regimesId = isset($_GET["regimesId"]) ? (int)$_GET["regimesId"] : null;
$convivesMin = isset($_GET["convivesMin"]) ? (int)$_GET["convivesMin"] : null;
$menuModele = new MenuModele();
$regimeModele = new RegimeModele();
$menus = $menuModele->rechercherFiltrer(prixMax : $prixMax, prixMin : $prixMin, themesId : $themesId, regimesId : $regimesId, convivesMin : $convivesMin);
$resultat = [];
foreach ($menus as $menu){
    $regime = $regimeModele->rechercherParId($menu->getRegimesId());
    $resultat[] = [
        "id" => $menu->getMenusId(),
        "titre" => $menu->getTitre(),
        "description" => $menu->getDescriptions(),
        "minimumConvive" => $menu->getMinimumConvive(),
        "prix" => $menu->getPrix(),
        "regime" => $regime->getLibelle()
    ];
}
echo json_encode($resultat);
?>