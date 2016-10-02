<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'discuter';
$header_submenu   = 'irc';
$header_sidemenu  = 'services';

// Titre et description
$page_titre = "IRC NoBleme: Services";
$page_desc  = "Liste de commandes et services pratiques utilisables sur le serveur IRC NoBleme";

// Identification
$page_nom = "irc";
$page_id  = "services";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/irc.png" alt="Serveur IRC NoBleme">
    </div>
    <br>

    <div class="body_main midsize">
      <span class="titre">Qu'est-ce qu'une commande ?</span><br>
      <br>
      Dans un client <a href="<?=$chemin?>pages/irc/index">IRC</a>, une commande est un mot ou une phrase qui commence par un slash (par exemple: « /ping » )<br>
      Lorsque vous écrivez une commande, elle ne sera pas envoyée sur le <a href="<?=$chemin?>pages/irc/canaux">canal IRC</a> où vous discutez, contrairement à du texte normal.<br>
      À la place, les commandes effectuent des actions dont vous seul pouvez voir le résultat.<br>
      <br>
      Cette page recense quelques commandes et fonctionnalités utiles sur IRC : certaines liées à votre client, d'autres au serveur IRC NoBleme.
    </div>

    <br>
    <br>

    <div class="body_main midsize">
      <span class="titre">Commandes liées à votre client IRC</span><br>
      <br>
      Les commandes listées dans le tableau ci-dessous fonctionnent dans la plupart des <a href="<?=$chemin?>pages/irc/client">clients IRC</a>.<br>
      Chaque <a href="<?=$chemin?>pages/irc/client">client</a> étant unique dans son fonctionnement, je ne peux pas vous garantir que ces commandes fonctionneront chez vous.<br>
      <br>
      <table class="cadre_gris indiv">
        <tr>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Commande
          </td>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Exemple
          </td>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Effet
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            /clear
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            &nbsp;
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Nettoie tous les messages présents à l'écran
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            /join #canal
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            /join #NoBleme
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Rejoint le <a class="dark blank gras" href="<?=$chemin?>pages/irc/canaux">canal</a> spécifié
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            /part #canal
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            /part #english
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Quitte le <a class="dark blank gras" href="<?=$chemin?>pages/irc/canaux">canal</a> spécifié
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            /quit
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            &nbsp;
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Vous déconnecte du serveur et quitte votre client IRC
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            /nick pseudonyme
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            /nick Bad
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Change le pseudonyme avec lequel vous apparaissez
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            /msg pseudonyme message
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            /nick Planeshift Bonjour !
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Envoie un message privé que seul l'utilisateur spécifié recevra
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            /whois pseudonyme
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            /whois ThArGos
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Renvoie des informations sur l'utilisateur spécifié
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            /ignore pseudonyme
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            /ignore jordanleouf
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Bloque toutes les communications envoyées par l'utilisateur spécifié
          </td>
        </tr>
      </table>
    </div>

    <br>
    <br>

    <div class="body_main midsize">
      <span class="titre">Enregistrer votre pseudonyme avec NickServ</span><br>
      <br>
      Le serveur NoBleme possède un service nommé NickServ qui vous permet d'enregistrer votre pseudonyme.<br>
      Une fois votre pseudonyme enregistré, personne d'autre que vous n'aura la possibilité d'utiliser votre pseudonyme sur le serveur.<br>
      <br>
      Enregistrer votre pseudonyme vous donne également accès à certaines commandes utiles que vous ne pouvez pas exécuter sans être enregistré, vous permet de créer votre propre canal IRC sur le serveur, et est requis pour être opérateur d'un canal IRC.<br>
      <br>
      Pour enregistrer le pseudonyme que vous utilisez actuellement, entrez la commande suivante :<br>
      <span class="alinea gras">/NS register motdepasse</span><br>
      Remplacez bien entendu « motdepasse » par votre mot de passe.<br>
      <br>
      Une fois votre pseudonyme enregistré, vous devez impérativement vous identifier lorsque vous vous connectez sur IRC.<br>
      Vous disposez de 60 secondes après votre connexion pour vous identifier, sinon votre pseudonyme sera changé par le serveur.<br>
      Pour vous identifier, utilisez la commande suivante, en remplaçant bien entendu « motdepasse » par votre mot de passe :<br>
      <span class="alinea gras">/NS identify motdepasse</span><br>
      <br>
      Si quelqu'un décide de squatter votre pseudonyme enregistré et que vous désirez en reprendre le contrôle, ou que les services du serveur ont verrouillé l'accès à votre pseudonyme, vous pouvez le libérer avec la commande suivante :<br>
      <span class="alinea gras">/NS recover pseudonyme motdepasse</span><br>
      Remplacez bien entendu « pseudonyme » par votre pseudonyme et « motdepasse » par votre mot de passe.<br>
      <br>
      Finalement, si vous désirez changer de mot de passe, il faut dé-enregistrer votre compte puis l'enregistrer à nouveau.<br>
      La commande vous permettant de libérer votre pseudonyme est la suivante (en remplaçant « pseudonyme » par votre pseudynome) :<br>
      <span class="alinea gras">/NS drop pseudonyme</span><br>
      <br>
      <span class="gras souligne">Note importante :</span> Ne vous amusez pas à enregistrer des pseudonymes d'utilisateurs autres que vous, ou vous serez banni vite fait.<br>
      Ces services sont faits pour protéger votre pseudonyme, pas pour abuser de ceux des autres.<br>
    </div>

    <br>
    <br>

    <div class="body_main midsize">
      <span class="titre">Enregistrer un canal de discussion avec NickServ</span><br>
      <br>
      Le serveur NoBleme possède un service nommé ChanServ qui permet d'enregistrer et gérer des <a href="<?=$chemin?>pages/irc/canaux">canaux de discussion</a>.<br>
      N'hésitez pas à créer votre propre canal sur le serveur NoBleme ! Tant que vous n'y faites rien d'illégal, ça ne pose aucun problème.<br>
      <br>
      Avant d'enregistrer un canal, vous devez d'abord avoir enregistré votre pseudonyme auprès de NickServ (voir la section précédente).<br>
      Une fois votre pseudonyme enregistré, utilisez la commande suivante pour enregistrer votre canal :<br>
      <span class="alinea gras">/CS register #canal</span><br>
      Remplacez bien entendu « #canal » par le nom de votre canal (qui doit impérativement commencer par le caractère « # » ).<br>
      <br>
      Une fois le canal crée, vous pouvez y ajouter des opérateurs, c'est à dire des utilisateurs qui peuvent kicker et bannir les indésirables.<br>
      Notez que vous ne pouvez ajouter en opérateurs que des utilisateurs qui ont enregistré leur pseudonyme auprès de NickServ.<br>
      Un opérateur s'ajoute à votre canal avec la commande suivante :<br>
      <span class="alinea gras">/CS aop #canal add pseudynome</span><br>
      Encore une fois, remplacez « #canal » par le nom de votre canal et « pseudonyme » par le pseudonyme de votre opérateur.<br>
      <br>
      Si vous décidez que vous ne voulez plus d'un canal que vous avez enregistré, vous pouvez le supprimer avec la commande suivante :<br>
      <span class="alinea gras">/CS drop #canal</span><br>
      Bien entendu, il faut remplacer « #canal » par le nom de votre canal. À force, vous devriez avoir compris ça quand même.<br>
      <br>
      <span class="gras souligne">Note importante :</span> Si le contenu de votre canal de discussion ne respecte pas le <a href="<?=$chemin?>pages/doc/coc">code de conduite</a> de NoBleme, les opérateurs du serveur IRC ont le pouvoir de dissoudre votre canal et de vous bannir à vie du serveur. Nous n'avons rien contre la présence d'utilisateurs extérieurs à NoBleme sur le serveur, mais ils doivent tout de même respecter les règles de NoBleme tant qu'ils sont sur le serveur.<br>
    </div>

    <br>
    <br>

    <div class="body_main bigsize">
      <span class="titre">Opérateurs et commandes</span><br>
      <br>
      Sur un <a href="<?=$chemin?>pages/irc/canaux">canal de discussion</a>, chaque utilisateur possède un certain « mode ».<br>
      Ce mode est représenté par un symbole unique qui est associé à son pseudonyme, et lui donne (ou non) certains pouvoirs sur le canal.<br>
      <br>
      Le tableau ci-dessous recense les principaux modes que vous trouverez sur les canaux, du moins important au plus important :<br>
      <br>

      <table class="cadre_gris indiv">
        <tr>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Mode
          </td>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Symbole
          </td>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Titre
          </td>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Droits
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="4">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            &nbsp;
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            &nbsp;
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Simple utilisateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Ne possède aucun droit particulier
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            +v
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            +
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Voix
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Ne possède aucun pouvoir spécial, sinon qu'il peut parler si le canal est en mode muet (+m)
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            +h
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            %
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Demi-opérateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Peut kicker et bannir les utilisateurs de niveau inférieur au sien (utilisateurs normaux et +voix)
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            +o
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            @
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Opérateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Peut kicker et bannir les utilisateurs de niveau inférieur au sien (normaux, +voix, et demi-ops)
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            +oa
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            &amp;
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Super opérateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Possède tous les droits sur le canal, sauf ceux de kicker/bannir le fondateur et de supprimer le canal
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced">
            +qo
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            ~
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Fondateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Possède tous les droits sur le canal
          </td>
        </tr>
      </table>

      <br>
      <hr class="points">
      <br>

      Si vous êtes un opérateur sur un canal IRC, vous avez accès à une série commandes vous permettant de gérer le canal via ChanServ.<br>
      Pour utiliser ces commandes, vous devez non seulement être un opérateur, mais aussi avoir enregistré et identifié votre pseudonyme auprès de NickServ.<br>
      <br>
      Le tableau ci-dessous recense les commandes les plus utiles pour maintenir l'ordre sur votre canal :<br>
      <br>

      <table class="cadre_gris indiv">
        <tr>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Commande
          </td>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Example
          </td>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Niveau minimum
          </td>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Effet
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="4">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced nowrap">
            /topic #canal contenu
          </td>
          <td class="cadre_gris align_center monospace spaced vspaced nowrap">
            /topic #NoBleme Bienvenue ici
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            Demi-opérateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Change le sujet du canal (texte qui apparait en permanence dans les clients des utilisateurs connectés)
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced nowrap">
            /kick pseudonyme raison
          </td>
          <td class="cadre_gris align_center monospace spaced vspaced nowrap">
            /kick Planeshift Tu dégages
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            Demi-opérateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Éjecte l'utilisateur spécifié hors du canal
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced nowrap">
            /mode #canal +b masque
          </td>
          <td class="cadre_gris align_center monospace spaced vspaced nowrap">
            /mode #dev +b *!*@*bla.fr
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            Demi-opérateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Bannit définitivement du canal tous les utilisateurs portant le masque d'hôte spécifié (complexe d'expliquer ce que c'est)
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced nowrap">
            /mode #canal -b masque
          </td>
          <td class="cadre_gris align_center monospace spaced vspaced nowrap">
            /mode #dev -b *!*@*bla.fr
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            Demi-opérateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Débannit tous les utilisateurs portant le masque d'hôte
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced nowrap">
            /mode #canal +m
          </td>
          <td class="cadre_gris align_center monospace spaced vspaced nowrap">
            /mode #test +m
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            Demi-opérateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Passe le canal en mode muet : Les utilisateurs normaux ne peuvent plus parler dans le canal tant qu'il est en mode +m
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced nowrap">
            /mode #canal -m
          </td>
          <td class="cadre_gris align_center monospace spaced vspaced nowrap">
            /mode #test -m
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            Demi-opérateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Retire le mode +m du canal, rend la parole à tout le monde
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="4">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced nowrap">
            /CS vop #canal add pseudonyme
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            /CS vop #dev add Trucy
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            Super opérateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            L'utilisateur spécifié devient +v (voix) sur le canal
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced nowrap">
            /CS hop #canal add pseudonyme
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            /CS hop #starcraft add ThArGos
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            Super opérateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            L'utilisateur spécifié devient +h (demi-opérateur)
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced nowrap">
            /CS aop #canal add pseudonyme
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            /CS aop #test add Planeshift
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            Super opérateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            L'utilisateur spécifié devient +o (opérateur)
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced nowrap">
            /CS sop #canal add pseudonyme
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            /CS sop #NoBleme add Akundo
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            Fondateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            L'utilisateur spécifié devient +oa (super opérateur)
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_vide" colspan="4">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center gras spaced vspaced nowrap">
            /CS aop #canal del pseudonyme
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            /CS sop #NoBleme del pins
          </td>
          <td class="cadre_gris align_center spaced vspaced nowrap">
            Super opérateur
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            L'utilisateur spécifié perd +o (opérateur)<br>
            Utilisable également avec vop, hop, sop à la place de aop
          </td>
        </tr>
      </table>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';