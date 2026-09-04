<?php
require_once __DIR__ . "/../../../Modeles/Commandes/CommandeModele.php";
require_once __DIR__ . "/../../../Modeles/StatutsCommande/StatutCommandeModele.php";
require_once __DIR__ . "/../../../Modeles/Menus/MenuModele.php";
require_once __DIR__ . "/../../../Modeles/Avis/AvisModele.php";
require_once __DIR__ . "/../../../Modeles/StatutsAvis/StatutAvisModele.php";

if (!isset($_SESSION["client"])) {
    header("Location: ?page=accueil");
    exit;
}

$titreOnglet = "Mes avis";

$cssOnglet = ["EspacePerso/Client/ongletAvisClient.css"];

$jsOnglet = ["EspacePerso/Client/ongletAvisClient.js"];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

$commandeModele = new CommandeModele;
$statutCommandeModele = new StatutCommandeModele;
$menuModele = new MenuModele;
$avisModele = new AvisModele;
$statutsAvisModele = new StatutAvisModele;
$statutTermine = $statutCommandeModele->rechercherParLibelle("Terminée");
if ($statutTermine === null) {
    throw new Exception("Configuration du système incorrecte.");
}
$commandes = $commandeModele->rechercherFiltrer(utilisateursId: $_SESSION["client"]["utilisateursId"], statutsCommandeId: $statutTermine->getStatutsCommandeId());
$commandesSansAvis = [];
$commandesAvecAvis = [];
foreach ($commandes as $commandeRecuperer) {
    $menu = $menuModele->rechercherParId($commandeRecuperer->getMenusId());
    $avis = $avisModele->rechercherParCommande($commandeRecuperer->getCommandesId());
    if ($avis === null){
        $commandesSansAvis[] = [
            "id" => $commandeRecuperer->getCommandesId(),
            "menuTitre" => $menu->getTitre(),
            "datePrestation" => $commandeRecuperer->getDatePrestation(),
        ];
    } else {
        $statutAvis = $statutsAvisModele->rechercherParId($avis->getStatutsAvisId());
        $commandesAvecAvis[] = [
            "id" => $commandeRecuperer->getCommandesId(),
            "menuTitre" => $menu->getTitre(),
            "datePrestation" => $commandeRecuperer->getDatePrestation(),
            "avisId" => $avis->getAvisId(),
            "avisTitre" => $avis->getTitre(),
            "avisNote" => $avis->getNote(),
            "avisStatut" => $statutAvis->getLibelle(),
        ];
    }   
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST["action"] ?? null;
    try {
        switch($formulaire){
            case 'envoyerAvis':
                $commandeId = (int)($_POST['commandeId'] ?? 0);
                $commandeExistante = $commandeModele->rechercherParId($commandeId);
                if ($commandeExistante === null) {
                    throw new Exception("Commande introuvable.");
                }
                if ($commandeExistante->getUtilisateursId() !== (int)$_SESSION["client"]["utilisateursId"]){
                    throw new Exception("Vous ne pouvez pas envoyer cet avis.");
                }
                if ($avisModele->rechercherParCommande($commandeId) !== null) {
                    throw new Exception("Un avis a déjà été posté pour cette commande.");
                }
                $statutEnAttente = $statutsAvisModele->rechercherParLibelle("En attente");
                if ($statutEnAttente === null) {
                    throw new Exception("Configuration du système incorrecte.");
                }
                $titreAvis = $_POST['titre'] ?? "";
                $commentaireAvis = $_POST['commentaire'] ?? "";
                $noteAvis = (int)($_POST['note'] ?? 0);
                $avisEnvoyer = new Avis(
                    null,
                    $titreAvis,
                    $noteAvis,
                    $commentaireAvis,
                    $commandeId,
                    $statutEnAttente->getStatutsAvisId()
                );
                $avisModele->ajouter($avisEnvoyer);
                break;
        }
        $_SESSION["messageSucces"] = "Votre avis a bien été poster.";
        header("Location: ?page=espacePerso&onglet=avisClient");
        exit;
    } catch (Exception $e){
        $toastMessage = $e->getMessage();
        $toastType = "erreur";
    }
}


ob_start();
require __DIR__ . '/../../../Vus/EspacePerso/Client/ongletAvisClient.php';
$contenuOnglet = ob_get_clean();
?>