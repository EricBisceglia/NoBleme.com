/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                  Fonctions liées aux sujets du forum                                                  **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prévisualise en direct le contenu d'une réponse pendant qu'on l'écrit
// chemin             est le chemin jusqu'à la racine du site
// id     (optionnel) spécifie l'id du message prévisualisé

function forum_ecrire_reponse_previsualisation(chemin, id)
{
  if(typeof(id) === 'undefined')
  {
    // On affiche l'encadré de preview au cas où il serait encore masqué
    document.getElementById('forum_ecrire_reponse_container').style.display = 'block';

    // Et on génère la prévisualisation en XHR
    dynamique(chemin, './xhr/previsualiser_message.php', 'forum_ecrire_reponse_previsualisation', 'message='+dynamique_prepare('forum_ecrire_reponse'), 1);
  }
  else
  {
    // On se contente d'envoyer le xhr
    dynamique(chemin, './xhr/previsualiser_message.php', 'forum_modifier_message_previsualisation_'+id, 'message='+dynamique_prepare('forum_modifier_message_'+id), 1);
  }
}





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Vérifie que tous les champs soient bien remplis avant de valider l'envoi d'une nouvelle réponse

function forum_ecrire_reponse_envoyer()
{
  // On remet le label en couleur par défaut
  document.getElementById('forum_ecrire_reponse_label').classList.remove('texte_negatif');

  // Si le message est vide, on arrête
  if(document.getElementById('forum_ecrire_reponse').value == '')
  {
    document.getElementById('forum_ecrire_reponse_label').classList.add('texte_negatif');
    return;
  }

  // Sinon, on envoie le formulaire
  document.getElementById("forum_poster_reponse").submit();
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ouvre le formulaire de modification ou suppression d'un message
// chemin est le chemin jusqu'à la racine du site
// id     est l'id du message à modifier/supprimer
// action est l'action à effectuer

function forum_modifier_message(chemin, id, action)
{
  // On prépare le postdata
  postdata  = 'chemin='   + encodeURIComponent(chemin);
  postdata += '&action='  + encodeURIComponent(action);
  postdata += '&id='      + encodeURIComponent(id);

  // On envoie le xhr
  dynamique(chemin, './xhr/modifier_message.php', 'message_' + id, postdata, 1);
}