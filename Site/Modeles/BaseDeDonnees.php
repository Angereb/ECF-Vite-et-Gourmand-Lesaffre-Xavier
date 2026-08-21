<?php
class BaseDeDonnees {
    private static string $serveur;
    private static string $base;
    private static string $utilisateurBase;
    private static string $motDePasseBase;

    private static function chargerConfiguration() : void {
        $configuration = require __DIR__ . "/../Configuration/config.php";

        self::$serveur = $configuration["serveur"];
        self::$base = $configuration["base"];
        self::$utilisateurBase = $configuration["utilisateur"];
        self::$motDePasseBase = $configuration["motDePasse"];
    }

    private static ?PDO $pdo = null;

    public static function connexion() : PDO {
        if (self::$pdo === null){
            self::chargerConfiguration();

            $dsn = "mysql:host=" . self::$serveur .
            ";dbname=" . self::$base .
            ";charset=utf8mb4";

            try{
                self::$pdo = new PDO(
                    $dsn,
                    self::$utilisateurBase,
                    self::$motDePasseBase
                );

                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $erreur) {
                error_log("Erreur de connexion BDD : " . $erreur->getMessage());
                throw new Exception("Le service est temporairement indisponible. Merci de réessayer plus tard.");
            }  
        }
        return self::$pdo;
    } 
}
?>