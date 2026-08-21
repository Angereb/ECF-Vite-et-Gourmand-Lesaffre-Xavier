<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Menu.php";

class MenuModele extends ModeleBase {
    public function ajouter(Menu $menu) : void {
        if (!$this->idExisteDans("themes", "themesId", $menu->getThemesId())) {
            throw new Exception("Le thème sélectionné n'existe pas.");
        }
        if (!$this->idExisteDans("regimes", "regimesId", $menu->getRegimesId())) {
            throw new Exception("Le régime sélectionné n'existe pas.");
        }
        if ($this->valeurExisteDeja("menus", "titre", $menu->getTitre())){
            throw new Exception("Ce titre de menu est déjà utiliser.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO menus (titre, descriptions, conditions, minimumConvive, stock, prix, actif, themesId, regimesId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $requete->execute([
            $menu->getTitre(),
            $menu->getDescriptions(),
            $menu->getConditions(),
            $menu->getMinimumConvive(),
            $menu->getStock(),
            $menu->getPrix(),
            $menu->getActif(),
            $menu->getThemesId(),
            $menu->getRegimesId(),
        ]);
    }

    public function rechercherParId(int $id): ?Menu {
        $requete = $this->pdo->prepare("SELECT * FROM menus WHERE menusId = ?");
        $requete->execute([$id]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            return null;
        }
        $menusId = (int)$donnees["menusId"];
        $minimumConvive = (int)$donnees["minimumConvive"];
        $stock = (int)$donnees["stock"];
        $actif = (bool)$donnees["actif"]; 
        $themesId = (int)$donnees["themesId"];
        $regimesId = (int)$donnees["regimesId"];
        $menu = new Menu(
            $menusId, $donnees["titre"], $donnees["descriptions"], $donnees["conditions"], $minimumConvive, $stock, $donnees["prix"], $actif, $themesId, $regimesId);
        return $menu;
    }

    public function rechercherFiltrer(?float $prixMax = null, ?float $prixMin = null, ?int $themesId = null, ?int $regimesId = null, ?int $convivesMin = null): array {
        $menus = [];
        $conditions = ["actif = 1"];
        $valeurs = [];
        if ($prixMax !== null) {
            $conditions[] = "prix <= ?";
            $valeurs[] = $prixMax;
        }
        if ($prixMin !== null) {
            $conditions[] = "prix >= ?";
            $valeurs[] = $prixMin;
        }
        if ($themesId !== null) {
            $conditions[] = "themesId = ?";
            $valeurs[] = $themesId;
        }
        if ($regimesId !== null) {
            $conditions[] = "regimesId = ?";
            $valeurs[] = $regimesId;
        }
        if ($convivesMin !== null) {
            $conditions[] = "minimumConvive <= ?";
            $valeurs[] = $convivesMin;
        }
        $sql = "SELECT * FROM menus";
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $requete = $this->pdo->prepare($sql);
        $requete->execute($valeurs);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $menusId = (int)$donnees["menusId"];
            $minimumConvive = (int)$donnees["minimumConvive"];
            $stock = (int)$donnees["stock"];
            $actif = (bool)$donnees["actif"];
            $menuThemesId = (int)$donnees["themesId"];
            $menuRegimesId = (int)$donnees["regimesId"];
            $menus[] = new Menu(
                $menusId, $donnees["titre"], $donnees["descriptions"], $donnees["conditions"], $minimumConvive, $stock, $donnees["prix"], $actif, $menuThemesId, $menuRegimesId);
            }
        return $menus;
    }

    public function modifier(Menu $menu): void {
        if ($menu->getMenusId() === null) {
            throw new Exception("Impossible de modifier un menu inexistant.");
        }
        if ($this->rechercherParId($menu->getMenusId()) === null) {
            throw new Exception("Le menu à modifier n'existe pas.");
        }
        if (!$this->idExisteDans("themes", "themesId", $menu->getThemesId())) {
            throw new Exception("Le thème sélectionné n'existe pas.");
        }
        if (!$this->idExisteDans("regimes", "regimesId", $menu->getRegimesId())) {
            throw new Exception("Le régime sélectionné n'existe pas.");
        }
        if ($this->valeurExisteDeja("menus", "titre", $menu->getTitre(), $menu->getMenusId(), "menusId")){
            throw new Exception("Ce titre de menu est déjà utiliser.");
        }
        $requete = $this->pdo->prepare("UPDATE menus SET titre = ?, descriptions = ?, conditions = ?, minimumConvive = ?, stock = ?, prix = ?, actif = ?, themesId = ?, regimesId = ? WHERE menusId = ?");
        $requete->execute([
            $menu->getTitre(),
            $menu->getDescriptions(),
            $menu->getConditions(),
            $menu->getMinimumConvive(),
            $menu->getStock(),
            $menu->getPrix(),
            $menu->getActif(),
            $menu->getThemesId(),
            $menu->getRegimesId(),
            $menu->getMenusId(),
        ]);
    }

    public function modifierStock(int $menusId, int $nouveauStock): void {
        if ($this->rechercherParId($menusId) === null) {
            throw new Exception("Le menu à modifier n'existe pas.");
        }
        if ($nouveauStock < 0) {
            throw new Exception("Le stock ne peut être négatif.");
        }
        $requete = $this->pdo->prepare("UPDATE menus SET stock = ? WHERE menusId = ?");
        $requete->execute([$nouveauStock, $menusId]);
    }

    public function modifierActif(int $menusId, bool $actif): void {
        if ($this->rechercherParId($menusId) === null) {
            throw new Exception("Le menu à modifier n'existe pas.");
        }
        $requete = $this->pdo->prepare("UPDATE menus SET actif = ? WHERE menusId = ?");
        $requete->execute([
            $actif,
            $menusId
        ]);
    }
}
?>