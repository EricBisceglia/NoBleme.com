<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DU FLUX RSS                                                        */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './inc/includes.inc.php'; // Inclusions communes
header("Content-Type: application/rss+xml; charset=UTF-8");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Assemblage du flux RSS

// On va chercher les tâches, selon ce qui est demandé
$qrss = "   ( SELECT    ''                                  AS 'rss_id'       ,
                        0                                   AS 'rss_date'     ,
                        ''                                  AS 'rss_titre'    ,
                        ''                                  AS 'rss_contenu'  ,
                        ''                                  AS 'rss_user'     ,
                        ''                                  AS 'rss_type'
              FROM      vars_globales
              WHERE     vars_globales.mise_a_jour LIKE 'sql_cheat_code' ) ";

if(isset($_GET['flux_irl']) && !isset($_GET['lang_en']))
$qrss .= "  UNION
            ( SELECT    irl.id                              AS 'rss_id'       ,
                        UNIX_TIMESTAMP(irl.date)            AS 'rss_date'     ,
                        irl.date                            AS 'rss_titre'    ,
                        irl.details_fr                      AS 'rss_contenu'  ,
                        ''                                  AS 'rss_user'     ,
                        'irl'                               AS 'rss_type'
              FROM      irl
              ORDER BY  irl.date DESC
              LIMIT     10 ) ";

if(isset($_GET['flux_irl']) && isset($_GET['lang_en']))
$qrss .= "  UNION
            ( SELECT    irl.id                              AS 'rss_id'       ,
                        UNIX_TIMESTAMP(irl.date)            AS 'rss_date'     ,
                        irl.date                            AS 'rss_titre'    ,
                        irl.details_en                      AS 'rss_contenu'  ,
                        ''                                  AS 'rss_user'     ,
                        'irl_en'                            AS 'rss_type'
              FROM      irl
              ORDER BY  irl.date DESC
              LIMIT     10 ) ";

if(isset($_GET['flux_misc']) && !isset($_GET['lang_en']))
$qrss .= "  UNION
            ( SELECT    quotes.id                           AS 'rss_id'       ,
                        quotes.timestamp                    AS 'rss_date'     ,
                        ''                                  AS 'rss_titre'    ,
                        quotes.contenu                      AS 'rss_contenu'  ,
                        ''                                  AS 'rss_user'     ,
                        'misc'                              AS 'rss_type'
              FROM      quotes
              WHERE     quotes.valide_admin = 1
              AND       quotes.timestamp > 0
              ORDER BY  quotes.timestamp DESC
              LIMIT     30 ) ";

if(isset($_GET['flux_ecrivains']) && !isset($_GET['lang_en']))
$qrss .= "  UNION
            ( SELECT    ecrivains_texte.id                  AS 'rss_id'       ,
                        ecrivains_texte.timestamp_creation  AS 'rss_date'     ,
                        ecrivains_texte.titre               AS 'rss_titre'    ,
                        ''                                  AS 'rss_contenu'  ,
                        ''                                  AS 'rss_user'     ,
                        'ecrivains'                         AS 'rss_type'
              FROM      ecrivains_texte
              ORDER BY  ecrivains_texte.timestamp_creation DESC
              LIMIT     20 ) ";

if(isset($_GET['flux_ecrivains_concours']) && !isset($_GET['lang_en']))
$qrss .= "  UNION
            ( SELECT    ecrivains_concours.id               AS 'rss_id'       ,
                        ecrivains_concours.timestamp_debut  AS 'rss_date'     ,
                        ecrivains_concours.titre            AS 'rss_titre'    ,
                        ''                                  AS 'rss_contenu'  ,
                        ''                                  AS 'rss_user'     ,
                        'ecrivains_concours'                AS 'rss_type'
              FROM      ecrivains_concours
              ORDER BY  ecrivains_concours.timestamp_debut DESC
              LIMIT     5 )
            UNION
            ( SELECT    ecrivains_concours.id               AS 'rss_id'       ,
                        ecrivains_concours.timestamp_fin    AS 'rss_date'     ,
                        ecrivains_concours.titre            AS 'rss_titre'    ,
                        ecrivains_texte.anonyme             AS 'rss_contenu'  ,
                        membres.pseudonyme                  AS 'rss_user'     ,
                        'ecrivains_concours_gagnant'        AS 'rss_type'
              FROM      ecrivains_concours
              LEFT JOIN ecrivains_texte ON ecrivains_concours.FKecrivains_texte_gagnant = ecrivains_texte.id
              LEFT JOIN membres         ON ecrivains_concours.FKmembres_gagnant         = membres.id
              WHERE     ecrivains_concours.FKecrivains_texte_gagnant != 0
              ORDER BY  ecrivains_concours.timestamp_fin DESC
              LIMIT     5 )";

