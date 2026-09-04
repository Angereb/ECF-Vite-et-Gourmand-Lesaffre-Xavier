<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/StatutAvis.php";

class StatutAvisModele extends ModeleBase {
    public function ajouter(StatutAvis $statutsAvis): void {
        if ($this->valeurExisteDeja("statutsAvis", "libelle", $statutsAvis->getLibelle())){
            throw new Exception("Le statut de l'avis existe déjà.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO statutsAvis (libelle) VALUES (?)");
        $requete->execute([
            $statutsAvis->getLibelle()
        ]);
    }

    public function rechercherParId(int $id): ?StatutAvis {
        $requete = $this->pdo->prepare("SELECT * FROM statutsAvis WHERE statutsAvisId = ?");
        $requete->execute([$id]);
        $donnee = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnee === false){
            return null;
        }
        $statutsAvisId = (int)$donnee["statutsAvisId"];
        $statutsAvis = new StatutAvis($statutsAvisId, $donnee["libelle"]);
        return $statutsAvis;
    }

    public function rechercherParLibelle(string $libelle): ?StatutAvis {
        $requete = $this->pdo->prepare("SELECT * FROM statutsAvis WHERE libelle = ?");
        $requete->execute([$libelle]);
        $donnee = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnee === false){
            return null;
        }
        $statutsAvisId = (int)$donnee["statutsAvisId"];
        $statutsAvis = new StatutAvis($statutsAvisId, $donnee["libelle"]);
        return $statutsAvis;
    }

    public function rechercherTous(): array {
        $statutsAvis = [];
        $requete = $this->pdo->prepare("SELECT * FROM statutsAvis ORDER BY libelle ASC");
        $requete->execute();
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $statutsAvisId = (int)$donnees["statutsAvisId"];
            $statutsAvis[] = new StatutAvis($statutsAvisId, $donnees["libelle"]);
        };
        return $statutsAvis;
    }

    public function modifier(StatutAvis $statutsAvis): void {
        if ($this->rechercherParId($statutsAvis->getStatutsAvisId()) === null) {
            throw new Exception("Le statut pour les avis à modifier n'existe pas.");
        }
        if ($this->valeurExisteDeja("statutsAvis", "libelle", $statutsAvis->getLibelle(), $statutsAvis->getStatutsAvisId(), "statutsAvisId")) {
            throw new Exception("Le statut de l'avis existe déjà.");
        }
        $requete = $this->pdo->prepare("UPDATE statutsAvis SET libelle = ? WHERE statutsAvisId = ?");
        $requete->execute([
            $statutsAvis->getLibelle(),
            $statutsAvis->getStatutsAvisId()
        ]);
    }

    public function supprimer(int $id): void {
        if ($this->rechercherParId($id) === null) {
            throw new Exception("Le statut pour les avis n'existe pas.");
        }
        try {
            $requete = $this->pdo->prepare("DELETE FROM statutsAvis WHERE statutsAvisId = ?");
            $requete->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Impossible de supprimer ce statuts d'avis : il est encore utilisé par au moins un avis.");
        }
    }
}
?>