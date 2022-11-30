<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


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
___('users_register_form_username',             'EN', "Your username (3 to 15 characters, letters & numbers only)");
___('users_register_form_username',             'FR', "Pseudonyme (3 à 15 caractères, chiffres & lettres sans accents)");
___('users_register_form_username_is_illegal',  'EN', "This username is not allowed, please choose another one");
___('users_register_form_username_is_illegal',  'FR', "Ce pseudonyme n'est pas autorisé, merci d'en choisir un autre");
___('users_register_form_username_exists',      'EN', "This username is already in use, please choose another one");
___('users_register_form_username_exists',      'FR', "Ce pseudonyme est déjà utilisé, merci d'en choisir un autre");
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
___('users_register_error_closed',              'EN', "Registrations are currently closed, no new accounts can be created on the website.");
___('users_register_error_closed',              'FR', "La création de comptes est fermée, il est actuellement impossible de créer de nouveaux comptes sur le site.");
___('users_register_error_passwords',           'EN', "You must enter the same password twice");
___('users_register_error_passwords',           'FR', "Vous devez saisir deux fois le même mot de passe");
___('users_register_error_password_length',     'EN', "Your password is too short (8 characters minimum)");
___('users_register_error_password_length',     'FR', "Votre mot de passe est trop court (8 caractères minimum)");
___('users_register_error_captchas',            'EN', "The number you entered in the last field did not match the number on the image");
___('users_register_error_captchas',            'FR', "Le nombre que vous avez saisi dans le dernier champ ne correspond pas à celui sur l'image");
___('users_register_error_username_short',      'EN', "The chosen username is too short");
___('users_register_error_username_short',      'FR', "Le pseudonyme choisi est trop court");
___('users_register_error_username_long',       'EN', "The chosen username is too long");
___('users_register_error_username_long',       'FR', "Le pseudonyme choisi est trop long");
___('users_register_error_password_short',      'EN', "The chosen password is too short");
___('users_register_error_password_short',      'FR', "Le mot de passe choisi est trop court");
___('users_register_error_username_illegal',    'EN', "The chosen username contains a forbidden word");
___('users_register_error_username_illegal',    'FR', "Le pseudonyme choisi contient un mot interdit");
___('users_register_error_username_characters', 'EN', "Your username can only be made from non accentuated latin letters and numbers");
___('users_register_error_username_characters', 'FR', "Votre pseudonyme ne peut être composé que de lettres non accentuées et de chiffres");
___('users_register_error_username_taken',      'EN', "The chosen username is already taken by another user");
___('users_register_error_username_taken',      'FR', "Le pseudonyme choisi est déjà utilisé par quelqu'un d'autre");


