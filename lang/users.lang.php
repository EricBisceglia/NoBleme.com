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




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       LOGIN                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Page title
___('users_login_page_title', 'EN', 'Login');
___('users_login_page_title', 'FR', 'Connexion');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                FORGOTTEN PASSWORD                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Page title
___('users_forgotten_page_title', 'EN', 'Recover password');
___('users_forgotten_page_title', 'FR', 'Mot de passe oublié');

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
