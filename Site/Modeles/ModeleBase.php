<?php
require_once __DIR__ . "/BaseDeDonnees.php";

abstract class ModeleBase {
    protected PDO $pdo;

    public function __construct() {
        $this->pdo = BaseDeDonnees::connexion();
    }

    protected function idExisteDans(string $table, string $colonneId, int $id) : bool {
        $requete = $this->pdo->prepare("SELECT COUNT(*) FROM $table WHERE $colonneId = ?");
        $requete->execute([$id]);
        return $requete->fetchColumn() > 0;
    }
    
    protected function valeurExisteDeja(string $table, string $colonne, string $valeur, ?int $idAExclure = null, string $colonneId = "") : bool {
        if ($idAExclure !== null) {
            $requete = $this->pdo->prepare("SELECT COUNT(*) FROM $table WHERE $colonne = ? AND $colonneId != ?");
            $requete->execute([$valeur, $idAExclure]);
        } else {
            $requete = $this->pdo->prepare("SELECT COUNT(*) FROM $table WHERE $colonne = ?");
            $requete->execute([$valeur]);
        }
        return $requete->fetchColumn() > 0;
    }
}
?>