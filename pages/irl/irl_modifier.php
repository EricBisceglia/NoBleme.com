<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
sysoponly($lang, 'irl');

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'IRL';

// Identification
$page_nom = "Observe de loin les IRL";
$page_url = "pages/irl/index";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = (!isset($_GET['id'])) ? "Créer une IRL" : "Modifier une IRL";

// CSS & JS
$css  = array('irl');
$js   = array('dynamique', 'irl/previsualiser_irl');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Détermination de ce qu'on est en train de faire sur cette page

// Si un ID existe, on va chercher s'il correspond à une IRL existante et c'est une modification
if(isset($_GET['id']))
{
  $irl_id = postdata($_GET['id'], 'int', 0);
  $qcheckirl = mysqli_fetch_array(query(" SELECT  irl.id
                                          FROM    irl
                                          WHERE   irl.id = '$irl_id' "));
  if(!$qcheckirl['id'])
    exit(header("Location: ".$chemin."pages/irl/index"));
  $irl_hidden = '';
}
// Sinon, on met 0 comme ID et c'est un ajout
else
{
  $irl_id = 0;
  $irl_hidden = ' class="hidden"';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Assainissement du postdata

if(isset($_POST['irl_add_go']) || isset($_POST['irl_edit_go']))
{
  $irl_edit_date        = mysqldate(postdata_vide('irl_edit_date', 'string', ''));
  $irl_edit_lieu        = postdata_vide('irl_edit_lieu', 'string', '', 20);
  $irl_edit_raison_fr   = postdata_vide('irl_edit_raison_fr', 'string', '', 35);
  $irl_edit_raison_en   = postdata_vide('irl_edit_raison_en', 'string', '', 35);
  $irl_edit_details_fr  = postdata_vide('irl_edit_details_fr', 'string', '');
  $irl_edit_details_en  = postdata_vide('irl_edit_details_en', 'string', '');
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'une nouvelle IRL

if(isset($_POST['irl_add_go']) && getmod('irl'))
{
  // On crée l'IRL
  query(" INSERT INTO irl
          SET         irl.date        = '$irl_edit_date'        ,
                      irl.lieu        = '$irl_edit_lieu'        ,
                      irl.raison_fr   = '$irl_edit_raison_fr '  ,
                      irl.raison_en   = '$irl_edit_raison_en '  ,
                      irl.details_fr  = '$irl_edit_details_fr'  ,
                      irl.details_en  = '$irl_edit_details_en'  ");

  // Activité récente
  $irl_id       = mysqli_insert_id($db);
  $action_titre = postdata(jourfr($irl_edit_date), 'string');
  activite_nouveau('irl_new', 0, 0, NULL, $irl_id, $action_titre);

  // Log de modération
  $sysop = postdata(getpseudo(), 'string');
  activite_nouveau('irl_new', 1, 0, $sysop, $irl_id, $action_titre);

  // Bot IRC
  $date_irl     = datefr($irl_edit_date);
  $date_irl_en  = datefr($irl_edit_date, 'EN');
  ircbot($chemin, "Nouvelle IRL planifiée le ".$date_irl.": ".$GLOBALS['url_site']."pages/irl/irl?id=".$irl_id, "#NoBleme");
  ircbot($chemin, "New real life meetup planned : ".$date_irl_en." - ".$GLOBALS['url_site']."pages/irl/irl?id=".$irl_id, "#english");

  // Redirection
  exit(header("Location: ".$chemin."pages/irl/irl?id=".$irl_id));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification d'une IRL existante

if(isset($_POST['irl_edit_go']) && getmod('irl'))
{
  // On va chercher des infos sur l'IRL
  $qcheckirl = mysqli_fetch_array(query(" SELECT  irl.date        ,
                                                  irl.lieu        ,
                                                  irl.raison_fr   ,
                                                  irl.raison_en   ,
                                                  irl.details_fr  ,
                                                  irl.details_en
                                          FROM    irl
                                          WHERE   irl.id = '$irl_id' "));

  // On prépare les infos sur l'IRL pour le diff
  $irl_avant_date       = mysqldate(postdata($qcheckirl['date'], 'string', ''));
  $irl_avant_lieu       = postdata($qcheckirl['lieu'], 'string', '');
  $irl_avant_raison_fr  = postdata($qcheckirl['raison_fr'], 'string', '');
  $irl_avant_raison_en  = postdata($qcheckirl['raison_en'], 'string', '');
  $irl_avant_details_fr = postdata($qcheckirl['details_fr'], 'string', '');
  $irl_avant_details_en = postdata($qcheckirl['details_en'], 'string', '');

  // On modifie l'IRL
  query(" UPDATE  irl
          SET     irl.date        = '$irl_edit_date'        ,
                  irl.lieu        = '$irl_edit_lieu'        ,
                  irl.raison_fr   = '$irl_edit_raison_fr '  ,
                  irl.raison_en   = '$irl_edit_raison_en '  ,
                  irl.details_fr  = '$irl_edit_details_fr'  ,
                  irl.details_en  = '$irl_edit_details_en'
          WHERE   irl.id          = '$irl_id' ");

  // Log de modération
  $action_titre = postdata(jourfr($irl_edit_date), 'string');
  $sysop        = postdata(getpseudo(), 'string');
  $activite_id  = activite_nouveau('irl_edit', 1, 0, $sysop, $irl_id, $action_titre);

  // Diff
  activite_diff($activite_id, 'Date'          , $irl_avant_date       , $irl_edit_date        , 1);
  activite_diff($activite_id, 'Lieu'          , $irl_avant_lieu       , $irl_edit_lieu        , 1);
  activite_diff($activite_id, 'Raison (fr)'   , $irl_avant_raison_fr  , $irl_edit_raison_fr   , 1);
  activite_diff($activite_id, 'Raison (en)'   , $irl_avant_raison_en  , $irl_edit_raison_en   , 1);
  activite_diff($activite_id, 'Détails (fr)'  , $irl_avant_details_fr , $irl_edit_details_fr  , 1);
  activite_diff($activite_id, 'Détails (en)'  , $irl_avant_details_en , $irl_edit_details_en  , 1);

  // Redirection
  exit(header("Location: ".$chemin."pages/irl/irl?id=".$irl_id));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si c'est une modification, on va chercher les infos de l'IRL pour pré-remplir les champs
if($irl_id)
{
  // On va chercher les infos
  $qirledit = mysqli_fetch_array(query("  SELECT  irl.date        ,
                                                  irl.lieu        ,
                                                  irl.raison_fr   ,
                                                  irl.raison_en   ,
                                                  irl.details_fr  ,
                                                  irl.details_en
                                          FROM    irl
                                          WHERE   irl.id = '$irl_id' "));

  // Et on les prépare pour l'affichage
  $irl_edit_date        = ddmmyy(predata($qirledit['date']));
  $irl_edit_lieu        = predata($qirledit['lieu']);
  $irl_edit_raison_fr   = predata($qirledit['raison_fr']);
  $irl_edit_raison_en   = predata($qirledit['raison_en']);
  $irl_edit_details_fr  = predata($qirledit['details_fr']);
  $irl_edit_details_en  = predata($qirledit['details_en']);
  $irl_previsualiser_fr = bbcode(predata($qirledit['details_fr'], 1));
  $irl_previsualiser_en = bbcode(predata($qirledit['details_en'], 1));
}
// Sinon, on met tous les champs à zéro
else
{
  $irl_edit_date        = "";
  $irl_edit_lieu        = "";
  $irl_edit_raison_fr   = "";
  $irl_edit_raison_en   = "";
  $irl_edit_details_fr  = "";
  $irl_edit_details_en  = "";
  $irl_previsualiser_fr = "";
  $irl_previsualiser_en = "";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <?php if(!$irl_id) { ?>

        <h1>Organiser une nouvelle IRL</h1>

        <p>
          <span class="gras souligne">Note préalable:</span> Idéalement, il faut discuter de l'IRL avant de la créer. Soit avoir une bonne raison de l'organiser (ex: quelqu'un passe dans une ville tel jour, donc on fait une IRL ce jour-là), soit avoir un consensus par avance pour la date (ex: 5 personnes ont dit ok ce jour-là je veux bien IRL, maintenant on peut la créer).
        </p>

        <br>
        <br>

        <?php } else { ?>

        <h1>Modifier une IRL</h1>

        <?php } ?>

        <form method="POST">

          <fieldset>

            <h5>Infos générales pour le tableau des IRL</h5>
            <br>

            <label for="irl_edit_date">Date de l'IRL au format dd/mm/yy ou dd/mm/YYYY (ex: 19/03/2005)</label>
            <input id="irl_edit_date" name="irl_edit_date" class="indiv" type="text" value="<?=$irl_edit_date?>"><br>
            <br>

            <label for="irl_edit_lieu">Lieu de l'IRL (rester très concis, juste un nom de ville si possible, 20 caractères max)</label>
            <input id="irl_edit_lieu" name="irl_edit_lieu" class="indiv" type="text" maxlength="20" value="<?=$irl_edit_lieu?>"><br>
            <br>

            <label for="irl_edit_raison_fr">Raison de l'organisation de l'IRL en français (optionnel) (rester très court/concis, 35 caractères max)</label>
            <input id="irl_edit_raison_fr" name="irl_edit_raison_fr" class="indiv" type="text" maxlength="35" value="<?=$irl_edit_raison_fr?>"><br>
            <br>

            <label for="irl_edit_raison_en">Raison de l'organisation de l'IRL en anglais (optionnel) (rester très court/concis, 35 caractères max)</label>
            <input id="irl_edit_raison_en" name="irl_edit_raison_en" class="indiv" type="text" maxlength="35" value="<?=$irl_edit_raison_en?>"><br>
            <br>
            <br>

            <h5>Infos détaillées pour la page de l'IRL</h5>

            <p>
              Il faut penser à répondre aux questions suivantes:<br>
              * Où à lieu l'IRL ?<br>
              * Quel jour à lieu l'IRL ?<br>
              * Où et quand est-ce qu'on se retrouve ?<br>
              * Quel est le programme de l'IRL ?<br>
              Dans le doute, le plus simple est de prendre exemple sur ce qui a déjà été rempli dans une IRL passée.
            </p>

            <br>

            <label for="irl_edit_details_fr">Détails/instructions en français (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> autorisés)</label>
            <textarea id="irl_edit_details_fr" name="irl_edit_details_fr" class="indiv irl_details" onkeyup="previsualiser_irl('<?=$chemin?>');"><?=$irl_edit_details_fr?></textarea><br>
            <br>

            <div id="irl_previsualisation_fr_container"<?=$irl_hidden?>>
              <label>Prévisualisation en direct:</label>
              <div class="vscrollbar irl_previsualisation" id="irl_previsualisation_fr">
                <?=$irl_previsualiser_fr?>
              </div>
              <br>
            </div>

            <label for="irl_edit_details_en">Détails/instructions en anglais (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> autorisés)</label>
            <textarea id="irl_edit_details_en" name="irl_edit_details_en" class="indiv irl_details" onkeyup="previsualiser_irl('<?=$chemin?>');"><?=$irl_edit_details_en?></textarea><br>
            <br>

            <div id="irl_previsualisation_en_container"<?=$irl_hidden?>>
              <label>Prévisualisation en direct:</label>
              <div class="vscrollbar irl_previsualisation" id="irl_previsualisation_en">
                <?=$irl_previsualiser_en?>
              </div>
              <br>
            </div>

            <?php if(!$irl_id) { ?>
            <input value="CRÉER UNE NOUVELLE IRL" type="submit" name="irl_add_go">
            <?php } else { ?>
            <input value="MODIFIER LES INFOS DE L'IRL" type="submit" name="irl_edit_go">
            <?php } ?>

          </fieldset>

        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';