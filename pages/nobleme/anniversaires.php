<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Anniversaires";
$page_desc  = "Anniversaires des NoBlemeux en cours et/ou à venir";

// Identification
$page_nom = "nobleme";
$page_id  = "anniversaires";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Anniversaires réels

// Requête pour récupérer les users (c'est magique, ça marche, j'y touche plus)
$qannivirl =  query(" SELECT  membres.id              ,
                              membres.pseudonyme      ,
                              membres.admin           ,
                              membres.sysop           ,
                              membres.anniversaire    ,
                              membres.derniere_visite ,
                              YEAR(CURDATE()) - YEAR(membres.anniversaire) AS 'xeme_anniv'
                    FROM      membres
                    WHERE     membres.anniversaire != '0000-00-00'
                    ORDER BY  (MONTH(membres.anniversaire) , DAY(membres.anniversaire)) < ( MONTH(CURDATE()), DAY(CURDATE()) )  ,
                              MONTH(membres.anniversaire)                                                                       ,
                              DAY(membres.anniversaire)                                                                         ,
                              membres.pseudonyme
                    LIMIT     25 ");

// Préparation des données
$nannivirl = 0;
while($dannivirl = mysqli_fetch_array($qannivirl))
{
  // On détermine si l'anniv est cette année ou la prochaine
  $moisjour = substr($dannivirl['anniversaire'],-5,2)."-".substr($dannivirl['anniversaire'],-2,2)." ";
  if(date('m-d') < $moisjour)
    $cann = date('Y')."-".$moisjour;
  else
    $cann = (date('Y')+1)."-".$moisjour;

  // Puis on calcule les jours restants avant l'anniv et on ne garde que les annivs ayant lieu dans moins de 30 jours
  if (((strtotime($cann)-time())/86400) < 90)
  {
    // Si c'est bon, on prépare les données pour l'affichage
    $annivirl_id[$nannivirl]      = $dannivirl['id'];
    $annivirl_pseudo[$nannivirl]  = $dannivirl['pseudonyme'];
    $annivirl_date[$nannivirl]    = jourfr($dannivirl['anniversaire']);
    $annivirl_css[$nannivirl]     = ((time() - $dannivirl['derniere_visite']) < 2678400) ? ' gras' : ' ';
    $annivirl_linkcss[$nannivirl] = ($dannivirl['admin'] || $dannivirl['sysop']) ? 'texte_blanc nolink' : 'dark blank ';

    // Déterminer le style des lignes qui sont aujourd'hui
    if(date('md') == (substr($dannivirl['anniversaire'],-5,2).substr($dannivirl['anniversaire'],-2,2)))
    {
      if ($dannivirl['admin'])
        $annivirl_css[$nannivirl] .= ' mise_a_jour texte_blanc gras';
      else if ($dannivirl['sysop'])
        $annivirl_css[$nannivirl] .= ' sysop texte_blanc gras';
      else
        $annivirl_css[$nannivirl] .= ' vert_background gras';
      $annivirl_age[$nannivirl]   = 'Joyeux '.$dannivirl['xeme_anniv'].' ans !';
    }
    else
    {
      // On calcule quand est l'anniversaire
      if((date('md')-(substr($dannivirl['anniversaire'],-5,2).substr($dannivirl['anniversaire'],-2,2))) > 0)
        $annivirl_age[$nannivirl]    = dans(strtotime((date('Y')+1).'-'.(substr($dannivirl['anniversaire'],-5,2).'-'.(substr($dannivirl['anniversaire'],-2,2)))));
      else
        $annivirl_age[$nannivirl]    = dans(strtotime((date('Y')).'-'.(substr($dannivirl['anniversaire'],-5,2).'-'.(substr($dannivirl['anniversaire'],-2,2)))));
      // On finit le style des lignes
      if ($dannivirl['admin'])
        $annivirl_css[$nannivirl] .= ' mise_a_jour texte_blanc gras';
      else if ($dannivirl['sysop'])
        $annivirl_css[$nannivirl] .= ' sysop texte_blanc gras';
      else if ((time() - $dannivirl['derniere_visite']) < 2678400)
        $annivirl_css[$nannivirl] .= ' nobleme_background';
    }

    // On peut incrémenter
    $nannivirl++;
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Anniversaires noblemeux

// Requête pour récupérer les users (c'est magique, ça marche, j'y touche plus)
$qannivnb = query(" SELECT    membres.id                                                                        ,
                              membres.pseudonyme                                                                ,
                              membres.admin                                                                     ,
                              membres.sysop                                                                     ,
                              membres.date_creation                                                             ,
                              membres.derniere_visite                                                           ,
                              DATE(FROM_UNIXTIME(membres.date_creation))                          AS inscr      ,
                              YEAR(CURDATE()) - YEAR(DATE(FROM_UNIXTIME(membres.date_creation)))  AS xeme_anniv
                    FROM      membres
                    ORDER BY  (MONTH(DATE(FROM_UNIXTIME(membres.date_creation))) , DAY(DATE(FROM_UNIXTIME(membres.date_creation)))) < ( MONTH(CURDATE()), DAY(CURDATE()) ) ,
                              MONTH(DATE(FROM_UNIXTIME(membres.date_creation))) ,
                              DAY(DATE(FROM_UNIXTIME(membres.date_creation))) ,
                              membres.pseudonyme
                    LIMIT     25 ");

// Préparation des données
$nannivnb = 0;
while($dannivnb = mysqli_fetch_array($qannivnb))
{
  // On ne veut pas des nouveaux inscrits
  if((time() - $dannivnb['date_creation']) > 86400)
  {
    // Données de base
    $anb_id[$nannivnb]      = $dannivnb['id'];
    $anb_user[$nannivnb]    = $dannivnb['pseudonyme'];
    $anb_inscr[$nannivnb]   = jourfr($dannivnb['inscr']);
    $anb_xanniv[$nannivnb]  = $dannivnb['xeme_anniv'];
    $anb_linkcss[$nannivnb] = ($dannivnb['admin'] || $dannivnb['sysop']) ? 'texte_blanc nolink' : 'dark blank ';

    // Déterminer le style pour toutes les lignes
    if($dannivnb['admin'])
      $anb_css[$nannivnb] = ' mise_a_jour texte_blanc gras';
    else if($dannivnb['sysop'])
      $anb_css[$nannivnb] = ' sysop texte_blanc gras';
    else if((time() - $dannivnb['derniere_visite']) < 2678400)
      $anb_css[$nannivnb] = ' nobleme_background gras';
    else
      $anb_css[$nannivnb] = '';

    // Déterminer le style des lignes qui sont aujourd'hui
    if((date('m-d',time()) == date('m-d',$dannivnb['date_creation'])) && !$dannivnb['admin'])
    {
      if($anb_xanniv[$nannivnb] == 1)
        $anb_xanniv[$nannivnb] = "Joyeux ".$anb_xanniv[$nannivnb]." an !";
      else
        $anb_xanniv[$nannivnb] = "Joyeux ".$anb_xanniv[$nannivnb]." ans !";
      $anb_css[$nannivnb] = $anb_css[$nannivnb].' vert_background gras';
    }
    else
    {
      $anb_css[$nannivnb] = $anb_css[$nannivnb];
      if((date('md')-(substr($dannivnb['inscr'],-5,2).substr($dannivnb['inscr'],-2,2))) > 0)
        $anb_xanniv[$nannivnb] = dans(strtotime((date('Y')+1).'-'.(substr($dannivnb['inscr'],-5,2).'-'.(substr($dannivnb['inscr'],-2,2)))));
      else
        $anb_xanniv[$nannivnb] = dans(strtotime((date('Y')).'-'.(substr($dannivnb['inscr'],-5,2).'-'.(substr($dannivnb['inscr'],-2,2)))));
    }

    // On peut incrémenter
    $nannivnb++;
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/anniversaires.png" alt="Anniversaires">
    </div>
    <br>

    <div class="body_main bigsize">
      <span class="titre">Prochains anniversaires réels et noblemeux</span><br>
      <br>
      Cette page contient deux tableaux permettant de prévoir deux types d'anniversaires à venir :<br>
      Le premier liste les <span class="gras">anniversaires réels</span>, ceux que vous vivez chaque année dans la vie réelle. Pour apparaitre dans la liste, remplissez vos <a href="<?=$chemin?>pages/user/public">informations publiques</a>.<br>
      Le secornd liste les <span class="gras">anniversaires noblemeux</span>, célébrant la date anniversaire de l'inscription de l'utilisateur sur NoBleme.<br>
      <br>
      Les lignes ayant un <span class="vert_background">&nbsp;fond vert&nbsp;</span> signifient que l'anniversaire en question a lieu aujourd'hui.<br>
      Les lignes ayant un <span class="nobleme_background gras">&nbsp;fond gris&nbsp;</span> et/ou dont le texte est en <span class="gras">gras</span> signifient que le membre concerné a été actif sur NoBleme récemment.<br>
      Les lignes ayant un <span class="sysop texte_blanc gras">&nbsp;fond orange&nbsp;</span> signifient qu'il s'agit d'un sysop (modérateur du site).<br>
      Les lignes ayant un <span class="mise_a_jour texte_blanc gras">&nbsp;fond rouge&nbsp;</span> signifient qu'il s'agit de l'administrateur.<br>
    </div>

    <br>

    <div class="body_main bigsize">
      <table class="indiv">
        <tr>
          <td class="valign_top">

            <table class="cadre_gris intable">
              <tr>
                <td class="cadre_gris_titre gros" colspan="3">
                  PROCHAINS ANNIVERSAIRES RÉELS
                </td>
              </tr>
              <tr>
                <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
                  Pseudonyme
                </td>
                <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
                  Date de naissance
                </td>
                <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
                  Anniversaire
                </td>
              </tr>
              <?php for($i=0;$i<$nannivirl;$i++) { ?>
              <tr>
                <td class="cadre_gris cadre_gris_haut align_center<?=$annivirl_css[$i]?>">
                  <a class="<?=$annivirl_linkcss[$i]?>" href="<?=$chemin?>pages/user/user?id=<?=$annivirl_id[$i]?>"><?=$annivirl_pseudo[$i]?></a>
                </td>
                <td class="cadre_gris cadre_gris_haut align_center<?=$annivirl_css[$i]?>">
                  <?=$annivirl_date[$i]?>
                </td>
                <td class="cadre_gris cadre_gris_haut align_center<?=$annivirl_css[$i]?>">
                  <?=$annivirl_age[$i]?>
                </td>
              </tr>
              <?php } ?>
            </table>

          </td>

          <td>
            &nbsp;
          </td>

          <td class="valign_top">

            <table class="cadre_gris intable">
              <tr>
                <td class="cadre_gris_titre gros" colspan="3">
                  PROCHAINS ANNIVERSAIRES NOBLEMEUX
                </td>
              </tr>
              <tr>
                <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
                  Pseudonyme
                </td>
                <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
                  Date d'inscription
                </td>
                <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
                  Anniversaire
                </td>
              </tr>
              <?php for($i=0;$i<$nannivnb;$i++) { ?>
              <tr>
                <td class="cadre_gris cadre_gris_haut align_center<?=$anb_css[$i]?>">
                  <a class="<?=$anb_linkcss[$i]?>" href="<?=$chemin?>pages/user/user?id=<?=$anb_id[$i]?>"><?=$anb_user[$i]?></a>
                </td>
                <td class="cadre_gris cadre_gris_haut align_center<?=$anb_css[$i]?>">
                  <?=$anb_inscr[$i]?>
                </td>
                <td class="cadre_gris cadre_gris_haut align_center<?=$anb_css[$i]?>">
                  <?=$anb_xanniv[$i]?>
                </td>
              </tr>
              <?php } ?>
            </table>

          </td>
        </tr>
      </table>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';