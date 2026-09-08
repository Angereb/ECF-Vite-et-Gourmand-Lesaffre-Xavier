<?php
/**@var array $fichesEmploye */
?>
<script>
    const donneesEmploye = <?= json_encode($fichesEmploye) ?>;
</script>

<section class="zone-onglet-employe">
    <h3 class="titre-zone-employe">Gestion des employés</h3>
    <div class="creation-nouvel-employe">
        <h3>Nouvel Employé</h3>
        <form class="formulaire-nouvel-employe" id="formulaireNouvelEmploye" method="post">
            <div class="duo-label-input">
                <label for="nomInput" class="label-inscription">Nom : </label>
                <input type="text" class="input-inscription" id="nomInput" placeholder="Nom" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
            </div>
            <div class="duo-label-input">
                <label for="prenomInput" class="label-inscription">Prénom : </label>
                <input type="text" class="input-inscription" id="prenomInput" placeholder="Prénom" name="prenom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>
            </div>
            <div class="duo-label-input">
                <label for="emailInput" class="label-inscription">Email : </label>
                <input type="email" class="input-inscription" id="emailInput" placeholder="Votre Email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="duo-label-input">
                <label for="motDePasseInput" class="label-inscription">Mot de passe : </label>
                <input type="password" class="input-inscription" id="motDePasseInput" placeholder="Votre mot de passe" name="motDePasse" required>
            </div>
            <p class="aide-mot-de-passe">Minimum 10 caractères, avec au moins une majuscule, une minuscule, un chiffre et un caractère spécial.</p>
            <div class="duo-label-input">
                <label for="verificationMotDePasseInput" class="label-inscription">Vérification du mot de passe :</label>
                <input type="password" class="input-inscription" id="verificationMotDePasseInput" placeholder="Confirmer votre mot de passe" name="verificationMotDePasse" required>
            </div>
            <button type="submit" class="valider-inscription" name="action" value="creerEmploye">Valider</button>
        </form>
    </div>
    <div class="modification-statut-employe">
        <h3>Modifier Employé</h3>
        <div class="zone-select">
            <label for="selectionEmploye" class="selection">Employé à modifier : </label>
            <select class="selecteur-gestion" id="selectionEmploye" name="selectEmploye">
                <option value="">-</option>
                <?php foreach ($fichesEmploye as $ficheEmploye) : ?>
                    <option value="<?= $ficheEmploye['utilisateurId'] ?>"><?= htmlspecialchars($ficheEmploye['nom']) ?> <?= htmlspecialchars($ficheEmploye['prenom']) ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <article class="employe-recuperer" id="employeRecuperer" aria-hidden="true">
            <p class="affichage-informations" id="articleEmployeNom"></p>
            <p class="affichage-informations" id="articleEmployePrenom"></p>
            <p class="affichage-informations" id="articleEmployeEmail"></p>
            <div class="zone-statut">
                <p class="affichage-informations" id="articleEmployeEtat"></p>
                <form class="formulaire-statut" method="post">
                    <input type="hidden" name="employeId" id="employeId">
                    <button type="submit" class="bouton-modification" name="action" value="toggleStatutEmploye">Changer le statut</button>
                </form>
            </div>
        </article>
    </div>
</section>