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
    
    default:
        echo "Page introuvable";
}
?>