<?php 
require_once __DIR__ . "/../Modeles/Commandes/CommandeModele.php";
require_once __DIR__ . "/../Modeles/Commandes/Commande.php";
require_once __DIR__ . "/../Modeles/Menus/MenuModele.php";
require_once __DIR__ . "/../Modeles/Menus/Menu.php";
require_once __DIR__ . "/../Modeles/HistoriquesStatutsCommandes/HistoriqueStatutCommandeModele.php";
require_once __DIR__ . "/../Modeles/HistoriquesStatutsCommandes/HistoriqueStatutCommande.php";

$modele1 = new CommandeModele();
$modele2 = new MenuModele();
$modele3 = new HistoriqueStatutCommandeModele();

/*
echo "Test 1 : calcul d'une facture simple à bordeaux.\n";
$menu1 = $modele2->rechercherParId(1);
$tarif1 = $modele1->calculerFacture($menu1, "33000", 4);
echo "la facture totale est de " . $tarif1 . "€;\n";

echo "Test 2 : calcul d'une facture simple à paris.\n";
$menu1 = $modele2->rechercherParId(1);
$tarif2 = $modele1->calculerFacture($menu1, "75000", 4);
echo "la facture totale est de " . $tarif2 . "€;\n";

echo "Test 3 : calcul d'une facture avec réduction à perpignan.\n";
$menu1 = $modele2->rechercherParId(1);
$tarif3 = $modele1->calculerFacture($menu1, "66000", 7);
echo "la facture totale est de " . $tarif3 . "€;\n";

echo "Test 4 : ajout d'une commande.\n";
$menu1 = $modele2->rechercherParId(1);
$commande2 = new Commande(null, "Quelque part", "33150", new DateTime("2026-08-25 18:30:00"), "18:30:00", new DateTime("2026-08-25 18:30:00"), 2, "60.00", 3, 1, 1);
$modele1->ajouter($commande2, $menu1);
$resultats = $modele1->rechercherFiltrer(utilisateursId : 3);
echo count($resultats) . " commande(s) trouvé(s)\n";

echo "Test 5 : recherche d'une commande par ID.\n";
$commandeTrouver = $modele1->rechercherParId(2);
if ($commandeTrouver !== null) {
    echo "OK - commande trouvé.\n";
} else {
    echo "ECHEC - commande non trouvé";
}

echo "\nTest 6 : recherche d'une commande par ID incorrect.\n";
$commandeTrouver = $modele1->rechercherParId(589);
if ($commandeTrouver !== null) {
    echo "ECHEC - commande trouvé.\n";
} else {
    echo "OK - commande non trouvé";
}

echo "test 7 : modification d'une commande client modifiant la facture.";
$commandeTrouver = $modele1->rechercherParId(2);
$menu1 = $modele2->rechercherParId(1);
$commandeModifier = new Commande($commandeTrouver->getCommandesId(), $commandeTrouver->getAdresse(), "33100", $commandeTrouver->getDatePrestation(), $commandeTrouver->getHeureLivraison(), $commandeTrouver->getDateLivraison(), 7, $commandeTrouver->getFacture(), 3, 1, 1);
try {
    $modele1->modifier($commandeModifier, $menu1);
    echo "Ok - la commande a bien été modifier.\n";
} catch (Exception $e) {
    echo "ECHEC - exception attrapée : " . $e->getMessage() . "\n";
}

echo "test 8 : modification d'un statut de commande.";
try {
    $modele1->modifierStatut(2,1);
    echo "Ok - le statut de la commande a bien été modifier.\n";
} catch (Exception $e) {
    echo "ECHEC - exception attrapée : " . $e->getMessage() . "\n";
}

echo "test 9 : modification d'un statut de commande vers un statut inexsitant.";
try {
    $modele1->modifierStatut(2,58);
    echo "ECHEC - le statut de la commande a bien été modifier.\n";
} catch (Exception $e) {
    echo "OK - exception attrapée : " . $e->getMessage() . "\n";
}

echo "Test 10 : ajout d'une commande pour voir l'historique.\n";
$menu1 = $modele2->rechercherParId(1);
$commande3 = new Commande(null, "Quelque part", "33150", new DateTime("2026-08-25 18:30:00"), "18:30:00", new DateTime("2026-08-25 18:30:00"), 2, "60.00", 3, 1, 4);
$modele1->ajouter($commande3, $menu1);
$resultats = $modele1->rechercherFiltrer(utilisateursId : 3);
echo count($resultats) . " commande(s) trouvé(s)\n";

echo "Test 11 : modification d'un statut de commande pour vérification de la modification du stock.\n";
$menuRecuperer = $modele2->rechercherParId(1);
echo "Le stock avant modification est de : " . $menuRecuperer->getStock() . ".\n";
try {
    $modele1->modifierStatut(3, 3);
    echo "OK Partiel - le statut de la commande a bien été modifier.\n";
    $menuRecuperer2 = $modele2->rechercherParId(1);
    echo "Le stock après modification est de : " . $menuRecuperer2->getStock() . ".\n";
} catch (Exception $e) {
    echo "Echec - Exception attrapée : " . $e->getMessage() . ".\n";
}

echo "Test 12 : modification d'un statut de commande vers annulée sans motif.\n";
try {
    $modele1->modifierStatut(3, 2);
    echo "ECHEC - le statut de la commande a bien été modifier.\n";
} catch (Exception $e) {
    echo "OK - Exception attrapée : " . $e->getMessage() . ".\n";
}
*/

echo "Test 13 : modification d'un statut de commande accepté vers annulée pour vérification de la modification du stock.\n";
$menuRecuperer = $modele2->rechercherParId(1);
echo "Le stock avant modification est de : " . $menuRecuperer->getStock() . ".\n";
try {
    $modele1->modifierStatut(3, 2, "Départ urgent du client", "Téléphone");
    echo "OK Partiel - le statut de la commande a bien été modifier?\n";
    $menuRecuperer2 = $modele2->rechercherParId(1);
    echo "Le stock après modification est de : " . $menuRecuperer2->getStock() . ".\n";
} catch (Exception $e) {
    echo "Echec - Exception attrapée : " . $e->getMessage() . ".\n";
}
?>