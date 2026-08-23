const boutonMenu = document.querySelector('.bouton-menu');
const liensMenu = document.getElementById('liens-menu');

boutonMenu.addEventListener('click', () => {
    const estOuvert = liensMenu.classList.toggle('ouvert');
    boutonMenu.classList.toggle('ouvert');
    boutonMenu.setAttribute('aria-expanded', estOuvert ? 'true' : 'false');
});

window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
        document.getElementById('liens-menu').classList.remove('ouvert');
        document.querySelector('.bouton-menu').classList.remove('ouvert');
        document.querySelector('.bouton-menu').setAttribute('aria-expanded', 'false');
    }
});