<?php
/**@var array $commandesComplettes */
?>
<section class="zone-onglet-commandes">
    <h3 class="titre-zone-commandes">Vos Commandes</h3>
    <?php foreach ($commandesComplettes as $commande): ?>
        <article class="commande-recuperer">
            <p class="informations-commande">Menu : <?= htmlspecialchars($commande['menuTitre']) ?></p>
            <p class="informations-commande">Adresse de Livraison : <?= htmlspecialchars($commande['adresse']) ?></p>
            <p class="informations-commande">Code Postal : <?= htmlspecialchars($commande['codePostal']) ?></p>
            <p class="informations-commande">Date de Prestation : <?= htmlspecialchars($commande['datePrestation']->format('d/m/Y')) ?></p>
            <p class="informations-commande">Heure de Prestation: <?= htmlspecialchars($commande['heureLivraison']) ?></p>
            <p class="informations-commande">Date de Livraison : <?= htmlspecialchars($commande['dateLivraison']->format('d/m/Y')) ?></p>
            <p class="informations-commande">Convive : <?= htmlspecialchars($commande['convive']) ?></p>
            <p class="informations-commande">Prix : <?= htmlspecialchars($commande['facture']) ?> €</p>
            <?php foreach ($commande['plats'] as $plat): ?>
                <p class="informations-commande">Plat : <?= htmlspecialchars($plat->getTitre()) ?></p>
            <?php endforeach; ?>
            <p class="informations-commande">Statut actuel : <?= htmlspecialchars($commande['statut']) ?></p>
             <?php if ($commande['statut'] === 'En attente'): ?>
                <button type="button" class="bouton-modifier"
                    data-id="<?= $commande['id'] ?>"
                    data-adresse="<?= htmlspecialchars($commande['adresse']) ?>"
                    data-code-postal="<?= htmlspecialchars($commande['codePostal']) ?>"
                    data-date-prestation="<?= $commande['datePrestation']->format('Y-m-d') ?>"
                    data-date-livraison="<?= $commande['dateLivraison']->format('Y-m-d') ?>"
                    data-heure-livraison="<?= htmlspecialchars($commande['heureLivraison']) ?>"
                    data-convive="<?= $commande['convive'] ?>">
                    Modifier
                </button>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
</section>

<div class="modale" id="modale-modifier-commande" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
        <form class="formulaire-prestation" id="formulairePrestation" method="post">
            <input type="hidden" name="commandeId" id="modif-commande-id">
            <div class="zone-date-prestation">
                <label for="datePrestationInput" class="label-commande">Date de prestation : </label>
                <input type="date" class="input-commande" id="datePrestationInput" name="datePrestation" required>
            </div>
            <div class="zone-date-livraison">
                <label for="dateLivraisonInput" class="label-commande">Date de livraison : </label>
                <input type="date" class="input-commande" id="dateLivraisonInput" name="dateLivraison" required>
            </div>
            <div class="zone-heure-livraison">
                <label for="heureLivraisonInput" class="label-commande">Heure de Livraison : </label>
                <input type="time" class="input-commande" id="heureLivraisonInput" name="heureLivraison" required>
            </div>
            <div class="zone-adresse-livraison">
                <label for="adresseLivraisonInput" class="label-commande">Adresse de livraison : </label>
                <textarea class="input-commande" id="adresseLivraisonInput" placeholder="Lieu de livraison" name="adresseLivraison" rows="3" required></textarea>
            </div>
            <div class="zone-code-postal">
                <label for="codePostalInput" class="label-commande">Code postal : </label>
                <input type="text" class="input-commande" id="codePostalInput" name="codePostal" required>
            </div>
            <div class="zone-convive">
                <label for="conviveInput" class="label-commande">Convive : </label>
                <input type="number" class="input-commande-convive" id="conviveInput" form="formulairePrestation" name="convive" required>
            </div>
            <button type="submit" class="valider-modification-commande" form="formulairePrestation" name="action" value="modifierCommande">Modifier</button>
        </form>
    </div>
</div>