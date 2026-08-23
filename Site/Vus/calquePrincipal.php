<?php
/**@var string $titre */
/**@var string $contenu */
/**@var array $css */
/**@var array $javascript */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $titre ?? 'Vite et Gourmand' ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/Site/Publique/CSS/style.css">
    <link rel="stylesheet" href="/Site/Publique/CSS/Composants/entete.css">
    <link rel="stylesheet" href="/Site/Publique/CSS/Composants/barreMenu.css">
    <link rel="stylesheet" href="/Site/Publique/CSS/Composants/piedDePage.css">
    <?php foreach($css ?? [] as $fichierCSS): ?>
        <link rel="stylesheet" href="/Site/Publique/CSS/<?= $fichierCSS ?>">
    <?php endforeach; ?>

    <script defer src="/Site/Publique/JS/Composants/barreMenu.js"></script>
    <script defer src="/Site/Publique/JS/Composants/piedDePage.js"></script>
    <?php foreach($javascript ?? [] as $script): ?>
        <script defer src="/Site/Publique/JS/<?= $script ?>"></script>
    <?php endforeach; ?>
</head>

<body>
    <?php require __DIR__ . "/Composants/entete.php";?>
    <?php require __DIR__ . "/Composants/barreMenu.php";?>

    <main>
        <?= $contenu ?? '' ?>
    </main>
    
    <?php require __DIR__ . "/Composants/piedDePage.php"?>
</body>

</html>