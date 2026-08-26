<section class="page-contact">
    <h1 class="titre-contact">Contact</h1>
    <form class="formulaire-contact" id="formulaireContact" method="post">
        <label for="titreInput" class="label-contact">Titre de votre message : </label>
        <input type="text" class="input-contact" id="titreInput" placeholder="Titre" name="titre" value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>" required>
        <label for="descriptionInput" class="label-contact">Votre Message : </label>
        <textarea class="input-contact" id="descriptionInput" placeholder="Message" name="description" rows="8" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        <label for="emailInput" class="label-contact">Votre adresse mail : </label>
        <input type="email" class="input-contact" id="emailInput" placeholder="adresse@mail.com" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        <button type="submit" class="envoyer-contact" name="action" value="contact">Envoyer</button>
    </form>
</section>
<?php if ($messageErreur !== null): ?>
    <div class="message-erreur">
        <?= htmlspecialchars($messageErreur) ?>
    </div>
<?php endif; ?> 