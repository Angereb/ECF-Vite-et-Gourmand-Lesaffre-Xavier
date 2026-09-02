<?php
/**@var string $onglet */
?>

<nav class="menu-onglets">
    <ul class="liste-onglets">
        <?php if (isset($_SESSION["client"])): ?>
            <li class="onglet"><a class="onglet-lien" href="?page=espacePerso&onglet=infosClient" <?= ($onglet === 'infosClient') ? 'aria-current="page"' : '' ?>>Mes informations</a></li>
            <li class="onglet"><a class="onglet-lien" href="?page=espacePerso&onglet=commandesClient" <?= ($onglet === 'commandesClient') ? 'aria-current="page"' : '' ?>>Mes commandes</a></li>
            <li class="onglet"><a class="onglet-lien" href="?page=espacePerso&onglet=avisClient" <?= ($onglet === 'avisClient') ? 'aria-current="page"' : '' ?>>Mes avis</a></li>
        <?php elseif (isset($_SESSION["employe"])): ?>
            <li class="onglet"><a class="onglet-lien" href="?page=espacePerso&onglet=infosEmploye" <?= ($onglet === 'infosEmploye') ? 'aria-current="page"' : '' ?>>Mes informations</a></li>
            <li class="onglet"><a class="onglet-lien" href="?page=espacePerso&onglet=menusEmploye" <?= ($onglet === 'menusEmploye') ? 'aria-current="page"' : '' ?>>Menus</a></li>
            <li class="onglet"><a class="onglet-lien" href="?page=espacePerso&onglet=horairesEmploye" <?= ($onglet === 'horairesEmploye') ? 'aria-current="page"' : '' ?>>Horaires</a></li>
            <li class="onglet"><a class="onglet-lien" href="?page=espacePerso&onglet=avisEmploye" <?= ($onglet === 'avisEmploye') ? 'aria-current="page"' : '' ?>>Avis</a></li>
            <li class="onglet"><a class="onglet-lien" href="?page=espacePerso&onglet=commandesEmploye" <?= ($onglet === 'commandesEmploye') ? 'aria-current="page"' : '' ?>>Commandes</a></li>
            <?php if ($_SESSION["employe"]["administrateur"]): ?>
                <li class="onglet"><a class="onglet-lien" href="?page=espacePerso&onglet=employes" <?= ($onglet === 'employes') ? 'aria-current="page"' : '' ?>>Employés</a></li>
                <li class="onglet"><a class="onglet-lien" href="?page=espacePerso&onglet=graphiques" <?= ($onglet === 'graphiques') ? 'aria-current="page"' : '' ?>>Graphiques</a></li>
            <?php endif; ?>
        <?php endif; ?>
    </ul>
</nav>