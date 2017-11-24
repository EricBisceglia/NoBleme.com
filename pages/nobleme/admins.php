<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'EquipeAdmin';

// Identification
$page_nom = "Respecte l'équipe administrative";
$page_url = "pages/nobleme/admins";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Équipe administrative" : "Administrative team";
$page_desc  = "Liste des membres de l'équipe qui modère et anime NoBleme";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va récupérer les admins / sysops / modérateurs
$qadmins = query("  SELECT    membres.id                        ,
                              membres.pseudonyme                ,
                              membres.admin                     ,
                              membres.sysop                     ,
                              membres.moderateur                ,
                              membres.moderateur_description_fr ,
                              membres.moderateur_description_en
                    FROM      membres
                    WHERE   ( membres.admin       = 1
                    OR        membres.sysop       = 1
                    OR        membres.moderateur != '' )
                    ORDER BY  membres.admin       DESC  ,
                              membres.sysop       DESC  ,
                              membres.moderateur  DESC  ,
                              membres.pseudonyme  ASC   ");

// Et on prépare pour l'affichage
for($nadmins = 0 ; $dadmins = mysqli_fetch_array($qadmins) ; $nadmins++)
{
  $admins_id[$nadmins]      = $dadmins['id'];
  $admins_pseudo[$nadmins]  = predata($dadmins['pseudonyme']);
  if($dadmins['admin'])
  {
    $admins_css[$nadmins]   = 'negatif gras texte_blanc';
    $admins_css2[$nadmins]  = 'gras texte_blanc nohover';
    $admins_role[$nadmins]  = ($lang == 'FR') ? 'Administrateur' : 'Administrator';
    $admins_zones[$nadmins] = ($lang == 'FR') ? 'Tout le site' : 'Whole website';
  }
  else if($dadmins['sysop'])
  {
    $admins_css[$nadmins]   = 'neutre gras texte_blanc';
    $admins_css2[$nadmins]  = 'gras texte_blanc nohover';
    $admins_role[$nadmins]  = 'Sysop';
    $admins_zones[$nadmins] = ($lang == 'FR') ? 'Tout le site' : 'Whole website';
  }
  else if($dadmins['moderateur'])
  {
    $admins_css[$nadmins]   = 'vert_background gras texte_nobleme_fonce';
    $admins_css2[$nadmins]  = 'gras texte_nobleme_fonce nohover';
    $admins_role[$nadmins]  = ($lang == 'FR') ? 'Modérateur' : 'Moderator';
    $admins_zones[$nadmins] = ($lang == 'FR') ? predata($dadmins['moderateur_description_fr']) : predata($dadmins['moderateur_description_en']);
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['admins_titre']         = "Équipe administrative";
  $trad['admins_soustitre']     = "Mais qui donc gère NoBleme ?";
  $trad['admins_texte']         = <<<EOD
<p>
  Tout site internet ayant une communauté se doit d'avoir une équipe administrative que tout le monde déteste. Une bande de radicaux emmerdeurs qui n'ont aucun sens de l'humour et dont le seul rôle dans la vie semble être de pourrir votre expérience au sein de ladite commaunauté. Bien entendu, l'équipe de NoBleme a été méticuleusement choisie pour correspondre parfaitement à cette description.
</p>

<p>
  <span class="gras negatif texte_blanc spaced">L'administrateur</span> possède tous les pouvoirs et en fait un usage aussi néfaste que possible.<br>
  <span class="gras neutre texte_blanc spaced">Les sysops</span> sont des modérateurs globaux, ils peuvent à peu près tout faire sur le site.<br>
  <span class="gras vert_background texte_nobleme_fonce spaced">Les modérateurs</span> ont du pouvoir uniquement sur une zone spécifique du site.<br>
</p>

<p>
  Vous trouverez la liste des administratifs de NoBleme ainsi que leur rôle dans le tableau ci-dessous. Si vous êtes curieux de voir le profil d'un des membres dans le tableau, cliquez sur son pseudonyme. N'hésitez pas à les contacter par message privé si vous avez un problème qu'ils pourraient vous aider à régler.
</p>
EOD;

  // Tableau
  $trad['admins_table_pseudo']  = "PSEUDONYME";
  $trad['admins_table_role']    = "RÔLE";
  $trad['admins_table_modzone'] = "ZONES MODÉRÉES";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['admins_titre']         = "Administrative team";
  $trad['admins_soustitre']     = "By whom is this website managed?";
  $trad['admins_texte']         = <<<EOD
<p>
  If a website has a community, it must also have a team of power hungry moderators and administrators that everyone loathes. A group of radical hatemongerers who abuse their powers in the most creative ways and ruin your experience within that community. As we want to adhere to high quality standards, NoBleme's administrative team has been especially selected to fit those criteria.
</p>

<p>
  <span class="gras negatif texte_blanc spaced">The administrator</span> is omnipotent and has the terrifying power to do anything he wishes.<br>
  <span class="gras neutre texte_blanc spaced">The sysops</span> are global moderators, they have power over the whole website.<br>
  <span class="gras vert_background texte_nobleme_fonce spaced">Moderators</span> have limited power over specific areas of the website.<br>
</p>

<p>
  In the table below, you will find a list of all the members of the administrative team. If you have any issue that we can help you with, feel free to click on the nickname of any of us and send us a private message.
</p>
EOD;

  // Tableau
  $trad['admins_table_pseudo']  = "NICKNAME";
  $trad['admins_table_role']    = "ROLE";
  $trad['admins_table_modzone'] = "MODERATED ZONES";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['admins_titre']?></h1>

        <h5><?=$trad['admins_soustitre']?></h5>

        <?=$trad['admins_texte']?>

        <br>
        <br>

        <table class="titresnoirs">
          <thead>
            <tr>
              <th>
                <?=$trad['admins_table_pseudo']?>
              </th>
              <th>
                <?=$trad['admins_table_role']?>
              </th>
              <th>
                <?=$trad['admins_table_modzone']?>
              </th>
            </tr>
          </thead>
          <tbody class="align_center">
            <?php for($i=0;$i<$nadmins;$i++) { ?>
            <tr class="pointeur <?=$admins_css[$i]?>" onclick="window.location.href = '<?=$chemin?>pages/user/user?id=<?=$admins_id[$i]?>'";>
              <td>
                <a class="<?=$admins_css2[$i]?>" href="<?=$chemin?>pages/user/user?id=<?=$admins_id[$i]?>">
                  <?=$admins_pseudo[$i]?>
                </a>
              </td>
              <td>
                <a class="<?=$admins_css2[$i]?>" href="<?=$chemin?>pages/user/user?id=<?=$admins_id[$i]?>">
                  <?=$admins_role[$i]?>
                </a>
              </td>
              <td>
                <a class="<?=$admins_css2[$i]?>" href="<?=$chemin?>pages/user/user?id=<?=$admins_id[$i]?>">
                  <?=$admins_zones[$i]?>
                </a>
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