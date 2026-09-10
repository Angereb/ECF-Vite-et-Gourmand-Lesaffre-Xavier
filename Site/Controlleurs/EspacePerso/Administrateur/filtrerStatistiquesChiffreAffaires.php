<?php
require_once __DIR__ . "/../../../Modeles/StatistiqueCommande/StatistiqueCommandeService.php";
require_once __DIR__ . "/../../../Modeles/Menus/MenuModele.php";

header("Content-Type: application/json"); 
$menuModele = new MenuModele;
$dateDebut = $_GET["dateDebut"] ?? null;
$dateFin = $_GET["dateFin"] ?? null;
$menuId = isset($_GET["menuId"]) ? (int)($_GET["menuId"]) : null;
$statistiquesFiltrer = StatistiqueCommandeService::calculerChiffreAffairesFiltrer($dateDebut, $dateFin, $menuId);
$chiffreAffaire = [];
foreach ($statistiquesFiltrer as $statistiqueFiltrer) {
    $menu = $menuModele->rechercherParId($statistiqueFiltrer["menuId"]);
    $chiffreAffaire[] = [
        "menuTitre" => $menu->getTitre(),
        "chiffreAffaire" => $statistiqueFiltrer["chiffreAffaire"]
    ];
}
echo json_encode($chiffreAffaire);
?>