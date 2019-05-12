<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Jouer';
$header_sidemenu  = 'NBRPGArchives';

// Identification
$page_nom = "Consulte les archives du NBRPG";
$page_url = "pages/nbrpg/archives";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "NBRPG : Archives";
$page_desc  = "Sessions de jeu archivées du NoBlemeRPG";

// CSS & JS
$css  = array('onglets');
$js   = array('onglets');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>NoBlemeRPG : Archives</h1>

        <h5>Sessions de jeu soigneusement archivées pour la postérité</h5>

        <p>Vous trouverez sur cette page des logs bruts de sessions du <a class="gras" href="<?=$chemin?>pages/nbrpg/index">NoBlemeRPG</a>, c'est à dire qu'ils ne sont pas édités ni formatés. Les sessions archivées ici correspondent au dernier arc du jeu, en 2015, au cours duquel dix ans d'histoires entamées ont été achevées afin de conclure définitivement cette version du NBRPG.</p>

      </div>

      <br>
      <br>

      <div class="tableau">

        <ul class="onglet">
          <li>
            <a style="cursor: default;">CHOISISSEZ UNE SESSION :</a>
          </li>
          <li>
            <a id="28092015_onglet" class="bouton_onglet onglet_actif" onclick="ouvrirOnglet(event, '28092015')">28/09/2015</a>
          </li>
          <li>
            <a id="06102015_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, '06102015')">06/10/2015</a>
          </li>
          <li>
            <a id="15102015_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, '15102015')">15/10/2015</a>
          </li>
          <li>
            <a id="24102015_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, '24102015')">24/10/2015</a>
          </li>
          <li>
            <a id="25102015_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, '25102015')">25/10/2015</a>
          </li>
        </ul>
        <div id="28092015" class="contenu_onglet">
          <?=predata(file_get_contents($chemin.'pages/nbrpg/logs/nbrpg_2015-09-28.txt'), 1);?>
        </div>
        <div id="06102015" class="hidden contenu_onglet">
          <?=predata(file_get_contents($chemin.'pages/nbrpg/logs/nbrpg_2015-10-06.txt'), 1);?>
        </div>
        <div id="15102015" class="hidden contenu_onglet">
          <?=predata(file_get_contents($chemin.'pages/nbrpg/logs/nbrpg_2015-10-15.txt'), 1);?>
        </div>
        <div id="24102015" class="hidden contenu_onglet">
          <?=predata(file_get_contents($chemin.'pages/nbrpg/logs/nbrpg_2015-10-24.txt'), 1);?>
        </div>
        <div id="25102015" class="hidden contenu_onglet">
          <?=predata(file_get_contents($chemin.'pages/nbrpg/logs/nbrpg_2015-10-25.txt'), 1);?>
        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';