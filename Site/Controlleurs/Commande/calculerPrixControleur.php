<?php
require_once __DIR__ . "/../../Modeles/Menus/MenuModele.php";
require_once __DIR__ . "/../../Modeles/Commandes/CommandeModele.php";

header("Content-Type: application/json");

if (!isset($_SESSION["menuIdCommande"]) || !isset($_GET["convive"]) || !isset($_GET["codePostal"])) {
    http_response_code(400);
    echo json_encode(["erreur" => "Paramètres manquants"]);
    exit;
}

$menuModele = new MenuModele();
$menu = $menuModele->rechercherParId((int)$_SESSION["menuIdCommande"]);

if ($menu === null) {
    http_response_code(404);
    echo json_encode(["erreur" => "Menu introuvable"]);
    exit;
}

$convive = (int)$_GET["convive"];
$codePostal = $_GET["codePostal"];
$commandeModele = new CommandeModele();
$prixParPersonne = bcdiv($menu->getPrix(), (string)$menu->getMinimumConvive(), 4);
$prixMenuBrut = bcmul($prixParPersonne, (string)$convive, 2);
$tauxReduction = ($convive >= ($menu->getMinimumConvive() + 5)) ? "0.10" : "0.00";
$reduction = bcmul($prixMenuBrut, $tauxReduction, 2);
$prixMenuFinal = bcsub($prixMenuBrut, $reduction, 2);
$fraisLivraison = $commandeModele->calculerFraisLivraison($codePostal);
$total = bcadd($prixMenuFinal, (string)$fraisLivraison, 2);

echo json_encode([
    "prixMenu" => $prixMenuBrut,
    "reduction" => $reduction,
    "fraisLivraison" => $fraisLivraison,
    "total" => $total
]);
?>