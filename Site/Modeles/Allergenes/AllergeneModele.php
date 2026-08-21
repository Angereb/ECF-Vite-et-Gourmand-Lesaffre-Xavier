<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Allergene.php";

class AllergeneModele extends ModeleBase {
    public function ajouter(Allergene $allergene): void {
        if ($this->valeurExisteDeja("allergenes", "libelle", $allergene->getLibelle())){
            throw new Exception("Le libellé de l'allergène existe déjà.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO allergenes (libelle) VALUES (?)");
        $requete->execute([
            $allergene->getLibelle()
        ]);
    }

    public function rechercherParId(int $id): ?Allergene {
        $requete = $this->pdo->prepare("SELECT * FROM allergenes WHERE allergenesId = ?");
        $requete->execute([$id]);
        $donnee = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnee === false){
            return null;
        }
        $allergenesId = (int)$donnee["allergenesId"];
        $allergene = new Allergene($allergenesId, $donnee["libelle"]);
        return $allergene;
    }

    public function rechercherTous(): array {
        $allergenes = [];
        $requete = $this->pdo->prepare("SELECT * FROM allergenes ORDER BY libelle ASC");
        $requete->execute();
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $allergenesId = (int)$donnees["allergenesId"];
            $allergenes[] = new Allergene($allergenesId, $donnees["libelle"]);
        };
        return $allergenes;
    }

    public function modifier(Allergene $allergene): void {
        if ($this->rechercherParId($allergene->getAllergenesId()) === null) {
            throw new Exception("L'allergène à modifier n'existe pas.");
        }
        if ($this->valeurExisteDeja("allergenes", "libelle", $allergene->getLibelle(), $allergene->getAllergenesId(), "allergenesId")) {
            throw new Exception("Le libellé de l'allergène existe déjà.");
        }
        $requete = $this->pdo->prepare("UPDATE allergenes SET libelle = ? WHERE allergenesId = ?");
        $requete->execute([
            $allergene->getLibelle(),
            $allergene->getAllergenesId()
        ]);
    }

    public function supprimer(int $id): void {
        if ($this->rechercherParId($id) === null) {
            throw new Exception("L'allergène à supprimer n'existe pas.");
        }
        try {
            $requete = $this->pdo->prepare("DELETE FROM allergenes WHERE allergenesId = ?");
            $requete->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Impossible de supprimer cet allergène : il est encore utilisé par au moins un plat.");
        }
    }
}
?>