<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Définition du nombre de pageviews

$page_views = isset($pageviews) ? "Cette page a été consultée ".$pageviews." fois" : "";



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Version actuelle

$dversion = mysqli_fetch_array(query("  SELECT    system_versions.version AS 'v_version'  ,
                                                  system_versions.build   AS 'v_build'    ,
                                                  system_versions.date    AS 'v_date'
                                        FROM      system_versions
                                        ORDER BY  system_versions.id DESC LIMIT 1 "));
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
        <a href="<?=$path?>s?<?=$shorturl?>">Lien court vers cette page</a><br>
        <?php } if(user_is_logged_in() && $est_admin) { ?>
        <a href="<?=$path?>pages/admin/pageviews"><?=$page_views?></a><br>
        <a>Page chargée en <?=$time_chargement?>s avec <?=$GLOBALS['query']?> requêtes</a><br>
        <?php } ?>
        <a href="<?=$path?><?=$trad['footer_lien']?>"><?=$version?></a><br>
        <a href="<?=$path?>pages/doc/mentions_legales"><?=$trad['footer_legal']?></a><br>
        <a href="<?=$path?>pages/doc/nobleme">&copy; NoBleme.com : 2005 - <?=date('Y')?></a>
      </footer>
    </div>
  </div>

  <?php } ?>

  </body>
</html>