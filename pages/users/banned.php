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
$header_sidemenu  = 'MonProfil';

// Identification
$page_nom = "Déprime parce qu'il est banni";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Banni !" : "Banned!";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher la raison et la date de fin du ban
$user_id = $_SESSION['user'];
$qbanned = mysqli_fetch_array(query(" SELECT  membres.banni_date ,
                                              membres.banni_raison
                                      FROM    membres
                                      WHERE   membres.id = '$user_id' "));

// Si l'user est pas banni, on le redirige
if(!$qbanned['banni_date'])
  exit(header("Location: ".$chemin."pages/users/user"));

// Si l'user a purgé son ban, on le retire et on le redirige
$timestamp = time();
if($timestamp > $qbanned['banni_date'])
{
  query(" UPDATE  membres
          SET     membres.banni_date    = 0 ,
                  membres.banni_raison  = ''
          WHERE   membres.id = '$user_id' ");
  exit(header("Location: ".$chemin."pages/users/user"));
}

// On prépare les infos pour l'affichage
$ban_raison = predata($qbanned['banni_raison']);
$ban_date   = datefr(date('Y-m-d', $qbanned['banni_date']), $lang);
$ban_heure  = date('H:i', $qbanned['banni_date']);
$ban_dans   = changer_casse(dans($qbanned['banni_date'], $lang), 'min');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "Banni !";

  // Corps
  $temp_raison        = ($ban_raison) ? $ban_raison : 'Raison non spécifiée';
  $trad['desc']       = <<<EOD
Félicitations, à force d'enfreindre le code de conduite du site, vous avez été banni de NoBleme !<br>
<br>
La raison de votre bannissement est: <span class="texte_negatif gras">$ban_raison</span><br>
Vous êtes banni jusqu'au <span class="texte_negatif gras">$ban_date à $ban_heure ($ban_dans)</span><br>
<br>
Si vous trouvez ce ban injuste et désirez le contester, vous pouvez venir en discuter poliment avec l'équipe administrative du site sur notre serveur IRC en <a class="gras" href="https://client00.chat.mibbit.com/?url=irc%3A%2F%2Firc.nobleme.com%2FNoBleme&charset=UTF-8">cliquant ici</a>.<br>
<br>
En attendant, vous pouvez continuer à naviguer sur le site en tant qu'invité, <a class="gras" href="<?=$chemin?>pages/users/banned?logout">cliquez ici</a> pour vous déconnecter de votre compte. Si vous voulez jouer au plus malin et vous créer un nouveau compte pour contourner le ban, vous vous prendrez un bannissement par adresse IP.
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']      = "Banned!";

  // Corps
  $trad['desc']       = <<<EOD
Congratulations, you managed to break NoBleme's code of conduct hard enough to get yourself banned!<br>
<br>
Your account will be banned until <span class="texte_negatif gras">$ban_date à $ban_heure ($ban_dans)</span><br>
<br>
If you do not believe that you deserved a ban, you can come and politiely appeal to NoBleme's administrative staff on our IRC server by <a class="gras" href="https://client00.chat.mibbit.com/?url=irc%3A%2F%2Firc.nobleme.com%2Fenglish&charset=UTF-8">clicking here</a>.<br>
<br>
Meanwhile, you are free to browse the website as a guest, <a class="gras" href="<?=$chemin?>pages/users/banned?logout">click here</a> to log out of your account.<br>If you want to play clever kid and create a new account to go around the ban, you will end up IP banned.
EOD;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1 class="texte_negatif"><?=$trad['titre']?></h1>

        <p><?=$trad['desc']?></p>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';