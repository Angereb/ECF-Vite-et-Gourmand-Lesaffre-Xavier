<?php 
require_once __DIR__ . "/Utilisateur.php";

class Employe extends Utilisateur {
    private bool $administrateur;
    private bool $actif;

    public function __construct(?int $utilisateursId, string $nom, string $prenom, string $email, string $motDePasse, bool $motDePasseHacher, bool $administrateur, bool $actif) {
        parent::__construct($utilisateursId, $nom, $prenom, $email, $motDePasse, $motDePasseHacher);
        $this->setAdministrateur($administrateur);
        $this->setActif($actif);
    }

    public function getAdministrateur() : bool {
        return $this->administrateur;
    }

    public function setAdministrateur(bool $administrateur) : void{
        $this->administrateur = $administrateur;
    }

    public function getActif() : bool {
        return $this->actif;
    }

    public function setActif(bool $actif): void {
        $this->actif = $actif;
    }
}
?>