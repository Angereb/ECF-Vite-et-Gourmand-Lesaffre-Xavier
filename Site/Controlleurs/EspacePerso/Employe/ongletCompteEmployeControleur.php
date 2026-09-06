<?php
require_once __DIR__ . "/../../../Modeles/Utilisateurs/EmployeModele.php";

if (!isset($_SESSION["employe"])) {
    header("Location: ?page=accueil");
    exit;
}

$titreOnglet = "Mes informations";

$cssOnglet = ["EspacePerso/Employe/ongletCompteEmploye.css"];

$jsOnglet = [];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

$employeModele = new EmployeModele;
$employe = $employeModele->rechercherParId((int)$_SESSION["employe"]["utilisateursId"]);

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST["action"] ?? null;
    try {
        switch($formulaire){
            case 'modifierCompte':
                $employeId = (int)$_SESSION["employe"]["utilisateursId"];
                $employeExistant = $employeModele->rechercherParId($employeId);
                if ($employeExistant === null) {
                    throw new Exception("Employé Introuvable.");
                }
                $nomModifier = $_POST["nom"] ?? "";
                $prenomModifier = $_POST["prenom"] ?? "";
                $emailModifier = $_POST["email"] ?? "";
                $motDePasse = $_POST["motDePasse"] ?? "";
                if (!password_verify($motDePasse, $employeExistant->getMotDePasse())){
                    throw new Exception("Une erreur est subvenue.");
                }
                $employeModifier = new Employe(
                    $employeId,
                    $nomModifier,
                    $prenomModifier,
                    $emailModifier,
                    $employeExistant->getMotDePasse(),
                    true, 
                    $employeExistant->getAdministrateur(),
                    $employeExistant->getActif());
                $employeModele->modifier($employeModifier);
                $_SESSION["messageSucces"] = "Votre compte employe a bien été modifier.";
            break;

            case 'modifierMotDePasse':
                $employeId = (int)$_SESSION["employe"]["utilisateursId"];
                $employeExistant = $employeModele->rechercherParId($employeId);
                if ($employeExistant === null) {
                    throw new Exception("Employe Introuvable.");
                }
                $ancienMotDePasse = $_POST["ancienMotDePasse"] ?? "";
                $nouveauMotDePasse = $_POST["nouveauMotDePasse"] ?? "";
                $verificationNouveauMotDePasse = $_POST["verificationNouveauMotDePasse"] ?? "";
                if (!password_verify($ancienMotDePasse, $employeExistant->getMotDePasse())){
                    throw new Exception("Une erreur est subvenue.");
                }
                if ($nouveauMotDePasse !== $verificationNouveauMotDePasse){
                    throw new Exception("Les deux mot de passe ne correspondent pas.");
                }
                $employeModele->modifierMotDePasse($employeId, $nouveauMotDePasse);
                $_SESSION["messageSucces"] = "Votre mot de passe a bien été modifier.";
            break;
        }
        header("Location: ?page=espacePerso&onglet=infosEmploye");
        exit;
    } catch (Exception $e){
        $toastMessage = $e->getMessage();
        $toastType = "erreur";
    }
}

ob_start();
require __DIR__ . '/../../../Vus/EspacePerso/Employe/ongletCompteEmploye.php';
$contenuOnglet = ob_get_clean();
?>