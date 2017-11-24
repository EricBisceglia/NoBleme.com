/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                         /js/dev/reference.js                                                          **
**                                       Fonctions liées aux outils de référence de développement                                        **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de fermer tous les onglets de /pages/dev/snippets.php

function formattage_tout_fermer()
{
  document.getElementById('formattage_complet').style.display     = "none";
  document.getElementById('formattage_header').style.display      = "none";
  document.getElementById('formattage_separateurs').style.display = "none";
  document.getElementById('formattage_html').style.display        = "none";
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de fermer tous les onglets de /pages/dev/reference.php

function reference_css_tout_fermer()
{
  document.getElementById('reference_css_couleurs').style.display     = "none";
  document.getElementById('reference_css_texte').style.display        = "none";
  document.getElementById('reference_css_tableaux').style.display     = "none";
  document.getElementById('reference_css_formulaires').style.display  = "none";
  document.getElementById('reference_css_elements').style.display     = "none";
  document.getElementById('reference_css_divers').style.display       = "none";
  document.getElementById('reference_css_scripts').style.display      = "none";
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de fermer tous les onglets de /pages/dev/fonctions.php

function fonctions_tout_fermer()
{
  document.getElementById('liste_fonctions_texte').style.display    = "none";
  document.getElementById('liste_fonctions_dates').style.display    = "none";
  document.getElementById('liste_fonctions_maths').style.display    = "none";
  document.getElementById('liste_fonctions_users').style.display    = "none";
  document.getElementById('liste_fonctions_nobleme').style.display  = "none";
  document.getElementById('liste_fonctions_divers').style.display   = "none";
}