<?php
require_once __DIR__ . "/../../Modeles/Avis/AvisModele.php";
require_once __DIR__ . "/../../Modeles/Avis/Avis.php";
require_once __DIR__ . "/../../Modeles/Commandes/CommandeModele.php";
require_once __DIR__ . "/../../Modeles/Menus/MenuModele.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/ClientModele.php";

$titre = "Accueil";

$css = [
    "Accueil/accueil.css",
];

$javascript = [
    "Accueil/accueil.js"
];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

$avisModele = new AvisModele();
$commandeModele = new CommandeModele();
$menuModele = new MenuModele();
$clientModele = new ClientModele();
$avisBruts = $avisModele->rechercherTousParStatut(1);
$avisComplets = [];
foreach ($avisBruts as $avi) {
    $commande = $commandeModele->rechercherParId($avi->getCommandesId());
    $client = $clientModele->rechercherParId($commande->getUtilisateursId());
    $menu = $menuModele->rechercherParId($commande->getMenusId());
    $avisComplets[] = [
        "id" => $avi->getAvisId(),
        "titre" => $avi->getTitre(),
        "note" => $avi->getNote(),
        "commentaire" => $avi->getCommentaire(),
        "nomClient" => $client->getPrenom() . " " . $client->getNom(),
        "menu" => $menu->getTitre()
    ];
}


ob_start();
require __DIR__ . '/../../Vus/Accueil/accueil.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calquePrincipal.php';
?>