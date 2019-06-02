/******************************************************************************************************************************************
**                                                                                                                                       **
**                                      Fonctions liées à l'administration des catégories de tâches                                      **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Affiche le formulaire de modification d'une catégorie spécifique
//
// chemin est le chemin jusqu'à la racine du site
// id     est l'id de la catégorie qu'on veut modifier

function categorie_formulaire_edition(chemin, id)
{
  // On affiche la ligne cachée contenant le formulaire
  toggle_row('categorie_edit_container_' + id, 1);

  // On prépare le postdata
  postdata  = 'categorie_id=' + encodeURIComponent(id);
  postdata += '&chemin='      + encodeURIComponent(chemin);

  // On appelle le formulaire en XHR
  dynamique(chemin, './xhr/categorie_edit', 'categorie_edit_' + id, postdata, 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajoute une nouvelle catégorie
//
// chemin est le chemin jusqu'à la racine du site

function categorie_ajouter(chemin)
{
  // On envoie la demande en XHR
  dynamique(chemin, 'edit_categories', 'categories_tbody', 'categorie_add=1', 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modifie une catégorie spécifique
//
// chemin est le chemin jusqu'à la racine du site
// id     est l'id de la catégorie qu'on veut modifier

function categorie_modifier(chemin, id)
{
  // On masque la ligne cachée contenant le formulaire
  toggle_row('categorie_edit_container_' + id, 1);

  // On prépare le postdata
  postdata  = 'categorie_edit='       + encodeURIComponent(id);
  postdata += '&categorie_titre_fr='  + dynamique_prepare('categorie_titre_fr_'+id);
  postdata += '&categorie_titre_en='  + dynamique_prepare('categorie_titre_en_'+id);

  // On envoie la demande en XHR
  dynamique(chemin, 'edit_categories', 'categories_tbody', postdata, 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Supprime une catégorie spécifique
//
// chemin est le chemin jusqu'à la racine du site
// id     est l'id de la catégorie qu'on veut modifier

function categorie_supprimer(chemin, id)
{
  // On confirme la suppression
  if(!confirm('Confirmer la suppression de la catégorie'))
    return;

  // On masque la ligne cachée contenant le formulaire
  toggle_row('categorie_edit_container_' + id, 1);

  // On envoie la demande en XHR
  dynamique(chemin, 'edit_categories', 'categories_tbody', 'categorie_delete=' + encodeURIComponent(id), 1);
}