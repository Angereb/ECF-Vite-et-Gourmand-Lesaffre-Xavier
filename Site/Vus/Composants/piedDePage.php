<?php
require_once __DIR__ . "/../../Modeles/Horaires/HoraireModele.php";

$horaireModele = new HoraireModele();
$horaires = $horaireModele->rechercherTous();
$horairesParJour = [];
foreach ($horaires as $horaire) {
    $horairesParJour[$horaire->getJour()] = $horaire;
}
$ordreJours = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
?>

<footer class="pied-de-page">
    <div class="secteur-horaires">
        <h4 class="titre-horaires">Horaires</h4>
        <div class="horaires">
            <?php foreach ($ordreJours as $jour): ?>
                <?php $horaire = $horairesParJour[$jour] ?? null; ?>
                <?php if ($horaire !== null): ?>
                    <p><?= htmlspecialchars($jour) ?> : 
                    <?= htmlspecialchars($horaire->getHeuresOuverture() ?? 'Fermé') ?> - 
                    <?= htmlspecialchars($horaire->getHeuresFermeture() ?? 'Fermé') ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="liens-legaux">
        <button type="button" class="liens-legal-mobile" data-modale="modale-mentions-cgv">Mentions Légales & CGV</button>
        <button type="button" class="liens-legal-desktop" data-modale="modale-mentions">Mentions légales</button>
        <button type="button" class="liens-legal-desktop" data-modale="modale-cgv">CGV</button>
    </div>
</footer>

<div class="modale" id="modale-mentions-cgv" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">x</button>
        <?php require __DIR__ . "/ContenusModales/mentionsLegales.php" ?>
        <?php require __DIR__ . "/ContenusModales/ConditionsGeneralesVentes.php" ?>
    </div>
</div>

<div class="modale" id="modale-mentions" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">x</button>
        <?php require __DIR__ . "/ContenusModales/mentionsLegales.php" ?>
    </div>
</div>

<div class="modale" id="modale-cgv" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">x</button>
        <?php require __DIR__ . "/ContenusModales/ConditionsGeneralesVentes.php" ?>
    </div>
</div>