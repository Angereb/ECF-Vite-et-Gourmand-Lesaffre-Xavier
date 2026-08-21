<?php 
class Horaire {
    private ?int $horairesId;
    private string $jour;
    private ?string $heuresOuverture;
    private ?string $heuresFermeture;

    public function __construct(?int $horairesId, string $jour, ?string $heuresOuverture, ?string $heuresFermeture){
        $this->horairesId = $horairesId;
        $this->setJour($jour);
        $this->setHeuresOuverture($heuresOuverture);
        $this->setHeuresFermeture($heuresFermeture);
    }

    public function getHorairesId(): ?int {
        return $this->horairesId;
    }

    public function getJour(): string {
        return $this->jour;
    }

    public function setJour(string $jour): void {
        $jour = trim($jour);
        if ($jour === "") {
            throw new Exception("Le jour pour l'horaire ne peut être vide.");
        }
        if (mb_strlen($jour) > 16) {
            throw new Exception("Le jour pour l'horaire ne peut excéder 16 caractères.");
        }
        $this->jour = $jour;
    }

    public function getHeuresOuverture(): ?string {
        return $this->heuresOuverture;
    }

    public function setHeuresOuverture(?string $heuresOuverture): void {
        if ($heuresOuverture === null) {
            $this->heuresOuverture = null;
            return;
        }
        if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$/', $heuresOuverture)) {
            throw new Exception("L'heure d'ouverture doit être au format HH:MM:SS.");
        }
        $this->heuresOuverture = $heuresOuverture;
    }
    
    public function getHeuresFermeture(): ?string {
        return $this->heuresFermeture;
    }

    public function setHeuresFermeture(?string $heuresFermeture): void {
        if ($heuresFermeture === null) {
            $this->heuresFermeture = null;
            return;
        }
        if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$/', $heuresFermeture)) {
            throw new Exception("L'heure de fermeture doit être au format HH:MM:SS.");
        }
        $this->heuresFermeture = $heuresFermeture;
    }
}
?>