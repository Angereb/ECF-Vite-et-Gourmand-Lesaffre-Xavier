document.getElementById('selectionEmploye').addEventListener('change', () => {
    const employeSelect = document.getElementById('selectionEmploye');
    const employeChoisi = parseInt(employeSelect.value);
    const employe = donneesEmploye.find(p => p.utilisateurId === employeChoisi);
    const articleEmploye = document.getElementById('employeRecuperer');
    if (employe !== undefined) {
        articleEmploye.setAttribute('aria-hidden', 'false');
        articleEmploye.style.display = 'grid';
        document.getElementById('articleEmployeNom').textContent = employe.nom;
        document.getElementById('articleEmployePrenom').textContent = employe.prenom;
        document.getElementById('articleEmployeEmail').textContent = employe.email;
        document.getElementById('articleEmployeEtat').textContent = employe.etat;
        document.getElementById('employeId').value = employe.utilisateurId;
    } else {
        articleEmploye.setAttribute('aria-hidden', 'true');
        articleEmploye.style.display = 'none';
    }
})