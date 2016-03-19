<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly();

// Titre et description
$page_titre = "Modifier mon profil";
$page_desc  = "Modification de votre profil public";

// Identification
$page_nom = "user";
$page_id  = "profil";

// CSS et JS
$css = array('user');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modifier le profil

// La partie de gauche du profil
if(isset($_POST['profil_gauche_modifier_x']))
{
  // Assainissement du postdata
  $edit_sexe        = postdata($_POST['profil_sexe']);
  $edit_anniv_annee = postdata($_POST['profil_naissance_annee']);
  $edit_anniv_mois  = (strlen($_POST['profil_naissance_mois'])== 1)? '0'.$_POST['profil_naissance_mois'] : $_POST['profil_naissance_mois'];
  $edit_anniv_jour  = (strlen($_POST['profil_naissance_jour'])== 1)? '0'.$_POST['profil_naissance_jour'] : $_POST['profil_naissance_jour'];
  $edit_anniv       = postdata($edit_anniv_annee.'-'.$edit_anniv_mois.'-'.$edit_anniv_jour);
  $edit_region      = postdata((strlen($_POST['profil_region']) > 36) ? substr($_POST['profil_region'],0,36) : $_POST['profil_region']);
  $edit_metier      = postdata((strlen($_POST['profil_metier']) > 36) ? substr($_POST['profil_metier'],0,36) : $_POST['profil_metier']);

  // On limite les choix de sexe pour pas que ça soit abusable via le postdata
  if($edit_sexe != '' && $edit_sexe != 'Masculin' && $edit_sexe != 'Féminin' && $edit_sexe != 'Neutre' && $edit_sexe != 'Indéfini')
    $edit_sexe = '';

  // Modification du profil
  $edit_user = $_SESSION['user'];
  query(" UPDATE  membres
          SET     membres.sexe          = '$edit_sexe'    ,
                  membres.anniversaire  = '$edit_anniv'   ,
                  membres.region        = '$edit_region'  ,
                  membres.metier        = '$edit_metier'
          WHERE   membres.id            = '$edit_user'    ");
}


// La partie de droite du profil
if(isset($_POST['profil_droite_modifier_x']))
{
  // Assainissement du postdata
  $edit_texte = postdata($_POST['profil_texte']);

  // Modification du profil
  $edit_user = $_SESSION['user'];
  query(" UPDATE membres SET membres.profil = '$edit_texte' WHERE membres.id = '$edit_user' ");
}


// Peu importe quelle partie a été modifiée, activité récente + redirection
if(isset($_POST['profil_gauche_modifier_x']) || isset($_POST['profil_droite_modifier_x']))
{
  // Détection du flood pour l'activité récente (une heure avant de refaire un log)
  $maxtimestamp = time()-3600;
  $qfloodactivite = query(" SELECT id FROM activite WHERE activite.timestamp > '$maxtimestamp' AND activite.FKmembres = '$edit_user' AND activite.action_type LIKE 'profil' ");
  if(!mysqli_num_rows($qfloodactivite))
  {
    // S'il y a pas de flood, on crée le log dans l'activité récente
    $timestamp  = time();
    $edit_nick  = getpseudo($edit_user);
    query(" INSERT INTO activite
            SET         timestamp   = '$timestamp'  ,
                        FKmembres   = '$edit_user'  ,
                        pseudonyme  = '$edit_nick'  ,
                        action_type = 'profil'      ");
  }

  // Redirection vers le profil
  header('Location: '.$chemin.'pages/user/user?id='.$edit_user.'#profil_haut');
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prévisualisation

// Par défaut on met rien dans la prévisualisation
$profil_previsualisation = '';

// Si elle est remplie, on l'affiche
if(isset($_POST['profil_droite_previsualiser_x']))
  $profil_previsualisation = nl2br_fixed(bbcode(destroy_html($_POST['profil_texte'])));




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On récupère les infos pour pré-remplir la page

$edit_user      = $_SESSION['user'];
$dprofiledit    = mysqli_fetch_array(query(" SELECT sexe, anniversaire, region, metier, profil FROM membres WHERE id = '$edit_user' "));
$profil_metier  = destroy_html($dprofiledit['metier']);
$profil_region  = destroy_html($dprofiledit['region']);
$profil_texte   = destroy_html((!isset($_POST['profil_droite_previsualiser_x'])) ? $dprofiledit['profil'] : $_POST['profil_texte']);



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menu déroulant: Sexe

if(!$dprofiledit['sexe'])
  $menu_sexe  = '<option value="0" selected>&nbsp;</option>';
else
  $menu_sexe  = '<option value="">&nbsp;</option>';
if($dprofiledit['sexe'] == 'Masculin')
  $menu_sexe .= '<option value="Masculin" selected>Masculin</option>';
else
  $menu_sexe .= '<option value="Masculin">Masculin</option>';
if($dprofiledit['sexe'] == 'Féminin')
  $menu_sexe .= '<option value="Féminin" selected>Féminin</option>';
else
  $menu_sexe .= '<option value="Féminin">Féminin</option>';
if($dprofiledit['sexe'] == 'Neutre')
  $menu_sexe .= '<option value="Neutre" selected>Neutre</option>';
else
  $menu_sexe .= '<option value="Neutre">Neutre</option>';
if($dprofiledit['sexe'] == 'Indéfini')
  $menu_sexe .= '<option value="Indéfini" selected>Indéfini</option>';
else
  $menu_sexe .= '<option value="Indéfini">Indéfini</option>';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menu déroulant: Jour de naissance

$jouranniv = substr($dprofiledit['anniversaire'],8,2);
if($jouranniv == '00')
  $menu_naissance_jour = '<option value="00" selected>&nbsp;</option>';
else
  $menu_naissance_jour = '<option value="00">&nbsp;</option>';
for($i=1;$i<31;$i++)
{
  if($jouranniv == $i)
    $menu_naissance_jour .= '<option value="'.$i.'" selected>'.$i.'</option>';
  else
    $menu_naissance_jour .= '<option value="'.$i.'">'.$i.'</option>';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menu déroulant: Mois de naissance

$moisanniv = substr($dprofiledit['anniversaire'],5,2);
if($moisanniv == '00')
  $menu_naissance_mois = '<option value="00" selected>&nbsp;</option>';
else
  $menu_naissance_mois = '<option value="00">&nbsp;</option>';
for($i=1;$i<=12;$i++)
{
  if($moisanniv == $i)
    $menu_naissance_mois .= '<option value="'.$i.'" selected>'.$moisfr[$i].'</option>';
  else
    $menu_naissance_mois .= '<option value="'.$i.'">'.$moisfr[$i].'</option>';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menu déroulant: Année de naissance

$anneeanniv = substr($dprofiledit['anniversaire'],0,4);
if($anneeanniv == '0000')
  $menu_naissance_annee = '<option value="0000" selected>&nbsp;</option>';
else
  $menu_naissance_annee = '<option value="0000">&nbsp;</option>';
for($i=date('Y');$i>1900;$i--)
{
  if($anneeanniv == $i)
    $menu_naissance_annee .= '<option value="'.$i.'" selected>'.$i.'</option>';
  else
    $menu_naissance_annee .= '<option value="'.$i.'">'.$i.'</option>';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/profil.png" alt="Logo">
    </div>
    <br>

    <form name="editprofil" method="post" action="profil#profil_previs">

      <div class="body_main smallsize">

        <span class="titre">Modifier mon profil public</span><br>
        <br>
        Tout ce que vous ajoutez ou modifiez sur cette page apparaitra sur votre <a href="<?=$chemin?>pages/user/user?id=<?=$_SESSION['user']?>">profil public</a>.<br>
        <br>
        Bien entendu, l'intégralité des informations sont optionnelles.<br>
        Vous pouvez choisir de n'en remplir qu'une partie ou même de ne rien remplir du tout.<br>
        Il n'y aura aucune conséquence négative si vous faites le choix d'avoir un profil non personnalisé.<br>
      </div>

      <br>

      <div class="body_main smallsize">
        <span class="soustitre">Colonne de gauche : Informations personnelles</span><br>
        <br>
        <table class="indiv">
          <tr>
            <td class="align_right spaced gras profil_colonnegauche">
              Sexe :
            </td>
            <td class="align_left" colspan="3">
              <select class="intable" name="profil_sexe">
                <?=$menu_sexe?>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="4" class="profil_minixeplication">
              Note de l'administrateur: Le choix d'utiliser sexe au lieu de genre n'a pas été fait dans un objectif discriminatoire. Tout simplement c'est parce que, en <?=date('Y')?>, la personne moyenne comprend très bien ce que signifie sexe mais pas forcément ce que signifie genre. J'ai choisi la clarté plutôt que la précision. Si le mot sexe ne vous convient pas, contentez vous de ne pas remplir ce champ de votre profil public. Je comprends parfaitement le problème que ce choix de vocabulaire peut poser, mais c'est une situation où les deux choix ont le potentiel de lancer des débats stériles car la plupart des gens ne comprennent pas bien les implications des mots sexe et genre.<br>
              <br>
            </td>
          </tr>
          <tr>
            <td class="align_right spaced gras profil_colonnegauche">
              Date de naissance :
            </td>
            <td class="align_left">
              <select class="intable align_center" name="profil_naissance_jour">
                <?=$menu_naissance_jour?>
              </select>
            </td>
            <td class="align_left">
              <select class="intable align_center" name="profil_naissance_mois">
                <?=$menu_naissance_mois?>
              </select>
            </td>
            <td class="align_left">
              <select class="intable align_center" name="profil_naissance_annee">
                <?=$menu_naissance_annee?>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="4">
              <br>
            </td>
          </tr>
          <tr>
            <td class="align_right spaced gras profil_colonnegauche">
              Ville / Région / Pays :
            </td>
            <td class="align_left" colspan="3">
              <input class="intable" maxlength="35" name="profil_region" value="<?=$profil_region?>">
            </td>
          </tr>
          <tr>
            <td colspan="4">
              <br>
            </td>
          </tr>
          <tr>
            <td class="align_right spaced gras profil_colonnegauche">
              Métier / Occupation :
            </td>
            <td class="align_left" colspan="3">
              <input class="intable" maxlength="35" name="profil_metier" value="<?=$profil_metier?>">
            </td>
          </tr>
        </table>
        <br>
        <div class="indiv align_center">
          <input type="image" src="<?=$chemin?>img/boutons/modifier.png" name="profil_gauche_modifier" alt="Modifier">
        </div>
      </div>

      <br>

      <?php if(isset($_POST['profil_droite_previsualiser_x'])) { ?>
      <div class="body_main smallsize" id="profil_previs">
        <div class="gras indiv align_center">Prévisualisation de votre profil public :</div><br>
        <hr>
        <br>
        <?=$profil_previsualisation?>
      </div>
      <?php } ?>

      <div class="body_main smallsize">
        <span class="soustitre">Colonne de droite : Espace personnalisable</span><br>
        <br>
        Cet espace est à votre disposition pour afficher ce dont vous avez envie, bien entendu dans la limite de ce qui est acceptable selon les <a href="<?=$chemin?>pages/doc/eula">termes et conditions</a> de NoBleme.<br>
        <br>
        Vous pouvez utiliser des <a href="<?=$chemin?>pages/doc/emotes">emoticones</a> et des <a href="<?=$chemin?>pages/doc/bbcodes">bbcodes</a> dans le texte de votre profil public.<br>
        <br>
        <textarea class="indiv" rows="15" name="profil_texte"><?=$profil_texte?></textarea>
        <br>
        <div class="indiv align_center">
          <input type="image" src="<?=$chemin?>img/boutons/previsualiser.png" name="profil_droite_previsualiser" alt="Prévisualiser">
          <img src="<?=$chemin?>img/boutons/separateur.png" alt="|">
          <input type="image" src="<?=$chemin?>img/boutons/modifier.png" name="profil_droite_modifier" alt="Modifier">
        </div>
      </div>

    </form>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';