///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Complétion automatique du nom de fichier lors de l'upload

function web_images_transfert_nom_fichier()
{
  // On récupère le nom complet du fichier
  var nomFichier = document.getElementById('web_images_upload_fichier').value;

  // On se débarrasse du chemin pour ne garder que le nom
  var position = nomFichier.lastIndexOf('\\');
  if(position >= 0)
    nomFichier = nomFichier.substring(position + 1);

  // On se dbarrasse aussi de l'extension à la fin du nom pour éviter de faire des bêtises
  nomFichier = nomFichier.split('.').slice(0, -1).join('.');

  // Il ne reste plus qu'à placer le nom du fichier dans le champ prévu à cet effet
  document.getElementById('web_images_upload_nom').value = nomFichier;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recherche dans le tableau
//
// chemin est le chemin jusqu'à la racine du site

function web_images_tableau_recherche(chemin)
{
  // Assemblage du postdata
  postdata  =  'web_images_search_nom='       + dynamique_prepare('web_images_search_nom');
  postdata += '&web_images_search_tags='      + dynamique_prepare('web_images_search_tags');
  postdata += '&web_images_search_pages_fr='  + dynamique_prepare('web_images_search_pages_fr');
  postdata += '&web_images_search_pages_en='  + dynamique_prepare('web_images_search_pages_en');

  // Envoi de la requête
  dynamique(chemin, 'web_images', 'web_images_tbody', postdata, 1);
}