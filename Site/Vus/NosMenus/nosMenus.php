<?php
/**@var array $menusComplets */
/**@var array $themes */
/**@var array $regimes */
?>
<section class="zone-filtre">
    <input type="number" class="bouton-filtre" id="filtre-prixMax" name="prixMax" placeholder="Prix Max" min="0">
    <input type="number" class="bouton-filtre" id="filtre-prixMin" name="prixMin" placeholder="Prix Min" min="0">
    <select class="bouton-filtre" id="filtre-theme" name="themesId">
        <option value="">Thème</option>
        <?php foreach ($themes as $theme): ?>
            <option value="<?= $theme->getThemesId() ?>"><?= htmlspecialchars($theme->getLibelle()) ?></option>
        <?php endforeach; ?>
    </select>
    <select class="bouton-filtre" id="filtre-regime" name="regimesId">
        <option value="">Régime</option>
        <?php foreach ($regimes as $regime): ?>
            <option value="<?= $regime->getRegimesId() ?>"><?= htmlspecialchars($regime->getLibelle()) ?></option>
        <?php endforeach; ?>
    </select>
    <input type="number" class="bouton-filtre" id="filtre-convivesMin" name="convivesMin" placeholder="Convives" min="1">
</section>
<section class="conteneur-menus">
    <section class="zone-menus" id="zone-menus"></section>
    <section class="zone-menu-detaillee" id="zone-menu-detaillee" aria-hidden="true"></section>
</section>

<div class="modale" id="modale-plat" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
        <h2 id="modale-plat-titre"></h2>
        <section class="contenu-plat">
            <div class="informations-plat">
                <p id="modale-plat-categorie"></p>
                <p id="modale-plat-regime"></p>
                <p id="modale-plat-allergenes"></p>
            </div>
            <img id="modale-plat-photo" class="photo-plat-modale" alt="">
        </section>
    </div>
</div>