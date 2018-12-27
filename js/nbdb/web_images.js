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