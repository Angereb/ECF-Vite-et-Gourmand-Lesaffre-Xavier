<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . "/../../Modeles/Menus/MenuModele.php";
require_once __DIR__ . "/../../Modeles/Themes/ThemeModele.php";
require_once __DIR__ . "/../../Modeles/Regimes/RegimeModele.php";
require_once __DIR__ . "/../../Modeles/Images/ImageModele.php";
require_once __DIR__ . "/../../Modeles/MenusPlats/MenuPlatModele.php";
require_once __DIR__ . "/../../Modeles/Plats/PlatModele.php";
require_once __DIR__ . "/../../Modeles/PlatsAllergenes/PlatAllergeneModele.php";
require_once __DIR__ . "/../../Modeles/Allergenes/AllergeneModele.php";


header("Content-Type: application/json");
$menuModele = new MenuModele();
$themeModele = new ThemeModele();
$regimeModele = new RegimeModele();
$imageModele = new ImageModele();
$menuPlatModele = new MenuPlatModele();
$platModele = new PlatModele();
$platAllergeneModele = new PlatAllergeneModele();
$allergeneModele = new AllergeneModele();
$menuComplet = [];
if (!isset($_GET["id"])) {
    http_response_code(404);
    echo json_encode(["erreur" => "Menu introuvable"]);
    exit;
}
$menu = $menuModele->rechercherParId((int)$_GET["id"]);
if ($menu === null) {
    http_response_code(404);
    echo json_encode(["erreur" => "Menu introuvable"]);
    exit;
}
$theme = $themeModele->rechercherParId($menu->getThemesId());
$regime = $regimeModele->rechercherParId($menu->getRegimesId());
$images = $imageModele->rechercherParMenusId($menu->getMenusId());
$menuPlats = $menuPlatModele->rechercherParMenu($menu->getMenusId());
$platsComplets = [];
foreach ($menuPlats as $platId) {
    $plat = $platModele->rechercherParId($platId);
    $allergenesDuPlat = [];
    $platAllergenes = $platAllergeneModele->rechercherParPlat($platId);
    foreach ($platAllergenes as $allergeneId) {
        $allergene = $allergeneModele->rechercherParId($allergeneId);
        $allergenesDuPlat[] = $allergene->getLibelle();
    }
    $regimePlat = $regimeModele->rechercherParId($plat->getRegimesId());
    $platsComplets[] = [
        "id" => $plat->getPlatsId(),
        "titre" => $plat->getTitre(),
        "categorie" => $plat->getCategorie(),
        "photo" => $plat->getPhoto() !== null ? base64_encode($plat->getPhoto()) : null,
        "allergenes" => $allergenesDuPlat,
        "platRegime" => $regimePlat->getLibelle()
    ];
}
$menuComplet = [
    "id" => $menu->getMenusId(),
    "titre" => $menu->getTitre(),
    "description" => $menu->getDescriptions(),
    "conditions" => $menu->getConditions(),
    "stock" => $menu->getStock(),
    "minimumConvive" => $menu->getMinimumConvive(),
    "prix" => $menu->getPrix(),
    "theme" => $theme->getLibelle(),
    "regime" => $regime->getLibelle(),
    "images" => array_map(fn($img) => base64_encode($img->getPhoto()), $images),
    "plats" => $platsComplets
];
echo json_encode($menuComplet);
?>