if(isset($_GET['flux_devblog']) && !isset($_GET['lang_en']))
$qrss .= "  UNION
            ( SELECT    devblog.id                          AS 'rss_id'       ,
                        devblog.timestamp                   AS 'rss_date'     ,
                        devblog.titre                       AS 'rss_titre'    ,
                        devblog.contenu                     AS 'rss_contenu'  ,
                        ''                                  AS 'rss_user'     ,
                        'devblog'                           AS 'rss_type'
              FROM      devblog
              ORDER BY  devblog.timestamp DESC
              LIMIT     10 ) ";

if(isset($_GET['flux_todo']) && !isset($_GET['lang_en']))
$qrss .= "  UNION
            ( SELECT    todo.id                             AS 'rss_id'       ,
                        todo.timestamp                      AS 'rss_date'     ,
                        todo.titre                          AS 'rss_titre'    ,
                        todo.contenu                        AS 'rss_contenu'  ,
                        membres.pseudonyme                  AS 'rss_user'     ,
                        'todo'                              AS 'rss_type'
              FROM      todo
              LEFT JOIN membres ON todo.FKmembres = membres.id
              WHERE     todo.valide_admin = 1
              AND       todo.public       = 1
              ORDER BY  todo.timestamp DESC
              LIMIT     40 ) ";

if(isset($_GET['flux_todo_fini']) && !isset($_GET['lang_en']))
$qrss .= "  UNION
            ( SELECT    todo.id                             AS 'rss_id'       ,
                        todo.timestamp_fini                 AS 'rss_date'     ,
                        todo.titre                          AS 'rss_titre'    ,
                        todo.contenu                        AS 'rss_contenu'  ,
                        ''                                  AS 'rss_user'     ,
                        'todo_fini'                         AS 'rss_type'
              FROM      todo
              WHERE     todo.valide_admin = 1
              AND       todo.public       = 1
              AND       todo.timestamp_fini > 0
              ORDER BY  todo.timestamp_fini DESC
              LIMIT     40 ) ";

$qrss .= "  ORDER BY rss_date DESC ";

// On envoie la requête
$qrss     = query($qrss);

