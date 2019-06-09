/******************************************************************************************************************************************
**                                                                                                                                       **
**                                         Fonctions liées à l'administration des plans de route                                         **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Affiche le formulaire de modification d'un plan de route spécifique
//
// chemin est le chemin jusqu'à la racine du site
// id     est l'id du plan de route qu'on veut modifier

function roadmap_formulaire_edition(chemin, id)
{
  // On affiche la ligne cachée contenant le formulaire
  toggle_row('roadmap_edit_container_' + id, 1);

  // On prépare le postdata
  postdata  = 'roadmap_id=' + encodeURIComponent(id);
  postdata += '&chemin='    + encodeURIComponent(chemin);

  // On appelle le formulaire en XHR
  dynamique(chemin, './xhr/roadmap_edit', 'roadmap_edit_' + id, postdata, 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajoute un nouveau plan de route
//
// chemin est le chemin jusqu'à la racine du site

function roadmap_ajouter(chemin)
{
  // On envoie la demande en XHR
  dynamique(chemin, 'edit_roadmaps', 'roadmaps_tbody', 'roadmap_add=1', 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modifie un plan de route spécifique
//
// chemin est le chemin jusqu'à la racine du site
// id     est l'id du plan de route qu'on veut modifier

function roadmap_modifier(chemin, id)
{
  // On masque la ligne cachée contenant le formulaire
  toggle_row('roadmap_edit_container_' + id, 1);

  // On prépare le postdata
  postdata  = 'roadmap_edit='         + encodeURIComponent(id);
  postdata += '&roadmap_classement='  + dynamique_prepare('roadmap_classement_'+id);
  postdata += '&roadmap_titre_fr='    + dynamique_prepare('roadmap_titre_fr_'+id);
  postdata += '&roadmap_titre_en='    + dynamique_prepare('roadmap_titre_en_'+id);
  postdata += '&roadmap_desc_fr='     + dynamique_prepare('roadmap_desc_fr_'+id);
  postdata += '&roadmap_desc_en='     + dynamique_prepare('roadmap_desc_en_'+id);

  // On envoie la demande en XHR
  dynamique(chemin, 'edit_roadmaps', 'roadmaps_tbody', postdata, 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Supprime un plan de route spécifique
//
// chemin est le chemin jusqu'à la racine du site
// id     est l'id du plan de route qu'on veut modifier

function roadmap_supprimer(chemin, id)
{
  // On confirme la suppression
  if(!confirm('Confirmer la suppression du plan de route'))
    return;

  // On masque la ligne cachée contenant le formulaire
  toggle_row('roadmap_edit_container_' + id, 1);

  // On envoie la demande en XHR
  dynamique(chemin, 'edit_roadmaps', 'roadmaps_tbody', 'roadmap_delete=' + encodeURIComponent(id), 1);
}