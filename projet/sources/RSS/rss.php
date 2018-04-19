<?php
 //fichier appelé par index.php pour la page RSS

  //On va chercher le fichier php qui contient le code pour mettre à jour le flux RSS
  include_once("update_rss.php");
 
  //On appelle la fonction de mise à jour du fichier
  update_fluxRSS();
 
?>  
