<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Canaux IRC";
$page_desc  = "Liste des canaux IRC principaux du serveur NoBleme";

// Identification
$page_nom = "irc";
$page_id  = "canaux";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <a href="<?=$chemin?>pages/irc/">
        <img src="<?=$chemin?>img/logos/irc.png" alt="Logo">
      </a>
    </div>
    <br>

    <div class="body_main midsize">
      <span class="titre">Liste des principaux canaux de discussion du serveur IRC NoBleme</span><br>
      <br>
      Le tableau ci-dessous recense tous les canaux de discussion importants du <a class="dark blank" href="<?=$chemin?>pages/irc/index">serveur de discussion IRC de NoBleme</a>.<br>
      Pourquoi avons nous séparé les conversations en plusieurs canaux ? Réponse sur la page des <a class="dark blank" href="<?=$chemin?>pages/irc/traditions">coutumes et traditions</a> du serveur.<br>
      <br>
      Pour rejoindre un canal listé dans le tableau, c'est tout simple : écrivez « <span class="gras">/join #canal</span> » sur IRC.<br>
      Il faut bien entendu remplacer #canal par le nom du canal, par exemple « /join #NoBleme » ou « /join #dev ».<br>
      <br>
      Si vous désirez qu'un canal de discussion soit ajouté à cette liste (ou en soit retiré), demandez-le à <a class="dark blank" href="<?=$chemin?>pages/user/user?id=1">Bad</a> sur le canal IRC #NoBleme.<br>
      <br>

      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Canal
          </td>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Responsable
          </td>
          <td class="cadre_gris_titre moinsgros gras spaced">
            Description
          </td>
        </tr>

        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center spaced vspaced">
            #NoBleme
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?pseudo=Bad">Bad</a>
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Canal principal/central du serveur. Conversations sur tous les sujets.
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center spaced vspaced">
            #dev
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?pseudo=Bad">Bad</a>
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Le coin des développeurs, où l'on parle informatique. Tous niveaux, d'amateur à professionel.
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center spaced vspaced">
            #english
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?pseudo=Bad">Bad</a>
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Canal anglophone / English channel for those who don't speak french
          </td>
        </tr>

        <tr>
          <td class="cadre_gris_vide" colspan="3">
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center spaced vspaced">
            #diablo
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?pseudo=Kutz">Kutz</a>
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Pour les joueurs et/ou spectateurs de <a class="dark blank" href="https://fr.wikipedia.org/wiki/Diablo_3">Diablo 3</a>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center spaced vspaced">
            #hots
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?pseudo=Bad">Bad</a>
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Pour les joueurs et/ou spectateurs de <a class="dark blank" href="https://fr.wikipedia.org/wiki/Heroes_of_the_Storm">Heroes of the Storm</a>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center spaced vspaced">
            #JdR
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?pseudo=Planeshift">Planeshift</a>
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Pour les amateurs de <a class="dark blank" href="https://fr.wikipedia.org/wiki/Jeu_de_r%C3%B4le">jeux de rôle</a> et/ou ceux qui veulent faire des jeux de rôles par internet
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center spaced vspaced">
            #lol
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?pseudo=Planeshift">Planeshift</a>
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Pour les joueurs et/ou spectateurs de <a class="dark blank" href="https://fr.wikipedia.org/wiki/League_of_Legends">League of Legends</a>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center spaced vspaced">
            #minecraft
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?pseudo=Kutz">Kutz</a>
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Pour les joueurs et/ou spectateurs de <a class="dark blank" href="https://fr.wikipedia.org/wiki/Minecraft">Minecraft</a>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center spaced vspaced">
            #musique
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?pseudo=Wan">Wan</a>
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Pour partager ce que l'on écoute et ainsi peut-être découvrir de nouveaux artistes
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center spaced vspaced">
            #starcraft
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?pseudo=Bad">Bad</a>
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Pour les joueurs et/ou spectateurs de <a class="dark blank" href="https://fr.wikipedia.org/wiki/Starcraft_II">Starcraft II</a>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center spaced vspaced">
            #urt
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?pseudo=Bad">Bad</a>
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Pour les joueurs et/ou spectateurs de <a class="dark blank" href="https://fr.wikipedia.org/wiki/Urban_Terror">Urban Terror</a>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center spaced vspaced">
            #write
          </td>
          <td class="cadre_gris align_center gras spaced vspaced">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?pseudo=OrCrawn">OrCrawn</a>
          </td>
          <td class="cadre_gris align_center spaced vspaced">
            Le coin des écrivains amateurs
          </td>
        </tr>

      </table>

    </div>


<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';