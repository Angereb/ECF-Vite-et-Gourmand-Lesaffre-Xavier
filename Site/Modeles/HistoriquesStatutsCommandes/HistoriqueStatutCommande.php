<?php 
class HistoriqueStatutCommande {
    private ?int $historiquesStatutsCommandesId;
    private ?DateTime $dateModification;
    private ?string $motif;
    private ?string $modeContact;
    private int $commandesId;
    private int $statutsCommandeId;

    public function __construct(?int $historiquesStatutsCommandesId, ?DateTime $dateModification, ?string $motif, ?string $modeContact, int $commandesId, int $statutsCommandeId){
        $this->historiquesStatutsCommandesId = $historiquesStatutsCommandesId;
        $this->dateModification = $dateModification;
        $this->setMotif($motif);
        $this->setModeContact($modeContact);
        $this->setCommandesId($commandesId);
        $this->setStatutsCommandeId($statutsCommandeId);
    }

    public function getHistoriquesStatutsCommandesId(): ?int {
        return $this->historiquesStatutsCommandesId;
    }
    
    public function getDateModification(): ?DateTime {
        return $this->dateModification;
    }

    public function getMotif(): ?string {
        return $this->motif;
    }

    public function setMotif(?string $motif): void {
        if ($motif === null) {
            $this->motif = null;
            return;
        }
        $motif = trim($motif);
        if ($motif === "") {
            $this->motif = null;
            return;
        }
        if (mb_strlen($motif) > 2500){
            throw new Exception("Le motif de modification d'une commande ne peut dépasser 2500 caractères.");
        }
        $this->motif = $motif;
    }

    public function getModeContact(): ?string {
        return $this->modeContact;
    }

    public function setModeContact(?string $modeContact): void {
        if ($modeContact === null) {
            $this->modeContact = null;
            return;
        }
        $modeContact = trim($modeContact);
        if ($modeContact === "") {
            $this->modeContact = null;
            return;
        }
        if (mb_strlen($modeContact) > 32){
            throw new Exception("Le mode de contact ne peut dépasser 32 caractères.");
        }
        $this->modeContact = $modeContact;
    }

    public function getCommandesId(): int {
        return $this->commandesId;
    }

    public function setCommandesId(int $commandesId): void {
        if ($commandesId <1) {
            throw new Exception("L'historique de statut de commande doit être lié à une commande valide.");
        }
        $this->commandesId = $commandesId;
    }

    public function getStatutsCommandeId(): int {
        return $this->statutsCommandeId;
    }

    public function setStatutsCommandeId(int $statutsCommandeId): void {
        if ($statutsCommandeId < 1){
            throw new Exception("L'historique de statut de commande doit être lié à un statut de commande valide.");
        }
        $this->statutsCommandeId = $statutsCommandeId;
    }
}
?>