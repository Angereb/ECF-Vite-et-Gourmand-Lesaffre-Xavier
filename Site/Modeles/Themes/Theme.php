<?php 
class Theme {
    private ?int $themesId;
    private string $libelle;

    public function __construct(?int $themesId, string $libelle){
        $this->themesId = $themesId;
        $this->setLibelle($libelle);
    }

    public function getThemesId() : ?int {
        return $this->themesId;
    }

    public function getLibelle() : string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void {
        $libelle = trim($libelle);
        if ($libelle === "") {
            throw new Exception("Le libellé du thème ne peut être vide.");
        }
        if (mb_strlen($libelle) > 64) {
            throw new Exception("Le libellé du thème ne peut excéder 64 caractères.");
        }
        $this->libelle = $libelle;
    }
}
?>