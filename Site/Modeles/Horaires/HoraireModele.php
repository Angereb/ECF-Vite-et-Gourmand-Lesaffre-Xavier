<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Horaire.php";

class HoraireModele extends ModeleBase {
    public function ajouter(Horaire $horaire): void {
        if ($this->valeurExisteDeja("horaires", "jour", $horaire->getJour())){
            throw new Exception("Ce jour pour l'horaire est déjà utiliser.");
        }
        $requete = $this->pdo->prepare(
            "INSERT INTO horaires (jour, heuresOuverture, heuresFermeture) VALUES (?, ?, ?)");
        $requete->execute([
            $horaire->getJour(),
            $horaire->getHeuresOuverture(),
            $horaire->getHeuresFermeture()
        ]);
    }

    public function rechercherParId(int $id): ?Horaire {
        $requete = $this->pdo->prepare("SELECT * FROM horaires WHERE horairesId = ?");
        $requete->execute([$id]);
        $donnee = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnee === false){
            return null;
        }
        $horairesId = (int)$donnee["horairesId"];
        $horaire = new Horaire($horairesId, $donnee["jour"], $donnee["heuresOuverture"], $donnee["heuresFermeture"]);
        return $horaire;
    }

    public function rechercherTous(): array {
        $horaires = [];
        $requete = $this->pdo->prepare("SELECT * FROM horaires ORDER BY jour ASC");
        $requete->execute();
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $horairesId = (int)$donnees["horairesId"];
            $horaires[] = new Horaire($horairesId, $donnees["jour"], $donnees["heuresOuverture"], $donnees["heuresFermeture"]);
        };
        return $horaires;
    }

    public function modifier(Horaire $horaire): void {
        if ($this->rechercherParId($horaire->getHorairesId()) === null){
            throw new Exception("L'horaire que vous voulez modifier n'existe pas.");
        }
        if ($this->valeurExisteDeja("horaires", "jour", $horaire->getJour(), $horaire->getHorairesId(), "horairesId")){
            throw new Exception("Ce jour pour l'horaire est déjà utiliser.");
        }
        $requete = $this->pdo->prepare("UPDATE horaires SET jour = ?, heuresOuverture = ?, heuresFermeture = ? WHERE horairesId = ?");
        $requete->execute([
            $horaire->getJour(),
            $horaire->getHeuresOuverture(),
            $horaire->getHeuresFermeture(),
            $horaire->getHorairesId()
        ]);
    }

    public function supprimer(int $id): void {
        if ($this->rechercherParId($id) === null){
            throw new Exception("L'horaire à supprimer n'existe pas.");
        }
        try {
            $requete = $this->pdo->prepare("DELETE FROM horaires WHERE horairesId = ?");
            $requete->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Impossible de supprimer cet horaire");
        }
    }
}
?>