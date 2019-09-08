<?php /**********************************************************************************************************************************/
/*                                                                                                                                      */
/*                                                            INITIALISATION                                                            */
/*                                                                                                                                      */
// Quand on fait le truc du contenu dynamique, on s'arrête là ***************************************************************************/
if(isset($_POST['dynamique_test']))
{
  header('Content-type: text/html; charset=utf-8');
  exit('Ce contenu a été fetch en XHR.<br>Voici un nombre aléatoire : '.rand(0,10));
}

// Inclusions
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'Dev';
$header_sidemenu  = 'Reference';

// Titre
$page_titre = "Dev: Référence CSS";

// Identification
$page_nom = "Administre secrètement le site";

// CSS & JS
$css  = array('tabs', 'dev');
$js   = array('onglets', 'toggle', 'highlight', 'dynamique', 'clipboard', 'dev/reference');




/****************************************************************************************************************************************/
/*                                                                                                                                      */
/*                                                        AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                      */
/***********************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <table class="fullgrid titresnoirs margin_auto noresize" style="width:1300px;">
        <thead>
          <tr>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onclick="reference_css_tout_fermer();toggle_row('reference_css_couleurs');">
              COULEURS
            </th>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onclick="reference_css_tout_fermer();toggle_row('reference_css_texte');">
              TEXTE
            </th>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onclick="reference_css_tout_fermer();toggle_row('reference_css_tableaux');">
              TABLEAUX
            </th>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onclick="reference_css_tout_fermer();toggle_row('reference_css_formulaires');">
              FORMULAIRES
            </th>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onclick="reference_css_tout_fermer();toggle_row('reference_css_elements');">
              ELEMENTS
            </th>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onclick="reference_css_tout_fermer();toggle_row('reference_css_divers');">
              DIVERS
            </th>
            <th class="rowaltc moinsgros pointeur border_right_blank"
                onclick="reference_css_tout_fermer();toggle_row('reference_css_scripts');">
              SCRIPTS
            </th>
          </tr>
        </thead>
      </table>

      <br>
      <br>




<!-- #####################################################################################################################################
#                                                                                                                                        #
#                                                                COULEURS                                                                #
#                                                                                                                                        #
##################################################################################################################################### !-->

      <div id="reference_css_couleurs">

        <table class="fullgrid titresnoirs margin_auto" style="width:800px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="5">
                COULEURS
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center gras">
                .blanc
              </td>
              <td class="align_center blanc" style="width:150px">
              </td>
              <td style="width:50px" rowspan="15">
              </td>
              <td class="align_center gras">
                .texte_blanc
              </td>
              <td class="align_center texte_blanc gras noir" style="width:150px">
                Texte
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .grisclair
              </td>
              <td class="align_center grisclair">
              </td>
              <td class="align_center gras">
                .texte_grisclair
              </td>
              <td class="align_center texte_grisclair gras">
                Texte
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .gris
              </td>
              <td class="align_center gris">
              </td>
              <td class="align_center gras">
                .texte_gris
              </td>
              <td class="align_center texte_gris gras">
                Texte
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .grisfonce
              </td>
              <td class="align_center grisfonce">
              </td>
              <td class="align_center gras">
                .texte_grisfonce
              </td>
              <td class="align_center texte_grisfonce gras">
                Texte
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .noir
              </td>
              <td class="align_center noir">
              </td>
              <td class="align_center gras">
                .texte_noir
              </td>
              <td class="align_center texte_noir gras">
                Texte
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .nobleme_clair
              </td>
              <td class="align_center nobleme_clair">
              </td>
              <td class="align_center gras">
                .texte_nobleme_clair
              </td>
              <td class="align_center texte_nobleme_clair gras">
                Texte
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .nobleme_fonce
              </td>
              <td class="align_center nobleme_fonce">
              </td>
              <td class="align_center gras">
                .texte_nobleme_fonce
              </td>
              <td class="align_center texte_nobleme_fonce gras">
                Texte
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .vert_background_clair
              </td>
              <td class="align_center vert_background_clair">
              </td>
              <td colspan="2" class="grisclair">
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .vert_background
              </td>
              <td class="align_center vert_background">
              </td>
              <td class="align_center gras">
                .texte_vert_background
              </td>
              <td class="align_center texte_vert_background gras">
                Texte
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .edited
              </td>
              <td class="align_center edited">
              </td>
              <td class="align_center gras">
                .texte_edited
              </td>
              <td class="align_center texte_edited gras">
                Texte
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .positif
              </td>
              <td class="align_center positif">
              </td>
              <td class="align_center gras">
                .texte_positif
              </td>
              <td class="align_center texte_positif gras">
                Texte
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .neutre
              </td>
              <td class="align_center neutre">
              </td>
              <td class="align_center gras">
                .texte_neutre
              </td>
              <td class="align_center texte_neutre gras">
                Texte
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .negatif, .erreur
              </td>
              <td class="align_center negatif">
              </td>
              <td class="align_center gras">
                .texte_negatif, .texte_erreur
              </td>
              <td class="align_center texte_negatif gras">
                Texte
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .mise_a_jour
              </td>
              <td class="align_center mise_a_jour">
              </td>
              <td class="align_center gras">
                .texte_mise_a_jour
              </td>
              <td class="align_center texte_mise_a_jour gras">
                Texte
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .mise_a_jour_background
              </td>
              <td class="align_center mise_a_jour_background">
              </td>
              <td colspan="2" class="grisclair">
              </td>
            </tr>
          </tbody>
        </table>

      </div>




<!-- #####################################################################################################################################
#                                                                                                                                        #
#                                                                 TEXTE                                                                  #
#                                                                                                                                        #
##################################################################################################################################### !-->

      <div id="reference_css_texte" class="hidden">

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                GESTION DES TEXTES LONGS
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center gras">
                .nowrap
              </td>
              <td class="align_center nowrap">
                Empêche les retours à la ligne si le contenu est trop long comme ici par exemple
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                FORMATTAGE DE TEXTE
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center gras">
                .gras
              </td>
              <td class="align_center gras">
                Texte en gras
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .souligne
              </td>
              <td class="align_center souligne">
                Texte souligné
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .barre
              </td>
              <td class="align_center barre">
                Texte barré
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .maigre
              </td>
              <td class="align_center maigre">
                Texte plus petit
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .moinsgros
              </td>
              <td class="align_center moinsgros">
                Texte plus gros
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .gros
              </td>
              <td class="align_center gros">
                Texte très gros
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .italique
              </td>
              <td class="align_center italique">
                Texte en italique
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .monospace
              </td>
              <td class="align_center monospace">
                Texte monospace
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                NIVEAUX DE TITRES
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center gras">
                &lt;h1&gt;
              </td>
              <td class="align_center">
                <h1>Titre niveau h1</h1>
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                &lt;h2&gt;
              </td>
              <td class="align_center">
                <h2>Titre niveau h2</h2>
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                &lt;h3&gt;
              </td>
              <td class="align_center">
                <h3>Titre niveau h3</h3>
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                &lt;h4&gt;
              </td>
              <td class="align_center">
                <h4>Titre niveau h4</h4>
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                &lt;h5&gt;
              </td>
              <td class="align_center">
                <h5>Titre niveau h5</h5>
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                &lt;h6&gt;
              </td>
              <td class="align_center">
                <h6>Titre niveau h6</h6>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <br>

        <table class="fullgrid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="2">
                CONTENU AJOUTÉ / SUPPRIMÉ DANS UN DIFF
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                &lt;ins&gt;
              </td>
              <td class="gras align_center">
                <ins>Contenu ajouté</ins>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                &lt;del&gt;
              </td>
              <td class="gras align_center">
                <del>Contenu supprimé</del>
              </td>
            </tr>
          </tbody>
        </table>

      </div>




<!-- #####################################################################################################################################
#                                                                                                                                        #
#                                                                TABLEAUX                                                                #
#                                                                                                                                        #
##################################################################################################################################### !-->

      <div id="reference_css_tableaux" class="hidden">

        <hr class="separateur_contenu">

        <table class="margin_auto titresnoirs" style="width:600px">
          <thead>
            <tr>
              <th>
                Colonne
              </th>
              <th>
                Colonne
              </th>
              <th>
                Colonne
              </th>
              <th>
                Colonne
              </th>
            </tr>
          </thead>
          <tbody class="align_center">
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td style="max-width:600px;" colspan="4">
                <pre onclick="highlight('refhtml_defaulttable');" class="align_left monospace spaced scrollbar vscrollbar" id="refhtml_defaulttable" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<table class="titresnoirs">
  <thead>
    <tr>
      <th>
        Colonne
      </th>
      <th>
        Colonne
      </th>
      <th>
        Colonne
      </th>
      <th>
        Colonne
      </th>
    </tr>
  </thead>
  <tbody class="align_center">
    <tr>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
    </tr>
    <tr>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
    </tr>
  </tbody>
</table>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="grid titresnoirs margin_auto" style="width:600px">
          <thead>
            <tr>
              <th>
                &nbsp;
              </th>
              <th>
                Colonne
              </th>
              <th>
                Colonne
              </th>
              <th>
                Colonne
              </th>
            </tr>
          </thead>
          <tbody class="align_center">
            <tr>
              <td class="align_right spaced gras">
                Ligne
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td class="align_right spaced gras">
                Ligne
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td colspan="4" class="blankrow"></td>
            </tr>
            <tr>
              <td class="align_right spaced gras">
                Ligne
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td class="align_right spaced gras">
                Ligne
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td style="max-width:600px;" colspan="4">
                <pre onclick="highlight('refhtml_grid');" class="align_left monospace spaced scrollbar vscrollbar" id="refhtml_grid" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<table class="grid titresnoirs">
  <thead>
    <tr>
      <th>
        &nbsp;
      </th>
      <th>
        Colonne
      </th>
      <th>
        Colonne
      </th>
      <th>
        Colonne
      </th>
    </tr>
  </thead>
  <tbody class="align_center">
    <tr>
      <td class="align_right spaced gras">
        Ligne
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
    </tr>
    <tr>
      <td colspan="4" class="blankrow"></td>
    </tr>
    <tr>
      <td class="align_right spaced gras">
        Ligne
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
    </tr>
  </tbody>
</table>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="grid titresnoirs altc margin_auto" style="width:600px">
          <thead>
            <tr>
              <th>
                Colonne
              </th>
              <th>
                Colonne
              </th>
              <th>
                Colonne
              </th>
              <th>
                Colonne
              </th>
            </tr>
          </thead>
          <tbody class="align_center">
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td style="max-width:600px;" colspan="4">
                <pre onclick="highlight('refhtml_gridaltc');" class="align_left monospace spaced scrollbar vscrollbar" id="refhtml_gridaltc" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<table class="grid titresnoirs altc">
  <thead>
    <tr>
      <th>
        Colonne
      </th>
      <th>
        Colonne
      </th>
      <th>
        Colonne
      </th>
      <th>
        Colonne
      </th>
    </tr>
  </thead>
  <tbody class="align_center">
    <tr>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
    </tr>
    <tr>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
    </tr>
  </tbody>
</table>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="grid titresnoirs hiddenaltc margin_auto" style="width:600px">
          <thead>
            <tr>
              <th>
                TITRE
              </th>
              <th>
                TITRE
              </th>
              <th>
                TITRE
              </th>
              <th>
                TITRE
              </th>
            </tr>
          </thead>
          <tbody class="align_center">
            <tr>
              <td colspan="4" class="noir texte_blanc gras">
                LIGNE DE HEAD AU TBODY
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td colspan="4">
                Ligne sous le contenu (faite pour être masquée)
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td colspan="4">
                Ligne sous le contenu (faite pour être masquée)
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td colspan="4">
                Ligne sous le contenu (faite pour être masquée)
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td colspan="4">
                Ligne sous le contenu (faite pour être masquée)
              </td>
            </tr>
            <tr>
              <td style="max-width:600px;" colspan="4">
                <pre onclick="highlight('refhtml_gridhiddenaltc');" class="align_left monospace spaced scrollbar vscrollbar" id="refhtml_gridhiddenaltc" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<table class="grid titresnoirs hiddenaltc">
  <thead>
    <tr>
      <th>
        TITRE
      </th>
      <th>
        TITRE
      </th>
      <th>
        TITRE
      </th>
      <th>
        TITRE
      </th>
    </tr>
  </thead>
  <tbody class="align_center">
    <tr>
      <td colspan="4" class="noir texte_blanc gras">
        LIGNE DE HEAD AU TBODY
      </td>
    </tr>
    <tr>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
    </tr>
    <tr>
      <td colspan="4">
        Ligne sous le contenu (faite pour être masquée)
      </td>
    </tr>
    <tr>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
    </tr>
    <tr>
      <td colspan="4">
        Ligne sous le contenu (faite pour être masquée)
      </td>
    </tr>
  </tbody>
</table>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="grid titresnoirs hiddenaltc2 margin_auto" style="width:600px">
          <thead>
            <tr>
              <th>
                TITRE
              </th>
              <th>
                TITRE
              </th>
              <th>
                TITRE
              </th>
              <th>
                TITRE
              </th>
            </tr>
          </thead>
          <tbody class="align_center">
            <tr>
              <td colspan="4" class="noir texte_blanc gras">
                LIGNE DE HEAD AU TBODY
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td colspan="4">
                Ligne sous le contenu (faite pour être masquée)
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td colspan="4">
                Ligne sous le contenu (faite pour être masquée)
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td colspan="4">
                Ligne sous le contenu (faite pour être masquée)
              </td>
            </tr>
            <tr>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
              <td>
                Contenu
              </td>
            </tr>
            <tr>
              <td colspan="4">
                Ligne sous le contenu (faite pour être masquée)
              </td>
            </tr>
            <tr>
              <td style="max-width:600px;" colspan="4">
                <pre onclick="highlight('refhtml_gridhiddenaltc2');" class="align_left monospace spaced scrollbar vscrollbar" id="refhtml_gridhiddenaltc2" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<table class="grid titresnoirs hiddenaltc2">
  <thead>
    <tr>
      <th>
        TITRE
      </th>
      <th>
        TITRE
      </th>
      <th>
        TITRE
      </th>
      <th>
        TITRE
      </th>
    </tr>
  </thead>
  <tbody class="align_center">
    <tr>
      <td colspan="4" class="noir texte_blanc gras">
        LIGNE DE HEAD AU TBODY
      </td>
    </tr>
    <tr>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
    </tr>
    <tr>
      <td colspan="4">
        Ligne sous le contenu (faite pour être masquée)
      </td>
    </tr>
    <tr>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
      <td>
        Contenu
      </td>
    </tr>
    <tr>
      <td colspan="4">
        Ligne sous le contenu (faite pour être masquée)
      </td>
    </tr>
  </tbody>
</table>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

      </div>




<!-- #####################################################################################################################################
#                                                                                                                                        #
#                                                              FORMULAIRES                                                               #
#                                                                                                                                        #
##################################################################################################################################### !-->

      <div id="reference_css_formulaires" class="hidden">

        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" style="width:500px">
                FORMULAIRE COMPLET
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <form method="POST">
                  <fieldset>
                    <label for="form_input">Input</label>
                    <input id="form_input" name="form_input" class="indiv" type="text" placeholder="Du texte va ici"><br>
                    <br>
                    <label for="form_dropdown">Menu déroulant</label>
                    <select id="form_dropdown" name="form_dropdown" class="indiv">
                      <option value="1" selected>Option 1</option>
                      <option value="2">Option 2</option>
                      <option value="3">Option 3</option>
                    </select><br>
                    <br>
                    <label for="form_textarea">Textarea</label>
                    <textarea id="form_textarea" name="form_textarea" class="indiv" placeholder="Du texte va ici"></textarea><br>
                    <br>
                    <label>Radio buttons</label>
                    <input id="form_radio_1" name="form_radio_1" type="radio">
                    <label class="label-inline" for="form_radio_1">Option 1</label><br>
                    <input id="form_radio_2" name="form_radio_2" type="radio">
                    <label class="label-inline" for="form_radio_2">Option 2</label><br>
                    <br>
                    <label>Checkboxes</label>
                    <input id="form_checkboxes_1" name="form_checkboxes_1" type="checkbox">
                    <label class="label-inline" for="form_checkboxes_1">Option 1</label><br>
                    <input id="form_checkboxes_2" name="form_checkboxes_2" type="checkbox">
                    <label class="label-inline" for="form_checkboxes_2">Option 2</label><br>
                    <br>
                    <label for="form_pass">Mot de passe</label>
                    <input id="form_pass" name="form_pass" class="indiv" type="password"><br>
                    <br>
                    <div class="float-right">
                      <input id="form_checkbox" name="form_checkbox" type="checkbox">
                      <label class="label-inline" for="form_checkbox">Checkbox à côté du bouton</label>
                    </div>
                    <input value="VALIDER" type="submit" name="form_go">
                  </fieldset>
                </form>
              </td>
            </tr>
            <tr>
              <td style="max-width:500px">
                <pre onclick="highlight('refhtml_formulaire');" class="monospace spaced scrollbar" id="refhtml_formulaire" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<form method="POST">
  <fieldset>
    <label for="form_input">Input</label>
    <input id="form_input" name="form_input" class="indiv" type="text" placeholder="Du texte va ici"><br>
    <br>
    <label for="form_dropdown">Menu déroulant</label>
    <select id="form_dropdown" name="form_dropdown" class="indiv">
      <option value="1">Option 1</option>
      <option value="2">Option 2</option>
      <option value="3">Option 3</option>
    </select><br>
    <br>
    <label for="form_textarea">Textarea</label>
    <textarea id="form_textarea" name="form_textarea" class="indiv" placeholder="Du texte va ici"></textarea><br>
    <br>
    <label>Radio buttons</label>
    <input id="form_radio_1" name="form_radio_1" type="radio">
    <label class="label-inline" for="form_radio_1">Option 1</label><br>
    <input id="form_radio_2" name="form_radio_2" type="radio">
    <label class="label-inline" for="form_radio_2">Option 2</label><br>
    <br>
    <label>Checkboxes</label>
    <input id="form_checkboxes_1" name="form_checkboxes_1" type="checkbox">
    <label class="label-inline" for="form_checkboxes_1">Option 1</label><br>
    <input id="form_checkboxes_2" name="form_checkboxes_2" type="checkbox">
    <label class="label-inline" for="form_checkboxes_2">Option 2</label><br>
    <br>
    <label for="form_pass">Mot de passe</label>
    <input id="form_pass" name="form_pass" class="indiv" type="password"><br>
    <br>
    <div class="float-right">
      <input id="form_checkbox" name="form_checkbox" type="checkbox">
      <label class="label-inline" for="form_checkbox">Checkbox à côté du bouton</label>
    </div>
    <input value="VALIDER" type="submit" name="form_go">
  </fieldset>
</form>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" style="width:500px" colspan="4">
                FORMULAIRE DE RECHERCHE DANS UN TABLEAU
              </th>
            </tr>
            <tr>
              <th>
                <input class="intable" size="1">
              </th>
              <th>
                <select class="table_search intable">
                  <option value="1">Oui</option>
                  <option value="0">Non</option>
                </select>
              </th>
              <th>
                <input class="intable" size="1">
              </th>
              <th>
                <select class="table_search intable">
                  <option value="1">Option 1</option>
                  <option value="2">Option 2</option>
                </select>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="max-width:500px" colspan="4">
                <pre onclick="highlight('refhtml_select');" class="monospace spaced vscrollbar" id="refhtml_select" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<tr>
  <th>
    <input class="intable" size="1">
  </th>
  <th>
    <select class="table_search intable">
      <option value="1">Oui</option>
      <option value="0">Non</option>
    </select>
  </th>
</tr>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" style="width:500px">
                MENU DÉROULANT AVEC AUTO-SUBMIT
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                <select name="oui_ou_non">
                  <option value="1">Submit en changeant d'option&nbsp;</option>
                  <option value="0">Désactivé pour l'exemple :)</option>
                </select>
              </td>
            </tr>
            <tr>
              <td style="max-width:500px">
                <pre onclick="highlight('refhtml_autosubmit');" class="monospace spaced scrollbar" id="refhtml_autosubmit" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<form method="POST">
  <select name="oui_ou_non" style="width:175px" onChange="this.form.submit()">
    <option value="1">Oui&nbsp;</option>
    <option value="0">Non</option>
  </select>
</form>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

      </div>




<!-- #####################################################################################################################################
#                                                                                                                                        #
#                                                               ELEMENTS                                                                 #
#                                                                                                                                        #
##################################################################################################################################### !-->

      <div id="reference_css_elements" class="hidden">

        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" style="width:500px">
                SÉPARATEUR HORIZONTAL
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <pre onclick="highlight('refhtml_hr');" class="monospace spaced" id="refhtml_hr" style="margin-bottom:0"><?php
                  echo(htmlspecialchars('<hr class="separateur_contenu">'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" style="width:500px">
                FLEXBOXES
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="flexcontainer grisclair">
                <div class="grisfonce texte_blanc align_center" style="flex:1;margin:5px">
                  Flexbox
                </div>
                <div class="grisfonce texte_blanc align_center" style="flex:1;margin:5px">
                  Flexbox
                </div>
                <div class="grisfonce texte_blanc align_center" style="flex:1;margin:5px">
                  Flexbox
                </div>
                <div class="grisfonce texte_blanc align_center" style="flex:1;margin:5px">
                  Flexbox
                </div>
                <div class="grisfonce texte_blanc align_center" style="flex:1;margin:5px">
                  Flexbox
                </div>
              </td>
            </tr>
            <tr>
              <td class="flexcontainer grisclair">
                <div class="grisfonce texte_blanc align_center" style="flex:3;margin:5px">
                  Flexbox
                </div>
                <div class="grisfonce texte_blanc align_center" style="flex:2;margin:5px">
                  Flexbox
                </div>
                <div class="grisfonce texte_blanc align_center" style="flex:1;margin:5px">
                  Flexbox
                </div>
              </td>
            </tr>
            <tr>
              <td style="max-width:500px">
                <pre onclick="highlight('refhtml_flexbox');" class="monospace spaced vscrollbar" id="refhtml_flexbox" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<div class="flexcontainer grisclair">
  <div class="grisfonce texte_blanc align_center" style="flex:1;margin:5px">
    Flexbox
  </div>
  <div class="grisfonce texte_blanc align_center" style="flex:1;margin:5px">
    Flexbox
  </div>
  <div class="grisfonce texte_blanc align_center" style="flex:1;margin:5px">
    Flexbox
  </div>
</div>
<div class="flexcontainer grisclair">
  <div class="grisfonce texte_blanc align_center" style="flex:2;margin:5px">
    Flexbox
  </div>
  <div class="grisfonce texte_blanc align_center" style="flex:1;margin:5px">
    Flexbox
  </div>
</div>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" style="width:500px">
                SECTION LIMITÉE EN LARGEUR ET HAUTEUR
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="max-width:500px">
                <pre onclick="highlight('refhtml_scroll');" class="monospace spaced scrollbar vscrollbar" id="refhtml_scroll" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<td style="max-width:200px;max-height:100px;" class="nowrap scrollbar vscrollbar">
  Le contenu de cette ligne est limité en largeur et scrolle horizontalement
  Le contenu de cette section est limité en hauteur et scrolle verticalement
  .scrollbar est la propriété horizontale
  .vscrollbar est la propriété verticale
</td>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" style="width:500px">
                BOUTONS
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center vspaced">
                <button class="button">Bouton</button>
                <button class="button button-outline">Bouton</button>
                <button class="button button-clear">Bouton</button>
                <br>
                <input class="button" value="Submit" type="submit">
                <input class="button button-outline" value="Submit" type="submit">
                <input class="button button-clear" value="Submit" type="submit">
              </td>
            </tr>
            <tr>
              <td style="max-width:500px">
                <pre onclick="highlight('refhtml_button');" class="monospace spaced scrollbar vscrollbar" id="refhtml_button" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<button class="button">Bouton</button>
<button class="button button-outline">Bouton</button>
<button class="button button-clear">Bouton</button>
<input class="button" value="Submit" type="submit">
<input class="button button-outline" value="Submit" type="submit">
<input class="button button-clear" value="Submit" type="submit">'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" style="width:500px">
                INFOBULLE
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tooltip-container align_center gras texte_nobleme_fonce">
                Passez-moi la souris dessus
                <span class="tooltip">
                  Je suis une infobulle<br>
                  Multiligne si nécessaire
                </span>
              </td>
            </tr>
            <tr>
              <td style="max-width:500px">
                <pre onclick="highlight('refhtml_infobulle');" class="monospace spaced vscrollbar" id="refhtml_infobulle" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<div class="tooltip-container">
  Passez-moi la souris dessus
  <span class="tooltip">
    Je suis une infobulle<br>
    Multiligne si nécessaire
  </span>
</div>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" style="width:500px">
                ONGLETS
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="max-width:500px">
                <ul class="onglet">
                  <li>
                    <a id="onglet1_onglet" class="bouton_onglet onglet_actif" onclick="ouvrirOnglet(event, 'onglet1')">TITRE</a>
                  </li>
                  <li>
                    <a id="onglet2_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'onglet2')">TITRE</a>
                  </li>
                  <li>
                    <a id="onglet3_onglet" class="bouton_onglet onglet_blink" onclick="ouvrirOnglet(event, 'onglet3')">TITRE</a>
                  </li>
                </ul>
                <div id="onglet1" class="contenu_onglet">
                  Contenu
                </div>
                <div id="onglet2" class="hidden contenu_onglet">
                  Contenu 2
                </div>
                <div id="onglet3" class="hidden contenu_onglet">
                  Contenu 3
                </div>
              </td>
            </tr>
            <tr>
              <td style="max-width:500px">
                <pre onclick="highlight('refhtml_onglets');" class="monospace spaced vscrollbar" id="refhtml_onglets" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<ul class="onglet">
  <li>
    <a id="onglet1_onglet" class="bouton_onglet onglet_actif" onclick="ouvrirOnglet(event, \'onglet1\')">TITRE</a>
  </li>
  <li>
    <a id="onglet2_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, \'onglet2\')">TITRE</a>
  </li>
  <li>
    <a id="onglet3_onglet" class="bouton_onglet onglet_blink" onclick="ouvrirOnglet(event, \'onglet3\')">TITRE</a>
  </li>
</ul>
<div id="onglet1" class="contenu_onglet">
  Contenu
</div>
<div id="onglet2" class="hidden contenu_onglet">
  Contenu 2
</div>
<div id="onglet3" class="hidden contenu_onglet">
  Contenu 3
</div>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" style="width:500px">
                LISTE
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <ul>
                  <li>Premier élément d'une liste</li>
                  <li>Second élément d'une liste</li>
                  <li>Troisième élément d'une liste</li>
                  <li>Quatrième élément d'une liste</li>
                </ul>
              </td>
            </tr>
            <tr>
              <td style="max-width:500px">
                <pre onclick="highlight('refhtml_liste');" class="monospace spaced" id="refhtml_liste" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<ul>
  <li>Premier élément d\'une liste</li>
  <li>Second élément d\'une liste</li>
</ul>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" style="width:500px">
                CITATION
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <blockquote>Ceci est une citation</blockquote>
              </td>
            </tr>
            <tr>
              <td style="max-width:500px">
                <pre onclick="highlight('refhtml_blockquote');" class="monospace spaced" id="refhtml_blockquote" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<blockquote>Ceci est une citation</blockquote>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" style="width:500px">
                FORMATTAGE PRÉSERVÉ
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <pre><code>Indentation
          Préservée
                  Ainsi que les
      Retours à la ligne</code></pre>
              </td>
            </tr>
            <tr>
              <td style="max-width:500px">
                <pre onclick="highlight('refhtml_pre');" class="monospace spaced" id="refhtml_pre" style="margin-bottom:0;max-height:80px;"><?php
                  echo(htmlspecialchars('<pre><code>Indentation
    Préservée
            Ainsi que les
Retours à la ligne</code></pre>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="indiv fullgrid titresnoirs">
          <thead>
            <tr>
              <th class="rowaltc moinsgros">
                TAILLES D'ÉLÉMENTS
              </th>
            </tr>
          </thead>
          <tbody class="align_center moinsgros gras texte_blanc">
            <tr>
              <td>
                <br>
                <div class="microtexte grisfonce">
                  .microtexte
                </div>
                <br>
                <div class="minitexte grisfonce">
                  .minitexte
                </div>
                <br>
                <div class="minitexte2 grisfonce">
                  .minitexte2
                </div>
                <br>
                <div class="texte grisfonce">
                  .texte
                </div>
                <br>
                <div class="texte2 grisfonce">
                  .texte2
                </div>
                <br>
                <div class="texte3 grisfonce">
                  .texte3
                </div>
                <br>
                <div class="tableau grisfonce">
                  .tableau
                </div>
                <br>
                <div class="tableau2 grisfonce">
                  .tableau2
                </div>
              </td>
            </tr>
          </tbody>
        </table>


      </div>




<!-- #####################################################################################################################################
#                                                                                                                                        #
#                                                                DIVERS                                                                  #
#                                                                                                                                        #
##################################################################################################################################### !-->

      <div id="reference_css_divers" class="hidden">

        <table class="fullgrid titresnoirs" style="width:1000px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc moinsgros" colspan="3" style="width:1000px">
                POSITION DU CONTENU
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center gras">
                .align_justify
              </td>
              <td class="align_justify">
                Le contenu de cette section est aligné de façon justifiée, avec des rivières typographiques parfois désagréables
              </td>
              <td class="align_center">
                <pre onclick="highlight('refhtml_textjustify');" class="monospace spaced" id="refhtml_textjustify" style="margin-bottom:0"><?php
                  echo(htmlspecialchars('<div class="align_justify">'))
                ?></pre>
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .align_left<br>
                .align_center<br>
                .align_right
              </td>
              <td>
                <div class="align_left">
                  Contenu à gauche
                </div>
                <div class="align_center">
                  Contenu centré
                </div>
                <div class="align_right">
                  Contenu à droite
                </div>
              </td>
              <td class="align_center">
                <pre onclick="highlight('refhtml_textalign');" class="monospace spaced" id="refhtml_textalign" style="margin-bottom:0"><?php
                  echo(htmlspecialchars('<div class="align_center">'))
                ?></pre>
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .valign_top<br>
                .valign_middle<br>
                .valign_bottom
              </td>
              <td style="height:100%" class="align_center">
                <div style="height:100%" class="valign_top">
                  Contenu en haut
                </div>
                <div style="height:100%" class="valign_middle">
                  Contenu au milieu
                </div>
                <div style="height:100%" class="valign_bottom">
                  Contenu en bas
                </div>
              </td>
              <td class="align_center">
                <pre onclick="highlight('refhtml_valign');" class="monospace spaced" id="refhtml_valign" style="margin-bottom:0"><?php
                  echo(htmlspecialchars('<td class="valign_middle">'))
                ?></pre>
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .valign_table
              </td>
              <td style="height:100%" class="align_center">
                <div style="height:100%" class="valign_table">
                  Contenu centré verticalement dans un td
                </div>
              </td>
              <td class="align_center">
                <pre onclick="highlight('refhtml_valign_table');" class="monospace spaced" id="refhtml_valign_table" style="margin-bottom:0"><?php
                  echo(htmlspecialchars('<td class="valign_table">'))
                ?></pre>
              </td>
            </tr>
            <tr>
              <td colspan="3" class="grisclair">
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .margin_auto
              </td>
              <td class="align_center">
                <div class="margin_auto grisclair" style="width:280px">
                  Centre un élément de largeur fixe
                </div>
              </td>
              <td class="align_center">
                <pre onclick="highlight('refhtml_marginauto');" class="monospace spaced" id="refhtml_marginauto" style="margin-bottom:0"><?php
                  echo(htmlspecialchars('<div class="margin_auto" style="width:1337px">'))
                ?></pre>
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .indiv, .intable
              </td>
              <td class="align_center">
                <div class="intable grisclair">
                  Prend 100% de la largeur disponible
                </div>
              </td>
              <td class="align_center">
                <pre onclick="highlight('refhtml_indiv');" class="monospace spaced" id="refhtml_indiv" style="margin-bottom:0"><?php
                  echo(htmlspecialchars('<table class="indiv">'))
                ?></pre>
              </td>
            </tr>
            <tr>
              <td class="rowaltc moinsgros align_center texte_noir gras" colspan="3" style="width:1000px">
                MARGES ET PADDINGS
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .alinea
              </td>
              <td class="align_center">
                <div class="align_left alinea">
                  Marge à gauche d'un élément
                </div>
              </td>
              <td class="align_center">
                <pre onclick="highlight('refhtml_alinea');" class="monospace spaced" id="refhtml_alinea" style="margin-bottom:0"><?php
                  echo(htmlspecialchars('<span class="alinea">'))
                ?></pre>
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .spaced
              </td>
              <td class="align_center">
                <span class="spaced grisclair">
                  Léger padding à gauche et à droite
                </span>
              </td>
              <td class="align_center">
                <pre onclick="highlight('refhtml_spaced');" class="monospace spaced" id="refhtml_spaced" style="margin-bottom:0"><?php
                  echo(htmlspecialchars('<td class="spaced">'))
                ?></pre>
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .vspaced
              </td>
              <td class="align_center">
                <span class="vspaced grisclair">
                  Léger padding en haut et en bas
                </span>
              </td>
              <td class="align_center">
                <pre onclick="highlight('refhtml_vspaced');" class="monospace spaced" id="refhtml_vspaced" style="margin-bottom:0"><?php
                  echo(htmlspecialchars('<td class="vspaced">'))
                ?></pre>
              </td>
            </tr>
            <tr>
              <td class="rowaltc moinsgros align_center texte_noir gras" colspan="3" style="width:1000px">
                TAGS DIVERS
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .pointeur
              </td>
              <td class="align_center pointeur">
                Un pointeur apparait en hover
              </td>
              <td class="align_center">
                <pre onclick="highlight('refhtml_pointeur');" class="monospace spaced" id="refhtml_pointeur" style="margin-bottom:0"><?php
                  echo(htmlspecialchars('<div class="pointeur">'))
                ?></pre>
              </td>
            </tr>
            <tr>
              <td colspan="3" class="grisclair">
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .hidden
              </td>
              <td class="align_center">
                Contenu invisible
              </td>
              <td class="align_center">
                <pre onclick="highlight('refhtml_hidden');" class="monospace spaced" id="refhtml_hidden" style="margin-bottom:0"><?php
                  echo(htmlspecialchars('<div class="hidden">'))
                ?></pre>
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .discret
              </td>
              <td class="align_center discret">
                Contenu sans bordures
              </td>
              <td class="align_center">
                <pre onclick="highlight('refhtml_discret');" class="monospace spaced" id="refhtml_discret" style="margin-bottom:0"><?php
                  echo(htmlspecialchars('<div class="discret">'))
                ?></pre>
              </td>
            </tr>
            <tr>
              <td class="rowaltc moinsgros align_center texte_noir gras" colspan="3" style="width:1000px">
                CLEARFIX
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .clearfix
              </td>
              <td class="discret clearfix" rowspan="3">
                Texte Texte Texte Texte Texte Texte Texte Texte
                <button class="float-left">Gauche</button>
                <button class="float-right">Droite</button>
                Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte
              </td>
              <td rowspan="3">
                <pre onclick="highlight('refhtml_clearfix');" class="monospace spaced scrollbar vscrollbar" id="refhtml_clearfix" style="margin-bottom:0;max-width:460px;max-height:100px;"><?php
                  echo(htmlspecialchars('<div class="clearfix">
  Texte Texte Texte Texte Texte Texte Texte Texte
  <button class="float-left">Gauche</button>
  <button class="float-right">Droite</button>
  Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte Texte
</div>'))
                ?></pre>
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .float-left
              </td>
            </tr>
            <tr>
              <td class="align_center gras">
                .float-right
              </td>
            </tr>
          </tbody>
        </table>

      </div>




<!-- #####################################################################################################################################
#                                                                                                                                        #
#                                                                SCRIPTS                                                                 #
#                                                                                                                                        #
##################################################################################################################################### !-->

      <div id="reference_css_scripts" class="hidden">

        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc" style="width:500px">
                <span class="moinsgros">CHARGER DU CONTENU DYNAMIQUEMENT</span><br>
                dynamique.js
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center pointeur gras texte_nobleme_fonce"
                  onclick="dynamique('<?=$chemin?>', 'reference', 'exemple_dynamique', 'dynamique_test=0');">
                Cliquez moi
              </td>
            </tr>
            <tr>
              <td class="align_center gras" id="exemple_dynamique">
                Le contenu dynamique apparaitra ici
              </td>
            </tr>
            <tr>
              <td>
                <pre onclick="highlight('refhtml_dynamique');" class="monospace spaced scrollbar" id="refhtml_dynamique" style="max-width:500px;max-height:80px;margin-bottom:0"><?php
                  echo(htmlspecialchars('<div class="align_center pointeur gras texte_nobleme_fonce" onclick="dynamique(\'<?=$chemin?>\',\'ma_page.php\',\'mon_id\',\'postdata\');">
  Cliquez moi
</div>
<div class="align_center gras" id="mon_id">
  Le contenu dynamique apparaitra ici
</div>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc" style="width:500px">
                <span class="moinsgros">AFFICHER/MASQUER UNE SECTION</span><br>
                toggle.js
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                <div class="pointeur gras texte_nobleme_fonce" onclick="toggle_row('exemple_togglejs');">
                  Cliquez moi (par id)
                </div>
                <div class="gras noir texte_negatif hidden" id="exemple_togglejs">
                  Cette section de contenu apparait et disparait
                </div>
              </td>
            </tr>
            <tr>
              <td class="align_center">
                <div class="pointeur gras texte_nobleme_fonce" onclick="toggle_class('exemple_togglejs');">
                  Cliquez moi (par classe)
                </div>
                <div class="gras noir texte_positif hidden exemple_togglejs">
                  Ces sections de contenu apparaissent et disparaissent
                </div>
                <div class="gras grisfonce texte_neutre hidden exemple_togglejs">
                  Ces sections de contenu uniques apparaissent et disparaissent
                </div>
                <div class="gras noir texte_blanc hidden exemple_togglejs">
                  Ces sections de contenu différentes apparaissent et disparaissent
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <pre onclick="highlight('refhtml_toggle');" class="monospace spaced scrollbar" id="refhtml_toggle" style="max-width:500px;max-height:80px;margin-bottom:0"><?php
                  echo(htmlspecialchars('<div class="pointeur gras texte_nobleme_fonce" onclick="toggle_row(\'exemple_togglejs\');">
  Cliquez moi (par id)
</div>
<div class="gras noir texte_negatif hidden" id="exemple_togglejs">
  Cette section de contenu apparait et disparait
</div>
<div class="pointeur gras texte_nobleme_fonce" onclick="toggle_class(\'exemple_togglejs\');">
  Cliquez moi (par classe)
</div>
<div class="gras noir texte_positif hidden exemple_togglejs">
  Ces sections de contenu apparaissent et disparaissent
</div>
<div class="gras grisfonce texte_neutre hidden exemple_togglejs">
  Ces sections de contenu uniques apparaissent et disparaissent
</div>
<div class="gras noir texte_blanc hidden exemple_togglejs">
  Ces sections de contenu différentes apparaissent et disparaissent
</div>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <hr class="separateur_contenu">
        <br>

        <table class="fullgrid titresnoirs" style="width:500px;margin:auto;">
          <thead>
            <tr>
              <th class="rowaltc" style="width:500px">
                <span class="moinsgros">METTRE DU CONTENU DANS LE PRESSE PAPIERS</span><br>
                clipboard.js
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align_center">
                <div class="pointeur gras texte_nobleme_fonce" onclick="to_clipboard('Du contenu dans le presse papiers');">
                  Cliquez moi pour remplir le presse papiers
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <pre onclick="highlight('refhtml_clipboard');" class="monospace spaced scrollbar" id="refhtml_clipboard" style="max-width:500px;max-height:80px;margin-bottom:0"><?php
                  echo(htmlspecialchars('<div onclick="to_clipboard(\'Ceci va dans le presse papiers\')">
  Cliquer ici
</div>'))
                ?></pre>
              </td>
            </tr>
          </tbody>
        </table>

      </div>

<?php /**********************************************************************************************************************************/
/*                                                                                                                                      */
/*                                                             FIN DU HTML                                                              */
/*                                                                                                                                      */
/**************************************************************************************************/ include './../../inc/footer.inc.php';