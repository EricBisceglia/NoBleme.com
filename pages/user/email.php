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
$header_sidemenu  = 'ChangerEmail';

// Identification
$page_nom = "En a marre de son adresse e-mail";
$page_url = "pages/user/email";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Changer d'e-mail" : "Change my e-mail";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On chope l'userid, si y'en a pas on arrête tout
$user_id = (isset($_SESSION['user'])) ? $_SESSION['user'] : erreur('Utilisateur invalide', $chemin, $lang, 'Compte', 'ChangerEmail');

// Modifier l'adresse e-mail
if(isset($_POST['emailModifier']))
{
  $email = postdata_vide('emailCompte', 'string', '');
  query(" UPDATE  membres
          SET     membres.email = '$email'
          WHERE   membres.id    = '$user_id' ");
  $email_css = ' texte_positif gras';
}
else
  $email_css = '';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher l'e-mail actuel
$qemail = mysqli_fetch_array(query("  SELECT  membres.email
                                      FROM    membres
                                      WHERE   membres.id = '$user_id' "));

// Et on le prépare pour l'affichage
$email = predata($qemail['email']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']        = "Changer d'adresse e-mail";
  $trad['desc']         = "Votre compte est lié à une adresse e-mail, dont NoBleme ne devrait normalement presque jamais se servir. Vous êtes même libre de supprimer l'adresse stockée et de n'avoir aucune adresse mail liée à votre compte, si vous le désirez. Toutefois, en cas de perte de votre mot de passe, posséder votre e-mail pourrait être un outil pratique pour récupérer l'accès à votre compte. À vous de voir !";

  // Formulaire
  $trad['form_titre']   = "Adresse e-mail liée à votre compte";
  $trad['form_submit']  = "CHANGER MON ADRESSE E-MAIL";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']        = "Change my e-mail address";
  $trad['desc']         = "Your account is linked to an e-mail address, which NoBleme will barely ever make use of. You are even free to delete the address and not have any e-mail linked to your account if you want to. However, if you ever lose your password, having a valid e-mail address could be a helpful tool to recover your account. You decide!";

  // Formulaire
  $trad['form_titre']   = "E-mail address tied to your account";
  $trad['form_submit']  = "CHANGE MY E-MAIL ADDRESS";
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
            <label for="emailCompte"><?=$trad['form_titre']?></label>
            <input id="emailCompte" name="emailCompte" class="indiv<?=$email_css?>" type="text" value="<?=$email?>"><br>
            <br>
            <input value="<?=$trad['form_submit']?>" type="submit" name="emailModifier">
          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';