/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                            js/dynamique.js                                                            **
**                                                                                                                                       **
**                                      Fonctions permettant les opérations dynamiques en javascript                                     **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  Paramètres :                                                                                                                         **
**                                                                                                                                       **
**          chemin : Le path relatif vers la racine du site                                                                              **
**  page_a_charger : URL de la page qui sera appelée par la requête et qui traitera le postdata                                          **
**   element_cible : ID de l'élément qui sera remplacé par ce que la requête va renvoyer                                                 **
**        postdata : Données qui vont être passées en postdata avec la requête                                                           **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  Exemple d'utilisation :                                                                                                              **
**                                                                                                                                       **
**  dynamique('<?=$chemin?>','maj.php?dynamique','maj',                                                                                  **
**    'version='+dynamique_prepare('version')+                                                                                           **
**    '&amp;build='+dynamique_prepare('build')+                                                                                          **
**    '&amp;date='+dynamique_prepare('date')+                                                                                            **
**    '&amp;maj=1');                                                                                                                     **
**                                                                                                                                       **
******************************************************************************************************************************************/

function dynamique(chemin, page_a_charger, element_cible , postdata) {

  // Barre de chargement à la place du futur contenu, si IE on ne l'affiche pas
  if(!document.addEventListener)
    document.getElementById(element_cible).innerHTML = '<div class="align_center intable">Chargement en cours...<br><img src="'+chemin+'img/divers/chargement.gif" alt="Chargement en cours..."></div>';


  // Création de l'objet xhr qui servira à communiquer
  var xhr;
  if(window.XMLHttpRequest)
    xhr = new XMLHttpRequest();
  else if (window.ActiveXObject)
    xhr = new ActiveXObject("Microsoft.XMLHTTP"); // Pour gérer IE8 et plus ancien

  // Envoi de la requête sous forme de postdata
  xhr.open("POST", page_a_charger, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(postdata);

  // Attente du retour des données
  xhr.onreadystatechange = retour_donnees;

  // Mise à jour des données si tout s'est bien passé
  function retour_donnees()
  {
    if(xhr.readyState === 4)
    {
      if(xhr.status === 200)
      {
        // Si l'user a IE, on reloade tout sans se poser de questions parce que fuck quoi
        if(!document.addEventListener)
          location.reload(false);

        // On met à jour la valeur
        document.getElementById(element_cible).innerHTML = xhr.responseText;
      }
      else
        // Erreur si 404 ou autre erreur http
        document.getElementById(element_cible).innerHTML = "Erreur de chargement du contenu dynamique :(";
    }
    else
      // Erreur si requête non finie ou autre erreur xhr
      document.getElementById(element_cible).innerHTML = "Erreur lors de la requête :(";
  }
}


function dynamique_prepare(id_element)
{
  // Cette fonction se contente de transformer les &amp; en :amp: pour pas perturber les chaines de postdata
  return document.getElementById(id_element).value.replace(/&/g,':amp:').replace(/&amp;/,':amp:');
}