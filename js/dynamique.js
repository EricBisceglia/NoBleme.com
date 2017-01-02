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
**          append : Si ce paramètre est rempli, le contenu est ajouté à la fin de l'élément au lieu de le remplacer                     **
**      scrolldown : Si ce paramètre est rempli, le contenu de l'élément spécifié est scrollé vers le bas                                **
**        blinktab : Fonctionne avec onglets.js et onglets.css - Quand du contenu est renvoyé, fait clignotter l'id passé en paramètre   **
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

function dynamique(chemin, page_a_charger, element_cible , postdata, append, scrolldown, blinktab) {

  // Barre de chargement à la place du futur contenu, si IE on ne l'affiche pas
  if(typeof append === 'undefined' && !document.addEventListener)
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
  if(typeof append === 'undefined')
    xhr.onreadystatechange = retour_donnees;
  else
    xhr.onreadystatechange = append_donnees;

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
        if(typeof append === 'undefined')
          document.getElementById(element_cible).innerHTML = xhr.responseText;
      }
      // Erreur si 404 ou autre erreur http
      else
        document.getElementById(element_cible).innerHTML = "Erreur de chargement du contenu dynamique :(";
    }
    // Erreur si requête non finie ou autre erreur xhr
    else
      document.getElementById(element_cible).innerHTML = "Erreur lors de la requête :(";
  }

  // Append de données si tout se passe bien
  function append_donnees()
  {
    if(xhr.readyState === 4)
    {
      if(xhr.status === 200)
      {
        // Si l'user a IE, on reloade tout sans se poser de questions parce que fuck quoi
        if(!document.addEventListener)
          location.reload(false);

        // Si on doit contrôler une barre de défilement, on en chope la position avant d'append l'élément
        if(typeof scrolldown !== 'undefined')
        {
          var scrollMe    = document.getElementById(scrolldown);
          var scrollLock  = ((scrollMe.scrollHeight - scrollMe.scrollTop) != scrollMe.clientHeight);
        }

        // On appent l'élément à la fin du div
        var div       = document.createElement("div");
        div.innerHTML = xhr.responseText;
        document.getElementById(element_cible).appendChild(div);

        // Si on doit faire clignotter un onglet, on le fait si du contenu est retourné par la fonction
        if(typeof blinktab !== 'undefined' && xhr.responseText)
        {
          var blinktabid = document.getElementById(blinktab);

          // Évidemment, on ne le fait que si l'onglet n'est pas actuellement actif, sinon ça sert à rien
          if(!blinktabid.classList.contains('onglet_actif'))
            blinktabid.classList.add('onglet_blink');
        }

        // Si nécessaire, on bouge la barre de défilement vers le bas
        if(typeof scrolldown !== 'undefined' && !scrollLock)
          scrollMe.scrollTop = scrollMe.scrollHeight;
      }
      // Erreur si 404 ou autre erreur http
      else
        document.getElementById(element_cible).innerHTML = "Erreur de chargement du contenu dynamique :(";
    }
  }
}


function dynamique_prepare(id_element)
{
  // Cette fonction se contente de transformer les &amp; en :amp: pour pas perturber les chaines de postdata
  return document.getElementById(id_element).value.replace(/&/g,':amp:').replace(/&amp;/,':amp:');
}