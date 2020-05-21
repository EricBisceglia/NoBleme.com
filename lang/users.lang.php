<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     REGISTER                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header & Code of conduct
___('users_register_title',     'EN', "Register an account");
___('users_register_title',     'FR', "Créer un compte");
___('users_register_subtitle',  'EN', "Code of conduct to follow when using NoBleme");
___('users_register_subtitle',  'FR', "Code de conduite à respecter sur NoBleme");
___('users_register_coc',       'EN', "We want to make sure that all users of the website understand that, even though there are few rules and little repression on NoBleme, there still exists a code of conduct that should be followed by all. In order to ensure that everyone reads it at least once, you will be asked some questions relating to NoBleme's code of conduct during the process of creating your account.");
___('users_register_coc',       'FR', "Nous voulons nous assurer que tous les utilisateurs du site comprennent que, même s'il y a très peu de règles ou de répression sur NoBleme, il existe tout de même un code de conduite que tous doivent respecter. Afin de vérifier que tout le monde le lise au moins une fois, quelques questions vous serons posées sur ce code de conduite lors de la création de votre compte.");


// Registration form
___('users_register_form_nickname',             'EN', "Your username (3 to 15 characters, letters & numbers only)");
___('users_register_form_nickname',             'FR', "Pseudonyme (3 à 15 caractères, chiffres & lettres sans accents)");
___('users_register_form_nickname_is_illegal',  'EN', "This username is not allowed, please choose another one");
___('users_register_form_nickname_is_illegal',  'FR', "Ce pseudonyme n'est pas autorisé, merci d'en choisir un autre");
___('users_register_form_nickname_exists',      'EN', "This username is already in use, please choose another one");
___('users_register_form_nickname_exists',      'FR', "Ce pseudonyme est déjà utilisé, merci d'en choisir un autre");
___('users_register_form_password_1',           'EN', "Password (at least 8 characters long)");
___('users_register_form_password_1',           'FR', "Mot de passe (8 caractères minimum)");
___('users_register_form_password_2',           'EN', "Confirm your password by typing it again");
___('users_register_form_password_2',           'FR', "Entrez à nouveau votre mot de passe pour le confirmer");
___('users_register_form_email',                'EN', "E-mail address (optional, useful if you forget your password)");
___('users_register_form_email',                'FR', "Adresse e-mail (optionnel, utile en cas de mot de passe oublié)");
___('users_register_form_question_1',           'EN', "Is pornography allowed?");
___('users_register_form_question_1',           'FR', "La pornographie est-elle autorisée ?");
___('users_register_form_question_1_maybe',     'EN', "It depends");
___('users_register_form_question_1_maybe',     'FR', "Ça dépend des cas");
___('users_register_form_question_2',           'EN', "Can I share gore images?");
___('users_register_form_question_2',           'FR', "Les images gores sont-elle tolérées ?");
___('users_register_form_question_2_dummy',     'EN', "I didn't read the rules");
___('users_register_form_question_2_dummy',     'FR', "Je n'ai pas lu les règles");
___('users_register_form_question_3',           'EN', "I'm having a tense argument with someone, what should I do?");
___('users_register_form_question_3',           'FR', "Mes échanges avec quelqu'un d'autre dégénèrent, je fais quoi ?");
___('users_register_form_question_3_silly',     'EN', "Spread it publicly");
___('users_register_form_question_3_silly',     'FR', "J'étale ça en public");
___('users_register_form_question_3_good',      'EN', "Try my best to solve it privately");
___('users_register_form_question_3_good',      'FR', "Je tente de résoudre ça en privé");
___('users_register_form_question_4',           'EN', "I'm being aggressive towards others, what will happen to me?");
___('users_register_form_question_4',           'FR', "Je suis aggressif avec les autres, qu'est-ce qui va m'arriver ?");
___('users_register_form_question_4_banned',    'EN', "I will get banned");
___('users_register_form_question_4_banned',    'FR', "Je me fais bannir");
___('users_register_form_question_4_freedom',   'EN', "Nothing, free speech protects me!");
___('users_register_form_question_4_freedom',   'FR', "La liberté d'expression me protège !");
___('users_register_form_captcha',              'EN', "Prove that you are a human by copying this number");
___('users_register_form_captcha',              'FR', "Prouvez que vous êtes humain en recopiant ce nombre");
___('users_register_form_captcha_alt',          'EN', "You must turn off your image blocker to see this captcha !");
___('users_register_form_captcha_alt',          'FR', "Vous devez désactiver votre bloqueur d'image pour voir ce captcha !");
___('users_register_form_submit',               'EN', "Create my account");
___('users_register_form_submit',               'FR', "Créer mon compte");


