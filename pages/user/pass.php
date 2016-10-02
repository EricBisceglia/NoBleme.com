<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly();

// Menus du header
$header_menu      = 'compte';
$header_submenu   = 'reglages';
$header_sidemenu  = 'pass';

// Titre et description
$page_titre = "Changer de mot de passe";
$page_desc  = "Changer le mot de passe de votre compte sur NoBleme";

// Identification
$page_nom = "user";
$page_id  = "pass";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si on change le mot de passe
$pass_actuel_erreur   = '';
$nouveau_pass_erreur  = '';
$nouveau_pass_regles  = '';
$changement_pass      = 0;
if(isset($_POST['edit_pass_go_x']))
{
  // On assainit le postdata
  $pass_actuel_check  = postdata($_POST['pass_actuel']);
  $nouveau_pass_1     = $_POST['nouveau_pass_1'];
  $nouveau_pass_2     = $_POST['nouveau_pass_2'];

  // On va chercher le pass actuel
  $user_id      = $_SESSION['user'];
  $qpass_actuel = mysqli_fetch_array(query(" SELECT membres.pass FROM membres WHERE membres.id = '$user_id' "));
  $pass_actuel  = $qpass_actuel['pass'];

  // On continue que si le pass est bon
  if($pass_actuel != salage($pass_actuel_check))
    $pass_actuel_erreur = ' erreur';
  else
  {
    // On s'assure que les deux nouveaux pass soient les mêmes
    if($nouveau_pass_1 != $nouveau_pass_2 || $nouveau_pass_1 == '' || $nouveau_pass_2 == '')
      $nouveau_pass_erreur = ' erreur';
    else
    {
      // On check la longueur du nouveau pass
      if(strlen($nouveau_pass_1) < 5)
        $nouveau_pass_regles = ' class="texte_blanc erreur gras" ';
      else
      {
        // On peut changer le pass si tout est bon
        $changement_pass = 1;
        $nouveau_pass = postdata(salage($nouveau_pass_1));
        query(" UPDATE membres SET membres.pass = '$nouveau_pass' WHERE membres.id = '$user_id' ");
      }
    }
  }
}





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
      <?php if(!$changement_pass) { ?>
      <span class="titre">Changer le mot de passe de votre compte</span><br>
      <br>
      Pour changer votre mot de passe, vous devez d'abord rentrer votre mot de passe, pour prouver que vous êtes bien le propriétaire du compte et non pas un petit malin qui utilise l'ordinateur d'un ami.<br>
      <br>
      Ensuite, vous devrez rentrer deux fois le nouveau mot de passe, pour être sûr de ne pas faire d'erreur.<br>
      <span<?=$nouveau_pass_regles?>>Votre nouveau mot de passe doit avoir une longueur d'au moins de 5 caractères.</span><br>
      <br>
      Le changement de mot de passe est définitif, ne faites pas n'importe quoi.<br>
      <br>
      <br>
      <form name="editpass" action="pass" method="POST">
        <span class="moinsgros gras alinea">Entrez votre mot de passe actuel :</span>
        <input type="password" class="indiv<?=$pass_actuel_erreur?>" name="pass_actuel"><br>
        <br>
        <span class="moinsgros gras alinea">Entrez deux fois votre nouveau mot de passe :</span>
        <input type="password" class="indiv<?=$nouveau_pass_erreur?>" name="nouveau_pass_1"><br>
        <input type="password" class="indiv<?=$nouveau_pass_erreur?>" name="nouveau_pass_2"><br>
        <br>
        <div class="indiv align_center">
          <input type="image" src="<?=$chemin?>img/boutons/modifier.png" alt="Modifier" name="edit_pass_go">
        </div>
      </form>
      <?php } else { ?>
      <div class="indiv align_center vert_background moinsgros gras"><br>Votre mot de passe a été changé !<br><br></div>
      <?php } ?>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';