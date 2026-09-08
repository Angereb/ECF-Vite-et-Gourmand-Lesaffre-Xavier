function echapperHtml(texte) {
    const div = document.createElement('div');
    div.textContent = texte;
    return div.innerHTML;
}

document.getElementById('selectionTheme').addEventListener('change', () => {
    const themeSelect = document.getElementById('selectionTheme');
    const themeChoisi = parseInt(themeSelect.value);
    const theme = donneesThemes.find(p => p.id === themeChoisi);
    const articleTheme = document.getElementById('themeRecuperer');
    if (theme !== undefined) {
        articleTheme.setAttribute('aria-hidden', 'false');
        articleTheme.style.display = 'grid';
        document.getElementById('article-theme-libelle').textContent = theme.libelle;
        document.getElementById('modifierTheme').setAttribute('data-id', theme.id);
        document.getElementById('modif-theme-id').value = theme.id;
        document.getElementById('modifierlibelleThemeInput').value = theme.libelle;
    } else {
        articleTheme.setAttribute('aria-hidden', 'true');
        articleTheme.style.display = 'none';
    }
})

document.getElementById('selectionAllergene').addEventListener('change', () => {
    const allergeneSelect = document.getElementById('selectionAllergene');
    const allergeneChoisi = parseInt(allergeneSelect.value);
    const allergene = donneesAllergenes.find(p => p.id === allergeneChoisi);
    const articleAllergene = document.getElementById('allergeneRecuperer');
    if (allergene !== undefined) {
        articleAllergene.setAttribute('aria-hidden', 'false');
        articleAllergene.style.display = 'grid';
        document.getElementById('article-allergene-libelle').textContent = allergene.libelle;
        document.getElementById('modifierAllergene').setAttribute('data-id', allergene.id);
        document.getElementById('modif-allergene-id').value = allergene.id;
        document.getElementById('modifierlibelleAllergeneInput').value = allergene.libelle;
    } else {
        articleAllergene.setAttribute('aria-hidden', 'true');
        articleAllergene.style.display = 'none';
    }
})

document.getElementById('selectionPlat').addEventListener('change', () => {
    const platSelect = document.getElementById('selectionPlat');
    const platIdChoisi = parseInt(platSelect.value);
    const plat = donneesPlats.find(p => p.platId === platIdChoisi);
    const articlePlat = document.getElementById('platRecuperer');
    if (plat !== undefined) {
        articlePlat.setAttribute('aria-hidden', 'false');
        articlePlat.style.display = 'grid';
        document.getElementById('article-plat-titre').textContent = plat.platTitre;
        document.getElementById('article-plat-categorie').textContent = plat.platCategorie;
        document.getElementById('article-plat-regime').textContent = plat.platRegime;
        document.getElementById('article-plat-allergenes').textContent = plat.platAllergenes.length > 0 
            ? "Allergènes : " + plat.platAllergenes.join(", ") 
            : "Aucun allergène déclaré";
        document.getElementById('article-plat-statut').textContent = plat.platActif;
        document.getElementById('statutPlatId').value = plat.platId;
        const imagePlat = document.getElementById('article-plat-photo');
        if (plat.platPhoto !== null) {
            imagePlat.src = `data:image/png;base64,${plat.platPhoto}`;
            imagePlat.alt = `Photo du plat ${plat.platTitre}`;
            imagePlat.style.display = 'block';
        } else {
            imagePlat.style.display = 'none';
        }
        document.getElementById('modifierPlat').setAttribute('data-id', plat.platId);
        document.getElementById('modif-plat-id').value = plat.platId;
        document.getElementById('modifierTitrePlatInput').value = plat.platTitre;
        document.getElementById('modifierCategoriePlatSelect').value = plat.platCategorie;
        document.getElementById('modifierRegimePlatSelect').value = plat.platRegimeId;
        document.querySelectorAll('[id^="modification_allergene_"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        plat.platAllergenesId.forEach(allergeneId => {
            const checkbox = document.getElementById('modification_allergene_' + allergeneId);
            if (checkbox !== null) {
                checkbox.checked = true;
            }
        });
    } else {
        articlePlat.setAttribute('aria-hidden', 'true');
        articlePlat.style.display = 'none';
    }
})

