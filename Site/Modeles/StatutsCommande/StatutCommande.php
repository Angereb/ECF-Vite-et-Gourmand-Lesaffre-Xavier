<?php 
class StatutCommande {
    private ?int $statutsCommandeId;
    private string $libelle;

    public function __construct(?int $statutsCommandeId, string $libelle){
        $this->statutsCommandeId = $statutsCommandeId;
        $this->setLibelle($libelle);
    }

    public function getStatutsCommandeId() : ?int {
        return $this->statutsCommandeId;
    }

    public function getLibelle() : string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void {
        $libelle = trim($libelle);
        if ($libelle === "") {
            throw new Exception("Le libellé du statut de commande ne peut être vide.");
        }
        if (mb_strlen($libelle) > 32) {
            throw new Exception("Le libellé du statut de commande ne peut excéder 32 caractères.");
        }
        $this->libelle = $libelle;
    }
}
?>