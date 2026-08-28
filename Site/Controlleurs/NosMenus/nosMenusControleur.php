<?php 
require_once __DIR__ . "/../../Modeles/Themes/ThemeModele.php";
require_once __DIR__ . "/../../Modeles/Regimes/RegimeModele.php";

$titre = "Nos Menus";

$css = [
    "NosMenus/nosMenus.css",
];

$javascript = [
    "NosMenus/nosMenus.js"
];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

$themeModele = new ThemeModele();
$regimeModele = new RegimeModele();
$themes = $themeModele->rechercherTous();
$regimes = $regimeModele->rechercherTous();

ob_start();
require __DIR__ . '/../../Vus/NosMenus/nosMenus.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calquePrincipal.php';
?>