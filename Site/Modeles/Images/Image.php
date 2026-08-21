<?php 
class Image {
    private ?int $imagesId;
    private string $titre;
    private string $photo;
    private int $menusId;

    public function __construct(?int $imagesId, string $titre, string $photo, int $menusId){
        $this->imagesId = $imagesId;
        $this->setTitre($titre);
        $this->setPhoto($photo);
        $this->setMenusId($menusId);
    }

    public function getImagesId(): ?int {
        return $this->imagesId;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function setTitre(string $titre): void {
        $titre = trim($titre);
        if ($titre === "") {
            throw new Exception("Le titre de l'image ne peut être vide.");
        }
        if (mb_strlen($titre) > 64) {
            throw new Exception("Le titre de l'image ne peut excéder 64 caractères.");
        }
        $this->titre = $titre;
    }

    public function getPhoto(): string {
        return $this->photo;
    }

    public function setPhoto(string $photo): void {
        $this->photo = $photo;
    }

    public function getMenusId(): int {
        return $this->menusId;
    }

    public function setMenusId(int $menusId): void {
        if ($menusId <1) {
            throw new Exception("L'image doit être lié à un menu valide.");
        }
        $this->menusId = $menusId;
    }
}
?>