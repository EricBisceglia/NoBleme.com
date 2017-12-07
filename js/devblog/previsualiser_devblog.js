/******************************************************************************************************************************************
**                                                                                                                                       **
**                       Fonction permettant d'avoir une prévisualisation en temps réel d'un blog de développement                       **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de prévisualiser en direct un devblog pendant qu'on le compose
// chemin             est le chemin jusqu'à la racine du site
// id     (optionnel) est l'id du devblog en cours de modification (si non rempli, c'est un ajout)

function previsualiser_devblog(chemin, id)
{
  // On prépare le postdata
  postdata = 'devblog_titre=' + dynamique_prepare('devblog_titre');
  postdata += '&devblog_contenu=' + dynamique_prepare('devblog_contenu');

  // On définit le chemin du fichier
  fichier = (typeof(id) === 'undefined') ? 'add' : 'edit?id='+id;

  // Et on génère la prévisualisation en XHR
  dynamique(chemin, fichier, 'devblog_previsualiser', postdata, 1 );
}