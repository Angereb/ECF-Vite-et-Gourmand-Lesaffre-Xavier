<?php
class Commande {
    private ?int $commandesId;
    private string $adresse;
    private string $codePostal;
    private DateTime $datePrestation;
    private string $heureLivraison;
    private DateTime $dateLivraison;
    private int $convive;
    private string $facture;
    private int $utilisateursId;
    private int $menusId;
    private int $statutsCommandeId;

    public function __construct(?int $commandesId, string $adresse, string $codePostal, DateTime $datePrestation, string $heureLivraison, DateTime $dateLivraison, int $convive, string $facture, int $utilisateursId, int $menusId, int $statutsCommandeId){
        $this->commandesId = $commandesId;
        $this->setAdresse($adresse);
        $this->setCodePostal($codePostal);
        $this->setDatePrestation($datePrestation);
        $this->setHeureLivraison($heureLivraison);
        $this->setDateLivraison($dateLivraison);
        $this->setConvive($convive);
        $this->setFacture($facture);
        $this->setUtilisateursId($utilisateursId);
        $this->setMenusId($menusId);
        $this->setStatutsCommandeId($statutsCommandeId);
    }

    public function getCommandesId(): ?int {
        return $this->commandesId;
    }

    public function getAdresse(): string {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): void {
        $adresse = trim($adresse);
        if ($adresse === "") {
            throw new Exception("L'adresse pour la commande ne peut être vide");
        }
        if (mb_strlen($adresse) > 1000) {
            throw new Exception("L'adresse pour la commande ne peut dépasser 1000 caractères.");
        }
        $this->adresse = $adresse;
    }

    public function getCodePostal(): string {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): void {
        if (!preg_match('/^[0-9]{5,5}$/', $codePostal)) {
            throw new Exception("Le code postal est invalide.");
        }
        $this->codePostal = $codePostal;
    }

    public function getDatePrestation(): DateTime {
        return $this->datePrestation;
    }

    public function setDatePrestation(DateTime $datePrestation): void {
        if ($datePrestation <= new DateTime("today")) {
            throw new Exception("La date de prestation ne peut être celle d'aujourd'hui ou passer.");
        }
        $this->datePrestation = $datePrestation;
    }

    public function getHeureLivraison(): string {
        return $this->heureLivraison;
    }

    public function setHeureLivraison(string $heureLivraison): void {
        if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$/', $heureLivraison)) {
            throw new Exception("L'heure de livraison doit être au format HH:MM:SS.");
        }
        $this->heureLivraison = $heureLivraison;
    }

    public function getDateLivraison(): DateTime {
        return $this->dateLivraison;
    }

    public function setDateLivraison(DateTime $dateLivraison): void {
        if ($dateLivraison <= new DateTime("today")) {
            throw new Exception("La date de livraison ne peut être celle d'aujourd'hui ou passer.");
        }
        if ($dateLivraison > $this->datePrestation) {
            throw new Exception("La date de livraison doit être antérieure ou égale à la date de prestation.");
        }
        $this->dateLivraison = $dateLivraison;
    }

    public function getConvive(): int {
        return $this->convive;
    }

    public function setConvive(int $convive): void {
        if ($convive < 1) {
            throw new Exception("Le nombre de convive ne peut être inférieur à 1.");
        }
        $this->convive = $convive;
    }

    public function getFacture(): string {
        return $this->facture;
    }

    public function setFacture(string $facture): void {
        $facture = trim($facture);
        if ($facture === "") {
            throw new Exception("La facture ne peut être vide.");
        }
        if (!preg_match('/^\d+([.,]\d{1,2})?$/', $facture)) {
            throw new Exception("La facture doit être un nombre positif avec au maximum 2 chiffres après la virgule.");
        }
        $facture = str_replace(',', '.', $facture);
        $parties = explode('.', $facture);
        $partieEntiere = $parties[0];
        if (strlen($partieEntiere) > 8) {
            throw new Exception("La facture ne peut pas dépasser 99 999 999,99€.");
        }
        $this->facture = $facture;
    }

    public function getUtilisateursId(): int {
        return $this->utilisateursId;
    }

    public function setUtilisateursId(int $utilisateursId): void {
        if ($utilisateursId < 1) {
            throw new Exception("La commande doit être lié à un utilisateur valide.");
        }
        $this->utilisateursId = $utilisateursId;
    }

    public function getMenusId(): int {
        return $this->menusId;
    }

    public function setMenusId(int $menusId): void {
        if ($menusId <1) {
            throw new Exception("La commande doit être lié à un menu valide.");
        }
        $this->menusId = $menusId;
    }

    public function getStatutsCommandeId(): int {
        return $this->statutsCommandeId;
    }

    public function setStatutsCommandeId(int $statutsCommandeId): void {
        if ($statutsCommandeId < 1){
            throw new Exception("La commande doit être lié à un statut de commande valide.");
        }
        $this->statutsCommandeId = $statutsCommandeId;
    }
}
?>