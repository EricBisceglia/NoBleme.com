/******************************************************************************************************************************************
**                                                                                                                                       **
**                            Fonction permettant d'avoir une prévisualisation en temps réel du profil public                            **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de prévisualiser en direct le profil public pendant qu'on le modifie
// chemin est le chemin jusqu'à la racine du site

function previsualiser_profil(chemin)
{
  // On affiche l'encadré de preview au cas où il serait encore masqué
  document.getElementById('profile_preview_container').style.display = 'block';

  // Et on génère la prévisualisation en XHR
  dynamique(chemin, './xhr/previsualiser_bbcodes.php', 'profile_preview',
            'message=' + dynamique_prepare('profilTexte'), 1 );
}