<?php
$titre = "Accueil";

$css = [
    "Accueil/accueil.css",
];

$javascript = [];

ob_start();

require __DIR__ . '/../../Vus/Accueil/accueil.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calquePrincipal.php';

?>