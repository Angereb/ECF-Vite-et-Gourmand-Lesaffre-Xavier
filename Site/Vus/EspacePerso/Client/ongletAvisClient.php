<?php
/**@var array $commandesSansAvis */
/**@var array $commandesAvecAvis */
?>
<section class="zone-onglet-avis">
    <h3 class="titre-zone-commandes">Vos Commandes</h3>
    <div class="tableau-avis">
        <section class="zone-commandes-sans-avis">
            <h4>Commandes sans Avis</h4>
            <?php foreach ($commandesSansAvis as $commandeSansAvis): ?>
                <article class="commandes-sans-avis">
                    <p class="informations-commande">Menu : <?= htmlspecialchars($commandeSansAvis['menuTitre']) ?></p>
                    <p class="informations-commande">Date de Prestation : <?= htmlspecialchars($commandeSansAvis['datePrestation']->format('d/m/Y')) ?></p>
                    <button type="button" class="donner-avis" data-id="<?= $commandeSansAvis['id'] ?>">Donner un Avis</button>
                </article>
            <?php endforeach ?>
        </section>
        <section class="zone-commandes-avec-avis">
            <h4>Commandes avec Avis</h4>
            <?php foreach ($commandesAvecAvis as $commandeAvecAvis): ?>
                <article class="commandes-avec-avis">
                    <p class="informations-commande">Menu : <?= htmlspecialchars($commandeAvecAvis['menuTitre']) ?></p>
                    <p class="informations-commande">Date de prestation : <?= htmlspecialchars($commandeAvecAvis['datePrestation']->format('d/m/Y')) ?></p>
                    <p class="informations-commande">Titre de l'avis : <?= htmlspecialchars($commandeAvecAvis['avisTitre']) ?></p>
                    <p class="informations-commande">Note : <?= htmlspecialchars($commandeAvecAvis['avisNote']) ?></p>
                    <p class="informations-commande">État de l'avis : <?= htmlspecialchars($commandeAvecAvis['avisStatut']) ?></p>
                </article>
            <?php endforeach ?>
        </section>
    </div>
</section>

<div class="modale" id="modale-donner-avis" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">×</button>
        <form class="formulaire-avis" id="formulaireAvis" method="post">
            <input type="hidden" name="commandeId" id="avis-commande-id">
            <div class="zone-titre-avis">
                <label for="titreAvisInput" class="label-avis">Titre : </label>
                <input type="text" class="input-avis" id="titreAvisInput" name="titre" required>
            </div>
            <div class="zone-commentaire-avis">
                <label for="commentaireAvisInput" class="label-avis">Commentaire : </label>
                <textarea class="input-avis" id="commentaireAvisInput" name="commentaire" rows="3" required></textarea>
            </div>
            <div class="zone-note-avis">
                <label for="noteAvisInput" class="label-avis">Note : </label>
                <select class="input-avis" id="noteAvisInput" name="note" required>
                    <option value="">Choisir une note</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
             <button type="submit" class="envoyer-avis" form="formulaireAvis" name="action" value="envoyerAvis">Envoyer</button>
        </form>
    </div>
</div>