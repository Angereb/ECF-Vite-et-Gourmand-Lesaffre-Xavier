<?php
require_once __DIR__ . "/../Services/Mail/ServiceMail.php";

echo "Test 1 : envoi d'un email de test.\n";
try {
    ServiceMail::envoyer(
        "reivax.erffasel@gmail.com",
        "Test ECF Vite et Gourmand",
        "<p>Ceci est un email de test envoyé depuis PHPMailer.</p>"
    );
    echo "OK - Email envoyé avec succès.\n";
} catch (Exception $e) {
    echo "ECHEC - " . $e->getMessage() . "\n";
}