<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                          PRÉPARATION DU JSON                                                          */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Assemblage du JSON à renvoyer

// On va chercher les citations
$qmisc  = "   SELECT    quotes.id         AS 'q_id'         ,
                        quotes.timestamp  AS 'q_timestamp'  ,
                        quotes.langue     AS 'q_lang'       ,
                        quotes.contenu    AS 'q_contenu'    ,
                        quotes.nsfw       AS 'q_nsfw'
              FROM      quotes
              WHERE     quotes.valide_admin = 1 ";

// On récupère les paramètres demandés
$misc_id      = isset($_GET['id']) ? postdata($_GET['id'], 'int') : 0;
$misc_lang    = isset($_GET['lang']) ? postdata($_GET['lang'], 'string') : '';
$misc_search  = isset($_GET['search']) ? postdata($_GET['search'], 'string') : '';
$misc_clean   = isset($_GET['clean']) ? 1 : 0;

// On fait les recherches si nécessaire
if($misc_id)
  $qmisc .= " AND       quotes.id           = '$misc_id' ";
if($misc_lang)
  $qmisc .= " AND       quotes.langue       LIKE '$misc_lang' ";
if($misc_search)
  $qmisc .= " AND       quotes.contenu      LIKE '%$misc_search%' ";
if($misc_clean)
  $qmisc .= " AND       quotes.nsfw         = 0 ";

// On envoie la requête
$qmisc .= "   ORDER BY  quotes.timestamp DESC ";
$qmisc  = query($qmisc);

// On prépare le tableau vide pour renvoyer les données
$return_json = array();

// On insère les citations dans le tableau
for($nmisc = 0; $dmisc = mysqli_fetch_array($qmisc); $nmisc++)
{
  $tempobject         = array(
    'id'        => $dmisc['q_id']                                               ,
    'url'       => $GLOBALS['url_site'].'pages/quotes/quote?id='.$dmisc['q_id'] ,
    'timestamp' => $dmisc['q_timestamp']                                        ,
    'lang'      => $dmisc['q_lang']                                             ,
    'text'      => str_replace(PHP_EOL, " ", $dmisc['q_contenu'])               ,
    'nsfw'      => ($dmisc['q_nsfw']) ? true : false
  );
  array_push($return_json, $tempobject);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Envoi du JSON

// S'il n'y a pas de retour, on envoie une 404
if($return_json == array())
  exit(header("HTTP/1.0 404 Not Found"));

// On annonce que c'est du json
header("Content-Type: application/json; charset=UTF-8");

// Puis on affiche le JSON
echo json_encode($return_json, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);