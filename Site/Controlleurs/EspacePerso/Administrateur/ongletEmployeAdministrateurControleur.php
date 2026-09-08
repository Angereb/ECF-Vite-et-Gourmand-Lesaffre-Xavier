<?php
require_once __DIR__ . "/../../../Modeles/Utilisateurs/EmployeModele.php";

if (!isset($_SESSION["employe"]) || $_SESSION["employe"]["administrateur"] !== true) {
    header("Location: ?page=accueil");
    exit;
}

$titreOnglet = "Gestion Employés";

$cssOnglet = ["EspacePerso/Administrateur/ongletEmployeAdministrateur.css"];

$jsOnglet = ["EspacePerso/Administrateur/ongletEmployeAdministrateur.js"];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

$employeModele = new EmployeModele;
$employes = $employeModele->rechercherTous();
$fichesEmploye = [];
foreach ($employes as $employe) {
    if ($employe->getActif() === true) {
        $employeActif = "Actif";
    } else {
        $employeActif = "Inactif";
    }
    $fichesEmploye[] = [
        "utilisateurId" => $employe->getUtilisateursId(),
        "nom" => $employe->getNom(),
        "prenom" => $employe->getPrenom(),
        "email" => $employe->getEmail(),
        "etat" => $employeActif
    ];
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST["action"] ?? null;
    try {
        switch($formulaire){
            case 'creerEmploye':
                $nom = $_POST["nom"] ?? "";
                $prenom = $_POST["prenom"] ?? "";
                $email = $_POST["email"] ?? "";
                $motDePasse = $_POST["motDePasse"] ?? "";
                $verificationMotDePasse = $_POST["verificationMotDePasse"] ?? "";
                if ($motDePasse !== $verificationMotDePasse){
                    throw new Exception("Les deux mot de passe ne correspondent pas.");
                }
                $nouvelEmploye = new Employe(
                    null,
                    $nom,
                    $prenom,
                    $email,
                    $motDePasse,
                    false,
                    false,
                    true);
                $employeModele->ajouter($nouvelEmploye);
                $_SESSION["messageSucces"] = "Le compte employé a bien été créé.";
                break;

            case 'toggleStatutEmploye':
                $employeId = (int)($_POST['employeId'] ?? 0);
                $employeExistant = $employeModele->rechercherParId($employeId);
                if ($employeExistant === null) {
                    throw new Exception("Employé introuvable.");
                }
                $employeModele->modifierActif($employeId, !$employeExistant->getActif());
                $_SESSION["messageSucces"] = "Le statut de l'employé a bien été modifié.";
                break;
        }
        header("Location: ?page=espacePerso&onglet=employeAdministrateur");
        exit;
    } catch (Exception $e){
        $toastMessage = $e->getMessage();
        $toastType = "erreur";
    }
}

ob_start();
require __DIR__ . '/../../../Vus/EspacePerso/Administrateur/ongletEmployeAdministrateur.php';
$contenuOnglet = ob_get_clean();
?>