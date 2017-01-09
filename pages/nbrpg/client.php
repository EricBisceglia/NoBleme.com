<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/nbrpg.inc.php';    // Contenu du NBRPG

// Permissions et récupération de l'id du joueur
$id_nbrpg = nbrpg();
if(!$id_nbrpg)
  header("Location: ".$chemin."pages/nbrpg/fiche_perso");
$id_session = nbrpg_session($id_nbrpg);
if(!$id_session)
  header("Location: ".$chemin."pages/nbrpg/client_spectateur");

// Cette page est à apprécier en plein écran, on vire les menus !
$_GET['popup'] = 1;

// Titre et description
$page_titre = "NoBlemeRPG";

// Identification
$page_nom = "nbrpg";
$page_id  = "client";

// CSS & JS
$css  = array("onglets", "nbrpg");
$js   = array("onglets", "dynamique");



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Historique des chats

// On remet à zéro la date de dernière lecture
$timestamp = time();
query(" UPDATE nbrpg_persos SET dernier_chat_rp = '$timestamp', dernier_chat_hrp = '$timestamp' WHERE id = '$id_nbrpg' ");

// On va chercher les lignes de chat
$qchat  = query(" SELECT    nbrpg_chatlog.timestamp     AS 'c_date'     ,
                            membres.pseudonyme          AS 'm_pseudo'   ,
                            nbrpg_persos.nom            AS 'm_nom'      ,
                            nbrpg_persos.couleur_chat   AS 'm_couleur'  ,
                            nbrpg_chatlog.type_chat     AS 'c_type'     ,
                            nbrpg_chatlog.message       AS 'c_message'
                  FROM      nbrpg_chatlog
                  LEFT JOIN nbrpg_persos  ON nbrpg_chatlog.FKmembres  = nbrpg_persos.FKmembres
                  LEFT JOIN membres       ON nbrpg_chatlog.FKmembres  = membres.id
                  ORDER BY  nbrpg_chatlog.timestamp ASC
                  LIMIT     1000 ");

// Puis on les prépare pour l'affichage
$chat_rp  = '';
$chat_hrp = '';
while($dchat = mysqli_fetch_array($qchat))
{
  if($dchat['c_type'] == 'RP')
    $chat_rp .= nbrpg_chatlog($dchat['c_date'], $dchat['m_couleur'], $dchat['m_nom'], 'RP', $dchat['c_message']);
  else if($dchat['c_type'] == 'HRP')
    $chat_hrp .= nbrpg_chatlog($dchat['c_date'], $dchat['m_couleur'], $dchat['m_pseudo'], 'RP', $dchat['c_message']);
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <br>
    <br>
    <div class="indiv align_center">
      <a href="<?=$chemin?>pages/nbrpg/index">
        <img src="<?=$chemin?>img/logos/nbrpg.png" alt="NoBlemeRPG">
      </a>
    </div>
    <br>
    <br>

    <script>
    window.addEventListener("DOMContentLoaded", function() {
      window.setInterval(function(){ dynamique('<?=$chemin?>','xhr/client_chat','chat_rp', 'xhr&type=RP', 'append','container_chat_rp','chatrp_onglet') }, 1800);
      window.setInterval(function(){ dynamique('<?=$chemin?>','xhr/client_chat','chat_hrp', 'xhr&type=HRP', 'append','container_chat_hrp','chathrp_onglet') }, 1900);
      window.setInterval(function(){ dynamique('<?=$chemin?>','xhr/client_session','nbrpg_session', 'xhr'); }, 2900);
      window.setInterval(function(){ dynamique('<?=$chemin?>','xhr/client_fiche_perso','fiche_perso', 'xhr'); }, 3000);
      window.setInterval(function(){ dynamique('<?=$chemin?>','xhr/client_evenements','nbrpg_evenements', 'xhr', 'append','container_evenements','evenements_onglet') }, 1900);
    }, false);
    </script>

    <div class="body_main midsize">

      <ul class="onglet">
        <li><a id="chatrp_onglet" class="pointeur bouton_onglet" onclick="ouvrirOnglet(event, 'chatrp')">NoBlemeRPG</a></li>
        <li><a id="chathrp_onglet" class="pointeur bouton_onglet" onclick="ouvrirOnglet(event, 'chathrp')">Chat hors RP</a></li>
        <li><a id="session_onglet" class="pointeur bouton_onglet" onclick="ouvrirOnglet(event, 'session')">Session</a></li>
        <li><a id="perso_onglet" class="pointeur bouton_onglet" onclick="ouvrirOnglet(event, 'perso')">Personnage</a></li>
        <li><a id="evenements_onglet" class="pointeur bouton_onglet" onclick="ouvrirOnglet(event, 'evenements')">Évènements</a></li>
        <li><a id="evenements_onglet" class="pointeur bouton_onglet" onclick="ouvrirOnglet(event, 'scribe')">Coin du scribe</a></li>
      </ul>

      <div id="chatrp" class="contenu_onglet">
        <div id="container_chat_rp" class="scroll_onglet monospace nbrpg_container">
          <?=$chat_rp?>
          <div id="chat_rp">
          </div>
        </div>
        <input id="chat_rp_input" class="indiv" maxlength="255" onKeyPress="if(event.keyCode == 13){ dynamique('<?=$chemin?>','xhr/client_actions','', 'xhr&amp;action=chat_rp&amp;valeur='+dynamique_prepare('chat_rp_input')); this.value=''; }">
      </div>

      <div id="chathrp" class="contenu_onglet">
        <div id="container_chat_hrp" class="scroll_onglet monospace nbrpg_container">
          <?=$chat_hrp?>
          <div id="chat_hrp">
          </div>
        </div>
        <input id="chat_hrp_input" class="indiv" maxlength="255" onKeyPress="if(event.keyCode == 13){ dynamique('<?=$chemin?>','xhr/client_actions','', 'xhr&amp;action=chat_hrp&amp;valeur='+dynamique_prepare('chat_hrp_input')); this.value=''; }">
      </div>

      <div id="perso" class="contenu_onglet">
        <div id="fiche_perso" class="nbrpg_fullcontainer">
          <div class="indiv align_center moinsgros gras nbrpg_preloader">
            Chargement du contenu...
          </div>
        </div>
      </div>

      <div id="session" class="contenu_onglet">
        <div id="nbrpg_session" class="nbrpg_fullcontainer">
          <div class="indiv align_center moinsgros gras nbrpg_preloader">
            Chargement du contenu...
          </div>
        </div>
      </div>

      <div id="evenements" class="contenu_onglet">
        <div id="container_evenements" class="scroll_onglet nbrpg_fullcontainer">
          <div id="nbrpg_evenements">
          </div>
        </div>
      </div>

      <div id="scribe" class="contenu_onglet">
        <div class="nbrpg_fullcontainer">
          <br>
          <div class="indiv align_center moinsgros gras vspaced">
            Chercher des informations dans la caverne de Liodain :<br>
            <input class="align_center gras nbrpg_searchcaverne" placeholder="Entrez votre recherche ici et appuyez sur entrée">
          </div>
          <br>
          <br>
          <div id="nbrpg_scribe" class="indiv align_center gras moinsgros">
            <br>
            <br>
            <br>
            <br>
            La caverne de Liodain n'est pas encore ouverte !<br>
            <br>
            <br>
            Cette fonctionnalité du NBRPG dépend de la caverne de Liodain,<br>
            et n'est donc pas disponible pour le moment.<br>
            <br>
            Désolé !
          </div>
        </div>
      </div>

    </div>

    <script>
    // Une fois la page chargée, on fait le choix de l'onglet à ouvrir et positionnement par défaut des barres de défilement
    window.addEventListener("DOMContentLoaded", function() {
      document.getElementById("chatrp_onglet").click();
      document.getElementById('container_chat_rp').scrollTop = document.getElementById('container_chat_rp').scrollHeight;
      document.getElementById('container_chat_hrp').scrollTop = document.getElementById('container_chat_hrp').scrollHeight;
    }, false);
    </script>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                     PLACE AUX DONNÉES DYNAMIQUES                                                      */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/