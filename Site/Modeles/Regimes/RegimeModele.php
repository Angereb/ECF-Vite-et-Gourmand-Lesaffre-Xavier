<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Regime.php";

class RegimeModele extends ModeleBase {
    public function ajouter(Regime $regime): void {
        if ($this->valeurExisteDeja("regimes", "libelle", $regime->getLibelle())){
            throw new Exception("Le régime allimentaire existe déjà.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO regimes (libelle) VALUES (?)");
        $requete->execute([
            $regime->getLibelle()
        ]);
    }

    public function rechercherParId(int $id): ?Regime {
        $requete = $this->pdo->prepare("SELECT * FROM regimes WHERE regimesId = ?");
        $requete->execute([$id]);
        $donnee = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnee === false){
            return null;
        }
        $regimesId = (int)$donnee["regimesId"];
        $regime = new Regime($regimesId, $donnee["libelle"]);
        return $regime;
    }

    public function rechercherTous(): array {
        $regimes = [];
        $requete = $this->pdo->prepare("SELECT * FROM regimes ORDER BY libelle ASC");
        $requete->execute();
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $regimesId = (int)$donnees["regimesId"];
            $regimes[] = new Regime($regimesId, $donnees["libelle"]);
        };
        return $regimes;
    }

    public function modifier(Regime $regime): void {
        if ($this->rechercherParId($regime->getRegimesId()) === null) {
            throw new Exception("Le régime allimentaire à modifier n'existe pas.");
        }
        if ($this->valeurExisteDeja("regimes", "libelle", $regime->getLibelle(), $regime->getRegimesId(), "regimesId")) {
            throw new Exception("Le régime allimentaire existe déjà.");
        }
        $requete = $this->pdo->prepare("UPDATE regimes SET libelle = ? WHERE regimesId = ?");
        $requete->execute([
            $regime->getLibelle(),
            $regime->getRegimesId()
        ]);
    }

    public function supprimer(int $id): void {
        if ($this->rechercherParId($id) === null) {
            throw new Exception("Le régime allimentaire à supprimer n'existe pas.");
        }
        try {
            $requete = $this->pdo->prepare("DELETE FROM regimes WHERE regimesId = ?");
            $requete->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Impossible de supprimer ce régime allimenaire : il est encore utilisé par au moins un menu ou un plat.");
        }
    }
}
?>