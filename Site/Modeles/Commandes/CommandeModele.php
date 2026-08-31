<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Commande.php";
require_once __DIR__ . "/../Menus/Menu.php";
require_once __DIR__ . "/../Menus/MenuModele.php";
require_once __DIR__ . "/../HistoriquesStatutsCommandes/HistoriqueStatutCommande.php";
require_once __DIR__ . "/../HistoriquesStatutsCommandes/HistoriqueStatutCommandeModele.php";

class CommandeModele extends ModeleBase {
    private const CODES_POSTAUX_BORDEAUX = ["33000", "33100", "33200", "33300", "33800"];

    public function calculerFraisLivraison(string $codePostal) : float {
        if (in_array($codePostal, self::CODES_POSTAUX_BORDEAUX, true)) {
            return 0.0;
        }
        return 5.0;
    }

    public function calculerFacture(Menu $menu, string $codePostal, int $convive) : string {
        $prixLivraison = $this->calculerFraisLivraison($codePostal);
        $prixParPersonne = bcdiv($menu->getPrix(), (string)$menu->getMinimumConvive(), 4);
        $prixMenuBrut = bcmul($prixParPersonne, (string)$convive, 4);
        $tauxReduction = ($convive >= ($menu->getMinimumConvive() + 5)) ? "0.10" : "0.00";
        $reduction = bcmul($prixMenuBrut, $tauxReduction, 2);
        $prixMenuFinal = bcsub($prixMenuBrut, $reduction, 2);
        $facture = bcadd($prixMenuFinal, (string)$prixLivraison, 2);
        return $facture;
    }

    public function verifierStock(Menu $menu, int $convive): bool {
        $stockNecessaire = (int)ceil($convive / $menu->getMinimumConvive());
        return $menu->getStock() >= $stockNecessaire;
    }

    public function verifierMinimumConvive(Menu $menu, int $convive): bool {
        return $convive >= $menu->getMinimumConvive();
    }

