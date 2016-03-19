<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// On redirige les membres vers l'index, ils ont pas besoin de voir cette page
if(loggedin(0))
  header('Location: ./../../index');

// Titre et description
$page_titre = "Bienvenue !";
$page_desc  = "Bienvenue sur NoBleme";

// Identification
$page_nom = "welcome";

// Identification
$page_nom = "user";
$page_id  = "welcome";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
      <br>
      <br>
      <div class="align_center">
        <img src="<?=$chemin?>img/logos/bienvenue.png" alt="Bienvenue sur NoBleme">
      </div>
      <br>
      <br>

      <div class="body_main midsize">

        <span class="titre">
          Bienvenue sur NoBleme !
        </span>
        <br>

        <br>
        Vous pouvez désormais utiliser le formulaire situé en haut à droite de chaque page pour vous connecter, et vous servir de votre compte.<br>
        <br>
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;Bienvenue et bon séjour sur NoBleme,<br>
        &nbsp;&nbsp;&nbsp;&nbsp;Votre administrateur,<br>
        &nbsp;&nbsp;&nbsp;&nbsp;<b>Bad</b>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';