// Error messages
___('users_register_error_no_email',            'EN', "You must specify an email");
___('users_register_error_no_email',            'FR', "Vous devez saisir une adresse e-mail");
___('users_register_error_passwords',           'EN', "You must enter the same password twice");
___('users_register_error_passwords',           'FR', "Vous devez saisir deux fois le même mot de passe");
___('users_register_error_password_length',     'EN', "Your password is too short (8 characters minimum)");
___('users_register_error_password_length',     'FR', "Votre mot de passe est trop court (8 caractères minimum)");
___('users_register_error_captchas',            'EN', "The number you entered in the last field did not match the number on the image");
___('users_register_error_captchas',            'FR', "Le nombre que vous avez saisi dans le dernier champ ne correspond pas à celui sur l'image");
___('users_register_error_nickname_short',      'EN', "The chosen username is too short");
___('users_register_error_nickname_short',      'FR', "Le pseudonyme choisi est trop court");
___('users_register_error_nickname_long',       'EN', "The chosen username is too long");
___('users_register_error_nickname_long',       'FR', "Le pseudonyme choisi est trop long");
___('users_register_error_password_short',      'EN', "The chosen password is too short");
___('users_register_error_password_short',      'FR', "Le mot de passe choisi est trop court");
___('users_register_error_nickname_illegal',    'EN', "The chosen username contains a forbidden word");
___('users_register_error_nickname_illegal',    'FR', "Le pseudonyme choisi contient un mot interdit");
___('users_register_error_nickname_characters', 'EN', "Your username can only be made from non accentuated latin letters and numbers");
___('users_register_error_nickname_characters', 'FR', "Votre pseudonyme ne peut être composé que de lettres non accentuées et de chiffres");
___('users_register_error_nickname_taken',      'EN', "The chosen username is already taken by another user");
___('users_register_error_nickname_taken',      'FR', "Le pseudonyme choisi est déjà utilisé par un autre utilisateur");


