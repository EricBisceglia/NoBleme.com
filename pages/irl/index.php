<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'IRL';

// Identification
$page_nom = "Observe de loin les IRL";
$page_url = "pages/irl/index";

// Lien court
$shorturl = "irl";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Rencontres IRL" : "Real life meetups";
$page_desc  = "Organisation de rencontres en personne entre les NoBlemeux";

// JS
$js = array('dynamique', 'irl/liste_irls');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Assainissement du postdata
$irl_tri                  = postdata_vide('irl_tri', 'string', '');
$irl_search_date          = postdata_vide('irl_search_date', 'int', 0);
$irl_search_lieu          = postdata_vide('irl_search_lieu', 'string', '');
$irl_search_raison        = postdata_vide('irl_search_raison', 'string', '');
$irl_search_participants  = postdata_vide('irl_search_participants', 'int', 0);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Tableau des IRLs

// On prépare le nom du champ raison selon la langue
$lang_raison = 'raison_'.$lang;

// On va chercher les IRL
$qirls = "    SELECT    irl.id                                    AS 'irl_id'       ,
                        irl.date                                  AS 'irl_date'     ,
                        irl.lieu                                  AS 'irl_lieu'     ,
                        irl.$lang_raison                          AS 'irl_raison'   ,
                      ( SELECT  COUNT(irl_participants.id)
                        FROM    irl_participants
                        WHERE   irl.id = irl_participants.FKirl ) AS 'irl_participants'
              FROM      irl
              WHERE     1 = 1";

// Recherches
if($irl_search_date)
  $qirls .= " AND       YEAR(irl.date) = '$irl_search_date' ";
if($irl_search_lieu)
  $qirls .= " AND       irl.lieu LIKE '%$irl_search_lieu%' ";
if($irl_search_raison)
  $qirls .= " AND       irl.$lang_raison LIKE '%$irl_search_raison%' ";
if($irl_search_participants)
  $qirls .= " AND       ( SELECT  COUNT(irl_participants.id)
                        FROM    irl_participants
                        WHERE   irl.id = irl_participants.FKirl ) >= '$irl_search_participants' ";

// Ordres de tri
if($irl_tri == 'lieu')
  $qirls .= " ORDER BY  irl.lieu                                  ASC   ,
                        irl.date                                  DESC  ";
else if($irl_tri == 'raison')
  $qirls .= " ORDER BY  (irl.$lang_raison = '')                       ,
                        irl.$lang_raison                          ASC   ,
                        irl.date                                  DESC  ";
else if($irl_tri == 'participants')
  $qirls .= " ORDER BY  ( SELECT  COUNT(irl_participants.id)
                        FROM    irl_participants
                        WHERE   irl.id = irl_participants.FKirl ) DESC  ";
else
  $qirls .= " ORDER BY  irl.date                                  DESC  ";

// On lance la requête
$qirls = query($qirls);

