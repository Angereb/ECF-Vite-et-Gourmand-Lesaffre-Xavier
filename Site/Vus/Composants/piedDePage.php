<?php
require_once __DIR__ . "/../../Modeles/Horaires/HoraireModele.php";

$horaireModele = new HoraireModele();
$horaires = $horaireModele->rechercherTous();
?>

<footer class="pied-de-page">
    <div class="horaires">
        <h3 class="titre-horaires">Horaires</h3>
        <?php foreach ($horaires as $horaire): ?>
            <p><?= htmlspecialchars($horaire->getJour()) ?> : 
               <?= htmlspecialchars($horaire->getHeuresOuverture() ?? 'Fermé') ?> - 
               <?= htmlspecialchars($horaire->getHeuresFermeture() ?? 'Fermé') ?></p>
        <?php endforeach; ?>
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
        <h2>Mentions légales</h2>
        <p>...</p>
        <h2>Conditions générales de vente</h2>
        <p>...</p>
    </div>
</div>

<div class="modale" id="modale-mentions" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">x</button>
        <h2>Mentions légales</h2>
        <p>...</p>
    </div>
</div>

<div class="modale" id="modale-cgv" aria-hidden="true">
    <div class="modale-contenu">
        <button type="button" class="fermer-modale" aria-label="Fermer">x</button>
        <h2>Conditions générales de vente</h2>
        <p>...</p>
    </div>
</div>