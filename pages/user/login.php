<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
guestonly($lang);

// Identification
$page_nom = "Se connecte à son compte";
$page_url = "pages/user/login";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Connexion" : "Login";
$page_desc  = "Se connecter à son compte NoBleme pour profiter de tous les services du site";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Gestion de la connexion
if(isset($_POST['login_pseudo']))
{
  // Récupération du postdata
  $login_pseudo   = predata($_POST['login_pseudo']);
  $login_souvenir = (isset($_POST['login_souvenir'])) ? ' checked' : '';
  $pseudo         = destroy_html(postdata($_POST['login_pseudo'], "string"));
  $pass           = destroy_html(postdata($_POST['login_pass'], "string"));
  $souvenir       = postdata_vide('login_souvenir');

  // Vérification que le pseudo & pass sont bien rentrés
  if($pseudo != "" && $pass != "")
  {
    // On check si la personne tente de bruteforce nobleme
    $brute_ip     = postdata($_SERVER["REMOTE_ADDR"], "string");
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
        $erreur = ($lang == 'FR') ? "Ce pseudonyme n'existe pas" : "This nickname does not exist";
      else
      {

        // On sale le mot de passe, puis on compare si le pass entré correspond au pass stocké
        $passtest     = postdata(salage($pass));
        $passtest_old = postdata(salage($pass,1));

        while($logins = mysqli_fetch_array($login))
        {
          // Vérifions s'il y a bruteforce
          $login_id         = postdata($logins['id'], "int");
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
            $erreur = ($lang == 'FR') ? "Trop d'essais de connexion dans la dernière minute<br><a href=\"".$chemin."pages/user/login?oublie\" class=\"dark\">Mot de passe oublié ?</a>" : "Too many login attempts in the past minute<br><a href=\"".$chemin."pages/user/login?oublie\" class=\"dark\">Forgot your password?</a>";
        }

        // Si le pass est pas bon, dehors. Et tant qu'on y est, on log l'essai en cas de bruteforce
        if(!$login_ok && $checkbruteforce['num_brute'] < 5)
        {
          $timestamp  = time();
          query(" INSERT INTO membres_essais_login SET FKmembres = '$login_id' , timestamp = '$timestamp' , ip = '$brute_ip' ");
          $erreur     = ($lang == 'FR') ? "Mot de passe incorrect<br><a href=\"".$chemin."pages/user/login?oublie\" class=\"dark\">Mot de passe oublié ?</a>" : "Incorrect password<br><a href=\"".$chemin."pages/user/login?oublie\" class=\"dark\">Forgot your password?</a>";
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
          header("location: ".$chemin."pages/user/notifications");

        }
      }
    }

  }
  // Si pseudo & pass ne sont pas correctement entrés, messages d'erreur
  else if ($pseudo != "" && $pass == "")
    $erreur = ($lang == 'FR') ? "Vous n'avez pas rentré de mot de passe" : "You must enter a password";
  else if ($pseudo == "" && $pass != "")
    $erreur = ($lang == 'FR') ? "Vous n'avez pas rentré de pseudonyme" : "You must enter a nickname";
  else
    $erreur = ($lang == 'FR') ? "Vous n'avez pas rentré d'identifiants" : "You must enter a nickname and a password";
}
else
{
  $login_pseudo   = "";
  $erreur         = "";
  $login_souvenir = " checked";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUTION DU CONTENU MULTILINGUE                                                    */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Titres et messages
$traduction['titre']        = ($lang == 'FR') ? "Connexion" : "Login";
$traduction['titre_oublie'] = ($lang == 'FR') ? "Mot de passe oublié" : "Forgotten password";
$traduction['titre_bien']   = ($lang == 'FR') ? "Bienvenue sur NoBleme !" : "Welcome to NoBleme !";
$traduction['register']     = ($lang == 'FR') ? "Vous n'avez pas de compte ? Cliquez ici pour en créer un !" : "Don't have an account? Click here to register one!";
$traduction['reg_erreur']   = ($lang == 'FR') ? "ERREUR:" : "ERROR:";

// Formulaire
$traduction['reg_nick']     = ($lang == 'FR') ? "Pseudonyme" : "Nickname";
$traduction['reg_pass']     = ($lang == 'FR') ? "Mot de passe" : "Password";
$traduction['reg_souvenir'] = ($lang == 'FR') ? "Se souvenir de moi" : "Remember me";

// Mot de passe oublié
if($lang == 'FR')
  $traduction['reg_oublie'] = "<p>Pour des raisons de sécurité, NoBleme n'envoie pas les mots de passe en clair par e-mail, et il n'y a pas non plus (pour le moment) de formulaire de récupération de mot de passe.</p><p>Si vous avez perdu l'accès à votre compte, la seule solution est de venir sur le <a class=\"gras\" href=\"".$chemin."pages/irc/index\">serveur de discussionIRC</a> pour demander à un <a class=\"gras\" href=\"".$chemin."pages/nobleme/admins\">administrateur ou sysop</a> de vous assigner un nouveau mot de passe.</p>";
else
  $traduction['reg_oublie'] = "<p>For security reasons, NoBleme account passwords are not sent through e-mail, and there isn't (yet) an automated form to recover your password.</p><p>If you fully lost access to your account, you can come on our <a class=\"gras\" href=\"".$chemin."pages/irc/index\">IRC chat server</a> and ask an <a class=\"gras\" href=\"".$chemin."pages/nobleme/admins\">admin or sysop</a> to give your account a new password.</p>";

// Bienvenue sur NoBleme
if($lang == 'FR')
  $traduction['reg_bien'] = "<p>Votre compte a été crée, et vous pouvez maintenant vous y connecter en vous servant du formulaire de connexion ci-dessous. Bienvenue parmi nous, et bon séjour sur NoBleme !<br><br>Votre administrateur,<br>Bad</p>";
else
  $traduction['reg_bien'] = "<p>Your account has successfully being created. You can now log into your account using the form below. Welcome amongst us, and enjoy your stay on NoBleme!<br><br>Your admin,<br>Bad</p>";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>


      <div class="texte">

        <?php if(isset($_GET['oublie'])) { ?>

        <h2><?=$traduction['titre_oublie']?></h2>

        <?=$traduction['reg_oublie']?>

        <br>

      </div>

      <hr class="separateur_contenu">

        <div class="texte">

        <br>

        <?php } else if(isset($_GET['bienvenue'])) { ?>

        <h2><?=$traduction['titre_bien']?></h2>

        <?=$traduction['reg_bien']?>

        <br>

      </div>

      <hr class="separateur_contenu">

        <div class="texte">

        <br>

        <?php } ?>

        <h1 class="indiv align_center"><?=$traduction['titre']?></h1>

        <p class="align_center gras moinsgros">
          <a href="<?=$chemin?>pages/user/register"><?=$traduction['register']?></a>
        </p>

        <br>
        <br>

        <?php if($erreur) { ?>
        <h5 class="texte_negatif gras indiv align_center">
          <span class="souligne"><?=$traduction['reg_erreur']?></span> <?=$erreur?>
        </h5>
        <br>
        <br>
        <?php } ?>

      </div>

      <div class="minitexte">

        <form method="POST" action="login">
          <fieldset>
            <label for="login_pseudo"><?=$traduction['reg_nick']?></label>
            <input id="login_pseudo" name="login_pseudo" class="indiv" type="text" value="<?=$login_pseudo?>"><br>
            <br>
            <label for="login_pass"><?=$traduction['reg_pass']?></label>
            <input id="login_pass" name="login_pass" class="indiv" type="password"><br>
            <br>
            <div class="float-right">
              <input id="login_souvenir" name="login_souvenir" type="checkbox"<?=$login_souvenir?>>
              <label class="label-inline" for="login_souvenir"><?=$traduction['reg_souvenir']?></label>
            </div>
            <input value="<?=$traduction['titre']?>" type="submit">
          </fieldset>
        </form>

      </div>

      <br>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';