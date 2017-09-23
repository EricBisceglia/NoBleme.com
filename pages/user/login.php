<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
guestonly($lang);

// Menus du header
$header_menu = 'NoBleme';

// Identification
$page_nom = "Se connecte à son compte";
$page_url = "pages/user/login";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Connexion" : "Login";
$page_desc  = "Se connecter à son compte fin d'accéder à tous les services du site";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Connexion

// Login
if(isset($_POST['nobleme_login_x']))
{
  // Récupération du postdata
  $login_pseudo   = predata($_POST['nobleme_pseudo']);
  $login_souvenir = (isset($_POST['nobleme_souvenir'])) ? 'checked' : '';
  $pseudo         = destroy_html(postdata($_POST['nobleme_pseudo']));
  $pass           = destroy_html(postdata($_POST['nobleme_pass']));
  $souvenir       = postdata_vide('nobleme_souvenir');

  // Vérification que le pseudo & pass sont bien rentrés
  if($pseudo != "" && $pass != "")
  {
    // On check si la personne tente de bruteforce nobleme
    $brute_ip     = postdata($_SERVER["REMOTE_ADDR"]);
    $timecheck    = (time() - 3600);
    $qcheckbrute  = query(" SELECT COUNT(*) AS 'num_brute' FROM membres_essais_login WHERE ip = '$brute_ip' AND timestamp > '$timecheck' ");
    $checkbrute   = mysqli_fetch_array($qcheckbrute);
    if( $checkbrute['num_brute'] > 14 )
      exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Non mais ho, c\'est quoi cette tentative de choper les mots de passe des gens ?<br><br>Vous êtes privé d\'utiliser un compte sur NoBleme pendant une heure.<br><br>Revenez quand vous serez calmé.<br><br>Couillon.</body></html>');
    else
    {
      // On récupère les pseudos correspondant au pseudo rentré
      $login = query(" SELECT membres.pass , membres.id FROM membres WHERE membres.pseudonyme = '$pseudo' ");

      // On s'arrête là si ça ne renvoie pas de résultat
      if (mysqli_num_rows($login) == 0)
        $erreur = "Ce pseudonyme n'existe pas";
      else
      {

        // On sale le mot de passe, puis on compare si le pass entré correspond au pass stocké
        $passtest     = postdata(salage($pass));
        $passtest_old = postdata(salage($pass,1));

        while($logins = mysqli_fetch_array($login))
        {
          // Vérifions s'il y a bruteforce
          $login_id         = postdata($logins['id']);
          $timecheck        = (time() - 60);
          $qcheckbruteforce = query(" SELECT COUNT(*) AS 'num_brute' FROM membres_essais_login WHERE FKmembres = '$login_id' AND timestamp > '$timecheck' ");
          $checkbruteforce  = mysqli_fetch_array($qcheckbruteforce);

          // Pas de bruteforce? Allons-y
          $login_ok     = 0;
          $bonpass      = $logins['pass'];

          if(($bonpass === $passtest || $bonpass === $passtest_old) && $checkbruteforce['num_brute'] < 5)
          {
            // C'est bon, on peut login
            $login_ok = 1;

            // Si on en est encore au vieux pass, on le fait sauter et on met le nouveau pass à la place
            if($bonpass !== 'nope')
              query(" UPDATE membres SET pass = '$passtest' WHERE id = '$login_id' ");
          }
          else
            $erreur = "Trop d'essais de connexion à ce compte dans la dernière minute<br><a href=\"".$chemin."pages/user/register?oublie\" class=\"dark\">Mot de passe oublié ?</a>";
        }

        // Si le pass est pas bon, dehors. Et tant qu'on y est, on log l'essai en cas de bruteforce
        if(!$login_ok && $checkbruteforce['num_brute'] < 5)
        {
          $timestamp  = time();
          query(" INSERT INTO membres_essais_login SET FKmembres = '$login_id' , timestamp = '$timestamp' , ip = '$brute_ip' ");
          $erreur     = "Mot de passe incorrect<br><a href=\"".$chemin."pages/user/register?oublie\" class=\"dark\">Mot de passe oublié ?</a>";
        }
        else if ($checkbruteforce['num_brute'] < 5)
        {
          // On est bons, reste plus qu'à se connecter!
          if($souvenir == "ok")
          {
            // Si checkbox se souvenir est cochée, on crée un cookie
            setcookie("nobleme_memory", salage($pseudo) , time()+630720000, "/");
            $_SESSION['user'] = $login_id;
          }
          else
          {
            // Sinon, on se contente d'ouvrir une session
            $_SESSION['user'] = $login_id;
          }

          // Validation & redirection
          $erreur = "Login ok, rechargez la page";
          header("location: ".$chemin."pages/user/notifications");

        }
      }
    }

  }
  // Si pseudo & pass ne sont pas correctement entrés, messages d'erreur
  else if ($pseudo != "" && $pass == "")
    $erreur = "Vous n'avez pas rentré de mot de passe.";
  else if ($pseudo == "" && $pass != "")
    $erreur = "Vous n'avez pas rentré de pseudonyme.";
  else
    $erreur = "Vous n'avez pas rentré d'identifiants.";
}
else
{
  $login_pseudo   = "";
  $erreur         = "";
  $login_souvenir = "checked";
}


/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="align_center">
      <img src="<?=$chemin?>img/logos/connexion.png" alt="Connexion">
    </div>
    <br>

    <div class="body_main minisize">
      <form name="login" action="login" method="POST">
        <table class="indiv">
          <tr>
            <td class="align_right gras login_texte">
              Pseudonyme :&nbsp;
            </td>
            <td>
             <input type="text" name="nobleme_pseudo" class="intable" value="<?=$login_pseudo?>">
           </td>
          </tr>
          <tr>
            <td class="align_right gras login_texte">
              Mot de passe :&nbsp;
            </td>
            <td>
              <input type="password" name="nobleme_pass" class="intable">
            </td>
          </tr>
          <tr>
            <td colspan="2" class="align_center gras vspaced">
              <input type="checkbox" name="nobleme_souvenir" value="ok" <?=$login_souvenir?>> Se souvenir de moi
            </td>
          </tr>
          <tr>
            <td colspan="2" class="align_center gras">
              <input type="image" src="<?=$chemin?>img/boutons/connexion.png" name="nobleme_login" alt="Connexion">
            </td>
          </tr>
        </table>
      </form>
    </div>

    <?php if($erreur) { ?>
    <div class="body_main minisize">
      <div class="align_center gras">
        <div class="vspaced">
          <span class="erreur spaced moinsgros souligne">ERREUR !</span>
        </div>
        <?=$erreur?>
      </div>
    </div>
    <?php } ?>



<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';