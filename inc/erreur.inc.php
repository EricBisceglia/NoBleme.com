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
// $message                     est le message d'erreur à écrire
// $chemin          (optionnel) est le chemin relatif jusqu'à l'index du site
// $lang            (optionnel) est la langue actuellement utilisée
// $menu_principal  (optionnel) est le menu principal du header dans lequel on se trouve
// $menu_lateral    (optionnel) est le menu latéral du header dans lequel on se trouve
//
// Exemple d'utilisation:
// erreur("Chiens interdits, même tenus en laisse", $chemin, $lang);

function erreur($message, $chemin='./../../', $lang=NULL, $menu_principal='NoBleme', $menu_lateral='Accueil')
{
  // L'user est-il connecté ?
  $est_connecte = (isset($_SESSION['user'])) ? $_SESSION['user'] : 0;

  // L'user est-il mod, sysop, ou admin ?
  if(!$est_connecte)
  {
    $est_admin      = 0;
    $est_sysop      = 0;
    $est_moderateur = 0;
  }
  else
  {
    $id_user = postdata($est_connecte, 'int', 0);
    $ddroits = mysqli_fetch_array(query(" SELECT  membres.admin       AS 'm_admin'  ,
                                                  membres.sysop       AS 'm_sysop'  ,
                                                  membres.moderateur  AS 'm_mod'
                                          FROM    membres
                                          WHERE   membres.id = '$id_user' "));
    $est_admin      = $ddroits['m_admin'];
    $est_sysop      = ($est_admin || $ddroits['m_sysop']) ? 1 : 0;
    $est_moderateur = $ddroits['m_mod'];
  }

  // Détermination de la langue à utiliser
  $temp_lang  = (!isset($_SESSION['lang'])) ? 'FR' : $_SESSION['lang'];
  $lang       = ($lang) ? $lang : $temp_lang;

  // Menus du header
  $header_menu      = $menu_principal;
  $header_sidemenu  = $menu_lateral;

  // Erreur
  $error_mode = 1;

  // Titre et description
  $langue_page  = array('FR','EN');
  $page_titre   = ($lang == 'FR') ? "Erreur" : "Error";
  $page_desc    = "Ceci est une page d'erreur. Vous allez oublier l'existence de cette page. Ne paniquez pas, le flash rouge est normal.";

  // Identification
  $page_nom = "Se prend une erreur";

  // Contenu multilingue
  $trad = array();
  $trad['ohno'] = ($lang == 'FR') ? "OH NON &nbsp;: (" : "OH NO &nbsp;: (";
  $trad['oups'] = ($lang == 'FR') ? "VOUS AVEZ RENCONTRÉ UNE ERREUR" : "YOU HAVE ENCOUNTERED AN ERROR";

  // HTML
  include $chemin.'inc/header.inc.php';
  ?>

  <br>
  <br>
  <br>
  <br>

  <div class="indiv align_center">
    <h3><?=$trad['ohno']?></h3>
    <br>
    <h3><?=$trad['oups']?></h3>
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