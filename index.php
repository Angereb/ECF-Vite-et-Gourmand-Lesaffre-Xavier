<?php 
session_start();

$page = $_GET['page'] ?? 'accueil';

switch ($page){
    case 'accueil':
        require_once __DIR__ . '/Site/Controlleurs/Accueil/accueilControleur.php';
        break;

    case 'contact':
        require_once __DIR__ . '/Site/Controlleurs/Contact/contactControleur.php';
        break;

    case 'nosMenus':
        require_once __DIR__ . '/Site/Controlleurs/NosMenus/nosMenusControleur.php';
        break;

    case 'filtrerMenus':
        require_once __DIR__ . '/Site/Controlleurs/NosMenus/filtrerMenusControleur.php';
        break;

    case 'detailMenus':
        require_once __DIR__ . '/Site/Controlleurs/NosMenus/detailMenusControleur.php';
        break;

    case 'inscription':
        require_once __DIR__ . '/Site/Controlleurs/Authentification/inscriptionControleur.php';
        break;
    
    case 'connexion':
        require_once __DIR__ . '/Site/Controlleurs/Authentification/connexionControleur.php';
        break;

    case 'deconnexion':
        require_once __DIR__ . '/Site/Controlleurs/Authentification/deconnexionControleur.php';
        break;
    
    case 'commande':
        require_once __DIR__ . '/Site/Controlleurs/Commande/commandeControleur.php';
        break;

    case 'reinitialisationMenu':
        require_once __DIR__ . '/Site/Controlleurs/Commande/reinitialisationMenuControleur.php';
        break;

    case 'calculerPrix':
        require_once __DIR__ . "/Site/Controlleurs/Commande/calculerPrixControleur.php";
        break;
    
    default:
        echo "Page introuvable";
}
?>