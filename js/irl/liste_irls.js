/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                         /js/irl/liste_irls.js                                                         **
**                                             Fonctions liées au tableau des rencontres IRL                                             **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de faire des tris et des recherches dans le tableau des IRL
//
// chemin             est le chemin jusqu'à la racine du site
// tri    (optionnel) est le tri à appliquer au tableau

function irls_tableau(chemin, tri)
{
  // On définit le nouvel ordre de tri
  if(typeof(tri) !== 'undefined')
    document.getElementById('irl_tri').value = tri;

  // On prépare le postdata
  postdata  = "irl_tri="                  + dynamique_prepare('irl_tri');
  postdata += "&irl_search_date="         + dynamique_prepare('irl_search_date');
  postdata += "&irl_search_lieu="         + dynamique_prepare('irl_search_lieu');
  postdata += "&irl_search_raison="       + dynamique_prepare('irl_search_raison');
  postdata += "&irl_search_participants=" + dynamique_prepare('irl_search_participants');

  // Et on recharge le tableau en XHR
  dynamique(chemin, 'index', 'irl_tbody', postdata, 1);
}