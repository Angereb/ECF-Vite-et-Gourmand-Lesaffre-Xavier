<?php
require_once __DIR__ . "/../../../Modeles/Utilisateurs/ClientModele.php";

if (!isset($_SESSION["client"])) {
    header("Location: ?page=accueil");
    exit;
}

$titreOnglet = "Mes informations";

$cssOnglet = ["EspacePerso/Client/ongletCompteClient.css"];

$jsOnglet = [];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

$clientModele = new ClientModele;
$client = $clientModele->rechercherParId((int)$_SESSION["client"]["utilisateursId"]);

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST["action"] ?? null;
    try {
        switch($formulaire){
            case 'modifierCompte':
                $clientid = (int)$_SESSION["client"]["utilisateursId"];
                $clientExistant = $clientModele->rechercherParId($clientid);
                if ($clientExistant === null) {
                    throw new Exception("Client Introuvable.");
                }
                $nomModifier = $_POST["nom"] ?? "";
                $prenomModifier = $_POST["prenom"] ?? "";
                $emailModifier = $_POST["email"] ?? "";
                $numeroTelephoneModifier = $_POST["numeroTelephone"] ?? "";
                $adressePostaleModifier = $_POST["adressePostale"] ?? "";
                $motDePasse = $_POST["motDePasse"] ?? "";
                if (!password_verify($motDePasse, $clientExistant->getMotDePasse())){
                    throw new Exception("Une erreur est subvenue.");
                }
                $clientModifier = new Client(
                    $clientid,
                    $nomModifier,
                    $prenomModifier,
                    $emailModifier,
                    $clientExistant->getMotDePasse(),
                    true,
                    $numeroTelephoneModifier,
                    $adressePostaleModifier,
                    true);
                $clientModele->modifier($clientModifier);
                $_SESSION["messageSucces"] = "Votre compte client a bien été modifier.";
            break;

            case 'modifierMotDePasse':
                $clientid = (int)$_SESSION["client"]["utilisateursId"];
                $clientExistant = $clientModele->rechercherParId($clientid);
                if ($clientExistant === null) {
                    throw new Exception("Client Introuvable.");
                }
                $ancienMotDePasse = $_POST["ancienMotDePasse"] ?? "";
                $nouveauMotDePasse = $_POST["nouveauMotDePasse"] ?? "";
                $verificationNouveauMotDePasse = $_POST["verificationNouveauMotDePasse"] ?? "";
                if (!password_verify($ancienMotDePasse, $clientExistant->getMotDePasse())){
                    throw new Exception("Une erreur est subvenue.");
                }
                if ($nouveauMotDePasse !== $verificationNouveauMotDePasse){
                    throw new Exception("Les deux mot de passe ne correspondent pas.");
                }
                $clientModele->modifierMotDePasse($clientid, $nouveauMotDePasse);
                $_SESSION["messageSucces"] = "Votre mot de passe a bien été modifier.";
        }
        header("Location: ?page=espacePerso&onglet=infosClient");
        exit;
    } catch (Exception $e){
        $toastMessage = $e->getMessage();
        $toastType = "erreur";
    }
}

ob_start();
require __DIR__ . '/../../../Vus/EspacePerso/Client/ongletCompteClient.php';
$contenuOnglet = ob_get_clean();
?>