<?php
/**@var array $ordreJours */
?>
<section class="zone-horaires-employe">
    <h3 class="titre-zone-horaires">Les horaires de l'entreprise "Vite et Gourmand"</h3>
    <form id="formulaireHoraires" method="post"></form>
    <table class="tableau-horaires">
        <tr>
            <th>Jours</th>
            <th>Horaires d'ouverture</th>
            <th>Horaires de fermetures</th>
        </tr>
        <?php foreach ($ordreJours as $jour): ?>
            <?php $horaire = $horairesParJour[$jour] ?? null; ?>
            <tr>
                <td><?= htmlspecialchars($jour) ?></td>
                <td><input type="time" class="horaires-input" form="formulaireHoraires" name="ouverture_<?= htmlspecialchars($jour) ?>" value="<?= $horaire !== null && $horaire->getHeuresOuverture() !== null ? htmlspecialchars($horaire->getHeuresOuverture()) : "" ?>"></td>
                <td><input type="time" class="horaires-input" form="formulaireHoraires" name="fermeture_<?= htmlspecialchars($jour) ?>" value="<?= $horaire !== null && $horaire->getHeuresFermeture() !== null ? htmlspecialchars($horaire->getHeuresFermeture()) : "" ?>"></td>
            </tr>
        <?php endforeach ?>
    </table>
    <button type="submit" class="modifier-horaires" form="formulaireHoraires" name="action" value="modifierHoraires">Modifier horaires</button>
</section>