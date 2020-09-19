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
___('users_register_coc',       'EN', <<<EOD
We want to make sure that all users of the website understand that, even though there are few rules and little moderation on NoBleme, there still exists a code of conduct that should be followed when interacting with other members of the community. In order to ensure that everyone reads it at least once, you will be asked a few simple questions relating to NoBleme's code of conduct during the account creation process.
EOD
);
___('users_register_coc',       'FR', <<<EOD
Nous voulons nous assurer que toutes les persionnes qui comptent créer un compte comprennent que, même s'il y a très peu de règles ou de modération sur NoBleme, il existe tout de même un code de conduite qui doit être respecté lors de vos interactions avec la communauté du site. Afin de vérifier que tout le monde le lise au moins une fois, quelques questions simples vous serons posées sur ce code de conduite lors de la création de votre compte.
EOD
);


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
___('users_register_form_question_4',           'FR', "J'agresse quelqu'un d'autre, qu'est-ce qui va m'arriver ?");
___('users_register_form_question_4_banned',    'EN', "I will get banned");
___('users_register_form_question_4_banned',    'FR', "Je me fais bannir");
___('users_register_form_question_4_freedom',   'EN', "Nothing, free speech protects me!");
___('users_register_form_question_4_freedom',   'FR', "La liberté d'expression me protège !");
___('users_register_form_captcha',              'EN', "Prove that you are a human by copying this number");
___('users_register_form_captcha',              'FR', "Prouvez que vous n'êtes pas un robot en recopiant ce nombre");
___('users_register_form_captcha_alt',          'EN', "You must turn off your image blocker to see this captcha !");
___('users_register_form_captcha_alt',          'FR', "Vous devez désactiver votre bloqueur d'image pour voir ce captcha !");
___('users_register_form_submit',               'EN', "Create my account");
___('users_register_form_submit',               'FR', "Créer mon compte");


// Error messages
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
___('users_register_error_nickname_taken',      'FR', "Le pseudonyme choisi est déjà utilisé par quelqu'un d'autre");


