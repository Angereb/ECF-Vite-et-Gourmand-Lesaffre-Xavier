<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/HistoriqueStatutCommande.php";

class HistoriqueStatutCommandeModele extends ModeleBase {
    public function ajouter(HistoriqueStatutCommande $historiqueStatutCommande): void {
        if (!$this->idExisteDans("commandes", "commandesId", $historiqueStatutCommande->getCommandesId())){
            throw new Exception("La commande sélectionné n'existe pas.");
        }
        if (!$this->idExisteDans("statutsCommande", "statutsCommandeId", $historiqueStatutCommande->getStatutsCommandeId())){
            throw new Exception("Le statut de commande sélectionné n'exsite pas.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO historiquesStatutsCommandes (motif, modeContact, commandesId, statutsCommandeId) VALUES (?, ?, ?, ?)");
        $requete->execute([
            $historiqueStatutCommande->getMotif(),
            $historiqueStatutCommande->getModeContact(),
            $historiqueStatutCommande->getCommandesId(),
            $historiqueStatutCommande->getStatutsCommandeId()
        ]);
    }

    public function rechercherParId(int $id): ?HistoriqueStatutCommande {
        $requete = $this->pdo->prepare("SELECT * FROM historiquesStatutsCommandes WHERE historiquesStatutsCommandesId = ?");
        $requete->execute([$id]);
        $donnee = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnee === false){
            return null;
        }
        $historiquesStatutsCommandesId = (int)$donnee["historiquesStatutsCommandesId"];
        $dateModification = new DateTime($donnee["dateModification"]);
        $commandesId = (int)$donnee["commandesId"];
        $statutsCommandeId = (int)$donnee["statutsCommandeId"];
        $historiqueStatutCommande = new HistoriqueStatutCommande(
            $historiquesStatutsCommandesId, $dateModification, $donnee["motif"], $donnee["modeContact"], $commandesId, $statutsCommandeId);
        return $historiqueStatutCommande;
    }

    public function rechercherTousParCommande(int $commandesId): array {
        $historiquesStatutsCommandes = [];
        $requete = $this->pdo->prepare("SELECT * FROM historiquesStatutsCommandes WHERE commandesId = ? ORDER BY dateModification DESC");
        $requete->execute([$commandesId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $historiquesStatutsCommandesId = (int)$donnees["historiquesStatutsCommandesId"];
            $dateModification = new DateTime($donnees["dateModification"]);
            $commandesIdRecuperer = (int)$donnees["commandesId"];
            $statutsCommandeId = (int)$donnees["statutsCommandeId"];
            $historiquesStatutsCommandes[] = new HistoriqueStatutCommande(
                $historiquesStatutsCommandesId, $dateModification, $donnees["motif"], $donnees["modeContact"], $commandesIdRecuperer, $statutsCommandeId);
        }
        return $historiquesStatutsCommandes;
    }

    public function modifier(HistoriqueStatutCommande $historiqueStatutCommande): void {
        if ($this->rechercherParId($historiqueStatutCommande->getHistoriquesStatutsCommandesId()) === null){
            throw new Exception("L'historique de statut de commande sélectionner n'existe pas");
        }
        if (!$this->idExisteDans("statutsCommande", "statutsCommandeId", $historiqueStatutCommande->getStatutsCommandeId())){
            throw new Exception("Le statut de commande sélectionné n'exsite pas.");
        }
        $requete = $this->pdo->prepare("UPDATE historiquesStatutsCommandes SET motif = ?, modeContact = ?, statutsCommandeId = ? WHERE historiquesStatutsCommandesId = ?");
        $requete->execute([
            $historiqueStatutCommande->getMotif(),
            $historiqueStatutCommande->getModeContact(),
            $historiqueStatutCommande->getStatutsCommandeId(),
            $historiqueStatutCommande->getHistoriquesStatutsCommandesId()
        ]);
    }

    public function supprimer(int $id): void {
        if ($this->rechercherParId($id) === null){
            throw new Exception("L'historique de statut de commande sélectionner n'existe pas");
        }
        try {
            $requete = $this->pdo->prepare("DELETE FROM historiquesStatutsCommandes WHERE historiquesStatutsCommandesId = ?");
            $requete->execute([$id]);
        } catch (PDOException $e){
            throw new Exception("Impossible de supprimer cette partie de l'historique de statut de commande.");
        }
    }
}
?>