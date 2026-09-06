<?php
/**@var array $commandesComplettes */
/**@var array $statutsCommande */
/**@var array $materiels */
?>
<section class="zone-onglet-commandes">
    <h3 class="titre-zone-commandes">Vos Commandes</h3>
    <div class="zone-commandes">
        <?php foreach ($commandesComplettes as $commande): ?>
            <article class="commande-recuperer">
                <p class="informations-commande">Client : <?= htmlspecialchars($commande['nom']) ?> <?= htmlspecialchars($commande['prenom']) ?></p>
                <p class="informations-commande">Menu : <?= htmlspecialchars($commande['menuTitre']) ?></p>
                <p class="informations-commande">Adresse de Livraison : <?= htmlspecialchars($commande['adresse']) ?></p>
                <p class="informations-commande">Code Postal : <?= htmlspecialchars($commande['codePostal']) ?></p>
                <p class="informations-commande">Date de Prestation : <?= htmlspecialchars($commande['datePrestation']->format('d/m/Y')) ?></p>
                <p class="informations-commande">Heure de Prestation: <?= htmlspecialchars($commande['heureLivraison']) ?></p>
                <p class="informations-commande">Date de Livraison : <?= htmlspecialchars($commande['dateLivraison']->format('d/m/Y')) ?></p>
                <p class="informations-commande">Convive : <?= htmlspecialchars($commande['convive']) ?></p>
                <?php foreach ($commande['plats'] as $plat): ?>
                    <p class="informations-commande">Plat : <?= htmlspecialchars($plat->getTitre()) ?></p>
                <?php endforeach; ?>
                <p class="informations-commande">Statut actuel : <?= htmlspecialchars($commande['statut']) ?></p>
                <?php if (!in_array($commande['statut'], ['Terminée', 'Annulée'])): ?>
                    <button type="button" class="bouton-gerer" data-id="<?= $commande['id'] ?>" data-statut-id="<?= $commande['statutId'] ?>">Gérer la Commande</button>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<div class="modale" id="modale-gerer-commande" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
        <form class="formulaire-gestion" id="formulaireGestion" method="post">
            <input type="hidden" name="commandeId" id="modif-commande-id">
            <div class="zone-selection-statut">
                <label for="statutSelection" class="label-gestion">Statut de la commande</label>
                <select class="selecteur-gestion" id="statutSelection" name="statutCommande" required>
                    <?php foreach ($statutsCommande as $statut): ?>
                        <option value="<?= $statut->getStatutsCommandeId() ?>"><?= htmlspecialchars($statut->getLibelle()) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="zone-annulation" style="display: none;">
                <div class="zone-motif">
                    <label for="motifInput" class="label-gestion">Motif de l'annulation</label>
                    <textarea class="input-gestion" id="motifInput" name="motif" rows="3"></textarea>
                </div>
                <div class="zone-mode-contact">
                    <label for="modeContactInput" class="label-gestion">Mode de contact utilisé</label>
                    <input type="text" class="input-gestion" id="modeContactInput" name="modeContact">
                </div>
            </div>
            <div class="zone-selection-materiel" style="display: none;">
                <?php foreach ($materiels as $materiel): ?>
                    <div class="zone-checkbox-materiel">
                        <label for="materiel_<?= $materiel->getMaterielsId() ?>" class="label-gestion"><?= htmlspecialchars($materiel->getLibelle()) ?></label>
                        <input type="checkbox" class="checkbox-gestion" id="materiel_<?= $materiel->getMaterielsId() ?>" name="materiels[]" value="<?= $materiel->getMaterielsId() ?>">
                    </div>
                    <div class="zone-quantite-materiel">
                        <label for="quantite_<?= $materiel->getMaterielsId() ?>" class="label-gestion">Quantité : </label>
                        <input type="number" class="input-gestion" id="quantite_<?= $materiel->getMaterielsId() ?>" name="quantite_<?= $materiel->getMaterielsId() ?>" min="1" value="1">
                    </div>  
                <?php endforeach ?>
            </div>
            <button type="submit" class="modifier-statut" name="action" value="gererCommande">Modifier l'état de la commande</button>
        </form>
    </div>
</div>