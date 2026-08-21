<?php 
require_once __DIR__ . "/../Modeles/Utilisateurs/ClientModele.php";
require_once __DIR__ . "/../Modeles/Utilisateurs/Client.php";

$modele = new ClientModele();

/*
echo "Test 1 : création d'un client\n";
try{
    $client2 = new Client(null, "Ochon", "Paul", "paul.ochon@test.com", "Azerty123/", false, "00-00-00-00-00", "2 rue de l'ailleur", true);
    $modele->ajouter($client2);
    echo "OK - Le client a bien été créer.\n";
} catch (Exception $e) {
    echo "ECHEC - exception attrapée : " . $e->getMessage() . "\n";
}

echo "Test 2 : création d'un client avec mail identique\n";
try{
    $client3 = new Client(null, "Ochon", "Polo", "paul.ochon@test.com", "Azerty123/", false, "00-00-00-00-00", "2 rue de l'ailleur", true);
    $modele->ajouter($client3);
    echo "ECHEC - Le client a bien été créer.\n";
} catch (Exception $e) {
    echo "OK - exception attrapée : " . $e->getMessage() . "\n";
}

echo "Test 3 : rechercherParId sur un client existant\n";
$client = $modele->rechercherParId(3);
if ($client !== null) {
    echo "OK - " . $client->getNom() . "\n";
} else {
    echo "ECHEC - client non trouvé\n";
}

echo "Test 4 : rechercherParId sur un client inexistant\n";
$client = $modele->rechercherParId(895);
if ($client !== null) {
    echo "ECHEC - " . $client->getNom() . "\n";
} else {
    echo "OK - client non trouvé\n";
}
*/

echo "Test 5 : modification d'un utilisateur hors mot de passe\n";
$clientExistant = $modele->rechercherParId(3);
$clientModifier = new Client($clientExistant->getUtilisateursId(), "Chon", "Paulo", "paulo.chon@test.com", $clientExistant->getMotDePasse(), true, $clientExistant->getNumeroTelephone(), "aucune idée", true);
try{
    $modele->modifier($clientModifier);
    echo "Ok - Le client a bien été modifier.\n";
} catch (Exception $e) {
    echo "ECHEC - exception attrapée : " . $e->getMessage() . "\n";
}

echo "Test 6 : modification d'un mot de passe utilisateur\n";
try{
    $modele->modifierMotDePasse(3, "aZERTY123/");
    echo "Ok - Le mdp a bien été modifier.\n";
} catch (Exception $e) {
    echo "ECHEC - exception attrapée : " . $e->getMessage() . "\n";
}
?>