<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'QuiEstEnLigne';

// Identification
$page_nom = "Traque qui est en ligne";
$page_url = "pages/nobleme/online?noguest";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Qui est en ligne ?" : "Who's online?";
$page_desc  = "Liste des membres de NoBleme connectés au site dans les dernières 48 heures";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher le mix d'invités et de membres qui se baladent sur nobleme
$maxdate = time() - 172800;
$qonline =  "  ( SELECT
                  'guest'                       AS 'type'   ,
                  '0'                           AS 'id'     ,
                  '0'                           AS 'mod'    ,
                  '0'                           AS 'admin'  ,
                  '0'                           AS 'sysop'  ,
                  invites.surnom                AS 'pseudo' ,
                  invites.derniere_visite       AS 'date'   ,
                  invites.derniere_visite_page  AS 'page'   ,
                  invites.derniere_visite_url   AS 'url'
                FROM      invites
                WHERE     invites.derniere_visite >= '$maxdate'
                ORDER BY  invites.derniere_visite DESC ";
if(isset($_GET['noguest']) || $lang != 'FR')
  $qonline .= " LIMIT       0 ) ";
else
  $qonline .= " LIMIT     1000 ) ";
$qonline .= " UNION
                ( SELECT
                  'user'                        AS 'type'   ,
                  membres.id                    AS 'id'     ,
                  membres.moderateur            AS 'mod'    ,
                  membres.admin                 AS 'admin'  ,
                  membres.sysop                 AS 'sysop'  ,
                  membres.pseudonyme            AS 'pseudo' ,
                  membres.derniere_visite       AS 'date'   ,
                  membres.derniere_visite_page  AS 'page'   ,
                  membres.derniere_visite_url   AS 'url'
                FROM      membres
                WHERE     membres.derniere_visite >= '$maxdate'
                ORDER BY  membres.derniere_visite DESC
                LIMIT     1000 )
              ORDER BY date DESC ";
$qonline = query($qonline);

