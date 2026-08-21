<?php 
class StatutAvis {
    private ?int $statutsAvisId;
    private string $libelle;

    public function __construct(?int $statutsAvisId, string $libelle){
        $this->statutsAvisId = $statutsAvisId;
        $this->setLibelle($libelle);
    }

    public function getStatutsAvisId() : ?int {
        return $this->statutsAvisId;
    }

    public function getLibelle() : string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void {
        $libelle = trim($libelle);
        if ($libelle === "") {
            throw new Exception("Le libellé du statut d'un avis ne peut être vide.");
        }
        if (mb_strlen($libelle) > 32) {
            throw new Exception("Le libellé du statut d'un avis ne peut excéder 32 caractères.");
        }
        $this->libelle = $libelle;
    }
}
?>