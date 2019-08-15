<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                          PRÉPARATION DU JSON                                                          */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Assemblage du JSON à renvoyer

// On récupère les paramètres demandés
$nbdb_lang    = isset($_GET['lang']) ? changer_casse(postdata($_GET['lang'], 'string'), 'min') : 'en';
$nbdb_type    = isset($_GET['type']) ? postdata($_GET['type'], 'string') : 'both';
$nbdb_title   = isset($_GET['title']) ? postdata($_GET['title'], 'string') : '';
$nbdb_search  = isset($_GET['search']) ? postdata($_GET['search'], 'string') : '';

// On va chercher les entrées de l'encyclopédie de la culture internet
$qnbdb  = "   ( SELECT    'web'                             AS 'n_type'   ,
                          nbdb_web_page.id                  AS 'n_id'     ,
                          nbdb_web_page.titre_$nbdb_lang    AS 'n_titre'  ,
                          nbdb_web_page.contenu_$nbdb_lang  AS 'n_body'
                FROM      nbdb_web_page
                WHERE     nbdb_web_page.titre_$nbdb_lang != '' ";

// On fait les recherches si nécessaire
if($nbdb_title)
  $qnbdb .= " AND       nbdb_web_page.titre_$nbdb_lang        LIKE '%$nbdb_title%' ";
else
  $qnbdb .= " AND       nbdb_web_page.redirection_$nbdb_lang  LIKE '' ";
if($nbdb_search)
  $qnbdb .= " AND       nbdb_web_page.contenu_$nbdb_lang      LIKE '%$nbdb_search%' ";

