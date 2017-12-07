/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                 Fonctions liées à la liste des tâches                                                 **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Faire des tris et des recherches dans le tableau des tâches
//
// chemin             est le chemin jusqu'à la racine du site
// tri    (optionnel) est le tri à appliquer au tableau, sa la valeur est raz, remet à zéro la recherche et le tri

function todolist_tableau(chemin, tri)
{
  // On définit le nouvel ordre de tri
  if(typeof(tri) !== 'undefined')
    document.getElementById('todo_tri').value = tri;

  // On prépare le postdata
  postdata  = "todo_tri=" + dynamique_prepare('todo_tri');
  if(tri != 'raz')
  {
    postdata += '&todo_search_id='          + dynamique_prepare('todo_search_id');
    postdata += '&todo_search_prive='       + dynamique_prepare('todo_search_prive');
    postdata += '&todo_search_importance='  + dynamique_prepare('todo_search_importance');
    postdata += '&todo_search_creation='    + dynamique_prepare('todo_search_creation');
    postdata += '&todo_search_createur='    + dynamique_prepare('todo_search_createur');
    postdata += '&todo_search_categorie='   + dynamique_prepare('todo_search_categorie');
    postdata += '&todo_search_description=' + dynamique_prepare('todo_search_description');
    postdata += '&todo_search_objectif='    + dynamique_prepare('todo_search_objectif');
    postdata += '&todo_search_etat='        + dynamique_prepare('todo_search_etat');
    postdata += '&todo_search_resolution='  + dynamique_prepare('todo_search_resolution');
  }

  // Si on remet à zéro la recherche, on vide les champs
  if(tri == 'raz')
  {
    document.getElementById('todo_tri').value                 = '';
    document.getElementById('todo_search_id').value           = '';
    document.getElementById('todo_search_prive').value        = -1;
    document.getElementById('todo_search_importance').value   = -1;
    document.getElementById('todo_search_creation').value     = 0;
    document.getElementById('todo_search_createur').value     = '';
    document.getElementById('todo_search_categorie').value    = -1;
    document.getElementById('todo_search_description').value  = '';
    document.getElementById('todo_search_objectif').value     = -1;
    document.getElementById('todo_search_etat').value         = -1;
    document.getElementById('todo_search_resolution').value   = 0;
  }

  // Et on recharge le tableau en XHR
  dynamique(chemin, 'index', 'todolist_tbody', postdata, 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Afficher le formulaire d'ajout de tâche

function todolist_ajouter_tache()
{
  // On wipe le formulaire
  document.getElementById('todolist_add_form').reset();

  // Et on l'affiche
  toggle_row('todolist_add');
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Afficher une tâche dans la liste des tâches
//
// chemin est le chemin jusqu'à la racine du site
// id     est l'id de la tâche à afficher

function todolist_afficher_tache(chemin, id)
{
  // On affiche la ligne
  toggle_row('todolist_ligne_'+id, 1);

  // On prépare le postdata
  postdata  = "todo_id="      + encodeURIComponent(id);
  postdata += "&todo_chemin=" + encodeURIComponent(chemin);

  // Et on invoque le contenu de la tâche en xhr
  dynamique(chemin, './xhr/todolist_afficher_tache', 'todolist_cellule_'+id, postdata);
}