document.getElementById('selectionMenu').addEventListener('change', () => {
    const menuSelect = document.getElementById('selectionMenu');
    const menuIdChoisi = parseInt(menuSelect.value);
    const menu = donneesMenus.find(p => p.id === menuIdChoisi);
    const articleMenu = document.getElementById('menuRecuperer');
    if (menu !== undefined) {
        articleMenu.setAttribute('aria-hidden', 'false');
        articleMenu.style.display = 'grid';
        document.getElementById('article-menu-titre').textContent = menu.titre;
        document.getElementById('article-menu-description').textContent = menu.description;
        document.getElementById('article-menu-condition').textContent = menu.conditions;
        document.getElementById('article-menu-theme').textContent = "Thème : " + menu.theme;
        document.getElementById('article-menu-regime').textContent = "Régime : " + menu.regime;
        document.getElementById('article-menu-minimum-convive').textContent = "Convive minimum : " + menu.minimumConvive;
        document.getElementById('article-menu-stock').textContent = "Stock actuel : " + menu.stock;
        document.getElementById('article-menu-prix').textContent = "Prix : " + menu.prix + "€";
        document.getElementById('article-menu-statut').textContent = menu.actif;
        document.getElementById('statutMenuId').value = menu.id;
        const platsParCategorie = { "Entrée": [], "Plat": [], "Dessert": [] };
        menu.plats.forEach(plat => {
            platsParCategorie[plat.categorie].push(plat);
        });
        let htmlPlats = '';
        for (const categorie in platsParCategorie) {
            if (platsParCategorie[categorie].length > 0) {
                htmlPlats += `<h4>${categorie}</h4><div class="liste-plats">`;
                platsParCategorie[categorie].forEach(plat => {
                    htmlPlats += `<p class="affichage-informations">${plat.titre}</p>`;
                });
                htmlPlats += `</div>`;
            }
        }
        document.getElementById('article-menu-plats').innerHTML = htmlPlats;
        let htmlGalerie = '';
        menu.images.forEach(image => {
            htmlGalerie += `
                <div class="image-galerie">
                    <p class="affichage-informations">${echapperHtml(image.titre)}</p>
                    <img src="data:image/png;base64,${image.photo}" alt="Photo du menu ${echapperHtml(menu.titre)}" class="image-galerie">
                </div>`;
        });
        document.getElementById('article-menu-galerie').innerHTML = htmlGalerie;
        document.getElementById('modifierStock').setAttribute('data-id', menu.id);
        document.getElementById('modif-menu-id-stock').value = menu.id;
        document.getElementById('modifierStockMenuInput').value = menu.stock;
        document.getElementById('modifierGalerie').setAttribute('data-id', menu.id);
        document.getElementById('modif-menu-id-galerie').value = menu.id;
        let htmlListeGalerie = '';
        menu.images.forEach(image => {
            htmlListeGalerie += `
                <div class="image-galerie-gestion">
                    <img src="data:image/png;base64,${image.photo}" alt="${echapperHtml(image.titre)}" class="miniature-galerie">
                    <p class="affichage-informations">${echapperHtml(image.titre)}</p>
                    <form method="post">
                        <input type="hidden" name="imageId" value="${image.id}">
                        <input type="hidden" name="menuId" value="${menu.id}">
                        <button type="submit" class="valider-formulaire-modifier-galerie-menu" name="action" value="supprimerImageMenu">Supprimer</button>
                    </form>
                </div>`;
        });
        document.getElementById('liste-images-galerie').innerHTML = htmlListeGalerie;
        document.getElementById('modifierMenu').setAttribute('data-id', menu.id);
        document.getElementById('modif-menu-id').value = menu.id;
        document.getElementById('modifierTitreMenuInput').value = menu.titre;
        document.getElementById('modifierDescriptionMenuInput').value = menu.description;
        document.getElementById('modifierConditionMenuInput').value = menu.conditions;
        document.getElementById('modifierMinimumConviveMenuInput').value = menu.minimumConvive;
        document.getElementById('modifierPrixMenuInput').value = menu.prix;
        document.getElementById('modifierThemeMenuSelect').value = menu.themeId;
        document.getElementById('modifierRegimeMenuSelect').value = menu.regimeId;
        document.querySelectorAll('[id^="modification_plat_"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        menu.platsId.forEach(platId => {
            const checkbox = document.getElementById('modification_plat_' + platId);
            if (checkbox !== null) {
                checkbox.checked = true;
            }
        });
    } else {
        articleMenu.setAttribute('aria-hidden', 'true');
        articleMenu.style.display = 'none';
    }
})