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
$header_sidemenu  = 'ReglagesNSFW';

// Identification
$page_nom = "Est confortable au boulot";
$page_url = "pages/users/nsfw";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Options de vulgarité" : "Adult content options";
$page_desc  = "Réglage des permissions liées au contenu sensible";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Mise à jour du niveau de NSFW

if(isset($_POST['profil_nsfw_go']))
{
  // Assainissement du postdata
  $membre_nsfw = postdata_vide('profil_nsfw', 'int', 0);

  // Mise à jour de la valeur
  $membre_id = postdata($_SESSION['user'], 'int', 0);
  query(" UPDATE  membres
          SET     membres.voir_nsfw = '$membre_nsfw'
          WHERE   membres.id        = '$membre_id' ");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Niveau de NSFW actuel du membre

// On récupère l'ID du membre
$membre_id = postdata($_SESSION['user'], 'int', 0);

// On va récupérer le niveau actuel du membre
$dnsfw = mysqli_fetch_array(query(" SELECT  membres.voir_nsfw AS 'm_nsfw'
                                    FROM    membres
                                    WHERE   membres.id = '$membre_id' "));

// On prépare le menu déroulant pour l'affichage
$select_nsfw_0  = (!$dnsfw['m_nsfw'])     ? ' selected' : '';
$select_nsfw_1  = ($dnsfw['m_nsfw'] == 1) ? ' selected' : '';
$select_nsfw_2  = ($dnsfw['m_nsfw'] == 2) ? ' selected' : '';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']        = "Options de vulgarité";
  $trad['soustitre']    = "Parce que vous ne voulez pas rester dans le flou";
  $trad['desc']         = <<<EOD
<p>
  Certaines pages contiennent du contenu vulgaire ou sensible, comme par exemple les <a class="gras" href="{$chemin}pages/quotes/index">miscellanées</a> ou l'<a class="gras" href="{$chemin}pages/nbdb/web">encyclopédie de la culture Internet</a>. Par défaut, les contenus qu'il est préférable de ne pas consulter sur un lieu de travail apparaissent floutés.
</p>
<p>
  Les options ci-dessous vous permettent de désactiver de façon permanent le floutage afin que les contenus sensibles soient affichés par défaut. Vous pouvez choisir de désactiver ce floutage soit uniquement pour les contenus écrits, soit pour les contenus écrits et les contenus visuels (images, vidéos).
</p>
EOD;

  // Formulaire
  $trad['nsfw_niveau']  = "Niveau de vulgarité désiré";
  $trad['nsfw_niv0']    = "Flouter tous les contenus";
  $trad['nsfw_niv1']    = "Révéler les textes, flouter les contenus visuels";
  $trad['nsfw_niv2']    = "Tout révéler par défaut, ne rien flouter";
  $trad['nsfw_go']      = "CHANGER LE NIVEAU DE VULGARITÉ";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']        = "Adult content options";
  $trad['soustitre']    = "Who wants to browse a blurry website anyway";
  $trad['desc']         = <<<EOD
<p>
  Some pages contain vulgar or sensitive content, such as the <a class="gras" href="{$chemin}pages/quotes/index">miscellanea</a> or the <a class="gras" href="{$chemin}pages/nbdb/web">encyclopedia of Internet culture</a>. By default, contents that you'd rather not be caught browsing a work appear blurry.
</p>
<p>
  The options below allow you to permanently deactivate the blurring of sensitive content. You can choose to turn it off only for written content, or for all types of content including media (images, videos).
</p>
EOD;

  // Formulaire
  $trad['nsfw_niveau']  = "Amount of blurring desired";
  $trad['nsfw_niv0']    = "Blur all the sensitive content";
  $trad['nsfw_niv1']    = "Reveal all texts but blur all media";
  $trad['nsfw_niv2']    = "Blur nothing, reveal everything by default";
  $trad['nsfw_go']      = "SET ADULT FILTER LEVEL";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <?=$trad['desc']?>

        <br>
        <br>

        <form method="POST">
          <fieldset>

            <label for="profil_nsfw"><?=$trad['nsfw_niveau']?></label>
            <select id="profil_nsfw" name="profil_nsfw" class="indiv">
              <option value="0"<?=$select_nsfw_0?>><?=$trad['nsfw_niv0']?></option>
              <option value="1"<?=$select_nsfw_1?>><?=$trad['nsfw_niv1']?></option>
              <option value="2"<?=$select_nsfw_2?>><?=$trad['nsfw_niv2']?></option>
            </select><br>
            <br>

            <input value="<?=$trad['nsfw_go']?>" type="submit" name="profil_nsfw_go">

          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';