<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Plat.php";

class PlatModele extends ModeleBase {
    public function ajouter(Plat $plat) : void {
        if (!$this->idExisteDans("regimes", "regimesId", $plat->getRegimesId())) {
            throw new Exception("Le régime sélectionné n'existe pas.");
        }
        if ($this->valeurExisteDeja("plats", "titre", $plat->getTitre())){
            throw new Exception("Ce titre de plat est déjà utiliser.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO plats (titre, categorie, photo, actif, regimesId) VALUES (?, ?, ?, ?, ?)");
        $requete->execute([
            $plat->getTitre(),
            $plat->getCategorie(),
            $plat->getPhoto(),
            $plat->getActif(),
            $plat->getRegimesId()
        ]);
    }

    public function rechercherParId(int $id) : ?Plat {
        $requete = $this->pdo->prepare("SELECT * FROM plats WHERE platsId = ?");
        $requete->execute([$id]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            return null;
        }
        $platsId = (int)$donnees["platsId"];
        $photo = $donnees["photo"] !== null ? (string)$donnees["photo"] : null;
        $actif = (bool)$donnees["actif"];
        $regimesId = (int)$donnees["regimesId"];
        $plat = new Plat(
            $platsId, $donnees["titre"], $donnees["categorie"], $photo, $actif, $regimesId);
        return $plat;
    }

    public function rechercherFiltrer(?string $categorie = null, ?int $regimesId = null) : array {
        $plats = [];
        $conditions = ["actif = 1"];
        $valeurs = [];
        if ($categorie !== null) {
            $conditions[] = "categorie = ?";
            $valeurs[] = $categorie;
        }
        if ($regimesId !== null) {
            $conditions[] = "regimesId = ?";
            $valeurs[] = $regimesId;
        }
        $sql = "SELECT * FROM plats";
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $requete = $this->pdo->prepare($sql);
        $requete->execute($valeurs);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $platsId = (int)$donnees["platsId"];
            $photo = $donnees["photo"] !== null ? (string)$donnees["photo"] : null;
            $actif = (bool)$donnees["actif"];
            $regimesId = (int)$donnees["regimesId"];
            $plats[] = new Plat(
            $platsId, $donnees["titre"], $donnees["categorie"], $photo, $actif, $regimesId);
        }
        return $plats;
    }

    public function modifier(Plat $plat) : void {
        if ($plat->getPlatsId() === null) {
            throw new Exception("Le plat à modifier n'existe pas.");
        }
        if ($this->rechercherParId($plat->getPlatsId()) === null) {
            throw new Exception("Le plat à modifier n'existe pas.");
        }
        if (!$this->idExisteDans("regimes", "regimesId", $plat->getRegimesId())) {
            throw new Exception("Le régime sélectionné n'existe pas.");
        }
        if ($this->valeurExisteDeja("plats", "titre", $plat->getTitre(), $plat->getPlatsId(), "platsId")){
            throw new Exception("Ce titre de plat est déjà utiliser.");
        }
        $requete = $this->pdo->prepare("UPDATE plats SET titre = ?, categorie = ?, photo = ?, actif = ?, regimesId = ? WHERE platsId = ?");
        $requete->execute([
            $plat->getTitre(),
            $plat->getCategorie(),
            $plat->getPhoto(),
            $plat->getActif(),
            $plat->getRegimesId(),
            $plat->getPlatsId()
        ]);
    }

    public function modifierActif(int $platsId, bool $actif) : void {
        if ($this->rechercherParId($platsId) === null) {
            throw new Exception("Le plat à modifier n'existe pas.");
        }
        $requete = $this->pdo->prepare("UPDATE plats SET actif = ? WHERE platsId = ?");
        $requete->execute([
            $actif,
            $platsId
        ]);
    }
}
?>