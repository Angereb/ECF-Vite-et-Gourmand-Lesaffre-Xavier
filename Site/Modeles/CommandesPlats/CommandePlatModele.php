<?php 
require_once __DIR__ . "/../ModeleBase.php";

class CommandePlatModeleModele extends ModeleBase {
    private function lienExisteDeja(int $commandesId, int $platsId): bool {
        $requete = $this->pdo->prepare("SELECT COUNT(*) FROM commandesPlats WHERE commandesId = ? AND platsId = ?");
        $requete->execute([$commandesId, $platsId]);
        return $requete->fetchColumn() > 0;
    }

    public function ajouter(int $commandesId, int $platsId): void {
        if (!$this->idExisteDans("commandes", "commandesId", $commandesId)){
            throw new Exception("La commande sélectionné n'existe pas.");
        }
        if (!$this->idExisteDans("plats", "platsId", $platsId)){
            throw new Exception("Le plat sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($commandesId, $platsId)){
            throw new Exception("Cette commande et ce plat sont déjà associé entre eux.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO commandesPlats (commandesId, platsId) VALUES (?, ?)");
        $requete->execute([
            $commandesId,
            $platsId
        ]);
    }

    public function rechercherParCommande(int $commandesId): array {
        $plats = [];
        $requete = $this->pdo->prepare("SELECT * FROM commandesPlats WHERE commandesId = ?");
        $requete->execute([$commandesId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $plats[] = (int)$donnees["platsId"];
        }
        return $plats;
    }

    public function rechercherParPlat(int $platsId): array {
        $commandes = [];
        $requete = $this->pdo->prepare("SELECT * FROM commandesPlats WHERE platsId = ?");
        $requete->execute([$platsId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $commandes[] = (int)$donnees["commandesId"];
        }
        return $commandes;
    }

    public function supprimer(int $commandesId, int $platsId): void {
        if (!$this->lienExisteDeja($commandesId, $platsId)){
            throw new Exception("Ce plat et cet commande ne sont pas associé entre eux.");
        }
        $requete = $this->pdo->prepare("DELETE FROM commandesPlats WHERE commandesId = ? AND platsId = ?");
        $requete->execute([
            $commandesId,
            $platsId
        ]);
    }
}
?>