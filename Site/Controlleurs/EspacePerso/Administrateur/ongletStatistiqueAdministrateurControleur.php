<?php
require_once __DIR__ . "/../../../Modeles/StatistiqueCommande/StatistiqueCommandeService.php";
require_once __DIR__ . "/../../../Modeles/Menus/MenuModele.php";

if (!isset($_SESSION["employe"]) || $_SESSION["employe"]["administrateur"] !== true) {
    header("Location: ?page=accueil");
    exit;
}

$titreOnglet = "Statistiques";

$cssOnglet = ["EspacePerso/Administrateur/ongletStatistiqueAdministrateur.css"];

$jsOnglet = ["EspacePerso/Administrateur/ongletStatistiqueAdministrateur.js"];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

$menuModele = new MenuModele;
$statistiquesCommande = StatistiqueCommandeService::compterCommandesParMenu();
$statistiquesNominative = [];
foreach ($statistiquesCommande as $statistiqueCommande) {
    $menu = $menuModele->rechercherParId($statistiqueCommande["menuId"]);
    $statistiquesNominative[] = [
        "menuTitre" => $menu->getTitre(),
        "nombreCommandes" => $statistiqueCommande["nombreCommandes"]
    ];
}
$tousMenus = $menuModele->rechercherFiltrer();
$ficheMenus = [];
foreach ($tousMenus as $menuRecuperer) {
    $ficheMenus[] = [
        "menuId" => $menuRecuperer->getMenusId(),
        "menuTitre" => $menuRecuperer->getTitre()
    ];
}

ob_start();
require __DIR__ . '/../../../Vus/EspacePerso/Administrateur/ongletStatistiqueAdministrateur.php';
$contenuOnglet = ob_get_clean();
?>