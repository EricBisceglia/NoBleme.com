/******************************************************************************************************************************************
**                                                                                                                                       **
**                                   Fonction permettant de chercher un utilisateur par son pseudonyme                                   **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de chercher un utilisateur par son pseudonyme afin de modifier ses permissions
//
// chemin est le chemin jusqu'à la racine du site

function admin_chercher_user(chemin)
{
  // On prépare le postdata
  postdata  = 'pseudo='   + dynamique_prepare('admin_pseudo_user');
  postdata += '&chemin='  + encodeURIComponent(chemin);

  // On envoie le XHR
  dynamique(chemin, './xhr/liste_users.php', 'admin_liste_users', postdata, 1 );
}