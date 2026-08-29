<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Client.php";

class ClientModele extends ModeleBase {
    public function ajouter(Client $client) : void {
        if ($this->valeurExisteDeja("utilisateurs", "email", $client->getEmail())) {
            throw new Exception("Cette adresse mail est déjà utilisée.");
        }
        $motDePasseHache = password_hash($client->getMotDePasse(), PASSWORD_DEFAULT);
        $this->pdo->beginTransaction();
        try {
            $requeteUtilisateur = $this->pdo->prepare(
                "INSERT INTO utilisateurs (nom, prenom, email, motDePasse) VALUES (?, ?, ?, ?)");
            $requeteUtilisateur->execute([
                $client->getNom(),
                $client->getPrenom(),
                $client->getEmail(),
                $motDePasseHache
            ]);
            $nouvelUtilisateursId = (int)$this->pdo->lastInsertId();
            $requeteClient = $this->pdo->prepare(
                "INSERT INTO clients (utilisateursId, numeroTelephone, adressePostale, actif) VALUES (?, ?, ?, ?)");
            $requeteClient->execute([
                $nouvelUtilisateursId,
                $client->getNumeroTelephone(),
                $client->getAdressePostale(),
                $client->getActif()
            ]);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Erreur lors de la création du client : " . $e->getMessage());
        }
    }

    public function rechercherParId(int $id) : ?Client {
        $requete = $this->pdo->prepare("SELECT * FROM clients JOIN utilisateurs ON utilisateurs.utilisateursId = clients.utilisateursId WHERE clients.utilisateursId = ?");
        $requete->execute([$id]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            return null;
        }
        $utilisateursId = (int)$donnees["utilisateursId"];
        $actif = (bool)$donnees["actif"];
        $client = new Client(
            $utilisateursId, $donnees["nom"], $donnees["prenom"], $donnees["email"], $donnees["motDePasse"], true, $donnees["numeroTelephone"], $donnees["adressePostale"], $actif);
        return $client;
    }

    public function rechercherParEmail(string $email): ?Client {
        $requete = $this->pdo->prepare("SELECT * FROM clients JOIN utilisateurs ON utilisateurs.utilisateursId = clients.utilisateursId WHERE utilisateurs.email = ?");
        $requete->execute([$email]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            return null;
        }
        $utilisateursId = (int)$donnees["utilisateursId"];
        $actif = (bool)$donnees["actif"];
        return new Client(
            $utilisateursId, $donnees["nom"], $donnees["prenom"], $donnees["email"], $donnees["motDePasse"], true, $donnees["numeroTelephone"], $donnees["adressePostale"], $actif
        );
    }

    public function modifier(Client $client) : void {
        if ($this->rechercherParId($client->getUtilisateursId()) === null) {
            throw new Exception("Le client à modifier n'existe pas.");
        }
        if ($this->valeurExisteDeja("utilisateurs", "email", $client->getEmail(), $client->getUtilisateursId(), "utilisateursId")){
            throw new Exception("Cette adresse mail est déjà utilisée.");
        }
        $this->pdo->beginTransaction();
        try {
            $requeteUtilisateur = $this->pdo->prepare("UPDATE utilisateurs SET nom = ?, prenom = ?, email = ? WHERE utilisateursId = ?");
            $requeteUtilisateur->execute([
                $client->getNom(),
                $client->getPrenom(),
                $client->getEmail(),
                $client->getUtilisateursId()
            ]);
            $requeteClient = $this->pdo->prepare("UPDATE clients SET numeroTelephone = ?, adressePostale = ?, actif = ? WHERE utilisateursId = ?");
            $requeteClient->execute([
                $client->getNumeroTelephone(),
                $client->getAdressePostale(),
                $client->getActif(),
                $client->getUtilisateursId()
            ]);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Erreur lors de la modification du client : " . $e->getMessage());
        }
    }

    public function modifierMotDePasse(int $utilisateursId, string $motDePasse) : void {
        if ($this->rechercherParId($utilisateursId) === null) {
            throw new Exception("Le client à modifier n'existe pas.");
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
            throw new Exception("Le client à modifier n'existe pas.");
        }
        $requete = $this->pdo->prepare("UPDATE clients SET actif = ? WHERE utilisateursId = ?");
        $requete->execute([
            $actif,
            $utilisateursId
        ]);
    }
}