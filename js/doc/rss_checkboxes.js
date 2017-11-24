/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                      /js/user/rss_checkboxes.js                                                       **
**                           Fonctions permettant de cocher des flux RSS spécifiques selon ce qui est demandé                            **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonctions de sélection de flux RSS

function rss_check_boxes()
{
  // On va chercher le type de sélection
  type = document.getElementById('flux_preset').value;

  // Rencontres IRL
  if(type == 'all' || type == 'irl')
    document.getElementById("flux_irl").checked = true;
  else
    document.getElementById("flux_irl").checked = false;

  // Miscellanées
  if(type == 'all' || type == 'misc')
    document.getElementById("flux_misc").checked = true;
  else
    document.getElementById("flux_misc").checked = false;

  // Développement
  if(type == 'all' || type == 'dev')
  {
    document.getElementById("flux_devblog").checked = true;
    document.getElementById("flux_todo").checked = true;
    document.getElementById("flux_todo_fini").checked = true;
  }
  else
  {
    document.getElementById("flux_devblog").checked = false;
    document.getElementById("flux_todo").checked = false;
    document.getElementById("flux_todo_fini").checked = false;
  }
}