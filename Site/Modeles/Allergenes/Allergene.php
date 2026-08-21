<?php 
class Allergene {
    private ?int $allergenesId;
    private string $libelle;

    public function __construct(?int $allergenesId, string $libelle){
        $this->allergenesId = $allergenesId;
        $this->setLibelle($libelle);
    }

    public function getAllergenesId() : ?int {
        return $this->allergenesId;
    }

    public function getLibelle() : string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void {
        $libelle = trim($libelle);
        if ($libelle === "") {
            throw new Exception("Le libellé de l'allergène ne peut être vide.");
        }
        if (mb_strlen($libelle) > 32) {
            throw new Exception("Le libellé de l'allergène ne peut excéder 32 caractères.");
        }
        $this->libelle = $libelle;
    }
}
?>