// On va avoir besoin de l'url complète
$full_url = predata((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"]);

// Et on prépare les données pour les afficher dans le flux, en traitant au cas par cas
for($nrss = 0; $drss = mysqli_fetch_array($qrss); $nrss++)
{
  // Nouvelle IRL
  if($drss['rss_type'] == 'irl')
  {
    $rss_url[$nrss]     = "pages/irl/irl?id=".$drss['rss_id'];
    $rss_date[$nrss]    = predata(date('r', $drss['rss_date']));
    $rss_titre[$nrss]   = "Nouvelle rencontre IRL prévue le ".date('d/m/Y',$drss['rss_date']);
    $rss_contenu[$nrss] = '<b><u>Rencontre IRL du '.datefr(date('Y-m-d',$drss['rss_date'])).'</u></b><br><br>'.bbcode(predata($drss['rss_contenu'], 1));
  }
  else if($drss['rss_type'] == 'irl_en')
  {
    $rss_url[$nrss]     = "pages/irl/irl?id=".$drss['rss_id'];
    $rss_date[$nrss]    = predata(date('r', $drss['rss_date']));
    $rss_titre[$nrss]   = "New real life meetup planned: ".date('d/m/Y',$drss['rss_date']);
    $rss_contenu[$nrss] = '<b><u>'.datefr(date('Y-m-d',$drss['rss_date']), 'EN').' meetup</u></b><br><br>'.bbcode(predata($drss['rss_contenu'], 1));
  }

  // Miscellanées
  else if($drss['rss_type'] == 'misc')
  {
    $rss_url[$nrss]     = "pages/quotes/quote?id=".$drss['rss_id'];
    $rss_date[$nrss]    = predata(date('r', $drss['rss_date']));
    $rss_titre[$nrss]   = "Nouvelle miscellanée : #".$drss['rss_id'];
    $rss_contenu[$nrss] = predata($drss['rss_contenu'], 1);
  }

  // Textes du coin des écrivains
  else if($drss['rss_type'] == 'ecrivains')
  {
    $rss_url[$nrss]     = "pages/ecrivains/texte?id=".$drss['rss_id'];
    $rss_date[$nrss]    = predata(date('r', $drss['rss_date']));
    $rss_titre[$nrss]   = "Coin des écrivains : Nouveau texte";
    $rss_contenu[$nrss] = "Un nouveau texte a été publié dans le coin des écrivains de NoBleme : « ".predata($drss['rss_titre'])." »";
  }

  // Concours du coin des écrivains
  else if($drss['rss_type'] == 'ecrivains_concours')
  {
    $rss_url[$nrss]     = "pages/ecrivains/concours?id=".$drss['rss_id'];
    $rss_date[$nrss]    = predata(date('r', $drss['rss_date']));
    $rss_titre[$nrss]   = "Coin des écrivains : Nouveau concours ouvert";
    $rss_contenu[$nrss] = "Le concours du coin des écrivains de NoBleme « ".predata($drss['rss_titre'])." » vient de commencer.";
  }

  // Gagnant du concours du coin des écrivains
  else if($drss['rss_type'] == 'ecrivains_concours_gagnant')
  {
    $rss_url[$nrss]     = "pages/ecrivains/concours?id=".$drss['rss_id'];
    $rss_date[$nrss]    = predata(date('r', $drss['rss_date']));
    $rss_titre[$nrss]   = "Coin des écrivains : Concours fini";
    $temp_gagnant       = ($drss['rss_contenu']) ? 'Un NoBlemeux anonyme' : $drss['rss_user'];
    $rss_contenu[$nrss] = predata($temp_gagnant)." a gagné le concours du coin des écrivains de NoBleme « ".predata($drss['rss_titre'])." ».<br><br>Tous les textes publiés en participation au concours sont maintenant disponibles à la lecture.";
  }

  // Nouveau devblog
  if($drss['rss_type'] == 'devblog')
  {
    $rss_url[$nrss]     = "pages/devblog/devblog?id=".$drss['rss_id'];
    $rss_date[$nrss]    = predata(date('r', $drss['rss_date']));
    $rss_titre[$nrss]   = "Blog de développement : #".$drss['rss_id'];
    $rss_contenu[$nrss] = '<b><u>'.predata($drss['rss_titre']).'</u></b><br><br>'.tronquer_chaine($drss['rss_contenu'],200,'...');
  }

  // Tâche ouverte
  if($drss['rss_type'] == 'todo')
  {
    $rss_url[$nrss]     = "pages/todo/index?id=".$drss['rss_id'];
    $rss_date[$nrss]    = predata(date('r', $drss['rss_date']));
    $rss_titre[$nrss]   = "Nouvelle tâche ouverte : #".$drss['rss_id'];
    $rss_contenu[$nrss] = "Tâche proposée par ".predata($drss['rss_user']).'<br><u>'.predata($drss['rss_titre']).'</u><br><br>'.bbcode(predata($drss['rss_contenu'], 1));
  }

  // Tâche fermée
  else if($drss['rss_type'] == 'todo_fini')
  {
    $rss_url[$nrss]     = "pages/todo/index?id=".$drss['rss_id']."&amp;fini";
    $rss_date[$nrss]    = predata(date('r', $drss['rss_date']));
    $rss_titre[$nrss]   = "Tâche résolue : #".$drss['rss_id'];
    $rss_contenu[$nrss] = '<u>'.predata($drss['rss_titre']).'</u><br><br>'.bbcode(predata($drss['rss_contenu'], 1));
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         GÉNÉRATION DU FLUX RSS                                                        */
/*                                                                                                                                       */
/**************************************************************************************/ echo('<?xml version="1.0" encoding="UTF-8"?>'); ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">

<channel>
  <atom:link href="<?=$full_url?>" rel="self" type="application/rss+xml" />
  <title>NoBleme.com</title>
  <link><?=$full_url?></link>

  <?php if(!isset($_GET['lang_en'])) { ?>
  <description>Flux RSS de NoBleme.com</description>
  <language>fr-fr</language>

  <?php } else { ?>
  <description>NoBleme.com's RSS feeds</description>
  <language>en-gb</language>
  <?php } ?>

  <?php for($i=0;$i<$nrss;$i++) { ?>
  <item>
    <guid><?=$GLOBALS['url_site']?><?=$rss_url[$i]?></guid>
    <link><?=$GLOBALS['url_site']?><?=$rss_url[$i]?></link>
    <title><?=$rss_titre[$i]?></title>
    <description><![CDATA[<?=$rss_contenu[$i]?>]]></description>
    <pubDate><?=$rss_date[$i]?></pubDate>
  </item>
  <?php } ?>

</channel>

</rss>