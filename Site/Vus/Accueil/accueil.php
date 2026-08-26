<?php
/**@var array $avisComplets */
?>
<section class="zone-entreprise">
    <p class="description-entreprise">«Vite & Gourmand» existe depuis plus de 25 ans au coeur de Bordeaux et propose des prestations qui vont du simple repas aux repas de fêtes.</p>
    <img class="photo-entreprise" src="/Site/Publique/Images/Photo-Bordeaux.svg" alt="Photo de Bordeaux">
</section>
<section class="zone-equipe">
    <img class="photo-equipe-mobile" src="/Site/Publique/Images/Photo-Louis-Hansel-Unsplash.svg" alt="Photo de cuisinier">
    <img class="photo-equipe-desktop" src="/Site/Publique/Images/Photo-Louis-Hansel-Unsplash-2.svg" alt="Photo de cuisinier">
    <div class="contenu-equipe">
        <p class="description-equipe">Notre équipe, dirigé par Julie et José, travaille sur des menus en constante évolution</p>
        <a href="?page=nosMenus" class="bouton-nos-menus">Nos Menus</a>
    </div>
</section>
<section class="zone-avis">
    <?php foreach ($avisComplets as $avi): ?>
        <article class="avis-recuperer-miniature-mobile" data-avis-id="<?= $avi["id"] ?>" aria-hidden="false">
            <p class="nom-avis">Avis de : <?= htmlspecialchars($avi["nomClient"])?></p>
            <p class="titre-avis"><?= htmlspecialchars($avi["titre"]) ?></p>
            <p class="note-avis" aria-label="Note : <?= htmlspecialchars((string)$avi['note']) ?> sur 5">
                <span aria-hidden="true"><?= htmlspecialchars(Avis::genererEtoiles($avi["note"])) ?></span>
            </p>
        </article>
        <article class="avis-recuperer-complette" data-avis-id="<?= $avi["id"] ?>" aria-hidden="true">
            <p class="nom-avis">Avis de : <?= htmlspecialchars($avi["nomClient"])?></p>
            <p class="titre-avis"><?= htmlspecialchars($avi["titre"]) ?></p>
            <p class="contenu-avis"><?= htmlspecialchars($avi["commentaire"]) ?></p>
            <div class="information-avis">
                <p class="menu-avis"><?= htmlspecialchars($avi["menu"])?></p>
                <p class="note-avis" aria-label="Note : <?= htmlspecialchars((string)$avi['note']) ?> sur 5">
                    <span aria-hidden="true"><?= htmlspecialchars(Avis::genererEtoiles($avi["note"])) ?></span>
                </p>
            </div>
        </article>
    <?php endforeach; ?>
</section>