// On va chercher les entrées du dictionnaire de la culture internet
$qnbdb .= " ) UNION
              ( SELECT    'dico'                                    AS 'n_type'   ,
                          nbdb_web_definition.id                    AS 'n_id'     ,
                          nbdb_web_definition.titre_$nbdb_lang      AS 'n_titre'  ,
                          nbdb_web_definition.definition_$nbdb_lang AS 'n_body'
                FROM      nbdb_web_definition
                WHERE     nbdb_web_definition.titre_$nbdb_lang != '' ";

// On fait les recherches si nécessaire
if($nbdb_title)
  $qnbdb .= " AND       nbdb_web_definition.titre_$nbdb_lang        LIKE '%$nbdb_title%' ";
else
  $qnbdb .= " AND       nbdb_web_definition.redirection_$nbdb_lang  LIKE '' ";
if($nbdb_search)
  $qnbdb .= " AND       nbdb_web_definition.definition_$nbdb_lang   LIKE '%$nbdb_search%' ";

// On trie les entrées
$qnbdb .= " ) ORDER BY n_titre ASC ";

// On envoie la requête
$qnbdb  = query($qnbdb);

// On prépare le tableau vide pour renvoyer les données
$return_json = array();

// On parcourt les résultats
for($nmisc = 0; $dnbdb = mysqli_fetch_array($qnbdb); $nmisc++)
{
  // On nettoie les BBCodes
  $nbdb_body = str_replace("[b]", "", $dnbdb['n_body']);
  $nbdb_body = str_replace("[/b]", "", $nbdb_body);
  $nbdb_body = str_replace("[i]", "", $nbdb_body);
  $nbdb_body = str_replace("[/i]", "", $nbdb_body);
  $nbdb_body = str_replace("[u]", "", $nbdb_body);
  $nbdb_body = str_replace("[/u]", "", $nbdb_body);
  $nbdb_body = str_replace("[s]", "", $nbdb_body);
  $nbdb_body = str_replace("[/s]", "", $nbdb_body);
  $nbdb_body = str_replace("[ins]", "", $nbdb_body);
  $nbdb_body = str_replace("[/ins]", "", $nbdb_body);
  $nbdb_body = str_replace("[del]", "", $nbdb_body);
  $nbdb_body = str_replace("[/del]", "", $nbdb_body);
  $nbdb_body = preg_replace('/\[url\](.*?)\[\/url\]/is','[link: $1 ]', $nbdb_body);
  $nbdb_body = preg_replace('/\[url\=(.*?)\](.*?)\[\/url\]/is','[link: $1 ]', $nbdb_body);
  $nbdb_body = preg_replace('/\[img\](.*?)\[\/img\]/is','[image: $1 ]', $nbdb_body);
  $nbdb_body = preg_replace('/\[align\=(left|center|right)\](.*?)\[\/align\]/is','$1', $nbdb_body);
  $nbdb_body = preg_replace('/\[color\=(.*?)\](.*?)\[\/color\]/is','$2', $nbdb_body);
  $nbdb_body = preg_replace('/\[size\=(.*?)\](.*?)\[\/size\]/is','$2', $nbdb_body);
  $nbdb_body = preg_replace('/\[code\](.*?)\[\/code\]/is','$1', $nbdb_body);
  $nbdb_body = preg_replace('/\[youtube\](.*?)\[\/youtube\]/is','', $nbdb_body);
  $nbdb_body = preg_replace('/\[twitter\](.*?)\[\/twitter\]/is','', $nbdb_body);
  $nbdb_body = preg_replace('/\[quote\](.*?)\[\/quote\]/is','[quote: $1]', $nbdb_body);
  $nbdb_body = preg_replace('/\[quote=(.*?)\](.*?)\[\/quote\]/is','[quote by $1: $2]', $nbdb_body);
  $nbdb_body = preg_replace('/\[spoiler\](.*?)\[\/spoiler\]/is','[spoiler]', $nbdb_body);
  $nbdb_body = preg_replace('/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is','[spoiler]', $nbdb_body);
  $nbdb_body = preg_replace('/\[blur\](.*?)\[\/blur\]/is','$1', $nbdb_body);
  $nbdb_body = preg_replace('/\[space\]/is',' ', $nbdb_body);
  $nbdb_body = preg_replace('/\[line\]/is',' ---- ', $nbdb_body);

  // On nettoie les NBDBcodes
  $nbdb_body = preg_replace('/\[\[web:(.*?)\|(.*?)\]\]/i','$2', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[dico:(.*?)\|(.*?)\]\]/i','$2', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[lien:(.*?)\|(.*?)\]\]/i','$2', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[lien:(.*?)\]\]/i','$1', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[image:(.*?)\|(.*?)\|(.*?)\]\]/i','[image: '.$GLOBALS['url_site'].'img/nbdb_web/$1 ]', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[image:(.*?)\|(.*?)\]\]/i','[image: '.$GLOBALS['url_site'].'img/nbdb_web/$1 ]', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[image:(.*?)\]\]/i','[image: '.$GLOBALS['url_site'].'img/nbdb_web/$1 ]', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[image-nsfw:(.*?)\|(.*?)\|(.*?)\]\]/i','[image nsfw: '.$GLOBALS['url_site'].'img/nbdb_web/$1 ]', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[image-nsfw:(.*?)\|(.*?)\]\]/i','[image nsfw: '.$GLOBALS['url_site'].'img/nbdb_web/$1 ]', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[image-nsfw:(.*?)\]\]/i','[image nsfw: '.$GLOBALS['url_site'].'img/nbdb_web/$1 ]', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[youtube:(.*?)\|(.*?)\|(.*?)\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[youtube:(.*?)\|(.*?)\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[youtube:(.*?)\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\|(.*?)\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[youtube-nsfw:(.*?)\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[galerie\]\](.*?)\[\[\/galerie\]\]/is', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[galerie:(.*?)\|youtube\|(.*?)\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[galerie:(.*?)\|youtube\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[galerie:(.*?)\|(.*?)\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[galerie:(.*?)\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[galerie-nsfw:(.*?)\|youtube\|(.*?)\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[galerie-nsfw:(.*?)\|youtube\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[galerie-nsfw:(.*?)\|(.*?)\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[galerie-nsfw:(.*?)\]\]/i', '', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[trends:(.*?)\]\]/i', '[Google trends: $1]', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[trends2:(.*?)\|(.*?)\]\]/i', '[Google trends: $1, $2]', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[trends3:(.*?)\|(.*?)\|(.*?)\]\]/i', '[Google trends: $1, $2, $3]', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[trends4:(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i', '[Google trends: $1, $2, $3, $4]', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[trends5:(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i', '[Google trends: $1, $2, $3, $4, $5]', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[copypasta\=(.*?)\]\](.*?)\[\[\/copypasta\]\]/is', '$2', $nbdb_body);
  $nbdb_body = preg_replace('/\[\[copypasta-nsfw\=(.*?)\]\](.*?)\[\[\/copypasta-nsfw\]\]/is', '$2', $nbdb_body);

  // On insère les données dans le tableau, tout en filtrant les types de résultats demandés
  if($nbdb_type == 'both' || ($nbdb_type == 'encyclopedia' && $dnbdb['n_type'] == 'web') || ($nbdb_type == 'dictionary' && $dnbdb['n_type'] == 'dico'))
  {
    $tempobject   = array(
      'uuid'      => $nmisc                                                       ,
      'type'      => ($dnbdb['n_type'] == 'web') ? 'encyclopedia' : 'dictionary'  ,
      'url'       => ($dnbdb['n_type'] == 'web') ? $GLOBALS['url_site'].'pages/nbdb/web?id='.$dnbdb['n_id'] : $GLOBALS['url_site'].'pages/nbdb/web_dictionnaire?id='.$dnbdb['n_id']             ,
      'shorturl'  => ($dnbdb['n_type'] == 'web') ? $GLOBALS['url_site'].'s?w='.$dnbdb['n_id'] : $GLOBALS['url_site'].'s?wd='.$dnbdb['n_id']                                                   ,
      'title'     => str_replace(PHP_EOL, " ", $dnbdb['n_titre'])                 ,
      'body'      => str_replace(PHP_EOL, " ", $nbdb_body)
    );
    array_push($return_json, $tempobject);
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Envoi du JSON

// S'il n'y a pas de retour, on envoie une 404
if($return_json == array())
  exit(header("HTTP/1.0 404 Not Found"));

// On annonce que c'est du json
header("Content-Type: application/json; charset=UTF-8");

// Puis on affiche le JSON
echo json_encode($return_json, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);