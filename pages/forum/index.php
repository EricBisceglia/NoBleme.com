<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'ForumIndex';

// Identification
$page_nom = "Parcourt les sujets de discussion du forum";
$page_url = "pages/forum/index";

// Lien court
$shorturl = "f";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Forum" : "Forum";
$page_desc  = "Liste des sujets actifs sur le forum NoBleme";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']            = "Forum NoBleme";
  $trad['soustitre']        = "Oui, il est réellement de retour";
  $trad['desc']             = <<<EOD
Bienvenue sur le <a class="gras" href="https://fr.wikipedia.org/wiki/Forum_(informatique)">forum de discussion</a> de NoBleme, un espace d'échange qui se veut convivial et ouvert à tous les individus et tous les sujets, tant que vous respectez notre <a class="gras" href="{$chemin}pages/doc/coc">code de conduite</a>. Le forum NoBleme est bilingue français/anglais et regroupe plusieurs catégories de conversation différentes, vous pouvez changer vos préférences de filtrage personnelles de langue et de catégories en cliquant sur le bouton ci-dessous.
EOD;
  $trad['options']          = "CLIQUEZ ICI POUR CHANGER VOS OPTIONS DE FILTRAGE ET/OU EFFECTUER UNE RECHERCHE";

  // Titres de la liste des sujets
  $trad['sujets_sujets']    = "SUJETS DE DISCUSSION";
  $trad['sujets_new']       = "+NOUVEAU";
  $trad['sujets_creation']  = "CRÉATION";
  $trad['sujets_reponses']  = "RÉPONSES";
  $trad['sujets_dernier']   = "DERNIER MESSAGE";

  // Pages de la liste des sujets
  $trad['sujets_affiches']  = "SUJETS AFFICHÉS SUR";
  $trad['sujets_plus']      = "CLIQUEZ ICI POUR EN CHARGER 50 DE PLUS";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <p><?=$trad['desc']?></p>

        <br>

        <button class="button button-outline"><?=$trad['options']?></button>

      </div>

      <br>
      <br>

      <div class="texte2">

        <table class="titresnoirs nowrap">

          <thead>
            <tr>
              <th colspan="2">
                <?=$trad['sujets_sujets']?> &nbsp;<a class="texte_positif pointeur" href="<?=$chemin?>pages/forum/new"><?=$trad['sujets_new']?></a>
              </th>
              <th class="nopadding">
                <?=$trad['sujets_creation']?>
              </th>
              <th class="moinsmaigre nopadding">
                <?=$trad['sujets_reponses']?>
              </th>
              <th class="nopadding">
                <?=$trad['sujets_dernier']?>
              </th>
            </tr>
          </thead>

          <tbody>

            <?php for($i=0;$i<50;$i++) { ?>
            <tr>

              <td>
                <img src="<?=$chemin?>img/icones/lang_<?=['fr', 'fr', 'fr', 'fr', 'en'][rand(0,4)];?>_clear.png" alt="FR" class="valign_table" height="20">
              </td>

              <td>

                <a class="gras" href="<?=$chemin?>pages/forum/sujet"><?=['Titre court', 'Salut !', 'Titre de message un peu long qui se fait couper...', 'Titre standard de sujet', 'Discutons politique', 'Parlons de pénis', 'Je suis ouvert à faire un débat les amis', 'The spoiling adventure version deux point zéro virgule c...'][rand(0,7)];?></a><br>

                <span class="gras texte_noir"><?=['Fil', 'Fil', 'Fil', 'Anonyme', 'Cascade', 'Cascade', 'Art'][rand(0,6)];?></span>

                <span class="texte_noir"><?=['- Débat', '- Sérieux', '', ''][rand(0,3)];?></span>

                <?=[' - NoBleme.com', ' - Politique', ''][rand(0,2)];?>

                <?php if(!rand(0,10)) { ?>
                <span class="gras neutre texte_blanc spaced">PRIVÉ</span>
                <?php } ?>

                <?php if(!rand(0,10)) { ?>
                <span class="gras negatif texte_blanc spaced">FERMÉ</span>
                <?php } ?>

                <?php if($i < 2) { ?>
                <span class="gras positif texte_blanc spaced">ÉPINGLÉ</span>
                <?php } ?>

              </td>

              <td class="align_center nopadding">
                <a class="pointeur"><?=['Bad', 'Planeshift', 'Pseudonyme long', 'Shalena', 'Bad', 'Trucy', 'Bruce'][rand(0,6)];?></a><br>
                <?=ilya(strtotime(rand(2016,2017).'-'.rand(1,10).'-'.rand(1,29)))?>
              </td>

              <td class="align_center texte_noir gras nopadding">
                <?=[0, rand(0,10), rand(0,100)][rand(0,2)];?><br>
              </td>

              <td class="align_center nopadding">
                <a class="pointeur"><?=['Bad', 'Planeshift', 'Pseudonyme long', 'Shalena', 'Bad', 'Trucy', 'Bruce'][rand(0,6)];?></a><br>
                <?=ilya(strtotime(rand(2016,2017).'-'.rand(1,10).'-'.rand(1,29)))?>
              </td>

            </tr>
            <?php } ?>

            <td colspan="5" class="align_center noir texte_blanc moinsgros gras pointeur">
              1-50 <?=$trad['sujets_affiches']?> <?=rand(100,1000)?> - <?=$trad['sujets_plus']?>
            </td>

          </tbody>
        </table>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';