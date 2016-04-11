<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Liste des tâches";
$page_desc  = "Liste des tâches accomplies et/ou à accomplir dans le développement de NoBleme";

// Identification
$page_nom = "todo";
$page_id  = "index";

// CSS & JS
$css = array('todo');
$js  = array('dynamique','toggle');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Si un ticket en particulier est ouvert

if(isset($_GET['id']) && is_numeric($_GET['id']))
{
  // On assainit
  $todoid = postdata($_GET['id']);

  // On vérifie qu'il existe
  $testid = query(" SELECT id FROM todo WHERE id = '$todoid' ");
  if(!mysqli_num_rows($testid))
    erreur("Ticket inexistant");
}
else
  $todoid = '';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recherches

if(isset($_POST['search_id']))
{
  $search_id          = destroy_html($_POST['search_id']);
  $search_titre       = destroy_html($_POST['search_titre']);
  $search_createur    = destroy_html($_POST['search_createur']);
  $search_resolution  = postdata($_POST['search_resolution']);
  $search_importance  = postdata($_POST['search_importance']);
  $search_categorie   = postdata($_POST['search_categorie']);
  $search_objectif    = postdata($_POST['search_objectif']);
  $search_reponses    = postdata($_POST['search_reponses']);
  if(loggedin() && getadmin() && !isset($_GET['noadmin']))
  {
    $search_valide    = postdata($_POST['search_valide']);
    $search_public    = postdata($_POST['search_public']);
  }
}
else
{
  $search_id          = $todoid;
  $search_titre       = '';
  $search_createur    = '';
  $search_resolution  = (isset($_GET['solved'])) ? 2 : ((isset($_GET['recent']) || $todoid) ? 0 : 1);
  $search_importance  = -1;
  $search_categorie   = 0;
  $search_objectif    = 0;
  $search_reponses    = 0;
  if(loggedin() && getadmin() && !isset($_GET['noadmin']))
  {
    $search_valide    = (isset($_GET['admin'])) ? 0 : -1;
    $search_public    = -1;
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contenu de la liste des tâches

// On va chercher les tickets et le contenu lié
$qtodo = "    SELECT    todo.id                   ,
                        todo.titre                ,
                        todo.FKmembres            ,
                        membres.pseudonyme        ,
                        todo.timestamp            ,
                        todo.timestamp_fini       ,
                        todo.importance           ,
                        todo.FKtodo_categorie     ,
                        todo_categorie.categorie  ,
                        todo.FKtodo_roadmap       ,
                        todo_roadmap.version      ,
                        todo.valide_admin         ,
                        todo.public               ,
                        todo.contenu              ,
                        todo.source               ,
                        COUNT(todo_commentaire.id) AS 'commentaires'

              FROM      todo
              LEFT JOIN membres           ON todo.FKmembres         = membres.id
              LEFT JOIN todo_categorie    ON todo.FKtodo_categorie  = todo_categorie.id
              LEFT JOIN todo_roadmap      ON todo.FKtodo_roadmap    = todo_roadmap.id
              LEFT JOIN todo_commentaire  ON todo.id                = todo_commentaire.FKtodo
              WHERE     1=1 ";

// On affiche que les tickets publics si on est pas en mode admin
if(!loggedin() || !getadmin() || isset($_GET['noadmin']))
  $qtodo .= " AND todo.public = 1 ";

// Si id est set, on chope que le ticket qu'on veut
if($todoid && !isset($_POST['search_id']))
  $qtodo .= " AND todo.id = '$todoid' ";

// Recherches via le tableau
if($search_id)
  $qtodo .= " AND todo.id = '".postdata($search_id)."'";
if($search_titre)
  $qtodo .= " AND todo.titre LIKE '%".postdata($search_titre)."%'";
if($search_createur)
  $qtodo .= " AND membres.pseudonyme LIKE '%".postdata($search_createur)."%'";
if($search_resolution == 1)
  $qtodo .= " AND todo.timestamp_fini = 0 ";
else if($search_resolution == 2)
  $qtodo .= " AND todo.timestamp_fini != 0 ";
if($search_importance >= 0)
  $qtodo .= " AND todo.importance = '$search_importance' ";
if($search_categorie)
  $qtodo .= " AND todo.FKtodo_categorie = '$search_categorie' ";
if($search_objectif)
  $qtodo .= " AND todo.FKtodo_roadmap = '$search_objectif' ";
if($search_reponses == 1)
  $qtodo .= " AND todo_commentaire.id IS NOT NULL ";
else if($search_reponses == 2)
  $qtodo .= " AND todo_commentaire.id IS NULL ";
if(loggedin() && getadmin() && !isset($_GET['noadmin']))
{
  if($search_valide >= 0)
    $qtodo .= " AND todo.valide_admin = '$search_valide' ";
  if($search_public >= 0)
    $qtodo .= " AND todo.public = '$search_public' ";
}

// Pour pas casser la requête avec le count des commentaires
$qtodo .= "   GROUP BY todo.id ";

// Ordre de tri
if(isset($_GET['recent']))
  $qtodo .= " ORDER BY  todo.timestamp DESC ";
else if(isset($_GET['solved']))
  $qtodo .= " ORDER BY  todo.timestamp_fini DESC ";
else
  $qtodo .= " ORDER BY  todo.importance DESC ,
                        todo.timestamp  ASC ";

// On balance la requête
$qtodo = query($qtodo);

// Préparation des données à l'affichage
for($ntodo = 0 ; $dtodo = mysqli_fetch_array($qtodo) ; $ntodo++)
{
  $todo_id[$ntodo]              = $dtodo['id'];
  $todo_importance_css[$ntodo]  = (!$dtodo['timestamp_fini']) ? 'todo_importance_'.$dtodo['importance'] : 'todo_resolu';
  $todo_titre[$ntodo]           = (strlen(html_entity_decode($dtodo['titre'])) > 30) ? destroy_html(substr(html_entity_decode($dtodo['titre']),0,28).'...') : $dtodo['titre'];
  $todo_createur[$ntodo]        = $dtodo['pseudonyme'];
  $todo_creation[$ntodo]        = ilya($dtodo['timestamp']);
  $todo_resolution[$ntodo]      = ($dtodo['timestamp_fini']) ? ilya($dtodo['timestamp_fini']) : '';
  $todo_importance[$ntodo]      = todo_importance($dtodo['importance'],1);
  $todo_categorie[$ntodo]       = ($dtodo['FKtodo_categorie']) ? $dtodo['categorie'] : '';
  $todo_objectif[$ntodo]        = ($dtodo['FKtodo_roadmap']) ? $dtodo['version'] : '';
  $todo_commentaires[$ntodo]    = ($dtodo['commentaires']) ? $dtodo['commentaires'] : '';
  $todo_valide[$ntodo]          = ($dtodo['valide_admin']) ? '' : 'non';
  $todo_valider_texte[$ntodo]   = ($dtodo['valide_admin']) ? 'Modifier' : 'Valider';
  $todo_refuser_texte[$ntodo]   = ($dtodo['valide_admin']) ? 'Supprimer' : 'Refuser';
  $todo_public[$ntodo]          = ($dtodo['public']) ? '' : 'privé';
  $todo_titre_complet[$ntodo]   = $dtodo['titre'];
  $todo_createur_id[$ntodo]     = $dtodo['FKmembres'];
  $todo_date_complete[$ntodo]   = jourfr(date('Y-m-d',$dtodo['timestamp']));
  $todo_date_resolution[$ntodo] = ($dtodo['timestamp_fini']) ? '<br>Résolu depuis le '.jourfr(date('Y-m-d',$dtodo['timestamp_fini'])) : '';
  $todo_source[$ntodo]          = ($dtodo['source']) ? '<br><a class="dark blank" href="'.destroy_html($dtodo['source']).'" target="_blank">Cliquez ici pour voir le code source du patch</a>' : '';
  $todo_contenu[$ntodo]         = bbcode(nl2br_fixed($dtodo['contenu']));

  // Si y'a des commentaires, on va les chercher
  if($dtodo['commentaires'])
  {
    // Requête pour chercher les commentaires
    $idtodotemp = $dtodo['id'];
    $qcomm = query("  SELECT    todo_commentaire.id         ,
                                todo_commentaire.FKmembres  ,
                                membres.pseudonyme          ,
                                todo_commentaire.timestamp  ,
                                todo_commentaire.contenu
                      FROM      todo_commentaire
                      LEFT JOIN membres ON todo_commentaire.FKmembres = membres.id
                      WHERE     todo_commentaire.FKtodo = '$idtodotemp'
                      ORDER BY  todo_commentaire.timestamp ASC ");

    // Préparation des données
    for($ncomm = 0 ; $dcomm = mysqli_fetch_array($qcomm) ; $ncomm++)
    {
      $comm_id[$ntodo][$ncomm]          = $dcomm['id'];
      $comm_date[$ntodo][$ncomm]        = jourfr(date('Y-m-d',$dcomm['timestamp']));
      $comm_date_ilya[$ntodo][$ncomm]   = lcfirst(ilya($dcomm['timestamp']));
      $comm_auteur_id[$ntodo][$ncomm]   = $dcomm['FKmembres'];
      $comm_auteur[$ntodo][$ncomm]      = $dcomm['pseudonyme'];
      $comm_contenu[$ntodo][$ncomm]     = bbcode(nl2br_fixed($dcomm['contenu']));
      $comm_contenu_raw[$ntodo][$ncomm] = $dcomm['contenu'];
    }
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menus déroulants de recherche

// Résolution
$select_resolution = '';
if(!$search_resolution)
  $select_resolution .= '<option value="0" selected>Tous</option>';
else
  $select_resolution .= '<option value="0">Tous</option>';
if($search_resolution == 1)
  $select_resolution .= '<option value="1" selected>Ouverts</option>';
else
  $select_resolution .= '<option value="1">Ouverts</option>';
if($search_resolution == 2)
  $select_resolution .= '<option value="2" selected>Résolus</option>';
else
  $select_resolution .= '<option value="2">Résolus</option>';


// Importance
$select_importance = '';
if(!$search_importance)
  $select_importance .= '<option value="-1" selected>Tous</option>';
else
  $select_importance .= '<option value="-1">Tous</option>';
for($i=5;$i>=0;$i--)
{
  if($search_importance == $i)
    $select_importance .= '<option class="todo_importance_'.$i.'" value="'.$i.'" selected>'.todo_importance($i).'</option>';
  else
    $select_importance .= '<option class="todo_importance_'.$i.'" value="'.$i.'">'.todo_importance($i).'</option>';
}


// Catégorie
$select_categorie = '';
if(!$search_categorie)
  $select_categorie .= '<option value="0" selected>Tous</option>';
else
  $select_categorie .= '<option value="0">Tous</option>';
$qcategories = query(" SELECT id, categorie FROM todo_categorie ORDER BY categorie ASC ");
while($dcategories = mysqli_fetch_array($qcategories))
{
  if($search_categorie == $dcategories['id'])
    $select_categorie .= '<option value="'.$dcategories['id'].'" selected>'.$dcategories['categorie'].'</option>';
  else
    $select_categorie .= '<option value="'.$dcategories['id'].'">'.$dcategories['categorie'].'</option>';
}


// Objectif
$select_objectif = '';
if(!$search_objectif)
  $select_objectif .= '<option value="0" selected>Tous</option>';
else
  $select_objectif .= '<option value="0">Tous</option>';
$qroadmap = query(" SELECT id, version FROM todo_roadmap ORDER BY id_classement DESC ");
while($droadmap = mysqli_fetch_array($qroadmap))
{
  if($search_objectif == $droadmap['id'])
    $select_objectif .= '<option value="'.$droadmap['id'].'" selected>'.$droadmap['version'].'</option>';
  else
    $select_objectif .= '<option value="'.$droadmap['id'].'">'.$droadmap['version'].'</option>';
}


// Commentaires
$select_reponses = '';
if(!$search_reponses)
  $select_reponses .= '<option value="0" selected>Tous</option>';
else
  $select_reponses .= '<option value="0">Tous</option>';
if($search_reponses == 1)
  $select_reponses .= '<option value="1" selected>Avec</option>';
else
  $select_reponses .= '<option value="1">Avec</option>';
if($search_reponses == 2)
  $select_reponses .= '<option value="2" selected>Sans</option>';
else
  $select_reponses .= '<option value="2">Sans</option>';


if(loggedin() && getadmin() && !isset($_GET['noadmin']))
{
  // Validé admin
  $select_valide = '';
  if($search_valide == -1)
    $select_valide .= '<option value="-1" selected>Tous</option>';
  else
    $select_valide .= '<option value="-1">Tous</option>';
  if($search_valide == 1)
    $select_valide .= '<option value="1" selected>Oui</option>';
  else
    $select_valide .= '<option value="1">Oui</option>';
  if($search_valide == 0)
    $select_valide .= '<option value="0" selected>Non</option>';
  else
    $select_valide .= '<option value="0">Non</option>';


  // Public
  $select_public = '';
  if($search_public == -1)
    $select_public .= '<option value="-1" selected>Tous</option>';
  else
    $select_public .= '<option value="-1">Tous</option>';
  if($search_public == 1)
    $select_public .= '<option value="1" selected>Public</option>';
  else
    $select_public .= '<option value="1">Public</option>';
  if($search_public == 0)
    $select_public .= '<option value="0" selected>Privé</option>';
  else
    $select_public .= '<option value="0">Privé</option>';
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!isset($_GET['dynamique'])) { /* Ne pas afficher les données dynamiques dans la page normale */ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/todo.png" alt="Liste des tâches">
    </div>
    <br>

    <?php if(!loggedin() || !getadmin() || isset($_GET['noadmin'])) { ?>
    <div class="body_main midsize">
      <span class="titre">Tickets ouverts : Bugs et features</span><br>
      <br>
      Ci-dessous, une liste de tickets pouvant être des rapports de bugs, demandes de features, ou autres tâches en rapport avec NoBleme.<br>
      Chaque ticket représente une tâche à accomplir ou accomplie dans le développement de NoBleme.<br>
      <br>
      La seconde ligne du tableau (entre les titres et le premier ticket) contient des champs permettant d'effectuer des recherches.<br>
      Il vous suffit de remplir un champ de texte ou changer la valeur d'un menu déroulant pour que la recherche s'effectue automatiquement.<br>
      <br>
      Pour consulter les détails d'un ticket, cliquez dessus dans le tableau et des détails apparaitront.<br>
      Vous pouvez également poster des commentaires sur les tickets si vous disposez d'un compte et êtes connecté à votre compte.<br>
      <br>
      Finalement, si vous désirez ouvrir un ticket pour rapporter un bug ou proposer un feature, vous pouvez le faire en <a href="<?=$chemin?>pages/todo/add">cliquant ici</a>.
      <script type="text/javascript">
        document.write('<br>'); // Cette ruse est pour que la balise noscript qui suive soit validée WC3 :>
      </script>
      <noscript>
        <br>
        <br>
        <div class="gros gras align_center erreur texte_blanc intable">
          <br>
          Le JavaScript est désactivé sur votre navigateur.<br>
          <br>
          Le JavaScript doit être activé pour utiliser toutes les fonctionnalités de la page !<br>
          <br>
        </div>
      </noscript>
    </div>
    <br>
    <?php } ?>

    <?php if(loggedin() && getadmin()) { ?>
    <div class="body_main todo_miniadmin align_center">
      <?php if(isset($_GET['noadmin'])) { ?>
      <a class="dark blank gros gras" href="<?=$chemin?>pages/todo/index">Basculer en mode administrateur</a>
      <?php } else { ?>
      <a class="dark blank gros gras" href="<?=$chemin?>pages/todo/index?noadmin">Basculer en mode utilisateur</a>
      <?php } ?>
    </div>
    <br>
    <?php } ?>

    <?php if(loggedin() && getadmin() && !isset($_GET['noadmin'])) { ?>
    <div class="body_main todo_adminmode">
    <?php } else { ?>
    <div class="body_main bigsize">
    <?php } ?>
      <form id="todo" method="POST" action="<?=$url_complete?>">

        <table class="indiv cadre_gris">

          <tr>
            <td class="cadre_gris_titre spaced">
              ID
            </td>
            <td class="cadre_gris_titre spaced">
              Titre
            </td>
            <td class="cadre_gris_titre spaced">
              Créateur
            </td>
            <td class="cadre_gris_titre spaced">
              Création
            </td>
            <td class="cadre_gris_titre spaced">
              Résolution
            </td>
            <td class="cadre_gris_titre spaced">
              Importance
            </td>
            <td class="cadre_gris_titre spaced">
              Catégorie
            </td>
            <td class="cadre_gris_titre spaced">
              Objectif
            </td>
            <td class="cadre_gris_titre spaced">
              Réponses
            </td>
            <?php if(loggedin() && getadmin() && !isset($_GET['noadmin'])) { ?>
            <td class="cadre_gris_titre spaced">
              Validé
            </td>
            <td class="cadre_gris_titre spaced">
              Public
            </td>
            <?php } ?>
          </tr>

          <tr>
            <td class="cadre_gris">
              <input class="intable discret nobleme_background texte_nobleme_fonce gras align_center" name="search_id" value="<?=$search_id?>" onChange="document.getElementById('todo').submit()">
            </td>
            <td class="cadre_gris">
              <input class="intable discret nobleme_background texte_nobleme_fonce gras align_center" name="search_titre" value="<?=$search_titre?>" onChange="document.getElementById('todo').submit()">
            </td>
            <td class="cadre_gris">
              <input class="intable discret nobleme_background texte_nobleme_fonce gras align_center" name="search_createur" value="<?=$search_createur?>" onChange="document.getElementById('todo').submit()">
            </td>
            <td class="cadre_gris nobleme_background">
              &nbsp;
            </td>
            <td class="cadre_gris">
              <select class="intable discret nobleme_background texte_nobleme_fonce gras align_center" name="search_resolution" onChange="document.getElementById('todo').submit()">
                <?=$select_resolution?>
              </select>
            </td>
            <td class="cadre_gris">
              <select class="intable discret nobleme_background texte_nobleme_fonce gras align_center" name="search_importance" onChange="document.getElementById('todo').submit()">
                <?=$select_importance?>
              </select>
            </td>
            <td class="cadre_gris">
              <select class="intable discret nobleme_background texte_nobleme_fonce gras align_center" name="search_categorie" onChange="document.getElementById('todo').submit()">
                <?=$select_categorie?>
              </select>
            </td>
            <td class="cadre_gris">
              <select class="intable discret nobleme_background texte_nobleme_fonce gras align_center" name="search_objectif" onChange="document.getElementById('todo').submit()">
                <?=$select_objectif?>
              </select>
            </td>
            <td class="cadre_gris">
              <select class="intable discret nobleme_background texte_nobleme_fonce gras align_center" name="search_reponses" onChange="document.getElementById('todo').submit()">
                <?=$select_reponses?>
              </select>
            </td>
            <?php if(loggedin() && getadmin() && !isset($_GET['noadmin'])) { ?>
            <td class="cadre_gris">
              <select class="intable discret nobleme_background texte_nobleme_fonce gras align_center" name="search_valide" onChange="document.getElementById('todo').submit()">
                <?=$select_valide?>
              </select>
            </td>
            <td class="cadre_gris">
              <select class="intable discret nobleme_background texte_nobleme_fonce gras align_center" name="search_public" onChange="document.getElementById('todo').submit()">
                <?=$select_public?>
              </select>
            </td>
            <?php } ?>
          </tr>

          <?php for($i=0;$i<$ntodo;$i++) { ?>
          <tr onClick="toggle_row('todo_row<?=$todo_id[$i]?>');">
            <td class="cadre_gris align_center pointeur gras spaced <?=$todo_importance_css[$i]?>">
              #<?=$todo_id[$i]?>
            </td>
            <td class="cadre_gris align_center pointeur gras nowrap spaced todo_encours <?=$todo_importance_css[$i]?>">
              <?=$todo_titre[$i]?>
            </td>
            <td class="cadre_gris align_center pointeur nowrap spaced <?=$todo_importance_css[$i]?>">
              <?=$todo_createur[$i]?>
            </td>
            <td class="cadre_gris align_center pointeur nowrap spaced <?=$todo_importance_css[$i]?>">
              <?=$todo_creation[$i]?>
            </td>
            <td class="cadre_gris align_center pointeur nowrap spaced <?=$todo_importance_css[$i]?>">
              <?=$todo_resolution[$i]?>
            </td>
            <td class="cadre_gris align_center pointeur nowrap spaced <?=$todo_importance_css[$i]?>">
              <?=$todo_importance[$i]?>
            </td>
            <td class="cadre_gris align_center pointeur nowrap spaced <?=$todo_importance_css[$i]?>">
              <?=$todo_categorie[$i]?>
            </td>
            <td class="cadre_gris align_center pointeur nowrap spaced <?=$todo_importance_css[$i]?>">
              <?=$todo_objectif[$i]?>
            </td>
            <td class="cadre_gris align_center pointeur nowrap spaced gras <?=$todo_importance_css[$i]?>">
              <?=$todo_commentaires[$i]?>
            </td>
            <?php if(loggedin() && getadmin() && !isset($_GET['noadmin'])) { ?>
            <td class="cadre_gris align_center pointeur nowrap spaced gras <?=$todo_importance_css[$i]?>">
              <?=$todo_valide[$i]?>
            </td>
            <td class="cadre_gris align_center pointeur nowrap spaced gras <?=$todo_importance_css[$i]?>">
              <?=$todo_public[$i]?>
            </td>
            <?php } ?>
          </tr>

          <?php if($todo_id[$i] === $todoid) { ?>
          <tr id="todo_row<?=$todo_id[$i]?>">
          <?php } else { ?>
          <tr class="hidden" id="todo_row<?=$todo_id[$i]?>">
          <?php } ?>
            <?php if(loggedin() && getadmin() && !isset($_GET['noadmin'])) { ?>
            <td colspan="11" class="cadre_gris alinea nobleme_background">
            <?php } else { ?>
            <td colspan="9" class="cadre_gris alinea nobleme_background">
            <?php } ?>
              <br>
              <span class="moinsgros gras souligne">Ticket <a class="dark blank" href="<?=$chemin?>pages/todo/index?id=<?=$todo_id[$i]?>">#<?=$todo_id[$i]?></a> : <?=$todo_titre_complet[$i]?></span><br>
              <span class="italique dark">Soumis le <?=$todo_date_complete[$i]?> par <a class="dark blank gras" href="<?=$chemin?>pages/user/user?id=<?=$todo_createur_id[$i]?>"><?=$todo_createur[$i]?></a><?=$todo_date_resolution[$i]?><?=$todo_source[$i]?></span><br>
              <?php if(loggedin() && getadmin()) { ?>
              <a class="dark blank gras" href="<?=$chemin?>pages/todo/admin?id=<?=$todo_id[$i]?>"><?=$todo_valider_texte[$i]?></a> -
              <?php if(!$todo_resolution[$i] && $todo_valide[$i] != 'non') { ?>
              <span id="com_resolu<?=$i?>"><a class="dark blank gras" onClick="var ok = confirm('Confirmer la résolution du ticket ?'); if(ok == true) { dynamique('<?=$chemin?>','index?dynamique','com_resolu<?=$i?>','resolu_todo=<?=$todo_id[$i]?>'); }">
                Résolu</a></span>
              <?php } else { ?>
              <span id="com_non_resolu<?=$i?>"><a class="dark blank gras" onClick="var ok = confirm('Confirmer la non résolution du ticket ?'); if(ok == true) { dynamique('<?=$chemin?>','index?dynamique','com_non_resolu<?=$i?>','non_resolu_todo=<?=$todo_id[$i]?>'); }">
                Non résolu</a></span>
              <?php } ?>
              - <a class="dark blank gras" href="<?=$chemin?>pages/todo/delete?id=<?=$todo_id[$i]?>"><?=$todo_refuser_texte[$i]?></a>
              <br>
              <?php } ?>
              <br>
              <?=$todo_contenu[$i]?><br>
              <br>
              <br>
              <hr>
              <div class="intable align_center">
                <img src="<?=$chemin?>img/logos/todo_commentaires.png" alt="Commentaires">
              </div>
              <?php if($todo_commentaires[$i]) {
                    for($j=0;$j<$todo_commentaires[$i];$j++) { ?>
              <hr>
              <br>
              <table class="intable">
                <tr>
                  <td>
                    <a class="dark" href="#<?=$todo_id[$i].'.'.($j+1)?>" id="<?=$todo_id[$i].'.'.($j+1)?>">#<?=($j+1)?></a> <span class="italique">Posté <?=$comm_date_ilya[$i][$j]?> (<?=$comm_date[$i][$j]?>) par <a class="dark blank gras" href="<?=$chemin?>pages/user/user?id=<?=$comm_auteur_id[$i][$j]?>"><?=$comm_auteur[$i][$j]?></a></span>
                  </td>
                  <?php if(getsysop()) { ?>
                  <td class="align_right" id="comm_sysop_tools<?=$i.$j?>">
                    <a class="dark" onClick="document.getElementById('comm_modification<?=$i.$j?>').style.display = 'inline' ; document.getElementById('comm_contenu<?=$i.$j?>').style.display = 'none' ; document.getElementById('comm_sysop_tools<?=$i.$j?>').style.display = 'none'">Modifier le commentaire</a>
                    -
                    <a class="dark" onClick="document.getElementById('comm_suppression<?=$i.$j?>').style.display = 'inline' ; document.getElementById('comm_contenu<?=$i.$j?>').style.display = 'none' ; document.getElementById('comm_sysop_tools<?=$i.$j?>').style.display = 'none'">Supprimer le commentaire</a>
                  </td>
                  <?php } ?>
                </tr>
              </table>
              <br>
              <br>
              <div id="comm_contenu<?=$i.$j?>"><?=$comm_contenu[$i][$j]?></div>
              <?php if(getsysop()) { ?>
              <div class="hidden nowrap moinsgros gras" id="comm_modification<?=$i.$j?>">
                <textarea class="intable" rows="10" id="comm_sysop_edit<?=$i.$j?>"><?=$comm_contenu_raw[$i][$j]?></textarea><br>
                Raison de la modification (optionnel) : <input class="raisonedit" id="com_modification_raison<?=$i.$j?>"><br>
                <div class="align_center">
                  <img src="<?=$chemin?>img/boutons/modifier.png" alt="MODIFIER"
                        onClick="dynamique('<?=$chemin?>','index?dynamique','comm_modification<?=$i.$j?>',
                        'comm_sysop_edit='+dynamique_prepare('comm_sysop_edit<?=$i.$j?>')+
                        '&amp;raison_modification='+dynamique_prepare('com_modification_raison<?=$i.$j?>')+
                        '&amp;commid=<?=$comm_id[$i][$j]?>');">
                </div>
              </div>
              <div class="hidden nowrap moinsgros gras" id="comm_suppression<?=$i.$j?>">
                Raison de la suppression (optionnel) :
                <input class="raisonedit" id="comm_suppression_raison<?=$i.$j?>"><br>
                <br>
                <div class="align_center">
                  <img src="<?=$chemin?>img/boutons/supprimer.png" alt="SUPPRIMER"
                        onClick="dynamique('<?=$chemin?>','index?dynamique','comm_suppression<?=$i.$j?>',
                        'raison_suppression='+dynamique_prepare('comm_suppression_raison<?=$i.$j?>')+
                        '&amp;commid=<?=$comm_id[$i][$j]?>');">
                </div>
              </div>
              <?php } ?>
              <br>
              <? } } ?>
              <hr>

              <?php if(!loggedin()) { ?>
              <br>
              <span class="alinea moinsgros gras">Poster un commentaire</span><br>
              <br>
              Il est nécessaire d'être connecté à un compte sur NoBleme pour poster un commentaire<br>
              <br>
              Si vous ne possédez pas de compte et désirez commenter, <a class="dark blank gras" href="<?=$chemin?>pages/user/register">cliquez ici</a> pour vous inscrire.<br>
              Si vous possédez un compte, connectez-vous <a class="dark blank gras" href="#body">en haut à droite</a> de la page actuelle.<br>
              <br>
              <?php } else { ?>
              <br>
              <div id="replace_commentaire<?=$i?>">
                <span class="alinea moinsgros gras">Poster un commentaire en réponse au ticket</span><br>
                <br>
                Les <a class="dark blank gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> et les <a class="dark blank gras" href="<?=$chemin?>pages/doc/emotes">émoticônes</a> sont autorisés pour mettre en forme votre message.<br>
                Relisez-vous bien: Une fois votre message posté, vous ne pourrez ni le modifier ni le supprimer.<br>
                <br>
                Merci de ne poster que des commentaires en rapport avec le ticket auquel vous répondez.<br>
                Toute réponse hors sujet ou contenant des éléments publicitaires/auto-promotionnels sera supprimée.<br>
                <br>
                <div id="previsualisation_commentaire<?=$i?>"></div>
                <textarea class="intable" name="contenu_commentaire" rows="4" id="commentaire_contenu<?=$i?>"></textarea><br>
                <div class="indiv align_center">
                  <img class="pointeur" src="<?=$chemin?>img/boutons/todo_previsualiser.png" alt="PRÉVISUALISER"
                        onClick="dynamique('<?=$chemin?>','index?dynamique','previsualisation_commentaire<?=$i?>',
                        'comm_previsualisation=1&amp;comm_contenu='+dynamique_prepare('commentaire_contenu<?=$i?>'));">
                  <img class="pointeur" src="<?=$chemin?>img/boutons/todo_envoyer_commentaire.png" alt="ENVOYER LE COMMENTAIRE"
                        onClick="dynamique('<?=$chemin?>','index?dynamique','replace_commentaire<?=$i?>',
                        'comm_parent_todo=<?=$todo_id[$i]?>&amp;comm_contenu='+dynamique_prepare('commentaire_contenu<?=$i?>'));">
                </div>
              </div>
              <br>
              <?php } ?>
            </td>
          </tr>
          <?php } ?>

        </table>

      </form>
    </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                     PLACE AUX DONNÉES DYNAMIQUES                                                      */
/*                                                                                                                                       */
/********************************************************************************************************************************/ } else {

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Ticket résolu

  if(isset($_POST['resolu_todo']))
  {
    // Si l'user n'est pas un admin, belle tentative de manipulation, mais gtfo thx
    adminonly();

    // On assainit
    $solved_id = postdata($_POST['resolu_todo']);

    // On a besoin d'infos sur le ticket pour la suite
    $dtodo = mysqli_fetch_array(query(" SELECT FKmembres, titre, public FROM todo WHERE todo.id = '$solved_id' "));

    // On peut le marquer comme résolu maintenant
    $solved_timestamp = time();
    query(" UPDATE todo SET timestamp_fini = '$solved_timestamp' WHERE todo.id = '$solved_id' ");

    // Activité récente
    if($dtodo['public'])
    {
      $solved_titre = postdata($dtodo['titre']);
      query(" INSERT INTO activite
              SET         timestamp     = '$solved_timestamp' ,
                          action_type   = 'fini_todo'         ,
                          action_id     = '$solved_id'        ,
                          action_titre  = '$solved_titre'     ");
    }

    // Bot IRC NoBleme
    ircbot($chemin,"Ticket résolu : ".substr($dtodo['titre'],0,200)." - http://nobleme.com/pages/todo/index?id=".$solved_id,"#dev");

    // On envoie une notification au submitteur pour le tenir au courant
    if($dtodo['FKmembres'] > 1)
    {
      $solved_titre     = (strlen(html_entity_decode($dtodo['titre'])) > 25) ? substr(html_entity_decode($dtodo['titre']),0,24).'...' : $dtodo['titre'];
      $solved_message   = "[b]Votre ticket [url=".$chemin."pages/todo/index?id=".$solved_id."]".$dtodo['titre']."[/url] a été résolu.[/b]\r\n\r\n";
      $solved_message  .= "Merci d'avoir contribué à l'amélioration de NoBleme !\r\n";
      $solved_message  .= "N'hésitez pas à proposer d'autres tickets dans le futur";
      envoyer_notif($dtodo['FKmembres'] , 'Ticket résolu : '.postdata($solved_titre) , postdata($solved_message));
    }

    // Et on retourne un affichage
    ?>
    &nbsp;<span class="vert_background texte_blanc gras"> Résolu ! </span>&nbsp;
    <?php
  }



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Ticket non résolu

  if(isset($_POST['non_resolu_todo']))
  {
    // Si l'user n'est pas un admin, belle tentative de manipulation, mais gtfo thx
    adminonly();

    // On assainit
    $solved_id = postdata($_POST['non_resolu_todo']);

    // On le marque comme non résolu
    query(" UPDATE todo SET timestamp_fini = '0' WHERE todo.id = '$solved_id' ");

    // On le vire de l'activité récente
    query(" DELETE FROM activite WHERE action_type = 'fini_todo' AND action_id = '$solved_id' ");

    // Et on retourne un affichage
    ?>
    &nbsp;<span class="erreur texte_blanc gras"> Non résolu ! </span>&nbsp;
    <?php
  }



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Prévisualiser un commentaire

  if(isset($_POST['comm_previsualisation']))
  {
    // Assainir
    $previsualiser_comm = bbcode(nl2br_fixed(destroy_html($_POST['comm_contenu'])));

    // Et afficher
    ?>
    <hr>
    <br>
    <?=$previsualiser_comm?><br>
    <br>
    <?php
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Poster un nouveau commentaire

  else if(loggedin() && isset($_POST['comm_parent_todo']) && isset($_POST['comm_contenu']))
  {
    // On commence par assainir
    $add_comm_parent  = postdata($_POST['comm_parent_todo']);
    $add_comm_contenu = postdata(destroy_html($_POST['comm_contenu']));

    // On vérifie que le ticket existe bien
    $todotest = query(" SELECT id FROM todo WHERE id = '$add_comm_parent' ");
    if(mysqli_num_rows($todotest))
    {
      // Maintenant on peut ajouter le commentaire
      $add_comm_user      = $_SESSION['user'];
      $add_comm_timestamp = time();
      query(" INSERT INTO todo_commentaire
              SET         FKtodo    = '$add_comm_parent'    ,
                          FKmembres = '$add_comm_user'      ,
                          timestamp = '$add_comm_timestamp' ,
                          contenu   = '$add_comm_contenu'   ");

      // Activité récente
      $add_comm_pseudo  = postdata(getpseudo());
      $fetchbuggy       = mysqli_fetch_array(query(" SELECT id FROM todo_commentaire ORDER BY timestamp DESC LIMIT 1 "));
      $add_comm_id      = (mysqli_insert_id($db)) ? mysqli_insert_id($db) : $fetchbuggy['id'];
      $fetchparent      = mysqli_fetch_array(query(" SELECT titre FROM todo WHERE id = '$add_comm_parent' "));
      $add_parent_titre = postdata($fetchparent['titre']);
      query(" INSERT INTO activite
              SET         timestamp     = '$add_comm_timestamp' ,
                          FKmembres     = '$add_comm_user'      ,
                          pseudonyme    = '$add_comm_pseudo'    ,
                          action_type   = 'new_todo_comm'       ,
                          action_id     = '$add_comm_id'        ,
                          parent_id     = '$add_comm_parent'    ,
                          parent_titre  = '$add_parent_titre'   ");


      // Et on retourne un affichage
      $new_comm = bbcode(nl2br_fixed(destroy_html($_POST['comm_contenu'])));
      ?>
      <div class="vert_background alinea texte_blanc gras">Votre commentaire a bien été posté en réponse au ticket</div>
      <br>
      <?=$new_comm?>
      <?php
    }
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Modification d'un commentaire

  else if(isset($_POST['comm_sysop_edit']))
  {
    // Si l'user n'est pas un sysop, belle tentative de manipulation, mais gtfo thx
    sysoponly();

    // On récupère le postdata
    $edit_commid  = postdata($_POST['commid']);
    $edit_raison  = postdata(destroy_html($_POST['raison_modification']));
    $edit_contenu = postdata(destroy_html($_POST['comm_sysop_edit']));

    // On vérifie que le commentaire existe avant de se lancer
    if(is_numeric($edit_commid) && $edit_commid > 0)
    {
      // On en profite pour récupérer des infos qui serviront au log de modération
      $deditcomm = mysqli_fetch_array(query(" SELECT  todo_commentaire.FKtodo     ,
                                                      todo_commentaire.FKmembres  ,
                                                      todo_commentaire.contenu    ,
                                                      todo.titre                  ,
                                                      membres.pseudonyme
                                            FROM      todo_commentaire
                                            LEFT JOIN todo    ON todo_commentaire.FKtodo    = todo.id
                                            LEFT JOIN membres ON todo_commentaire.FKmembres = membres.id
                                            WHERE     todo_commentaire.id = '$edit_commid' "));

      // On check l'existence du commentaire
      if($deditcomm['FKtodo'])
      {
        // Log de modération
        $timestamp    = time();
        $editc_membre = $deditcomm['FKmembres'];
        $editc_pseudo = postdata($deditcomm['pseudonyme']);
        $editc_todoid = $deditcomm['FKtodo'];
        $editc_todo   = postdata($deditcomm['titre']);
        $sysop_id     = $_SESSION['user'];
        $sysop_pseudo = postdata(getpseudo());
        query(" INSERT INTO activite
                SET         timestamp       = '$timestamp'          ,
                            log_moderation  = 1                     ,
                            FKmembres       = '$editc_membre'       ,
                            pseudonyme      = '$editc_pseudo'       ,
                            action_type     = 'edit_todo_comm'      ,
                            action_id       = '$editc_todoid'       ,
                            action_titre    = '$editc_todo'         ,
                            parent_id       = '$sysop_id'           ,
                            parent_titre    = '$sysop_pseudo'       ,
                            justification   = '$edit_raison'        ");

        // Diff
        $id_diff          = mysqli_insert_id($db);
        $archive_comment  = postdata(diff(nl2br_fixed($deditcomm['contenu']),nl2br_fixed($_POST['comm_sysop_edit']),1));
        query(" INSERT INTO activite_diff SET FKactivite = '$id_diff' , diff = '$archive_comment' ");

        // Bot IRC NoBleme
        ircbot($chemin,"http://nobleme.com/pages/nobleme/activite?mod : ".getpseudo()." a modifié un commentaire sur un ticket","#sysop");

        // Édition du commentaire
        query(" UPDATE todo_commentaire SET contenu = '$edit_contenu' WHERE id = '$edit_commid' ");
      }
    }

    // Reste plus qu'à renvoyer le message de confirmation
    ?>
    <div class="vert_background alinea texte_blanc gras">Le commentaire a bien été modifié</div>
    <?php
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Suppression d'un commentaire

  if(isset($_POST['raison_suppression']))
  {
    // Si l'user n'est pas un sysop, belle tentative de manipulation, mais gtfo thx
    sysoponly();

    // On récupère le postdata
    $del_commid = postdata($_POST['commid']);
    $del_raison = postdata(destroy_html($_POST['raison_suppression']));

    // On vérifie que le commentaire existe avant de se lancer
    if(is_numeric($del_commid) && $del_commid > 0)
    {
      // On en profite pour récupérer des infos qui serviront au log de modération
      $ddelcom = mysqli_fetch_array(query(" SELECT    todo_commentaire.FKtodo     ,
                                                      todo_commentaire.FKmembres  ,
                                                      todo_commentaire.contenu    ,
                                                      todo.titre                  ,
                                                      membres.pseudonyme
                                            FROM      todo_commentaire
                                            LEFT JOIN todo    ON todo_commentaire.FKtodo    = todo.id
                                            LEFT JOIN membres ON todo_commentaire.FKmembres = membres.id
                                            WHERE     todo_commentaire.id = '$del_commid' "));

      // On check l'existence du commentaire
      if($ddelcom['FKtodo'])
      {
        // Activité récente
        query(" DELETE FROM activite WHERE action_type = 'new_todo_comm' AND action_id = '$del_commid' ");

        // Log de modération
        $timestamp    = time();
        $delc_membre  = $ddelcom['FKmembres'];
        $delc_pseudo  = postdata($ddelcom['pseudonyme']);
        $delc_todoid  = $ddelcom['FKtodo'];
        $delc_todo    = postdata($ddelcom['titre']);
        $sysop_id     = $_SESSION['user'];
        $sysop_pseudo = postdata(getpseudo());
        query(" INSERT INTO activite
                SET         timestamp       = '$timestamp'          ,
                            log_moderation  = 1                     ,
                            FKmembres       = '$delc_membre'        ,
                            pseudonyme      = '$delc_pseudo'        ,
                            action_type     = 'del_todo_comm'       ,
                            action_id       = '$delc_todoid'        ,
                            action_titre    = '$delc_todo'          ,
                            parent_id       = '$sysop_id'           ,
                            parent_titre    = '$sysop_pseudo'       ,
                            justification   = '$del_raison'         ");

        // Diff
        $id_diff          = mysqli_insert_id($db);
        $archive_comment  = postdata(nl2br_fixed($ddelcom['contenu']));
        query(" INSERT INTO activite_diff SET FKactivite = '$id_diff' , diff = '$archive_comment' ");

        // Bot IRC NoBleme
        ircbot($chemin,"http://nobleme.com/pages/nobleme/activite?mod : ".getpseudo()." a supprimé un commentaire sur un ticket","#sysop");

        // Suppression du commentaire
        query(" DELETE FROM todo_commentaire WHERE id = '$del_commid' ");
      }
    }

    // Reste plus qu'à renvoyer le message de confirmation
    ?>
    <div class="erreur alinea texte_blanc gras">Le commentaire a bien été supprimé</div>
    <?php
  }
}