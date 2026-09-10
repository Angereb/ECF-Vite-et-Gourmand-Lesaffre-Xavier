<?php
/**@var array $statistiquesNominative */
/**@var array $ficheMenus */
/**@var array $chiffreAffaire */
?>
<script>
    const donneesCommandesParMenu = <?= json_encode($statistiquesNominative) ?>;
</script>
<section class="zone-onglet-statistique">
    <h3 class="titre-zone-statistique">Statistiques de ventes</h3>
    <div class="zones-graphique">
        <div class="zone-graphique-commandes">
            <h3 class="titre-graphiques">Graphique de commandes par Menus</h3>
            <canvas class="graphique" id="graphiqueCommandes" width="600" height="400"></canvas>
        </div>
        <div class="zone-gestion-graphique-chiffre-affaire">
            <div class="zone-filtre">
                <input type="date" class="bouton-filtre" id="filtre-dateDebut" name="dateDebut">
                <input type="date" class="bouton-filtre" id="filtre-dateFin" name="dateFin">
                <select class="bouton-filtre" id="filtre-menu" name="menuId">
                    <option value="">-</option>
                    <?php foreach ($ficheMenus as $menu): ?>
                        <option value="<?= $menu["menuId"] ?>"><?= htmlspecialchars($menu["menuTitre"]) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="zone-graphique-chiffre-affaire">
                <h3 class="titre-graphiques">Graphique de chiffres d'affaires</h3>
                <canvas class="graphique" id="graphiqueChiffreAffaires" width="600" height="400"></canvas>
            </div>
        </div>
    </div>
</section>