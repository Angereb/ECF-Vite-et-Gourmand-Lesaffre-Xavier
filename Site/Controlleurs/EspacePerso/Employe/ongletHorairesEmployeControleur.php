<?php
require_once __DIR__ . "/../../../Modeles/Horaires/HoraireModele.php";

if (!isset($_SESSION["employe"])) {
    header("Location: ?page=accueil");
    exit;
}

$titreOnglet = "Horaires";

$cssOnglet = ["EspacePerso/Employe/ongletHorairesEmploye.css"];

$jsOnglet = [];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

$horaireModele = new HoraireModele();
$horaires = $horaireModele->rechercherTous();

$horairesParJour = [];
foreach ($horaires as $horaire) {
    $horairesParJour[$horaire->getJour()] = $horaire;
}

$ordreJours = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST["action"] ?? null;
    try {
        switch($formulaire){
            case 'modifierHoraires' :
                foreach ($ordreJours as $jourOrdonne) {
                    $ouverture = $_POST["ouverture_" . $jourOrdonne] ?? "";
                    if ($ouverture === "") {
                        $ouvertureModifier = null;
                    } else {
                        $ouvertureModifier = (substr_count($ouverture, ':') === 1) ? $ouverture . ":00" : $ouverture;
                    }
                    $fermeture = $_POST["fermeture_" . $jourOrdonne] ?? "";
                    if ($fermeture === "") {
                        $fermetureModifier = null;
                    } else {
                        $fermetureModifier = (substr_count($fermeture, ':') === 1) ? $fermeture . ":00" : $fermeture;
                    }
                    if (!isset($horairesParJour[$jourOrdonne])) {
                        $horaireObjet = new Horaire(null, $jourOrdonne, $ouvertureModifier, $fermetureModifier);
                        $horaireModele->ajouter($horaireObjet);
                    } else {
                        $horaireExistant = $horairesParJour[$jourOrdonne];
                        $horaireObjet = new Horaire($horaireExistant->getHorairesId(), $jourOrdonne, $ouvertureModifier, $fermetureModifier);
                        $horaireModele->modifier($horaireObjet);
                    } 
                    $_SESSION["messageSucces"] = "Les horaires ont bien été mis à jour.";
                }
            break;
        }
        header("Location: ?page=espacePerso&onglet=horairesEmploye");
        exit;
    } catch (Exception $e){
        $toastMessage = $e->getMessage();
        $toastType = "erreur";
    }
}

ob_start();
require __DIR__ . '/../../../Vus/EspacePerso/Employe/ongletHorairesEmploye.php';
$contenuOnglet = ob_get_clean();
?>