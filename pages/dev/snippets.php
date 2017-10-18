<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'Dev';
$header_sidemenu  = 'Snippets';

// Titre et description
$page_titre = "Dev: Formattage";

// Identification
$page_nom = "Administre secrètement le site";

// CSS & JS
$css = array('admin');
$js  = array('highlight','toggle');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <script>
        function formattage_tout_fermer()
        {
          document.getElementById('formattage_header').style.display = "none";
          document.getElementById('formattage_separateurs').style.display = "none";
          document.getElementById('formattage_html').style.display = "none";
          document.getElementById('formattage_dynamique').style.display = "none";
        }
      </script>

      <table class="fullgrid titresnoirs margin_auto noresize" style="width:1150px;">
        <thead>
          <tr>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onClick="formattage_tout_fermer();toggle_row('formattage_header');">
              HEADER
            </th>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onClick="formattage_tout_fermer();toggle_row('formattage_separateurs');">
              SÉPARATEURS
            </th>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onClick="formattage_tout_fermer();toggle_row('formattage_html');">
              HTML
            </th>
            <th class="rowaltc moinsgros pointeur border_all_blank"
                onClick="formattage_tout_fermer();toggle_row('formattage_dynamique');">
              XHR
            </th>
          </tr>
        </thead>
      </table>

      <br>
      <br>

      <div class="margin_auto" id="formattage_header" style="width:1150px">

        <pre onclick="highlight('pre_init');" class="monospace spaced" id="pre_init">&lt;?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
guestonly($lang);

// Menus du header
$header_menu      = '';
$header_sidemenu  = '';

// Identification
$page_nom = "Administre secrètement le site";
$page_url = "pages/nobleme/404";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Titre" : "Title";
$page_desc  = "Metadescription";

// CSS &amp; JS
$css = array('admin');
$js  = array('dynamique');</pre>

        <br>

        <pre onclick="highlight('pre_include');" class="monospace spaced" style="overflow-x:scroll;" id="pre_include">&lt;?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');</pre>

      </div>

      <div class="margin_auto hidden" id="formattage_separateurs" style="width:1150px">

        <pre onclick="highlight('pre_separateur');" class="monospace spaced" id="pre_separateur">///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Titre</pre>

        <br>

        <pre onclick="highlight('pre_postdata');" class="monospace spaced" id="pre_postdata">/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/</pre>

        <br>

        <pre onclick="highlight('pre_paration');" class="monospace spaced" id="pre_paration">/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/</pre>

        <br>

        <pre onclick="highlight('pre_traduction');" class="monospace spaced" id="pre_traduction">/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUTION DU CONTENU MULTILINGUE                                                    */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

$traduction['phrase'] = ($lang == 'FR') ? "Français" : "English";</pre>

      </div>

      <div class="margin_auto hidden" id="formattage_html" style="width:1150px">

        <pre onclick="highlight('pre_html');" class="monospace spaced" id="pre_html">/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      &lt;div class="texte">

        &lt;h1>Titre&lt;/h1>

        &lt;h5>Sous-titre&lt;/h5>

        &lt;p>Contenu&lt;/p>

      &lt;/div>

&lt;?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';</pre>

        <br>

        <pre onclick="highlight('pre_dynamique');" class="monospace spaced" id="pre_dynamique">/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?&gt;

      &lt;div class="texte">

        &lt;h1>Titre&lt;/h1>

        &lt;h5>Sous-titre&lt;/h5>

        &lt;p>Contenu&lt;/p>

      &lt;/div>

&lt;?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }</pre>

      </div>

      <div class="margin_auto hidden" id="formattage_dynamique" style="width:1150px">

        <pre onclick="highlight('pre_dynamique_init');" class="monospace spaced" id="pre_dynamique_init">&lt;?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();
guestonly($lang);</pre>

        <br>

        <pre onclick="highlight('pre_affichage');" class="monospace spaced" id="pre_affichage">/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?></pre>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';