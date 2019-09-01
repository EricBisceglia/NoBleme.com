/******************************************************************************************************************************************
**                                                                                                                                       **
**                           Fonction permettant d'avoir une prévisualisation en temps réel du contenu des IRL                           **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de prévisualiser en direct le contenu des IRL pendant qu'on les modifie
// chemin est le chemin jusqu'à la racine du site

function previsualiser_irl(chemin)
{
  // On affiche les encadrés de prévisualisation au cas où il seraient encore masqués
  document.getElementById('meetups_preview_fr_container').style.display = 'block';
  document.getElementById('meetups_preview_en_container').style.display = 'block';

  // Et on génère les prévisualisations en XHR
  dynamique(chemin, './../user/xhr/previsualiser_bbcodes.php', 'meetups_preview_fr',
            'message=' + dynamique_prepare('irl_edit_details_fr'), 1 );
  dynamique(chemin, './../user/xhr/previsualiser_bbcodes.php', 'meetups_preview_en',
            'message=' + dynamique_prepare('irl_edit_details_en'), 1 );
}