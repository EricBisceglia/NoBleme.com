<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'DroitOubli';

// Identification
$page_nom = "Veut devenir un fantôme";
$page_url = "pages/doc/droit_oubli";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Droit à l'oubli" : "Right to be forgotten";
$page_desc  = "Vous permet de supprimer toutes les données personnelles que NoBleme conserve sur vous";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression des données personnelles

if(isset($_POST['oubli_go']))
{
  // On supprime l'IP des invités
  $oubli_ip = postdata($_SERVER["REMOTE_ADDR"], 'string');
  query(" DELETE FROM invites WHERE invites.ip LIKE '$oubli_ip' ");

  // On supprime les cookies et on ferme la session
  setcookie("nobleme_language", "", time()-630720000, "/");
  setcookie("nobleme_memory", "", time()-630720000, "/");
  session_destroy();

  // On ne charge pas le header
  $temp_lang = ($lang == 'FR') ? 'Toutes vos données personnelles ont été supprimées de NoBleme.com' : 'All your personal data has been deleted from NoBleme.com';
  exit($temp_lang);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "Droit à l'oubli";
  $trad['soustitre']  = "Libérer vos données personnelles";
  $trad['desc']       = <<<EOD
NoBleme conserve quelques données personnelles sur vous, dont vous pouvez avoir la liste complète ainsi que leur utilité au site sur la page « <a class="gras" href="{$chemin}pages/doc/donnees_personnelles">Vos données personnelles</a> ». En respect de la <a class="gras" href="{$chemin}pages/doc/mentions_legales">politique de confidentialité</a> de NoBleme et du <a class="gras" href="https://fr.wikipedia.org/wiki/R%C3%A8glement_g%C3%A9n%C3%A9ral_sur_la_protection_des_donn%C3%A9es">RGPD</a>, vous avez la possibilité de faire valoir votre <a class="gras" href="https://fr.wikipedia.org/wiki/Droit_%C3%A0_l%27oubli">droit à l'oubli</a> et de demander à ce que NoBleme supprime toutes vos données personnelles et tous vos cookies liés au site.
EOD;
  $trad['desc2']      = <<<EOD
Par ailleurs, en concordance avec le droit à l'oubli, si vous désirez que des contenus du site faisant référence à vous soient supprimés, vous pouvez en faire la demande en <a class="gras" href="{$chemin}pages/user/user?id=1">contactant l'administrateur du site</a>.
EOD;

  // Formulaire
  $trad['oubli_go']   = "CLIQUEZ ICI POUR SUPPRIMER TOUTES VOS DONNÉES PERSONNELLES SUR NOBLEME.COM";
  $trad['oubli_ok']   = "Confirmer la suppression de vos données personnelles sur NoBleme.com";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']      = "Right to be forgotten";
  $trad['soustitre']  = "Set your personal data free and preserve your anonymity";
  $trad['desc']       = <<<EOD
NoBleme keeps a bit of personal data on you, of which you can find a complete list on the "<a class="gras" href="{$chemin}pages/doc/donnees_personnelles">Your personal data</a>" page. According to NoBleme's <a class="gras" href="{$chemin}pages/doc/mentions_legales">privacy policy</a> and the <a class="gras" href="https://en.wikipedia.org/wiki/General_Data_Protection_Regulation">GDPR</a>, you have the <a class="gras" href="https://en.wikipedia.org/wiki/Right_to_be_forgotten">right to be forgotten</a>, and can ask that NoBleme delete all the personal data that it keeps on you.
EOD;
  $trad['desc2']      = <<<EOD
As per the right to be forgotten, if you also desire the permanent deletion of some contents of the website which refer to you, you can make a demand for it by contacting the <a class="gras" href="{$chemin}pages/user/user?id=1">website's administrator</a>.
EOD;

  // Formulaire
  $trad['oubli_go']   = "CLICK HERE TO DELETE ALL YOUR PERSONAL DATA ON NOBLEME.COM";
  $trad['oubli_ok']   = "Confirm the deletion of all your personal data on NoBleme.com";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <p><?=$trad['desc']?></p>

        <p><?=$trad['desc2']?></p>

        <br>
        <br>
        <br>

        <form method="POST">
          <fieldset class="align_center">
            <input value="<?=$trad['oubli_go']?>" type="submit" name="oubli_go" onclick="return confirm('<?=$trad['oubli_ok']?>)">
          </fieldset>
        </form>

        <br>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';