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
$header_sidemenu  = 'SupprimerCompte';

// Identification
$page_nom = "En a fini avec NoBleme";
$page_url = "pages/user/delete";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Supprimer mon compte" : "Delete my account";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  $trad['titre']      = "Supprimer mon compte";
  $trad['desc']       = <<<EOD
Désolé, il n'est pas possible de supprimer son compte à la demande sur NoBleme. Préserver l'intégrité des archives du site est pour nous quelque chose de très important, et permettre aux membres de supprimer des sections entières du passé est quelque chose qui nuirait à l'intégrité de ces archives.<br>
<br>
Toutefois, si vous avez une raison valide de vouloir supprimer votre compte (par exemple parce que vous êtes cible de harcèlement sur internet lié à votre identité), vous pouvez <a class="gras" href="{$chemin}pages/user/pm?user=1">envoyer un message privé à Bad</a>. Si votre justification est considérée acceptable, votre compte sera supprimé.
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  $trad['titre']      = "Delete my account";
  $trad['desc']       = <<<EOD
Sorry, it isn't possible to delete your account at will on NoBleme. It is important to us that the website's archives remain intact. Deleting whole parts of its history would cause incoherences in the archives, which is something we want to avoid if possible.<br>
<br>
However, if you want to delete your account for a valid reason (such as being a target of harrassment linked to your online identity) <a class="gras" href="{$chemin}pages/user/pm?user=1">send a private message to Bad</a> explinaing why you want your account gone. If your justification is considered good enough, your account will be deleted.
EOD;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <p><?=$trad['desc']?></p>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';