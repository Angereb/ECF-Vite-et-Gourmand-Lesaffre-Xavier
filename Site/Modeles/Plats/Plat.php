<?php
class Plat {
    public const CATEGORIE_ENTREE = "Entrée";
    public const CATEGORIE_PLAT = "Plat";
    public const CATEGORIE_DESSERT = "Dessert";

    private const CATEGORIES_VALIDES = [
        self::CATEGORIE_ENTREE,
        self::CATEGORIE_PLAT,
        self::CATEGORIE_DESSERT,
    ];

    private ?int $platsId;
    private string $titre;
    private string $categorie;
    private ?string $photo;
    private bool $actif;
    private int $regimesId;

    public function __construct(?int $platsId, string $titre, string $categorie, ?string $photo, bool $actif, int $regimesId){
        $this->platsId = $platsId;
        $this->setTitre($titre);
        $this->setCategorie($categorie);
        $this->setPhoto($photo);
        $this->setActif($actif);
        $this->setRegimesId($regimesId);
    }

    public function getPlatsId(): ?int {
        return $this->platsId;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function setTitre(string $titre): void {
        $titre = trim($titre);
        if ($titre === "") {
            throw new Exception("Le titre du plat ne peut être vide.");
        }
        if (mb_strlen($titre) > 64) {
            throw new Exception("Le titre du plat ne peut excéder 64 caractères.");
        }
        $this->titre = $titre;
    }

    public function getCategorie() : string {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): void {
        if (!in_array($categorie, self::CATEGORIES_VALIDES, true)) {
            throw new Exception("La catégorie doit être : Entrée, Plat ou Dessert.");
        }
        $this->categorie = $categorie;
    }

    public function getPhoto() : ?string {
        return $this->photo;
    }

    public function setPhoto(?string $photo): void {
        $this->photo = $photo;
    }

    public function getActif() : bool {
        return $this->actif;
    }

    public function setActif(bool $actif): void {
        $this->actif = $actif;
    }

    public function getRegimesId(): int {
        return $this->regimesId;
    }

    public function setRegimesId(int $regimesId): void {
        if ($regimesId < 1) {
            throw new Exception("Le plat doit être lié à un régimes alimentaire valide.");
        }
        $this->regimesId = $regimesId;
    }
}
?>