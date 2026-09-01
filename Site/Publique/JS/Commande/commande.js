function echapperHtml(texte) {
    const div = document.createElement('div');
    div.textContent = texte;
    return div.innerHTML;
}

function classeRegime(regime) {
    const correspondance = {
        "Classique": "regime-classique",
        "Végétarien": "regime-vegetarien",
        "Vegan": "regime-vegan"
    };
    return correspondance[regime] ?? "regime-classique";
}
// Penser a vérifier que les libellés de régime corresponde avec la bdd

function afficherMenuSelectionner() {
    const zoneMenu = document.getElementById("informations-menu");
    const menuId = zoneMenu.dataset.menuId;
    if (menuId !== '') {
        fetch(`?page=detailMenus&id=${menuId}`)
            .then(reponse => reponse.json())
            .then(menu => {
                const html = construireHtmlMenu(menu);
                zoneMenu.innerHTML = html;
                zoneMenu.querySelectorAll('.checkbox-plat').forEach(checkboxPlat => {
                    checkboxPlat.addEventListener('change', () =>{
                        actualiserAllergenes(menu);
                    });
                });
                document.getElementById("conviveInput").addEventListener('change', () => {
                    calculerPrix(menu);
                });
                document.getElementById("codePostalInput").addEventListener('change', () => {
                    calculerPrix(menu);
                });
                document.querySelectorAll('#conviveInput, #codePostalInput').forEach(champ => {
                    champ.addEventListener('keydown', (evenement) => {
                        if (evenement.key === 'Enter') {
                            evenement.preventDefault();
                        }
                    });
                });
            });
    }
}

function construireHtmlPlats(platsParCategorie, prefixe) {
    let html = '';
    for (const categorie in platsParCategorie) {
        if (platsParCategorie[categorie].length > 0) {
            html += `<h4>${categorie}</h4><div class="liste-plats">`;
            platsParCategorie[categorie].forEach(plat => {
                html += `
                    <input type="radio" class="checkbox-plat" id="${prefixe}-plat-${plat.id}" form="formulairePrestation" name="plat-${categorie}" value="${plat.id}" data-plat-id="${plat.id}">
                    <label for="${prefixe}-plat-${plat.id}">${echapperHtml(plat.titre)}</label>
                `;
            });
            html += `</div>`;
        }
    }
    return html;
}

function construireHtmlMenu(menu) {
    const platsParCategorie = { "Entrée": [], "Plat": [], "Dessert": [] };
    menu.plats.forEach(plat => {
        platsParCategorie[plat.categorie].push(plat);
    });
    const htmlPlatsMobile = construireHtmlPlats(platsParCategorie, 'mobile');
    const htmlPlatsDesktop = construireHtmlPlats(platsParCategorie, 'desktop');
    return `
        <div class="informations">
            <div class="menu-generale">
                <div class="haut-menu">
                    <h3>${echapperHtml(menu.titre)}</h3>
                    <span class="pastille-regime ${classeRegime(menu.regime)}">${echapperHtml(menu.regime)}</span>
                </div>
                <p>Thème : ${echapperHtml(menu.theme)}</p>
                <div class="plats-mobile">
                    ${htmlPlatsMobile}
                </div>
                <p id="menu-allergenes"></p>
                ${menu.conditions ? `<div class="conditions-menu">${echapperHtml(menu.conditions)}</div>` : ''}
            </div>
            <div class="menu-detail">
                <div class="plats-desktop">
                    ${htmlPlatsDesktop }
                </div>
                <div class="bas-carte-ouverte">
                    <div class="zone-convive">
                        <label for="conviveInput" class="label-commande">Convives : </label>
                        <input type="number" class="input-commande-convive" id="conviveInput" form="formulairePrestation" name="convive" required>
                    </div>
                    <div class="zone-tarifaire">
                        <p id="prix-menu"></p>
                        <p id="reduction"></p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function actualiserAllergenes(menu) {
    const toutesLesCheckbox = document.querySelectorAll('.checkbox-plat');
    const platSelectionner = Array.from(toutesLesCheckbox).filter(checkbox => checkbox.checked);
    const allergenes = [];
    platSelectionner.forEach (checkbox => {
        const platId = parseInt(checkbox.dataset.platId);
        const plat = menu.plats.find(p => p.id === platId)
        allergenes.push(...plat.allergenes);
    });
    const allergenesUniques = [...new Set(allergenes)];
    document.getElementById('menu-allergenes').textContent = allergenesUniques.length > 0 
        ? "Allergènes : " + allergenesUniques.join(", ") 
        : "Aucun allergène déclaré";
}

function calculerPrix() {
    const conviveInput = document.getElementById("conviveInput");
    const convive = conviveInput.value;
    const codePostalInput = document.getElementById("codePostalInput");
    const codePostal = codePostalInput.value;
    if (convive !== '' && codePostal !== '') {
        fetch(`?page=calculerPrix&convive=${convive}&codePostal=${codePostal}`)
            .then(response => response.json())
            .then(detailFacture => {
                document.getElementById('prix-menu').textContent = "Prix : " + detailFacture.prixMenu + "€";
                document.getElementById('reduction').textContent = "Réduction : " + detailFacture.reduction + "€";
                document.getElementById('frais-livraison').textContent = "Prix livraison : " +  detailFacture.fraisLivraison + "€";
                document.getElementById('total').textContent = "Total : " + detailFacture.total + "€";
            });
    };
}

afficherMenuSelectionner();

window.addEventListener('resize', () => {
    document.querySelectorAll('.checkbox-plat:checked').forEach(radioCoche => {
        const platId = radioCoche.dataset.platId;
        document.querySelectorAll(`.checkbox-plat[data-plat-id="${platId}"]`).forEach(radio => {
            radio.checked = true;
        });
    });
});