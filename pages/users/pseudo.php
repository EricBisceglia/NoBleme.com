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
$header_sidemenu  = 'ChangerPseudo';

// Identification
$page_nom = "Veut changer d'identité";
$page_url = "pages/users/pseudo";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Changer de pseudonyme" : "Change my nickname";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  $trad['titre']      = "Changer de pseudonyme";
  $trad['desc']       = <<<EOD
Désolé, il n'est pas possible de changer son pseudonyme à volonté sur NoBleme. Permettre aux utilisateurs de changer de pseudonyme lorsqu'ils en ont envie causerait du chaos, permettrait des formes d'abus, rendrait certaines archives compliquées à lire, et ne servirait pas les intérêts de la communauté.<br>
<br>
Toutefois, si vous avez une raison valide de vouloir changer votre pseudonyme (par exemple parce que vous êtes cible de harcèlement sur internet lié à votre identité et désirez en changer), vous pouvez <a class="gras" href="{$chemin}pages/users/pm?user=1">envoyer un message privé à Bad</a>. Si votre justification est considérée acceptable, votre pseudonyme sera changé.
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  $trad['titre']      = "Change my nickname";
  $trad['desc']       = <<<EOD
Sorry, it isn't possible to change your nickname at will on NoBleme. Allowing users to change nicknames whenever they desire would cause chaos, would allow some forms of abuse, would make some archives complicated to read, and wouldn't serve the interests of the community.<br>
<br>
However, if you want to change your nickname for a valid reason (such as being a target of harrassment linked to your online identity) <a class="gras" href="{$chemin}pages/users/pm?user=1">send a private message to Bad</a>. If your justification for wanting to change is considered good enough, your nickname will be changed.
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