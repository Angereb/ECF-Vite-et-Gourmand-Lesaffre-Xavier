<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Avis.php";
require_once __DIR__ . "/../Commandes/CommandeModele.php";

class AvisModele extends ModeleBase{
    public function ajouter(Avis $avis): void {
        if (!$this->idExisteDans("commandes", "commandesId", $avis->getCommandesId())){
            throw new Exception("La commande sélectionné n'existe pas.");
        }
        $commandeModele = new CommandeModele();
        $commande = $commandeModele->rechercherParId($avis->getCommandesId());
        $requeteLibelle = $this->pdo->prepare("SELECT libelle FROM statutsCommande WHERE statutsCommandeId = ?");
        $requeteLibelle->execute([$commande->getStatutsCommandeId()]);
        $libelleStatut = $requeteLibelle->fetchColumn();
        if ($libelleStatut !== "Terminée"){
            throw new Exception("Seul une commande terminée peut avoir un avis.");
        }
        // TODO : vérifier que le libellé de statut est exact par rapport à la BDD

        if (!$this->idExisteDans("statutsAvis", "statutsAvisId", $avis->getStatutsAvisId())) {
            throw new Exception("Le statut d'avis sélectionné n'existe pas.");
        }
        if ($this->valeurExisteDeja("avis", "commandesId", $avis->getCommandesId())) {
            throw new Exception("Un avis existe déjà pour cette commande.");
        }
        $requete = $this->pdo->prepare(
        "INSERT INTO avis (titre, note, commentaire, commandesId, statutsAvisId) VALUES (?, ?, ?, ?, ?)");
        $requete->execute([
            $avis->getTitre(),
            $avis->getNote(),
            $avis->getCommentaire(),
            $avis->getCommandesId(),
            $avis->getStatutsAvisId()
        ]);
    }

    public function rechercherParId(int $id): ?Avis {
        $requete = $this->pdo->prepare("SELECT * FROM avis WHERE avisId = ?");
        $requete->execute([$id]);
        $donnee = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnee === false){
            return null;
        }
        $avisId = (int)$donnee["avisId"];
        $note = (int)$donnee["note"];
        $commandesId = (int)$donnee["commandesId"];
        $statutsAvisId = (int)$donnee["statutsAvisId"];
        $avis = new Avis(
            $avisId, $donnee["titre"], $note, $donnee["commentaire"], $commandesId, $statutsAvisId);
        return $avis;
    }

    public function rechercherTousParStatut(int $statutsAvisId): array {
        $avis = [];
        $requete = $this->pdo->prepare("SELECT * FROM avis WHERE statutsAvisId = ? ORDER BY avisId ASC");
        $requete->execute([$statutsAvisId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $avisId = (int)$donnees["avisId"];
            $note = (int)$donnees["note"];
            $commandesId = (int)$donnees["commandesId"];
            $statutsAvisIdRecuperer = (int)$donnees["statutsAvisId"];
            $avis[] = new Avis(
                $avisId, $donnees["titre"], $note, $donnees["commentaire"], $commandesId, $statutsAvisIdRecuperer);
        }
        return $avis;
    }

    public function modifier(Avis $avis): void {
        if ($this->rechercherParId($avis->getAvisId()) === null){
            throw new Exception("L'avis à modifier n'existe pas.");
        }
        $requete = $this->pdo->prepare("UPDATE avis SET titre = ?, note = ?, commentaire = ? WHERE avisId = ?");
        $requete->execute([
            $avis->getTitre(),
            $avis->getNote(),
            $avis->getCommentaire(),
            $avis->getAvisId()
        ]);
    }

    public function modifierStatut(int $avisId, int $statutsAvisId): void {
        if ($this->rechercherParId($avisId) === null){
            throw new Exception("L'avis à modifier n'existe pas.");
        }
        if (!$this->idExisteDans("statutsAvis", "statutsAvisId", $statutsAvisId)) {
            throw new Exception("Le statut d'avis sélectionné n'existe pas.");
        }
        $requete = $this->pdo->prepare("UPDATE avis SET statutsAvisId = ? WHERE avisId = ?");
        $requete->execute([
            $statutsAvisId,
            $avisId
        ]);
    }

    public function supprimer(int $id): void {
        if ($this->rechercherParId($id) === null){
            throw new Exception("L'avis que vous voulez supprimer n'existe pas.");
        }
        try {
            $requete = $this->pdo->prepare("DELETE FROM avis WHERE avisId = ?");
            $requete->execute([$id]);
        } catch (PDOException $e){
            throw new Exception("Impossible de supprimer cet avis.");
        }
    }
}
?>