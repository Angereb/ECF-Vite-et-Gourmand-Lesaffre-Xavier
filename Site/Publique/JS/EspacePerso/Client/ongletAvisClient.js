document.querySelectorAll('.donner-avis').forEach(bouton => {
    bouton.addEventListener('click', () => {
        document.getElementById('avis-commande-id').value = bouton.dataset.id;
        const modale = document.getElementById('modale-donner-avis');
        modale.classList.add('ouverte');
        modale.setAttribute('aria-hidden', 'false');
    });
});