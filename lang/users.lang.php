<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  RECENT ACTIVITY                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Push page names into the existing user activity array
$page_names['users_login_en']     = "Is logging into his account";
$page_names['users_login_fr']     = "Se connecte à son compte";
$page_names['users_forgotten_en'] = "Forgot his password";
$page_names['users_forgotten_fr'] = "A oublié son mot de passe";
$page_names['users_register_en']  = "Se crée un nouveau compte";
$page_names['users_register_fr']  = "Is creating a new account";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       LOGIN                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Page title
___('users_login_title', 'EN', "Login");
___('users_login_title', 'FR', "Connexion");


// Welcome message
___('users_login_welcome', 'EN', "Welcome to NoBleme!<br>Your account has succesfully been created, you can now log in.");
___('users_login_welcome', 'FR', "Bienvenue sur NoBleme !<br>Votre compte a été crée, vous pouvez maintenant vous y connecter.");


// Login form
___('users_login_form_create', 'EN', "Don't have an account? Click here to register one!");
___('users_login_form_create', 'FR', "Vous n'avez pas de compte ? Cliquez ici pour en créer un !");
___('users_login_form_remember', 'EN', "Stay logged in");
___('users_login_form_remember', 'FR', "Rester connecté");
___('users_login_form_forgotten_password', 'EN', "Forgot your account's password? Click here.");
___('users_login_form_forgotten_password', 'FR', "Vous avez oublié votre mot de passe ? Cliquez ici.");
___('users_login_form_register', 'EN', 'REGISTER');
___('users_login_form_register', 'FR', 'INSCRIPTION');


// Error messages
___('users_login_error_no_nickname', 'EN', "You must specify a nickname");
___('users_login_error_no_nickname', 'FR', "Vous devez saisir un pseudonyme");
___('users_login_error_no_password', 'EN', "You must specify a password");
___('users_login_error_no_password', 'FR', "Vous devez saisir un mot de passe");
___('users_login_error_bruteforce', 'EN', "You are trying to log in too often, please wait 10 minutes");
___('users_login_error_bruteforce', 'FR', "Trop de tentatives de connexion, merci d'attendre 10 minutes");
___('users_login_error_wrong_user', 'EN', "This nickname does not exist on the website");
___('users_login_error_wrong_user', 'FR', "Ce pseudonyme n'existe pas sur le site");
___('users_login_error_wrong_password', 'EN', "Incorrect password for this nickname");
___('users_login_error_wrong_password', 'FR', "Mauvais mot de passe pour ce pseudonyme");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                FORGOTTEN PASSWORD                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Body
___('users_forgotten_title', 'EN', 'Forgotten password');
___('users_forgotten_title', 'FR', 'Mot de passe oublié');

