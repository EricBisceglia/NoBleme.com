/******************************************************************************************************************************************
**                                                                                                                                       **
**                                   Fonction permettant de chercher un utilisateur par son pseudonyme                                   **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de chercher un utilisateur par son pseudonyme
//
// chemin est le chemin jusqu'à la racine du site
// action est l'action à afficher dans le tableau renvoyé
// lien   est le lien vers lequel l'action doit pointer

function sysop_chercher_user(chemin, action, lien)
{
  // On prépare le postdata
  postdata  = 'pseudo='   + dynamique_prepare('sysop_pseudo_user');
  postdata += '&action='  + encodeURIComponent(action);
  postdata += '&lien='    + encodeURIComponent(lien);
  postdata += '&chemin='  + encodeURIComponent(chemin);

  // On envoie le XHR
  dynamique(chemin, './xhr/liste_users.php', 'sysop_liste_users', postdata, 1 );
}