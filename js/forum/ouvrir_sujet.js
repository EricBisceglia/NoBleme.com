/******************************************************************************************************************************************
**                                                                                                                                       **
**                                         Fonctions liées à la création d'un sujet sur le forum                                         **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Remplit le cadre d'exemple à partir d'informations demandées par un clic de l'utilisateur sur un élément
//
// chemin   est le chemin jusqu'à la racine du site
// element  est l'élément demandé

function forum_ouvrir_sujet_explications(chemin, element)
{
  // Préparation du postdata
  postdata  = 'chemin='+encodeURIComponent(chemin);
  postdata += '&element='+encodeURIComponent(element);

  // On remplace le contenu de la boite par l'élément demandé
  dynamique(chemin, './xhr/explications.php', 'forum_explications', postdata, 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Décoche des cases et fait apparaitre des catégories au fur et à mesure que l'utilisateur coche des cases
//
// type     est le type de case qui vient d'être cochée
// element  est l'id de la case qui vient d'être cochée

function forum_ouvrir_sujet_categories(type, element)
{
  if(type == 'apparence')
  {
    document.getElementById('forum_presentation_fil').checked     = false;
    document.getElementById('forum_presentation_anonyme').checked = false;
    document.getElementById(element).checked                      = true;
  }
  else if(type == 'classification')
  {
    document.getElementById('forum_type_standard').checked  = false;
    document.getElementById('forum_type_serieux').checked   = false;
    document.getElementById('forum_type_debat').checked     = false;
    document.getElementById('forum_type_jeu').checked       = false;
    document.getElementById(element).checked                = true;
  }
  else if(type == 'categorisation')
  {
    num_categories = document.getElementById('forum_categorie_num').value;
    for(var i = 0; i < num_categories; i++)
      document.getElementById('forum_categorie_' + i).checked     = false;
    document.getElementById('forum_categorie_' + element).checked = true;
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Vérifie qu'une case de chaque type soit bien cochée avant de passer à la phase suivante de la création d'un sujet

function forum_ouvrir_sujet_composer()
{
  // On envoie le formulaire et on passe à la suite
  document.getElementById("forum_choisir_options").submit();
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de prévisualiser en direct le contenu d'un message pendant qu'on le compose
// chemin est le chemin jusqu'à la racine du site

function forum_ouvrir_sujet_previsualisation(chemin)
{
  // On affiche l'encadré de preview au cas où il serait encore masqué
  document.getElementById('forum_add_previsualisation_container').style.display = 'block';

  // Et on génère la prévisualisation en XHR
  dynamique(chemin, './xhr/previsualiser_message.php', 'forum_add_previsualisation', 'message='+dynamique_prepare('forum_add_contenu'), 1);
}





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Vérifie que tous les champs soient bien remplis avant de valider l'ouverture d'un nouveau sujet

function forum_ouvrir_sujet_envoyer()
{
  // On initialise la variable de vérification
  var verification = 1;

  // On remet les titres en couleur par défaut
  document.getElementById('forum_add_titre_label').classList.remove('texte_negatif');
  document.getElementById('forum_add_contenu_label').classList.remove('texte_negatif');

  // Si le titre est pas rempli, on arrête
  if(document.getElementById('forum_add_titre').value == '')
  {
    document.getElementById('forum_add_titre_label').classList.add('texte_negatif');
    verification = 0;
  }

  // Si le contenu du message est pas rempli, on arrête
  if(document.getElementById('forum_add_contenu').value == '')
  {
    document.getElementById('forum_add_contenu_label').classList.add('texte_negatif');
    verification = 0;
  }

  // Si tout est bon, on envoie le formulaire
  if(verification)
    document.getElementById("forum_composer_message").submit();
}