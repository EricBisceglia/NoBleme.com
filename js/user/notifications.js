/******************************************************************************************************************************************
**                                                                                                                                       **
**                               Utilisé avec les pages liées aux notifications systèmes et messages privés                              **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction marquant toutes les notifications comme lues ou supprimant toutes les modifications
// chemin   est le chemin jusqu'à la racine du site
// message  est le message de confirmation
// action   est l'action à faire ('lire' pour tout lire, 'supprimer' pour tout supprimer)

function notifications_boutons(chemin, message, action)
{
  // On commence par s'assurer que l'utilisateur veuille vraiment faire l'action
  if(!confirm(message))
   return;

  // On retire le gras de toutes les lignes du tableau
  if(action == 'lire')
  {
    var temptable = document.getElementById('messages_tbody');
    for (var i = 0, row; row = temptable.rows[i]; i++)
      row.classList.remove('gras');
  }

  // On retire le flash insupportable du header
  document.getElementById('nouveaux_messages').classList.remove('nouveaux_messages');

  // Et on envoie le XHR qui va faire l'action
  xhr_url   = (action == 'supprimer') ? 'notifs_tout_supprimer' : 'notifs_tout_lire';
  xhr_cible = (action == 'supprimer') ? 'messages_tbody' : 'messages_nonlus';
  dynamique(chemin, './xhr/'+xhr_url, encodeURIComponent(xhr_cible), '', 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de dérouler un message
// chemin est le chemin jusqu'à la racine du site
// id     est l'id du message
// outbox (optionnel) signifie qu'il s'agit d'un message envoyé

function notifications_afficher_message(chemin, id, outbox)
{
  // On commence par ouvrir la ligne
  toggle_row('message_ligne_' + id, 1);

  // On retire le gras et on vire le flash rouge horrible dans le header vu que le message va être marqué comme lu
  if(typeof(outbox) === 'undefined')
  {
    document.getElementById('message_tableau_' + id).classList.remove('gras');
    document.getElementById('nouveaux_messages').classList.remove('nouveaux_messages');
  }

  // On assemble le postdata
  postdata  = 'message_id=' + encodeURIComponent(id);
  postdata += '&chemin='    + encodeURIComponent(chemin);
  if(typeof(outbox) !== 'undefined')
    postdata += '&envoye=1';

  // Et on va lancer le XHR pour que le message s'affiche
  dynamique(chemin, './xhr/notifs_voir_message.php', 'message_corps_' + encodeURIComponent(id) , postdata);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant d'ouvrir un formulaire de réponse à un message
// id     est l'id du message
// citer  (optionnel) permet d'avoir la citation du message auquel on répond

function notification_formulaire_reponse(id, citer)
{
  // Si on ne veut pas citer, on vide le textarea du message et on masque la prévisualisation
  if(typeof(citer) === 'undefined')
  {
    document.getElementById('message_textarea_' + id).value = '';
    document.getElementById('message_previsualisation_' + id).innerHTML = '';
    document.getElementById('message_previsualisation_container_' + id).style.display = 'none' ;
  }

  // On masque les actions et on affiche le message
  toggle_row('message_actions_' + id);
  toggle_row('message_reponse_' + id);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de prévisualiser en direct un message pendant qu'on l'écrit
// chemin   est le chemin jusqu'à la racine du site
// id       (optionnel) est l'id du message - s'il n'est pas rempli on est dans le formulaire de composition

function notification_previsualiser(chemin, id)
{
  // Si on est dans le tableau
  if(typeof(id) !== 'undefined')
  {
    // On affiche l'encadré de preview au cas où il serait encore masqué
    document.getElementById('message_previsualisation_container_' + id).style.display = 'block';

    // Et on génère la prévisualisation en XHR
    dynamique(chemin, './xhr/previsualiser_bbcodes.php', 'message_previsualisation_' + id,
              'message=' + dynamique_prepare('message_textarea_' + id), 1 );
  }
  // Si on est dans le formulaire de composition
  else
  {
    // On affiche l'encadré de preview au cas où il serait encore masqué
    document.getElementById('message_previsualisation_container').style.display = 'block';

    // Et on génère la prévisualisation en XHR
    dynamique(chemin, './xhr/previsualiser_bbcodes.php', 'message_previsualisation',
              'message=' + dynamique_prepare('message_textarea'), 1 );
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant d'envoyer la réponse à un message
// chemin   est le chemin jusqu'à la racine du site
// id       est l'id du message

function notification_envoyer_reponse(chemin, id)
{
  // On peut fermer la ligne et afficher la zone de confirmation maintenant qu'on en a fini
  toggle_row('message_ligne_' + id, 1);
  document.getElementById('messages_confirmation').style.display = 'block';

  // On va chercher le contenu du message pour l'envoyer
  postdata  = "destinataire=" + dynamique_prepare('message_destinataire_' + id);
  postdata += "&sujet="       + dynamique_prepare('message_sujet_' + id);
  postdata += "&contenu="     + dynamique_prepare('message_textarea_' + id);

  // Et on laisse le XHR envoyer le message
  dynamique(chemin, './xhr/notifs_repondre.php', 'messages_confirmation', postdata, 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de supprimer un message
// chemin   est le chemin jusqu'à la racine du site
// id       est l'id du message
// message  est le message de confirmation

function notification_supprimer(chemin, id, message)
{
  // On s'assure que l'user veuille vraiment supprimer son message
  if(!confirm(message))
    return;

  // On ferme le formulaire d'édition puis on masque la ligne correspondant au message dans le tableau
  document.getElementById('message_ligne_' + id).style.display = 'none' ;
  document.getElementById('message_tableau_' + id).setAttribute('onclick', null);
  document.getElementById('message_tableau_' + id).classList.remove('pointeur');

  // Et on envoie le XHR pour supprimer le message
  dynamique(chemin, './xhr/notifs_supprimer.php', 'message_tableau_' + id, 'message=' + encodeURIComponent(id), 1);
}