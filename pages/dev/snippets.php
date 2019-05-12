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
$css  = array('dev');
$js   = array('highlight', 'toggle', 'dev/reference');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <table class="fullgrid titresnoirs margin_auto noresize" style="width:1150px;">
        <thead>
          <tr>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onClick="formattage_tout_fermer();toggle_row('formattage_complet');">
              PAGE COMPLÈTE
            </th>
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
          </tr>
        </thead>
      </table>

      <br>
      <br>

      <div class="margin_auto" id="formattage_complet" style="width:1170px">

        <pre onclick="highlight('pre_complet');" class="monospace spaced vscrollbar" id="pre_complet" style="max-height:300px">&lt;?php /***********************************************************************************************************************************/
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

// Lien court
$shorturl = "raccourcis";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Titre" : "Title";
$page_desc  = "Metadescription";

// CSS &amp; JS
$css  = array('admin');
$js   = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Titre




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "Titre";
  $trad['soustitre']  = "Sous-titre";
  $trad['desc']       = &lt;&lt;&lt;EOD
Description de la page incluant mais ne se limitant pas à un &lt;a href="{$chemin}pages/dev/snippets"&gt;lien&lt;/a&gt;
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?&gt;

      &lt;div class="texte">

        &lt;h1>&lt;?=$trad['titre']?&gt;&lt;/h1>

        &lt;h5>&lt;?=$trad['soustitre']?&gt;&lt;/h5>

        &lt;p>&lt;?=$trad['desc']?&gt;&lt;/p>

      &lt;/div>

&lt;?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';</pre>

        <br>

        <pre onclick="highlight('pre_complet_xhr');" class="monospace spaced vscrollbar" style="max-height:300px;" id="pre_complet_xhr">&lt;?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                             CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE DYNAMIQUEMENT PAR DU XHR                              */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();
guestonly($lang);

/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?></pre>

      </div>




      <div class="margin_auto hidden" id="formattage_header" style="width:1150px">

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

// Lien court
$shorturl = "raccourcis";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Titre" : "Title";
$page_desc  = "Metadescription";

// CSS &amp; JS
$css  = array('admin');
$js   = array('dynamique');</pre>

        <br>

        <pre onclick="highlight('pre_xhr');" class="monospace spaced" id="pre_xhr">&lt;?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                             CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE DYNAMIQUEMENT PAR DU XHR                              */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();
guestonly($lang);</pre>

        <br>

        <pre onclick="highlight('pre_include');" class="monospace spaced" style="overflow-x:scroll;" id="pre_include">&lt;?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('&lt;html&gt;&lt;head&gt;&lt;meta http-equiv="Content-Type" content="text/html; charset=utf-8"&gt;&lt;/head&gt;&lt;body&gt;Vous n\'êtes pas censé accéder à cette page, dehors!&lt;/body&gt;&lt;/html&gt;');</pre>

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
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "Titre";
  $trad['soustitre']  = "Sous-titre";
  $trad['desc']       = &lt;&lt;&lt;EOD
Description de la page incluant mais ne se limitant pas à un &lt;a href="{$chemin}pages/dev/snippets"&gt;lien&lt;/a&gt;
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?&gt;

      &lt;div class="texte">

        &lt;h1>&lt;?=$trad['titre']?&gt;&lt;/h1>

        &lt;h5>&lt;?=$trad['soustitre']?&gt;&lt;/h5>

        &lt;p>&lt;?=$trad['desc']?&gt;&lt;/p>

      &lt;/div>

&lt;?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';
</pre>

      </div>




      <div class="margin_auto hidden" id="formattage_html" style="width:1150px">

        <br>

        <pre onclick="highlight('pre_html');" class="monospace spaced" id="pre_html">/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?&gt;

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

        <pre onclick="highlight('pre_dynamique_header');" class="monospace spaced" id="pre_dynamique_header">/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?&gt;</pre>

        <br>

        <pre onclick="highlight('pre_dynamique_footer');" class="monospace spaced" id="pre_dynamique_footer">&lt;?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }</pre>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';