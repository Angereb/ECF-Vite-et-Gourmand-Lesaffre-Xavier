<?php 
class Materiel {
    private ?int $materielsId;
    private string $libelle;

    public function __construct(?int $materielsId, string $libelle){
        $this->materielsId = $materielsId;
        $this->setLibelle($libelle);
    }

    public function getMaterielsId() : ?int {
        return $this->materielsId;
    }

    public function getLibelle() : string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void {
        $libelle = trim($libelle);
        if ($libelle === "") {
            throw new Exception("Le libellé du matériel ne peut être vide.");
        }
        if (mb_strlen($libelle) > 128) {
            throw new Exception("Le libellé du matériel ne peut excéder 128 caractères.");
        }
        $this->libelle = $libelle;
    }
}
?>