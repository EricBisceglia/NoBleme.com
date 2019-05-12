<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly($lang);

// Menus du header
$header_menu      = 'Compte';
$header_sidemenu  = 'ModifierProfil';

// Identification
$page_nom = "Modifie son profil public";
$page_url = "pages/user/profil";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Modifier mon profil public" : "Edit my public profile";

// CSS & JS
$css = array('user');
$js  = array('dynamique', 'user/previsualiser_profil');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération des données

// On chope l'userid, si y'en a pas on arrête tout
$profil_id = (isset($_SESSION['user'])) ? $_SESSION['user'] : erreur('Utilisateur invalide', $chemin, $lang, 'Compte', 'ModifierProfil');



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modifier le profil

if(isset($_POST['profil_modifier']))
{
  // Mesure anti flood
  antiflood();

  // Assainissement du postdata
  $edit_langue_fr   = postdata_vide('profilLangueFr', 'string', '');
  $edit_langue_en   = postdata_vide('profilLangueEn', 'string', '');
  $edit_naissance_d = str_pad(postdata_vide('profilNaissanceJour', 'int', 0), 2, '0', STR_PAD_LEFT);
  $edit_naissance_m = str_pad(postdata_vide('profilNaissanceMois', 'int', 0), 2, '0', STR_PAD_LEFT);
  $edit_naissance_y = str_pad(postdata_vide('profilNaissanceAnnee', 'int', 0), 4, '0', STR_PAD_LEFT);
  $edit_naissance   = ($edit_naissance_d != '00' && $edit_naissance_m != '00' && $edit_naissance_y != '0000' ) ? $edit_naissance_y.'-'.$edit_naissance_m.'-'.$edit_naissance_d : '0000-00-00';
  $edit_genre       = postdata_vide('profilGenre', 'string', '', 35);
  $edit_habite      = postdata_vide('profilHabite', 'string', '', 35);
  $edit_metier      = postdata_vide('profilMetier', 'string', '', 35);
  $edit_texte       = postdata_vide('profilTexte', 'string', '');

  // On détermine la langue
  $edit_langue = ($edit_langue_fr) ? 'FR' : '';
  $edit_langue = ($edit_langue_en) ? $edit_langue.'EN' : $edit_langue;

  // On récupère des infos pour le diff
  $dprofilavant = mysqli_fetch_array(query("  SELECT  membres.langue        AS 'm_lang'   ,
                                                      membres.anniversaire  AS 'm_anniv'  ,
                                                      membres.genre         AS 'm_genre'  ,
                                                      membres.habite        AS 'm_habite' ,
                                                      membres.metier        AS 'm_metier' ,
                                                      membres.profil        AS 'm_texte'
                                              FROM    membres
                                              WHERE   membres.id = '$profil_id' "));

  // On met à jour le profil
  query(" UPDATE  membres
          SET     membres.langue        = '$edit_langue'    ,
                  membres.anniversaire  = '$edit_naissance' ,
                  membres.genre         = '$edit_genre'     ,
                  membres.habite        = '$edit_habite'    ,
                  membres.metier        = '$edit_metier'    ,
                  membres.profil        = '$edit_texte'
          WHERE   membres.id = '$profil_id' ");

  // On met une notification dans le log de modération
  $pseudonyme   = postdata(getpseudo($profil_id), 'string');
  $activite_id  = activite_nouveau('profil', 1, $profil_id, $pseudonyme);

  // Ainsi qu'un historique des changements
  $profil_avant_langue  = postdata($dprofilavant['m_lang'], 'string');
  $profil_avant_anniv   = postdata($dprofilavant['m_anniv'], 'string');
  $profil_avant_genre   = postdata($dprofilavant['m_genre'], 'string');
  $profil_avant_habite  = postdata($dprofilavant['m_habite'], 'string');
  $profil_avant_metier  = postdata($dprofilavant['m_metier'], 'string');
  $profil_avant_texte   = postdata($dprofilavant['m_texte'], 'string');
  activite_diff($activite_id, 'Texte', $profil_avant_texte, $edit_texte, 1);
  activite_diff($activite_id, 'Langues parlées', $profil_avant_langue, $edit_langue, 1);
  activite_diff($activite_id, 'Date de naissance', $profil_avant_anniv, $edit_naissance, 1);
  activite_diff($activite_id, 'Genre', $profil_avant_genre, $edit_genre, 1);
  activite_diff($activite_id, 'Ville / Région / Pays', $profil_avant_habite, $edit_habite, 1);
  activite_diff($activite_id, 'Métier / Occupation', $profil_avant_metier, $edit_metier, 1);

  // On envoie un message sur #sysop avec le bot IRC pour qu'un sysop vérifie que ça soit pas du contenu abusif
  ircbot($chemin, getpseudo($profil_id)." a modifié son profil public - ".$GLOBALS['url_site']."pages/user/user?id=".$profil_id, "#sysop");

  // Et on redirige vers le profil public
  exit(header("Location: ".$chemin."pages/user/user"));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Données du profil pour pré-remplir les champs

// On commence par aller chercher les données
$qprofil = mysqli_fetch_array(query(" SELECT  membres.langue        AS 'u_langue' ,
                                              membres.anniversaire  AS 'u_anniv'  ,
                                              membres.genre         AS 'u_genre'  ,
                                              membres.habite        AS 'u_habite' ,
                                              membres.metier        AS 'u_metier' ,
                                              membres.profil        AS 'u_profil'
                                      FROM    membres
                                      WHERE   membres.id = '$profil_id' "));

// Et on les prépare pour l'affichage
$profil_langue_fr = (strstr($qprofil['u_langue'], 'FR')) ? ' checked' : '';
$profil_langue_en = (strstr($qprofil['u_langue'], 'EN')) ? ' checked' : '';
$profil_genre     = predata($qprofil['u_genre']);
$profil_habite    = predata($qprofil['u_habite']);
$profil_metier    = predata($qprofil['u_metier']);
$profil_texte     = predata($qprofil['u_profil']);
$profil_hidden    = (!$qprofil['u_profil']) ? ' class="hidden"' : '';
$profil_preview   = bbcode(predata($qprofil['u_profil'], 1));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menus déroulants pour la date de naissance

// Jour de naissance
$profil_anniv_jour  = ($qprofil['u_anniv'] != '0000-00-00') ? intval(substr($qprofil['u_anniv'],8,2)) : 0;
$select_anniv_jour  = '<option value=""></option>';
for($i = 1; $i <= 31; $i++)
{
  $selected           = ($profil_anniv_jour == $i) ? ' selected' : '';
  $select_anniv_jour .= '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
}

// Mois de naissance
$profil_anniv_mois  = ($qprofil['u_anniv'] != '0000-00-00') ? intval(substr($qprofil['u_anniv'],5,2)) : 0;
$select_anniv_mois  = '<option value=""></option>';
for($i = 1; $i <= 12; $i++)
{
  $selected           = ($profil_anniv_mois == $i) ? ' selected' : '';
  $temp_mois          = ($lang == 'FR') ? $moisfr[$i] : date("F", mktime(0, 0, 0, $i, 10));
  $select_anniv_mois .= '<option value="'.$i.'"'.$selected.'>'.$temp_mois.'</option>';
}

// Année de naissance
$profil_anniv_annee = ($qprofil['u_anniv'] != '0000-00-00') ? intval(substr($qprofil['u_anniv'],0,4)) : 0;
$select_anniv_annee = '<option value=""></option>';
for($i = date('Y'); $i > 1900; $i--)
{
  $selected             = ($profil_anniv_annee == $i) ? ' selected' : '';
  $select_anniv_annee  .= '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']          = "Modifier mon profil public";
  $trad['desc']           = <<<EOD
Cette page vous permet de modifier les éléments qui apparaissent sur votre <a href="{$chemin}pages/user/user" class="gras">profil public</a>. Bien entendu, l'intégralité de ces champs sont optionnels, c'est à vous de décider si vous voulez ou non que ces choses apparaissent publiquement. Si vous préférez rester anonyme, il n'y a aucune conséquence négative à laisser votre profil entièrement vide.
EOD;

  // Informations générales
  $trad['general_titre']  = "Informations générales";
  $trad['general_lang']   = "Langues parlées (vous pouvez cocher les deux)";
  $trad['general_fr']     = "Français";
  $trad['general_en']     = "Anglais";

  // Colonne de gauche
  $trad['gauche_titre']   = "Colonne de gauche : Informations personnelles";
  $trad['gauche_anniv']   = "Date de naissance";
  $trad['gauche_genre']   = "Genre";
  $trad['gauche_tgenre']  = "Masculin, féminin, etc.     35 caractères maximum";
  $trad['gauche_habite']  = "Ville / Région / Pays";
  $trad['gauche_thabite'] = "L'endroit où vous vivez     35 caractères maximum";
  $trad['gauche_metier']  = "Métier / Occupation";
  $trad['gauche_tmetier'] = "Ce que vous faites dans la vie     35 caractères maximum";

  // Colonne de droite
  $trad['droite_titre']   = "Colonne de droite : Espace personnalisable";
  $trad['droite_desc']    = <<<EOD
Cet espace est à votre disposition pour y mettre tout ce dont vous avez envie, bien entendu tout en respectant le <a class="gras" href="{$chemin}pages/doc/coc">code de conduite</a> de NoBleme. Vous pouvez utiliser des <a class="gras" href="{$chemin}pages/doc/emotes">émoticônes</a> et des <a class="gras" href="{$chemin}pages/doc/bbcodes">BBCodes</a> sur votre profil.
EOD;
  $trad['droite_prev']    = "Prévisualisation du profil";
  $trad['droite_valider'] = "MODIFIER MON PROFIL PUBLIC";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']          = "Edit my public profile";
  $trad['desc']           = <<<EOD
This page allows you to edit the contents of elements that appear on your <a href="{$chemin}pages/user/user" class="gras">public profile</a>. Of course, all of those fields are optional, it's up to you to decide whether you want to share those things publicly or not. If you would rather stay fully anonymous, there are no consequences to leaving your public profile empty.
EOD;

// Informations générales
  $trad['general_titre']  = "General information";
  $trad['general_lang']   = "Spoken languages (you can select both)";
  $trad['general_fr']     = "French";
  $trad['general_en']     = "English";

  // Colonne de gauche
  $trad['gauche_titre']   = "Left side: Personal information";
  $trad['gauche_anniv']   = "Date of birth";
  $trad['gauche_genre']   = "Gender";
  $trad['gauche_tgenre']  = "Male, female, etc.     35 character limit";
  $trad['gauche_habite']  = "City / Country:";
  $trad['gauche_thabite'] = "The place where you live     35 character limit";
  $trad['gauche_metier']  = "Job / Occupation";
  $trad['gauche_tmetier'] = "Your life's main activity     35 character limit";

  // Colonne de droite
  $trad['droite_titre']   = "Right side: Customizable area";
  $trad['droite_desc']    = <<<EOD
You are free to put whatever you want in this area of your public profile, as long as it follows NoBleme's <a class="gras" href="{$chemin}pages/doc/coc">code of conduct</a> obviously. You can use <a class="gras" href="{$chemin}pages/doc/emotes">emotes</a> and <a class="gras" href="{$chemin}pages/doc/bbcodes">BBCodes</a> on your public profile.
EOD;
  $trad['droite_prev']    = "Profile preview";
  $trad['droite_valider'] = "EDIT MY PUBLIC PROFILE";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <p><?=$trad['desc']?></p>

        <br>
        <br>

        <form method="POST">
          <fieldset>

            <h5><?=$trad['general_titre']?></h5>

            <br>

            <label><?=$trad['general_lang']?></label>
            <input id="profilLangueFr" name="profilLangueFr" type="checkbox"<?=$profil_langue_fr?>>
            <label class="label-inline" for="profilLangueFr"><?=$trad['general_fr']?></label><br>
            <input id="profilLangueEn" name="profilLangueEn" type="checkbox"<?=$profil_langue_en?>>
            <label class="label-inline" for="profilLangueEn"><?=$trad['general_en']?></label><br>
            <br>
            <br>

            <h5><?=$trad['gauche_titre']?></h5>

            <br>

            <label for="profilNaissanceJour"><?=$trad['gauche_anniv']?></label>
            <div class="flexcontainer">

              <?php if($lang == 'FR') { ?>
              <div style="flex:10">
                <select id="profilNaissanceJour" name="profilNaissanceJour" class="indiv">
                  <?=$select_anniv_jour?>
                </select>
              </div>
              <div style="flex:1">
                &nbsp;
              </div>
              <div style="flex:15">
                <select id="profilNaissanceMois" name="profilNaissanceMois" class="indiv">
                  <?=$select_anniv_mois?>
                </select>
              </div>

              <?php } else { ?>
              <div style="flex:15">
                <select id="profilNaissanceMois" name="profilNaissanceMois" class="indiv">
                  <?=$select_anniv_mois?>
                </select>
              </div>
              <div style="flex:1">
                &nbsp;
              </div>
              <div style="flex:10">
                <select id="profilNaissanceJour" name="profilNaissanceJour" class="indiv">
                  <?=$select_anniv_jour?>
                </select>
              </div>
              <?php } ?>

              <div style="flex:1">
                &nbsp;
              </div>
              <div style="flex:10">
                <select id="profilNaissanceAnnee" name="profilNaissanceAnnee" class="indiv">
                  <?=$select_anniv_annee?>
                </select>
              </div>
              <div style="flex:50">
                &nbsp;
              </div>

            </div>
            <br>

            <label for="profilGenre"><?=$trad['gauche_genre']?></label>
            <input id="profilGenre" name="profilGenre" class="indiv" placeholder="<?=$trad['gauche_tgenre']?>" type="text" maxlength="35" value="<?=$profil_genre?>"><br>
            <br>

            <label for="profilHabite"><?=$trad['gauche_habite']?></label>
            <input id="profilHabite" name="profilHabite" class="indiv" placeholder="<?=$trad['gauche_thabite']?>" type="text" maxlength="35" value="<?=$profil_habite?>"><br>
            <br>

            <label for="profilMetier"><?=$trad['gauche_metier']?></label>
            <input id="profilMetier" name="profilMetier" class="indiv" placeholder="<?=$trad['gauche_tmetier']?>" type="text" maxlength="35" value="<?=$profil_metier?>"><br>

            <br>
            <br>

            <h5><?=$trad['droite_titre']?></h5>

            <p><?=$trad['droite_desc']?></p>

            <br>

            <textarea id="profilTexte" name="profilTexte" class="indiv profil_textarea" lines="20" onkeyup="previsualiser_profil('<?=$chemin?>');"><?=$profil_texte?></textarea><br>
            <br>
            <div id="profil_previsualisation_container"<?=$profil_hidden?>>
              <label><?=$trad['droite_prev']?>:</label>
              <div id="profil_previsualisation" class="vscrollbar profil_previsualisation">
                <?=$profil_preview?>
              </div>
              <br>
            </div>

            <input value="<?=$trad['droite_valider']?>" name="profil_modifier" type="submit">
          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';