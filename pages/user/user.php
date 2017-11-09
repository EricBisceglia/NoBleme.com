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
$page_url = "pages/user/user?id=";

// Lien court
$shorturl = "u=";

// Langages disponibles
$langage_page = array('FR','EN');

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
    erreur($temp_erreur);
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
                                membres.genre           AS 'u_genre'      ,
                                membres.anniversaire    AS 'u_anniv'      ,
                                membres.habite          AS 'u_habite'     ,
                                membres.metier          AS 'u_metier'     ,
                                membres.email           AS 'u_email'      ,
                                membres.profil          AS 'u_profil'
                    FROM        membres
                    WHERE       membres.id = '$user_id' ");

// Si le membre existe pas, on dégage
if(!mysqli_num_rows($qprofil))
{
  $temp_erreur = ($lang == 'FR') ? 'Cet utilisateur n\'existe pas' : 'This user does not exist';
  erreur($temp_erreur);
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
$temp_date        = date('Y-m-d');
$qprofil_irl      = mysqli_fetch_array(query("  SELECT    COUNT(irl_participants.id) AS 'num_irls'
                                                FROM      irl_participants
                                                LEFT JOIN irl ON irl_participants.FKirl = irl.id
                                                WHERE     irl.date                    <= '$temp_date'
                                                AND       irl_participants.FKmembres  = '$user_id'
                                                AND       irl_participants.confirme   = 1 "));

$qprofil_quotes   = mysqli_fetch_array(query("  SELECT    COUNT(quotes_membres.id) AS 'num_quotes'
                                                FROM      quotes_membres
                                                LEFT JOIN quotes ON quotes_membres.FKquotes = quotes.id
                                                WHERE     quotes_membres.FKmembres  = '$user_id'
                                                AND       quotes.valide_admin       = 1 "));

$qprofil_quotesub = mysqli_fetch_array(query("  SELECT    COUNT(quotes.id) AS 'num_quotes'
                                                FROM      quotes
                                                WHERE     quotes.FKauteur     = '$user_id'
                                                AND       quotes.valide_admin = 1 "));

$qprofil_todo     = mysqli_fetch_array(query("  SELECT    COUNT(todo.id) AS 'num_todos'
                                                FROM      todo
                                                WHERE     todo.FKmembres    = '$user_id'
                                                AND       todo.valide_admin = 1
                                                AND       todo.public       = 1 "));

// Reste plus qu'à préparer tout ça pour l'affichage
$profil_pseudo    = predata($dprofil['u_pseudo']);
$profil_admin     = $dprofil['u_admin'];
$profil_sysop     = $dprofil['u_sysop'];
$profil_mod       = $dprofil['u_mod'];
$profil_banni     = ($dprofil['u_ban_date']) ? jourfr(date('Y-m-d', $dprofil['u_ban_date']), $lang) : 0;
$profil_sysop_ban = (!$dprofil['u_ban_date']) ? 'BANNIR' : 'DÉBANNIR';
$profil_bannidans = changer_casse(dans($dprofil['u_ban_date'], $lang), 'min');
$profil_banraison = predata($dprofil['u_ban_raison']);
$profil_contenu   = ($dprofil['u_profil']) ? bbcode(predata($dprofil['u_profil'], 1)) : '';
$profil_creation  = jourfr(date('Y-m-d', $dprofil['u_creation']), $lang).' ('.ilya($dprofil['u_creation'], $lang).')';
$profil_activite  = ilya($dprofil['u_activite'], $lang);
$profil_genre     = predata($dprofil['u_genre']);
$profil_age       = ($dprofil['u_anniv'] != '0000-00-00') ? floor((time() - strtotime($dprofil['u_anniv'])) / 31556926) : '';
$profil_anniv     = ($dprofil['u_anniv'] != '0000-00-00') ? jourfr($dprofil['u_anniv'], $lang) : '';
$profil_lieu      = predata($dprofil['u_habite']);
$profil_metier    = predata($dprofil['u_metier']);
$profil_email     = predata($dprofil['u_email']);
$profil_irl       = $qprofil_irl['num_irls'];
$profil_quotes    = $qprofil_quotes['num_quotes'];
$profil_quotesub  = $qprofil_quotesub['num_quotes'];
$profil_todo      = $qprofil_todo['num_todos'];




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

        <br>
        <br>

        <div class="flexcontainer">
          <div style="flex:15">

            <div class="profil_cadre align_center">

              <?php if(getsysop()) { ?>
              <button class="profil_bouton button-outline" onclick="window.location.href = '<?=$chemin?>pages/sysop/profil?id=<?=$user_id?>';">MODIFIER LE PROFIL</button>
              &nbsp;
              <button class="profil_bouton button-outline" onclick="window.location.href = '<?=$chemin?>pages/sysop/ban?id=<?=$user_id?>';"><?=$profil_sysop_ban?></button>

              <hr class="profil_hr">
              <?php } if (loggedin() && $user_id == $_SESSION['user']) { ?>
              <button class="profil_bouton" onclick="window.location.href = '<?=$chemin?>pages/user/profil';"><?=$trad['bouton_profil']?></button>
              <?php } else { ?>
              <button class="profil_bouton" onclick="window.location.href = '<?=$chemin?>pages/user/pm?user=<?=$user_id?>';"><?=$trad['bouton_message']?></button>
              <?php } ?>

              <hr class="profil_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/nobleme/membres';">
                <span class="gras"><?=$trad['user_creation']?></span><br>
                <?=$trad['usert_creation'].$profil_creation?>
              </div>

              <hr class="profil_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/nobleme/online';">
                <span class="gras"><?=$trad['user_activite']?></span><br>
                <?=$profil_activite?>
              </div>

              <?php if($profil_genre) { ?>
              <hr class="profil_hr">
              <span class="gras"><?=$trad['user_genre']?></span><br>
              <?=$profil_genre?>

              <?php } if($profil_anniv) { ?>
              <hr class="profil_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/nobleme/anniversaires';">
                <span class="gras"><?=$trad['user_age']?></span><br>
                <?=$profil_age.$trad['user_anniv'].$profil_anniv?>
              </div>

              <?php } if($profil_lieu) { ?>
              <hr class="profil_hr">
              <span class="gras"><?=$trad['user_lieu']?></span><br>
              <?=$profil_lieu?>

              <?php } if($profil_metier) { ?>
              <hr class="profil_hr">
              <span class="gras"><?=$trad['user_metier']?></span><br>
              <?=$profil_metier?>

              <?php } if($profil_irl) { ?>
              <hr class="profil_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/irl/stats';">
                <span class="gras"><?=$trad['user_irl']?></span><br>
                <?=$trad['usert_irl']?>
              </div>

              <?php } if($profil_quotes && $lang == 'FR') { ?>
              <hr class="profil_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/quotes/stats';">
                <span class="gras">Apparitions dans les miscellanées</span><br>
                <span class="gras texte_noir"><?=$profil_quotes?></span>
              </div>

              <?php } if($profil_quotesub && $lang == 'FR') { ?>
              <hr class="profil_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/quotes/stats';">
                <span class="gras">Miscellanées proposées</span><br>
                <span class="gras texte_noir"><?=$profil_quotesub?></span>
              </div>

              <?php } if($profil_todo && $lang == 'FR') { ?>
              <hr class="profil_hr">
              <div class="pointeur" onclick="window.location.href = '<?=$chemin?>pages/todo/index';">
                <span class="gras">Tickets ouverts</span><br>
                <span class="gras texte_noir"><?=$profil_todo?></span>
              </div>

              <?php } if($profil_email && getadmin()) { ?>
              <hr class="profil_hr">
              <span class="gras">E-mail du compte</span><br>
              <?=$profil_email?>

              <?php } ?>
              <hr class="profil_hr">

            </div>

          </div>

          <div style="flex:1">
            &nbsp;
          </div>

          <div style="flex:20">

            <div class="profil_cadre"><?=$profil_contenu?></div>

          </div>
        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';