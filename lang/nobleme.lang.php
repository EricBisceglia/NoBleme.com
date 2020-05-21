<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     HOMEPAGE                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Welcome paragraph
___('nobleme_home_welcome_title',     'EN', "Welcome to NoBleme");
___('nobleme_home_welcome_title',     'FR', "Bienvenue sur NoBleme");
___('nobleme_home_welcome_subtitle',  'EN', "Preserving the spirit of Internet communities");
___('nobleme_home_welcome_subtitle',  'FR', "L'esprit perdu des communautés Internet");
___('nobleme_home_welcome',           'EN', <<<EOT
<p>
  A product of the Internet's landscape in 2005, before the era of massive social networks and centralized websites, NoBleme is a small independent website trying to keep the spirit of Internet communities from the first decade of the 21st century alive.
</p>
<p>
  For those who did not experience these communities, they were small websites with no specific main theme, usually centered around a forum and a chatroom. NoBleme used to be such a place for a small french community, which then grew in various ways over the years. The website's history gets covered in more detail on the {{link+++|todo_link|"what is NoBleme?"|bold|1|}} page.
</p>
<p>
  However, NoBleme is not meant to be an archeological museum or a tribute to the past. It is a living place, evolving with the times, maintaining an active community, always welcoming to those who would want to join.
</p>
EOT
);
___('nobleme_home_welcome',           'FR', <<<EOT
<p>
  Produit de la culture Internet de 2005, avant l'ère des réseaux sociaux massifs et des plateformes centralisées, NoBleme est un petit site Internet indépendant qui tente de préserver l'esprit des commaunautés Internet de la première décennie du 21ème siècle.
</p>
<p>
  Pour ceux qui n'ont pas connu ces communautés, il s'agissait de petits sites Internet sans sujet ou thème particulier, généralement composés d'un forum et d'un salon de discussion. NoBleme a été une de ces communautés, puis a grandi et changé. L'histoire du site est racontée de façon plus détaillée sur la page {{link+++|todo_link|« qu'est-ce que NoBleme »|bold|1|}}.
</p>
<p>
  Toutefois, NoBleme n'est pas un musée archéologique ou un monument au passé. C'est un site Internet vivant, en évolution constante, dont la communauté est toujours accueillante envers ceux qui voudraient la rejoindre.
</p>
EOT
);


// Mission statement
___('nobleme_home_statement_title', 'EN', "Mission statement");
___('nobleme_home_statement_title', 'FR', "Qu'est-ce que NoBleme ?");
___('nobleme_home_statement',       'EN', <<<EOT
<p>
  NoBleme has has no central theme or topic. It has no goal other than being a place where you can hang out with friendly people. However, there is a {{link+++|todo_link|code of conduct|bold|1|}} which must be respected by all. It can be summarized as such: be mindful and respectful of others, and they shall be mindful and respectful of you.
</p>
<p>
  There is a deliberate political stance on NoBleme: conservatives, reactionaries, and fascists are not welcome. There are a great number of websites and communities that already cater to their needs, NoBleme is not one of them. Instead, we try to have a vision which is not compatible with theirs: be a place where people who might feel oppressed in daily life feel comfortable expressing themselves without fear of being oppressed online. NoBleme is not a safe space though, everyone from every background is welcome, but we show low tolerance for aggressive or oppressive behaviors.
</p>
<p>
  In the spirit of the early Internet days, NoBleme is entirely free to use, does not need donations to live, does not have any ads or third party content, does not track or use {{link+++|todo_link|your personal data|bold|1|}}, and {{link+++|todo_link|respects your privacy|bold|1|}}.
</p>
EOT
);
___('nobleme_home_statement',       'FR', <<<EOT
<p>
  NoBleme n'a pas de thème ou de sujet spécifique, ni d'objectif autre que de continuer à maintenir sa communauté. Toutefois, il y a un {{link+++|todo_link|code de conduite|bold|1|}} que tou·te·s doivent respecter. Il peut se résumer ainsi : soyez attentif et respectueux envers les autres, et les autres seront attentifs et respecteux envers vous.
</p>
<p>
  NoBleme a une unique limitation : les conservateurs, traditionnalistes, nationalistes, fascistes, et autres réactionnaires ne sont pas les bienvenus. Il y a un grand nombre de sites Internet et communautés faits pour eux, NoBleme n'en fait pas partie. En effet, leur vision est incompatible avec celle de NoBleme : nous voulons être une communauté inclusive, où ceux et celles qui souffrent de l'oppression de la société au quotidien puissent venir s'exprimer librement sans se sentir oppressés. Cela ne fait pas de NoBleme un « safe space », tout le monde y est bienvenu, mais nous faisons preuve de peu de patience pour ceux qui viennent y partager des ponints de vue aggressifs ou opressifs.
</p>
<p>
  Dans l'esprit des anciennes communautés Internet, NoBleme est entièrement gratuit à utiliser, n'a pas besoin de donations pour vivre, ne contient pas de publicités ni de contenus extérieurs, ne traque pas et ne conserve pas {{link+++|todo_link|vos données personnelles|bold|1|}} contre votre volonté, et {{link+++|todo_link|respecte votre vie privée|bold|1|}}.
</p>
EOT
);


