<?php
require_once __DIR__ . "/../../../Modeles/Commandes/CommandeModele.php";
require_once __DIR__ . "/../../../Modeles/Menus/MenuModele.php";
require_once __DIR__ . "/../../../Modeles/CommandesPlats/CommandePlatModele.php";
require_once __DIR__ . "/../../../Modeles/Plats/PlatModele.php";
require_once __DIR__ . "/../../../Modeles/StatutsCommande/StatutCommandeModele.php";

if (!isset($_SESSION["client"])) {
    header("Location: ?page=accueil");
    exit;
}

$titreOnglet = "Mes commandes";

$cssOnglet = ["EspacePerso/Client/ongletCommande.css"];

$jsOnglet = ["EspacePerso/Client/ongletCommandes.js"];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

$commandeModele = new CommandeModele;
$menuModele = new MenuModele;
$commandePlatModele = new CommandePlatModele;
$platModele = new PlatModele;
$statutCommandeModele = new StatutCommandeModele;
$commandes = $commandeModele->rechercherFiltrer(utilisateursId: $_SESSION["client"]["utilisateursId"]);
$commandesComplettes = [];
foreach ($commandes as $commandeRecuperer) {
    $menu = $menuModele->rechercherParId($commandeRecuperer->getMenusId());
    $platsId = $commandePlatModele->rechercherParCommande($commandeRecuperer->getCommandesId());
    $platsRecuperer = [];
    foreach ($platsId as $platId) {
        $platsRecuperer[] = $platModele->rechercherParId($platId);
    }
    $statutId = $statutCommandeModele->rechercherParId($commandeRecuperer->getStatutsCommandeId());
    $statut = $statutId->getLibelle();
    $commandesComplettes[] = [
        "id" => $commandeRecuperer->getCommandesId(),
        "menuTitre" => $menu->getTitre(),
        "adresse" => $commandeRecuperer->getAdresse(),
        "codePostal" => $commandeRecuperer->getCodePostal(),
        "datePrestation" => $commandeRecuperer->getDatePrestation(),
        "heureLivraison" => $commandeRecuperer->getHeureLivraison(),
        "dateLivraison" => $commandeRecuperer->getDateLivraison(),
        "convive" => $commandeRecuperer->getConvive(),
        "facture" => $commandeRecuperer->getFacture(),
        "plats" => $platsRecuperer,
        "statut" => $statut
    ];
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST["action"] ?? null;
    try {
        switch($formulaire){
            case 'modifierCommande':
                $commandeId = (int)($_POST['commandeId'] ?? 0);
                $commandeModele = new CommandeModele();
                $commandeExistante = $commandeModele->rechercherParId($commandeId);
                if ($commandeExistante === null) {
                    throw new Exception("Commande introuvable.");
                }
                if ($commandeExistante->getUtilisateursId() !== (int)$_SESSION["client"]["utilisateursId"]) {
                    throw new Exception("Vous n'avez pas le droit de modifier cette commande.");
                }
                $statutCommandeModele = new StatutCommandeModele();
                $statutActuel = $statutCommandeModele->rechercherParId($commandeExistante->getStatutsCommandeId());
                if ($statutActuel->getLibelle() !== "En attente") {
                    throw new Exception("Cette commande ne peut plus être modifiée.");
                }
                $adresseModifier = $_POST["adresseLivraison"] ?? "";
                $codePostalModifier = $_POST["codePostal"] ?? "";
                $datePrestationModifier = new DateTime($_POST["datePrestation"] ?? "");
                $heureLivraisonBrute = $_POST["heureLivraison"] ?? "";
                $heureLivraisonModifier = (substr_count($heureLivraisonBrute, ':') === 1) 
                    ? $heureLivraisonBrute . ":00" 
                    : $heureLivraisonBrute;
                $dateLivraisonModifier = new DateTime($_POST["dateLivraison"] ?? "");
                $conviveModifier = (int)$_POST["convive"] ?? "";
                $menuModele = new MenuModele();
                $menu = $menuModele->rechercherParId($commandeExistante->getMenusId());
                $commandeModifier = new Commande(
                    $commandeId, 
                    $adresseModifier, 
                    $codePostalModifier, 
                    $datePrestationModifier,
                    $heureLivraisonModifier,
                    $dateLivraisonModifier,
                    $conviveModifier,
                    "0",
                    $commandeExistante->getUtilisateursId(),
                    $commandeExistante->getMenusId(),
                    $commandeExistante->getStatutsCommandeId(),
                    false
                );
                $commandeModele->modifier($commandeModifier, $menu);
                break;
        }
        $_SESSION["messageSucces"] = "Votre commande a bien été modifier.";
        header("Location: ?page=espacePerso&onglet=commandesClient");
        exit;
    } catch (Exception $e){
        $toastMessage = $e->getMessage();
        $toastType = "erreur";
    }
}

ob_start();
require __DIR__ . '/../../../Vus/EspacePerso/Client/ongletCommandesClient.php';
$contenuOnglet = ob_get_clean();
?>