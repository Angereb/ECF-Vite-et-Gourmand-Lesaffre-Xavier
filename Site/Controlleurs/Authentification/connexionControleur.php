<?php 
require_once __DIR__ . "/../../Modeles/Utilisateurs/ClientModele.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/EmployeModele.php";

$titre = "Connexion";

$css = [
    "Authentification/connexion.css",
];

$javascript = [
    ""
];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST["action"] ?? null;
    try {
        switch($formulaire){
            case 'connexion':
                $email = $_POST["email"] ?? "";
                $motDePasse = $_POST["motDePasse"] ?? "";
                $clientModele = new ClientModele();
                $employeModele = new EmployeModele();
                if ($utilisateur = $clientModele->rechercherParEmail($email)){
                    if (!$utilisateur->getActif()){
                        throw new Exception("Identifiant ou mot de passe incorrect.");
                    }
                    if (!password_verify($motDePasse, $utilisateur->getMotDePasse())){
                        throw new Exception("Identifiant ou mot de passe incorrect.");
                    }
                    $_SESSION["client"] = [
                        "utilisateursId" => $utilisateur->getUtilisateursId(),
                        "nom" => $utilisateur->getNom(),
                        "prenom" => $utilisateur->getPrenom(),
                        "email" => $utilisateur->getEmail(),
                        "numeroTelephone" => $utilisateur->getNumeroTelephone(),
                        "adressePostale" => $utilisateur->getAdressePostale()];
                    $destination = isset($_SESSION["menuIdCommande"]) ? "commande" : "accueil";
                    $_SESSION["messageSucces"] = "Bienvenue à vous.";
                    header("Location: ?page=" . $destination);
                    exit;
                }
                elseif ($utilisateur = $employeModele->rechercherParEmail($email)){
                    if (!$utilisateur->getActif()){
                        throw new Exception("Identifiant ou mot de passe incorrect.");
                    }
                    if (!password_verify($motDePasse, $utilisateur->getMotDePasse())){
                        throw new Exception("Identifiant ou mot de passe incorrect.");
                    }
                    $_SESSION["employe"] = [
                        "utilisateursId" => $utilisateur->getUtilisateursId(),
                        "nom" => $utilisateur->getNom(),
                        "prenom" => $utilisateur->getPrenom(),
                        "email" => $utilisateur->getEmail(),
                        "administrateur" => $utilisateur->getAdministrateur()];
                    $destination = isset($_SESSION["menuIdCommande"]) ? "commande" : "accueil";
                    $_SESSION["messageSucces"] = "Bienvenue à vous.";
                    header("Location: ?page=" . $destination);
                }
                else throw new Exception("Identifiant ou mot de passe incorrect.");
            default:
                throw new Exception("Action inconnue");
        }
    } catch (Exception $e){
        $toastMessage = $e->getMessage();
        $toastType = "erreur";
    }
}

ob_start();
require __DIR__ . '/../../Vus/Authentification/connexion.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calquePrincipal.php';
?>