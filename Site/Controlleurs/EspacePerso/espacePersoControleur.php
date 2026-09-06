<?php

$onglet = $_GET['onglet'] ?? null;

$titreBase = "Mon Espace";

$cssCommun = ["EspacePerso/calqueEspacePerso.css"];

$jsCommun = [];

switch ($onglet) {
    case 'infosClient':
        require __DIR__ . '/Client/ongletCompteClientControleur.php';
        break;

    case 'commandesClient':
        require __DIR__ . '/Client/ongletCommandesClientControleur.php';
        break;

    case 'avisClient':
        require __DIR__ . '/Client/ongletAvisClientControleur.php';
        break;

    case 'infosEmploye':
        require __DIR__ . '/Employe/ongletCompteEmployeControleur.php';
        break;
        
    case 'horairesEmploye':
        require __DIR__ . '/Employe/ongletHorairesEmployeControleur.php';
        break;

    case 'avisEmploye':
        require __DIR__ . '/Employe/ongletAvisEmployeControleur.php';
        break;

    case 'commandesEmploye':
        require __DIR__ . '/Employe/ongletCommandeEmployeControleur.php';
        break;

    default:
        $titreOnglet = "Introuvable";
        $contenuOnglet = "<p>Cet onglet n'existe pas.</p>";
        $cssOnglet = [];
        $jsOnglet = [];
}

$titre = $titreBase . " - " . $titreOnglet;

$css = array_merge($cssCommun, $cssOnglet);

$javascript = array_merge($jsCommun, $jsOnglet);

$messageErreur = null;

ob_start();
require __DIR__ . '/../../Vus/EspacePerso/calqueEspacePerso.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calquePrincipal.php';

?>