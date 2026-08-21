<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Theme.php";

class ThemeModele extends ModeleBase {
    public function ajouter(Theme $theme): void {
        if ($this->valeurExisteDeja("themes", "libelle", $theme->getLibelle())){
            throw new Exception("Le libellé du thème existe déjà.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO themes (libelle) VALUES (?)");
        $requete->execute([
            $theme->getLibelle()
        ]);
    }

    public function rechercherParId(int $id): ?Theme {
        $requete = $this->pdo->prepare("SELECT * FROM themes WHERE themesId = ?");
        $requete->execute([$id]);
        $donnee = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnee === false){
            return null;
        }
        $themesId = (int)$donnee["themesId"];
        $theme = new Theme($themesId, $donnee["libelle"]);
        return $theme;
    }

    public function rechercherTous(): array {
        $themes = [];
        $requete = $this->pdo->prepare("SELECT * FROM themes ORDER BY libelle ASC");
        $requete->execute();
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $themesId = (int)$donnees["themesId"];
            $themes[] = new Theme($themesId, $donnees["libelle"]);
        };
        return $themes;
    }

    public function modifier(Theme $theme): void {
        if ($this->rechercherParId($theme->getThemesId()) === null) {
            throw new Exception("Le thème à modifier n'existe pas.");
        }
        if ($this->valeurExisteDeja("themes", "libelle", $theme->getLibelle(), $theme->getThemesId(), "themesId")) {
            throw new Exception("Le libellé du thème existe déjà.");
        }
        $requete = $this->pdo->prepare("UPDATE themes SET libelle = ? WHERE themesId = ?");
        $requete->execute([
            $theme->getLibelle(),
            $theme->getThemesId()
        ]);
    }

    public function supprimer(int $id): void {
        if ($this->rechercherParId($id) === null) {
            throw new Exception("Le thème à supprimer n'existe pas.");
        }
        try {
            $requete = $this->pdo->prepare("DELETE FROM themes WHERE themesId = ?");
            $requete->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Impossible de supprimer ce thème : il est encore utilisé par au moins un menu.");
        }
    }
}
?>