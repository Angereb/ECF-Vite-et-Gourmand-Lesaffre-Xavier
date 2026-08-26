<?php 
require_once __DIR__ . "/../../Services/Mail/ServiceMail.php";

$titre = "Contact";

$css = [
    "Contact/contact.css",
];

$javascript = [
    ""
];

$messageErreur = null;

$configuration = require __DIR__ . "/../../Configuration/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST["action"] ?? null;
    try {
        switch($formulaire){
            case 'contact':
                $titre = $_POST["titre"] ?? "";
                $titre = trim($titre);
                if ($titre === ""){
                    throw new Exception("Le titre ne peut pas être vide");
                }
                $description = $_POST["description"] ?? "";
                $description = trim($description);
                if ($description === "") {
                    throw new Exception("Le contenue du mail ne peut être vide.");
                }
                $email = $_POST["email"] ?? "";
                $email = trim($email);
                if ($email === "") {
                    throw new Exception("L'addresse mail ne peut pas être vide.");
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("L'adresse mail n'est pas valide.");
                }
                $destinataireEntreprise = $configuration["smtpUtilisateur"];
                $corpsMail = "<p>Nouveau message de contact reçu :</p>";
                $corpsMail .= "<p><strong>De :</strong> " . htmlspecialchars($email) . "</p>";
                $corpsMail .= "<p><strong>Titre :</strong> " . htmlspecialchars($titre) . "</p>";
                $corpsMail .= "<p><strong>Message :</strong><br>" . nl2br(htmlspecialchars($description)) . "</p>";
                ServiceMail::envoyer(
                    $destinataireEntreprise,
                    "Nouveau message de contact : " . $titre,
                    $corpsMail,
                    $email
                );
                break;
            default:
                throw new Exception("Action inconnue");
        }
        $_SESSION["messageSucces"] = "Votre message a bien été envoyé.";
        header("Location: ?page=accueil");
        exit;
    } catch (Exception $e){
        $toastMessage = $e->getMessage();
        $toastType = "erreur";
    }
}

ob_start();
require __DIR__ . '/../../Vus/Contact/contact.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calquePrincipal.php';
?>
?>