<?php 
class Regime {
    private ?int $regimesId;
    private string $libelle;

    public function __construct(?int $regimesId, string $libelle){
        $this->regimesId = $regimesId;
        $this->setLibelle($libelle);
    }

    public function getRegimesId() : ?int {
        return $this->regimesId;
    }

    public function getLibelle() : string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void {
        $libelle = trim($libelle);
        if ($libelle === "") {
            throw new Exception("Le libellé du régime allimentaire ne peut être vide.");
        }
        if (mb_strlen($libelle) > 32) {
            throw new Exception("Le libellé du régime allimentaire ne peut excéder 32 caractères.");
        }
        $this->libelle = $libelle;
    }
}
?>