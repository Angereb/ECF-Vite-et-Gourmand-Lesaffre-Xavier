document.querySelectorAll('.bouton-gerer').forEach(bouton => {
    bouton.addEventListener('click', () => {
        document.getElementById('modif-commande-id').value = bouton.dataset.id;
        document.getElementById('statutSelection').value = bouton.dataset.statutId;
        const modale = document.getElementById('modale-gerer-commande');
        modale.classList.add('ouverte');
        modale.setAttribute('aria-hidden', 'false');
    });
});

document.getElementById('statutSelection').addEventListener('change', () => {
    const select = document.getElementById('statutSelection');
    const texteChoisi = select.options[select.selectedIndex].text;

    const zoneAnnulation = document.querySelector('.zone-annulation');
    const zoneMateriel = document.querySelector('.zone-selection-materiel');

    if (texteChoisi === 'Annulée') {
        zoneAnnulation.style.display = 'block';
        zoneMateriel.style.display = 'none';
    } else if (texteChoisi === 'Accepté') {
        zoneAnnulation.style.display = 'none';
        zoneMateriel.style.display = 'block';
    } else {
        zoneAnnulation.style.display = 'none';
        zoneMateriel.style.display = 'none';
    }
});
