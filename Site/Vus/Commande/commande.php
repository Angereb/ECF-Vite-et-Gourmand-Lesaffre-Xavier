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
                <label for="datePrestationInput" class="label-commande">Date de prestation : </label>
                <input type="date" class="input-commande" id="datePrestationInput" name="datePrestation" value="<?= htmlspecialchars($_POST['datePrestation'] ?? '') ?>" required>
                <label for="dateLivraisonInput" class="label-commande">Date de livraison : </label>
                <input type="date" class="input-commande" id="dateLivraisonInput" name="dateLivraison" value="<?= htmlspecialchars($_POST['dateLivraison'] ?? '') ?>" required>
                <label for="heureLivraisonInput" class="label-commande">Heure de Livraison : </label>
                <input type="time" class="input-commande" id="heureLivraisonInput" name="heureLivraison" value="<?= htmlspecialchars($_POST['heureLivraison'] ?? '') ?>" required>
                <label for="adresseLivraisonInput" class="label-commande">Adresse de livraison : </label>
                <textarea class="input-commande" id="adresseLivraisonInput" placeholder="Lieu de livraison" name="adresseLivraison" rows="3" required><?= htmlspecialchars($_POST['adresseLivraison'] ?? '') ?></textarea>
                <label for="codePostalInput" class="label-commande">Code postal : </label>
                <input type="text" class="input-commande" id="codePostalInput" name="codePostal" value="<?= htmlspecialchars($_POST['codePostal'] ?? '') ?>" required>
                <label for="informationsComplementaireInput" class="label-commande">Information supplémentaire de livraison : </label>
                <textarea class="input-commande" id="informationsComplementaireInput" placeholder="Entrée, étage, lieu différé ..." name="informationsComplementaire" rows="3" required><?= htmlspecialchars($_POST['informationsComplementaire'] ?? '') ?></textarea>
            </form>
        </div>
    </section>
    <section class="informations-menu" id="informations-menu" data-menu-id="<?= isset($_SESSION['menuIdCommande']) ? (int)$_SESSION['menuIdCommande'] : '' ?>">
        <a href="?page=reinitialisationMenu" class="bouton-nos-menus">Choisir un autre menu</a>
    </section>
</section>
<section class="finalisation-commande"></section>