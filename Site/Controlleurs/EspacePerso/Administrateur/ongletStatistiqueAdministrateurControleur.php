<?php
require_once __DIR__ . "/../../../Modeles/StatistiqueCommande/StatistiqueCommandeService.php";

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



ob_start();
require __DIR__ . '/../../../Vus/EspacePerso/Administrateur/ongletStatistiqueAdministrateur.php';
$contenuOnglet = ob_get_clean();
?>