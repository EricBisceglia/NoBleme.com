<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly();

// Titre et description
$page_titre = "Changer d'e-mail";
$page_desc  = "Changer l'e-mail que vous utilisez pour récupérer votre compte sur NoBleme";

// Identification
$page_nom = "user";
$page_id  = "email";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si on change le mail
if(isset($_POST['edit_email_go_x']))
{
  // On assainit le postdata
  $edit_email = postdata($_POST['edit_email']);

  // On change l'e-mail
  $user_id = $_SESSION['user'];
  query(" UPDATE membres SET membres.email = '$edit_email' WHERE membres.id = '$user_id' ");

  // Et on fait savoir visuellement que c'est bon
  $edit_email_css = ' vert_background';
}
else
  $edit_email_css = '';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher l'e-mail actuel
$user_id    = $_SESSION['user'];
$getemail   = mysqli_fetch_array(query(" SELECT membres.email FROM membres WHERE membres.id = '$user_id' "));
$user_email = destroy_html($getemail['email']);

/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/reglages.png" alt="Réglages">
    </div>
    <br>

    <div class="body_main smallsize">
      <span class="titre">Changer l'adresse e-mail liéé à votre compte</span><br>
      <br>
      Une adresse e-mail est liée à votre compte sur NoBleme. Elle ne sert que si vous oubliez votre mot de passe, pour avoir un moyen de prouver votre identité et récupérer l'accès à votre compte.<br>
      <br>
      Avoir une adresse e-mail liéé à votre compte est facultatif. Vous pouvez choisir de ne pas en avoir.<br>
      <br>
      <br>
      <span class="soustitre">Votre adresse e-mail :</span>
      <form name="editemail" action="email" method="POST">
        <input class="indiv<?=$edit_email_css?>" name="edit_email" value="<?=$user_email?>"><br>
        <br>
        <div class="indiv align_center">
          <input type="image" src="<?=$chemin?>img/boutons/modifier.png" alt="Modifier" name="edit_email_go">
        </div>
      </form>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';