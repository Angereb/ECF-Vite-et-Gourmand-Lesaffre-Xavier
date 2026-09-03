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
        bouton.blur();
        modale.classList.remove('ouverte');
        modale.setAttribute('aria-hidden', 'true');
    });
});

document.querySelectorAll('.modale').forEach(modale => {
    let clicCommenceSurOverlay = false;

    modale.addEventListener('mousedown', (evenement) => {
        clicCommenceSurOverlay = (evenement.target === modale);
    });

    modale.addEventListener('mouseup', (evenement) => {
        if (clicCommenceSurOverlay && evenement.target === modale) {
            if (document.activeElement) document.activeElement.blur();
            modale.classList.remove('ouverte');
            modale.setAttribute('aria-hidden', 'true');
        }
    });
});