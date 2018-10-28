///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sélection d'une catégorie
//
// chemin est le chemin jusqu'à la racine du site

function web_pages_select_categorie(chemin)
{
  // On remet les autres éléments à zéro
  document.getElementById('web_pages_periode').selectedIndex = 0;
  document.getElementById('web_pages_search').value = '';

  // Puis on sélectionne la catégorie
  dynamique(chemin, 'web_pages?categorie='+dynamique_prepare('web_pages_categorie'), 'web_pages_liste', '', 0);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sélection d'une période
//
// chemin est le chemin jusqu'à la racine du site

function web_pages_select_periode(chemin)
{
  // On remet les autres éléments à zéro
  document.getElementById('web_pages_categorie').selectedIndex = 0;
  document.getElementById('web_pages_search').value = '';

  // Puis on sélectionne la période
  dynamique(chemin, 'web_pages?periode='+dynamique_prepare('web_pages_periode'), 'web_pages_liste', '', 0);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recherche parmi les pages
//
// chemin est le chemin jusqu'à la racine du site

function web_pages_recherche(chemin)
{
  // On remet les autres éléments à zéro
  document.getElementById('web_pages_categorie').selectedIndex = 0;
  document.getElementById('web_pages_periode').selectedIndex = 0;

  // Puis on lance la recherche
  dynamique(chemin, 'web_pages', 'web_pages_liste', 'search=' + dynamique_prepare('web_pages_search'), 0);
}
