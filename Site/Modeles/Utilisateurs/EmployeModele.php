<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Employe.php";

class EmployeModele extends ModeleBase {
    public function ajouter(Employe $employe) : void {
        if ($this->valeurExisteDeja("utilisateurs", "email", $employe->getEmail())) {
            throw new Exception("Cette adresse mail est déjà utilisée.");
        }
        $motDePasseHache = password_hash($employe->getMotDePasse(), PASSWORD_DEFAULT);
        $this->pdo->beginTransaction();
        try {
            $requeteUtilisateur = $this->pdo->prepare(
                "INSERT INTO utilisateurs (nom, prenom, email, motDePasse) VALUES (?, ?, ?, ?)");
            $requeteUtilisateur->execute([
                $employe->getNom(),
                $employe->getPrenom(),
                $employe->getEmail(),
                $motDePasseHache
            ]);
            $nouvelUtilisateursId = (int)$this->pdo->lastInsertId();
            $requeteEmploye = $this->pdo->prepare(
                "INSERT INTO employes (utilisateursId, administrateur, actif) VALUES (?, ?, ?)");
            $requeteEmploye->execute([
                $nouvelUtilisateursId,
                $employe->getAdministrateur(),
                $employe->getActif()
            ]);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Erreur lors de la création de l'employé : " . $e->getMessage());
        }  
    }

    public function rechercherParId(int $id) : ?Employe {
        $requete = $this->pdo->prepare("SELECT * FROM employes JOIN utilisateurs ON utilisateurs.utilisateursId = employes.utilisateursId WHERE employes.utilisateursId = ?");
        $requete->execute([$id]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            return null;
        }
        $utilisateursId = (int)$donnees["utilisateursId"];
        $administrateur = (bool)$donnees["administrateur"];
        $actif = (bool)$donnees["actif"];
        $employe = new Employe(
            $utilisateursId, $donnees["nom"], $donnees["prenom"], $donnees["email"], $donnees["motDePasse"], true, $administrateur, $actif);
        return $employe;
    }

    public function rechercherParEmail(string $email): ?Employe {
        $requete = $this->pdo->prepare("SELECT * FROM employes JOIN utilisateurs ON utilisateurs.utilisateursId = employes.utilisateursId WHERE utilisateurs.email = ?");
        $requete->execute([$email]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            return null;
        }
        $utilisateursId = (int)$donnees["utilisateursId"];
        $administrateur = (bool)$donnees["administrateur"];
        $actif = (bool)$donnees["actif"];
        $employe = new Employe(
            $utilisateursId, $donnees["nom"], $donnees["prenom"], $donnees["email"], $donnees["motDePasse"], true, $administrateur, $actif);
        return $employe;
    }

    public function modifier(Employe $employe) : void {
        if ($this->rechercherParId($employe->getUtilisateursId()) === null) {
            throw new Exception("L'employe à modifier n'existe pas.");
        }
        if ($this->valeurExisteDeja("utilisateurs", "email", $employe->getEmail(), $employe->getUtilisateursId(), "utilisateursId")){
            throw new Exception("Cette adresse mail est déjà utilisée.");
        }
        $this->pdo->beginTransaction();
        try {
            $requeteUtilisateur = $this->pdo->prepare("UPDATE utilisateurs SET nom = ?, prenom = ?, email = ? WHERE utilisateursId = ?");
            $requeteUtilisateur->execute([
                $employe->getNom(),
                $employe->getPrenom(),
                $employe->getEmail(),
                $employe->getUtilisateursId()
            ]);
            $requeteEmploye = $this->pdo->prepare("UPDATE employes SET administrateur = ?, actif = ? WHERE utilisateursId = ?");
            $requeteEmploye->execute([
                $employe->getAdministrateur(),
                $employe->getActif(),
                $employe->getUtilisateursId()
            ]);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Erreur lors de la modification du employe : " . $e->getMessage());
        }
    }

    public function modifierMotDePasse(int $utilisateursId, string $motDePasse) : void {
        if ($this->rechercherParId($utilisateursId) === null) {
            throw new Exception("L'employe à modifier n'existe pas.");
        }
        $motDePasseHache = password_hash($motDePasse, PASSWORD_DEFAULT);
        $requete = $this->pdo->prepare("UPDATE utilisateurs SET motDePasse = ? WHERE utilisateursId = ?");
        $requete->execute([
            $motDePasseHache,
            $utilisateursId
        ]);
    }

    public function modifierActif(int $utilisateursId, bool $actif) : void {
        if ($this->rechercherParId($utilisateursId) === null) {
            throw new Exception("L'employe' à modifier n'existe pas.");
        }
        $requete = $this->pdo->prepare("UPDATE employes SET actif = ? WHERE utilisateursId = ?");
        $requete->execute([
            $actif,
            $utilisateursId
        ]);
    }
}
?>