<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Définition du nombre de pageviews

$page_views = isset($pageviews) ? "Cette page a été consultée ".$pageviews." fois" : "";


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Version actuelle

$qversion = mysqli_fetch_array(query("SELECT version.version, version.build, version.date FROM version ORDER BY version.id DESC LIMIT 1"));
$version = "Version ".$qversion['version'].", build ".$qversion['build'];
$version .= ($lang == 'FR') ? " du ".jourfr($qversion['date'], 'FR') : " - ".jourfr($qversion['date'], 'EN');


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contenu multilingue

$trad['footer_dev'] = ($lang == 'FR') ? "Développé et administré par " : "Developed and administered by ";





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
        <?php } if(loggedin() && getadmin($_SESSION['user'])) { ?>
        <a href="<?=$chemin?>pages/admin/stats_pageviews"><?=$page_views?></a><br>
        <?php } ?>
        <a href="<?=$chemin?>pages/todo/roadmap"><?=$version?></a><br>
        <a href="<?=$chemin?>pages/user/user?id=1"><?=$trad['footer_dev']?> <span class="gras">Bad</span></a><br>
        <a href="<?=$chemin?>pages/doc/nobleme">NoBleme.com: 2005 - <?=date('Y')?></a>
      </footer>
    </div>
  </div>

  <?php } ?>

  </body>
</html>