// Welcome private message
___('users_register_private_message_title', 'EN', "Welcome to NoBleme!");
___('users_register_private_message_title', 'FR', "Bienvenue sur NoBleme !");
___('users_register_private_message',       'EN', <<<EOT
[size=1.3][b]Welcome to NoBleme![/b][/size]

Now that you have registered, why not join the community where it is most active: on [url={{1}}todo_link]the IRC chat server[/url].

If you are curious what is being active on the website recently, why not check out the [url={{1}}pages/nobleme/activity]recent activity page[/url] - that's what it's here for!

Enjoy your stay on NoBleme!
If you have any questions, feel free to reply to this message.

Your admin,
[url={{1}}todo_link]Bad[/url]
EOT
);
___('users_register_private_message',       'FR', <<<EOT
[size=1.3][b]Bienvenue sur NoBleme ![/b][/size]

Maintenant que vous avez rejoint le site, pourquoi ne pas rejoindre la communauté là où elle est active : sur [url={{1}}todo_link]le serveur de discussion IRC[/url].

Si vous êtes curieux de ce qui se passe sur le site en ce moment, la page [url={{1}}pages/nobleme/activity]d'activité récente[/url] est là exprès pour ça.

Bon séjour sur NoBleme !
Si vous avez la moindre question, n'hésitez pas à répondre à ce message.

Votre administrateur,
[url={{1}}todo_link]Bad[/url]
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      WELCOME                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Body
___('users_welcome_title',  'EN', "Your account has been created");
___('users_welcome_title',  'FR', "Votre compte a été crée");
___('users_welcome_body',   'EN', <<<EOT
You have successfully registered an account on NoBleme. You can now use the login form above to log into your newly created account and begin using the website as a registered user!
EOT
);
___('users_welcome_body',   'FR', <<<EOT
Votre compte a bien été crée. Vous pouvez maintenant utiliser le formulaire de connexion ci-dessus afin de vous connecter sur votre nouveau compte. Bienvenue parmi les membres de NoBleme !
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   WHO'S ONLINE                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('users_online_title',         'EN', "Who's online?");
___('users_online_title',         'FR', "Qui est en ligne ?");
___('users_online_header_intro',  'EN', "This page lists the most recently visited page of all users that were active on NoBleme in the last month. In the case of guests (users without an account), only the 1000 most recent ones are displayed, and randomly generated silly nicknames are assigned to each of them. If you fear that it might enable stalking in ways you're not comfortable with and want to be hidden from this page, you can do that in your account's {{link|todo_link|privacy options}}.");
___('users_online_header_intro',  'FR', "Cette page recense l'activité la plus récente des visiteurs qui ont fréquenté NoBleme ce mois-ci. Dans le cas des invités (visiteurs non connectés), seuls les 1000 plus récents sont affichés, et de petits surnoms stupides leur sont aléatoirement assignés. Si vous craignez que cette page permette à des gens de vous traquer ou n'êtes juste pas confortable avec le fait d'avoir votre activité listée publiquement, vous pouvez retirer votre compte de la liste via vos {{link|todo_link|options de vie privée}}.");
___('users_online_header_colors', 'EN', <<<EOD
In order to tell them apart from each other, users are color coded:
<ul class="nopadding">
  <li>Guests will not have any specific formatting.</li>
  <li>{{link|todo_link|Registered users}} will appear in <span class="bold">bold</span>.</li>
  <li>{{link|todo_link|Moderators}} have an <span class="text_orange bold">orange</span> background.</li>
  <li>{{link|todo_link|Administrators}} have a <span class="text_red glow bold">red</span> background.</li>
</ul>
EOD
);
___('users_online_header_colors', 'FR', <<<EOD
Afin de les distinguer, les visiteurs suivent un code couleur :
<ul class="nopadding">
  <li>Les invités n'ont pas de formattage spécifique.</li>
  <li>{{link|todo_link|Les membres du site}} apparaissent en <span class="bold">gras</span>.</li>
  <li>{{link|todo_link|Les modérateurs}} ont un arrière-plan <span class="text_orange bold">orange.</span></li>
  <li>{{link|todo_link|Les administrateurs}} ont un arrière-plan <span class="text_red glow bold">rouge.</span></li>
</ul>
EOD
);


// Options
___('users_online_hide_gests',      'EN', "Do not show guests in the list");
___('users_online_hide_gests',      'FR', "Ne pas afficher les invités dans la liste");
___('users_online_admin_view',      'EN', "See the table like a regular user would");
___('users_online_admin_view',      'FR', "Voir la page comme un utilisateur normal");
___('users_online_refresh',         'EN', "Automatically reload the table every 10 seconds");
___('users_online_refresh',         'FR', "Recharger automatiquement la liste toutes les 10 secondes");
___('users_online_refresh_mobile',  'EN', "Refresh the table every 10 seconds");
___('users_online_refresh_mobile',  'FR', "Actualiser la liste toutes les 10 secondes");


// Table
___('users_online_activity',  'EN', "LATEST ACTIVITY");
___('users_online_activity',  'FR', "DERNIÈRE ACTIVITÉ");
___('users_online_page',      'EN', "LAST VISITED PAGE");
___('users_online_page',      'FR', "DERNIÈRE PAGE VISITÉE");