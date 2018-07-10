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

$trad['footer_dev'] = ($lang == 'FR') ? "Développé et administré par " : "Developed and administered by ";


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
        <a href="<?=$chemin?>pages/todo/roadmap"><?=$version?></a><br>
        <a href="<?=$chemin?>pages/user/user?id=1"><?=$trad['footer_dev']?> <span class="gras">Bad</span></a><br>
        <a href="<?=$chemin?>pages/doc/nobleme">NoBleme.com : 2005 - <?=date('Y')?></a>
      </footer>
    </div>
  </div>

  <?php } ?>

  </body>
</html>