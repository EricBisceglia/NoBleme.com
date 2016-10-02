<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// On redirige les membres vers l'index, ils ont pas besoin de voir cette page
if(loggedin(0))
  header('Location: ./../../index');

// Menus du header
$header_menu = 'inscription';

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

      <div class="body_main smallsize">

        <span class="titre">
          Bienvenue sur NoBleme !
        </span>
        <br>

        <br>
        <br>
        Vous pouvez désormais vous connecter à votre compte en <a href="<?=$chemin?>pages/user/login">cliquant ici</a>.<br>
        <br>
        <br>
        Bienvenue et bon séjour sur NoBleme,<br>
        Votre administrateur,<br>
        <b>Bad</b>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';