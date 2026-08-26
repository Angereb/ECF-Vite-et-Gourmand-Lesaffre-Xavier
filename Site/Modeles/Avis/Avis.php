<?php 
class Avis {
    private ?int $avisId;
    private string $titre;
    private int $note;
    private string $commentaire;
    private int $commandesId;
    private int $statutsAvisId;

    public function __construct(?int $avisId, string $titre, int $note, string $commentaire, int $commandesId, int $statutsAvisId){
        $this->avisId = $avisId;
        $this->setTitre($titre);
        $this->setNote($note);
        $this->setCommentaire($commentaire);
        $this->setCommandesId($commandesId);
        $this->setStatutsAvisId($statutsAvisId);
    }

    public function getAvisId(): ?int {
        return $this->avisId;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function setTitre(string $titre): void {
        $titre = trim($titre);
        if ($titre === "") {
            throw new Exception("Le titre de l'avis ne peut être vide.");
        }
        if (mb_strlen($titre) > 68) {
            throw new Exception("Le titre de l'avis ne peut excéder 68 caractères.");
        }
        $this->titre = $titre;
    }

    public function getNote(): int {
        return $this->note;
    }

    public function setNote(int $note): void {
        if ($note < 0 || $note > 5){
            throw new Exception("La note doit être comprise entre 0 et 5.");
        }
        $this->note = $note;
    }

    public function getCommentaire(): string {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): void {
        $commentaire = trim($commentaire);
        if ($commentaire === "") {
            throw new Exception("Le commentaire de l'avis ne peut être vide.");
        }
        if (mb_strlen($commentaire) > 2500) {
            throw new Exception("Le commentaire de l'avis ne peut excéder 2500 caractères.");
        }
        $this->commentaire = $commentaire;
    }

    public function getCommandesId(): int {
        return $this->commandesId;
    }

    public function setCommandesId(int $commandesId): void {
        if ($commandesId <1) {
            throw new Exception("L'avis être lié à une commande valide.");
        }
        $this->commandesId = $commandesId;
    }

    public function getStatutsAvisId(): int {
        return $this->statutsAvisId;
    }

    public function setStatutsAvisId(int $statutsAvisId): void {
        if ($statutsAvisId < 1){
            throw new Exception("L'avis doit être lié à un statut d'avis valide.");
        }
        $this->statutsAvisId = $statutsAvisId;
    }

    public static function genererEtoiles(int $note): string {
        $etoilesPleines = str_repeat("★", $note);
        $etoilesVides = str_repeat("☆", 5 - $note);
        return $etoilesPleines . $etoilesVides;
    }
}
?>