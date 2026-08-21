<?php 
class Utilisateur {
    private ?int $utilisateursId;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $motDePasse;

    public function __construct(?int $utilisateursId, string $nom, string $prenom, string $email, string $motDePasse, bool $motDePasseHacher = false)
    {
        $this->utilisateursId = $utilisateursId;
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setEmail($email);
        if ($motDePasseHacher) {$this->setMotDePasseHacher($motDePasse);}
        else {$this->setMotDePasse($motDePasse);}
    }

    public function getUtilisateursId(): ?int {
        return $this->utilisateursId;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $nom = trim($nom);
        if ($nom === "") {
            throw new Exception("Le nom ne peut pas être vide");
        }
        if (mb_strlen($nom) > 64) {
            throw new Exception("Le nom ne peut pas dépasser 64 caractères.");
        }
        $this->nom = $nom;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void {
        $prenom = trim($prenom);
        if ($prenom === "") {
            throw new Exception("Le prénom ne peut pas être vide");
        }
        if (mb_strlen($prenom) > 64) {
            throw new Exception("Le prénom ne peut pas dépasser 64 caractères.");
        }
        $this->prenom = $prenom;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $email = trim($email);
        if ($email === "") {
            throw new Exception("L'addresse mail ne peut pas être vide.");
        }
        if (strlen($email) > 128) {
            throw new Exception("L'addresse mail ne peut pas dépasser 128 caractères.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("L'adresse mail n'est pas valide.");
        }
        $this->email = $email;
    }

    public function getMotDePasse(): string {
        return $this->motDePasse;
    }

    private function setMotDePasseHacher(string $motDePasseHacher): void {
        if ($motDePasseHacher === "") {
            throw new Exception("Le mot de passe ne peut pas être vide.");
        }
        if (!preg_match('/^\$2y\$\d{2}\$[A-Za-z0-9.\/]{53}$/', $motDePasseHacher)) {
            throw new Exception("Le format du mot de passe haché est invalide.");
        }
        $this->motDePasse = $motDePasseHacher;
    }

    public function setMotDePasse(string $motDePasse): void {
        if ($motDePasse === "") {
            throw new Exception("Le mot de passe ne peut pas être vide.");
        }

        if (strlen($motDePasse) > 255) {
            throw new Exception("Le mot de passe ne peut pas dépasser 255 caractères.");
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_\-+\/])[a-zA-Z0-9!@#$%^&*_\-+\/]{10,255}$/', $motDePasse)) {
            throw new Exception("Le mot de passe doit contenir au minimum 10 caractères et au moins une minuscule, une majuscule, un chiffre et un caractère spécial.");
        }

        $this->motDePasse = $motDePasse;
    }
}
?>