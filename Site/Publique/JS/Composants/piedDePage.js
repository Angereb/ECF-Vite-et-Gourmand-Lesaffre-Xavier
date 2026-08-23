document.querySelectorAll('[data-modale]').forEach(bouton => {
    bouton.addEventListener('click', () => {
        const modale = document.getElementById(bouton.dataset.modale);
        modale.classList.add('ouverte');
        modale.setAttribute('aria-hidden', 'false');
    });
});

document.querySelectorAll('.fermer-modale').forEach(bouton => {
    bouton.addEventListener('click', () => {
        const modale = bouton.closest('.modale');
        modale.classList.remove('ouverte');
        modale.setAttribute('aria-hidden', 'true');
    });
});

document.querySelectorAll('.modale').forEach(modale => {
    modale.addEventListener('click', (evenement) => {
        if (evenement.target === modale) {
            modale.classList.remove('ouverte');
            modale.setAttribute('aria-hidden', 'true');
        }
    });
});