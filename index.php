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

    default:
        echo "Page introuvable";
}
?>