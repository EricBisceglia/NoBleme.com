/******************************************************************************************************************************************
**                                                                                                                                       **
**                                    Fonctions liées à l'édition d'une IRL et/ou de ses participants                                    **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'un participant à une IRL
//
// chemin est le chemin jusqu'à la racine du site
// id     est l'id de l'irl à laquelle le participant est ajouté

function irl_ajouter_participant(chemin, id)
{
  // On masque le formulaire d'ajout
  toggle_row('irl_ajouter_participant');

  // On prépare le postdata
  postdata  = "irl_add_pseudo="       + dynamique_prepare('irl_add_pseudo');
  postdata += "&irl_add_details_fr="  + dynamique_prepare('irl_add_details_fr');
  postdata += "&irl_add_details_en="  + dynamique_prepare('irl_add_details_en');
  postdata += "&irl_add_confirme="    + encodeURIComponent(document.getElementById('irl_add_confirme').checked);

  // On nettoie le formulaire d'ajout
  document.getElementById('irl_add_pseudo').value = '';
  document.getElementById('irl_add_details_fr').value = '';
  document.getElementById('irl_add_details_en').value = '';
  document.getElementById('irl_add_confirme').checked = false;

  // Et on ajoute le participant en XHR
  dynamique(chemin, 'irl?id='+id, 'irl_participants_tbody', postdata, 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification d'un participant à une IRL
//
// chemin       est le chemin jusqu'à la racine du site
// irl          est l'id de l'irl à laquelle le participant est ajouté
// participant  est l'id du participant à modifier dans l'irl

function irl_modifier_participant(chemin, irl, participant)
{
  // On masque le formulaire d'édition
  toggle_row('irl_edition_'+participant, 1);

  // On prépare le postdata
  postdata  = "&irl_edit_id="         + encodeURIComponent(participant);
  postdata += "&irl_edit_pseudo="     + dynamique_prepare('irl_edit_pseudo_'+participant);
  postdata += "&irl_edit_details_fr=" + dynamique_prepare('irl_edit_details_fr_'+participant);
  postdata += "&irl_edit_details_en=" + dynamique_prepare('irl_edit_details_en_'+participant);
  postdata += "&irl_edit_confirme="   + encodeURIComponent(document.getElementById('irl_edit_confirme_'+participant).checked);

  // Et on envoie la modification en xhr
  dynamique(chemin, 'irl?id='+irl, 'irl_participants_tbody', postdata, 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'un participant à une IRL
//
// chemin       est le chemin jusqu'à la racine du site
// irl          est l'id de l'irl à laquelle le participant est ajouté
// participant  est l'id du participant à supprimer de l'IRL

function irl_supprimer_participant(chemin, irl, participant)
{
  // On confirme l'action
  if(!confirm('Confirmer la suppression du participant à l\'IRL? '))
    return;

  // Puis on supprime le participant en XHR
  dynamique(chemin, 'irl?id='+irl, 'irl_participants_tbody', 'irl_supprimer_participant='+encodeURIComponent(participant), 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une IRL
//
// chemin est le chemin jusqu'à la racine du site
// id     est l'id de l'irl à supprimer

function irl_supprimer(chemin, id)
{
  // On confirme l'action
  if(!confirm('Confirmer la suppression définitive de l\'IRL ?'))
    return;

  // Une seconde fois parce que bon
  if(!confirm('Confirmer une seconde fois la suppression définitive de l\'IRL (on est jamais trop sûr) ?'))
    return;

  // On supprime l'IRL en XHR
  dynamique(chemin, 'irl?id='+id, 'irl_titre', 'irl_supprimer=1', 1);
}