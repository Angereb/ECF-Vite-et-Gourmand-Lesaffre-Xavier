<?php
/**@var object $client */
?>
<section class="zone-onglet-compte">
    <article class="client-recuperer">
        <h3 class="titre-zone-compte">Votre Compte</h3>
        <form class="formulaire-compte-client" id="formulaireCompteClient" method="post">
            <div class="zone-nom">
                <label for="nomModifierInput" class="label-compte">Nom : </label>
                <input type="text" class="input-compte" id="nomModifierInput" name="nom" value="<?= htmlspecialchars($client->getNom()) ?>" required>
            </div>
            <div class="zone-prenom">
                <label for="prenomModifierInput" class="label-compte">Prénom : </label>
                <input type="text" class="input-compte" id="prenomModifierInput" name="prenom" value="<?= htmlspecialchars($client->getPrenom()) ?>" required>
            </div>
            <div class="zone-email">
                <label for="emailModifierInput" class="label-compte">Email : </label>
                <input type="email" class="input-compte" id="emailModifierInput" name="email" value="<?= htmlspecialchars($client->getEmail()) ?>" required>
            </div>
            <div class="zone-telephone">
                <label for="numeroTelephoneModifierInput" class="label-compte">Numéro de téléphone : </label>
                <input type="text" class="input-compte" id="numeroTelephoneModifierInput" name="numeroTelephone" value="<?= htmlspecialchars($client->getNumeroTelephone()) ?>" required>
            </div>
            <div class="zone-adresse">
                <label for="adressePostaleModifierInput" class="label-compte">Adresse postale : </label>
                <textarea class="input-compte" id="adressePostaleModifierInput" name="adressePostale" rows="6" required><?= htmlspecialchars($client->getAdressePostale()) ?></textarea>
            </div>
            <div class="zone-mot-de-passe">
                <label for="motDePasseInput" class="label-compte">Mot de passe : </label>
                <input type="password" class="input-compte" id="motDePasseInput" placeholder="Entrez votre mot de passe" name="motDePasse" required>
            </div>
            <button type="submit" class="modifier-compte" name="action" value="modifierCompte">Modifier le Compte</button>
        </form>
        <h3 class="titre-zone-mot-de-passe">Votre Mot de Passe</h3>
        <form class="formulaire-mot-de-passe-client" id="formulaireMotDePasseClient" method="post">
            <div class="zone-ancien-mot-de-passe">
                <label for="ancienMotDePasseInput" class="label-compte">Ancien mot de passe : </label>
                <input type="password" class="input-compte" id="ancienMotDePasseInput" placeholder="Entrez votre ancien mot de passe" name="ancienMotDePasse" required>
            </div>
            <div class="zone-nouveau-mot-de-passe">
                <label for="nouveauMotDePasseInput" class="label-compte">Nouveau mot de passe : </label>
                <input type="password" class="input-compte" id="nouveauMotDePasseInput" placeholder="Entrez votre nouveau mot de passe" name="nouveauMotDePasse" required>
            </div>
            <div class="zone-verification-nouveau-mot-de-passe">
                <label for="verificationNouveauMotDePasseInput" class="label-compte">Vérification nouveau mot de passe : </label>
                <input type="password" class="input-compte" id="verificationNouveauMotDePasseInput" placeholder="Vérifier votre nouveau mot de passe" name="verificationNouveauMotDePasse" required>
            </div>
            <button type="submit" class="modifier-compte" name="action" value="modifierMotDePasse">Modifier le Mot de passe</button>
        </form>       
    </article>
</section>