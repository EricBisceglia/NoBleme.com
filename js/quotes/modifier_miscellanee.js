/******************************************************************************************************************************************
**                                                                                                                                       **
**                                          Fonctions liées à la modification d'une miscellanée                                          **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de prévisualiser en direct une miscellanée pendant qu'on la modifie
// chemin est le chemin jusqu'à la racine du site
// id     est l'id de la miscellanée en cours d'édition

function previsualiser_miscellanee(chemin, id)
{
  // On génère la prévisualisation en XHR
  dynamique(chemin, './edit.php?id='+id, 'misc_preview', 'misc_preview='+dynamique_prepare('misc_contenu'), 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de lier ou supprimer un membre associé à la miscellanée
// chemin             est le chemin jusqu'à la racine du site
// id                 est l'id de la miscellanée à laquelle le membre est lié
// action             est l'action à effectuer
// membre (optionnel) est l'id du membre à supprimer

function miscellanee_membres_lies(chemin, id, action, membre)
{

  // Préparation du postdata
  postdata = 'misc_action='+action;

  // Modification d'un membre lié
  if(action == 'ajout')
    postdata += '&misc_membre='+dynamique_prepare('misc_membres');

  // Suppression d'un membre lié
  if(action == 'supprimer')
    postdata += '&misc_membre='+membre;

  // On vide le champ texte
  document.getElementById('misc_membres').value = '';

  // On envoie la requête en xhr
  dynamique(chemin, './edit.php?id='+id, 'misc_membres_lies', postdata, 1);
}