// Welcome private message
___('users_register_private_message_title', 'EN', "Welcome to NoBleme!");
___('users_register_private_message_title', 'FR', "Bienvenue sur NoBleme !");
___('users_register_private_message',       'EN', <<<EOT
[size=1.3][b]Welcome to NoBleme![/b][/size]

Now that you have registered, why not join the community where it is most active: on [url={{1}}todo_link]the IRC chat server[/url].

If you are curious about what is happening on the website and within its community, why not check out the [url={{1}}pages/nobleme/activity]recent activity page[/url] - that's what it's here for!

Enjoy your stay on NoBleme!
If you have any questions, feel free to reply to this message.

Your admin,
[url={{1}}todo_link]Bad[/url]
EOT
);
___('users_register_private_message',       'FR', <<<EOT
[size=1.3][b]Bienvenue sur NoBleme ![/b][/size]

Maintenant que vous avez rejoint le site, pourquoi ne pas rejoindre la communauté là où elle est active : sur [url={{1}}todo_link]le serveur de discussion IRC[/url].

Si vous voulez suivre ce qui est publié sur le site et ce qui se passe au sein de sa communauté, vous pouvez le faire via [url={{1}}pages/nobleme/activity]l'activité récente[/url].

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
Votre compte a bien été crée. Vous pouvez maintenant utiliser le formulaire de connexion ci-dessus afin de vous connecter sur votre nouveau compte. Bienvenue dans la communauté NoBlemeuse !
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
___('users_online_header_intro',  'EN', <<<EOD
This page lists the most recently visited page of all users that were active on NoBleme in the last month. In the case of guests (users without an account), only the 1000 most recent ones are displayed, and randomly generated silly nicknames are assigned to each of them. If you fear that it might enable stalking in ways you're not comfortable with and want to be hidden from this page, you can do that in your account's {{link|todo_link|privacy options}}.
EOD
);
___('users_online_header_intro',  'FR', <<<EOD
Cette page recense la dernière activité des visiteurs de NoBleme ce mois-ci. Dans le cas des invités (visiteurs non connectés), seuls les 1000 entrées les plus récentes sont affichées, et de petits surnoms stupides leur sont aléatoirement assignés. Si vous craignez que cette page permette à des gens de vous traquer ou n'êtes juste pas confortable avec le fait d'avoir votre activité listée publiquement, vous pouvez retirer votre compte de la liste via vos {{link|todo_link|options de vie privée}}.
EOD
);
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
  <li>{{link|todo_link|La modération}} apparait en <span class="text_orange bold">orange.</span></li>
  <li>{{link|todo_link|L'administration}} apparait en <span class="text_red glow bold">rouge.</span></li>
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




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      BANNED                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('users_banned_title',         'EN', "Banned!");
___('users_banned_title',         'FR', "Banni !");
___('users_banned_subtitle',      'EN', "Your account is banned from using NoBleme");
___('users_banned_subtitle',      'FR', "Votre compte est banni de NoBleme");
___('users_banned_header',        'EN', <<<EOD
Being banned from NoBleme means that you are unable to take part in any form of interaction on the website until you have purged the full duration of your ban. If you wish to browse the website before your ban ends, you can always log out of your account and use the website as a guest.
EOD
);
___('users_banned_header',        'FR', <<<EOD
Se faire bannir de NoBleme signifie que vous ne pouvez plus interagir sur le site depuis votre compte tant que vous n'avez pas purgé l'intégralité de votre peine. Si vous voulez vous servir du site avant la fin de votre bannissement, vous pouvez toujours vous déconnecter de votre compte et utiliser le site en tant qu'invité.
EOD
);
___('users_banned_header_evason', 'EN', <<<EOD
Take note that <span class="bold underlined">ban evasion will get you IP banned</span>: if you try to circumvent the ban by creating a new account, you will end up blocked from using the website as a whole. If you feel bad about being banned, the only thing you can do about it is to appeal the sentence. Keep reading this page if you're looking to know how ban appeals are done.
EOD
);
___('users_banned_header_evason', 'FR', <<<EOD
Attention, <span class="bold underlined">tentez de contourner le bannissement et vous vous ferez bannir par adresse IP</span> : si vous essayez de défier ce bannissement en créant un nouveau compte, vous vous perdrez la possibilité même d'utiliser le site en tant qu'invité. Si vous n'êtes pas d'accord avec votre bannissement, la seule chose que vous pouvez faire est tenter de faire appel de la décision de vous bannir. Continuez à lire cette page si vous désirez savoir comment faire appel de votre bannissement.
EOD
);


// Ban details
___('users_banned_details_title',     'EN', "Ban details");
___('users_banned_details_title',     'FR', "Détails du bannissement");
___('users_banned_details_body',      'EN', <<<EOD
You have been banned on <span class="text_red">{{1}}</span> for a total of <span class="text_red">{{2}}</span> days.<br>
Your ban will last until <span class="text_red">{{3}}</span>, Europe/Paris time (<span class="text_red">{{4}}</span>)<br>
You have been "soft" banned (not IP banned).<br>
EOD
);
___('users_banned_details_body',      'FR', <<<EOD
Vous vous êtes fait bannir le <span class="text_red">{{1}}</span> pour <span class="text_red">{{2}}</span> jours.<br>
Le bannissement prendra fin le <span class="text_red">{{3}}</span>, heure de Paris (<span class="text_red">{{4}}</span>)<br>
Il s'agit d'un bannissement "doux" (pas d'un bannissement par filtrage IP).<br>
EOD
);
___('users_banned_details_reason',    'EN', "You have been banned for the following reason:");
___('users_banned_details_reason',    'FR', "La cause du bannissement est la suivante :");
___('users_banned_details_no_reason', 'EN', "No reason has been specified for your ban.");
___('users_banned_details_no_reason', 'FR', "Aucune justification n'a été spécifiée pour votre bannissement.");


// Code of conduct
___('users_banned_coc_title', 'EN', "Code of conduct reminder");
___('users_banned_coc_title', 'FR', "Rappel du code de conduite");


// Appeal
___('users_banned_appeal_title',        'EN', "Appeal your ban");
___('users_banned_appeal_title',        'FR', "Faire appel de la décision du bannissement");
___('users_banned_appeal_explanation',  'EN', <<<EOD
If you believe that you have been unfairly banned, or that you have been fairly banned but have learned your lesson, there is an appeal procedure in place. The appeal is not an automated procedure: it is based on a human decision by members of the administrative team, and is done through NoBleme's IRC chat server. If your appeal is accepted, then your sentence might be reduced or even fully lifted. Here are the instructions to follow in order to appeal your ban:
EOD
);
___('users_banned_appeal_explanation',  'FR', <<<EOD
Si vous considéré que votre bannissement est injuste, ou que votre bannissement est juste mais que vous en avez tiré des leçons, une procédure d'appel est possible. Cette procédure n'est pas automatisée : il s'agit d'une décision humaine prise par des l'équipe administrative, et se fait via le serveur de chat IRC de NoBleme. Si votre appel est accepté, alors votre peine pourra être réduite ou même totalement annulée. Voici les instructions à suivre pour faire appel de votre bannissement :
EOD
);
___('users_banned_appeal_instructions', 'EN', <<<EOD
<ul>
  <li>Log out of your account (else you won't be able to use the website due to being banned)</li>
  <li>Look for the "IRC Chat Server" section of the website</li>
  <li>Follow the instructions on how to join NoBleme's IRC Chat</li>
  <li>On the IRC Chat, ask to speak to an administrator (be patient, they might not be around at all times)</li>
  <li>The administrator will walk you through the ban appeal process</li>
  <li>The administrator will immediately inform you of the decision taken</li>
</ul>
EOD
);
___('users_banned_appeal_instructions', 'FR', <<<EOD
<ul>
  <li>Déconnectez-vous de votre compte (sinon vous ne pourrez pas utiliser le site)</li>
  <li>Allez sur la section « Serveur de chat IRC » du site</li>
  <li>Suivez les instructions afin de rejoindre le chat IRC de NoBleme</li>
  <li>Une fois sur le chat IRC, demandez à parler à l'administration (faites preuve de patience si personne ne répond immédiatement)</li>
  <li>L'administration discutera avec vous de votre bannissement</li>
  <li>Une décision non négociable sera rendue immédiatement sur votre peine</li>
</ul>
EOD
);