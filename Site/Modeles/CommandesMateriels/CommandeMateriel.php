<?php 
require_once __DIR__ . "/../ModeleBase.php";

class CommandeMateriel extends ModeleBase {
    private function lienExisteDeja(int $commandesId, int $materielsId): bool {
        $requete = $this->pdo->prepare("SELECT COUNT(*) FROM commandesMateriels WHERE commandesId = ? AND materielsId = ?");
        $requete->execute([$commandesId, $materielsId]);
        return $requete->fetchColumn() > 0;
    }

    public function ajouter(int $commandesId, int $materielsId, int $quantite): void {
        if (!$this->idExisteDans("commandes", "commandesId", $commandesId)){
            throw new Exception("La commande sélectionné n'existe pas.");
        }
        if (!$this->idExisteDans("materiels", "materielsId", $materielsId)){
            throw new Exception("Le materiel sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($commandesId, $materielsId)){
            throw new Exception("Cette commande et ce materiel sont déjà associé entre eux.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO commandesMateriels (commandesId, materielsId, quantite) VALUES (?, ?, ?)");
        $requete->execute([
            $commandesId,
            $materielsId,
            $quantite
        ]);
    }

    public function rechercherParCommande(int $commandesId): array {
        $resultats = [];
        $requete = $this->pdo->prepare("SELECT * FROM commandesMateriels WHERE commandesId = ?");
        $requete->execute([$commandesId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $resultats[] = ["materielsId" => (int)$donnees["materielsId"], "quantite" => (int)$donnees["quantite"]];
        }
        return $resultats;
    }

    public function rechercherParMateriel(int $materielsId): array {
        $resultats = [];
        $requete = $this->pdo->prepare("SELECT * FROM commandesMateriels WHERE materielsId = ?");
        $requete->execute([$materielsId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $resultats[] = ["commandesId" => (int)$donnees["commandesId"], "quantite" => (int)$donnees["quantite"]];
        }
        return $resultats;
    }

    public function modifierQuantite(int $commandesId, int $materielsId, int $quantite): void {
        if (!$this->lienExisteDeja($commandesId, $materielsId)){
            throw new Exception("Cette commande et ce materiel ne sont pas déjà associé entre eux.");
        }
        $requete = $this->pdo->prepare("UPDATE commandesMateriels SET quantite = ? WHERE commandesId = ? AND materielsId = ?");
        $requete->execute([
            $quantite,
            $commandesId,
            $materielsId
        ]);
    }

    public function supprimer(int $commandesId, int $materielsId): void {
        if (!$this->lienExisteDeja($commandesId, $materielsId)){
            throw new Exception("Ce materiel et cet commande ne sont pas associé entre eux.");
        }
        $requete = $this->pdo->prepare("DELETE FROM commandesMateriels WHERE commandesId = ? AND materielsId = ?");
        $requete->execute([
            $commandesId,
            $materielsId
        ]);
    }
}
?>