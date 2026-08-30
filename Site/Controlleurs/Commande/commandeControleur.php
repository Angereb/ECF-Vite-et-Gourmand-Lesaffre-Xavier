<?php
require_once __DIR__ . "/../../Modeles/Utilisateurs/ClientModele.php";

if (isset($_GET["menuId"])) {
    $_SESSION["menuIdCommande"] = (int)$_GET["menuId"];
}

if (isset($_SESSION["employe"])) {
    unset($_SESSION["menuIdCommande"]);
    header("Location: ?page=accueil");
    exit;
}

if (!isset($_SESSION["client"])) {
    header("Location: ?page=connexion");
    exit;
}

$titre = "Commande";

$css = [
    "Commande/commande.css",
];

$javascript = [
    "Commande/commande.js",
];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

$clientModele = new ClientModele;
$client = $clientModele->rechercherParId($_SESSION["client"]["utilisateursId"]);

ob_start();
require __DIR__ . '/../../Vus/Commande/commande.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calquePrincipal.php';
?>