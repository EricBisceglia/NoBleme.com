<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
sysoponly($lang);

// Menus du header
$header_menu      = 'Admin';
$header_sidemenu  = 'ChangerPass';

// Identification
$page_nom = "Administre secrètement le site";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Changer un mot de passe";

// JS
$js = array('dynamique', 'sysop/chercher_user');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Changement d'un mot de passe
if(isset($_POST['pass_go']))
{
  // On nettoie le postdata
  $pass_id      = postdata($_GET['id'], 'int');
  $pass_nouveau = postdata(salage($_POST['pass_nouveau']), 'string');

  // On vérifie que l'user existe, sinon on dégage
  $qtestpass = mysqli_fetch_array(query(" SELECT  membres.id
                                          FROM    membres
                                          WHERE   membres.id = '$pass_id' "));
  if(!$qtestpass['id'])
    header("Location: ".$chemin."pages/sysop/pass");

  // Si aucun pass n'est rentré, on sort de là
  if(!$pass_nouveau)
    header("Location: ".$chemin."pages/sysop/pass?id=".$pass_id);

  // On change le mot de passe de l'user
  query(" UPDATE  membres
          SET     pass          = '$pass_nouveau'
          WHERE   membres.id    = '$pass_id' ");

  // On ajoute le changement de pass au log de modération
  $pass_pseudo  = postdata(getpseudo($pass_id), 'string');
  $pass_sysop   = postdata(getpseudo(), 'string');
  activite_nouveau('editpass', 1, $pass_id, $pass_pseudo, 0, NULL, $pass_sysop);

  // On notifie #sysop de l'action
  ircbot($chemin, getpseudo()." a changé le mot de passe de ".getpseudo($pass_id), "#sysop");

  // Et on redirige vers le log de modération
  header("Location: ".$chemin."pages/nobleme/activite?mod");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si on a choisi l'user, on prépare ses infos
if(isset($_GET['id']))
{
  // On commence par récupérer l'ID
  $pass_id = postdata($_GET['id'], 'int', 0);

  // On va chercher les données liées à l'user
  $qpassuser = mysqli_fetch_array(query(" SELECT  membres.pseudonyme
                                          FROM    membres
                                          WHERE   membres.id = '$pass_id' "));
  $pass_pseudo = predata($qpassuser['pseudonyme']);

  // Si l'user existe pas, on dégage
  if(!$pass_pseudo)
    $_GET['id'] = 0;
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>Changer un mot de passe</h1>

        <p>Théoriquement, je choisis bien mes sysop. J'ai confiance que vous n'allez pas abuser de cet outil. Son but unique est de permettre à quelqu'un de récupérer l'accès à son compte s'il l'a perdu.</p>

        <p>Si quelqu'un vous demande un nouveau mot de passe mais que vous n'avez pas 100% confiance qu'il est le propriétaire légitime du compte, demandez à Bad de s'en occuper. J'ai accès à des outils qui permettent de vérifier l'authenticité des gens, et je peux communiquer avec eux via l'e-mail qui est lié au compte.</p>

        <br>
        <br>

        <?php if(isset($_GET['id']) && $pass_pseudo && $pass_id == 1) { ?>

        <h5>On ne change pas le mot de passe du patron. Bien essayé.</h5>

        <?php } else if(isset($_GET['id']) && $pass_pseudo) { ?>

        <h5>Changer le mot de passe de <a href="<?=$chemin?>pages/users/user?id=<?=$pass_id?>"><?=$pass_pseudo?></a></h5>
        <br>

        <form method="POST">
          <fieldset>
            <label for="pass_nouveau">Nouveau mot de passe (idéalement 6 caractères minimum):</label>
            <input id="pass_nouveau" name="pass_nouveau" class="indiv" type="password"><br>
            <br>
            <input value="Changer le pass de <?=$pass_pseudo?>" type="submit" name="pass_go">
          </fieldset>
        </form>

        <?php } else { ?>

        <fieldset>
          <label for="sysop_pseudo_user">Entrez une partie du pseudonyme de l'utilisateur dont vous souhaitez changer le mot de passe :</label>
          <input  id="sysop_pseudo_user" name="sysop_pseudo_user" class="indiv" type="text"
                  onkeyup="sysop_chercher_user('<?=$chemin?>', 'Changer pass', 'pass')";><br>
        </fieldset>

      </div>

      <div class="minitexte" id="sysop_liste_users">
        &nbsp;

      <?php } ?>

    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';