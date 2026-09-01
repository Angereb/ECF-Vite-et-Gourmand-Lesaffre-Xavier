<?php
/**@var Client $client */
?>
<section class="commande">
    <section class="informations-client">
        <div class="informations-personnel">
            <p class="information-nom">Nom : <?= htmlspecialchars($client->getNom()) ?></p>
            <p class="information-prenom">Prénom : <?= htmlspecialchars($client->getPrenom()) ?></p>
            <p class="information-email">Email : <?= htmlspecialchars($client->getEmail()) ?></p>
            <p class="information-numero-telephone">Téléphone : <?= htmlspecialchars($client->getNumeroTelephone()) ?></p>
        </div>
        <div class="informations-prestation">
            <form class="formulaire-prestation" id="formulairePrestation" method="post">
                <div class="zone-date-prestation">
                    <label for="datePrestationInput" class="label-commande">Date de prestation : </label>
                    <input type="date" class="input-commande" id="datePrestationInput" name="datePrestation" value="<?= htmlspecialchars($_POST['datePrestation'] ?? '') ?>" required>
                </div>
                <div class="zone-date-livraison">
                    <label for="dateLivraisonInput" class="label-commande">Date de livraison : </label>
                    <input type="date" class="input-commande" id="dateLivraisonInput" name="dateLivraison" value="<?= htmlspecialchars($_POST['dateLivraison'] ?? '') ?>" required>
                </div>
                <div class="zone-heure-livraison">
                    <label for="heureLivraisonInput" class="label-commande">Heure de Livraison : </label>
                    <input type="time" class="input-commande" id="heureLivraisonInput" name="heureLivraison" value="<?= htmlspecialchars($_POST['heureLivraison'] ?? '') ?>" required>
                </div>
                <div class="zone-adresse-livraison">
                    <label for="adresseLivraisonInput" class="label-commande">Adresse de livraison : </label>
                    <textarea class="input-commande" id="adresseLivraisonInput" placeholder="Lieu de livraison" name="adresseLivraison" rows="3" required><?= htmlspecialchars($_POST['adresseLivraison'] ?? '') ?></textarea>
                </div>
                <div class="zone-code-postal">
                    <label for="codePostalInput" class="label-commande">Code postal : </label>
                    <input type="text" class="input-commande" id="codePostalInput" name="codePostal" value="<?= htmlspecialchars($_POST['codePostal'] ?? '') ?>" required>
                </div>
                <div class="zone-informations-complementaire">
                    <label for="informationsComplementaireInput" class="label-commande">Information supplémentaire de livraison : </label>
                    <textarea class="input-commande" id="informationsComplementaireInput" placeholder="Entrée, étage, lieu différé ..." name="informationsComplementaire" rows="3" required><?= htmlspecialchars($_POST['informationsComplementaire'] ?? '') ?></textarea>
                </div>
            </form>
            <p class="frais-livraison" id="frais-livraison"></p>
        </div>
    </section>
    <a href="?page=reinitialisationMenu" class="bouton-nos-menus">Choisir un autre menu</a>
    <section class="informations-menu" id="informations-menu" data-menu-id="<?= isset($_SESSION['menuIdCommande']) ? (int)$_SESSION['menuIdCommande'] : '' ?>">
    </section>
</section>
<section class="finalisation-commande">
    <div class="zone-erreur">
        <?php if ($messageErreur !== null): ?>
            <div class="message-erreur">
                <?= htmlspecialchars($messageErreur) ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="zone-tarifaire-finale">
        <button type="submit" class="valider-commande" form="formulairePrestation" name="action" value="commander">Valider</button>
        <p class="total-facture" id="total"></p>
    </div>
</section>