___('users_forgotten_body', 'EN', <<<EOT
For obvious safety reasons, NoBleme account passwords are not sent through e-mail upon registering. Sadly, there is no working automated password resetting form right now (yet), which means that password recovery can be a touchy process. If you want to get back into your lost account, what you should do is go on {{link|pages/irc/index|NoBleme's IRC chat server}}, message a member of NoBleme's {{link|pages/nobleme/admins|administrative team}}, and ask them to manually reset your account's password.
EOT
);
___('users_forgotten_body', 'FR', <<<EOT
Pour des raisons de sécurité évidentes, NoBleme ne vous envoie pas votre mot de passe par e-mail lorsque vous créez votre compte. Malheureusement, il n'y a pour le moment pas de système de remise à zéro de mot de passe, ce qui rend le cas des mots de passe oubliés assez gênant. La solution temporaire à ce problème est de vous rendre sur le {{link|pages/irc/index|serveur de discussion IRC de NoBleme}}, d'y contacter un membre de {{link|pages/nobleme/admins|l'équipe administrative}}, et de lui demander de changer manuellement le mot de passe de votre compte.
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     REGISTER                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header & Code of conduct
___('users_register_title', 'EN', "Register an account");
___('users_register_title', 'FR', "Créer un compte");
___('users_register_subtitle', 'EN', "Code of conduct to follow when using NoBleme");
___('users_register_subtitle', 'FR', "Code de conduite à respecter sur NoBleme");
___('users_register_coc', 'EN', "We want to make sure that all users of the website understand that, even though there are few rules and little repression on NoBleme, there still exists a code of conduct that should be followed by all. In order to ensure that everyone reads it at least once, you will be asked some questions relating to NoBleme's code of conduct during the process of creating your account.");
___('users_register_coc', 'FR', "Nous voulons nous assurer que tous les utilisateurs du site comprennent que, même s'il y a très peu de règles ou de répression sur NoBleme, il existe tout de même un code de conduite que tous doivent respecter. Afin de vérifier que tout le monde le lise au moins une fois, quelques questions vous serons posées sur ce code de conduite lors de la création de votre compte.");


// Registration form
___('users_register_form_nickname', 'EN', "Choose a nickname (3 to 15 characters long)");
___('users_register_form_nickname', 'FR', "Choisissez un pseudonyme (3 à 15 caractères)");
___('users_register_form_password_1', 'EN', "Your password (at least 8 characters long)");
___('users_register_form_password_1', 'FR', "Mot de passe (8 caractères minimum)");
___('users_register_form_password_2', 'EN', "Confirm your password by typing it again");
___('users_register_form_password_2', 'FR', "Entrez à nouveau votre mot de passe");
___('users_register_form_email', 'EN', "E-mail address (useful if you forget your password)");
___('users_register_form_email', 'FR', "Adresse e-mail (utile si vous oubliez votre mot de passe)");

___('users_register_form_question_1', 'EN', "Is pornography allowed?");
___('users_register_form_question_1', 'FR', "La pornographie est-elle autorisée ?");
___('users_register_form_question_1_maybe', 'EN', "It depends");
___('users_register_form_question_1_maybe', 'FR', "Ça dépend des cas");

___('users_register_form_question_2', 'EN', "Can I share gore images?");
___('users_register_form_question_2', 'FR', "Les images gores sont-elle tolérées ?");
___('users_register_form_question_2_dummy', 'EN', "I didn't read the rules");
___('users_register_form_question_2_dummy', 'FR', "Je n'ai pas lu les règles");

___('users_register_form_question_3', 'EN', "I'm having a tense argument with someone, what should I do?");
___('users_register_form_question_3', 'FR', "Mes échanges avec quelqu'un d'autre dégénèrent, je fais quoi ?");
___('users_register_form_question_3_silly', 'EN', "Spread it publicly");
___('users_register_form_question_3_silly', 'FR', "J'étale ça en public");
___('users_register_form_question_3_good', 'EN', "Try my best to solve it privately");
___('users_register_form_question_3_good', 'FR', "Je tente de résoudre ça en privé");

___('users_register_form_question_4', 'EN', "I'm being aggressive towards others, what will happen to me?");
___('users_register_form_question_4', 'FR', "Je suis aggressif avec les autres, qu'est-ce qui va m'arriver ?");
___('users_register_form_question_4_banned', 'EN', "I will get banned");
___('users_register_form_question_4_banned', 'FR', "Je me fais bannir");
___('users_register_form_question_4_freedom', 'EN', "Nothing, free speech protects me!");
___('users_register_form_question_4_freedom', 'FR', "La liberté d'expression me protège !");

___('users_register_form_captcha', 'EN', "Prove that you are a human by copying this number");
___('users_register_form_captcha', 'FR', "Prouvez que vous êtes humain en recopiant ce nombre");
___('users_register_form_captcha_alt', 'EN', "You must turn off your image blocker to see this captcha !");
___('users_register_form_captcha_alt', 'FR', "Vous devez désactiver votre bloqueur d'image pour voir ce captcha !");

___('users_register_form_submit', 'EN', "Create my account");
___('users_register_form_submit', 'FR', "Créer mon compte");


// Error messages
___('users_register_error_no_email', 'EN', "You must specify an email");
___('users_register_error_no_email', 'FR', "Vous devez saisir une adresse e-mail");
___('users_register_error_passwords', 'EN', "You must enter the same password twice");
___('users_register_error_passwords', 'FR', "Vous devez saisir deux fois le même mot de passe");
___('users_register_error_captchas', 'EN', "The number you entered in the last field did not match the number on the image");
___('users_register_error_captchas', 'FR', "Le nombre que vous avez saisi dans le dernier champ ne correspond pas à celui sur l'image");

___('users_register_error_nickname_short', 'EN', "The chosen nickname is too short");
___('users_register_error_nickname_short', 'FR', "Le pseudonyme choisi est trop court");
___('users_register_error_nickname_long', 'EN', "The chosen nickname is too long");
___('users_register_error_nickname_long', 'FR', "Le pseudonyme choisi est trop long");
___('users_register_error_password_short', 'EN', "The chosen password is too short");
___('users_register_error_password_short', 'FR', "Le mot de passe choisi est trop court");
___('users_register_error_nickname_taken', 'EN', "The chosen nickname is already taken by another user");
___('users_register_error_nickname_taken', 'FR', "Le pseudonyme choisi est déjà utilisé par un autre membre");


// Welcome private message
___('users_register_private_message_title', 'EN', "Welcome to NoBleme!");
___('users_register_private_message_title', 'FR', "Bienvenue sur NoBleme !");
___('users_register_private_message', 'EN', <<<EOT
[size=1.3][b]Welcome to NoBleme![/b][/size]

Now that you have registered, why not join the community where it is most active: on [url={{1}}pages/irc/index]the IRC chat server[/url].

If you are curious what is being active on the website recently, why not check out the [url={{1}}pages/nobleme/activity]recent activity page[/url] - that's what it's here for!

Enjoy your stay on NoBleme!
If you have any questions, feel free to reply to this message.

Your admin,
[url={{1}}pages/users/user?id=1]Bad[/url]
EOT
);
___('users_register_private_message', 'FR', <<<EOT
[size=1.3][b]Bienvenue sur NoBleme ![/b][/size]

Maintenant que vous avez rejoint le site, pourquoi ne pas rejoindre la communauté là où elle est active : sur [url={{1}}pages/irc/index]le serveur de discussion IRC[/url].

Si vous êtes curieux de ce qui se passe sur le site en ce moment, la page [url={{1}}pages/nobleme/activity]d'activité récente[/url] est là exprès pour ça.

Bon séjour sur NoBleme !
Si vous avez la moindre question, n'hésitez pas à répondre à ce message.

Votre administrateur,
[url={{1}}pages/users/user?id=1]Bad[/url]
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   WHO'S ONLINE                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('users_online_title', 'EN', "Who's online?");
___('users_online_title', 'FR', "Qui est en ligne ?");

___('users_online_header_intro', 'EN', "This page lists the most recently visited page of all users that were active on NoBleme in the last month. In the case of guests (users without an account), only the 1000 most recent ones are displayed, and randomly generated silly nicknames are assigned to each of them. If you fear that it might enable stalking in ways you're not comfortable with and want to be hidden from this page, you can do that in your account's {{link|pages/users/privacy|privacy options}}.");
___('users_online_header_intro', 'FR', "Cette page recense l'activité la plus récente des visiteurs qui ont fréquenté NoBleme ce mois-ci. Dans le cas des invités (visiteurs non connectés), seuls les 1000 plus récents sont affichés, et de petits surnoms stupides leur sont aléatoirement assignés. Si vous craignez que cette page permette à des gens de vous traquer ou n'êtes juste pas confortable avec le fait d'avoir votre activité listée publiquement, vous pouvez retirer votre compte de la liste via vos {{link|pages/users/privacy|options de vie privée}}.");

___('users_online_header_colors', 'EN', <<<EOD
In order to tell them apart from each other, users are color coded:<br>
- Guests will not have any specific color.<br>
- {{link+|pages/users/list|Registered users|normal}} have a <span class="grey_light text_black bold spaced">light grey</span> background.<br>
- {{link+|pages/users/admins|Moderators|normal}} have a <span class="positive text_white bold spaced">green</span> background.<br>
- {{link+|pages/users/admins|Global moderators|normal}} have a <span class="neutral text_white bold spaced">orange</span> background.<br>
- {{link+|pages/users/admins|Administrators|normal}} have a <span class="negative text_white bold spaced">red</span> background.
EOD
);
___('users_online_header_colors', 'FR', <<<EOD
Afin de les distinguer, les visiteurs suivent un code couleur :<br>
- Les invités n'ont pas de couleur spécifique.<br>
- {{link+|pages/users/list|Les membres du site|normal}} ont un arrière-plan <span class="grey_light text_black bold spaced">gris clair</span><br>
- {{link+|pages/users/admins|Les modérateurs|normal}} ont un arrière-plan <span class="positive text_white bold spaced">vert</span><br>
- {{link+|pages/users/admins|Les modérateurs globaux|normal}} ont un arrière-plan <span class="neutral text_white bold spaced">orange</span><br>
- {{link+|pages/users/admins|Les administrateurs|normal}} ont un arrière-plan <span class="negative text_white bold spaced">rouge</span>
EOD
);


// Options
___('users_online_hide_gests', 'EN', "Do not show guests in the list");
___('users_online_hide_gests', 'FR', "Ne pas afficher les invités dans la liste");
___('users_online_admin_view', 'EN', "See the table like a regular user would");
___('users_online_admin_view', 'FR', "Voir la page comme un utilisateur normal");
___('users_online_refresh', 'EN', "Automatically reload the table every 10 seconds");
___('users_online_refresh', 'FR', "Recharger automatiquement la liste toutes les 10 secondes");


// Table
___('users_online_activity', 'EN', "LATEST ACTIVITY");
___('users_online_activity', 'FR', "DERNIÈRE ACTIVITÉ");
___('users_online_page', 'EN', "LAST VISITED PAGE");
___('users_online_page', 'FR', "DERNIÈRE PAGE VISITÉE");