<?php
/**@var string $onglet */
/**@var string $contenuOnglet */
?>
<section class="espace-perso">
    <?php require __DIR__ . '/ComposantsEspacePerso/menuOnglet.php'; ?>
    <div class="contenu-onglet">
        <?= $contenuOnglet ?>
    </div>
</section>