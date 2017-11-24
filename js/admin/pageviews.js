/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                        /js/admin/pageviews.js                                                         **
**                                   Fonction permettant de gérer le contenu du tableau des pageviews                                    **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de faire un peu tout dans le tableau des pageviews
//
// chemin est le chemin jusqu'à la racine du site
// tri    (optionnel) est le tri à appliquer au tableau, ne s'applique pas si sa valeur est 0
// raz    (optionnel) remet à zéro la date de comparaison s'il est rempli, ne s'applique pas si sa valeur est 0
// id_del (optionnel) supprime l'entrée du tableau dont l'id est passé via la variable delete

function d_tableau_pageviews(chemin, tri, raz, id_del)
{
  // Si nécessaire, on change le tri
  if(typeof(tri) !== 'undefined' && tri != 0)
    document.getElementById('pageviews_tri').value = tri;

  // On récupère les champs de recherche
  postdata  = 'pageviews_tri='        + dynamique_prepare('pageviews_tri');
  postdata += '&pageviews_recherche=' + dynamique_prepare('pageviews_recherche');

  // Remise à zéro de la date de comparaison ou arrêter le script
  if(typeof(raz) !== 'undefined' && raz != 0)
  {
    if(confirm('Remettre à zéro la date de comparaison des pageviews ?'))
      postdata += '&pageviews_raz=1';
    else
      return;
  }

  // Suppression d'une entrée du tableau
  if(typeof(id_del) !== 'undefined')
  {
    if(confirm('Supprimer cette entrée des pageviews ?'))
      postdata += '&pageviews_delete=' + encodeURIComponent(id_del);
    else
      return;
  }

  // Et on envoie le XHR
  dynamique(chemin, 'pageviews.php', 'pageviews_tbody', postdata, 1);
}