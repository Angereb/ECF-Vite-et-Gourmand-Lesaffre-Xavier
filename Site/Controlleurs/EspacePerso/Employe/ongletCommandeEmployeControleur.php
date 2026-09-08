<?php
require_once __DIR__ . "/../../../Modeles/Commandes/CommandeModele.php";
require_once __DIR__ . "/../../../Modeles/Menus/MenuModele.php";
require_once __DIR__ . "/../../../Modeles/CommandesPlats/CommandePlatModele.php";
require_once __DIR__ . "/../../../Modeles/Plats/PlatModele.php";
require_once __DIR__ . "/../../../Modeles/StatutsCommande/StatutCommandeModele.php";
require_once __DIR__ . "/../../../Modeles/Materiels/MaterielModele.php";
require_once __DIR__ . "/../../../Modeles/CommandesMateriels/CommandeMateriel.php";
require_once __DIR__ . "/../../../Modeles/Utilisateurs/ClientModele.php";

if (!isset($_SESSION["employe"])) {
    header("Location: ?page=accueil");
    exit;
}

$titreOnglet = "Gestion des commandes";

$cssOnglet = ["EspacePerso/Employe/ongletCommandeEmploye.css"];

$jsOnglet = ["EspacePerso/Employe/ongletCommandeEmploye.js"];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

$commandeModele = new CommandeModele;
$menuModele = new MenuModele;
$commandePlatModele = new CommandePlatModele;
$platModele = new PlatModele;
$statutCommandeModele = new StatutCommandeModele;
$materielModele = new MaterielModele;
$commandeMaterielModele = new CommandeMaterielModele;
$clientModele = new ClientModele;
$toutesCommandes = $commandeModele->rechercherFiltrer();
$commandesComplettes = [];
foreach ($toutesCommandes as $commandeRecuperer) {
    $menu = $menuModele->rechercherParId($commandeRecuperer->getMenusId());
    $platsId = $commandePlatModele->rechercherParCommande($commandeRecuperer->getCommandesId());
    $platsRecuperer = [];
    foreach ($platsId as $platId) {
        $platsRecuperer[] = $platModele->rechercherParId($platId);
    }
    $statutId = $statutCommandeModele->rechercherParId($commandeRecuperer->getStatutsCommandeId());
    $statut = $statutId->getLibelle();
    $client = $clientModele->rechercherParId($commandeRecuperer->getUtilisateursId());
    $commandesComplettes[] = [
        "id" => $commandeRecuperer->getCommandesId(),
        "nom" => $client->getNom(),
        "prenom" => $client->getPrenom(),
        "menuTitre" => $menu->getTitre(),
        "adresse" => $commandeRecuperer->getAdresse(),
        "codePostal" => $commandeRecuperer->getCodePostal(),
        "datePrestation" => $commandeRecuperer->getDatePrestation(),
        "heureLivraison" => $commandeRecuperer->getHeureLivraison(),
        "dateLivraison" => $commandeRecuperer->getDateLivraison(),
        "convive" => $commandeRecuperer->getConvive(),
        "plats" => $platsRecuperer,
        "statut" => $statut,
        "statutId" => $commandeRecuperer->getStatutsCommandeId()
    ];
}
$commandesComplettes = array_reverse($commandesComplettes);

$statutsCommande = $statutCommandeModele->rechercherTous();

$materiels = $materielModele->rechercherTous();

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST["action"] ?? null;
    try {
        switch($formulaire){
            case 'gererCommande':
                $commandeId = (int)($_POST['commandeId'] ?? 0);
                $statutCommandeId = (int)($_POST['statutCommande'] ?? 0);
                $commandeExistante = $commandeModele->rechercherParId($commandeId);
                if ($commandeExistante === null) {
                    throw new Exception("Commande introuvable.");
                }
                $nouveauStatut = $statutCommandeModele->rechercherParId($statutCommandeId);
                if ($nouveauStatut === null) {
                    throw new Exception("Statut invalide.");
                }
                $motif = null;
                $modeContact = null;
                if ($nouveauStatut->getLibelle() === "Annulée") {
                    $motif = $_POST['motif'] ?? "";
                    $modeContact = $_POST['modeContact'] ?? "";
                    if ($motif === "" || $modeContact === "") {
                        throw new Exception("Le motif et le mode de contact sont obligatoires pour une annulation.");
                    }
                }
                $commandeModele->modifierStatut($commandeId, $statutCommandeId, $motif, $modeContact);
                if ($nouveauStatut->getLibelle() === "Accepté") {
                    $materielsCoches = $_POST["materiels"] ?? [];
                    foreach ($materielsCoches as $materielId) {
                        $quantite = (int)($_POST["quantite_" . $materielId] ?? 1);
                        $commandeMaterielModele->ajouter($commandeId, (int)$materielId, $quantite);
                    }
                }
                $_SESSION["messageSucces"] = "La commande a bien été mise à jour.";
                break;
        }
        header("Location: ?page=espacePerso&onglet=commandesEmploye");
        exit;
    } catch (Exception $e){
        $toastMessage = $e->getMessage();
        $toastType = "erreur";
    }
}

ob_start();
require __DIR__ . '/../../../Vus/EspacePerso/Employe/ongletCommandeEmploye.php';
$contenuOnglet = ob_get_clean();
?>