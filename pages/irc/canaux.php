<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'IRCCanaux';

// Identification
$page_nom = "Choisit des canaux IRC à rejoindre";
$page_url = "pages/irc/canaux";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Canaux IRC" : "IRC Channels";
$page_desc  = "Liste des canaux publics présents sur le serveur IRC NoBleme";

// JS
$js = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les canaux
$qcanaux  = query(" SELECT    irc_canaux.canal          ,
                              irc_canaux.langue         ,
                              irc_canaux.importance     ,
                              irc_canaux.description_fr ,
                              irc_canaux.description_en
                    FROM      irc_canaux
                    ORDER BY  irc_canaux.importance DESC  ,
                              irc_canaux.canal      ASC   ");

// Et on les prépare pour l'affichage
for($ncanaux = 0; $dcanaux = mysqli_fetch_array($qcanaux); $ncanaux++)
{
  $canal_imp[$ncanaux]      = $dcanaux['importance'];
  $canal_nom[$ncanaux]      = predata($dcanaux['canal']);
  $canal_langue[$ncanaux]   = $dcanaux['langue'];
  $temp_majeur              = ($lang == 'FR') ? 'Majeur' : 'Major';
  $temp_auto                = ($lang == 'FR') ? 'Automatisé' : 'Automated';
  $temp_mineur              = ($lang == 'FR') ? 'Mineur' : 'Minor';
  $temp_canal_majeur        = ($dcanaux['importance']) ? '<span class="gras">'.$temp_majeur.'</span>' : $temp_mineur;
  $canal_majeur[$ncanaux]   = ($dcanaux['importance'] && $dcanaux['importance'] <= 10) ? '<span class="italique">'.$temp_auto.'</span>' : $temp_canal_majeur;
  $canal_desc[$ncanaux]     = ($lang == 'FR') ? predata($dcanaux['description_fr']) : predata($dcanaux['description_en']);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "Liste des canaux IRC";
  $trad['soustitre']  = "Élargissez vos horizons de discussions sur NoBleme";
  $trad['desc']       = <<<EOD
<p>
  Sur le <a class="gras" href="{$chemin}pages/irc/index">serveur IRC NoBleme</a>, vous trouverez de nombreux canaux de discussion différents, certains publics et d'autres privés. Le but de cette page est de lister les canaux publics, pour que vous puissiez choisir et rejoindre ceux qui vous intéresseraient potentiellement. Les canaux sont séparés en deux catégories : les canaux majeurs, qui sont fortement fréquentés et utilisés, et les canaux mineurs, qui servent à discuter de sujets très spécifiques.
</p>
<p>
  Pour rejoindre un canal IRC, une fois connecté au <a class="gras" href="{$chemin}pages/irc/index">serveur IRC NoBleme</a>, entrez dans votre <a class="gras" href="{$chemin}pages/irc/client">client IRC</a> la commande suivante :<br>
  /join #NomDuCanal (par exemple /join #NoBleme ou /join #dev).
</p>
<p>
  De par la nature bilingue du serveur IRC NoBleme, certains canaux sont francophones, d'autres sont anglophones. La langue d'un canal peut changer avec le temps, certains canaux francophones peuvent devenir bilingues ou même purement anglophones selon la langue parlée par les utilisateurs qui les fréquentent.
</p>
<p>
  Si vous désirez créer votre propre canal IRC sur le serveur, référez vous à l'onglet CHANSERV de la page <a class="gras" href="{$chemin}pages/irc/services">commandes et services</a>, puis envoyez un message privé à <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a> si vous désirez que votre canal soit ajouté à la liste publique des canaux IRC de NoBleme.
</p>
EOD;

  // Tableau
  $trad['irc_canal']  = "CANAL";
  $trad['irc_imp']    = "IMPORTANCE";
  $trad['irc_lang']   = "LANGUE";
  $trad['irc_desc']   = "DESCRIPTION";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']      = "IRC channel list";
  $trad['soustitre']  = "Join new conversations on NoBleme";
  $trad['desc']       = <<<EOD
<p>
  On <a class="gras" href="{$chemin}pages/irc/index">NoBleme's IRC server</a>, you will find many different IRC channels, some of them public and some private. This page's goal is to list all the public channels, so that you can choose and join those that might be of interest to you. Channels are split into two categories: major channels, which see a lot of use, and minor channels, which aim to discuss a very specific topic.
</p>
<p>
  In order to join an IRC channel, once connected to <a class="gras" href="{$chemin}pages/irc/index">NoBleme's IRC server</a>, enter the following command in your <a class="gras" href="{$chemin}pages/irc/client">IRC client</a>:<br>
  /join #ChannelName (for example /join #english or /join #dev).
</p>
<p>
  Due to the bilingual nature of NoBleme's IRC server, some channels will speak mainly french, others mainly english. Do not be afraid to join a channel listed as french only, we have enough bilingual french users that we can include you in our conversations, and maybe the channel will eventually become a bilingual one due to your presence like others have in the past.
</p>
<p>
  If you wish to create your own channel on the server, follow instructions in the CHANSERV tab of the <a class="gras" href="{$chemin}pages/irc/services">commands and services</a> page, then send <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a> a private message if you want your channel to be listed on NoBleme's public channel list.
</p>
EOD;

  // Tableau
  $trad['irc_canal']  = "CHANNEL";
  $trad['irc_imp']    = "IMPORTANCE";
  $trad['irc_lang']   = "LANGUAGE";
  $trad['irc_desc']   = "DESCRIPTION";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte2">

        <h1>
          <?=$trad['titre']?>
          <?php if($est_admin) { ?>
          <a href="<?=$chemin?>pages/irc/edit_canaux">
            <img src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="30">
          </a>
          <?php } ?>
        </h1>

        <h5><?=$trad['soustitre']?></h5>

        <?=$trad['desc']?>

        <br>
        <br>

        <table class="grid titresnoirs altc nowrap">
          <thead>
            <tr>
              <th>
                <?=$trad['irc_canal']?>
              </th>
              <th>
                <?=$trad['irc_imp']?>
              </th>
              <th>
                <?=$trad['irc_lang']?>
              </th>
              <th>
                <?=$trad['irc_desc']?>
              </th>
            </tr>
          </thead>
          <tbody class="align_center">
            <?php for($i=0;$i<$ncanaux;$i++) { ?>
            <?php if($i < ($ncanaux - 1) && $canal_imp[$i] && (!$canal_imp[$i+1] || ($canal_imp[$i+1] <= 10 && $canal_imp[$i] > 10))) { ?>
            <tr class="bas_noir">
            <?php } else { ?>
            <tr>
            <?php } ?>
              <td class="spaced gras texte_noir">
                <?=$canal_nom[$i]?>
              </td>
              <td>
                <?=$canal_majeur[$i]?>
              </td>
              <td>
                <div class="flexcontainer">
                  <?php if($canal_langue[$i] == 'FR' || $canal_langue[$i] == 'FREN' || $canal_langue[$i] == 'ENFR') { ?>
                  <div style="flex:1">
                    <img src="<?=$chemin?>img/icones/lang_fr_clear.png" alt="FR" class="valign_table" height="20">
                  </div>
                  <?php } if($canal_langue[$i] == 'EN' || $canal_langue[$i] == 'FREN' || $canal_langue[$i] == 'ENFR') { ?>
                  <div style="flex:1">
                    <img src="<?=$chemin?>img/icones/lang_en_clear.png" alt="EN" class="valign_table" height="20">
                  </div>
                  <?php } ?>
                </div>
              </td>
              <td>
                <?=$canal_desc[$i]?>
              </td>
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