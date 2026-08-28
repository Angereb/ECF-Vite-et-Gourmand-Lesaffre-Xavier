let menuOuvert = null;
let carteOuverte = null;

function echapperHtml(texte) {
    const div = document.createElement('div');
    div.textContent = texte;
    return div.innerHTML;
}

function recupererFiltres() {
    return {
        prixMax: document.getElementById('filtre-prixMax').value,
        prixMin: document.getElementById('filtre-prixMin').value,
        themesId: document.getElementById('filtre-theme').value,
        regimesId: document.getElementById('filtre-regime').value,
        convivesMin: document.getElementById('filtre-convivesMin').value
    };
}

function construireUrl(filtres) {
    const parametres = new URLSearchParams();
    for (const cle in filtres) {
        if (filtres[cle] !== '') {
            parametres.append(cle, filtres[cle]);
        }
    }
    return '?page=filtrerMenus&' + parametres.toString();
}

function actualiserMenus() {
    const filtres = recupererFiltres();
    const url = construireUrl(filtres);
    fetch(url)
        .then(reponse => reponse.json())
        .then(menus => afficherMenus(menus));
}

function afficherMenus(menus) {
    const zone = document.getElementById('zone-menus');
    zone.innerHTML = '';
    menus.forEach(menu => {
        const carte = document.createElement('article');
        carte.className = 'carte-menu';
        carte.dataset.menuId = menu.id;
        carte.innerHTML = construireHtmlMiniature(menu);
        carte.addEventListener('click', () => afficherDetailMenu(menu.id));
        zone.appendChild(carte);
    });
}

function construireHtmlMiniature(menu) {
    return `
        <div class="haut-carte">
            <h3 class="titre-carte">${echapperHtml(menu.titre)}</h3>
            <span class="pastille-regime">${echapperHtml(menu.regime)}</span>
        </div>
        <p>${echapperHtml(menu.description)}</p>
        <div class="bas-carte">
            <p>Convives min : ${menu.minimumConvive}</p>
            <p class="prix-carte">Prix : ${menu.prix}€</p>
        </div>
    `;
}

document.querySelectorAll('#filtre-prixMax, #filtre-prixMin, #filtre-theme, #filtre-regime, #filtre-convivesMin').forEach(champ => {
    champ.addEventListener('change', actualiserMenus);
});

actualiserMenus();

function afficherDetailMenu(id) {
    fetch(`?page=detailMenus&id=${id}`)
        .then(reponse => reponse.json())
        .then(menu => {
            const html = construireHtmlDetail(menu);
            document.querySelectorAll('.carte-menu').forEach(carte => {
                carte.classList.remove('selectionnee');
            });
            const carteSelectionnee = document.querySelector(`.carte-menu[data-menu-id="${id}"]`);
            carteSelectionnee.classList.add('selectionnee');
            menuOuvert = menu;
            carteOuverte = carteSelectionnee;
            let cible;
            if (window.innerWidth < 768) {
                carteSelectionnee.innerHTML = html;
                carteSelectionnee.classList.add('carte-ouverte');
                cible = carteSelectionnee;
            } else {
                cible = document.getElementById('zone-menu-detaillee');
                cible.innerHTML = html;
                cible.classList.add('active');
                cible.setAttribute('aria-hidden', 'false');
                document.querySelector('.conteneur-menus').classList.add('detail-ouvert');
            }
            cible.querySelector('.fermer-detail').addEventListener('click', (evenement) => {
                evenement.stopPropagation();
                fermerDetailMenu(menu, carteSelectionnee);
            });
            cible.querySelectorAll('.badge-plat').forEach(bouton => {
                bouton.addEventListener('click', (evenement) => {
                    evenement.stopPropagation();
                    const platId = parseInt(bouton.dataset.platId);
                    const plat = menu.plats.find(p => p.id === platId);
                    afficherModalePlat(plat);
                });
            });
        });
}

