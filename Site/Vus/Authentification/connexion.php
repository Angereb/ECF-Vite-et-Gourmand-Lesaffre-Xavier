<section class="page-connexion">
    <h1 class="titre-connexion">Connexion</h1>
    <form class="formulaire-connexion" id="formulaireConnexion" method="post">
        <label for="emailInput" class="label-connexion">Email : </label>
        <input type="email" class="input-connexion" id="emailInput" placeholder="Votre Email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        <label for="motDePasseInput" class="label-connexion">Mot de passe : </label>
        <input type="password" class="input-connexion" id="motDePasseInput" placeholder="Votre mot de passe" name="motDePasse" required>
        <a href="?page=contact" class="contact-assistance">En cas de problème pour vous connecter, contactez-nous.</a>
        <button type="submit" class="valider-connexion" name="action" value="connexion">Valider</button>       
    </form>
</section>