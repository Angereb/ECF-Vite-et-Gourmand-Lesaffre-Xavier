<section class="page-inscription">
    <h1 class="titre-inscription">Inscription</h1>
    <form class="formulaire-inscription" id="formulaireInscription" method="post">
        <label for="nomInput" class="label-inscription">Nom : </label>
        <input type="text" class="input-inscription" id="nomInput" placeholder="Nom" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
        <label for="prenomInput" class="label-inscription">Prénom : </label>
        <input type="text" class="input-inscription" id="prenomInput" placeholder="Prénom" name="prenom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>
        <label for="emailInput" class="label-inscription">Email : </label>
        <input type="email" class="input-inscription" id="emailInput" placeholder="Votre Email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        <label for="numeroTelephoneInput" class="label-inscription">Numéro de téléphone : </label>
        <input type="text" class="input-inscription" id="numeroTelephoneInput" placeholder="XX-XX-XX-XX-XX" name="numeroTelephone" value="<?= htmlspecialchars($_POST['numeroTelephone'] ?? '') ?>" required>
        <label for="adressePostaleInput" class="label-inscription">Adresse postale : </label>
        <textarea class="input-inscription" id="adressePostaleInput" placeholder="Votre adresse" name="adressePostale" rows="6" required><?= htmlspecialchars($_POST['adressePostale'] ?? '') ?></textarea>
        <label for="motDePasseInput" class="label-inscription">Mot de passe : </label>
        <input type="password" class="input-inscription" id="motDePasseInput" placeholder="Votre mot de passe" name="motDePasse" required>
        <p class="aide-mot-de-passe">Minimum 10 caractères, avec au moins une majuscule, une minuscule, un chiffre et un caractère spécial.</p>
        <label for="verificationMotDePasseInput" class="label-inscription">Vérification du mot de passe :</label>
        <input type="password" class="input-inscription" id="verificationMotDePasseInput" placeholder="Confirmer votre mot de passe" name="verificationMotDePasse" required>
        <button type="submit" class="valider-inscription" name="action" value="inscription">Valider</button>
    </form>
</section>