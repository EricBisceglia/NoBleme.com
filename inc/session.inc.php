<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Session sécurisée pour remplacer les sessions normales pas super secures de PHP
// Le token de la session est régénéré à chaque nouveau chargement de page
// À invoquer au début des pages utilisant des sessions, à la place de session_start

function session_start_securise()
{
  // Token public qui sert à identifier la session générale
  $nom_session = 'nobleme_session_secure';

  // On va forcer la session à ne passer que par les cookies
  if (ini_set('session.use_only_cookies', 1) === FALSE) {
      exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Impossible de démarrer une session sécurisée, merci de ne pas bloquer les cookies</body></html>');
  }

  // On chope le cookie actuel
  $cookieParams = session_get_cookie_params();

  // On prépare un nouveau cookie à chaque changement de page
  session_set_cookie_params(  $cookieParams["lifetime"] ,
                              $cookieParams["path"]     ,
                              $cookieParams["domain"]   ,
                              false                     ,  // Une fois que je peux garantir le https partout, mettre true ici
                              true                      ); // Cette ligne fait que le session id ne peut pas être chopé par du js

  // Et on démarre la session
  session_name($nom_session);
  session_start();
  session_regenerate_id();
}