function fermerDetailMenu(menu, carte) {
    carte.classList.remove('selectionnee', 'carte-ouverte');

    if (window.innerWidth < 768) {
        carte.innerHTML = construireHtmlMiniature(menu);
    } else {
        const zoneDetail = document.getElementById('zone-menu-detaillee');
        zoneDetail.innerHTML = '';
        zoneDetail.classList.remove('active');
        zoneDetail.setAttribute('aria-hidden', 'true');
        document.querySelector('.conteneur-menus').classList.remove('detail-ouvert');
    }
    menuOuvert = null;
    carteOuverte = null;
}

function construireHtmlDetail(menu) {
    const platsParCategorie = { "Entrée": [], "Plat": [], "Dessert": [] };
    menu.plats.forEach(plat => {
        platsParCategorie[plat.categorie].push(plat);
    });
    let htmlPlats = '';
    for (const categorie in platsParCategorie) {
        if (platsParCategorie[categorie].length > 0) {
            htmlPlats += `<h4>${categorie}</h4><div class="liste-plats">`;
            platsParCategorie[categorie].forEach(plat => {
                htmlPlats += `<button type="button" class="badge-plat" data-plat-id="${plat.id}">${echapperHtml(plat.titre)}</button>`;
            });
            htmlPlats += `</div>`;
        }
    }
    let htmlGalerie = '';
    menu.images.forEach(image => {
        htmlGalerie += `<img src="data:image/png;base64,${image}" alt="Photo du menu ${echapperHtml(menu.titre)}" class="image-galerie">`;
    });
    return `
        <div class="informations">
            <div class="haut-carte">
                <h3>${echapperHtml(menu.titre)}</h3>
                <span class="pastille-regime">${echapperHtml(menu.regime)}</span>
            </div>
            <div class="visuel-carte">
                <p>${echapperHtml(menu.description)}</p>
                <div class="galerie-conteneur-mobile">${htmlGalerie}</div>
            </div>
            <p>Thème : ${echapperHtml(menu.theme)}</p>
            ${menu.conditions ? `<div class="conditions-menu">${echapperHtml(menu.conditions)}</div>` : ''}
            ${htmlPlats}
            <div class="bas-carte-ouverte">
                <p>Convives min : ${menu.minimumConvive}</p>
                <p class="stock">Stock : ${menu.stock}</p>
                <p>Prix : ${menu.prix}€</p>
            </div>
            <nav class="nav-carte">
                <button type="button" class="fermer-detail">Fermer</button>
                <button type="button" class="bouton-commander">Commander</button>
            </nav>
        </div>
        <div class="galerie-conteneur-desktop">${htmlGalerie}</div>
    `;
}

function afficherModalePlat(plat) {
    document.getElementById('modale-plat-titre').textContent = plat.titre;
    document.getElementById('modale-plat-categorie').textContent = plat.categorie;
    document.getElementById('modale-plat-regime').textContent = plat.platRegime;
    document.getElementById('modale-plat-allergenes').textContent = plat.allergenes.length > 0 
        ? "Allergènes : " + plat.allergenes.join(", ") 
        : "Aucun allergène déclaré";
    const imagePlat = document.getElementById('modale-plat-photo');
    if (plat.photo !== null) {
        imagePlat.src = `data:image/png;base64,${plat.photo}`;
        imagePlat.alt = `Photo du plat ${plat.titre}`;
        imagePlat.style.display = 'block';
    } else {
        imagePlat.style.display = 'none';
    }
    const modale = document.getElementById('modale-plat');
    modale.classList.add('ouverte');
    modale.setAttribute('aria-hidden', 'false');
}

window.addEventListener('resize', () => {
    if (menuOuvert === null) return;

    if (window.innerWidth >= 768) {
        if (carteOuverte.classList.contains('carte-ouverte')) {
            carteOuverte.classList.remove('selectionnee', 'carte-ouverte');
            carteOuverte.innerHTML = construireHtmlMiniature(menuOuvert);
            menuOuvert = null;
            carteOuverte = null;
        }
    } else {
        const zoneDetail = document.getElementById('zone-menu-detaillee');
        if (zoneDetail.classList.contains('active')) {
            zoneDetail.innerHTML = '';
            zoneDetail.classList.remove('active');
            zoneDetail.setAttribute('aria-hidden', 'true');
            document.querySelector('.conteneur-menus').classList.remove('detail-ouvert');
            menuOuvert = null;
            carteOuverte = null;
        }
    }
});