// Welcome private message
___('users_register_private_message_title', 'EN', "Welcome to NoBleme!");
___('users_register_private_message_title', 'FR', "Bienvenue sur NoBleme !");
___('users_register_private_message',       'EN', <<<EOT
[size=1.3][b]Welcome to NoBleme![/b][/size]

Now that you have registered, why not join the community where it is most active: on [url={{1}}pages/social/irc]the IRC chat server[/url].

If you are curious about what is happening on the website and within its community, why not check out the [url={{1}}pages/nobleme/activity]recent activity page[/url] - that's what it's here for!

Enjoy your stay on NoBleme!
If you have any questions, feel free to reply to this message.
EOT
);
___('users_register_private_message',       'FR', <<<EOT
[size=1.3][b]Bienvenue sur NoBleme ![/b][/size]

Maintenant que vous avez rejoint le site, pourquoi ne pas rejoindre la communauté là où elle est active : sur [url={{1}}pages/social/irc]le serveur de discussion IRC[/url].

Si vous voulez suivre ce qui est publié sur le site et ce qui se passe au sein de sa communauté, vous pouvez le faire via [url={{1}}pages/nobleme/activity]l'activité récente[/url].

Bon séjour sur NoBleme !
Si vous avez la moindre question, n'hésitez pas à répondre à ce message.
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      WELCOME                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Body
___('users_welcome_title',  'EN', "Your account has been created");
___('users_welcome_title',  'FR', "Votre compte a été créé");
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
/*                                                CLOSED REGISTRATION                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/

___('users_closed_subtitle',  'EN', "New account registrations are closed");
___('users_closed_subtitle',  'FR', "La création de comptes est désactivée");
___('users_closed_body_1',    'EN', <<<EOT
It is currently impossible to create new accounts on NoBleme. This is a protective measure which can be activated for a variety of reasons, such as protecting the website from spammers.
EOT
);
___('users_closed_body_1',    'FR', <<<EOT
Il est actuellement impossible de créer un nouveau compte sur NoBleme. Cette mesure de protection peut être activée pour des raisons telles que protéger le site d'une attaque de spam ou de harcèlement.
EOT
);
___('users_closed_body_2',    'EN', <<<EOT
This is a temporary situation. Sorry for the inconvenience, please come back at a later date.
EOT
);
___('users_closed_body_2',    'FR', <<<EOT
Cette situation est temporaire. N'hésitez pas à revenir plus tard.
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                              SETTINGS: ADULT CONTENT                                              */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('account_nsfw_intro',   'EN', <<<EOT
As NoBleme does not have any age restrictions, and as some users might be browsing the website at work, in public, or around children, all adult content (mostly extreme vulgarity and nudity) is blurred by default. Regardless of your settings, blurred content can still be seen by hovering your mouse over it or clicking on it.
EOT
);
___('account_nsfw_intro',   'FR', <<<EOT
Comme NoBleme n'a pas de restriction d'âge, et comme il n'est pas possible de savoir si vous accédez au site sur un lieu de travail, en public, ou autour d'enfants, tout le contenu adulte (principalement la vulgarité extrême et la nudité) sont floutés par défaut. Peu importe vos réglages, le contenu flouté peut toutefois être vu en le survolant avec votre pointeur ou en cliquant dessus.
EOT
);
___('account_nsfw_levels',  'EN', <<<EOT
Instead of being a simple on/off switch, this setting allows you to have three different possible setups: keep all the adult content blurred, reveal all texts but blur adult images, or reveal everything. This allows for the middle ground where you don't mind extreme vulgarity or sexual topics in writing, but would rather not have sexual images show up on your screen around people.
EOT
);
___('account_nsfw_levels',  'FR', <<<EOT
Plutôt qu'un simple oui/non, ce réglage possède trois options possibles : conserver le floutage sur tout le contenu adulte, révéler tous les textes mais flouter les images vulgaires, ou tout révéler. Cela permet un entre deux dans le cas où vous n'avez aucun problème avec la vulgarité extrême et les sujets sexuels par écrit, mais préférez éviter que des images suggestives soient présentes sur votre écran en public.
EOT
);


// Selector
___('account_nsfw_label', 'EN', "Your desired adult content settings");
___('account_nsfw_label', 'FR', "Votre niveau de vulgarité désiré");
___('account_nsfw_0',     'EN', "Blur everything");
___('account_nsfw_0',     'FR', "Tout flouter");
___('account_nsfw_1',     'EN', "Blur images only");
___('account_nsfw_1',     'FR', "Ne flouter que les images");
___('account_nsfw_2',     'EN', "Show everything");
___('account_nsfw_2',     'FR', "Tout révéler");


// Confirmation
___('account_nsfw_confirm', 'EN', "Your settings have been updated");
___('account_nsfw_confirm', 'FR', "Vos réglages ont été mis à jour");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 SETTINGS: PRIVACY                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('account_privacy_intro',    'EN', <<<EOT
On NoBleme, we highly value online privacy. As our {{link|pages/doc/privacy|privacy policy}} states, we will only gather the bare minimum {{link|pages/doc/data|user data}}, we will not use it in ways other than the bare minimum required to run the website, we will never share or sell your personal data, and we let you {{link|pages/messages/admins?delete|delete your account}} if you desire.
EOT
);
___('account_privacy_intro',    'FR', <<<EOT
Sur NoBleme, nous prêtons beaucoup d'importance au respect de votre vie privée. Comme indiqué dans notre {{link|pages/doc/privacy|politique de confidentialité}}, nous conservons le strict minimum de vos {{link|pages/doc/data|données personnelles}}, ne les utilisons que dans le fonctionnement interne du site, n'avons pas l'intention de partager ou vendre vos données personnelles, et vous offrons la possibilité de {{link|pages/messages/admins?delete|supprimer votre compte}} à tout moment.
EOT
);
___('account_privacy_others',   'EN', <<<EOT
However, we have no control over any third party content that might be embedded on some of the website's pages. To manage the impact this might have on your privacy, we try to minimize the number of third parties that can be embedded on NoBleme (currently only YouTube, Google Trends, Discord, and KiwiIRC), and give you the option to completely disable third party embedded content if you'd rather not have them.
EOT
);
___('account_privacy_others',   'FR', <<<EOT
Toutefois, nous ne pouvons pas contrôler ce que font les tiers que nous intégrons sur le site. Afin de vous laisser un maximum de contrôle sur vos données personnelles, nous minimisons le nombre de tiers qui sont intégrables sur le site (actuellement uniquement YouTube, Google Trends, Discord, et KiwiIRC), et vous donnons la possibilité de complètement désactiver les contenus tiers.
EOT
);
___('account_privacy_disable',  'EN', <<<EOT
If you disable any of the third parties, they will simply not appear at all when you are browsing pages that include external content (for example, a YouTube video embedded in a page will instead be replaced by a link to the YouTube video which you can manually click if you want to watch it).
EOT
);
___('account_privacy_disable',  'FR', <<<EOT
Dans le cas où vous désactiveriez un des tiers, il n'apparaitra plus lorsque vous visiterez des pages du site qui les contiennent (par exemple, au lieu de voir une vidéo YouTube incrustée dans la page, vous verrez un lien vers la vidéo YouTube en question que vous pourrez cliquer manuellement si vous désirez la voir).
EOT
);
___('account_privacy_activity', 'EN', <<<EOT
We also offer the ability to have your account hidden from the {{link|pages/users/online|who's online}} page of the website. Appearing on this page allows users to know what each other are up to on the website, but we understand that some of you would rather stay hidden or would like a way to avoid being stalked.
EOT
);
___('account_privacy_activity', 'FR', <<<EOT
Nous vous offrons également la possibilité de ne pas apparaître sur la page {{link|pages/users/online|qui est en ligne}}. Cette page permet de voir ce que font les autres comptes sur le site, mais nous comprenons très bien qu'un désir d'anonymité ou un besoin d'échapper à des harcèlements peuvent vous mettre mal à l'aise face à ce concept.
EOT
);


// Selectors
___('account_privacy_youtube',  'EN', "Show embedded {{external|http://youtube.com/|YouTube}} videos");
___('account_privacy_youtube',  'FR', "Afficher les vidéos {{external|http://youtube.com/|YouTube}}");
___('account_privacy_trends',   'EN', "Show embedded {{external|http://trends.google.com/|Google Trends}} graphs");
___('account_privacy_trends',   'FR', "Afficher les graphes {{external|http://trends.google.com/|Google Trends}}");
___('account_privacy_discord',  'EN', "Show live preview of {{link|pages/social/discord|NoBleme's Discord server}}");
___('account_privacy_discord',  'FR', "Afficher un aperçu en direct du {{link|pages/social/discord|serveur Discord NoBleme}}");
___('account_privacy_kiwiirc',  'EN', "Show embedded {{link|pages/social/irc?browser|KiwiIRC web client}}");
___('account_privacy_kiwiirc',  'FR', "Afficher le {{link|pages/social/irc?browser|client web KiwiIRC}}");
___('account_privacy_online',   'EN', "Show my account on {{link|pages/users/online|Who's online}}");
___('account_privacy_online',   'FR', "Afficher mon compte sur {{link|pages/users/online|Qui est en ligne}}");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 SETTINGS: E-MAIL                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('account_email_intro',  'EN', <<<EOT
On NoBleme, as we highly value {{link|pages/doc/privacy|privacy}}, we do not require any form of personal identification. You are free to have an account with no e-mail address. If you do choose to enter an e-mail address, know that it will never be shown publicly on the website, and that e-mails will never be sent to you from NoBleme. The only usage we have for your e-mail address is as a tool for recovering access to your account, in the event that you would forget your username and/or password.
EOT
);
___('account_email_intro',  'FR', <<<EOT
Sur NoBleme, comme nous respectons {{link|pages/doc/privacy|votre vie privée}}, nous n'avons pas besoin de la moindre preuve d'identité. Vous êtes libre de ne pas avoir d'adresse e-mail liée à votre compte. Si vous choisissez d'enregistrer une adresse e-mail, sachez qu'elle ne sera jamais affichée publiquement sur le site, et qu'aucun e-mail ne vous sera envoyé par NoBleme. La seule utilisation que nous faisons des adresses e-mail est pour la récupération de l'accès à votre compte dans le cas où vous oublieriez votre pseudonyme et/ou mot de passe.
EOT
);


// Form
___('account_email_label',    'EN', "Your e-mail address");
___('account_email_label',    'FR', "Votre adresse e-mail");
___('account_email_error',    'EN', "The provided e-mail address is not valid");
___('account_email_error',    'FR', "L'adresse e-mail fournie est invalide");
___('account_email_confirm',  'EN', "Your account's e-mail address has been updated");
___('account_email_confirm',  'FR', "L'adresse e-mail de votre compte a été mise à jour");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                SETTINGS: PASSWORD                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('account_password_title', 'EN', "New password");
___('account_password_title', 'FR', "Nouveau mot de passe");


// Form
___('account_password_current', 'EN', "Your current password");
___('account_password_current', 'FR', "Votre mot de passe actuel");
___('account_password_new',     'EN', "Your new password (at least 8 characters long)");
___('account_password_new',     'FR', "Nouveau mot de passe (8 caractères minimum)");
___('account_password_confirm', 'EN', "Type your new password again to confirm it");
___('account_password_confirm', 'FR', "Entrez à nouveau votre mot de passe pour le confirmer");


// Errors / Success
___('account_password_error_current', 'EN', "You must enter your current password");
___('account_password_error_current', 'FR', "Vous devez remplir votre mot de passe actuel");
___('account_password_error_confirm', 'EN', "You must enter and confirm your new password");
___('account_password_error_confirm', 'FR', "Vous devez remplir et confirmer votre nouveau mot de passe");
___('account_password_error_wrong',   'EN', "Your current password is incorrect");
___('account_password_error_wrong',   'FR', "Votre mot de passe actuel est incorrect");
___('account_password_success',       'EN', "Your password has been changed");
___('account_password_success',       'FR', "Votre mot de passe a été changé");