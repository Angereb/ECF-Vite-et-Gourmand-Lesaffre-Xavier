<?php
require_once __DIR__ . "/../../../Modeles/Avis/AvisModele.php";
require_once __DIR__ . "/../../../Modeles/StatutsAvis/StatutAvisModele.php";
require_once __DIR__ . "/../../../Modeles/Commandes/CommandeModele.php";
require_once __DIR__ . "/../../../Modeles/Menus/MenuModele.php";
require_once __DIR__ . "/../../../Modeles/Utilisateurs/ClientModele.php";

if (!isset($_SESSION["employe"])) {
    header("Location: ?page=accueil");
    exit;
}

$titreOnglet = "Gestion Avis";

$cssOnglet = ["EspacePerso/Employe/ongletAvisEmploye.css"];

$jsOnglet = [];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

$avisModele = new AvisModele;
$statutAvisModele = new StatutAvisModele;
$commandeModele = new CommandeModele;
$menuModele = new MenuModele;
$clientModele = new ClientModele;
$statutEnAttente = $statutAvisModele->rechercherParLibelle("En attente");
if ($statutEnAttente === null) {
    throw new Exception("Configuration du système incorrecte.");
}
$avis = $avisModele->rechercherTousParStatut(statutsAvisId: $statutEnAttente->getStatutsAvisId());
$avisComplets = [];
foreach ($avis as $avisRecuperer) {
    $commande = $commandeModele->rechercherParId($avisRecuperer->getCommandesId());
    $menu = $menuModele->rechercherParId($commande->getMenusId());
    $client = $clientModele->rechercherParId($commande->getUtilisateursId());
    $avisComplets[] = [
        "id" => $avisRecuperer->getAvisId(),
        "titre" => $avisRecuperer->getTitre(),
        "note" => $avisRecuperer->getNote(),
        "commentaire" => $avisRecuperer->getCommentaire(),
        "menu" => $menu->getTitre(),
        "nom" => $client->getNom(),
        "prenom" => $client->getPrenom()
    ];
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST["action"] ?? null;
    try {
        switch($formulaire){
            case 'validerAvis':
                $avisId = (int)($_POST["avisId"] ?? 0);
                $avisExistant = $avisModele->rechercherParId($avisId);
                if ($avisExistant === null) {
                    throw new Exception("Avis Introuvable.");
                }
                $statutValider = $statutAvisModele->rechercherParLibelle("Valider");
                if ($statutValider === null) {
                    throw new Exception("Configuration du système incorrecte.");
                }
                $avisModele->modifierStatut($avisId, $statutValider->getStatutsAvisId());
                $_SESSION["messageSucces"] = "L'avis sélectionner a été valider.";
            break;

            case 'refuserAvis':
                $avisId = (int)($_POST["avisId"] ?? 0);
                $avisExistant = $avisModele->rechercherParId($avisId);
                if ($avisExistant === null) {
                    throw new Exception("Avis Introuvable.");
                }
                $statutRefuser = $statutAvisModele->rechercherParLibelle("Refuser");
                if ($statutRefuser === null) {
                    throw new Exception("Configuration du système incorrecte.");
                }
                $avisModele->modifierStatut($avisId, $statutRefuser->getStatutsAvisId());
                $_SESSION["messageSucces"] = "L'avis sélectionner a été refuser.";
            break;
        }
        header("Location: ?page=espacePerso&onglet=avisEmploye");
        exit;
    } catch (Exception $e){
        $toastMessage = $e->getMessage();
        $toastType = "erreur";
    }
}

ob_start();
require __DIR__ . '/../../../Vus/EspacePerso/Employe/ongletAvisEmploye.php';
$contenuOnglet = ob_get_clean();
?>