<?php 
require_once __DIR__ . "/Utilisateur.php";

class Client extends Utilisateur {
    private string $numeroTelephone;
    private string $adressePostale;
    private bool $actif;

    public function __construct(?int $utilisateursId, string $nom, string $prenom, string $email, string $motDePasse, bool $motDePasseHacher, string $numeroTelephone, string $adressePostale, bool $actif) {
        parent::__construct($utilisateursId, $nom, $prenom, $email, $motDePasse, $motDePasseHacher);
        $this->setNumeroTelephone($numeroTelephone);
        $this->setAdressePostale($adressePostale);
        $this->setActif($actif);
    }

    public function getNumeroTelephone(): string {
        return $this->numeroTelephone;
    }

    public function setNumeroTelephone(string $numeroTelephone): void {
        $numeroTelephone = trim($numeroTelephone);
        if ($numeroTelephone === "") {
            throw new Exception("Le numéro de téléphone ne peut être vide.");
        }
        if (mb_strlen($numeroTelephone) > 16) {
            throw new Exception("Le numéro de téléphone ne peut excéder 16 caractères.");
        }
        if (!preg_match('/^[0-9\-]+$/', $numeroTelephone)) {
            throw new Exception("Le numéro de téléphone ne peut être composer que de chifres et de tirets");
        }
        $this->numeroTelephone = $numeroTelephone;
    }

    public function getAdressePostale(): string {
        return $this->adressePostale;
    }

    public function setAdressePostale(string $adressePostale): void {
        $adressePostale = trim($adressePostale);
        if ($adressePostale === "") {
            throw new Exception("L'adresse postale ne peut être vide");
        }
        if (mb_strlen($adressePostale) > 1000) {
            throw new Exception("L'adresse postale ne peut dépasser 1000 caractères.");
        }
        $this->adressePostale = $adressePostale;
    }

    public function getActif() : bool {
        return $this->actif;
    }

    public function setActif(bool $actif): void {
        $this->actif = $actif;
    }
}
?>