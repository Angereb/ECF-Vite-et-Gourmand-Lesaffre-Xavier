<?php
/**@var array $themes */
/**@var array $allergenes */
/**@var array $regimes */
/**@var array $themesJson */
/**@var array $allergenesJson */
/**@var array $fichePlats */
/**@var array $platsUtilisables */
/**@var array $ficheMenus */
?>
<script>
    const donneesThemes = <?= json_encode($themesJson) ?>;
    const donneesAllergenes = <?= json_encode($allergenesJson) ?>;
    const donneesPlats = <?= json_encode($fichePlats) ?>;
    const donneesMenus = <?= json_encode($ficheMenus) ?>;
</script>

<section class="zone-onglet-menus">
    <h3 class="titre-zone-menus">Gestion des Menus, Plats, Thèmes et Allergènes</h3>
    <div class="zone-boutons-creation">
        <button type="button" class="bouton-creation" id="creationTheme" data-modale="modale-creer-theme">Créer un thème</button>
        <button type="button" class="bouton-creation" id="creationAllergene" data-modale="modale-creer-allergene">Créer un allergène</button>
        <button type="button" class="bouton-creation" id="creationPlat" data-modale="modale-creer-plat">Créer un plat</button>
        <button type="button" class="bouton-creation" id="creationMenu" data-modale="modale-creer-menu">Créer un menu</button>
    </div>
    <div class="zone-de-select">
        <div class="zone-theme">
            <div class="zone-select">
                <label for="selectionTheme" class="selection">Thème à modifier : </label>
                <select class="selecteur-gestion" id="selectionTheme" name="selectTheme">
                    <option value="">-</option>
                    <?php foreach ($themes as $theme): ?>
                        <option value="<?= $theme->getThemesId() ?>"><?= htmlspecialchars($theme->getLibelle()) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <article class="theme-recuperer" id="themeRecuperer" aria-hidden="true">
                <p class="affichage-informations-principal" id="article-theme-libelle"></p>
                <button type="button" class="bouton-modification" id="modifierTheme" data-id="" data-modale="modale-modifier-theme">Modifier le thème</button>
            </article>
        </div>
        <div class="zone-allergene">
            <div class="zone-select">
                <label for="selectionAllergene" class="selection">Allergène à modifier : </label>
                <select class="selecteur-gestion" id="selectionAllergene" name="selectAllergene">
                    <option value="">-</option>
                    <?php foreach ($allergenes as $allergene): ?>
                        <option value="<?= $allergene->getAllergenesId() ?>"><?= htmlspecialchars($allergene->getLibelle()) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <article class="allergene-recuperer" id="allergeneRecuperer" aria-hidden="true">
                <p class="affichage-informations-principal" id="article-allergene-libelle"></p>
                <button type="button" class="bouton-modification" id="modifierAllergene" data-id="" data-modale="modale-modifier-allergene">Modifier l'allergène</button>
            </article>
        </div>
        <div class="zone-plat">
            <div class="zone-select">
                <label for="selectionPlat" class="selection">Plat à modifier : </label>
                <select class="selecteur-gestion" id="selectionPlat" name="selectPlat">
                    <option value="">-</option>
                    <?php foreach ($fichePlats as $plat): ?>
                        <option value="<?= $plat['platId'] ?>"><?= htmlspecialchars($plat['platTitre']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <article class="plat-recuperer" id="platRecuperer" aria-hidden="true">
                <p class="affichage-informations-principal" id="article-plat-titre"></p>
                <p class="affichage-informations" id="article-plat-categorie"></p>
                <p class="affichage-informations" id="article-plat-allergenes"></p>
                <p class="affichage-informations" id="article-plat-regime"></p>
                <div class="zone-statut">
                    <p class="affichage-informations" id="article-plat-statut"></p>
                    <form class="formulaire-statut" method="post">
                        <input type="hidden" name="platId" id="statutPlatId">
                        <button type="submit" class="bouton-modification" name="action" value="toggleStatutPlat">Changer le statut</button>
                    </form>
                </div>
                <img class="affichage-photo" id="article-plat-photo">
                <button type="button" class="bouton-modification" id="modifierPlat" data-id="" data-modale="modale-modifier-plat">Modifier le plat</button>
            </article>
        </div>
        <div class="zone-menu">
            <div class="zone-select">
                <label for="selectionMenu" class="selection">Menu à modifier : </label>
                <select class="selecteur-gestion" id="selectionMenu" name="selectMenu">
                    <option value="">-</option>
                    <?php foreach ($ficheMenus as $menu): ?>
                        <option value="<?= $menu['id'] ?>"><?= htmlspecialchars($menu['titre']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <article class="menu-recuperer" id="menuRecuperer" aria-hidden="true">
                <p class="affichage-informations-principal" id="article-menu-titre"></p>
                <p class="affichage-informations" id="article-menu-description"></p>
                <p class="affichage-informations" id="article-menu-condition"></p>
                <p class="affichage-informations" id="article-menu-theme"></p>
                <p class="affichage-informations" id="article-menu-regime"></p>
                <p class="affichage-informations" id="article-menu-minimum-convive"></p>
                <p class="affichage-informations" id="article-menu-stock"></p>
                <p class="affichage-informations" id="article-menu-prix"></p>
                <div class="zone-statut">
                    <p class="affichage-informations" id="article-menu-statut"></p>
                    <form class="formulaire-statut" method="post">
                        <input type="hidden" name="menuId" id="statutMenuId">
                        <button type="submit" class="bouton-modification" name="action" value="toggleStatutMenu">Changer le statut</button>
                    </form>
                </div>
                <div id="article-menu-plats"></div>
                <div class="article-menu-galerie" id="article-menu-galerie"></div>
                <button type="button" class="bouton-modification" id="modifierStock" data-id="" data-modale="modale-modifier-menu-stock">Modifier le stock</button>
                <button type="button" class="bouton-modification" id="modifierGalerie" data-id="" data-modale="modale-modifier-menu-galerie">Modifier la galerie</button>
                <button type="button" class="bouton-modification" id="modifierMenu" data-id="" data-modale="modale-modifier-menu">Modifier le Menu</button>
            </article>
        </div>
    </div>
</section>

<div class="modale" id="modale-creer-theme" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
        <form class="formulaire-gestion" id="formulaireCreationTheme" method="post">
            <div class="duo-label-input">
                <label for="libelleThemeInput" class="label-gestion">Libellé du thème : </label>
                <input type="text" class="input-gestion" id="libelleThemeInput" name="libelleTheme" required>
            </div>
            <button type="submit" class="valider-formulaire-creer-theme" name="action" value="creerTheme">Créer le nouveau thème</button>
        </form>
    </div>
</div>

<div class="modale" id="modale-creer-allergene" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
        <form class="formulaire-gestion" id="formulaireCreationAllergene" method="post">
            <div class="duo-label-input">
                <label for="libelleAllergeneInput" class="label-gestion">Libellé de l'allergene : </label>
                <input type="text" class="input-gestion" id="libelleAllergeneInput" name="libelleAllergene" required>
            </div>
            <button type="submit" class="valider-formulaire-creer-allergene" name="action" value="creerAllergene">Créer le nouvelle allergène</button>
        </form>
    </div>
</div>

<div class="modale" id="modale-creer-plat" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
        <form class="formulaire-gestion" id="formulaireCreationPlat" method="post" enctype="multipart/form-data">
            <div class="duo-label-input">
                <label for="titrePlatInput" class="label-gestion">Titre du plat : </label>
                <input type="text" class="input-gestion" id="titrePlatInput" name="titrePlat" required>
            </div>
            <div class="duo-label-select">
                <label for="categoriePlatSelect" class="label-gestion">Catégorie du plat : </label>
                <select class="selecteur-gestion" id="categoriePlatSelect" name="categoriePlat">
                    <option value="">-</option>
                    <option value="Entrée">Entrée</option>
                    <option value="Plat">Plat</option>
                    <option value="Dessert">Dessert</option>
                </select>
            </div>
            <div class="duo-label-select">
                <label for="regimePlatSelect" class="label-gestion">Régime du plat : </label>
                <select class="selecteur-gestion" id="regimePlatSelect" name="regimePlat">
                    <option value="">-</option>
                    <?php foreach ($regimes as $regime): ?>
                        <option value="<?= $regime->getRegimesId() ?>"><?= htmlspecialchars($regime->getLibelle()) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="duo-label-checkbox">
                <?php foreach ($allergenes as $allergene): ?>
                    <div class="zone-checkbox-plat-allergene">
                        <input type="checkbox" class="checkbox" id="creation_allergene_<?= $allergene->getAllergenesId() ?>" name="allergenes[]" value="<?= $allergene->getAllergenesId() ?>">
                        <label for="creation_allergene_<?= $allergene->getAllergenesId() ?>"><?= htmlspecialchars($allergene->getlibelle()) ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="import-image">
                <input type="file" class="image-input" accept="image/png" name="photoPlat">
            </div>
            <button type="submit" class="valider-formulaire-creer-plat" name="action" value="creerPlat">Créer le nouveau plat</button>
        </form>
    </div>
</div>

<div class="modale" id="modale-creer-menu" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
        <form class="formulaire-gestion" id="formulaireCreationMenu" method="post">
            <div class="duo-label-input">
                <label for="titreMenuInput" class="label-gestion">Titre du menu : </label>
                <input type="text" class="input-gestion" id="titreMenuInput" name="titreMenu" required>
            </div>
            <div class="duo-label-area">
                <label for="descriptionMenuInput" class="label-gestion">Description du menu : </label>
                <textarea class="input-gestion" id="descriptionMenuInput" name="descriptionMenu" rows="3" required></textarea>
            </div>
            <div class="duo-label-area">
                <label for="conditionMenuInput" class="label-gestion">Conditions du menu : </label>
                <textarea class="input-gestion" id="conditionMenuInput" name="conditionMenu" rows="3"></textarea>
            </div>
            <div class="duo-label-input">
                <label for="minimumConviveMenuInput" class="label-gestion">Convive minimum du menu : </label>
                <input type="number" class="input-gestion" id="minimumConviveMenuInput" name="minimumConviveMenu" required>
            </div>
            <div class="duo-label-input">
                <label for="stockInitialMenuInput" class="label-gestion">Stock initial du menu : </label>
                <input type="number" class="input-gestion" id="stockInitialMenuInput" name="stockInitialMenu" required>
            </div>
            <div class="duo-label-input">
                <label for="prixMenuInput" class="label-gestion">Prix du menu : </label>
                <input type="number" step="0.01" min="0.01" class="input-gestion" id="prixMenuInput" name="prixMenu" required>
            </div>
            <div class="duo-label-select">
                <label for="themeMenuSelect" class="label-gestion">Thème du menu : </label>
                <select class="selecteur-gestion" id="themeMenuSelect" name="themeMenu">
                    <option value="">-</option>
                    <?php foreach ($themes as $theme): ?>
                        <option value="<?= $theme->getThemesId() ?>"><?= htmlspecialchars($theme->getLibelle()) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="duo-label-select">
                <label for="regimeMenuSelect" class="label-gestion">Régime du menu : </label>
                <select class="selecteur-gestion" id="regimeMenuSelect" name="regimeMenu">
                    <option value="">-</option>
                    <?php foreach ($regimes as $regime): ?>
                        <option value="<?= $regime->getRegimesId() ?>"><?= htmlspecialchars($regime->getLibelle()) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <?php
            $platsParCategoriePhp = ["Entrée" => [], "Plat" => [], "Dessert" => []];
            foreach ($platsUtilisables as $plat) {
                $platsParCategoriePhp[$plat->getCategorie()][] = $plat;
            }
            ?>
            <?php foreach ($platsParCategoriePhp as $categorie => $platsCategorie): ?>
                <div class="zone-categorie-plats">
                    <h4><?= htmlspecialchars($categorie) ?></h4>
                    <div class="duo-label-checkbox">
                        <?php foreach ($platsCategorie as $plat): ?>
                            <div class="zone-checkbox-plat-menu">
                                <input type="checkbox" class="checkbox" id="creation_plat_<?= $plat->getPlatsId() ?>" name="plats[]" value="<?= $plat->getPlatsId() ?>">
                                <label for="creation_plat_<?= $plat->getPlatsId() ?>"><?= htmlspecialchars($plat->getTitre()) ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="valider-formulaire-creer-menu" name="action" value="creerMenu">Créer le nouveau menu</button>
        </form>
    </div>
</div>

<div class="modale" id="modale-modifier-theme" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
        <form class="formulaire-gestion" id="formulaireModifierTheme" method="post">
            <input type="hidden" name="themeId" id="modif-theme-id">
            <div class="duo-label-input">
                <label for="modifierlibelleThemeInput" class="label-gestion">Modifier le libellé du thème : </label>
                <input type="text" class="input-gestion" id="modifierlibelleThemeInput" name="modifierlibelleTheme" required>
            </div>
            <button type="submit" class="valider-formulaire-modifier-theme" name="action" value="modifierTheme">Modifier le thème</button>
        </form>
    </div>
</div>

<div class="modale" id="modale-modifier-allergene" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
        <form class="formulaire-gestion" id="formulaireModifierAllergene" method="post">
            <input type="hidden" name="allergeneId" id="modif-allergene-id">
            <div class="duo-label-input">
                <label for="modifierlibelleAllergeneInput" class="label-gestion">Modifier le libellé de l'allergène : </label>
                <input type="text" class="input-gestion" id="modifierlibelleAllergeneInput" name="modifierlibelleAllergene" required>
            </div>
            <button type="submit" class="valider-formulaire-modifier-allergene" name="action" value="modifierAllergene">Modifier l'allergène</button>
        </form>
    </div>
</div>

<div class="modale" id="modale-modifier-plat" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
        <form class="formulaire-gestion" id="formulaireModifierPlat" method="post" enctype="multipart/form-data">
            <input type="hidden" name="platId" id="modif-plat-id">
            <div class="duo-label-input">
                <label for="modifierTitrePlatInput" class="label-gestion">Modifier le titre du plat : </label>
                <input type="text" class="input-gestion" id="modifierTitrePlatInput" name="modifierTitrePlat" required>
            </div>
            <div class="duo-label-select">
                <label for="modifierCategoriePlatSelect" class="label-gestion">Modifier la catégorie du plat : </label>
                <select class="selecteur-gestion" id="modifierCategoriePlatSelect" name="modifierCategoriePlat">
                    <option value="">-</option>
                    <option value="Entrée">Entrée</option>
                    <option value="Plat">Plat</option>
                    <option value="Dessert">Dessert</option>
                </select>
            </div>
            <div class="duo-label-select">
                <label for="modifierRegimePlatSelect" class="label-gestion">Modifier le régime du plat : </label>
                <select class="selecteur-gestion" id="modifierRegimePlatSelect" name="modifierRegimePlat">
                    <option value="">-</option>
                    <?php foreach ($regimes as $regime): ?>
                        <option value="<?= $regime->getRegimesId() ?>"><?= htmlspecialchars($regime->getLibelle()) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="duo-label-checkbox">
                <?php foreach ($allergenes as $allergene): ?>
                    <div class="zone-checkbox-plat-allergene">
                        <input type="checkbox" class="checkbox" id="modification_allergene_<?= $allergene->getAllergenesId() ?>" name="allergenes[]" value="<?= $allergene->getAllergenesId() ?>">
                        <label for="modification_allergene_<?= $allergene->getAllergenesId() ?>"><?= htmlspecialchars($allergene->getlibelle()) ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="import-image">
                <input type="file" class="image-input" id="modifierImagePlatInput" accept="image/png" name="photoPlat">
            </div>
            <button type="submit" class="valider-formulaire-modifier-plat" name="action" value="modifierPlat">Modifier le plat</button>
        </form>
    </div>
</div>

<div class="modale" id="modale-modifier-menu-stock" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
        <form class="formulaire-gestion" id="formulaireModifierStockMenu" method="post">
            <input type="hidden" name="menuId" id="modif-menu-id-stock">
            <div class="duo-label-input">
                <label for="modifierStockMenuInput" class="label-gestion">Modifier le stock du menu : </label>
                <input type="number" class="input-gestion" id="modifierStockMenuInput" name="modifierStockMenu" required>
            </div>
            <button type="submit" class="valider-formulaire-modifier-stock-menu" name="action" value="modifierStockMenu">Modifier le stock du menu</button>
        </form>
    </div>
</div>

<div class="modale" id="modale-modifier-menu-galerie" aria-hidden="true">
    <div class="modale-contenu">
        <div class="zone-interne-modale">
            <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
            <h4>Ajouter une image</h4>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="menuId" id="modif-menu-id-galerie">
                <div class="duo-label-input">
                    <label for="creerTitreImageInput" class="label-gestion">Titre du la photo : </label>
                    <input type="text" class="input-gestion" id="creerTitreImageInput" name="creerTitreImage" required>
                </div>
                <div class="import-image">
                    <input type="file" accept="image/png" name="nouvelleImage">
                </div>
                <button type="submit" class="valider-formulaire-modifier-galerie-menu" name="action" value="ajouterImageMenu">Ajouter</button>
            </form>
            <h4>Images actuelles</h4>
            <div id="liste-images-galerie"></div>
        </div>
    </div>
</div>

<div class="modale" id="modale-modifier-menu" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
        <form class="formulaire-gestion" id="formulaireModifierMenu" method="post">
            <input type="hidden" name="menuId" id="modif-menu-id">
            <div class="duo-label-input">
                <label for="modifierTitreMenuInput" class="label-gestion">Modifier le titre du menu : </label>
                <input type="text" class="input-gestion" id="modifierTitreMenuInput" name="modifierTitreMenu" required>
            </div>
            <div class="duo-label-area-grand">
                <label for="modifierDescriptionMenuInput" class="label-gestion">Modifier la description du menu : </label>
                <textarea class="input-gestion" id="modifierDescriptionMenuInput" name="modifierDescriptionMenu" rows="3" required></textarea>
            </div>
            <div class="duo-label-area-grand">
                <label for="modifierConditionMenuInput" class="label-gestion">Modifier les conditions du menu : </label>
                <textarea class="input-gestion" id="modifierConditionMenuInput" name="modifierConditionMenu" rows="3"></textarea>
            </div>
            <div class="duo-label-input">
                <label for="modifierMinimumConviveMenuInput" class="label-gestion">Modifier le nombre de convive minimum du menu : </label>
                <input type="number" class="input-gestion" id="modifierMinimumConviveMenuInput" name="modifierMinimumConviveMenu" required>
            </div>
            <div class="duo-label-input">
                <label for="modifierPrixMenuInput" class="label-gestion">Modifier le prix du menu : </label>
                <input type="number" step="0.01" min="0.01" class="input-gestion" id="modifierPrixMenuInput" name="modifierPrixMenu" required>
            </div>
            <div class="duo-label-select">
                <label for="modifierThemeMenuSelect" class="label-gestion">Modifier le thème du menu : </label>
                <select class="selecteur-gestion" id="modifierThemeMenuSelect" name="modifierThemeMenu">
                    <option value="">-</option>
                    <?php foreach ($themes as $theme): ?>
                        <option value="<?= $theme->getThemesId() ?>"><?= htmlspecialchars($theme->getLibelle()) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="duo-label-select">
                <label for="modifierRegimeMenuSelect" class="label-gestion">Modifier le Régime du menu : </label>
                <select class="selecteur-gestion" id="modifierRegimeMenuSelect" name="modifierRegimeMenu">
                    <option value="">-</option>
                    <?php foreach ($regimes as $regime): ?>
                        <option value="<?= $regime->getRegimesId() ?>"><?= htmlspecialchars($regime->getLibelle()) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <?php
            $platsParCategoriePhp = ["Entrée" => [], "Plat" => [], "Dessert" => []];
            foreach ($platsUtilisables as $plat) {
                $platsParCategoriePhp[$plat->getCategorie()][] = $plat;
            }
            ?>
            <?php foreach ($platsParCategoriePhp as $categorie => $platsCategorie): ?>
                <div class="zone-categorie-plats">
                    <h4><?= htmlspecialchars($categorie) ?></h4>
                    <div class="duo-label-checkbox">
                        <?php foreach ($platsCategorie as $plat): ?>
                            <div class="zone-checkbox-plat-menu">
                                <input type="checkbox" class="checkbox" id="modification_plat_<?= $plat->getPlatsId() ?>" name="modifierPlats[]" value="<?= $plat->getPlatsId() ?>">
                                <label for="modification_plat_<?= $plat->getPlatsId() ?>"><?= htmlspecialchars($plat->getTitre()) ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="valider-formulaire-modifier-menu" name="action" value="modifierMenu">Modifier le menu</button>
        </form>
    </div>
</div>