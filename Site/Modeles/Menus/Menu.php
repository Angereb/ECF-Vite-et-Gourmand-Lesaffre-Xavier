<?php
class Menu {
    private ?int $menusId;
    private string $titre;
    private string $descriptions;
    private ?string $conditions;
    private int $minimumConvive;
    private int $stock;
    private string $prix; // j'ai chercher sur internet comment le SQL DECIMAL était récupérer
    private bool $actif;
    private int $themesId;
    private int $regimesId;

    public function __construct(?int $menusId, string $titre, string $descriptions, ?string $conditions, int $minimumConvive, int $stock, string $prix, bool $actif, int $themesId, int $regimesId){
        $this->menusId = $menusId;
        $this->setTitre($titre);
        $this->setDescriptions($descriptions);
        $this->setConditions($conditions);
        $this->setMinimumConvive($minimumConvive);
        $this->setStock($stock);
        $this->setPrix($prix);
        $this->setActif($actif);
        $this->setThemesId($themesId);
        $this->setRegimesId($regimesId);
    }

    public function getMenusId(): ?int {
        return $this->menusId;
    }

    public function getTitre(): string {
        return $this->titre;
    }
    
    public function setTitre(string $titre): void {
        $titre = trim($titre);
        if ($titre === "") {
            throw new Exception("Le titre du menu ne peut être vide.");
        }
        if (mb_strlen($titre) > 64) {
            throw new Exception("Le titre du menu ne peut excéder 64 caractères.");
        }
        $this->titre = $titre;
    }

    public function getDescriptions(): string {
        return $this->descriptions;
    }

    public function setDescriptions(string $descriptions): void {
        $descriptions = trim($descriptions);
        if ($descriptions === "") {
            throw new Exception("La description du menu ne peut être vide.");
        }
        if (mb_strlen($descriptions) > 2500) {
            throw new Exception("La description du menu ne peut excéder 2500 caractères.");
        }
        $this->descriptions = $descriptions;
    }

    public function getConditions(): ?string {
        return $this->conditions;
    }

    public function setConditions(?string $conditions): void {
        if ($conditions === null) {
            $this->conditions = null;
            return;
        }
        $conditions = trim($conditions);
        if (mb_strlen($conditions) > 2500) {
            throw new Exception("Les conditions du menu ne peuvent excéder 2500 caractères.");
        }
        $this->conditions = $conditions;
    }

    public function getMinimumConvive(): int {
        return $this->minimumConvive;
    }

    public function setMinimumConvive(int $minimumConvive): void {
        if ($minimumConvive < 1) {
            throw new Exception("Le nombre minimum de convives ne peut être inférieur à 1.");
        }
        $this->minimumConvive = $minimumConvive;
    }

    public function getStock(): int {
        return $this->stock;
    }

    public function setStock(int $stock): void {
        if ($stock < 0){
            throw new Exception("Le stock de menu ne peut être inférieur à 0.");
        }
        $this->stock = $stock;
    }

    public function getPrix(): string {
        return $this->prix;
    }

    public function setPrix(string $prix): void {
        $prix = trim($prix);
        if ($prix === "") {
            throw new Exception("Le prix du menu ne peut être vide.");
        }
        if (!preg_match('/^\d+([.,]\d{1,2})?$/', $prix)) {  //j'ai chercher sur internet pour un regex correspondant à positif et 2 chiffres après la virgule
            throw new Exception("Le prix du menu doit être un nombre positif avec au maximum 2 chiffres après la virgule.");
        }
        $prix = str_replace(',', '.', $prix);
        if ((float)$prix <= 0){
            throw new Exception("Le prix du menu ne peut être de 0.00€.");
        }
        $parties = explode('.', $prix);
        $partieEntiere = $parties[0];
        if (strlen($partieEntiere) > 8) {
            throw new Exception("Le prix du menu ne peut pas dépasser 99 999 999,99€.");
        }
        $this->prix = $prix;
    }

    public function getActif() : bool {
        return $this->actif;
    }

    public function setActif(bool $actif): void {
        $this->actif = $actif;
    }

    public function getThemesId(): int {
        return $this->themesId;
    }

    public function setThemesId(int $themesId): void {
        if ($themesId < 1) {
            throw new Exception("Le menu doit être lié à un thème valide.");
        }
        $this->themesId = $themesId;
    }

    public function getRegimesId(): int {
        return $this->regimesId;
    }

    public function setRegimesId(int $regimesId): void {
        if ($regimesId < 1) {
            throw new Exception("Le menu doit être lié à un régimes alimentaire valide.");
        }
        $this->regimesId = $regimesId;
    }
}
?>