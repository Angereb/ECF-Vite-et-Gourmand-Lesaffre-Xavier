<?php
$_SESSION = [];
$_SESSION["messageSucces"] = "Vous avez été déconnecté.";
session_destroy();

header("Location: ?page=accueil");
exit;
?>