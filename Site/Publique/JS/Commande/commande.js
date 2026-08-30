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
                })
            });
    }
}

function construireHtmlMenu(menu) {
    const platsParCategorie = { "Entrée": [], "Plat": [], "Dessert": [] };
    menu.plats.forEach(plat => {
        platsParCategorie[plat.categorie].push(plat);
    });
    let htmlPlats = '';
    for (const categorie in platsParCategorie) {
        if (platsParCategorie[categorie].length > 0) {
            htmlPlats += `<h4>${categorie}</h4><div class="liste-plats">`;
            platsParCategorie[categorie].forEach(plat => {
                htmlPlats += `
                    <input type="radio" class="checkbox-plat" id="plat-${plat.id}" form="formulairePrestation" name="plat-${categorie}" value="${plat.id}" data-plat-id="${plat.id}">
                    <label for="plat-${plat.id}">${echapperHtml(plat.titre)}</label>
                `;
            });
            htmlPlats += `</div>`;
        }
    }
    return `
        <div class="informations">
            <div class="haut-menu">
                <h3>${echapperHtml(menu.titre)}</h3>
                <span class="pastille-regime ${classeRegime(menu.regime)}">${echapperHtml(menu.regime)}</span>
            </div>
            <p>Thème : ${echapperHtml(menu.theme)}</p>
            ${htmlPlats}
            <p id="menu-allergenes"></p>
            ${menu.conditions ? `<div class="conditions-menu">${echapperHtml(menu.conditions)}</div>` : ''}
            <div class="bas-carte-ouverte">
                <p>Convives min : ${menu.minimumConvive}</p>
                <p class="stock">Stock : ${menu.stock}</p>
                <p>Prix : ${menu.prix}€</p>
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

afficherMenuSelectionner();