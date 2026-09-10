<?php
/*
echo "Test 1 : récupération des statistiques de commande\n";
$statistiquesCommande = StatistiqueCommandeService::compterCommandesParMenu();
foreach ($statistiquesCommande as $statistique) {
    echo "Menu " . $statistique["menuId"] . " : " . $statistique["nombreCommandes"] . " commande(s)\n";
}

echo "Test 2 : récupération des statistiques de chiffre d'affaire\n";
$statistiquesCA = StatistiqueCommandeService::calculerChiffreAffairesParMenu();
foreach ($statistiquesCA as $statistique2) {
    echo "Menu " . $statistique2["menuId"] . " : " . $statistique2["chiffreAffaire"] . " €\n";
}
*/

echo "Test 3 : récupération des statistiques de chiffre d'affaire\n";
$statistiquesCA = StatistiqueCommandeService::calculerChiffreAffairesFiltrer();
foreach ($statistiquesCA as $statistique2) {
    echo "Menu " . $statistique2["menuId"] . " : " . $statistique2["chiffreAffaire"] . " €\n";
}

echo "Test 4 : filtre avec une date qui exclut tout\n";
$statistiquesCA = StatistiqueCommandeService::calculerChiffreAffairesFiltrer(dateDebut: "2030-01-01");
echo count($statistiquesCA) . " résultat(s) trouvé(s)\n";

echo "Test 5 : filtre avec une date qui inclut tout\n";
$statistiquesCA = StatistiqueCommandeService::calculerChiffreAffairesFiltrer(dateDebut: "2020-01-01");
foreach ($statistiquesCA as $statistique) {
    echo "Menu " . $statistique["menuId"] . " : " . $statistique["chiffreAffaire"] . " €\n";
}

echo "Test 6 : filtre avec une date qui inclut une partie\n";
$statistiquesCA = StatistiqueCommandeService::calculerChiffreAffairesFiltrer(dateDebut: "2026-09-20");
foreach ($statistiquesCA as $statistique) {
    echo "Menu " . $statistique["menuId"] . " : " . $statistique["chiffreAffaire"] . " €\n";
}
?>