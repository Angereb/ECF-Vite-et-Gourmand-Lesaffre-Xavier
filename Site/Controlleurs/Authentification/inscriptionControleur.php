<?php 
require_once __DIR__ . "/../../Modeles/Utilisateurs/ClientModele.php";
require_once __DIR__ . "/../../Services/Mail/ServiceMail.php";

$titre = "Inscription";

$css = [
    "Authentification/inscription.css",
];

$javascript = [];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST["action"] ?? null;
    try {
        switch($formulaire){
            case 'inscription':
                $nom = $_POST["nom"] ?? "";
                $prenom = $_POST["prenom"] ?? "";
                $email = $_POST["email"] ?? "";
                $motDePasse = $_POST["motDePasse"] ?? "";
                $verificationMotDePasse = $_POST["verificationMotDePasse"] ?? "";
                $numeroTelephone = $_POST["numeroTelephone"] ?? "";
                $adressePostale = $_POST["adressePostale"] ?? "";
                if ($motDePasse !== $verificationMotDePasse){
                    throw new Exception("Les deux mot de passe ne correspondent pas.");
                }
                $client = new Client(
                    null,
                    $nom,
                    $prenom,
                    $email,
                    $motDePasse,
                    false,
                    $numeroTelephone,
                    $adressePostale,
                    true);
                $clientModele = new ClientModele();
                $clientModele->ajouter($client);
                $_SESSION["messageSucces"] = "Votre compte client a bien été créé.";
                try {
                    $corpsMail = "<p>Bonjour " . htmlspecialchars($prenom) . ",</p>";
                    $corpsMail .= "<p>Bienvenue chez Vite & Gourmand ! Votre compte a bien été créé.</p>";
                    $corpsMail .= "<p>Vous pouvez dès à présent vous connecter et commander nos menus.</p>";
                    ServiceMail::envoyer(
                        $email,
                        "Bienvenue chez Vite & Gourmand",
                        $corpsMail
                    );
                } catch (Exception $e) {
                    error_log("Échec de l'envoi du mail de bienvenue : " . $e->getMessage());
                }
                header("Location: ?page=connexion");
                exit;
            default:
                throw new Exception("Action inconnue");
        }
    } catch (Exception $e){
        $toastMessage = $e->getMessage();
        $toastType = "erreur";
    }
}

ob_start();
require __DIR__ . '/../../Vus/Authentification/inscription.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calquePrincipal.php';
?>