<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Équipe administrative";
$page_desc  = "Liste des administrateurs, sysops, et modérateurs de NoBleme";

// Identification
$page_nom = "nobleme";
$page_id  = "admins";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va récupérer les admins / sysops / modérateurs
$qadmins = query("  SELECT    membres.id          ,
                              membres.pseudonyme  ,
                              membres.admin       ,
                              membres.sysop       ,
                              membres.moderateur  ,
                              membres.moderateur_description
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
  $admins_pseudo[$nadmins]  = $dadmins['pseudonyme'];
  if($dadmins['admin'])
  {
    $admins_css[$nadmins]   = 'mise_a_jour gras texte_blanc';
    $admins_css2[$nadmins]  = 'gras texte_blanc';
    $admins_role[$nadmins]  = 'Administrateur';
    $admins_zones[$nadmins] = 'Tout le site';
  }
  else if($dadmins['sysop'])
  {
    $admins_css[$nadmins]   = 'sysop gras texte_blanc';
    $admins_css2[$nadmins]  = 'gras texte_blanc';
    $admins_role[$nadmins]  = 'Sysop';
    $admins_zones[$nadmins] = 'Tout le site';
  }
  else if($dadmins['moderateur'])
  {
    $admins_css[$nadmins]   = 'vert_background texte_nobleme_fonce';
    $admins_css2[$nadmins]  = 'texte_nobleme_fonce';
    $admins_role[$nadmins]  = 'Modérateur';
    $admins_zones[$nadmins] = $dadmins['moderateur_description'];
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
      <img src="<?=$chemin?>img/logos/equipe_administrative.png" alt="Logo">
    </div>
    <br>

    <div class="body_main smallsize">
      <span class="titre">Qui donc gère NoBleme ?</span><br>
      <br>
      Tout site internet ayant une communauté se doit d'avoir une équipe administrative que tout le monde déteste. Une bande de radicaux emmerdeurs qui n'ont aucun sens de l'humour et dont le seul rôle dans la vie semble être de pourrir votre expérience au sein de ladite commaunauté.<br>
      <br>
      Bien entendu, l'équipe de NoBleme a été méticuleusement choisie pour correspondre parfaitement à cette description. L'administration est divisée selon les rôles suivants :<br>
      <br>
      <span class="gras mise_a_jour texte_blanc spaced">L'administrateur</span> possède tous les pouvoirs et en fait un usage aussi néfaste que possible.<br>
      <span class="gras sysop texte_blanc spaced">Les sysops</span> sont des modérateurs globaux, ils peuvent à peu près tout faire sur le site.<br>
      <span class="gras vert_background texte_nobleme_fonce spaced">Les modérateurs</span> ont du pouvoir uniquement sur une zone spécifique du site.<br>
      <br>
      Vous trouverez la liste des administratifs de NoBleme ainsi que leur rôle dans le tableau ci-dessous.<br>
      Si vous êtes curieux de voir le profil d'un des membres dans le tableau, cliquez sur son pseudonyme.<br>
    </div>
    <div class="body_main smallsize">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre moinsgros">
            PSEUDONYME
          </td>
          <td class="cadre_gris_titre moinsgros">
            RÔLE
          </td>
          <td class="cadre_gris_titre moinsgros">
            ZONES MODÉRÉES
          </td>
        </tr>

        <?php for($i=0;$i<$nadmins;$i++) { ?>
        <tr>
          <td class="cadre_gris_haut align_center <?=$admins_css[$i]?>">
            <a class="nolink <?=$admins_css2[$i]?>" href="<?=$chemin?>pages/user/user?id=<?=$admins_id[$i]?>"><?=$admins_pseudo[$i]?></a>
          </td>
          <td class="cadre_gris_haut align_center <?=$admins_css[$i]?>">
            <?=$admins_role[$i]?>
          </td>
          <td class="cadre_gris_haut align_center <?=$admins_css[$i]?>">
            <?=$admins_zones[$i]?>
          </td>
        </tr>
        <?php } ?>

      </table>

    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';