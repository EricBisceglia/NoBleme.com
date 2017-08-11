<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de renvoi d'une page d'erreur
// A n'utiliser qu'avant l'inclusion du header!
// Se conclut par un exit();
//
// Exemple d'utilisation:
// erreur("Chiens interdits, même tenus en laisse");

function erreur($message)
{
  // Redéfinition du $chemin

  // La base est différente selon si on est en localhost ou en prod
  if($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "127.0.0.1")
    $count_base = 3;
  else
    $count_base = 2;

  // Déterminer à combien de dossiers de la racine on est
  $longueur = count(explode( '/', $_SERVER['REQUEST_URI']));

  // Si on est à la racine, laisser le chemin tel quel
  if($longueur <= $count_base)
    $chemin = "";

  // Sinon, partir de ./ puis déterminer le nombre de ../ à rajouter
  else
  {
    $chemin = "./";
    for ($i=0 ; $i<($longueur-$count_base) ; $i++)
      $chemin .= "../";
  }

  // Erreur
  $error_mode = 1;

  // Titre et description
  $page_titre = "Erreur";
  $page_desc  = "Ceci est une page d'erreur. Vous allez oublier l'existence de cette page. Ne paniquez pas, le flash rouge est normal.";

  // Identification
  $page_nom = "erreur";

  // HTML
  include './../../inc/header.inc.php';
  ?>

  <br>
  <br>
  <br>
  <br>
  <br>
  <br>

  <div class="margin_auto align_center" style="width:1000px;">
    <h3>Vous avez rencontré une erreur !</h3>
    <br>
    <br>
     <br>
    <h3><?=$message?></h3>
  </div>

  <br>
  <br>
  <br>

  <?php
  include './../../inc/footer.inc.php';
  exit ();
}