<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Menus du header
$header_menu      = 'Dev';
$header_sidemenu  = 'Formattage';

// Titre
$page_titre = "Dev : Formattage";

// Identification
$page_nom = "admin";

// CSS & JS
$css = array('admin');
$js  = array('highlight');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>

    <div class="margin_auto monospace midsize">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros align_center">SECTIONS D'UNE PAGE STANDARD</td>
        </tr>
        <tr>
          <td class="cadre_gris nowrap spaced" onclick="highlight('pre_init');">
            <pre class="maigre indiv" id="pre_init">
&lt;?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
guestonly();

// Menus du header
$header_menu      = '';
$header_submenu   = '';
$header_sidemenu  = '';

// Titre et description
$page_titre = "Titre";
$page_desc  = "Metadescription";

// Identification
$page_nom = "admin";
$page_id  = "admin";

// CSS &amp; JS
$css = array('admin');
$js  = array('dynamique');</pre>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris nowrap spaced" onclick="highlight('pre_postdata');">
            <pre class="maigre indiv" id="pre_postdata">
/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/</pre>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris nowrap spaced" onclick="highlight('pre_hashes');">
            <pre class="maigre indiv" id="pre_hashes">
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Titre</pre>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris nowrap spaced" onclick="highlight('pre_paration');">
            <pre class="maigre indiv" id="pre_paration">
/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/</pre>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris nowrap spaced" onclick="highlight('pre_html');">
            <pre class="maigre indiv" id="pre_html">
/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    &lt;br>
    &lt;br>
    &lt;div class="indiv align_center">
      &lt;img src="&lt;?=$chemin?>img/logos/logo.png" alt="Logo">
    &lt;/div>
    &lt;br>

&lt;?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';</pre>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris nowrap spaced" onclick="highlight('pre_html_xhr');">
            <pre class="maigre indiv" id="pre_html_xhr">
/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!isset($_GET['dynamique'])) { /* Ne pas afficher les données dynamiques dans la page normale */ include './../../inc/header.inc.php'; ?>

    &lt;br>
    &lt;br>
    &lt;div class="indiv align_center">
      &lt;img src="&lt;?=$chemin?>img/logos/logo.png" alt="Logo">
    &lt;/div>
    &lt;br>

&lt;?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                     PLACE AUX DONNÉES DYNAMIQUES                                                      */
/*                                                                                                                                       */
/********************************************************************************************************************************/ } else {

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Titre

}</pre>
          </td>
        </tr>

      </table>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';