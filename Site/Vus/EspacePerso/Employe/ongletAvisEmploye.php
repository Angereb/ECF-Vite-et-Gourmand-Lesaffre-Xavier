<?php
/**@var array $avisComplets */
?>
<section class="zone-onglet-avis-employe">
    <h3 class="titre-zone-avis">Gestion des Avis en attente</h3>
    <div class="zone-avis">
        <?php foreach ($avisComplets as $avi): ?>
            <article class="avis-recuperer">
                <p class="informations-avis">Client : <?= htmlspecialchars($avi['nom']) ?> <?= htmlspecialchars($avi['prenom']) ?></p>
                <p class="informations-avis">Menu : <?= htmlspecialchars($avi['menu']) ?></p>
                <p class="informations-avis">Titre de l'avis : <?= htmlspecialchars($avi['titre']) ?></p>
                <p class="informations-avis">Contenue de l'avis : <?= htmlspecialchars($avi['commentaire']) ?></p>
                <p class="informations-avis">Note de l'avis : <?= htmlspecialchars($avi['note']) ?></p>
                <form method="post" class="formulaire-avis-employe">
                    <input type="hidden" name="avisId" value="<?= $avi['id'] ?>">
                    <button type="submit" class="valider-avis" name="action" value="validerAvis">Valider</button>
                    <button type="submit" class="refuser-avis" name="action" value="refuserAvis">Refuser</button>
                </form>
            </article>
        <?php endforeach ?>
    </div>
</section>