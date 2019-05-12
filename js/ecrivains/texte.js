/******************************************************************************************************************************************
**                                                                                                                                       **
**                                     Fonctions liées à la gestion d'un texte du coin des écrivains                                     **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ouvre l'interface administrative de suppression d'une réaction spécifique au texte
// chemin est le chemin jusqu'à la racine du site
// id     spécifie l'id de la réaction à supprimer

function texte_supprimer_reaction(chemin, id)
{
  // On prépare le postdata
  postdata  = 'chemin='   + encodeURIComponent(chemin);
  postdata += '&id='      + encodeURIComponent(id);

  // On envoie le XHR
  dynamique(chemin, './xhr/texte_reaction_supprimer.php', 'texte_reaction_'+id, postdata, 1);
}