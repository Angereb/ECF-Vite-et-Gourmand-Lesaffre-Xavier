document.querySelectorAll('.avis-recuperer-miniature-mobile').forEach(miniature => {
    miniature.addEventListener('click', () => {
        if (window.innerWidth >= 768) return;
        const id = miniature.dataset.avisId;
        const complet = document.querySelector(`.avis-recuperer-complette[data-avis-id="${id}"]`);
        miniature.style.display = 'none';
        miniature.setAttribute('aria-hidden', 'true');
        complet.style.display = 'grid';
        complet.setAttribute('aria-hidden', 'false');
    });
});

document.querySelectorAll('.avis-recuperer-complette').forEach(complette => {
    complette.addEventListener('click', () => {
        if (window.innerWidth >= 768) return;
        const id = complette.dataset.avisId;
        const miniature = document.querySelector(`.avis-recuperer-miniature-mobile[data-avis-id="${id}"]`);  
        complette.style.display = 'none';
        complette.setAttribute('aria-hidden', 'true');
        miniature.style.display = 'grid';
        miniature.setAttribute('aria-hidden', 'false');
    });
});

window.addEventListener('resize', () => {
    document.querySelectorAll('.avis-recuperer-miniature-mobile').forEach(miniature => {
        const id = miniature.dataset.avisId;
        const complet = document.querySelector(`.avis-recuperer-complette[data-avis-id="${id}"]`);

        if (window.innerWidth >= 768) {
            miniature.style.display = 'none';
            miniature.setAttribute('aria-hidden', 'true');
            complet.style.display = 'grid';
            complet.setAttribute('aria-hidden', 'false');
        } else {
            miniature.style.display = 'grid';
            miniature.setAttribute('aria-hidden', 'false');
            complet.style.display = 'none';
            complet.setAttribute('aria-hidden', 'true');
        }
    });
});