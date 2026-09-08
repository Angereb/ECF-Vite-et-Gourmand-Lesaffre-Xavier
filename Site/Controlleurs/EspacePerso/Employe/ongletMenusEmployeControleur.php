<?php
require_once __DIR__ . "/../../../Modeles/Themes/ThemeModele.php";
require_once __DIR__ . "/../../../Modeles/Allergenes/AllergeneModele.php";
require_once __DIR__ . "/../../../Modeles/Plats/PlatModele.php";
require_once __DIR__ . "/../../../Modeles/PlatsAllergenes/PlatAllergeneModele.php";
require_once __DIR__ . "/../../../Modeles/MenusPlats/MenuPlatModele.php";
require_once __DIR__ . "/../../../Modeles/Menus/MenuModele.php";
require_once __DIR__ . "/../../../Modeles/Images/ImageModele.php";
require_once __DIR__ . "/../../../Modeles/Regimes/RegimeModele.php";

if (!isset($_SESSION["employe"])) {
    header("Location: ?page=accueil");
    exit;
}

$titreOnglet = "Gestion des menus";

$cssOnglet = ["EspacePerso/Employe/ongletMenusEmploye.css"];

$jsOnglet = ["EspacePerso/Employe/ongletMenusEmploye.js"];

$messageErreur = null;

$toastMessage = $_SESSION["messageSucces"] ?? null;
$toastType = "succes";
unset($_SESSION["messageSucces"]);

$themeModele = new ThemeModele;
$allergeneModele = new AllergeneModele;
$platModele = new PlatModele;
$platAllergeneModele = new PlatAllergeneModele;
$menuModele = new MenuModele;
$menuPlatModele = new MenuPlatModele;
$imageModele = new ImageModele;
$regimeModele = new RegimeModele;

