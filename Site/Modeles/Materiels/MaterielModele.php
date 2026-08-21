<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Materiel.php";

class MaterielModele extends ModeleBase {
    public function ajouter(Materiel $materiel): void {
        if ($this->valeurExisteDeja("materiels", "libelle", $materiel->getLibelle())){
            throw new Exception("Le matériel existe déjà.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO materiels (libelle) VALUES (?)");
        $requete->execute([
            $materiel->getLibelle()
        ]);
    }

    public function rechercherParId(int $id): ?Materiel {
        $requete = $this->pdo->prepare("SELECT * FROM materiels WHERE materielsId = ?");
        $requete->execute([$id]);
        $donnee = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnee === false){
            return null;
        }
        $materielsId = (int)$donnee["materielsId"];
        $materiel = new Materiel($materielsId, $donnee["libelle"]);
        return $materiel;
    }

    public function rechercherTous(): array {
        $materiels = [];
        $requete = $this->pdo->prepare("SELECT * FROM materiels ORDER BY libelle ASC");
        $requete->execute();
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $materielsId = (int)$donnees["materielsId"];
            $materiels[] = new Materiel($materielsId, $donnees["libelle"]);
        };
        return $materiels;
    }

    public function modifier(Materiel $materiel): void {
        if ($this->rechercherParId($materiel->getMaterielsId()) === null) {
            throw new Exception("Le matériel à modifier n'existe pas.");
        }
        if ($this->valeurExisteDeja("materiels", "libelle", $materiel->getLibelle(), $materiel->getMaterielsId(), "materielsId")) {
            throw new Exception("Le matériel existe déjà.");
        }
        $requete = $this->pdo->prepare("UPDATE materiels SET libelle = ? WHERE materielsId = ?");
        $requete->execute([
            $materiel->getLibelle(),
            $materiel->getMaterielsId()
        ]);
    }

    public function supprimer(int $id): void {
        if ($this->rechercherParId($id) === null) {
            throw new Exception("Le matériel à supprimer n'existe pas.");
        }
        try {
            $requete = $this->pdo->prepare("DELETE FROM materiels WHERE materielsId = ?");
            $requete->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Impossible de supprimer ce materiel : il est encore utilisé par au moins une commande.");
        }
    }
}
?>