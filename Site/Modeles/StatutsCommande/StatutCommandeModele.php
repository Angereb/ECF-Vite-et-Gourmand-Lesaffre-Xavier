<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/StatutCommande.php";

class StatutCommandeModele extends ModeleBase {
    public function ajouter(StatutCommande $statutsCommande): void {
        if ($this->valeurExisteDeja("statutsCommande", "libelle", $statutsCommande->getLibelle())){
            throw new Exception("Le statut de commande existe déjà.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO statutsCommande (libelle) VALUES (?)");
        $requete->execute([
            $statutsCommande->getLibelle()
        ]);
    }

    public function rechercherParId(int $id): ?StatutCommande {
        $requete = $this->pdo->prepare("SELECT * FROM statutsCommande WHERE statutsCommandeId = ?");
        $requete->execute([$id]);
        $donnee = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnee === false){
            return null;
        }
        $statutsCommandeId = (int)$donnee["statutsCommandeId"];
        $statutsCommande = new StatutCommande($statutsCommandeId, $donnee["libelle"]);
        return $statutsCommande;
    }

    public function rechercherTous(): array {
        $statutsCommande = [];
        $requete = $this->pdo->prepare("SELECT * FROM statutsCommande ORDER BY libelle ASC");
        $requete->execute();
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $statutsCommandeId = (int)$donnees["statutsCommandeId"];
            $statutsCommande[] = new StatutCommande($statutsCommandeId, $donnees["libelle"]);
        };
        return $statutsCommande;
    }

    public function modifier(StatutCommande $statutsCommande): void {
        if ($this->rechercherParId($statutsCommande->getStatutsCommandeId()) === null) {
            throw new Exception("Le statut de commande à modifier n'existe pas.");
        }
        if ($this->valeurExisteDeja("statutsCommande", "libelle", $statutsCommande->getLibelle(), $statutsCommande->getStatutsCommandeId(), "statutsCommandeId")) {
            throw new Exception("Le statut de commande existe déjà.");
        }
        $requete = $this->pdo->prepare("UPDATE statutsCommande SET libelle = ? WHERE statutsCommandeId = ?");
        $requete->execute([
            $statutsCommande->getLibelle(),
            $statutsCommande->getStatutsCommandeId()
        ]);
    }

    public function supprimer(int $id): void {
        if ($this->rechercherParId($id) === null) {
            throw new Exception("Le statut de commande à supprimer n'existe pas.");
        }
        try {
            $requete = $this->pdo->prepare("DELETE FROM statutsCommande WHERE statutsCommandeId = ?");
            $requete->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Impossible de supprimer ce statut de commande : il est encore utilisé par au moins une commande.");
        }
    }
}
?>