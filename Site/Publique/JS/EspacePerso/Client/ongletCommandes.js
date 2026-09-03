document.querySelectorAll('.bouton-modifier').forEach(bouton => {
    bouton.addEventListener('click', () => {
        document.getElementById('modif-commande-id').value = bouton.dataset.id;
        document.getElementById('adresseLivraisonInput').value = bouton.dataset.adresse;
        document.getElementById('codePostalInput').value = bouton.dataset.codePostal;
        document.getElementById('datePrestationInput').value = bouton.dataset.datePrestation;
        document.getElementById('dateLivraisonInput').value = bouton.dataset.dateLivraison;
        document.getElementById('heureLivraisonInput').value = bouton.dataset.heureLivraison;
        document.getElementById('conviveInput').value = bouton.dataset.convive;
        const modale = document.getElementById('modale-modifier-commande');
        modale.classList.add('ouverte');
        modale.setAttribute('aria-hidden', 'false');
    });
});