<?php 
require_once __DIR__ . "/../Modeles/Utilisateurs/EmployeModele.php";
require_once __DIR__ . "/../Modeles/Utilisateurs/Employe.php";

$modele = new EmployeModele();

/*
echo "Test 1 : création d'un Employe\n";
try{
    $employe2 = new Employe(null, "Assaut", "Richard", "richard.assaut@test.com", "Azerty123/", false, true, true);
    $modele->ajouter($employe2);
    echo "OK - L'employe a bien été créer.\n";
} catch (Exception $e) {
    echo "ECHEC - exception attrapée : " . $e->getMessage() . "\n";
}

echo "Test 2 : création d'un employe avec mail identique\n";
try{
    $employe3 = new Employe(null, "Assaut", "Ricardo", "richard.assaut@test.com", "Azerty123/", false, true, true);
    $modele->ajouter($employe3);
    echo "ECHEC - L'employe a bien été créer.\n";
} catch (Exception $e) {
    echo "OK - exception attrapée : " . $e->getMessage() . "\n";
}
*/
echo "Test 3 : rechercherParId sur un employe existant\n";
$employe = $modele->rechercherParId(6);
if ($employe !== null) {
    echo "OK - " . $employe->getNom() . "\n";
} else {
    echo "ECHEC - employe non trouvé\n";
}

echo "Test 4 : rechercherParId sur un employe inexistant\n";
$employe = $modele->rechercherParId(895);
if ($employe !== null) {
    echo "ECHEC - " . $employe->getNom() . "\n";
} else {
    echo "OK - employe non trouvé\n";
}

echo "Test 5 : modification d'un utilisateur hors mot de passe\n";
$employeExistant = $modele->rechercherParId(6);
$employeModifier = new Employe($employeExistant->getUtilisateursId(), "Assault", "Richard", "richard.assault@test.com", $employeExistant->getMotDePasse(), true, true, true);
try{
    $modele->modifier($employeModifier);
    echo "Ok - L'employe a bien été modifier.\n";
} catch (Exception $e) {
    echo "ECHEC - exception attrapée : " . $e->getMessage() . "\n";
}

echo "Test 6 : modification d'un mot de passe utilisateur\n";
try{
    $modele->modifierMotDePasse(6, "aZERTY123/");
    echo "Ok - Le mdp a bien été modifier.\n";
} catch (Exception $e) {
    echo "ECHEC - exception attrapée : " . $e->getMessage() . "\n";
}
?>