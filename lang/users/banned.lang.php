<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


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