$themes = $themeModele->rechercherTous();
$themesJson = [];
foreach ($themes as $theme) {
    $themesJson[] = [
        "id" => $theme->getThemesId(),
        "libelle" => $theme->getLibelle()
    ];
}
$allergenes = $allergeneModele->rechercherTous();
$allergenesJson = [];
foreach ($allergenes as $allergene) {
    $allergenesJson[] = [
        "id" => $allergene->getAllergenesId(),
        "libelle" => $allergene->getLibelle()
    ];
}
$plats = $platModele->rechercherTous();
$fichePlats = [];
foreach ($plats as $plat) {
    if ($plat->getActif() === true) {
        $platActif = "Actif";
    } else {
        $platActif = "Inactif";
    }
    $allergenesDuPlat = [];
    $allergenesPlat = $platAllergeneModele->rechercherParPlat($plat->getPlatsId());
    foreach ($allergenesPlat as $allergeneId) {
        $allergene = $allergeneModele->rechercherParId($allergeneId);
        $allergenesDuPlat[] = $allergene->getLibelle();
    }
    $regimePlat = $regimeModele->rechercherParId($plat->getRegimesId());
    $fichePlats[] = [
        "platId" => $plat->getPlatsId(),
        "platTitre" => $plat->getTitre(),
        "platCategorie" => $plat->getCategorie(),
        "platPhoto" => $plat->getPhoto() !== null ? base64_encode($plat->getPhoto()) : null,
        "platAllergenesId" => $allergenesPlat,
        "platAllergenes" => $allergenesDuPlat,
        "platRegimeId" => $plat->getRegimesId(),
        "platRegime" => $regimePlat->getLibelle(),
        "platActif" => $platActif
    ];
}
$platsUtilisables = $platModele->rechercherFiltrer();
$menus = $menuModele->rechercherTous();
$ficheMenus = [];
foreach ($menus as $menu) {
    if ($menu->getActif() === true) {
        $menuActif = "Actif";
    } else {
        $menuActif = "Inactif";
    }
    $themeMenu = $themeModele->rechercherParId($menu->getThemesId());
    $regimeMenu = $regimeModele->rechercherParId($menu->getRegimesId());
    $imagesMenu = $imageModele->rechercherParMenusId($menu->getMenusId());
    $menuPlats = $menuPlatModele->rechercherParMenu($menu->getMenusId());
    $platsPourMenu = [];
    foreach ($menuPlats as $platId) {
        $platPourMenu = $platModele->rechercherParId($platId);
        $platsPourMenu[] = [
            "id" => $platPourMenu->getPlatsId(),
            "titre" => $platPourMenu->getTitre(),
            "categorie" => $platPourMenu->getCategorie()
        ];
    }
    $ficheMenus[] = [
        "id" => $menu->getMenusId(),
        "titre" => $menu->getTitre(),
        "description" => $menu->getDescriptions(),
        "conditions" => $menu->getConditions(),
        "stock" => $menu->getStock(),
        "minimumConvive" => $menu->getMinimumConvive(),
        "prix" => $menu->getPrix(),
        "themeId" => $menu->getThemesId(),
        "theme" => $themeMenu->getLibelle(),
        "regimeId" => $menu->getRegimesId(),
        "regime" => $regimeMenu->getLibelle(),
        "images" => array_map(fn($img) => [
            "id" => $img->getImagesId(),
            "titre" => $img->getTitre(),
            "photo" => base64_encode($img->getPhoto())
        ], $imagesMenu),
        "platsId" => $menuPlats,
        "plats" => $platsPourMenu,
        "actif" => $menuActif
    ];
}
$regimes = $regimeModele->rechercherTous();

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST["action"] ?? null;
    try {
        switch($formulaire){
            case 'toggleStatutPlat':
                $platId = (int)($_POST['platId'] ?? 0);
                $platExistant = $platModele->rechercherParId($platId);
                if ($platExistant === null) {
                    throw new Exception("Plat introuvable.");
                }
                $platModele->modifierActif($platId, !$platExistant->getActif());
                $_SESSION["messageSucces"] = "Le statut du plat a bien été modifié.";
                break;

            case 'toggleStatutMenu':
                $menuId = (int)($_POST['menuId'] ?? 0);
                $menuExistant = $menuModele->rechercherParId($menuId);
                if ($menuExistant === null) {
                    throw new Exception("Menu introuvable.");
                }
                $menuModele->modifierActif($menuId, !$menuExistant->getActif());
                $_SESSION["messageSucces"] = "Le statut du menu a bien été modifié.";
                break;
            
            case 'creerTheme':
                $themeLibelle = $_POST['libelleTheme'] ?? "";
                $nouveauTheme = new Theme(null, $themeLibelle);
                $themeModele->ajouter($nouveauTheme);
                $_SESSION["messageSucces"] = "Le thème a bien été créer.";
                break;

            case 'creerAllergene':
                $allergeneLibelle = $_POST['libelleAllergene'] ?? "";
                $nouveauAllergene = new Allergene(null, $allergeneLibelle);
                $allergeneModele->ajouter($nouveauAllergene);
                $_SESSION["messageSucces"] = "L'allergène a bien été créer.";
                break;
            
            case 'creerPlat':
                $titrePlat = $_POST['titrePlat'] ?? "";
                $categoriePlat = $_POST['categoriePlat'] ?? "";
                $regimePlatId = (int)($_POST['regimePlat'] ?? 0);
                $photoContenu = null;
                if (isset($_FILES["photoPlat"]) && $_FILES["photoPlat"]["error"] === UPLOAD_ERR_OK) {
                    if (!is_uploaded_file($_FILES["photoPlat"]["tmp_name"])) {
                        throw new Exception("Fichier invalide.");
                    }
                    if ($_FILES["photoPlat"]["size"] > 5 * 1024 * 1024) {
                        throw new Exception("L'image ne doit pas dépasser 5 Mo.");
                    }
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $typeReel = $finfo->file($_FILES["photoPlat"]["tmp_name"]);
                    if ($typeReel !== "image/png") {
                        throw new Exception("Le fichier doit être une image au format PNG.");
                    }
                    $photoContenu = file_get_contents($_FILES["photoPlat"]["tmp_name"]);
                }
                $nouveauPlat = new Plat(null, $titrePlat, $categoriePlat, $photoContenu, true, $regimePlatId);
                $nouveauPlatId = $platModele->ajouter($nouveauPlat);
                $allergenesChoisis = $_POST["allergenes"] ?? [];
                foreach ($allergenesChoisis as $allergeneId) {
                    $platAllergeneModele->ajouter($nouveauPlatId, (int)$allergeneId);
                }
                $_SESSION["messageSucces"] = "Le plat a bien été créé.";
                break;

            case 'creerMenu':
                $titreMenu = $_POST['titreMenu'] ?? "";
                $descriptionMenu = $_POST['descriptionMenu'] ?? "";
                $conditionsMenu = $_POST['conditionMenu'] ?? "";
                $conviveMinimumMenu = (int)($_POST['minimumConviveMenu'] ?? 0);
                $stockMenu = (int)($_POST['stockInitialMenu'] ?? 0);
                $prixMenu = (string)($_POST['prixMenu'] ?? "");
                $themesIdMenu = (int)($_POST['themeMenu'] ?? 0);
                if ($themeModele->rechercherParId($themesIdMenu) === null) {
                    throw new Exception("Thème sélectionner invalide.");
                }
                $regimeNouveauMenu = (int)($_POST['regimeMenu'] ?? 0);
                if ($regimeModele->rechercherParId($regimeNouveauMenu) === null) {
                    throw new Exception("Régime sélectionner invalide.");
                }
                $platsMenuId = $_POST["plats"] ?? [];
                $nouveauMenu = new Menu(null, $titreMenu, $descriptionMenu, $conditionsMenu, $conviveMinimumMenu, $stockMenu, $prixMenu, true, $themesIdMenu, $regimeNouveauMenu);
                $nouveauMenuId = $menuModele->ajouter($nouveauMenu);
                foreach ($platsMenuId as $platMenuId) {
                    $menuPlatModele->ajouter($nouveauMenuId, (int)$platMenuId);
                }
                $_SESSION["messageSucces"] = "Le menu a bien été créé.";
                break;
            
            case 'modifierTheme':
                $themeModifierId = (int)($_POST['themeId'] ?? 0);
                if ($themeModele->rechercherParId($themeModifierId) === null) {
                    throw new Exception("Thème introuvable.");
                }
                $themeModifierLibelle = $_POST['modifierlibelleTheme'] ?? "";
                $themeModifier = new Theme($themeModifierId, $themeModifierLibelle);
                $themeModele->modifier($themeModifier);
                $_SESSION["messageSucces"] = "Le thème a bien été modifier.";
                break;

            case 'modifierAllergene':
                $allergeneModifierId = (int)($_POST['allergeneId'] ?? 0);
                if ($allergeneModele->rechercherParId($allergeneModifierId) === null) {
                    throw new Exception("Allergène introuvable.");
                }
                $allergeneModifierLibelle = $_POST['modifierlibelleAllergene'] ?? "";
                $allergeneModifier = new Allergene($allergeneModifierId, $allergeneModifierLibelle);
                $allergeneModele->modifier($allergeneModifier);
                $_SESSION["messageSucces"] = "L'allergène a bien été modifier.";
                break;

            case 'modifierPlat':
                $platId = (int)($_POST['platId'] ?? 0);
                $platExistant = $platModele->rechercherParId($platId);
                if ($platExistant === null) {
                    throw new Exception("Plat introuvable.");
                }
                $titrePlat = $_POST['modifierTitrePlat'] ?? "";
                $categoriePlat = $_POST['modifierCategoriePlat'] ?? "";
                $regimePlatId = (int)($_POST['modifierRegimePlat'] ?? 0);
                if (isset($_FILES["photoPlat"]) && $_FILES["photoPlat"]["error"] === UPLOAD_ERR_OK) {
                    if (!is_uploaded_file($_FILES["photoPlat"]["tmp_name"])) {
                        throw new Exception("Fichier invalide.");
                    }
                    if ($_FILES["photoPlat"]["size"] > 5 * 1024 * 1024) {
                        throw new Exception("L'image ne doit pas dépasser 5 Mo.");
                    }
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $typeReel = $finfo->file($_FILES["photoPlat"]["tmp_name"]);
                    if ($typeReel !== "image/png") {
                        throw new Exception("Le fichier doit être une image au format PNG.");
                    }
                    $photoContenu = file_get_contents($_FILES["photoPlat"]["tmp_name"]);
                } else {
                    $photoContenu = $platExistant->getPhoto();
                }
                $platModifie = new Plat($platId, $titrePlat, $categoriePlat, $photoContenu, $platExistant->getActif(), $regimePlatId);
                $platModele->modifier($platModifie);
                $anciensAllergenes = $platAllergeneModele->rechercherParPlat($platId);
                foreach ($anciensAllergenes as $allergeneId) {
                    $platAllergeneModele->supprimer($platId, $allergeneId);
                }
                $nouveauxAllergenes = $_POST["allergenes"] ?? [];
                foreach ($nouveauxAllergenes as $allergeneId) {
                    $platAllergeneModele->ajouter($platId, (int)$allergeneId);
                }
                break;

            case 'modifierStockMenu':
                $stockMenuModifierId = (int)($_POST['menuId'] ?? 0);
                $stockModifierMenu = (int)($_POST['modifierStockMenu'] ?? 0);
                $menuModele->modifierStock($stockMenuModifierId, $stockModifierMenu);
                $_SESSION["messageSucces"] = "Le stock du menu a bien été mis à jour.";
                break;

            case 'ajouterImageMenu':
                $menuIdPourGalerie = (int)($_POST['menuId'] ?? 0);
                $nouveauTitreImage = $_POST['creerTitreImage'] ?? "";
                $photoGalerie = null;
                if (isset($_FILES["nouvelleImage"]) && $_FILES["nouvelleImage"]["error"] === UPLOAD_ERR_OK) {
                    if (!is_uploaded_file($_FILES["nouvelleImage"]["tmp_name"])) {
                        throw new Exception("Fichier invalide.");
                    }
                    if ($_FILES["nouvelleImage"]["size"] > 5 * 1024 * 1024) {
                        throw new Exception("L'image ne doit pas dépasser 5 Mo.");
                    }
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $typeReel = $finfo->file($_FILES["nouvelleImage"]["tmp_name"]);
                    if ($typeReel !== "image/png") {
                        throw new Exception("Le fichier doit être une image au format PNG.");
                    }
                    $photoGalerie = file_get_contents($_FILES["nouvelleImage"]["tmp_name"]);
                }
                $nouvelleImage = new Image(null, $nouveauTitreImage, $photoGalerie, $menuIdPourGalerie);
                $imageModele->ajouter($nouvelleImage);
                $_SESSION["messageSucces"] = "La photo a bien été ajouter à la galerie.";
                break;

            case 'supprimerImageMenu':
                $imageIdPourSuppressionGalerie = (int)($_POST['imageId'] ?? 0);
                $imageExistante = $imageModele->rechercherParId($imageIdPourSuppressionGalerie);
                if ($imageExistante === null) {
                    throw new Exception("Image introuvable.");
                }
                $imageModele->supprimer($imageIdPourSuppressionGalerie);
                $_SESSION["messageSucces"] = "La photo a bien été supprimer de la galerie.";
                break;

            
            case 'modifierMenu':
                $menuModifierId = (int)($_POST['menuId'] ?? 0);
                $menuExistant = $menuModele->rechercherParId($menuModifierId);
                if ($menuExistant === null) {
                    throw new Exception("Menu introuvable.");
                }
                $titreMenuModifier = $_POST['modifierTitreMenu'] ?? "";
                $descriptionMenuModifier = $_POST['modifierDescriptionMenu'] ?? "";
                $conditionsMenuModifier = $_POST['modifierConditionMenu'] ?? "";
                $stockMenu = $menuExistant->getStock();
                $conviveMinimumMenuModifier = (int)($_POST['modifierMinimumConviveMenu'] ?? 0);
                $prixMenuModifier = (string)($_POST['modifierPrixMenu'] ?? "");
                $actifMenu = $menuExistant->getActif();
                $themesIdMenuModifier = (int)($_POST['modifierThemeMenu'] ?? 0);
                if ($themeModele->rechercherParId($themesIdMenuModifier) === null) {
                    throw new Exception("Thème sélectionner invalide.");
                }
                $regimeMenuModifier = (int)($_POST['modifierRegimeMenu'] ?? 0);
                if ($regimeModele->rechercherParId($regimeMenuModifier) === null) {
                    throw new Exception("Régime sélectionner invalide.");
                }
                $platsMenuModifierId = $_POST["modifierPlats"] ?? [];
                $MenuModifier = new Menu($menuModifierId, $titreMenuModifier, $descriptionMenuModifier, $conditionsMenuModifier, $conviveMinimumMenuModifier, $stockMenu, $prixMenuModifier, $actifMenu, $themesIdMenuModifier, $regimeMenuModifier);
                $menuModele->modifier($MenuModifier);
                $anciensPlatsMenu = $menuPlatModele->rechercherParMenu($menuModifierId);
                foreach ($anciensPlatsMenu as $platId) {
                    $menuPlatModele->supprimer($menuModifierId, $platId);
                }
                foreach ($platsMenuModifierId as $platMenuId) {
                    $menuPlatModele->ajouter($menuModifierId, (int)$platMenuId);
                }
                $_SESSION["messageSucces"] = "Le menu a bien été modifier.";
                break;

        }
        header("Location: ?page=espacePerso&onglet=menusEmploye");
        exit;
    } catch (Exception $e){
        $toastMessage = $e->getMessage();
        $toastType = "erreur";
    }
}

ob_start();
require __DIR__ . '/../../../Vus/EspacePerso/Employe/ongletMenusEmploye.php';
$contenuOnglet = ob_get_clean();
?>