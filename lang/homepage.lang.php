<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


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
  For those who did not experience these communities, they were small websites with no specific main theme, usually centered around a forum and a chatroom. NoBleme used to be such a place for a small french community, which then grew in various ways over the years. The website's history gets covered in more detail on the {{link++|todo_link|"what is NoBleme?"|bold|}} page.
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
  Pour ceux qui n'ont pas connu ces communautés, il s'agissait de petits sites Internet sans sujet ou thème particulier, généralement composés d'un forum et d'un salon de discussion. NoBleme a été une de ces communautés, puis a grandi et changé. L'histoire du site est racontée de façon plus détaillée sur la page {{link++|todo_link|« qu'est-ce que NoBleme »|bold|}}.
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
  NoBleme has has no central theme or topic. It has no goal other than being a place where you can hang out with friendly people. However, there is a {{link++|pages/doc/coc|code of conduct|bold|}} which must be respected by all. It can be summarized as such: be mindful and respectful of others, and they shall be mindful and respectful of you.
</p>
<p>
  There is a deliberate political stance on NoBleme: conservatives, reactionaries, and fascists are not welcome. There are a great number of websites and communities that already cater to their needs, NoBleme is not one of them. Instead, we try to have a vision which is not compatible with theirs: be a place where people who might feel oppressed in daily life feel comfortable expressing themselves without fear of being oppressed online. NoBleme is not a safe space though, everyone from every background is welcome, but we show low tolerance for aggressive or oppressive behaviors.
</p>
<p>
  In the spirit of the early Internet days, NoBleme is entirely free to use, does not need donations to live, does not have any ads or third party content, does not track or use {{link++|todo_link|your personal data|bold|}}, and {{link++|todo_link|respects your privacy|bold|}}.
</p>
EOT
);
___('nobleme_home_statement',       'FR', <<<EOT
<p>
  NoBleme n'a pas de thème ou de sujet spécifique, ni d'objectif autre que de continuer à maintenir sa communauté. Toutefois, il y a un {{link++|pages/doc/coc|code de conduite|bold|}} à respecter lors de vos interactions avec la communauté.
</p>
<p>
  NoBleme impose une seule limitation : les conservateurs, traditionnalistes, nationalistes, fascistes, et autres réactionnaires ne sont pas les bienvenus. Il y a un grand nombre de sites Internet et communautés faits pour eux, NoBleme n'en fait pas partie. En effet, leur vision est incompatible avec celle de NoBleme : nous voulons être une communauté inclusive, où celles et ceux qui souffrent de l'oppression de la société au quotidien peuvent venir s'exprimer librement sans craindre la moindre oppression ou aggression.
</p>
<p>
  Dans l'esprit des anciennes communautés Internet, NoBleme est entièrement gratuit à utiliser, n'a pas besoin de donations pour vivre, ne contient pas de publicités ni de contenus tiers, ne traque pas et ne conserve pas {{link++|todo_link|vos données personnelles|bold|}} contre votre volonté, et {{link++|todo_link|respecte votre vie privée|bold|}}.
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
    {{link++|todo_link|The IRC chat server|bold|}} is where the community hangs out and communicates. Come join!
  </li>
  <li class="smallpadding_top">
    {{link++|todo_link|The 21st century compendium|bold|}} is a deep dive into modern culture, society, slang, and memes.
  </li>
  <li class="smallpadding_top">
    {{link++|pages/politics/manifesto|The contrapositionist manifesto|bold|}} will give you some insight on where NoBleme stands politically.
  </li>
</ul>
<p>
  Enjoy your stay on NoBleme!<br>
</p>
EOT
);
___('nobleme_home_tour',        'FR', <<<EOT
<p>
  Depuis le 15ème anniversaire de NoBleme, au printemps 2020, beaucoup d'éléments non utilisés ont été retirés du site. Une partie de ces contenus sont toujours en cours de réimagination ou de reconstruction, ce qui fait que NoBleme ne contient actuellement que ses contenus principaux - ne vous attendez pas à y trouver énormément de choses. Vous pouvez utiliser les menus en haut de la page pour vous balader sur NoBleme, ou vous laisser guider par cette liste de nos contenus les plus intéressants :
</p>
<ul class="padding_top padding_bot">
  <li>
    {{link++|todo_link|Le serveur de chat IRC|bold|}}, où vous pourrez trouver et interagir avec la communauté de NoBleme.
  </li>
  <li class="smallpadding_top">
    {{link++|todo_link|Une étude du 21ème siècle|bold|}}, où sont analysés la culture, la société, le langage, et les memes.
  </li>
  <li class="smallpadding_top">
    {{link++|pages/politics/manifesto|Le manifeste contrapositioniste|bold|}}, qui devrait clarifier les positions politiques de NoBleme.
  </li>
</ul>
<p>
  Bon séjour sur NoBleme !<br>
</p>
EOT
);