// Et on prépare tout ça pour l'affichage
for($nirls = 0 ; $dirls = mysqli_fetch_array($qirls) ; $nirls++)
{
  $irl_id[$nirls]           = $dirls['irl_id'];
  $irl_css[$nirls]          = (strtotime($dirls['irl_date']) >= strtotime(date('Y-m-d'))) ? ' class="positif gras texte_blanc"' : '';
  $irl_css2[$nirls]         = (strtotime($dirls['irl_date']) >= strtotime(date('Y-m-d'))) ? 'positif gras texte_blanc' : 'gras';
  $irl_date[$nirls]         = datefr($dirls['irl_date'], $lang);
  $irl_lieu[$nirls]         = predata($dirls['irl_lieu']);
  $irl_raison[$nirls]       = predata($dirls['irl_raison']);
  $irl_participants[$nirls] = $dirls['irl_participants'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menus déroulants pour la recherche

// Années
$select_annees = '<option value="0">&nbsp;</option>';
for($i = date('Y'); $i >= 2012; $i--)
  $select_annees .= '<option value="'.$i.'">'.$i.'</option>';





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "Rencontres IRL";
  $trad['soustitre']  = "Quand internet se glisse dans la vie réelle";
  $trad['desc']       = <<<EOD
<p>
  L'acronyme IRL, signifiant en anglais <span class="gras">I</span>n <span class="gras">R</span>eal <span class="gras">L</span>ife (ou en français « dans la vraie vie »), est utilisé sur internet pour qualifier tout ce qui se fait en dehors d'internet. Dans le cas de NoBleme, le terme est utilisé pour qualifier les rencontres organisées en personne entre NoBlemeux.
</p>
<p>
  Des rencontres IRL entre NoBlemeux ont eu lieu régulièrement depuis 2005, mais ce n'est que depuis fin 2012 qu'elles sont organisées et listées sur le site internet. Par conséquent, il nous manque (hélas) toutes les informations sur les IRL datant d'avant l'automne 2012.
</p>
<p>
  Cette section du site sert bien entendu à planifier les IRL futures, mais également à archiver des données sur les IRL passées, pour aider à la préservation des souvenirs. Si vous êtes curieux de la fréquence des IRL, des participants réguliers, ou d'autres généralités à leur sujet, les <a class="gras" href="{$chemin}pages/irl/stats">statistiques des IRL</a> sont là pour ça.
</p>
<p>
  Cliquez sur une ligne du tableau pour afficher les détails d'une IRL. Les lignes en vert sont les IRL futures (lorsqu'il y en a), cliquez sur une ligne en vert pour savoir comment participer à une future IRL si vous êtes intéressé (les nouveaux participants sont toujours bienvenus parmi nous).
</p>
EOD;

  // Tableau
  $trad['irl_date']   = "DATE";
  $trad['irl_lieu']   = "LIEU";
  $trad['irl_raison'] = "RAISON";
  $trad['irl_nombre'] = "PARTICIPANTS";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']      = "Real life meetups";
  $trad['soustitre']  = "When the internet spills into the real world";
  $trad['desc']       = <<<EOD
<p>
  Real life meetups have been organized on a regular basis amongst the NoBleme community since 2005. Sadly, these meetups have only been organized and tracked through the website since late 2012, thus all the info on meetups before the autumn of 2012 is missing.
</p>
<p>
  This section of the website is of course used to plan future meetups, but also as a way to archive data on past meetups in order to keep track of memories. If you are curious about how often we do meetups, who's regulars in our meetups, and various other things, we have a page full of <a class="gras" href="{$chemin}pages/irl/stats">meetup statistics</a>.
</p>
<p>
  Click on a line of the table below to get details about a meetup. If there are any future meetups planned, they appear in green in the table. Clicking on a green line will tell you how you can be part of that meetup if you so desire (new people are always welcome to our meetups). Don't be afraid of the language barrier, a lot of us speak english, and we've had plenty of non-french people take part in our meetups in the past.
</p>
EOD;

  // Tableau
  $trad['irl_date']   = "DATE";
  $trad['irl_lieu']   = "LOCATION";
  $trad['irl_raison'] = "REASON";
  $trad['irl_nombre'] = "ATTENDEES";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <input type="hidden" id="irl_tri" value="date">

      <div class="texte">

        <h1>
          <?=$trad['titre']?>
          <?php if(getmod('irl')) { ?>
          <a href="<?=$chemin?>pages/irl/irl_modifier">
            <img class=" pointeur" src="<?=$chemin?>img/icones/ajouter.svg" alt="+" height="32">
          </a>
          <?php } ?>
          <a href="<?=$chemin?>pages/doc/rss">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/rss.svg" alt="RSS">
          </a>
        </h1>

        <h5><?=$trad['soustitre']?></h5>

        <?=$trad['desc']?>

        <br>
        <br>

        <table class="fullgrid titresnoirs altc nowrap">
          <thead>
            <tr class="pointeur">
              <th onclick="irls_tableau('<?=$chemin?>', 'date');">
                <?=$trad['irl_date']?>
              </th>
              <th onclick="irls_tableau('<?=$chemin?>', 'lieu');">
                <?=$trad['irl_lieu']?>
              </th>
              <th onclick="irls_tableau('<?=$chemin?>', 'raison');">
                <?=$trad['irl_raison']?>
              </th>
              <th class="maigre" onclick="irls_tableau('<?=$chemin?>', 'participants');">
                <?=$trad['irl_nombre']?>
              </th>
            </tr>
            <tr>
              <th>
                <select class="table_search intable" id="irl_search_date" onchange="irls_tableau('<?=$chemin?>');">
                  <?=$select_annees?>
                </select>
              </th>
              <th>
                <input class="intable" size="1" id="irl_search_lieu" onkeyup="irls_tableau('<?=$chemin?>');">
              </th>
              <th>
                <input class="intable" size="1" id="irl_search_raison" onkeyup="irls_tableau('<?=$chemin?>');">
              </th>
              <th>
                <select class="table_search intable" id="irl_search_participants" onchange="irls_tableau('<?=$chemin?>');">
                  <option value="0">&nbsp;</option>
                  <option value="5">5+</option>
                  <option value="10">10+</option>
                  <option value="15">15+</option>
                </select>
              </th>
            </tr>
          </thead>
          <tbody class="align_center" id="irl_tbody">
            <?php } ?>
            <?php for($i=0;$i<$nirls;$i++) { ?>
            <tr class="pointeur" onclick="window.open('<?=$chemin?>pages/irl/irl?id=<?=$irl_id[$i]?>', '_blank');">
              <td<?=$irl_css[$i]?>>
                <?=$irl_date[$i]?>
              </td>
              <td<?=$irl_css[$i]?>>
                <?=$irl_lieu[$i]?>
              </td>
              <td<?=$irl_css[$i]?>>
                <?=$irl_raison[$i]?>
              </td>
              <td class="<?=$irl_css2[$i]?>">
                <?=$irl_participants[$i]?>
              </td>
            </tr>
            <?php } ?>
            <?php if(!getxhr()) { ?>
          </tbody>
        </table>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }