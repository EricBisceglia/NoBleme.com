<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
guestonly($lang);

// Identification
$page_nom = "Se crée un compte";
$page_url = "pages/user/register";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Créer un compte" : "Register";
$page_desc  = "Rejoindre la communauté NoBleme en se créant un compte";

// JS
$js = array('dynamique', '/user/register');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Vérification et validation des données
if (isset($_POST["register_pseudo"]))
{
  // Assainissement du postdata
  $register_pseudo  = postdata($_POST["register_pseudo"],"string");
  $register_pass_1  = postdata($_POST["register_pass_1"],"string");
  $register_pass_2  = postdata($_POST["register_pass_2"],"string");
  $register_email   = postdata($_POST["register_email"],"string");
  $register_captcha = postdata($_POST["register_captcha"],"string");
  $register_erreur  = "";

  // On remet les questions de sécurité là où elles étaient
  $register_q1      = isset($_POST["register_question_1"]) ? postdata($_POST["register_question_1"]) : 0;
  $register_q2      = isset($_POST["register_question_2"]) ? postdata($_POST["register_question_2"]) : 0;
  $register_q3      = isset($_POST["register_question_3"]) ? postdata($_POST["register_question_3"]) : 0;
  $register_q4      = isset($_POST["register_question_4"]) ? postdata($_POST["register_question_4"]) : 0;
  for($i=1;$i<=3;$i++)
  {
    $register_check_q1[$i] = ($register_q1 == $i) ? " checked" : "";
    $register_check_q2[$i] = ($register_q2 == $i) ? " checked" : "";
    $register_check_q3[$i] = ($register_q3 == $i) ? " checked" : "";
    $register_check_q4[$i] = ($register_q4 == $i) ? " checked" : "";
  }

  // On vérifie si le pseudo est valide
  if($register_erreur == "" && strlen($_POST["register_pseudo"]) < 3)
    $register_erreur = ($lang == 'FR') ? "Pseudonyme trop court" : "Nickname is too short";
  else if($register_erreur == "" && strlen($_POST["register_pseudo"]) > 15)
    $register_erreur = ($lang == 'FR') ? "Pseudonyme trop long" : "Nickname is too long";
  else if($register_erreur == "" && strlen($_POST["register_pass_1"]) < 6)
    $register_erreur = ($lang == 'FR') ? "Mot de passe trop court" : "Password is too short";

  // On vérifie l'originalité du pseudo
  $qallnick = query(" SELECT pseudonyme FROM membres ");
  while($dallnick = mysqli_fetch_array($qallnick))
  {
    if(changer_casse($register_pseudo, 'maj') == changer_casse($dallnick['pseudonyme'], 'maj'))
      $register_erreur = "Le pseudonyme choisi existe déjà, merci d'en utiliser un autre";
  }

  // On vérifie que tout soit bien rempli
  if($register_erreur == "" && ($register_pseudo == "" || $register_pass_1 == "" || $register_pass_2 == "" || $register_email == "" || $register_captcha == ""))
    $register_erreur = ($lang == 'FR') ? "Tous les champs sont obligatoires" : "All fields are mandatory";

  // On check si le captcha est bien rempli
  if($register_erreur == "" && ($register_captcha != $_SESSION['captcha']))
    $register_erreur = ($lang == 'FR') ? "Mauvaise réponse au test anti-robot" : "You failed the anti-robot test, try again";

  // Si pas d'erreur, on peut créer le compte
  if($register_erreur == "")
  {
    $register_pass  = postdata(salage($_POST["register_pass_1"]), 'string');
    $date_creation  = time();

    // Création du compte
    query(" INSERT INTO membres
            SET         membres.pseudonyme            = '$register_pseudo'  ,
                        membres.pass                  = '$register_pass'    ,
                        membres.admin                 = 0                   ,
                        membres.sysop                 = 0                   ,
                        membres.moderateur            = ''                  ,
                        membres.email                 = '$register_email'   ,
                        membres.date_creation         = '$date_creation'    ,
                        membres.derniere_visite       = '$date_creation'    ,
                        membres.derniere_visite_page  = 'Index'             ,
                        membres.derniere_visite_url   = 'index.php'         ,
                        membres.derniere_activite     = '$date_creation'    ");

    // Activité récente
    $new_user = mysqli_insert_id($db);
    activite_nouveau('register', 0, $new_user, $register_pseudo);

    // Bot IRC NoBleme
    ircbot($chemin, "Nouveau membre enregistré sur le site : ".$_POST["register_pseudo"]." - ".$GLOBALS['url_site']."pages/user/user?id=".$new_user, "#NoBleme");
    ircbot($chemin, "A new member registered on the website: ".$_POST["register_pseudo"]." - ".$GLOBALS['url_site']."pages/user/user?id=".$new_user, "#english");

    // Préparation du message de bienvenue
    if($lang == 'FR')
      $temp_contenu = <<<EOD
[size=1.3][b]Bienvenue sur NoBleme ![/b][/size]

Maintenant que vous êtes inscrit, pourquoi pas rejoindre la communauté là où elle est active :
- Princiaplement [url={$chemin}pages/irc/index]sur le serveur IRC[/url], où l'on discute en temps réel
- Parfois sur [url={$chemin}pages/forum/index]le forum[/url], où l'on discute en différé
- Et dans tous les endroits actifs dans [url={$chemin}pages/nobleme/activite]l'activité récente[/url], où vous aurez une idée de ce qui se passe sur le site

Bon séjour sur NoBleme !
Si vous avez la moindre question, n'hésitez pas à répondre à ce message.

Votre administrateur,
[url={$chemin}pages/user/user?id=1]Bad[/url]
EOD;
    else
      $temp_contenu = <<<EOD
"[size=1.3][b]Welcome to NoBleme![/b][/size]

Now that you have registered, why not join the community where it is most active :
- Mainly on [url={$chemin}pages/irc/index]the IRC server[/url], where we chat in real time
- Sometimes on [url={$chemin}pages/forum/index]the forum[/url], on which we share things every now and then
- And everywhere that's active in the [url={$chemin}pages/nobleme/activite]recent activity[/url], which should show you what's going on on the website

Enjoy your stay on NoBleme!
If you have any questions, feel free to reply to this message.

Your admin,
[url={$chemin}pages/user/user?id=1]Bad[/url]
EOD;

    // Envoi du message de bienvenue
    $temp_titre = ($lang == 'FR') ? "Bienvenue sur NoBleme !" : "Welcome to NoBleme!";
    envoyer_notif($new_user, $temp_titre, postdata($temp_contenu));

    // Redirection vers la page de bienvenue
    header('Location: ./login?bienvenue');
  }
  // Si y'a une erreur, on fixe l'affichage
  else
  {
    $register_pseudo  = predata(stripslashes($register_pseudo));
    $register_email   = predata(stripslashes($register_email));
    $register_pass_1  = predata(stripslashes($register_pass_1));
    $register_pass_2  = predata(stripslashes($register_pass_2));
  }
}

// Sinon on remet tout à zéro
else
{
  $register_pseudo  = "";
  $register_pass_1  = "";
  $register_pass_2  = "";
  $register_email   = "";
  $register_erreur  = "";
  for($i=1;$i<=3;$i++)
  {
    $register_check_q1[$i]  = "";
    $register_check_q2[$i]  = "";
    $register_check_q3[$i]  = "";
    $register_check_q4[$i]  = "";
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Titre et intro
  $trad['titre']      = "Créer un compte";
  $trad['soustitre']  = "Code de conduite à respecter sur NoBleme";

  // Formulaire d'inscription
  $trad['reg_pseudo'] = "Choisissez un pseudonyme (3 à 15 caractères)";
  $trad['reg_pass']   = "Mot de passe (6 caractères minimum)";
  $trad['reg_pass2']  = "Entrez à nouveau votre mot de passe";
  $trad['reg_email']  = "Adresse e-mail (utile si vous oubliez votre mot de passe)";
  $trad['reg_humain'] = "Prouvez que vous êtes humain en recopiant ce nombre";
  $trad['reg_capalt'] = "Vous devez désactiver votre bloqueur d'image pour voir ce captcha !";
  $trad['reg_creer']  = "Créer mon compte";

  // Questionnaire sur le code de conduite
  $trad['reg_quest1'] = "La pornographie est-elle autorisée ?";
  $trad['reg_repq11'] = "Oui";
  $trad['reg_repq12'] = "Non";
  $trad['reg_repq13'] = "Ça dépend des cas";
  $trad['reg_quest2'] = "Les images gores sont-elle tolérées ?";
  $trad['reg_repq21'] = "Oui";
  $trad['reg_repq22'] = "Non";
  $trad['reg_repq23'] = "Je n'ai pas lu les règles";
  $trad['reg_quest3'] = "Je m'engueule de façon virulente avec quelqu'un, je fais quoi ?";
  $trad['reg_repq31'] = "J'étale ça en public";
  $trad['reg_repq32'] = "Je tente de résoudre ça en privé";
  $trad['reg_quest4'] = "Je suis aggressif avec les autres, qu'est-ce qui va m'arriver ?";
  $trad['reg_repq41'] = "Je me fais bannir";
  $trad['reg_repq42'] = "La liberté d'expression me protège !";

  // Code de conduite
  $trad['reg_coc']    = <<<EOD
<p>
  NoBleme est un site à l'ambiance relax. Il n'y a pas de restriction d'âge, et peu de restrictions de contenu. Il y a juste un code de conduite minimaliste à respecter, afin de tous cohabiter paisiblement. Pour s'assurer que tout le monde lise le code de conduite (il est court), vous devez répondre à des questions à son sujet lors de la création de votre compte.
</p>
<br>
<ul>
  <li>
    Tout <span class="gras">contenu illégal</span> sera immédiatement <span class="gras">envoyé à la police</span>. Ne jouez pas avec le feu.
  </li>
  <li>
    Vu qu'il n'y a pas de restriction d'âge, les <span class="gras">images pornographiques</span> ou suggestives <span class="gras">sont interdites</span>.
  </li>
  <li>
    Les <span class="gras">images gores</span> ou à tendance dégueulasse sont <span class="gras">également interdites</span>. NoBleme n'est pas le lieu pour ça.
  </li>
  <li>
    L'<span class="gras">incitation à la haine</span> et les <span class="gras">propos discriminatoires</span> auront pour réponse un <span class="gras">bannissement immédiat et permanent</span>.
  </li>
  <li>
    Si vous pouvez régler une situation tendue en privé plutôt qu'en public, faites l'effort, sinon vous finirez tous les deux bannis.
  </li>
  <li>
    Les trolls, provocateurs gratuits, et emmerdeurs de service pourront être bannis sans sommation s'ils abusent trop.
  </li>
</ul>
<br>
On est avant tout sur NoBleme pour passer du bon temps. Si vos actions ou votre langage empêchent d'autres personnes de passer du bon temps, c'est un peu nul, non ? Essayez d'être bienveillants : ce n'est pas un grand effort, et tout le monde en bénéficie.<br>
<br>
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Titre et intro
  $trad['titre']      = "Register an account";
  $trad['soustitre']  = "Code of conduct to follow on NoBleme";

  // Formulaire d'inscription
  $trad['reg_pseudo'] = "Choose a nickname (3 to 15 characters long)";
  $trad['reg_pass']   = "Your password (at least 6 characters long)";
  $trad['reg_pass2']  = "Confirm your password by typing it again";
  $trad['reg_email']  = "E-mail address (useful if you forget your password)";
  $trad['reg_humain'] = "Prove you are human by copying this number";
  $trad['reg_capalt'] = "You must turn off your image blocker to see this captcha !";
  $trad['reg_creer']  = "Create my account";

  // Questionnaire sur le code de conduite
  $trad['reg_quest1'] = "Is pornography allowed?";
  $trad['reg_repq11'] = "Yes";
  $trad['reg_repq12'] = "No";
  $trad['reg_repq13'] = "It depends";
  $trad['reg_quest2'] = "Can I post gore images?";
  $trad['reg_repq21'] = "Yes";
  $trad['reg_repq22'] = "No";
  $trad['reg_repq23'] = "I didn't read the rules";
  $trad['reg_quest3'] = "I'm having a tense argument with someone, what should I do?";
  $trad['reg_repq31'] = "Spread it publicly";
  $trad['reg_repq32'] = "Try my best to solve it privately";
  $trad['reg_quest4'] = "I'm being aggressive towards others, what will happen to me?";
  $trad['reg_repq41'] = "I will get banned";
  $trad['reg_repq42'] = "Nothing, free speech protects me!";

  // Code de conduite
  $trad['reg_coc']    = <<<EOD
<p>
  NoBleme is a small community with a laid back mood. There is no age restriction, and very few restrictions on content. However, in order to all coexist peacefully, there is a minimalistic code of conduct that everyone should respect. In order to ensure that everyone reads it (it's short), you will have to answer a few questions about it when registering your account.
</p>
<br>
<ul>
  <li>
    Obviously, <span class="gras">illegal content</span> will immediately be <span class="gras">sent to the police</span>. Don't play with fire.
  </li>
  <li>
    Since NoBleme has no age restriction <span class="gras">pornography</span> or extra suggestive content <span class="gras">is forbidden</span>.
  </li>
  <li>
    All <span class="gras">gore images</span> and other disgusting things are <span class="gras">also forbidden</span>. NoBleme is not the right place for that.
  </li>
  <li>
    Any form of <span class="gras">hate speech, discrimination, or incitation to violence</span> will be met with an <span class="gras">immediate and permanent ban</span>.
  </li>
  <li>
    If you have to argue with someone about a tense situation, do it in private. If done publicly, you will both end up banned.
  </li>
  <li>
    Trolls and other kinds of purposeful agitators will be banned without a warning if they try to test boundaries.
  </li>
</ul>
<br>
We are first and foremost on NoBleme to have a good time together. If your actions or your language prevent other people from having a good time, it's a bit silly, isn't it? Try to stay respectful of others and we'll all benefit from it.<br>
<br>
EOD;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte2">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <?=$trad['reg_coc']?>

        <br>

        <div class="minitexte2">

        <form method="POST" id="register_formulaire" action="register#register_formulaire">
          <fieldset>

            <label for="register_pseudo" id="label_register_pseudo"><?=$trad['reg_pseudo']?></label>
            <input id="register_pseudo" name="register_pseudo" class="indiv" type="text" value="<?=$register_pseudo?>" maxlength="15"><br>
            <br>

            <label for="register_pass_1" id="label_register_pass_1"><?=$trad['reg_pass']?></label>
            <input id="register_pass_1" name="register_pass_1" class="indiv" type="password" value="<?=$register_pass_1?>"><br>
            <br>

            <label for="register_pass_2" id="label_register_pass_2"><?=$trad['reg_pass2']?></label>
            <input id="register_pass_2" name="register_pass_2" class="indiv" type="password" value="<?=$register_pass_2?>"><br>
            <br>

            <label for="register_email" id="label_register_email"><?=$trad['reg_email']?></label>
            <input id="register_email" name="register_email" class="indiv" type="text" value="<?=$register_email?>"><br>
            <br>

            <label for="register_question_1" id="label_register_question_1"><?=$trad['reg_quest1']?></label>
            <div class="flexcontainer">
              <div style="flex:1">
            <input id="register_question_1" name="register_question_1" value="1" type="radio"<?=$register_check_q1[1]?>>
            <label class="label-inline" for="register_question_1"><?=$trad['reg_repq11']?></label>
              </div>
              <div style="flex:1">
            <input name="register_question_1" value="2" type="radio"<?=$register_check_q1[2]?>>
            <label class="label-inline" for="register_question_1"><?=$trad['reg_repq12']?></label>
              </div>
              <div style="flex:3">
            <input name="register_question_1" value="3" type="radio"<?=$register_check_q1[3]?>>
            <label class="label-inline" for="register_question_1"><?=$trad['reg_repq13']?></label><br>
              </div>
            </div>
            <br>

            <label for="register_question_2" id="label_register_question_2"><?=$trad['reg_quest2']?></label>
            <div class="flexcontainer">
              <div style="flex:1">
            <input id="register_question_2" name="register_question_2" value="1" type="radio"<?=$register_check_q2[1]?>>
            <label class="label-inline" for="register_question_2"><?=$trad['reg_repq21']?></label>
              </div>
              <div style="flex:1">
            <input name="register_question_2" value="2" type="radio"<?=$register_check_q2[2]?>>
            <label class="label-inline" for="register_question_2"><?=$trad['reg_repq22']?></label>
              </div>
              <div style="flex:3">
            <input name="register_question_2" value="3" type="radio"<?=$register_check_q2[3]?>>
            <label class="label-inline" for="register_question_2"><?=$trad['reg_repq23']?></label><br>
              </div>
            </div>
            <br>

            <label for="register_question_3" id="label_register_question_3"><?=$trad['reg_quest3']?></label>
            <div class="flexcontainer">
              <div style="flex:2">
            <input id="register_question_3" name="register_question_3" value="1" type="radio"<?=$register_check_q3[1]?>>
            <label class="label-inline" for="register_question_2"><?=$trad['reg_repq31']?></label>
              </div>
              <div style="flex:3">
            <input name="register_question_3" value="2" type="radio"<?=$register_check_q3[2]?>>
            <label class="label-inline" for="register_question_3"><?=$trad['reg_repq32']?></label>
              </div>
            </div>
            <br>

            <label for="register_question_4" id="label_register_question_4"><?=$trad['reg_quest4']?></label>
            <div class="flexcontainer">
              <div style="flex:2">
            <input id="register_question_4" name="register_question_4" value="1" type="radio"<?=$register_check_q4[1]?>>
            <label class="label-inline" for="register_question_4"><?=$trad['reg_repq41']?></label>
              </div>
              <div style="flex:3">
            <input name="register_question_4" value="2" type="radio"<?=$register_check_q4[2]?>>
            <label class="label-inline" for="register_question_4"><?=$trad['reg_repq42']?></label>
              </div>
            </div>
            <br>

            <label for="register_captcha" id="label_register_captcha"><?=$trad['reg_humain']?></label>
            <div class="flexcontainer">
              <div style="flex:1">
                <img src="<?=$chemin?>inc/captcha.inc.php" alt="<?=$trad['reg_capalt']?>">
              </div>
              <div style="flex:4">
                <input id="register_captcha" name="register_captcha" class="indiv" type="text"><br>
              </div>
            </div>

          </fieldset>
        </form>

        <?php if($register_erreur != "") { ?>
        <p>
          <span class="texte_blanc negatif spaced moinsgros gras">
            <?=$register_erreur?>
          </span>
        </p>
        <?php } ?>

        <br>

        <button onclick="creer_compte('<?=$chemin?>');"><?=$trad['reg_creer']?></button>

      </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';