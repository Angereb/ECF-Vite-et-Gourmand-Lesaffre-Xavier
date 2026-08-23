<?php
/**@var string $page */
?>

<nav class="barre-menu">
    <button class="bouton-menu" type="button" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="liens-menu"></button>
    <ul class="liens-menu" id="liens-menu">
        <li><a href="?page=accueil" class="lien-menu" <?= ($page === 'accueil') ? 'aria-current="page"' : '' ?>>Accueil</a></li>
        <li><a href="?page=nosMenus" class="lien-menu" <?= ($page === 'nosMenus') ? 'aria-current="page"' : '' ?>>Nos Menus</a></li>
        <li><a href="?page=commande" class="lien-menu" <?= ($page === 'commande') ? 'aria-current="page"' : '' ?>>Commande</a></li>
        <li><a href="?page=inscription" class="lien-menu" <?= ($page === 'inscription') ? 'aria-current="page"' : '' ?>>Inscription</a></li>
        <li><a href="?page=connexion" class="lien-menu" <?= ($page === 'connexion') ? 'aria-current="page"' : '' ?>>Connexion</a></li>
        <li><a href="?page=contact" class="lien-menu" <?= ($page === 'contact') ? 'aria-current="page"' : '' ?>>Contact</a></li>
    </ul>
</nav>