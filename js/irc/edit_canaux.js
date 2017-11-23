/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                         /js/irc/edit_canaux.js                                                        **
**                                              Fonctions liées à l'édition des canaux IRC                                               **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Affiche le formulaire de modification d'un canal IRC spécifique
//
// chemin est le chemin jusqu'à la racine du site
// id     est l'id du canal qu'on veut modifier

function canal_formulaire_edition(chemin, id)
{
  // On affiche la ligne cachée contenant le formulaire
  toggle_row('canal_ligne_' + id, 1);

  // On prépare le postdata
  postdata  = 'canal_id=' + encodeURIComponent(id);
  postdata += '&chemin='  + encodeURIComponent(chemin);

  // On appelle le formulaire en XHR
  dynamique(chemin, './xhr/canal_edit', 'canal_container_' + id, postdata, 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modifie un cana spécifique
//
// chemin est le chemin jusqu'à la racine du site
// id     est l'id du canal qu'on veut modifier

function canal_modifier(chemin, id)
{
  // On masque la ligne cachée contenant le formulaire
  toggle_row('canal_ligne_' + id, 1);

  // On prépare le postdata
  postdata  = 'canal_edit='         + encodeURIComponent(id);
  postdata += '&canal_nom='         + dynamique_prepare('canal_nom_'+id);
  postdata += '&canal_importance='  + dynamique_prepare('canal_importance_'+id);
  postdata += '&canal_langue='      + dynamique_prepare('canal_langue_'+id);
  postdata += '&canal_descfr='      + dynamique_prepare('canal_descfr_'+id);
  postdata += '&canal_descen='      + dynamique_prepare('canal_descen_'+id);

  // On envoie la demande en XHR
  dynamique(chemin, 'edit_canaux', 'canaux_tbody', postdata, 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Supprime un canal spécifique
//
// chemin est le chemin jusqu'à la racine du site
// id     est l'id du canal qu'on veut modifier

function canal_supprimer(chemin, id)
{
  // On confirme la suppression
  if(!confirm('Confirmer la suppression du canal'))
    return;

  // On masque la ligne cachée contenant le formulaire
  toggle_row('canal_ligne_' + id, 1);

  // On envoie la demande en XHR
  dynamique(chemin, 'edit_canaux', 'canaux_tbody', 'canal_delete=' + encodeURIComponent(id), 1);
}