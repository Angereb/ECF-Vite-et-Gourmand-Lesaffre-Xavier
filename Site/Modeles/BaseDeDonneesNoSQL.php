<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use MongoDB\Client;

class BaseDeDonneesNoSQL {
    private static ?Client $client = null;

    public static function connexion(): Client {
        if (self::$client === null) {
            try {
                $configuration = require __DIR__ . "/../Configuration/config.php";
                self::$client = new Client($configuration["mongoUri"]);
            } catch (Exception $e) {
                error_log("Erreur de connexion MongoDB : " . $e->getMessage());
                throw new Exception("Impossible de se connecter à la base de données NoSQL.");
            }
        }
        return self::$client;
    }
}
?>