    public function ajouter(Commande $commande, Menu $menu) : int {
        if (!$this->idExisteDans("utilisateurs", "utilisateursId", $commande->getUtilisateursId())){
            throw new Exception("L'utilisateur sélectionné n'existe pas.");
        }
        if (!$this->idExisteDans("menus", "menusId", $commande->getMenusId())){
            throw new Exception("Le menu sélectionné n'existe pas.");
        }
        if (!$this->idExisteDans("statutsCommande", "statutsCommandeId", $commande->getStatutsCommandeId())){
            throw new Exception("Le statut de la commande sélectionné n'existe pas.");
        }
        if (!$this->verifierMinimumConvive($menu, $commande->getConvive())) {
            throw new Exception("Le nombre de convives est inférieur au minimum requis pour ce menu.");
        }
        if (!$this->verifierStock($menu, $commande->getConvive())) {
            throw new Exception("Le stock disponible est insuffisant pour ce nombre de convives.");
        }
        $facture = $this->calculerFacture($menu, $commande->getCodePostal(), $commande->getConvive());
        $this->pdo->beginTransaction();
        try {
            $requete = $this->pdo->prepare(
                "INSERT INTO commandes (adresse, codePostal, datePrestation, heureLivraison, dateLivraison, convive, facture, utilisateursId, menusId, statutsCommandeId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $requete->execute([
                $commande->getAdresse(),
                $commande->getCodePostal(),
                $commande->getDatePrestation()->format("Y-m-d"),
                $commande->getHeureLivraison(),
                $commande->getDateLivraison()->format("Y-m-d"),
                $commande->getConvive(),
                $facture,
                $commande->getUtilisateursId(),
                $commande->getMenusId(),
                $commande->getStatutsCommandeId()
            ]);
            $nouvelleCommandeId = (int)$this->pdo->lastInsertId();
            $historique = new HistoriqueStatutCommande(null, null, null, null, $nouvelleCommandeId, $commande->getStatutsCommandeId());
            $historiqueModele = new HistoriqueStatutCommandeModele();
            $historiqueModele->ajouter($historique);
            $this->pdo->commit();
            return $nouvelleCommandeId;
        } catch (Exception $e){
            $this->pdo->rollBack();
            throw new Exception("Erreur lors de la création de la commande : " . $e->getMessage());
        } 
    }
    
    public function rechercherParId(int $id): ?Commande {
        $requete = $this->pdo->prepare("SELECT * FROM commandes WHERE commandesId = ?");
        $requete->execute([$id]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            return null;
        }
        $commandesId = (int)$donnees["commandesId"];
        $datePrestation = new DateTime($donnees["datePrestation"]);
        $dateLivraison = new DateTime($donnees["dateLivraison"]);
        $convive = (int)$donnees["convive"];
        $utilisateursId = (int)$donnees["utilisateursId"];
        $menusId = (int)$donnees["menusId"];
        $statutsCommandeId = (int)$donnees["statutsCommandeId"];
        $commande = new Commande(
            $commandesId, $donnees["adresse"], $donnees["codePostal"], $datePrestation, $donnees["heureLivraison"], $dateLivraison, $convive, $donnees["facture"], $utilisateursId, $menusId, $statutsCommandeId, true);
        return $commande;
    }

    public function rechercherFiltrer(?int $utilisateursId = null, ?int $statutsCommandeId = null, ?int $menusId = null, ?DateTime $dateDebut = null, ?DateTime $dateFin = null): array {
        $commandes = [];
        $conditions = [];
        $valeurs = [];
        if ($utilisateursId !== null) {
            $conditions[] = "utilisateursId = ?";
            $valeurs[] = $utilisateursId;
        }
        if ($statutsCommandeId !== null) {
            $conditions[] = "statutsCommandeId = ?";
            $valeurs[] = $statutsCommandeId;
        }
        if ($menusId !== null) {
            $conditions[] = "menusId = ?";
            $valeurs[] = $menusId;
        }
        if ($dateDebut !== null) {
            $conditions[] = "datePrestation >= ?";
            $valeurs[] = $dateDebut->format("Y-m-d");
        }
        if ($dateFin !== null) {
            $conditions[] = "datePrestation <= ?";
            $valeurs[] = $dateFin->format("Y-m-d");
        }
        $sql = "SELECT * FROM commandes";
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $requete = $this->pdo->prepare($sql);
        $requete->execute($valeurs);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $commandesId = (int)$donnees["commandesId"];
            $datePrestation = new DateTime($donnees["datePrestation"]);
            $dateLivraison = new DateTime($donnees["dateLivraison"]);
            $convive = (int)$donnees["convive"];
            $utilisateursIdLigne = (int)$donnees["utilisateursId"];
            $menusIdLigne = (int)$donnees["menusId"];
            $statutsCommandeIdLigne = (int)$donnees["statutsCommandeId"];
            $commandes[] = new Commande(
                $commandesId, $donnees["adresse"], $donnees["codePostal"], $datePrestation, $donnees["heureLivraison"], $dateLivraison, $convive, $donnees["facture"], $utilisateursIdLigne, $menusIdLigne, $statutsCommandeIdLigne, true);
        }
        return $commandes;
    }

    public function modifier(Commande $commande, Menu $menu): void {
        if ($this->rechercherParId($commande->getCommandesId()) === null) {
            throw new Exception("La commande à modifier n'existe pas.");
        }
        if (!$this->verifierMinimumConvive($menu, $commande->getConvive())) {
            throw new Exception("Le nombre de convives est inférieur au minimum requis pour ce menu.");
        }
        if (!$this->verifierStock($menu, $commande->getConvive())) {
            throw new Exception("Le stock disponible est insuffisant pour ce nombre de convives.");
        }
        $facture = $this->calculerFacture($menu, $commande->getCodePostal(), $commande->getConvive());
        $requete = $this->pdo->prepare("UPDATE commandes SET adresse = ?, codePostal = ?, datePrestation = ?, heureLivraison = ?, dateLivraison = ?, convive = ?, facture = ? WHERE commandesId = ?");
        $requete->execute([
            $commande->getAdresse(),
            $commande->getCodePostal(),
            $commande->getDatePrestation()->format("Y-m-d"),
            $commande->getHeureLivraison(),
            $commande->getDateLivraison()->format("Y-m-d"),
            $commande->getConvive(),
            $facture,
            $commande->getCommandesId()
        ]);
    }

    public function modifierStatut(int $commandesId, int $statutsCommandeId, ?string $motif = null, ?string $modeContact = null): void {
        $commande = $this->rechercherParId($commandesId);
        if ($commande === null) {
            throw new Exception("La commande à modifier n'existe pas.");
        }
        if (!$this->idExisteDans("statutsCommande", "statutsCommandeId", $statutsCommandeId)){
            throw new Exception("Le statut de la commande sélectionné n'existe pas.");
        }
        $requeteAncienLibelle = $this->pdo->prepare("SELECT libelle FROM statutsCommande WHERE statutsCommandeId = ?");
        $requeteAncienLibelle->execute([$commande->getStatutsCommandeId()]);
        $ancienLibelle = $requeteAncienLibelle->fetchColumn();
        $requeteNouveauLibelle = $this->pdo->prepare("SELECT libelle FROM statutsCommande WHERE statutsCommandeId = ?");
        $requeteNouveauLibelle->execute([$statutsCommandeId]);
        $nouveauLibelle = $requeteNouveauLibelle->fetchColumn();
        $statutsNecessitantJustification = ["Annulée"];
        if (in_array($nouveauLibelle, $statutsNecessitantJustification, true)) {
            if ($motif === null || $modeContact === null) {
                throw new Exception("Un motif et un mode de contact sont obligatoires pour ce changement de statut.");
            }
        }
        $this->pdo->beginTransaction();
        try {
            $requete = $this->pdo->prepare("UPDATE commandes SET statutsCommandeId = ? WHERE commandesId = ?");
            $requete->execute([$statutsCommandeId, $commandesId]);
            $historique = new HistoriqueStatutCommande(null, null, $motif, $modeContact, $commandesId, $statutsCommandeId);
            $historiqueModele = new HistoriqueStatutCommandeModele();
            $historiqueModele->ajouter($historique);
            $menuModele = new MenuModele();
            $menu = $menuModele->rechercherParId($commande->getMenusId());
            $quantiteConcernee = (int)ceil($commande->getConvive() / $menu->getMinimumConvive());
            if ($nouveauLibelle === "Accepté") {
                $menuModele->modifierStock($menu->getMenusId(), $menu->getStock() - $quantiteConcernee);
            }
            if ($ancienLibelle === "Accepté" && $nouveauLibelle === "Annulée") {
                $menuModele->modifierStock($menu->getMenusId(), $menu->getStock() + $quantiteConcernee);
            }
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Erreur lors de la modification du statut : " . $e->getMessage());
        }
    }

}