<?php 
require_once __DIR__ . "/../ModeleBase.php";

class PlatAllergeneModele extends ModeleBase {
    private function lienExisteDeja(int $platsId, int $allergenesId): bool {
        $requete = $this->pdo->prepare("SELECT COUNT(*) FROM platsAllergenes WHERE platsId = ? AND allergenesId = ?");
        $requete->execute([$platsId, $allergenesId]);
        return $requete->fetchColumn() > 0;
    }

    public function ajouter(int $platsId, int $allergenesId): void {
        if (!$this->idExisteDans("plats", "platsId", $platsId)){
            throw new Exception("Le plat sélectionné n'existe pas.");
        }
        if (!$this->idExisteDans("allergenes", "allergenesId", $allergenesId)){
            throw new Exception("L'allergène sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($platsId, $allergenesId)){
            throw new Exception("Ce plat et cette allergène sont déjà associé entre eux.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO platsAllergenes (platsId, allergenesId) VALUES (?, ?)");
        $requete->execute([
            $platsId,
            $allergenesId
        ]);
    }

    public function rechercherParPlat(int $platsId): array {
        $allergenes = [];
        $requete = $this->pdo->prepare("SELECT * FROM platsAllergenes WHERE platsId = ?");
        $requete->execute([$platsId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $allergenes[] = (int)$donnees["allergenesId"];
        }
        return $allergenes;
    }

    public function rechercherParAllergene(int $allergenesId): array {
        $plats = [];
        $requete = $this->pdo->prepare("SELECT * FROM platsAllergenes WHERE allergenesId = ?");
        $requete->execute([$allergenesId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $plats[] = (int)$donnees["platsId"];
        }
        return $plats;
    }

    public function supprimer(int $platsId, int $allergenesId): void {
        if (!$this->lienExisteDeja($platsId, $allergenesId)){
            throw new Exception("Cet allergène et ce plat ne sont pas associé entre eux.");
        }
        $requete = $this->pdo->prepare("DELETE FROM platsAllergenes WHERE platsId = ? AND allergenesId = ?");
        $requete->execute([
            $platsId,
            $allergenesId
        ]);
    }
}
?>