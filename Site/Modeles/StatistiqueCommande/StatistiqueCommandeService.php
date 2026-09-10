<?php
require_once __DIR__ . "/../BaseDeDonneesNoSQL.php";
use MongoDB\BSON\Decimal128;

class StatistiqueCommandeService {
    private static function collection(): \MongoDB\Collection {
        $configuration = require __DIR__ . "/../../Configuration/config.php";
        $client = BaseDeDonneesNoSQL::connexion();
        return $client->selectCollection($configuration["mongoBase"], "statistiquesCommandes");
    }

    public static function enregistrer(int $menuId, string $dateCommande, string $prixPaye): void {
        self::collection()->insertOne([
            "menu_id" => $menuId,
            "date_commande" => $dateCommande,
            "prix_paye" => new Decimal128($prixPaye)
        ]);
    }

    public static function compterCommandesParMenu(): array {
        $resultats = self::collection()->aggregate([
            [
                '$group' => [
                    '_id' => '$menu_id',
                    'nombreCommandes' => ['$sum' => 1]
                ]
            ]
        ]);
        $tableauResultats = [];
        foreach ($resultats as $resultat) {
            $tableauResultats[] = [
                "menuId" => $resultat["_id"],
                "nombreCommandes" => $resultat["nombreCommandes"]
            ];
        }
        return $tableauResultats;
    }

    public static function calculerChiffreAffairesFiltrer(?string $dateDebut = null, ?string $dateFin = null, ?int $menuId = null): array {
    $conditions = [];
    if ($dateDebut !== null) {
        $conditions["date_commande"]['$gte'] = $dateDebut;
    }
    if ($dateFin !== null) {
        $conditions["date_commande"]['$lte'] = $dateFin;
    }
    if ($menuId !== null) {
        $conditions["menu_id"] = $menuId;
    }
    $pipeline = [];
    if (count($conditions) > 0) {
        $pipeline[] = ['$match' => $conditions];
    }
    $pipeline[] = [
        '$group' => [
            '_id' => '$menu_id',
            'chiffreAffaire' => ['$sum' => '$prix_paye']
        ]
    ];
    $resultats = self::collection()->aggregate($pipeline);
    $tableauResultats = [];
    foreach ($resultats as $resultat) {
        $tableauResultats[] = [
            "menuId" => $resultat["_id"],
            "chiffreAffaire" => (string)$resultat["chiffreAffaire"]
        ];
    }
    return $tableauResultats;
}
}
?>