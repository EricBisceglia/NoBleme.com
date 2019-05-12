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
$header_sidemenu  = 'ChangerPass';

// Identification
$page_nom = "Protège son compte";
$page_url = "pages/user/pass";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Changer de mot de passe" : "Change my password";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On chope l'userid, si y'en a pas on arrête tout
$user_id = (isset($_SESSION['user'])) ? $_SESSION['user'] : erreur('Utilisateur invalide', $chemin, $lang, 'Compte', 'ChangerPass');

// Modifier le mot de passe
if(isset($_POST['passModifier']))
{
  // On commence par nettoyer le postdata
  $pass_actuel    = postdata_vide('passActuel', 'string', '');
  $pass_nouveau   = postdata_vide('passNouveau', 'string', '');
  $pass_confirmer = postdata_vide('passConfirmer', 'string', '');

  // Si une des entrées est vide, on envoie une erreur
  if(!$pass_actuel || !$pass_nouveau || !$pass_confirmer)
    $erreur = ($lang == 'FR') ? 'Tous les champs doivent être remplis' : 'You must fill all of the fields below';

  // Si le mot de passe actuel est faux, on envoie une erreur
  $cypher_actuel  = salage($pass_actuel);
  $qpasscheck     = mysqli_fetch_array(query("  SELECT  membres.pass
                                                FROM    membres
                                                WHERE   membres.id = '$user_id' "));
  if(!isset($erreur) && $cypher_actuel != $qpasscheck['pass'])
    $erreur = ($lang == 'FR') ? 'Mot de passe actuel incorrect' : 'Incorrect current password';

  // Si les nouveaux pass ne sont pas identiques, on envoie une erreur
  if(!isset($erreur) && $pass_nouveau != $pass_confirmer)
    $erreur = ($lang == 'FR') ? 'Les nouveaux mots de passe sont différents' : 'You entered two different new passwords';

  // Si les nouveaux pass ne sont pas assez longs, on envoie une erreur
  if(!isset($erreur) && mb_strlen($pass_nouveau) < 6)
    $erreur = ($lang == 'FR') ? 'Nouveau mot de passe trop court' : 'Your new password is too short';

  // Maintenant on peut changer le mot de passe
  if(!isset($erreur))
  {
    $nouveau_pass = salage($pass_nouveau);
    query(" UPDATE  membres
            SET     membres.pass  = '$nouveau_pass'
            WHERE   membres.id    = '$user_id' ");
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
  $trad['titre']          = "Changer mon mot de passe";
  $trad['pass_change']    = "Votre mot de passe a bien été changé";

  // Formulaire
  $trad['form_actuel']    = "Entrez votre mot de passe actuel";
  $trad['form_nouveau']   = "Entrez votre nouveau mot de passe (6 caractères minimum)";
  $trad['form_confirmer'] = "Entrez une seconde fois votre nouveau mot de passe";
  $trad['form_submit']    = "CHANGER MON MOT DE PASSE";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']          = "Change my password";
  $trad['pass_change']    = "Your password has successfully been changed";

  // Formulaire
  $trad['form_actuel']    = "Enter your current password";
  $trad['form_nouveau']   = "Enter your new password (6 characters minimum)";
  $trad['form_confirmer'] = "Enter your new password once again";
  $trad['form_submit']    = "CHANGE MY PASSWORD";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h2><?=$trad['titre']?></h2>

        <br>
        <br>

        <?php if(isset($erreur)) { ?>
        <h4 class="negatif texte_blanc align_center"><?=$erreur?></h4>
        <br>
        <br>
        <?php } else if(isset($nouveau_pass)) { ?>
        <h4 class="positif texte_blanc align_center"><?=$trad['pass_change']?></h4>
        <br>
        <br>
        <?php } ?>

        <form method="POST">
          <fieldset>
            <label for="passActuel"><?=$trad['form_actuel']?></label>
            <input id="passActuel" name="passActuel" class="indiv" type="password"><br>
            <br>
            <br>
            <label for="passNouveau"><?=$trad['form_nouveau']?></label>
            <input id="passNouveau" name="passNouveau" class="indiv" type="password"><br>
            <br>
            <label for="passConfirmer"><?=$trad['form_confirmer']?></label>
            <input id="passConfirmer" name="passConfirmer" class="indiv" type="password"><br>
            <br>
            <br>
            <input value="<?=$trad['form_submit']?>" type="submit" name="passModifier">
          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';