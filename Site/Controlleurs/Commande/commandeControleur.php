<?php
require_once __DIR__ . "/../../Modeles/Utilisateurs/ClientModele.php";
require_once __DIR__ . "/../../Modeles/StatutsCommande/StatutCommandeModele.php";
require_once __DIR__ . "/../../Modeles/Plats/PlatModele.php";
require_once __DIR__ . "/../../Modeles/Commandes/CommandeModele.php";
require_once __DIR__ . "/../../Modeles/CommandesPlats/CommandePlatModele.php";
require_once __DIR__ . "/../../Services/Mail/ServiceMail.php";

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

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST["action"] ?? null;
    try {
        switch($formulaire){
            case 'commander':
                $adresse = $_POST["adresseLivraison"] ?? "";
                $codePostal = $_POST["codePostal"] ?? "";
                $datePrestation = new DateTime($_POST["datePrestation"] ?? "");
                $heureLivraison = ($_POST["heureLivraison"] ?? "") . ":00";
                $dateLivraison = new DateTime($_POST["dateLivraison"] ?? "");
                $convive = (int)$_POST["convive"] ?? "";
                $facture = 0;
                $utilisateurId = $_SESSION["client"]["utilisateursId"] ?? "";
                if ($utilisateurId === ""){
                    throw new Exception("Il y a un problème de session utilisateur.");
                }
                $menuId =  $_SESSION["menuIdCommande"] ?? "";
                if ($menuId === ""){
                    throw new Exception("Il y a un problème avec la récupération du menu.");
                }
                $statutCommandeModele = new StatutCommandeModele();
                $statutEnAttente = $statutCommandeModele->rechercherParLibelle("En attente");
                if ($statutEnAttente === null) {
                    throw new Exception("Configuration du système incorrecte.");
                }
                $statutsCommandeId = $statutEnAttente->getStatutsCommandeId();
                $menuModele = new MenuModele();
                $menu = $menuModele->rechercherParId($menuId);
                $commande = new Commande(
                    null,
                    $adresse,
                    $codePostal,
                    $datePrestation,
                    $heureLivraison,
                    $dateLivraison,
                    $convive,
                    $facture,
                    $utilisateurId,
                    $menuId,
                    $statutsCommandeId,
                    false
                );
                $commandeModele = new CommandeModele();
                $commandesId = $commandeModele->ajouter($commande, $menu);
                $commandePlatModele = new CommandePlatModele();
                $platEntreeId = $_POST["plat-Entrée"] ?? null;
                $platPlatId = $_POST["plat-Plat"] ?? null;
                $platDessertId = $_POST["plat-Dessert"] ?? null;
                if ($platEntreeId !== null) {
                    $commandePlatModele->ajouter($commandesId, (int)$platEntreeId);
                }
                if ($platPlatId !== null) {
                    $commandePlatModele->ajouter($commandesId, (int)$platPlatId);
                }
                if ($platDessertId !== null) {
                    $commandePlatModele->ajouter($commandesId, (int)$platDessertId);
                }
                try {
                    $corpsMail = "<p>Bonjour " . htmlspecialchars($_SESSION["client"]["prenom"]) . ",</p>";
                    $corpsMail .= "<p>Votre commande pour le menu \"" . htmlspecialchars($menu->getTitre()) . "\" a bien été enregistrée.</p>";
                    $corpsMail .= "<p>Elle est en attente de validation par notre équipe.</p>";
                    ServiceMail::envoyer(
                        $_SESSION["client"]["email"],
                        "Confirmation de votre commande - Vite & Gourmand",
                        $corpsMail
                    );
                } catch (Exception $e) {
                    error_log("Échec de l'envoi du mail de confirmation : " . $e->getMessage());
                }
                unset($_SESSION["menuIdCommande"]);
                $_SESSION["messageSucces"] = "Votre commande a bien été enregistrée.";
                break;
            default:
                throw new Exception("Action Inconnue");
        }
        header("Location: ?page=accueil");
        exit;
    } catch(Exception $e){$messageErreur = $e->getMessage();}
}

ob_start();
require __DIR__ . '/../../Vus/Commande/commande.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calquePrincipal.php';
?>