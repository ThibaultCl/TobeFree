<?php 
//fichier appelé par index.php pour déconnecter l'utilisateur

// Suppression des variables de session et de la session
$_SESSION = array();

session_destroy();

// Suppression des cookies de connexion automatique

setcookie('login', '');

//message de confirmation et redirection vers la page d'accueil
echo "<script>alert('Vous êtes maintenant déconnecté !');window.location.replace(\"..\");</script>";

?>