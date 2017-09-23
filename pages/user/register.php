<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
guestonly();

// Menus du header
$header_menu = 'NoBleme';

// Titre et description
$page_titre = "Créer un compte";
$page_desc  = "S'inscrire sur NoBleme pour devenir un membre de la communauté";

// CSS
$css = array('user');

// Identification
$page_nom = "user";
$page_id  = "register";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Pas d'erreur pour le moment
$register_erreur = "";

// On commence par réinitialiser les réponses aux questions, ça servira plus tard
for($i=1;$i<=3;$i++)
{
  $register_check_q1[$i]  = "";
  $register_check_q2[$i]  = "";
  $register_check_q3[$i]  = "";
  $register_check_q4[$i]  = "";
}

// Vérification et validation des données
if (isset($_POST["register_go_x"]))
{
  // Récupération du postdata
  $register_pseudo  = postdata(destroy_html($_POST["register_pseudo"]));
  $register_pass_1  = postdata(destroy_html($_POST["register_pass_1"]));
  $register_pass_2  = postdata(destroy_html($_POST["register_pass_2"]));
  $register_email   = postdata(destroy_html($_POST["register_email"]));
  $register_captcha = postdata($_POST["register_captcha"]);
  $register_q1      = isset($_POST["register_question_1"]) ? postdata($_POST["register_question_1"]) : 0;
  $register_q2      = isset($_POST["register_question_2"]) ? postdata($_POST["register_question_2"]) : 0;
  $register_q3      = isset($_POST["register_question_3"]) ? postdata($_POST["register_question_3"]) : 0;
  $register_q4      = isset($_POST["register_question_4"]) ? postdata($_POST["register_question_4"]) : 0;

  // On remet les questions de sécurité là où elles étaient
  for($i=1;$i<=3;$i++)
  {
    if($register_q1 == $i)
      $register_check_q1[$i] = " checked";
    if($register_q2 == $i)
      $register_check_q2[$i] = " checked";
    if($register_q3 == $i)
      $register_check_q3[$i] = " checked";
    if($register_q4 == $i)
      $register_check_q4[$i] = " checked";
  }

  // On check si toutes les questions sont remplies
  if(!$register_q1 || !$register_q2 || !$register_q3 || !$register_q4)
    $register_erreur = "Il est obligatoire de répondre aux quatre questions sur le règlement de NoBleme<br>Désolé du dérangement, mais ça nous évite 90% des utilisateurs à problèmes";

  // On check si le pseudo est valide
  if($register_erreur == "" && strlen($_POST["register_pseudo"]) < 3)
    $register_erreur = "Pseudonyme trop court (3 caractères minimum)";
  else if($register_erreur == "" && strlen($_POST["register_pseudo"]) > 18)
    $register_erreur = "Pseudonyme trop long (18 caractères maximum)";

  // On check l'originalité du pseudo
  $allnick = query(" SELECT pseudonyme FROM membres ");

  while($allpseudo = mysqli_fetch_array($allnick))
  {
    if(strtoupper($register_pseudo) == strtoupper($allpseudo['pseudonyme']))
      $register_erreur = "Le pseudonyme choisi existe déjà, merci d'en utiliser un autre";
  }

  // On check si les réponses au QCM sont bonnes
  if($register_erreur == "" && $register_q1 != 2)
    $register_erreur = "Mauvaise réponse à la première question sur les conditions d'utilisation";
  else if($register_erreur == "" && $register_q2 != 1)
    $register_erreur = "Mauvaise réponse à la seconde question sur les conditions d'utilisation";
  else if($register_erreur == "" && $register_q3 != 2)
    $register_erreur = "Mauvaise réponse à la troisième question sur les conditions d'utilisation";
  else if($register_erreur == "" && $register_q4 != 1)
    $register_erreur = "Mauvaise réponse à la quatrième question sur les conditions d'utilisation";

  // On check si tous les champs sont remplis
  if($register_erreur == "" && ($register_pseudo == "" || $register_pass_1 == "" || $register_pass_2 == "" || $register_email == "" || $register_captcha == ""))
    $register_erreur = "Tous les champs sont obligatoires, merci de les remplir !";

  // On check si les mots de passe saisis sont identiques
  if($register_erreur == "" && ($register_pass_1 != $register_pass_2))
    $register_erreur = "Les deux mots de passe saisis ne sont pas identiques";

  // On check si le mot de passe est assez long
  if($register_erreur == "" && strlen($register_pass_1) < 5)
    $register_erreur = "Mot de passe trop court (5 caractères minimum)";

  // On check si le captcha est bien rempli
  if($register_erreur == "" && ($register_captcha != $_SESSION['captcha']))
    $register_erreur = "Mauvaise réponse au test anti-robot";

  // Si pas d'erreur, on peut créer le compte
  if($register_erreur == "")
  {
    // Préparation des données à insérer
    $register_pass  = postdata(salage($register_pass_1));
    $date_creation  = time();

    // Création du compte
    query(" INSERT INTO membres
            SET         pseudonyme    = '$register_pseudo'  ,
                        pass          = '$register_pass'    ,
                        admin         = '0'                 ,
                        sysop         = '0'                 ,
                        email         = '$register_email'   ,
                        date_creation = '$date_creation'    ");

    // Ajout du register dans l'activité
    $new_user = mysqli_insert_id($db);
    query(" INSERT INTO activite
            SET         timestamp   = '$date_creation'    ,
                        pseudonyme  = '$register_pseudo'  ,
                        FKmembres   = '$new_user'         ,
                        action_type = 'register'          ");

    // Bot IRC NoBleme
    ircbot($chemin,"Nouveau membre enregistré sur le site : ".$_POST["register_pseudo"]." - http://www.nobleme.com/pages/user/user?id=".$new_user,"#NoBleme");

    // Envoi d'un message de bienvenue
    envoyer_notif($new_user,"Bienvenue sur NoBleme !",postdata("[size=1.3][b]Bienvenue sur NoBleme ![/b][/size]\r\n\r\nMaintenant que vous êtes inscrit, pourquoi pas rejoindre la communauté là où elle est active :\r\n- Princiaplement [url=".$chemin."pages/irc/index][color=#2F4456][b]sur le serveur IRC[/b][/color][/url], où l'on discute en temps réel\r\n- Parfois sur [url=".$chemin."pages/forum/index][color=#2F4456][b]le forum[/b][/color][/url], où l'on discute en différé\r\n- Et dans tous les endroits actifs dans [url=".$chemin."pages/nobleme/activite][color=#2F4456][b]l'activité récente[/b][/color][/url], où vous aurez une idée de ce qui se passe sur le site\r\n\r\n\r\nBon séjour sur NoBleme,\r\nSi vous avez la moindre question, n'hésitez pas à répondre à ce message.\r\n\r\nVotre administrateur,\r\n[url=".$chemin."pages/user/user?id=1][color=#2F4456][b]Bad[/b][/color][/url]"));

    // Redirection vers la page de bienvenue
    header('Location: ./welcome#bienvenue');

  }
  else
  {
    // Pas d'erreur? On fixe le display
    $register_pseudo  = stripslashes($register_pseudo);
    $register_email   = stripslashes($register_email);
  }
}
else
{
  // Pré-remplissage des champs si pas encore fait
  $register_pseudo  = "";
  $register_email   = "";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
      <br>
      <div class="align_center">
        <img src="<?=$chemin?>img/logos/enregistrement.png" alt="Créer un compte">
      </div>
      <br>

      <?php
      if(isset($_GET["oublie"]))
      {
        ?>

        <div class="body_main midsize">

          <span class="titre">Mot de passe oublié ?</span><br>

          <br>
          Pour des raisons de sécurité évidentes, NoBleme.com n'envoie pas de mot de passe par e-mail.<br>
          <br>
          Il n'y a pas non plus de formulaire de récupération de mot de passe, ou d'envoi de système de réinitialisation de mot de passe par mail, encore une fois pour des raisons de sécurité. Il est trop facile d'exploiter ces systèmes pour voler le compte de quelqu'un.<br>
          <br>
          Si vous avez oublié votre mot de passe, une seule solution: Venez en parler avec <a href="<?=$chemin?>pages/user/user?id=1" target="_blank">Bad</a> sur <a href="<?=$chemin?>pages/irc/index" target="_blank">IRC</a>.<br>
          Je dispose d'une méthode (j'espère) infaillible et très rapide de prouver que vous êtes bien le vrai propriétaire de votre compte.<br>
          Une fois la vérification faite, n'ayant pas d'accès à votre mot de passe, je vais vous mettre un nouveau mot de passe à la place.<br>
          Ce sera ensuite à vous de le changer en un mot de passe qui vous convient mieux.<br>
          <br>
          La meilleure solution reste encore de ne pas oublier son mot de passe !

        </div>

        <?php
      }
      else
      {
        ?>

        <div class="body_main midsize">

          <span class="titre">Code de conduite à respecter sur NoBleme</span><br>
          <br>
          NoBleme est un site cool où les gens sont relax. Il n'y a pas de limite d'âge, et tout contenu est autorisé, sauf les exceptions suivantes :<br>
          <br>
          * Les <b>images pornographiques</b> ou fortement suggestives sont <b>strictement interdites</b>. Elles seront supprimées, et leur auteur banni.<br>
          * Les <b>images gores</b> ou à tendance dégueulasse sont également <b>interdites</b>, NoBleme n'est pas le lieu pour ça.<br>
          * Tout <b>contenu illégal</b> sera immédiatement <b>envoyé à la police</b>. Ne jouez pas avec le feu.<br>
          * Si vous pouvez régler une situation tendue en privé, faites-le. Les auteurs de drames publics seront bannis temporairement.<br>
          * Les trolls, provocateurs gratuits, et emmerdeurs de service pourront être bannis sans sommation s'ils abusent trop.<br>
          * L'écriture SMS et la grammaire sans effort sont à éviter autant que possible. Prenez le temps de bien écrire, ça sera apprécié.<br>
          <br>
          On est avant tout sur NoBleme pour s'amuser et passer du bon temps. Si vos actions ou votre langage empêchent d'autres membres de passer du bon temps, c'est un peu nul, vous trouvez pas ? On peut rire de tout, mais pas avec n'importe qui.<br>
          <br>
          Le pouvoir de bannir est entre les mains de l'administration du site, mais n'est utilisé que très rarement, dans les situations extrêmes.<br>
          Toutefois, si vous cherchez la merde, vous y passerez. Restez cool et on restera cool, c'est aussi simple que ça :)<br>

        </div>

        <br>
        <br>

        <div class="body_main midsize">

          <?php
          // Notification des erreurs
          if($register_erreur != "")
          {
            ?>

            <div class="body_main_title" id="erreur">
              <span class="texte_erreur moinsgros gras">
                <u>Erreur</u> : <?=$register_erreur?>
              </span>
            </div>

            <?php
          }
          else
          {
            ?>

            <span class="titre" id="erreur">Créer un nouveau compte</span><br>

            <?php
          }
          ?>

          <br>

          <form name="register" method="post" action="register#erreur">

            <table class="data_input indiv">

              <tr>
                <td class="data_input_right user_register">
                  Votre pseudonyme :&nbsp;
                </td>
                <td colspan="2">
                  <input class="intable" name="register_pseudo" value="<?=$register_pseudo?>">
                </td>
                <td class="data_input_left user_register_big">
                  &nbsp; Doit faire entre 3 et 18 caractères et ne pas être déjà utilisé
                </td>
              </tr>

              <tr>
                <td colspan="4">
                  &nbsp;
                </td>
              </tr>

              <tr>
                <td class="data_input_right user_register">
                  Mot de passe :&nbsp;
                </td>
                <td colspan="2">
                  <input class="intable" type="password" name="register_pass_1">
                </td>
                <td class="data_input_left user_register_big">
                  &nbsp; 5 caractères minimum, caractères spéciaux et espaces autorisés
                </td>
              </tr>

              <tr>
                <td class="data_input_right user_register">
                  Confirmer :&nbsp;
                </td>
                <td colspan="2">
                  <input class="intable" type="password" name="register_pass_2">
                </td>
                <td class="data_input_left user_register_big">
                  &nbsp; Entrez à nouveau votre mot de passe pour confirmation
                </td>
              </tr>

              <tr>
                <td colspan="4">
                  &nbsp;
                </td>
              </tr>

              <tr>
                <td class="data_input_right user_register">
                  Adresse e-mail :&nbsp;
                </td>
                <td colspan="2">
                  <input class="intable" name="register_email" value="<?=$register_email?>">
                </td>
                <td class="data_input_left user_register_big">
                  &nbsp; Pour vérifier votre identité si vous perdez votre mot de passe
                </td>
              </tr>

              <tr>
                <td class="data_input_right user_register">
                  Test anti-robot :&nbsp;
                </td>
                <td>
                  <img src="<?=$chemin?>inc/captcha.inc.php" alt="Vous devez désactiver votre bloqueur d'image pour voir ce captcha !">
                </td>
                <td>
                  <input class="intable" name="register_captcha" value="">
                </td>
                <td class="data_input_left user_register_big">
                  &nbsp; Prouvez que vous êtes humain en recopiant le nombre affiché
                </td>
              </tr>

            </table>

            <br>
            <br>

            <div class="body_main_title">
              Et maintenant, prouvez que vous avez bien lu les conditions d'utilisation
            </div>
            C'est pas la mort, elles sont courtes à lire. Un petit effort !<br>

            <br>

            <table class="data_input indiv">

              <tr>
                <td class="data_input_right user_register_questions">
                  La pornographie est-elle autorisée ?&nbsp;
                </td>
                <td class="align_left user_register_questions_big">
                  <input type="radio" name="register_question_1" value="1"<?=$register_check_q1[1]?>> Oui &nbsp;&nbsp;
                  <input type="radio" name="register_question_1" value="2"<?=$register_check_q1[2]?>> Non &nbsp;&nbsp;
                  <input type="radio" name="register_question_1" value="3"<?=$register_check_q1[3]?>> Ça dépend des cas
                </td>
              </tr>

              <tr>
                <td class="data_input_right user_register_questions">
                  Les images gores sont-elles tolérées ?&nbsp;
                </td>
                <td class="align_left user_register_questions_big">
                  <input type="radio" name="register_question_2" value="1"<?=$register_check_q2[1]?>> Non &nbsp;&nbsp;
                  <input type="radio" name="register_question_2" value="2"<?=$register_check_q2[2]?>> Oui &nbsp;&nbsp;
                  <input type="radio" name="register_question_2" value="3"<?=$register_check_q2[3]?>> J'en sais rien, j'ai pas lu
                </td>
              </tr>

              <tr>
                <td class="data_input_right user_register_questions">
                  Si je m'engueule avec quelqu'un, je fais quoi ?&nbsp;
                </td>
                <td class="align_left user_register_questions_big">
                  <input type="radio" name="register_question_3" value="1"<?=$register_check_q3[1]?>> J'étale ça sur le forum&nbsp;&nbsp;
                  <input type="radio" name="register_question_3" value="2"<?=$register_check_q3[2]?>> Je résous ça en privé
                </td>
              </tr>

              <tr>
                <td class="data_input_right user_register_questions">
                  Si je fais chier le monde, qu'est-ce qui se passe ?&nbsp;
                </td>
                <td class="align_left user_register_questions_big">
                  <input type="radio" name="register_question_4" value="1"<?=$register_check_q4[1]?>> Je me fais bannir &nbsp;&nbsp;
                  <input type="radio" name="register_question_4" value="2"<?=$register_check_q4[2]?>> Rien, on est dans un pays libre !
                </td>
              </tr>

            </table>

            <br>

            <p class="align_center">
              <input type="image" src="<?=$chemin?>img/boutons/creer_mon_compte.png" alt="Créer mon compte" name="register_go">
            </p>

          </form>

        </div>

        <?php
      }


/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';