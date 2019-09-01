// Faire disparaitre la suggestion de menu latéral quand on scrolle
window.addEventListener('scroll', function() {

  // On applique ceci seulement si le menu est caché
  if(window.getComputedStyle(document.getElementById('header_sidemenu')).display == 'none')
  {
    // On détecte où en est le scrolling
    var currentscroll = Math.max(document.body.scrollTop,document.documentElement.scrollTop);

    // Si on est en haut, on affiche, sinon, on masque
    if(!currentscroll)
      document.getElementById('header_nomenu').style.display = 'inline';
    else
      document.getElementById('header_nomenu').style.display = 'none';
  }
}, true);