// Website tour
___('nobleme_home_tour_title',  'EN', "Website features");
___('nobleme_home_tour_title',  'FR', "Visite guidée du site");
___('nobleme_home_tour',        'EN', <<<EOT
<p>
  The 15th birthday overhaul of the website in spring 2020 cut many unused features from the website. Some of this content is still in the process of being reimagined and rebuilt right now, therefore NoBleme is currently cut down to its core features - don't expect too much content. You can use the menus on top of the page to browse around the website, or let yourself get guided by this quick list of our main features:
</p>
<ul class="padding_top padding_bot">
  <li>
    {{link+++|todo_link|The IRC chat server|bold|1|}} is where the community hangs out and communicates. Come join!
  </li>
  <li class="smallpadding_top">
    {{link+++|todo_link|The 21st century compendium|bold|1|}} is a deep dive into modern culture, society, slang, and memes.
  </li>
  <li class="smallpadding_top">
    {{link+++|pages/politics/manifesto|The contrapositionist manifesto|bold|1|}} will give you some insight on where NoBleme stands politically.
  </li>
</ul>
<p>
  Enjoy your stay on NoBleme!<br>
  {{link+++|todo_link|- Bad|indented bold|1|}}
</p>
EOT
);
___('nobleme_home_tour',        'FR', <<<EOT
<p>
  Depuis le 15ème anniversaire de NoBleme, au printemps 2020, beaucoup d'éléments non utilisés ont été retirés du site. Une partie de ces contenus sont toujours en cours de réimagination ou de reconstruction, ce qui fait que NoBleme ne contient actuellement que ses contenus principaux - ne vous attendez pas à y trouver énormément de choses. Vous pouvez utiliser les menus en haut de la page pour vous balader sur NoBleme, ou vous laisser guider par cette liste de nos contenus les plus intéressants :
</p>
<ul class="padding_top padding_bot">
  <li>
    {{link+++|todo_link|Le serveur de chat IRC|bold|1|}}, où vous pourrez trouver et interagir avec la communauté de NoBleme.
  </li>
  <li class="smallpadding_top">
    {{link+++|todo_link|Une étude du 21ème siècle|bold|1|}}, où sont analysés la culture, la société, le langage, et les memes.
  </li>
  <li class="smallpadding_top">
    {{link+++|pages/politics/manifesto|Le manifeste contrapositioniste|bold|1|}}, qui devrait clarifier les positions politiques de NoBleme.
  </li>
</ul>
<p>
  Bon séjour sur NoBleme !<br>
  {{link+++|todo_link|- Bad|indented bold|1|}}
</p>
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  RECENT ACTIVITY                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('activity_title',           'EN', "Recent activity");
___('activity_title',           'FR', "Activité récente");
___('activity_title_modlogs',   'EN', "Moderation logs");
___('activity_title_modlogs',   'FR', "Logs de modération");
___('activity_mod_info',        'EN', <<<EOT
Some of the moderation logs below have an icon to their right: <img class="smallicon valign_middle" src="{{1}}img/icons/help.svg" alt="?"><br>
Clicking one of these icons will load some extra information about the logged action.
EOT
);
___('activity_mod_info',        'FR', <<<EOT
Certains des logs de modération ci-dessous ont des icônes à droite : <img class="smallicon valign_middle" src="{{1}}img/icons/help.svg" alt="?"><br>
Cliquer sur une de ces icônes affiche plus de détails sur l'action qui a été effectée.
EOT
);

___('activity_latest_actions',  'EN', "LATEST ACTIONS");
___('activity_latest_actions',  'FR', "DERNIÈRES ACTIONS");

___('activity_type_all',        'EN', "All activity types");
___('activity_type_all',        'FR', "Tous types d'activité");
___('activity_type_users',      'EN', "Users");
___('activity_type_users',      'FR', "Membres");
___('activity_type_meetups',    'EN', "Meetups");
___('activity_type_meetups',    'FR', "Rencontres IRL");
___('activity_type_internet',   'EN', "Internet encyclopedia");
___('activity_type_internet',   'FR', "Encyclopédie du web");
___('activity_type_quotes',     'EN', "Quotes");
___('activity_type_quotes',     'FR', "Citations");
___('activity_type_dev',        'EN', "Website internals");
___('activity_type_dev',        'FR', "Développement");


// Activity log details
___('activity_details_reason',  'EN', "Reason for this action:");
___('activity_details_reason',  'FR', "Justification de l'action :");
___('activity_details_diff',    'EN', "Différence(s) before/after this action:");
___('activity_details_diff',    'FR', "Différence(s) avant/après l'action :");


// Actions
___('activity_delete',    'EN', "Are you sure you want to delete this activity log?");
___('activity_delete',    'FR', "Êtes-vous sûr de vouloir supprimer ce log d'activité ?");
___('activity_deleted',   'EN', "THIS ACTIVITY LOG HAS BEEN DELETED");
___('activity_deleted',   'FR', "CE LOG D'ACTIVITÉ A ÉTÉ SUPPRIMÉ");
___('activity_restored',  'EN', "THIS ACTIVITY LOG HAS BEEN RESTORED");
___('activity_restored',  'FR', "CE LOG D'ACTIVITÉ A ÉTÉ RÉTABLI");