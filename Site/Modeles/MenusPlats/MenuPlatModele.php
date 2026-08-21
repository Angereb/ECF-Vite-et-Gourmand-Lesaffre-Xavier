<?php 
require_once __DIR__ . "/../ModeleBase.php";

class MenuPlatModele extends ModeleBase {
    private function lienExisteDeja(int $menusId, int $platsId): bool {
        $requete = $this->pdo->prepare("SELECT COUNT(*) FROM menusPlats WHERE menusId = ? AND platsId = ?");
        $requete->execute([$menusId, $platsId]);
        return $requete->fetchColumn() > 0;
    }

    public function ajouter(int $menusId, int $platsId) : void {
        if (!$this->idExisteDans("menus", "menusId", $menusId)) {
            throw new Exception("Le menu sélectionné n'exsite pas.");
        }
        if (!$this->idExisteDans("plats", "platsId", $platsId)) {
            throw new Exception("Le plat sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($menusId, $platsId)) {
            throw new Exception("Ce plat et ce menu sont déjà associé entre eux.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO menusPlats (menusId, platsId) VALUES (?, ?)");
        $requete->execute([
            $menusId,
            $platsId
        ]);
    }

    public function rechercherParMenu(int $menusId) : array {
        $plats = [];
        $requete = $this->pdo->prepare("SELECT * FROM menusPlats WHERE menusId = ?");
        $requete->execute([$menusId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $plats[] = (int)$donnees["platsId"];
        }
        return $plats;
    }

    public function rechercherParPlat(int $platsId) : array {
        $menus = [];
        $requete = $this->pdo->prepare("SELECT * FROM menusPlats WHERE platsId = ?");
        $requete->execute([$platsId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $menus[] = (int)$donnees["menusId"];
        }
        return $menus;
    }

    public function supprimer(int $menusId, int $platsId) : void {
        if (!$this->lienExisteDeja($menusId, $platsId)) {
            throw new Exception("Ce plat et ce menu ne sont pas associé entre eux.");
        }
        $requete = $this->pdo->prepare("DELETE FROM menusPlats WHERE menusId = ? AND platsId = ?");
        $requete->execute([
            $menusId,
            $platsId
        ]);
    }
}
?>