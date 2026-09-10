function dessinerAxeX(ctx, canvas, labels) {
    const distance = (canvas.width - 100) / labels.length;

    ctx.strokeStyle = '#2E2622';
    ctx.fillStyle = '#2E2622';
    ctx.beginPath();
    ctx.moveTo(50, canvas.height - 50);
    ctx.lineTo(canvas.width - 50, canvas.height - 50);
    ctx.stroke();

    labels.forEach((label, i) => {
        const x = 50 + (i * distance) + (distance / 2);
        ctx.textAlign = "center";
        ctx.font = "12px Work Sans";
        ctx.fillText(label, x, canvas.height - 30);
    });

    return distance;
}

function dessinerBarres(ctx, canvas, valeurs, distance, echelle) {
    ctx.fillStyle = '#6B2338';
    valeurs.forEach((valeur, i) => {
        const x = 50 + (i * distance) + (distance / 2) - 15;
        const hauteur = valeur * echelle;
        ctx.fillRect(x, canvas.height - 50 - hauteur, 30, hauteur);

        ctx.fillStyle = '#2E2622';
        ctx.textAlign = "center";
        ctx.fillText(valeur, x + 15, canvas.height - 55 - hauteur);
        ctx.fillStyle = '#6B2338';
    });
}

function dessinerGraphiqueBarres(idCanvas, donnees, cleLabel, cleValeur) {
    const canvas = document.getElementById(idCanvas);
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    const labels = donnees.map(d => d[cleLabel]);
    const valeurs = donnees.map(d => parseFloat(d[cleValeur]));

    const valeurMax = Math.max(...valeurs);
    const hauteurDisponible = canvas.height - 100;
    const echelle = valeurMax > 0 ? hauteurDisponible / valeurMax : 1;

    const distance = dessinerAxeX(ctx, canvas, labels);
    dessinerBarres(ctx, canvas, valeurs, distance, echelle);
}

dessinerGraphiqueBarres('graphiqueCommandes', donneesCommandesParMenu, 'menuTitre', 'nombreCommandes');

function recupererFiltres() {
    return {
        dateDebut: document.getElementById('filtre-dateDebut').value,
        dateFin: document.getElementById('filtre-dateFin').value,
        menuId: document.getElementById('filtre-menu').value,
    };
}

function construireUrl(filtres) {
    const parametres = new URLSearchParams();
    for (const cle in filtres) {
        if (filtres[cle] !== '') {
            parametres.append(cle, filtres[cle]);
        }
    }
    return '?page=filtrerStatistiquesChiffreAffaires&' + parametres.toString();
}

function actualiserGraphiqueChiffreAffaires() {
    const filtres = recupererFiltres();
    const url = construireUrl(filtres);
    fetch(url)
    .then(chiffreAffaire => chiffreAffaire.json())
    .then(graphiqueChiffreAffaires => afficherGraphiqueChiffreAffaires(graphiqueChiffreAffaires));
}

function afficherGraphiqueChiffreAffaires(donneesRecues) {
    dessinerGraphiqueBarres('graphiqueChiffreAffaires', donneesRecues, 'menuTitre', 'chiffreAffaire');
}

document.querySelectorAll('#filtre-dateDebut, #filtre-dateFin, #filtre-menu').forEach(champ => {
    champ.addEventListener('change', actualiserGraphiqueChiffreAffaires);
});