// Et on prépare tout ça pour l'affichage
for($nonline = 0 ; $donline = mysqli_fetch_array($qonline) ; $nonline++)
{
  // L'invité a son surnom mignon, l'user son pseudo
  if ($donline['type'] === 'guest')
    $online_pseudo[$nonline] = $donline['pseudo'];
  else if (!$donline['admin'] && !$donline['sysop'] && !$donline['mod'])
    $online_pseudo[$nonline] = '<a href="'.$chemin.'pages/user/user?id='.$donline['id'].'">'.$donline['pseudo'].'</a>';
  else
    $online_pseudo[$nonline] = '<a href="'.$chemin.'pages/user/user?id='.$donline['id'].'"><span class="texte_blanc">'.$donline['pseudo'].'</span></a>';

  // Les couleurs de fond
  if ($donline['type'] === 'guest')
    $online_css[$nonline] = 'grisclair';
  else if (!$donline['admin'] && !$donline['sysop'] && !$donline['mod'])
    $online_css[$nonline] = 'grisclair gras';
  else if ($donline['sysop'])
    $online_css[$nonline] = 'neutre texte_blanc gras';
  else if ($donline['mod'])
    $online_css[$nonline] = 'positif texte_blanc gras';
  else
    $online_css[$nonline] = 'negatif texte_blanc gras';

  // La page avec ou sans url autour
  if(!$donline['url'])
    $online_page[$nonline] = $donline['page'];
  else if (!$donline['admin'] && !$donline['sysop'] && !$donline['mod'])
    $online_page[$nonline] = '<a href="'.$chemin.$donline['url'].'">'.$donline['page'].'</a>';
  else
    $online_page[$nonline] = '<a href="'.$chemin.$donline['url'].'"><span class="texte_blanc">'.$donline['page'].'</span></a>';

  // Et le reste
  $online_date[$nonline] = ($lang == 'FR') ? ilya($donline['date']) : ilya($donline['date'],'EN');
  $online_url[$nonline]  = $donline['url'];
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUTION DU CONTENU MULTILINGUE                                                    */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

$traduction['titre']      = ($lang == 'FR') ? "Qui est en ligne ?" : "Who's online right now ?";
$traduction['soustitre']  = ($lang == 'FR') ? "La page officielle des traqueurs obsessifs et des curieux" : "The official home of obsessive stalkers, curious cats, and other weird animals";
$traduction['pseudo']     = ($lang == 'FR') ? "PSEUDONYME" : "USER";
$traduction['activite']   = ($lang == 'FR') ? "ACTIVITE" : "LAST ACTION";

if($lang == 'FR')
  $traduction['description'] = "Cette page recense les visiteurs connectés ces dernières 48 heures, et la page de NoBleme qu'ils ont visité en dernier. Si plus de 1000 personnes se sont connectées ces dernières 48 heures, seules les 1000 activités les plus récentes apparaitront (sait-on jamais, c'est peut-être le cas dans une ligne temporelle différente).";
else
  $traduction['description'] = "This page lists all accounts that were active on NoBleme in the last 48 hours, sorted by latest activity. If more than 1000 people used the website in the last 48 hours, only the 1000 most recent users will appear (you never know, it could be the case in some alternate timeline, better be safe than sorry).";

if($lang == 'FR')
  $traduction['couleurs'] = "Afin de les distinguer, les <a href=\"".$chemin."pages/nobleme/membres\">membres enregistrés</a> apparaissent sur fond <span class=\"texte_noir grisclair gras spaced\">gris</span> , les <a href=\"".$chemin."pages/nobleme/admins\">modérateurs</a> sur fond <span class=\"positif texte_blanc gras spaced\">vert</span> , les <a href=\"".$chemin."pages/nobleme/admins\">sysops</a> sur fond <span class=\"neutre texte_blanc gras spaced\">orange</span> , et l'<a href=\"".$chemin."pages/user/user?id=1\">administrateur</a> sur fond <span class=\"negatif texte_blanc gras spaced\">rouge</span>.";
else
  $traduction['couleurs'] = "In order to tell them apart from eachother, <a href=\"".$chemin."pages/nobleme/membres\">registered users</a> will appear in <span class=\"texte_noir grisclair gras spaced\">grey</span> , <a href=\"".$chemin."pages/nobleme/admins\">moderators</a> in <span class=\"positif texte_blanc gras spaced\">green</span> , <a href=\"".$chemin."pages/nobleme/admins\">sysops</a> in <span class=\"neutre texte_blanc gras spaced\">orange</span> , and the <a href=\"".$chemin."pages/user/user?id=1\">administrator</a> in <span class=\"negatif texte_blanc gras spaced\">red</span>.";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1 class="alinea"><?=$traduction['titre']?></h1>

        <h6 class="alinea texte_nobleme_clair"><?=$traduction['soustitre']?></h6>

        <p><?=$traduction['description']?></p>

        <p><?=$traduction['couleurs']?></p>

        <?php if($lang == 'FR') { ?>

        <p>Par défaut, les invités (personnes non connectées à un compte) sont masqués car ils sont beaucoup plus nombreux que les utilisateurs et rendent la page difficile à lire. Afin de pouvoir les identifier et suivre leur activité, des surnoms rigolos et généralement mignons sont affectés à chaque invité.</p>

        <?php if(isset($_GET['noguest'])) { ?>
        <p><a class="gras" href="<?=$chemin?>pages/nobleme/online">Si vous désirez que les invités soient également affichés, cliquez ici.</a></p>
        <?php } else { ?>
        <p><a class="gras" href="<?=$chemin?>pages/nobleme/online?noguest">Si vous désirez masquer les invités, cliquez ici.</a></p>
        <?php } ?>

        <?php } ?>

        <br>
        <br>

        <table class="titresnoirs">
          <thead>
            <tr>
              <th>
                <?=$traduction['pseudo']?>
              </th>
              <th>
                <?=$traduction['activite']?>
              </th>
              <?php if($lang == 'FR') { ?>
              <th>
                ACTION
              </th>
              <?php } ?>
            </tr>
          </thead>
          <tbody class="align_center">

            <?php for($i=0;$i<$nonline;$i++) { ?>
            <tr>
              <td class="<?=$online_css[$i]?>">
                <?=$online_pseudo[$i]?>
              </td>
              <td class="<?=$online_css[$i]?>">
                <?=$online_date[$i]?>
              </td>
              <?php if($lang == 'FR') { ?>
              <td class="<?=$online_css[$i]?>">
                <?=$online_page[$i]?>
              </td>
              <?php } ?>
            </tr>
            <?php } ?>

          </tbody>
        </table>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';