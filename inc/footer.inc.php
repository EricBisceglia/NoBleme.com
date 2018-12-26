<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Définition du nombre de pageviews

$page_views = isset($pageviews) ? "Cette page a été consultée ".$pageviews." fois" : "";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Version actuelle

$dversion = mysqli_fetch_array(query("  SELECT    version.version AS 'v_version'  ,
                                                  version.build   AS 'v_build'    ,
                                                  version.date    AS 'v_date'
                                        FROM      version
                                        ORDER BY  version.id DESC LIMIT 1 "));
$version = "Version ".$dversion['v_version'].", build ".$dversion['v_build'];
$version .= ($lang == 'FR') ? " du ".jourfr($dversion['v_date'], 'FR') : " - ".jourfr($dversion['v_date'], 'EN');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contenu multilingue

$trad['footer_lien']  = ($lang == 'FR') ? "pages/todo/roadmap" : "pages/nobleme/coulisses";
$trad['footer_legal'] = ($lang == 'FR') ? "Mentions légales &amp; confidentialité" : "Legal notices and privacy policy";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Temps de chargement

$time_chargement  = round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 3);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/**************************************************************************************************************************************/ ?>

<!-- ######################################################################################################################################
#                                                                 FOOTER                                                                  #
###################################################################################################################################### !-->

      <?php if(!isset($_GET["popup"]) && !isset($_GET["popout"]) && !isset($_GET["dynamique"])) { ?>

      <footer>
        <?php if(isset($shorturl)) { ?>
        <a href="<?=$chemin?>s?<?=$shorturl?>">Lien court vers cette page</a><br>
        <?php } if(loggedin() && getadmin()) { ?>
        <a href="<?=$chemin?>pages/admin/pageviews"><?=$page_views?></a><br>
        <a>Page chargée en <?=$time_chargement?>s avec <?=$GLOBALS['query']?> requêtes</a><br>
        <?php } ?>
        <a href="<?=$chemin?><?=$trad['footer_lien']?>"><?=$version?></a><br>
        <a href="<?=$chemin?>pages/doc/mentions_legales"><?=$trad['footer_legal']?></a><br>
        <a href="<?=$chemin?>pages/doc/nobleme">&copy; NoBleme.com : 2005 - <?=date('Y')?></a>
      </footer>
    </div>
  </div>

  <?php } ?>

  </body>
</html>