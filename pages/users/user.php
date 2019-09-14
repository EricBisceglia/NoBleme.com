<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'ListeDesMembres';

// Identification
$page_nom = "Regarde le profil de ";
$page_url = "pages/users/user?id=";

// Lien court
$shorturl = "u=";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = "Profil de ";
$page_desc  = "Profil public du compte NoBleme de ";

// CSS & JS
$css = array('user');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si on a ni ID ni pseudo, on met son propre profil, ou on renvoie une erreur
if(!isset($_GET['id']) && !isset($_GET['pseudo']))
{
  if(!loggedin())
    useronly($lang);
  else
    $user_id = $_SESSION['user'];
}
// Sinon on récupère l'ID ou le pseudo
else if(isset($_GET['id']))
  $user_id = postdata($_GET['id'], 'int');
else
  $user_pseudo = postdata($_GET['pseudo'], 'string');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si on a un pseudo, on récupère l'ID correspondant
if (isset($user_pseudo))
{
  // On va chercher l'ID
  $qtempuser = query(" SELECT membres.id FROM membres WHERE membres.pseudonyme LIKE BINARY '$user_pseudo' ");

  // S'il existe pas, on dégage
  if(!mysqli_num_rows($qtempuser))
  {
    $temp_erreur = ($lang == 'FR') ? 'Cet utilisateur n\'existe pas' : 'This user does not exist';
    exit(header("Location: ".$chemin."pages/nobleme/membres"));
  }

  // Sinon, on récupère l'ID
  $dtempuser = mysqli_fetch_array($qtempuser);
  $user_id = $dtempuser['id'];
}

