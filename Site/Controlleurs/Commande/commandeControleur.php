<?php
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

$javascript = [];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

ob_start();
require __DIR__ . '/../../Vus/Commande/commande.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calquePrincipal.php';
?>