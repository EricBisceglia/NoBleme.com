/******************************************************************************************************************************************
**                                                                                                                                       **
**                                         Fonctions liées à la création d'un sujet sur le forum                                         **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Remplit le cadre d'exemple à partir d'informations demandées par un clic de l'utilisateur sur un élément
//
// chemin   est le chemin jusqu'à la racine du site
// element  est l'élément demandé

function forum_ouvrir_sujet_explications(chemin, element)
{
  // Préparation du postdata
  postdata  = 'chemin='+encodeURIComponent(chemin);
  postdata += '&element='+encodeURIComponent(element);

  // On remplace le contenu de la boite par l'élément demandé
  dynamique(chemin, 'xhr/explications.php', 'forum_explications', postdata);
}