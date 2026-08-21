<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Image.php";

class ImageModele extends ModeleBase {
    public function ajouter(Image $image): void {
        if (!$this->idExisteDans("menus", "menusId", $image->getMenusId())){
            throw new Exception("Le menu sélectionné n'existe pas.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO images (titre, photo, menusId) VALUES (?, ?, ?)");
        $requete->execute([
            $image->getTitre(),
            $image->getPhoto(),
            $image->getMenusId()
        ]);
    }

    public function rechercherParId(int $id): ?Image {
        $requete = $this->pdo->prepare("SELECT * FROM images WHERE imagesId = ?");
        $requete->execute([$id]);
        $donnee = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnee === false){
            return null;
        }
        $imagesId = (int)$donnee["imagesId"];
        $photo = $donnee["photo"] !== null ? (string)$donnee["photo"] : null;
        $menusId = (int)$donnee["menusId"];
        $image = new Image(
            $imagesId, $donnee["titre"], $photo, $menusId);
        return $image;
    }

    public function rechercherTous(): array {
        $images = [];
        $requete = $this->pdo->prepare("SELECT * FROM images ORDER BY imagesId");
        $requete->execute();
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $imagesId = (int)$donnees["imagesId"];
            $photo = $donnees["photo"] !== null ? (string)$donnees["photo"] : null;
            $menusId = (int)$donnees["menusId"];
            $images[] = new Image($imagesId, $donnees["titre"], $photo, $menusId);
        };
        return $images;
    }

    public function modifier(Image $image): void {
        if ($this->rechercherParId($image->getImagesId()) === null){
            throw new Exception("L'image que vous voulez modifier n'existe pas.");
        }
        if (!$this->idExisteDans("menus", "menusId", $image->getMenusId())){
            throw new Exception("Le menu sélectionné n'existe pas.");
        }
        $requete = $this->pdo->prepare("UPDATE images SET titre = ?, photo = ?, menusId = ? WHERE imagesId = ?");
        $requete->execute([
            $image->getTitre(),
            $image->getPhoto(),
            $image->getMenusId(),
            $image->getImagesId()
        ]);
    }

    public function supprimer(int $id): void {
        if ($this->rechercherParId($id) === null){
            throw new Exception("L'image que vous voulez supprimer n'existe pas.");
        }
        try {
            $requete = $this->pdo->prepare("DELETE FROM images WHERE imagesId = ?");
            $requete->execute([$id]);
        } catch (PDOException $e){
            throw new Exception("Impossible de supprimer cet image.");
        }
    }
}
?>