// Maintenant, on peut aller chercher les données du profil
$qprofil = query("  SELECT      membres.pseudonyme      AS 'u_pseudo'     ,
                                membres.admin           AS 'u_admin'      ,
                                membres.sysop           AS 'u_sysop'      ,
                                membres.moderateur      AS 'u_mod'        ,
                                membres.date_creation   AS 'u_creation'   ,
                                membres.derniere_visite AS 'u_activite'   ,
                                membres.banni_date      AS 'u_ban_date'   ,
                                membres.banni_raison    AS 'u_ban_raison' ,
                                membres.langue          AS 'u_langue'     ,
                                membres.genre           AS 'u_genre'      ,
                                membres.anniversaire    AS 'u_anniv'      ,
                                membres.habite          AS 'u_habite'     ,
                                membres.metier          AS 'u_metier'     ,
                                membres.email           AS 'u_email'      ,
                                membres.profil          AS 'u_profil'     ,
                                membres.forum_messages  AS 'u_forum'
                    FROM        membres
                    WHERE       membres.id = '$user_id' ");

// Si le membre existe pas, on dégage
if(!mysqli_num_rows($qprofil))
{
  $temp_erreur = ($lang == 'FR') ? 'Cet utilisateur n\'existe pas' : 'This user does not exist';
  exit(header("Location: ".$chemin."pages/nobleme/membres"));
}

// On va commencer par compléter les infos internes de la page
if(loggedin() && $user_id == $_SESSION['user'])
{
  $header_menu      = 'Compte';
  $header_sidemenu  = 'MonProfil';
}
$dprofil            = mysqli_fetch_array($qprofil);
$page_nom           = $page_nom.predata($dprofil['u_pseudo']);
$page_url           = $page_url.$user_id;
$shorturl           = $shorturl.$user_id;
$page_titre         = ($lang == 'FR') ? $page_titre.predata($dprofil['u_pseudo']) : predata($dprofil['u_pseudo']).'\'s profile';
$page_desc          = $page_desc.predata($dprofil['u_pseudo']);


// On va aller chercher d'autres infos sur le membre

$qprofil_forum      = mysqli_fetch_array(query("  SELECT    COUNT(forum_sujet.id) AS 'num_sujets'
                                                  FROM      forum_sujet
                                                  WHERE     forum_sujet.FKmembres_createur    = '$user_id'
                                                  AND       forum_sujet.apparence      NOT LIKE 'Anonyme'
                                                  AND       forum_sujet.public                = 1 "));

$temp_date          = date('Y-m-d');
$qprofil_irl        = mysqli_fetch_array(query("  SELECT    COUNT(irl_participants.id) AS 'num_irls'
                                                  FROM      irl_participants
                                                  LEFT JOIN irl ON irl_participants.FKirl = irl.id
                                                  WHERE     irl.date                     <= '$temp_date'
                                                  AND       irl_participants.FKmembres    = '$user_id'
                                                  AND       irl_participants.confirme     = 1 "));

$qprofil_ecrivains  = mysqli_fetch_array(query("  SELECT    COUNT(ecrivains_texte.id) AS 'num_textes'
                                                  FROM      ecrivains_texte
                                                  WHERE     ecrivains_texte.FKmembres = '$user_id' "));

$qprofil_necrivains = mysqli_fetch_array(query("  SELECT    COUNT(ecrivains_note.id) AS 'num_reactions'
                                                  FROM      ecrivains_note
                                                  WHERE     ecrivains_note.FKmembres = '$user_id' "));

$profil_concoursecr = mysqli_fetch_array(query("  SELECT    COUNT(ecrivains_texte.id) AS 'num_textes'
                                                  FROM      ecrivains_texte
                                                  WHERE     ecrivains_texte.FKmembres             = '$user_id'
                                                  AND       ecrivains_texte.FKecrivains_concours != 0 "));

$profil_gagnantcecr = mysqli_fetch_array(query("  SELECT    COUNT(ecrivains_concours.id) AS 'num_concours'
                                                  FROM      ecrivains_concours
                                                  WHERE     ecrivains_concours.FKmembres_gagnant = '$user_id' "));

$qprofil_quotes     = mysqli_fetch_array(query("  SELECT    COUNT(quotes_membres.id) AS 'num_quotes'
                                                  FROM      quotes_membres
                                                  LEFT JOIN quotes ON quotes_membres.FKquotes = quotes.id
                                                  WHERE     quotes_membres.FKmembres          = '$user_id'
                                                  AND       quotes.valide_admin               = 1 "));

$qprofil_quotesub   = mysqli_fetch_array(query("  SELECT    COUNT(quotes.id) AS 'num_quotes'
                                                  FROM      quotes
                                                  WHERE     quotes.FKauteur     = '$user_id'
                                                  AND       quotes.valide_admin = 1 "));

$qprofil_todo       = mysqli_fetch_array(query("  SELECT    COUNT(todo.id) AS 'num_todos'
                                                  FROM      todo
                                                  WHERE     todo.FKmembres    = '$user_id'
                                                  AND       todo.valide_admin = 1
                                                  AND       todo.public       = 1 "));

// Reste plus qu'à préparer tout ça pour l'affichage
$profil_pseudo      = predata($dprofil['u_pseudo']);
$profil_admin       = $dprofil['u_admin'];
$profil_sysop       = $dprofil['u_sysop'];
$profil_mod         = $dprofil['u_mod'];
$profil_banni       = ($dprofil['u_ban_date']) ? jourfr(date('Y-m-d', $dprofil['u_ban_date']), $lang) : 0;
$profil_sysop_ban   = (!$dprofil['u_ban_date']) ? 'BANNIR' : 'DÉBANNIR';
$profil_bannidans   = changer_casse(dans($dprofil['u_ban_date'], $lang), 'min');
$profil_banraison   = predata($dprofil['u_ban_raison']);
$profil_langue      = $dprofil['u_langue'];
$profil_contenu     = ($dprofil['u_profil']) ? bbcode(predata($dprofil['u_profil'], 1)) : '';
$profil_creation    = jourfr(date('Y-m-d', $dprofil['u_creation']), $lang).' ('.ilya($dprofil['u_creation'], $lang).')';
$profil_activite    = ilya($dprofil['u_activite'], $lang);
$profil_genre       = predata($dprofil['u_genre']);
$profil_age         = ($dprofil['u_anniv'] != '0000-00-00') ? floor((time() - strtotime($dprofil['u_anniv'])) / 31556926) : '';
$profil_anniv       = ($dprofil['u_anniv'] != '0000-00-00') ? jourfr($dprofil['u_anniv'], $lang) : '';
$profil_lieu        = predata($dprofil['u_habite']);
$profil_metier      = predata($dprofil['u_metier']);
$profil_email       = predata($dprofil['u_email']);
$profil_forum       = $qprofil_forum['num_sujets'];
$profil_forum_2     = $dprofil['u_forum'];
$profil_irl         = $qprofil_irl['num_irls'];
$profil_ecrivains   = "A ";
$temp_pluriel       = ($qprofil_ecrivains['num_textes'] == 1) ? 'texte' : 'textes';
$profil_ecrivains  .= ($qprofil_ecrivains['num_textes']) ? 'publié <span class="gras texte_noir">'.$qprofil_ecrivains['num_textes'].'</span> '.$temp_pluriel : '';
$profil_ecrivains  .= ($qprofil_ecrivains['num_textes'] && $qprofil_necrivains['num_reactions']) ? ' et ' : '';
$temp_pluriel       = ($qprofil_necrivains['num_reactions'] == 1) ? 'texte' : 'textes';
$profil_ecrivains  .= ($qprofil_necrivains['num_reactions']) ? 'réagi à <span class="gras texte_noir">'.$qprofil_necrivains['num_reactions'].'</span> '.$temp_pluriel : '';
$profil_ecrivains   = ($qprofil_ecrivains['num_textes'] || $qprofil_necrivains['num_reactions']) ? $profil_ecrivains : '';
$profil_concoursecr = ($profil_concoursecr['num_textes']) ? 'A participé <span class="gras texte_noir">'.$profil_concoursecr['num_textes'].'</span> fois aux concours d\'écriture' : '';
$profil_gagnantcecr = ($profil_gagnantcecr['num_concours']) ? 'A gagné <span class="gras texte_noir">'.$profil_gagnantcecr['num_concours'].'</span> concours du coin des écrivains' : '';
$profil_quotes      = $qprofil_quotes['num_quotes'];
$profil_quotesub    = $qprofil_quotesub['num_quotes'];
$profil_todo        = $qprofil_todo['num_todos'];




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['soustitre']      = "Membre #".$user_id;
  $trad['banni']          = "Banni jusqu'au $profil_banni ($profil_bannidans)<br>Raison: $profil_banraison";
  $trad['admin']          = "Administrateur";
  $trad['sysop']          = "Sysop";
  $trad['mod']            = "Modérateur";
  $trad['fr']             = "Parle français";
  $trad['en']             = "Parle anglais";

  // Profil
  $trad['bouton_profil']  = "MODIFIER MON PROFIL PUBLIC";
  $trad['bouton_message'] = "ENVOYER UN MESSAGE PRIVÉ";
  $trad['user_creation']  = "Création du compte";
  $trad['usert_creation'] = "Le ";
  $trad['user_activite']  = "Dernière visite";
  $trad['user_genre']     = "Genre";
  $trad['user_age']       = "Âge / Anniversaire";
  $trad['user_anniv']     = " ans / Né le ";
  $trad['user_lieu']      = "Ville / Pays";
  $trad['user_metier']    = "Métier / Occupation";
  $trad['user_forum']     = "Forum NoBleme";
  $trad['usert_forum']    = "A posté ";
  $temp_pluriel           = ($profil_forum == 1) ? 'sujet' : 'sujets';
  $trad['usert_forum']   .= ($profil_forum) ? '<span class="gras texte_noir">'.$profil_forum.'</span> '.$temp_pluriel.' et ' : "";
  $temp_pluriel           = ($profil_forum_2 == 1) ? 'message' : 'messages';
  $trad['usert_forum']   .= ($profil_forum_2) ? '<span class="gras texte_noir">'.$profil_forum_2.'</span> '.$temp_pluriel : "";
  $trad['user_irl']       = "IRLs NoBlemeuses";
  $trad['usert_irl']      = 'Est venu <span class="gras texte_noir">'.$profil_irl.'</span> fois';
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['soustitre']      = "User #".$user_id;
  $trad['banni']          = "Banned until $profil_banni ($profil_bannidans)";
  $trad['admin']          = "Administrator";
  $trad['sysop']          = "Sysop";
  $trad['mod']            = "Moderator";
  $trad['fr']             = "Speaks french";
  $trad['en']             = "Speaks english";

  // Profil
  $trad['bouton_profil']  = "EDIT MY PUBLIC PROFILE";
  $trad['bouton_message'] = "SEND A PRIVATE MESSAGE";
  $trad['user_creation']  = "Account creation";
  $trad['usert_creation'] = "";
  $trad['user_activite']  = "Latest visit";
  $trad['user_genre']     = "Gender";
  $trad['user_age']       = "Age / Birthday";
  $trad['user_anniv']     = " years old / Born ";
  $trad['user_lieu']      = "City / Country";
  $trad['user_metier']    = "Job / Occupation";
  $trad['user_forum']     = "NoBleme forum";
  $trad['usert_forum']    = "Posted ";
  $temp_pluriel           = ($profil_forum == 1) ? 'topic' : 'topics';
  $trad['usert_forum']   .= ($profil_forum) ? '<span class="gras texte_noir">'.$profil_forum.'</span> '.$temp_pluriel.' and ' : "";
  $temp_pluriel           = ($profil_forum_2 == 1) ? 'message' : 'messages';
  $trad['usert_forum']   .= ($profil_forum_2) ? '<span class="gras texte_noir">'.$profil_forum_2.'</span> '.$temp_pluriel : "";
  $trad['user_irl']       = "Real life meetups";
  $trad['usert_irl']      = 'Attended <span class="gras texte_noir">'.$profil_irl.'</span> of them';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte2">

        <h1 class="align_center"><?=$profil_pseudo?></h1>

        <h5 class="align_center"><?=$trad['soustitre']?></h5>

        <?php if($profil_banni) { ?>
        <br>
        <h5 class="align_center texte_negatif"><?=$trad['banni']?></h5>
        <?php } else if($profil_admin) { ?>
        <h5 class="align_center">
          <a class="texte_negatif" href="<?=$chemin?>pages/nobleme/admins"><?=$trad['admin']?></a>
        </h5>
        <?php } else if($profil_sysop) { ?>
        <h5 class="align_center">
          <a class="texte_neutre" href="<?=$chemin?>pages/nobleme/admins"><?=$trad['sysop']?></a>
        </h5>
        <?php } else if($profil_mod) { ?>
        <h5 class="align_center">
          <a class="texte_positif" href="<?=$chemin?>pages/nobleme/admins"><?=$trad['mod']?></a>
        </h5>
        <?php } ?>

        <?php if($profil_langue) { ?>
        <div class="indiv align_center vspaced">
          <?php if($profil_langue == 'FR' || $profil_langue == 'FREN') { ?>
          <img src="<?=$chemin?>img/icones/lang_fr_clear.png" alt="FR" title="<?=$trad['fr']?>">
          <?php } if($profil_langue == 'FREN') { ?>
          &nbsp;
          <?php } if($profil_langue == 'EN' || $profil_langue == 'FREN') { ?>
          <img src="<?=$chemin?>img/icones/lang_en_clear.png" alt="EN" title="<?=$trad['en']?>">
          <?php } ?>
        </div>
        <?php } else { ?>
        <br>
        <?php } ?>

        <br>

        <div class="flexcontainer">
          <div style="flex:15">

            <div class="profile_frame align_center">

              <?php if($est_sysop) { ?>
              <button class="profile_button button-outline" onclick="window.location.href = '<?=$chemin?>pages/sysop/profil?id=<?=$user_id?>';">MODIFIER LE PROFIL</button>
              &nbsp;
              <button class="profile_button button-outline" onclick="window.location.href = '<?=$chemin?>pages/sysop/ban?id=<?=$user_id?>';"><?=$profil_sysop_ban?></button>

              <hr class="profile_hr">
              <?php } if (loggedin() && $user_id == $_SESSION['user']) { ?>
              <button class="profile_button" onclick="window.location.href = '<?=$chemin?>pages/users/profil';"><?=$trad['bouton_profil']?></button>
              <?php } else { ?>
              <button class="profile_button" onclick="window.location.href = '<?=$chemin?>pages/users/pm?user=<?=$user_id?>';"><?=$trad['bouton_message']?></button>
              <?php } ?>

              <hr class="profile_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/nobleme/membres';">
                <span class="gras"><?=$trad['user_creation']?></span><br>
                <?=$trad['usert_creation'].$profil_creation?>
              </div>

              <hr class="profile_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/nobleme/online';">
                <span class="gras"><?=$trad['user_activite']?></span><br>
                <?=$profil_activite?>
              </div>

              <?php if($profil_genre) { ?>
              <hr class="profile_hr">
              <span class="gras"><?=$trad['user_genre']?></span><br>
              <?=$profil_genre?>

              <?php } if($profil_anniv) { ?>
              <hr class="profile_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/nobleme/anniversaires';">
                <span class="gras"><?=$trad['user_age']?></span><br>
                <?=$profil_age.$trad['user_anniv'].$profil_anniv?>
              </div>

              <?php } if($profil_lieu) { ?>
              <hr class="profile_hr">
              <span class="gras"><?=$trad['user_lieu']?></span><br>
              <?=$profil_lieu?>

              <?php } if($profil_metier) { ?>
              <hr class="profile_hr">
              <span class="gras"><?=$trad['user_metier']?></span><br>
              <?=$profil_metier?>

              <?php } if($profil_forum || $profil_forum_2) { ?>
              <hr class="profile_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/forum/index';">
                <span class="gras"><?=$trad['user_forum']?></span><br>
                <?=$trad['usert_forum']?>
              </div>

              <?php } if($profil_irl) { ?>
              <hr class="profile_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/irl/stats';">
                <span class="gras"><?=$trad['user_irl']?></span><br>
                <?=$trad['usert_irl']?>
              </div>

              <?php } if($profil_ecrivains && $lang == 'FR') { ?>
              <hr class="profile_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/ecrivains/index';">
                <span class="gras">Coin des écrivains</span><br>
                <?=$profil_ecrivains?>
              </div>

              <?php } if($profil_concoursecr && $lang == 'FR') { ?>
              <hr class="profile_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/ecrivains/concours_liste';">
                <span class="gras">Concours du coin des écrivains</span><br>
                <?=$profil_concoursecr?>
              </div>

              <?php } if($profil_gagnantcecr && $lang == 'FR') { ?>
              <hr class="profile_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/ecrivains/concours_liste';">
                <span class="gras">Gagnant du concours du coin des écrivains</span><br>
                <?=$profil_gagnantcecr?>
              </div>

              <?php } if($profil_quotes && $lang == 'FR') { ?>
              <hr class="profile_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/quotes/stats';">
                <span class="gras">Miscellanées</span><br>
                Est apparu <span class="gras texte_noir"><?=$profil_quotes?></span> fois
              </div>

              <?php } if($profil_quotesub && $lang == 'FR') { ?>
              <hr class="profile_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/quotes/stats';">
                <span class="gras">Proposition de miscellanées</span><br>
                A proposé <span class="gras texte_noir"><?=$profil_quotesub?></span> miscellanée<?=($profil_quotesub == 1) ? '' : 's'?>
              </div>

              <?php } if($profil_todo && $lang == 'FR') { ?>
              <hr class="profile_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/todo/index';">
                <span class="gras">Liste des tâches</span><br>
                A proposé <span class="gras texte_noir"><?=$profil_todo?></span> tâche<?=($profil_todo == 1) ? '' : 's'?>
              </div>

              <?php } if($profil_email && $est_admin) { ?>
              <hr class="profile_hr">
              <span class="gras">E-mail du compte</span><br>
              <?=$profil_email?>

              <?php } ?>
              <hr class="profile_hr">

            </div>

          </div>

          <div style="flex:1">
            &nbsp;
          </div>

          <div style="flex:20">

            <div class="profile_frame"><?=$profil_contenu?></div>

          </div>
        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';