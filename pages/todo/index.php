<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Todolist';

// Identification
$page_nom = "Décortique la liste des tâches";
$page_url = "pages/todo/index";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Liste des tâches";
$page_desc  = "Liste de tâches accomplies ou à accomplir dans le développement de NoBleme";

// CSS & JS
$css  = array('todo');
$js   = array('toggle', 'dynamique', 'todo/liste_taches');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajouter une nouvelle tâche

if(isset($_POST['todo_add_go']) && getadmin())
{
  // Permissions
  adminonly($lang);

  // Assainissement du postdata
  $todo_add_titre       = postdata_vide('todo_add_titre', 'string', '');
  $todo_add_description = postdata_vide('todo_add_description', 'string', '');
  $todo_add_categorie   = postdata_vide('todo_add_categorie', 'int', 0);
  $todo_add_objectif    = postdata_vide('todo_add_objectif', 'int', 0);
  $todo_add_importance  = postdata_vide('todo_add_importance', 'int', 0);
  $todo_add_public      = postdata_vide('todo_add_public', 'int', 0);

  // Création de la tâche
  $timestamp = time();
  query(" INSERT INTO todo
          SET         todo.FKmembres        = 1                       ,
                      todo.timestamp        = '$timestamp'            ,
                      todo.importance       = '$todo_add_importance'  ,
                      todo.titre            = '$todo_add_titre'       ,
                      todo.contenu          = '$todo_add_description' ,
                      todo.FKtodo_categorie = '$todo_add_categorie'   ,
                      todo.FKtodo_roadmap   = '$todo_add_objectif'    ,
                      todo.valide_admin     = 1                       ,
                      todo.public           = '$todo_add_public'      ,
                      todo.timestamp_fini   = 0                       ,
                      todo.source           = ''                      ");

  // Si la tâche est publique, on notifie
  if($todo_add_public)
  {
    // Activité récente
    $todo_add_id      = mysqli_insert_id($db);
    $todo_add_pseudo  = postdata(getpseudo(), 'string');
    query(" INSERT INTO activite
            SET         activite.timestamp    = '$timestamp'        ,
                        activite.FKmembres    = 1                   ,
                        activite.pseudonyme   = '$todo_add_pseudo'  ,
                        activite.action_type  = 'todo_new'          ,
                        activite.action_id    = '$todo_add_id'      ,
                        activite.action_titre = '$todo_add_titre'   ");

    // Bot IRC
    $todo_add_pseudo_raw  = getpseudo();
    $todo_add_titre_raw   = $_POST['todo_add_titre'];
    ircbot($chemin, $todo_add_pseudo_raw." a ouvert une tâche : ".$todo_add_titre_raw." - ".$GLOBALS['url_site']."pages/todo/index?id=".$todo_add_id, "#dev");
  }
}






/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Tableau des tâches

// On stocke dans un coin si on est admin ou pas
$todo_admin   = getadmin();

// On va chercher la liste des tâches
$qtodo = "    SELECT    todo.id                   AS 't_id'         ,
                        todo.titre                AS 't_titre'      ,
                        todo.timestamp            AS 't_creation'   ,
                        todo.timestamp_fini       AS 't_resolution' ,
                        todo.importance           AS 't_importance' ,
                        todo.valide_admin         AS 't_valide'     ,
                        todo.public               AS 't_public'     ,
                        todo.source               AS 't_source'     ,
                        todo.contenu              AS 't_contenu'    ,
                        todo_categorie.categorie  AS 'c_nom'        ,
                        todo_roadmap.version      AS 'r_nom'        ,
                        membres.pseudonyme        AS 'm_pseudo'     ,
                        membres.id                AS 'm_id'
              FROM      todo
              LEFT JOIN membres         ON todo.FKmembres         = membres.id
              LEFT JOIN todo_categorie  ON todo.FKtodo_categorie  = todo_categorie.id
              LEFT JOIN todo_roadmap    ON todo.FKtodo_roadmap    = todo_roadmap.id
              WHERE     1 = 1 ";
if(!$todo_admin)
  $qtodo .= " AND       todo.valide_admin = 1
              AND       todo.public       = 1 ";

// Assainissement du postdata des recherches
$todo_preset_id           = isset($_GET['id']) ? postdata($_GET['id'], 'int') : 0;
$todo_search_id           = postdata_vide('todo_search_id', 'int', $todo_preset_id);
$todo_preset_id           = ($todo_preset_id) ? $todo_preset_id : '';
$todo_search_prive        = postdata_vide('todo_search_prive', 'int', -1);
$todo_search_importance   = postdata_vide('todo_search_importance', 'int', -1);
$todo_search_creation     = postdata_vide('todo_search_creation', 'int', 0);
$todo_search_createur     = postdata_vide('todo_search_createur', 'string', '');
$todo_search_categorie    = postdata_vide('todo_search_categorie', 'int', -1);
$todo_search_description  = postdata_vide('todo_search_description', 'strin', '');
$todo_search_objectif     = postdata_vide('todo_search_objectif', 'int', -1);
$todo_search_etat         = postdata_vide('todo_search_etat', 'int', -1);
$todo_search_resolution   = postdata_vide('todo_search_resolution', 'int', 0);

// Recherches
if($todo_search_id)
  $qtodo .= " AND       todo.id                                   = '$todo_search_id' ";
if($todo_search_prive >= 0)
  $qtodo .= " AND       todo.public                               = '$todo_search_prive' ";
if($todo_search_importance >= 0)
  $qtodo .= " AND       todo.timestamp_fini                       = 0
              AND       todo.importance                           = '$todo_search_importance' ";
if($todo_search_creation)
  $qtodo .= " AND       YEAR(FROM_UNIXTIME(todo.timestamp))       = '$todo_search_creation' ";
if($todo_search_createur)
  $qtodo .= " AND       membres.pseudonyme                        LIKE '%$todo_search_createur%' ";
if($todo_search_categorie == 0)
  $qtodo .= " AND       todo.FKtodo_categorie                     = 0 ";
if($todo_search_categorie > 0)
  $qtodo .= " AND       todo.FKtodo_categorie                     = '$todo_search_categorie' ";
if($todo_search_description)
  $qtodo .= " AND       todo.titre                                LIKE '%$todo_search_description%' ";
if($todo_search_objectif == 0)
  $qtodo .= " AND       todo.FKtodo_roadmap                       = 0 ";
if($todo_search_objectif > 0)
  $qtodo .= " AND       todo.FKtodo_roadmap                       = '$todo_search_objectif' ";
if($todo_search_etat == 0)
  $qtodo .= " AND       todo.timestamp_fini                       = 0 ";
if($todo_search_etat == 1)
  $qtodo .= " AND       todo.timestamp_fini                       != 0 ";
if($todo_search_resolution)
  $qtodo .= " AND       YEAR(FROM_UNIXTIME(todo.timestamp_fini))  = '$todo_search_resolution' ";

// Tri
$todo_tri = postdata_vide('todo_tri', 'string', '');
if($todo_tri == 'id')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        todo.id                     DESC  ";
else if($todo_tri == 'prive')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        todo.public                 ASC   ,
                        (todo.timestamp_fini != 0)        ,
                        todo.timestamp_fini         DESC  ,
                        todo.importance             DESC  ,
                        (todo.FKtodo_roadmap = 0)         ,
                        todo_roadmap.id_classement  ASC   ,
                        todo.timestamp              DESC  ";
else if($todo_tri == 'creation')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        todo.timestamp              DESC  ";
else if($todo_tri == 'createur')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        membres.pseudonyme          ASC   ,
                        (todo.timestamp_fini != 0)        ,
                        todo.timestamp_fini         DESC  ,
                        todo.importance             DESC  ,
                        (todo.FKtodo_roadmap = 0)         ,
                        todo_roadmap.id_classement  ASC   ,
                        todo.timestamp              DESC  ";
else if($todo_tri == 'categorie')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        (todo.FKtodo_categorie = 0)       ,
                        todo_categorie.categorie    ASC   ,
                        (todo.timestamp_fini != 0)        ,
                        todo.timestamp_fini         DESC  ,
                        todo.importance             DESC  ,
                        (todo.FKtodo_roadmap = 0)         ,
                        todo_roadmap.id_classement  ASC   ,
                        todo.timestamp              DESC  ";
else if($todo_tri == 'description')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        todo.titre                  ASC   ,
                        todo.timestamp              DESC  ";
else if($todo_tri == 'objectif')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        (todo.FKtodo_roadmap = 0)         ,
                        todo_roadmap.id_classement  DESC  ,
                        (todo.timestamp_fini != 0)        ,
                        todo.timestamp_fini         DESC  ,
                        todo.importance             DESC  ,
                        todo.timestamp              DESC  ";
else if($todo_tri == 'resolution')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        (todo.timestamp_fini = 0)         ,
                        todo.timestamp_fini         DESC  ,
                        todo.importance             DESC  ,
                        (todo.FKtodo_roadmap = 0)         ,
                        todo_roadmap.id_classement  ASC   ,
                        todo.timestamp              DESC  ";
else
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        (todo.timestamp_fini != 0)        ,
                        todo.timestamp_fini         DESC  ,
                        todo.importance             DESC  ,
                        (todo.FKtodo_roadmap = 0)         ,
                        todo_roadmap.id_classement  ASC   ,
                        todo.timestamp              DESC  ";

// On lance la requête
$qtodo = query($qtodo);

// On initialise le compteur de tâches à faire
$todo_a_faire = 0;

// On prépare tout ça pour l'affichage
for($ntodo = 0; $dtodo = mysqli_fetch_array($qtodo); $ntodo++)
{
  $todo_a_faire            += (!$dtodo['t_resolution']) ? 1 : 0;
  $todo_css[$ntodo]         = ($dtodo['t_resolution']) ? 'todo_resolu' : 'todo_importance_'.$dtodo['t_importance'];
  $todo_css[$ntodo]         = (!$dtodo['t_valide']) ? 'negatif texte_blanc' : $todo_css[$ntodo];
  $todo_id[$ntodo]          = $dtodo['t_id'];
  $todo_titre[$ntodo]       = predata(tronquer_chaine($dtodo['t_titre'], 50, '...'));
  $todo_full_titre[$ntodo]  = predata($dtodo['t_titre']);
  $todo_createur[$ntodo]    = predata($dtodo['m_pseudo']);
  $todo_creation[$ntodo]    = predata(ilya($dtodo['t_creation']));
  $todo_resolution[$ntodo]  = ($dtodo['t_resolution']) ? predata(ilya($dtodo['t_resolution'])) : 'Non résolu';
  $todo_importance[$ntodo]  = (!$dtodo['t_resolution']) ? todo_importance($dtodo['t_importance'], 1) : 'Résolu';
  $todo_importance[$ntodo]  = (!$dtodo['t_valide']) ? '<span class="gras">NON VALIDÉ !</span>' : $todo_importance[$ntodo];
  $todo_categorie[$ntodo]   = ($dtodo['c_nom']) ? predata($dtodo['c_nom']) : '';
  $todo_objectif[$ntodo]    = ($dtodo['r_nom']) ? predata($dtodo['r_nom']) : '';
  $todo_prive[$ntodo]       = (!$dtodo['t_public']) ? 'PRIVÉ' : '';
  $todo_approuve[$ntodo]    = ($dtodo['t_valide']) ? 1 : 0;
}

// Si c'est une tâche seule, on prépare le contenu des détails de la tâche
if($todo_search_id && $ntodo == 1)
{
  mysqli_data_seek($qtodo, 0);
  $dtodo            = mysqli_fetch_array($qtodo);
  $shorturl         = "t=".$todo_search_id;
  $todo_titre_full  = predata($dtodo['t_titre']);
  $todo_soumis_le   = predata(jourfr(date('Y-m-d', $dtodo['t_creation'])));
  $todo_soumis_id   = $dtodo['m_id'];
  $todo_resolu      = ($dtodo['t_resolution']) ? 1 : 0;
  $todo_resolu_le   = predata(jourfr(date('Y-m-d', $dtodo['t_resolution'])));
  $todo_source      = ($dtodo['t_source']) ? predata($dtodo['t_source']) : 0;
  $todo_contenu     = bbcode(predata($dtodo['t_contenu'], 1));
  $todo_modifier    = ($dtodo['t_valide']) ? 'MODIFIER' : 'APPROUVER';
  $todo_supprimer   = ($dtodo['t_valide']) ? 'SUPPRIMER' : 'REJETER';
}

// On calcule le nombre de tâches résolues
$todo_finies    = $ntodo - $todo_a_faire;
$todo_resolues  = format_nombre(calcul_pourcentage($todo_finies, $ntodo),"pourcentage",0);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menus déroulants pour la recherche

// Années depuis 2012
$select_annees = '<option value="0">&nbsp;</option>';
for($i=date('Y');$i>=2012;$i--)
  $select_annees .= '<option value="'.$i.'">'.$i.'</option>';


// Importance
$select_importance = '';
for($i=0;$i<=5;$i++)
  $select_importance .= '<option value="'.$i.'">'.todo_importance($i).'</option>';


// Catégories
$qcategories = query("  SELECT    todo_categorie.id ,
                                  todo_categorie.categorie
                        FROM      todo_categorie
                        ORDER BY  todo_categorie.categorie ASC ");
$select_categorie = '<option value="0">Aucune catégorie</option>';
while($dcategories = mysqli_fetch_array($qcategories))
  $select_categorie .= '<option value="'.$dcategories['id'].'">'.predata($dcategories['categorie']).'</option>';


// Objectifs
$qobjectifs = query(" SELECT    todo_roadmap.id ,
                                todo_roadmap.version
                      FROM      todo_roadmap
                      ORDER BY  todo_roadmap.id_classement DESC ");
$select_objectif = '<option value="0">Aucun objectif</option>';
while($dobjectifs = mysqli_fetch_array($qobjectifs))
  $select_objectif .= '<option value="'.$dobjectifs['id'].'">'.predata($dobjectifs['version']).'</option>';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Si on est dans une tâche spécifique, on update les variables du header

if(isset($_GET['id']))
{
  // Si la tâche n'existe pas, on revient sur l'index
  if(!$_GET['id'] || !$todo_id[0])
    exit(header("Location: ".$chemin."pages/todo/index"));

  // Identification
  $page_nom = "Constate l'état de la tâche #".$todo_id[0];
  $page_url = "pages/todo/index?id=".$todo_id[0];

  // Titre et description
  $page_titre = "Tâche #".$todo_id[0]." : ".$todo_full_titre[0];
  $page_desc  = "Tâche liée au développement de NoBleme : ".$todo_full_titre[0];
}





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte">

        <h1>
          <?php if(isset($_GET['id'])) { ?>
          <a href="<?=$chemin?>pages/todo/index">Liste des tâches</a>
          <?php } else { ?>
          Liste des tâches
          <?php } ?>
          <a href="<?=$chemin?>pages/doc/rss">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/rss.png" alt="RSS">
          </a>
          <?php if($todo_admin) { ?>
          <img class="pointeur" src="<?=$chemin?>img/icones/ajouter.png" alt="+" onclick="todolist_ajouter_tache();">
          <?php } ?>
        </h1>

        <h5>Suivi du développement de NoBleme</h5>

        <p>
          La liste des tâches regroupe les rapports de bugs et demandes de fonctionnalités liés au développement de NoBleme. Pour voir les détails d'une tâche dans le tableau, cliquez n'importe où sur la ligne contenant la tâche en question. Vous pouvez faire des recherches dans la liste des tâches à l'aide des champs et menus déroulants situés en haut du tableau.
        </p>

        <p>
          Si vous avez trouvé un bug sur NoBleme, vous pouvez <a class="gras" href="<?=$chemin?>pages/todo/request?bug">soumettre un rapport de bug</a>.<br>
          Si vous avez une idée de fonctionnalité qui pourrait être ajoutée au site, vous pouvez <a class="gras" href="<?=$chemin?>pages/todo/request">quémander un feature</a>.<br>
        </p>

      </div>

      <?php if($todo_admin) { ?>

      <div class="hidden" id="todolist_add">

        <br>
        <hr class="separateur_contenu">
        <br>

        <div class="texte">

          <form method="POST" id="todolist_add_form">
            <fieldset>

              <label for="todo_add_titre">Titre de la tâche</label>
              <input id="todo_add_titre" name="todo_add_titre" class="indiv" type="text"><br>
              <br>

              <label for="todo_add_description">Description</label>
              <textarea id="todo_add_description" name="todo_add_description" class="indiv" style="height:100px"></textarea><br>
              <br>

              <label for="todo_add_categorie">Catégorie</label>
              <div class="flexcontainer">
                <div style="flex:15">
                  <select id="todo_add_categorie" name="todo_add_categorie" class="indiv">
                    <?=$select_categorie?>
                  </select><br>
                </div>
                <div style="flex:1" class="align_right">
                  <a href="<?=$chemin?>pages/todo/edit_categories">
                    <img src="<?=$chemin?>img/icones/modifier.png" alt="M">
                  </a>
                </div>
              </div>
              <br>

              <label for="todo_add_objectif">Objectif</label>
              <div class="flexcontainer">
                <div style="flex:15">
                  <select id="todo_add_objectif" name="todo_add_objectif" class="indiv">
                    <?=$select_objectif?>
                  </select><br>
                </div>
                <div style="flex:1" class="align_right">
                  <a href="<?=$chemin?>pages/todo/edit_roadmaps">
                    <img src="<?=$chemin?>img/icones/modifier.png" alt="M">
                  </a>
                </div>
              </div>
              <br>

              <label for="todo_add_importance">Importance</label>
              <select id="todo_add_importance" name="todo_add_importance" class="indiv">
                <?=$select_importance?>
              </select><br>
              <br>

              <label for="todo_add_public">Visibilité</label>
              <select id="todo_add_public" name="todo_add_public" class="indiv">
                <option value="1">Public</option>
                <option value="0">Privé</option>
              </select><br>
              <br>

              <br>
              <input value="CRÉER LA TÂCHE" type="submit" name="todo_add_go"><br>

            </fieldset>
          </form>

        </div>

        <br>
        <hr class="separateur_contenu">

      </div>

      <?php } ?>

      <br>
      <br>

      <div class="tableau2">

        <input type="hidden" value="" id="todo_tri">
        <?php if(!$todo_admin) { ?>
        <input type="hidden" value="-1" id="todo_search_prive">
        <?php } ?>

        <table class="grid fullgrid texte_noir">
          <thead class="nowrap">

            <tr class="grisclair gras pointeur">
              <th onclick="todolist_tableau('<?=$chemin?>', 'id');">
                ID
              </th>
              <?php if($todo_admin) { ?>
              <th onclick="todolist_tableau('<?=$chemin?>', 'prive');">
                PRIVÉ
              </th>
              <?php } ?>
              <th onclick="todolist_tableau('<?=$chemin?>', 'importance');">
                IMPORTANCE
              </th>
              <th onclick="todolist_tableau('<?=$chemin?>', 'creation');">
                CRÉATION
              </th>
              <th onclick="todolist_tableau('<?=$chemin?>', 'createur');">
                CRÉATEUR
              </th>
              <th onclick="todolist_tableau('<?=$chemin?>', 'categorie');">
                CATÉGORIE
              </th>
              <th onclick="todolist_tableau('<?=$chemin?>', 'description');">
                DESCRIPTION
              </th>
              <th onclick="todolist_tableau('<?=$chemin?>', 'objectif');">
                OBJECTIF
              </th>
              <th colspan="2" onclick="todolist_tableau('<?=$chemin?>', 'resolution');">
                RÉSOLUTION
              </th>
            </tr>

            <tr>

              <th>
                <input class="intable" size="1" id="todo_search_id" value="<?=$todo_preset_id?>" onkeyup="todolist_tableau('<?=$chemin?>');">
              </th>

              <?php if($todo_admin) { ?>
              <th>
                <select class="table_search intable" id="todo_search_prive" onchange="todolist_tableau('<?=$chemin?>');">
                  <option value="-1">&nbsp;</option>
                  <option value="1">Public</option>
                  <option value="0">Privé</option>
                </select>
              </th>
              <?php } ?>

              <th>
                <select class="table_search intable" id="todo_search_importance" onchange="todolist_tableau('<?=$chemin?>');">
                  <option value="-1">&nbsp;</option>
                  <?=$select_importance?>
                </select>
              </th>

              <th>
                <select class="table_search intable" id="todo_search_creation" onchange="todolist_tableau('<?=$chemin?>');">
                  <?=$select_annees?>
                </select>
              </th>

              <th>
                <input class="intable" size="1" id="todo_search_createur" onkeyup="todolist_tableau('<?=$chemin?>');">
              </th>

              <th>
                <select class="table_search intable" id="todo_search_categorie" onchange="todolist_tableau('<?=$chemin?>');">
                  <option value="-1">&nbsp;</option>
                  <?=$select_categorie?>
                </select>
              </th>

              <th>
                <input class="intable" size="1" id="todo_search_description" onkeyup="todolist_tableau('<?=$chemin?>');">
              </th>

              <th>
                <select class="table_search intable" id="todo_search_objectif" onchange="todolist_tableau('<?=$chemin?>');">
                  <option value="-1">&nbsp;</option>
                  <?=$select_objectif?>
                </select>
              </th>

              <th>
                <select class="table_search intable" id="todo_search_etat" onchange="todolist_tableau('<?=$chemin?>');">
                  <option value="-1">&nbsp;</option>
                  <option value="1">Résolu</option>
                  <option value="0">Non résolu</option>
                </select>
              </th>
              <th>
                <select class="table_search intable" id="todo_search_resolution" onchange="todolist_tableau('<?=$chemin?>');">
                  <?=$select_annees?>
                </select>
              </th>

            </tr>

          </thead>
          <tbody class="align_center" id="todolist_tbody">

            <?php } ?>

            <tr class="pointeur nowrap" onclick="todolist_tableau('<?=$chemin?>', 'raz');">
              <?php if($todo_admin) { ?>
              <td colspan="10" class="noir texte_blanc gras">
              <?php } else { ?>
              <td colspan="9" class="noir texte_blanc gras">
              <?php } ?>
                <?php if($ntodo > 1) { ?>
                <?=$ntodo?> TÂCHES TROUVÉES
                <?php } else { ?>
                <?=$ntodo?> TÂCHE TROUVÉE
                <?php } ?>
                &nbsp;<span class="texte_positif">DONT <?=$todo_finies?> FINIES</span>
                &nbsp;<span class="texte_negatif">ET <?=$todo_a_faire?> À FAIRE</span>
                &nbsp;<span class="texte_neutre">SOIT <?=$todo_resolues?> RÉSOLUES</span>
                <?php if($todo_preset_id || (getxhr() && $todo_tri != 'raz')) { ?>
                &nbsp; - &nbsp;<span>CLIQUER ICI POUR REMETTRE À ZÉRO LA RECHERCHE</span>
                <?php } ?>
              </td>
            </tr>

            <?php for($i=0;$i<$ntodo;$i++) { ?>

            <tr class="nowrap <?=$todo_css[$i]?> pointeur" onclick="todolist_afficher_tache('<?=$chemin?>', <?=$todo_id[$i]?>);">
              <td>
                <?=$todo_id[$i]?>
              </td>
              <?php if($todo_admin) { ?>
              <td class="gras">
                <?=$todo_prive[$i]?>
              </td>
              <?php } ?>
              <td>
                <?=$todo_importance[$i]?>
              </td>
              <td>
                <?=$todo_creation[$i]?>
              </td>
              <td>
                <?=$todo_createur[$i]?>
              </td>
              <td>
                <?=$todo_categorie[$i]?>
              </td>
              <td class="gras">
                <?=$todo_titre[$i]?>
              </td>
              <td>
                <?=$todo_objectif[$i]?>
              </td>
              <td colspan="2">
                <?=$todo_resolution[$i]?>
              </td>
            </tr>

            <?php if($todo_search_id && $ntodo == 1) { ?>

            <tr class="grisclair align_left">
              <?php if($todo_admin) { ?>
              <td colspan="10">
              <?php } else { ?>
              <td colspan="9">
              <?php } ?>

                <div class="alinea">
                  <br>

                  <span class="moinsgros gras">
                    <a href="<?=$chemin?>pages/todo/index?id=<?=$todo_id[$i]?>">Tâche #<?=$todo_id[$i]?></a> : <?=$todo_titre_full?>
                  </span><br>

                  <span class="italique">
                    Tâche proposée le <?=$todo_soumis_le?> par <a class="gras" href="<?=$chemin?>pages/user/user?id=<?=$todo_soumis_id?>"><?=$todo_createur[$i]?></a><br>
                    <?php if($todo_resolu) { ?>
                    Tâche résolue le <?=$todo_resolu_le?>
                    <?php if($todo_source) { ?>
                    : <a href="<?=$todo_source?>">code source du patch</a>
                    <?php } ?>
                    <br>
                    <?php } ?>
                  </span>

                </div>
                <br>
                <hr>
                <br>
                <div class="alinea">

                  <?=$todo_contenu?><br>

                  <?php if($todo_admin) { ?>

                  <br>
                  <br>

                  <?php if($todo_approuve[$i]) { ?>
                  <a class="spaced" href="<?=$chemin?>pages/todo/resolu?id=<?=$todo_id[$i]?>">
                    <button class="button button-outline">RÉSOLU</button>
                  </a>
                  &nbsp;
                  <?php } ?>

                  <a class="spaced" href="<?=$chemin?>pages/todo/edit?id=<?=$todo_id[$i]?>">
                    <button class="button button-outline"><?=$todo_modifier?></button>
                  </a>
                  &nbsp;

                  <a class="spaced" href="<?=$chemin?>pages/todo/delete?id=<?=$todo_id[$i]?>">
                    <button class="button button-outline"><?=$todo_supprimer?></button>
                  </a>
                  <br>

                  <?php } ?>

                  <br>
                </div>

              </td>
            </tr>

            <?php } else { ?>

            <tr class="hidden grisclair align_left" id="todolist_ligne_<?=$todo_id[$i]?>">
              <?php if($todo_admin) { ?>
              <td colspan="10" id="todolist_cellule_<?=$todo_id[$i]?>">
              <?php } else { ?>
              <td colspan="9" id="todolist_cellule_<?=$todo_id[$i]?>">
              <?php } ?>
                &nbsp;
              </td>
            </tr>

            <?php } ?>

            <?php } ?>

            <?php if(!getxhr()) { ?>

          </tbody>
        </table>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }