<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Anniversaires';

// Identification
$page_nom = "Regarde les anniversaires à venir";
$page_url = "pages/nobleme/anniversaires";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Anniversaires" : "Birthdays";
$page_desc  = "Liste des anniversaires à venir des membres de NoBleme";




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
                              membres.moderateur      ,
                              membres.anniversaire    ,
                              membres.derniere_visite ,
                              YEAR(CURDATE()) - YEAR(membres.anniversaire) AS 'xeme_anniv'
                    FROM      membres
                    WHERE     membres.anniversaire != '0000-00-00'
                    ORDER BY  (MONTH(membres.anniversaire) , DAY(membres.anniversaire)) < ( MONTH(CURDATE()), DAY(CURDATE()) )  ,
                              MONTH(membres.anniversaire)                                                                       ,
                              DAY(membres.anniversaire)                                                                         ,
                              membres.pseudonyme
                    LIMIT     50 ");

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
    $annivirl_pseudo[$nannivirl]  = predata($dannivirl['pseudonyme']);
    $annivirl_date[$nannivirl]    = jourfr($dannivirl['anniversaire'], $lang);
    $annivirl_css[$nannivirl]     = ((time() - $dannivirl['derniere_visite']) < 864000) ? ' gras' : ' ';
    $annivirl_linkcss[$nannivirl] = ($dannivirl['admin'] || $dannivirl['sysop']) ? 'texte_blanc nohover' : 'dark blank ';
    $annivirl_linkcss[$nannivirl] = ($dannivirl['moderateur']) ? 'texte_nobleme_fonce' : $annivirl_linkcss[$nannivirl];

    // Déterminer le style des lignes qui sont aujourd'hui
    if(date('md') == (substr($dannivirl['anniversaire'],-5,2).substr($dannivirl['anniversaire'],-2,2)))
    {
      if ($dannivirl['admin'])
        $annivirl_css[$nannivirl] .= ' mise_a_jour texte_blanc gras';
      else if ($dannivirl['sysop'])
        $annivirl_css[$nannivirl] .= ' neutre texte_blanc gras';
      else if ($dannivirl['moderateur'])
        $annivirl_css[$nannivirl] .= ' vert_background gras';
      else
        $annivirl_css[$nannivirl] .= ' gras';
      $annivirl_age[$nannivirl]   = ($lang == 'FR') ? 'Joyeux '.$dannivirl['xeme_anniv'].' ans !' : 'Happy '.$dannivirl['xeme_anniv'].' years !';
    }
    else
    {
      // On calcule quand est l'anniversaire
      if((date('md')-(substr($dannivirl['anniversaire'],-5,2).substr($dannivirl['anniversaire'],-2,2))) > 0)
        $annivirl_age[$nannivirl]    = dans(strtotime((date('Y')+1).'-'.(substr($dannivirl['anniversaire'],-5,2).'-'.(substr($dannivirl['anniversaire'],-2,2)))), $lang);
      else
        $annivirl_age[$nannivirl]    = dans(strtotime((date('Y')).'-'.(substr($dannivirl['anniversaire'],-5,2).'-'.(substr($dannivirl['anniversaire'],-2,2)))), $lang);
      // On finit le style des lignes
      if ($dannivirl['admin'])
        $annivirl_css[$nannivirl] .= ' mise_a_jour texte_blanc gras';
      else if ($dannivirl['sysop'])
        $annivirl_css[$nannivirl] .= ' neutre texte_blanc gras';
      else if ($dannivirl['moderateur'])
        $annivirl_css[$nannivirl] .= ' vert_background gras';
      else if ((time() - $dannivirl['derniere_visite']) < 864000)
        $annivirl_css[$nannivirl] .= '';
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
                              membres.moderateur                                                                ,
                              membres.date_creation                                                             ,
                              membres.derniere_visite                                                           ,
                              DATE(FROM_UNIXTIME(membres.date_creation))                          AS inscr      ,
                              YEAR(CURDATE()) - YEAR(DATE(FROM_UNIXTIME(membres.date_creation)))  AS xeme_anniv
                    FROM      membres
                    ORDER BY  (MONTH(DATE(FROM_UNIXTIME(membres.date_creation))) , DAY(DATE(FROM_UNIXTIME(membres.date_creation)))) < ( MONTH(CURDATE()), DAY(CURDATE()) ) ,
                              MONTH(DATE(FROM_UNIXTIME(membres.date_creation))) ,
                              DAY(DATE(FROM_UNIXTIME(membres.date_creation))) ,
                              membres.pseudonyme
                    LIMIT     50 ");

// Préparation des données
$nannivnb = 0;
while($dannivnb = mysqli_fetch_array($qannivnb))
{
  // On ne veut pas des nouveaux inscrits
  if((time() - $dannivnb['date_creation']) > 86400)
  {
    // Données de base
    $anb_id[$nannivnb]      = $dannivnb['id'];
    $anb_user[$nannivnb]    = predata($dannivnb['pseudonyme']);
    $anb_inscr[$nannivnb]   = jourfr($dannivnb['inscr'], $lang);
    $anb_xanniv[$nannivnb]  = $dannivnb['xeme_anniv'];
    $anb_linkcss[$nannivnb] = ($dannivnb['admin'] || $dannivnb['sysop']) ? 'texte_blanc nohover' : 'dark blank ';
    $anb_linkcss[$nannivnb] = ($dannivnb['moderateur']) ? 'texte_nobleme_fonce' : $anb_linkcss[$nannivnb];

    // Déterminer le style pour toutes les lignes
    if($dannivnb['admin'])
      $anb_css[$nannivnb] = ' mise_a_jour texte_blanc gras';
    else if($dannivnb['sysop'])
      $anb_css[$nannivnb] = ' neutre texte_blanc gras';
    else if($dannivnb['moderateur'])
      $anb_css[$nannivnb] = ' vert_background gras';
    else if((time() - $dannivnb['derniere_visite']) < 864000)
      $anb_css[$nannivnb] = ' grisclair gras';
    else
      $anb_css[$nannivnb] = '';

    // Déterminer le style des lignes qui sont aujourd'hui
    if((date('m-d',time()) == date('m-d',$dannivnb['date_creation'])))
    {
      if($anb_xanniv[$nannivnb] == 1)
        $anb_xanniv[$nannivnb] = ($lang == 'FR') ? "Joyeux ".$anb_xanniv[$nannivnb]." an !" : "Happy ".$anb_xanniv[$nannivnb]." year !";
      else
        $anb_xanniv[$nannivnb] = ($lang == 'FR') ? "Joyeux ".$anb_xanniv[$nannivnb]." ans !" : "Happy ".$anb_xanniv[$nannivnb]." years !";;
      if(!$dannivnb['admin'])
        $anb_css[$nannivnb] = $anb_css[$nannivnb].' gras';
    }
    else
    {
      $anb_css[$nannivnb] = $anb_css[$nannivnb];
      if((date('md')-(substr($dannivnb['inscr'],-5,2).substr($dannivnb['inscr'],-2,2))) > 0)
        $anb_xanniv[$nannivnb] = dans(strtotime((date('Y')+1).'-'.(substr($dannivnb['inscr'],-5,2).'-'.(substr($dannivnb['inscr'],-2,2)))), $lang);
      else
        $anb_xanniv[$nannivnb] = dans(strtotime((date('Y')).'-'.(substr($dannivnb['inscr'],-5,2).'-'.(substr($dannivnb['inscr'],-2,2)))), $lang);
    }

    // On peut incrémenter
    $nannivnb++;
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUTION DU CONTENU MULTILINGUE                                                    */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

$traduction['titre']        = ($lang == 'FR') ? "Anniversaires" : "Birthdays";
$traduction['soustitre']    = ($lang == 'FR') ? "Prochains anniversaires réels et NoBlemeux" : "Upcoming real life and virtual birthdays";
$traduction['ann_reels']    = ($lang == 'FR') ? "ANNIVERSAIRES RÉELS" : "REAL LIFE BIRTHDAYS";
$traduction['ann_nobleme']  = ($lang == 'FR') ? "ANNIVERSAIRES NOBLEMEUX" : "NOBLEME ANNIVERSARIES";
$traduction['ann_pseudo']   = ($lang == 'FR') ? "PSEUDONYME" : "NICKNAME";
$traduction['ann_naiss']    = ($lang == 'FR') ? "DATE DE NAISSANCE" : "BIRTHDAY";
$traduction['ann_inscr']    = ($lang == 'FR') ? "DATE D'INSCRIPTION" : "REGISTRATION";
$traduction['ann_iv']       = ($lang == 'FR') ? "ANNIVERSAIRE" : "BIRTHDAY";

if($lang == 'FR')
  $traduction['description'] = "<p>
  Cette page contient deux tableaux permettant de voir deux types d'anniversaires à venir:<br>Le premier liste les <span class=\"gras\">anniversaires réels</span> (vous pouvez remplir le votre dans les <a href=\"".$chemin."pages/user/public\">réglages de votre compte</a>).<br>Le second liste les <span class=\"gras\">anniversaires NoBlemeux</span>, basés sur la date de création des comptes.
</p>
<p>
  Les utilisateurs qui se sont <a href=\"".$chemin."pages/nobleme/online?noguest\">connectés récemment</a> à leur compte apparaissent en <span class=\"gras\">gras</span><br>
  Les membres de <a class=\"gras\" href=\"".$chemin."pages/nobleme/admins\">l'équipe administrative</a> apparaissent dans leurs couleurs respectives.<br>
</p>";
else
  $traduction['description'] = "<p>
  Below are two tables which contain two different types of upcoming birthdays:<br>The first one lists <span class=\"gras\">real life birthdays</span> (you can set yours in your <a href=\"".$chemin."pages/user/public\">account settings</a>).<br>The second one lists <span class=\"gras\">NoBleme anniversaries</span>, based on the registration date of accounts.
</p>
<p>
  Users that have <a href=\"".$chemin."pages/nobleme/online\">recently logged into their account</a> will appear in <span class=\"gras\">bold</span><br>
  Members of the <a class=\"gras\" href=\"".$chemin."pages/nobleme/admins\">administrative team</a> will appear each in their respective formatting<br>
</p>";





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$traduction['titre']?></h1>

        <h5><?=$traduction['soustitre']?></h5>

        <?=$traduction['description']?>

      </div>

      <br>
      <br>

      <div class="texte3">

        <div class="flexcontainer">
          <div style="flex:1;margin-right:25px;">

            <table class="fullgrid titresnoirs nowrap">
              <thead>
                <tr>
                  <th colspan="3" class="moinsgros">
                    <?=$traduction['ann_reels']?>
                  </th>
                </tr>
                <tr>
                  <th>
                    <?=$traduction['ann_pseudo']?>
                  </th>
                  <th>
                    <?=$traduction['ann_naiss']?>
                  </th>
                  <th>
                    <?=$traduction['ann_iv']?>
                  </th>
                </tr>
              </thead>
              <tbody class="align_center">
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
              </tbody>
            </table>

          </div>
          <div style="flex:1;margin-left:25px;">

            <table class="fullgrid titresnoirs nowrap">
              <thead>
                <tr>
                  <th colspan="3" class="moinsgros">
                    <?=$traduction['ann_nobleme']?>
                  </th>
                </tr>
                <tr>
                  <th>
                    <?=$traduction['ann_pseudo']?>
                  </th>
                  <th>
                    <?=$traduction['ann_inscr']?>
                  </th>
                  <th>
                    <?=$traduction['ann_iv']?>
                  </th>
                </tr>
              </thead>
              <tbody class="align_center">
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
              </tbody>
            </table>

          </div>
        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';