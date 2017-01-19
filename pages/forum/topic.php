<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'discuter';
$header_submenu   = 'forum';

// Titre et description
$page_titre = "Forum";
$page_desc  = "Le forum NoBleme... plus ou moins";

// Identification
$page_nom = "forum";
$page_id  = "loljk";

// CSS & JS
$css = array('forum_loljk');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On dégage si c'est pas un topic ou new

if(!isset($_GET['id']) && !isset($_GET['new']))
  exit('id invalide');
if(isset($_GET['id']) && !is_numeric($_GET['id']))
  exit('id invalide');
if(isset($_GET['id']))
  $loljk_id = postdata($_GET['id']);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Envoi d'un message

if(isset($_POST['forumloljk_x']))
{
  // On assainit le postdata
  if(isset($_GET['new']))
    $add_titre  = postdata(substr($_POST['loljk_titre'],0,50));
  $add_contenu  = postdata($_POST['loljk_contenu']);

  // Si le titre est vide
  if(isset($_GET['new']) && !$add_titre)
    $add_titre = "Message";

  // Et on balance le message
  $add_timestamp  = time();
  $add_user       = $_SESSION['user'];
  if(isset($_GET['new']))
    query(" INSERT INTO forum_loljk
            SET         timestamp     = '$add_timestamp'  ,
                        threadparent  = 0                 ,
                        FKauteur      = '$add_user'       ,
                        titre         = '$add_titre'      ,
                        contenu       = '$add_contenu'    ");
  else
    query(" INSERT INTO forum_loljk
            SET         timestamp     = '$add_timestamp'  ,
                        threadparent  = '$loljk_id'       ,
                        FKauteur      = '$add_user'       ,
                        titre         = ''                ,
                        contenu       = '$add_contenu'    ");

  // Redirection si new
  if(isset($_GET['new']))
    header('Location: '.$chemin.'pages/forum/topic?id='.mysqli_insert_id($db));
}


/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Thread

if(isset($_GET['id']))
{
  $qthreadjk = query("  SELECT    forum_loljk.timestamp     ,
                                  forum_loljk.threadparent  ,
                                  forum_loljk.FKauteur      ,
                                  membres.pseudonyme        ,
                                  forum_loljk.titre         ,
                                  forum_loljk.contenu
                        FROM      forum_loljk
                        LEFT JOIN membres ON forum_loljk.FKauteur = membres.id
                        WHERE     ( forum_loljk.threadparent  = '$loljk_id'
                        OR          forum_loljk.id            = '$loljk_id' )
                        ORDER BY  forum_loljk.timestamp ASC ");

  for($nthreadjk = 0 ; $dthreadjk = mysqli_fetch_array($qthreadjk) ; $nthreadjk++)
  {
    // Titre du thread
    if(!$dthreadjk['threadparent'])
      $jk_titre = destroy_html($dthreadjk['titre']);

    // Préparation des données
    $jk_auteurid[$nthreadjk]  = $dthreadjk['FKauteur'];
    $jk_auteur[$nthreadjk]    = destroy_html($dthreadjk['pseudonyme']);
    $jk_date[$nthreadjk]      = "Le ".date("d/m/y à H:i:s",$dthreadjk['timestamp']);
    $jk_contenu[$nthreadjk]   = nl2br(destroy_html($dthreadjk['contenu']));

    // Troll
    $jk_bordelisateur = rand(0,10);
    if($dthreadjk['pseudonyme'] == "Wan" || $dthreadjk['pseudonyme'] == "Trucy")
      $jk_contenu[$nthreadjk] = '<img src="'.$chemin.'img/forumloljk/gorille_jk.png" alt="Gorille">';
    else if($dthreadjk['pseudonyme'] == "Shalena")
      $jk_contenu[$nthreadjk] = destroy_html(str_shuffle($jk_contenu[$nthreadjk]));
    else if($dthreadjk['pseudonyme'] == "OrCrawn")
      $jk_contenu[$nthreadjk] = "Putain ".strtolower($jk_contenu[$nthreadjk]);
    else if($dthreadjk['pseudonyme'] == "ThArGos")
      $jk_contenu[$nthreadjk] = "Ok";
    else if($dthreadjk['pseudonyme'] == "Planeshift")
    {
      if($jk_bordelisateur == 0)
        $jk_contenu[$nthreadjk] = "Alors en fait ".strtolower($jk_contenu[$nthreadjk])."... mais bon.";
      if($jk_bordelisateur == 1)
        $jk_contenu[$nthreadjk] = "Bad est mon idole.";
      if($jk_bordelisateur == 2)
        $jk_contenu[$nthreadjk] = "J'aime les frites";
      if($jk_bordelisateur == 3)
        $jk_contenu[$nthreadjk] = "NoBleme est cool, mais ".strtolower($jk_contenu[$nthreadjk]);
      if($jk_bordelisateur == 4)
        $jk_contenu[$nthreadjk] = "J'aime le nombre 10";
      if($jk_bordelisateur == 5)
        $jk_contenu[$nthreadjk] = "Putain c'est quoi ce bordel";
      if($jk_bordelisateur == 6)
        $jk_contenu[$nthreadjk] = "C'est quoi tous ces shitposts ??";
    }
    else if($dthreadjk['pseudonyme'] == "Exirel")
      $jk_contenu[$nthreadjk] = "Full stack ".strtolower($jk_contenu[$nthreadjk]);
    else if($dthreadjk['pseudonyme'] == "Kutz")
      $jk_contenu[$nthreadjk] = "Ach so, ".strtolower($jk_contenu[$nthreadjk]);
    else if($dthreadjk['pseudonyme'] == "MoitiePlus")
      $jk_contenu[$nthreadjk] = $jk_contenu[$nthreadjk].".. Et une bite.";
    else if($dthreadjk['pseudonyme'] == "Plow")
      $jk_contenu[$nthreadjk] = "Est-ce que les asiatiques ont des petites bites ? Aidez moi svp je sais vriment pas :v";
  }
}


/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <a href="<?=$chemin?>pages/forum/index">
        <img src="<?=$chemin?>img/forumloljk/forum_jk.png" alt="Le forum nobleme xd">
      </a>
    </div>
    <br>

    <?php if(isset($_GET['id'])) { ?>

    <div class="body_main midsize">

      <table class="indiv">
        <tr>
          <td class="cadre_gris_titre gros gras comicsans" colspan="2">
            <?=$jk_titre?>
          </td>
        </tr>

        <?php for($i=0;$i<$nthreadjk;$i++) { ?>
        <tr>
          <td colspan="2">
            <hr>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris newgauche_jk spaced vspaced align_center comicsans">
            <a class="dark blank moinsgros gras" href="<?=$chemin?>pages/user/user?id=<?=$jk_auteurid[$i]?>" ><?=$jk_auteur[$i]?></a><br>
            <?=$jk_date[$i]?>
          </td>
          <td class="cadre_gris spaced vspaced comicsans" style="color:#<?=substr(md5(rand()), 0, 6);?>">
            <?=$jk_contenu[$i]?>
          </td>
        </tr>
        <?php } ?>

      </table>
    </div>

    <?php } ?>

    <?php if(loggedin()) { ?>

    <div class="body_main midsize">

      <?php if(isset($_GET['new'])) { ?>
      <form id="forumloljk" method="POST" action="topic?new">
      <?php } else { ?>
      <form id="forumloljk" method="POST" action="topic?id=<?=$loljk_id?>">
      <?php } ?>
        <table class="indiv">

          <?php if(isset($_GET['new'])) { ?>

          <tr>
            <td class="align_right spaced comicsans moinsgros gras newgauche_jk">
              Titre du message :
            </td>
            <td>
              <input name="loljk_titre" class="intable comicsans">
            </td>
          </tr>
          <tr>
            <td class="align_right spaced comicsans moinsgros gras newgauche_jk">
              Contenu du message :
            </td>
            <td>
              <textarea name="loljk_contenu" class="intable comicsans" rows="10"></textarea>
            </td>
          </tr>

          <?php } else { ?>

          <tr>
            <td>
              <span class="comicsans gros gras alinea">Répondre à la conversation :</span><br><br>
              <textarea name="loljk_contenu" class="intable comicsans" rows="10"></textarea>
            </td>
          </tr>

          <?php } ?>

          <tr>
            <td class="align_center" colspan="2">
              <br><br>
              <input type="image" src="<?=$chemin?>img/forumloljk/loljk_envoyer.png" alt="envoyer le message" name="forumloljk">
            </td>
          </tr>

        </table>
      </form>

    </div>

    <?php } else { ?>

    <div class="body_main midsize">
      <span class="titre">Vous devez être connecté sur un compte pour pouvoir poster sur le forum</span>
    </div>

    <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';