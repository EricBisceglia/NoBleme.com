<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'discuter';
$header_submenu   = 'forum';

// Titre et description
$page_titre = "Forum";
$page_desc  = "Le forum NoBleme... plus ou moins";

// Identification
$page_nom = "forum";
$page_id  = "loljk";

// CSS & JS
$css = array('forum_loljk');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On chope les threads
$qforumjk = query(" SELECT    forum_loljk.id        AS 'jk_id'      ,
                              forum_loljk.titre     AS 'jk_titre'   ,
                              membres.pseudonyme    AS 'jk_user'
                    FROM      forum_loljk
                    LEFT JOIN membres ON forum_loljk.FKauteur = membres.id
                    WHERE     forum_loljk.threadparent = 0
                    ORDER BY  forum_loljk.timestamp DESC ");

// Et on prépare à l'affichage
for($nforumjk = 0 ; $dforumjk = mysqli_fetch_array($qforumjk) ; $nforumjk++)
{
  $jk_id[$nforumjk]     = $dforumjk['jk_id'];
  $jk_titre[$nforumjk]  = $dforumjk['jk_titre'];
  $jk_auteur[$nforumjk] = $dforumjk['jk_user'];
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/forumloljk/forum_jk.png" alt="Le forum nobleme xd">
    </div>
    <br>

    <div class="body_main midsize">

      <table class="intable">
        <tr>
          <td class="comicsans gros gras align_center">
            <a href="<?=$chemin?>pages/forum/topic?new">++++ Créer un nouveau sujet de discussion ++++</a>
          </td>
        </tr>
        <tr>
          <td>
            <br><hr>
          </td>
        </tr>

        <?php for($i=0;$i<$nforumjk;$i++) { ?>
        <tr>
          <td class="comicsans gros">
            <span style="color:#<?=substr(md5(rand()), 0, 6);?>"><a class="blank" style="color:#<?=substr(md5(rand()), 0, 6);?>" href="<?=$chemin?>pages/forum/topic?id=<?=$jk_id[$i]?>"><?=$jk_titre[$i]?> (<?=$jk_auteur[$i]?>)</span><hr>
          </td>
        </tr>
        <?php } ?>

        <tr>
          <td class="comicsans gros gras align_center">
            <a href="<?=$chemin?>pages/forum/topic?new">++++ Créer un nouveau sujet de discussion ++++</a>
          </td>
        </tr>

      </table>

    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';