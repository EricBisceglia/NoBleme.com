<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     HOMEPAGE                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('nobleme_home_welcome_title',     'EN', "Welcome to NoBleme");
___('nobleme_home_welcome_title',     'FR', "Bienvenue sur NoBleme");
___('nobleme_home_welcome_subtitle',  'EN', "Preserving the spirit of Internet communities");
___('nobleme_home_welcome_subtitle',  'FR', "L'esprit perdu des communautés Internet");

// Introduction
___('nobleme_home_intro_1', 'EN', <<<EOT
A product of the Internet's landscape in 2005, before the era of massive social networks and centralization, NoBleme is a small independent website trying to preserve the spirit of Internet communities from the first decade of the 21st century.
EOT
);
___('nobleme_home_intro_1', 'FR', <<<EOT
Produit de la culture Internet de 2005, avant l'ère des réseaux sociaux massifs et des plateformes de communication centralisées, NoBleme est un petit site Internet indépendant qui tente de préserver l'esprit des commaunautés Internet de la première décennie du 21ème siècle.
EOT
);
___('nobleme_home_intro_2', 'EN', <<<EOT
For those who did not experience these communities, they were small websites with no specific theme, usually centered around a forum and a chatroom. NoBleme used to be such a place, initially a french community which grew and evolved in various ways over the years. The website's history and purpose are covered in more detail on the {{link++|pages/doc/nobleme|what is NoBleme|bold|}} page.
EOT
);
___('nobleme_home_intro_2', 'FR', <<<EOT
Si vous n'avez pas connu ces communautés, il s'agissait de petits sites Internet sans sujet ou thème spécifique, généralement composés d'un forum et d'un salon de discussion. NoBleme était une de ces communautés, puis a grandi et changé avec le temps. L'histoire et la raison d'être du site sont racontés de façon plus détaillée sur la page {{link++|pages/doc/nobleme|qu'est-ce que NoBleme ?|bold|}}
EOT
);
___('nobleme_home_intro_3', 'EN', <<<EOT
However, NoBleme is not meant to be an archeological museum or a tribute to the past. It is a living place, evolving with the times, maintaining an active community, always welcoming to those who would want to join.
EOT
);
___('nobleme_home_intro_3', 'FR', <<<EOT
Toutefois, NoBleme n'est pas un musée archéologique ou un monument au passé. C'est un site Internet moderne, en évolution constante, dont la communauté est vivante et accueillante.
EOT
);


// Mission statement
___('nobleme_home_statement_title', 'EN', "Mission statement");
___('nobleme_home_statement_title', 'FR', "Qu'est-ce que NoBleme ?");
___('nobleme_home_statement_1',     'EN', <<<EOT
NoBleme has has no central theme or topic, no goal other than being a nice place to hang out. The website is entirely free to use, does not need donations to live, does not have any advertisements or third party content, {{link++|pages/doc/privacy|respects your privacy|bold|}}, and does not collect {{link++|pages/doc/data|your personal data|bold|}}.
EOT
);
___('nobleme_home_statement_1',     'FR', <<<EOT
NoBleme n'a pas de thème ou de sujet spécifique, ni d'objectif autre que de servir de plateforme à sa communauté. Le site est gratuit à utiliser, n'a pas besoin de donations pour vivre, ne contient pas de publicités ni de contenus tiers, {{link++|pages/doc/privacy|respecte votre vie privée|bold|}}, et ne collecte pas {{link++|pages/doc/data|vos données personnelles|bold|}}.
EOT
);
___('nobleme_home_statement_2',     'EN', <<<EOT
Conservatives, reactionaries, or anyone else whose worldview involves belittling others are not welcome on NoBleme. If you happen to be one of those people, worry not, many other websites and communities on the Internet already cater to your needs. NoBleme is however not a safe space: discussing or debating any topic is fine, but we will show low tolerance towards lack of empathy and oppressive behavior.
EOT
);
___('nobleme_home_statement_2',     'FR', <<<EOT
Les conservateurs, traditionnalistes, nationalistes, et autres réactionnaires ne sont pas bienvenus. Si vous êtes une de ces personnes, ne vous inquiétez pas, il existe un grand nombre d'autres communautés et sites Internet pour vous, NoBleme n'en fait juste pas partie. Nous sommes une communauté inclusive mais pas pour autant excessivement protectrice : tous les sujets sont autorisés lors des conversations et des débats, sous condition de savoir faire preuve d'empathie et d'éviter les comportements oppressifs.
EOT
);
___('nobleme_home_statement_3',     'EN', <<<EOT
The navigation menu on top of each page allows you to explore NoBleme's contents. You can join the community by interacting with us on our {{link++|pages/social/irc|IRC chat|bold|}} or on {{link++|pages/social/discord|Discord|bold|}}.
EOT
);
___('nobleme_home_statement_3',     'FR', <<<EOT
Le menu de navigation situé en haut de chaque page vous permet d'explorer le contenu de NoBleme. Vous pouvez interagir avec la communauté via notre {{link++|pages/social/irc|chat IRC|bold|}} ou sur {{link++|pages/social/discord|Discord|bold|}}.
EOT
);

// 21st century compendium
___('nobleme_home_compendium_1',      'EN', <<<EOT
NoBleme includes the {{link++|pages/compendium/index|21st century compendium|bold|}}: a small encyclopedia documenting some aspects of 21st century culture, including {{link++|pages/compendium/meme|memes|bold|}}, {{link++|pages/compendium/slang|slang|bold|}}, and {{link++|pages/compendium/sociocultural|sociocultural|bold|}} topics.
EOT
);
___('nobleme_home_compendium_1',      'FR', <<<EOT
NoBleme contient le {{link++|pages/compendium/index|compendium du 21ème siècle|bold|}}: une petite encyclopédie documentant des aspects de la culture du 21ème siècle, incluant des {{link++|pages/compendium/meme|memes|bold|}}, de {{link++|pages/compendium/slang|l'argot|bold|}}, et des contenus {{link++|pages/compendium/sociocultural|socioculturels|bold|}}.
EOT
);
___('nobleme_home_compendium_2',      'EN', <<<EOT
Answers to most questions related to this compendium (why does it exist? what are its goals? what is a compendium anyway?) can be found in the compendium's {{link++|pages/compendium/mission_statement|mission statement|bold|}}.
EOT
);
___('nobleme_home_compendium_2',      'FR', <<<EOT
Des réponses à la plupart des questions portant sur ce compendium (pourquoi existe-il ? quels sont ses buts ? qu'est-ce qu'un compendium ?) se trouvent dans sa {{link++|pages/compendium/mission_statement|foire aux questions|bold|}}.
EOT
);
___('nobleme_home_compendium_3',      'EN', <<<EOT
You can find a {{link++|pages/compendium/page_list|list of all pages|bold|}} in the compendium, which will hopefully lead you to learn new things and have a few good laughs. Or maybe you're the type of person that would rather get started with a {{link++|pages/compendium/random_page|random page|bold|}} or a {{link++|pages/compendium/random_image|random image|bold|}} and see where fate leads you…
EOT
);
___('nobleme_home_compendium_3',      'FR', <<<EOT
En partant de la {{link++|pages/compendium/page_list|liste des pages|bold|}} du compendium, vous pourriez apprendre de nouvelles choses ou vous marrer un bon coup. Ou peut-être etes-vous le type de personne qui préfère commencer par une {{link++|pages/compendium/random_page|page au hasard|bold|}} ou une {{link++|pages/compendium/random_image|image au hasard|bold|}} et voir où le destin vous amène…
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  FOLLOW NOBLEME                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Community
___('nobleme_follow_community_title',   'EN', "Community life");
___('nobleme_follow_community_title',   'FR', "La communauté");
___('nobleme_follow_community_body_1',  'EN', <<<EOT
NoBleme's community can be found and interacted with in a few places. Our {{link|pages/social/irc|IRC chat server}} acts as our main real time chat hub, though you can also chat with some of us on our {{link|pages/social/discord|Discord}} server.
EOT
);
___('nobleme_follow_community_body_1',  'FR', <<<EOT
La communauté de NoBleme se trouve à plusieurs endroits différents. Notre {{link|pages/social/irc|chat IRC}} est la principale plateforme de communication en temps réel que nous utilisons, mais vous pouvez également discuter avec une partie d'entre nous sur notre {{link|pages/social/discord|serveur Discord}}.
EOT
);
___('nobleme_follow_community_body_2',  'EN', <<<EOT
You can also use the website to keep in touch with our {{link|pages/meetups/list|real life meetups}}, which are mostly organized on {{link|pages/social/irc|IRC}}.
EOT
);
___('nobleme_follow_community_body_2',  'FR', <<<EOT
Nos {{link|pages/meetups/list|rencontres IRL}} sont documentées sur le site, et sont principalement organisées sur {{link|pages/social/irc|IRC}}.
EOT
);


// Activity
___('nobleme_follow_activity_title',  'EN', "Website activity");
___('nobleme_follow_activity_title',  'FR', "Activité du site");
___('nobleme_follow_activity_body_1', 'EN', <<<EOT
The website's {{link|pages/nobleme/activity|recent activity}} page lets you keep track of anything that happens on the website, and can be filtered to look for specific content you would like to follow.
EOT
);
___('nobleme_follow_activity_body_1', 'FR', <<<EOT
La page {{link|pages/nobleme/activity|activité récente}} vous permet de suivre tout ce qui se passe sur le site, et vous permet de filtrer l'activité si vous désirez suivre des contenus spécifiques.
EOT
);
___('nobleme_follow_activity_body_2', 'EN', <<<EOT
If, instead of checking periodically for new content, you would rather like to be notified in real time whenever anything new happens on the website, notifications are automatically sent to the main english and french channels of our {{link|pages/social/irc|IRC chat server}} aswell as in dedicated notification channels on {{link|pages/social/discord|Discord}} anytime something of note happens.
EOT
);
___('nobleme_follow_activity_body_2', 'FR', <<<EOT
Si, plutôt que de regarder périodiquement la page activité récente, vous préférez avoir des notifications en temps réel de l'activité du site, toute forme d'activité sur le site est communiquée en temps réel sur le principal canal de discussion francophone et anglophone de notre {{link|pages/social/irc|serveur IRC}}, ainsi que sur notre {{link|pages/social/discord|Discord}}.
EOT
);


// Activity
___('nobleme_follow_social_title',  'EN', "Social media");
___('nobleme_follow_social_title',  'FR', "Médias sociaux");
___('nobleme_follow_social_body_1', 'EN', <<<EOT
NoBleme has two official socia media accounts. Any other social media account claiming to represent NoBleme is not an official account.
EOT
);
___('nobleme_follow_social_body_1', 'FR', <<<EOT
NoBleme possède deux comptes officiels sur des sites tiers. Tout autre compte sur un site tiers affirmant représenter NoBleme ne représente pas NoBleme.
EOT
);
___('nobleme_follow_social_body_2', 'EN', <<<EOT
{{external_popup|https://hsnl.social/web/@NoBleme|Our Mastodon account @nobleme@hsnl.social}} relays updates from the {{link|pages/compendium/index|21st century compendium}}, along with major NoBleme website and community news. It is a mostly automated account which will usually not engage in any conversations.
EOT
);
___('nobleme_follow_social_body_2', 'FR', <<<EOT
{{external_popup|https://hsnl.social/web/@NoBleme|Notre compte Mastodon @nobleme@hsnl.social}} partage l'activité du {{link|pages/compendium/index|compendium du 21ème siècle}}, ainsi que les nouvelles majeures concernant la communauté et le site. Le compte est automatisé, et n'a pas pour but de participer à des conversations.
EOT
);
___('nobleme_follow_social_body_3', 'EN', <<<EOT
{{external_popup|https://reddit.com/r/NoBleme/|Our subreddit r/nobleme}} relays updates from the {{link|pages/compendium/index|21st century compendium}}, along with major NoBleme website and community news. Feel free to engage in conversations on the subreddit, but make sure to respect its rules and keep it on the topic of NoBleme.
EOT
);
___('nobleme_follow_social_body_3', 'FR', <<<EOT
{{external_popup|https://reddit.com/r/NoBleme/|Notre subreddit r/nobleme}} partage l'activité du {{link|pages/compendium/index|compendium du 21ème siècle}}, ainsi que les nouvelles majeures concernant la communauté et le site. Si vous participez à des conversations sur le subreddit, assurez-vous d'en respecter les règles.
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  WHAT IS NOBLEME                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Images
___('nobleme_history_img_2005_forum', 'EN', "NoBleme's message board in april 2005, a month after launch (click on images to view them full screen)");
___('nobleme_history_img_2005_forum', 'FR', "Le forum NoBleme en avril 2005, un mois après sa création (cliquez sur les images pour les agrandir)");
___('nobleme_history_img_2006_home',  'EN', "NoBleme's very bare homepage in early 2006 reflects how ugly the Internet used to look as a whole");
___('nobleme_history_img_2006_home',  'FR', "La page d'accueil très vide de NoBleme en 2006 nous rappelle à quel point l'Internet était moche à cette époque");
___('nobleme_history_img_2008_nrm',   'EN', "The {{link|pages/social/games_history#nrm|NRM Online}} in 2008. Would you believe that this was considered very good looking by 2008 Internet standards? Times change.");
___('nobleme_history_img_2008_nrm',   'FR', "Le {{link|pages/social/games_history#nrm|NRM Online}} en 2008. Ce site était considéré comme très joli en 2008. Les temps changent.");
___('nobleme_history_img_2008_nbrpg', 'EN', "Behind the scenes, the original {{link|pages/social/games_history#nbrpg|NoBlemeRPG}}'s dungeon master interface (players never saw it)");
___('nobleme_history_img_2008_nbrpg', 'FR', "Le dessous du {{link|pages/social/games_history#nbrpg|NoBlemeRPG}} : l'interface d'administration du jeu");
___('nobleme_history_img_2008_wiki',  'EN', "NoBleme's wiki's homepage in 2008");
___('nobleme_history_img_2008_wiki',  'FR', "Le Wiki NoBleme en 2008");
___('nobleme_history_img_2010_black', 'EN', "The 2010 blackout");
___('nobleme_history_img_2010_black', 'FR', "Le blackout de 2010");
___('nobleme_history_img_2012_home',  'EN', "NoBleme's homepage following the 2012 website relaunch");
___('nobleme_history_img_2012_home',  'FR', "La page d'accueil de NoBleme après son redesign de 2012");
___('nobleme_history_img_2015_home',  'EN', "The homepage following a small redesign in 2015 for the website's 10th birthday");
___('nobleme_history_img_2015_home',  'FR', "La page d'accueil de NoBleme après un petit redesign en 2015 pour son 10ème anniversaire");
___('nobleme_history_img_2017_home',  'EN', "Another redesign happened in 2017, making NoBleme fully bilingual after 12 years of being french only");
___('nobleme_history_img_2017_home',  'FR', "Un autre redesign a eu lieu en 2017, rendant NoBleme bilingue après 12 à avoir été francophone uniquement");
___('nobleme_history_img_2019_nbdb',  'EN', "The definition of a meme on NoBleme in 2019");
___('nobleme_history_img_2019_nbdb',  'FR', "La définition d'un meme sur NoBleme en 2019");
___('nobleme_history_img_2021_home',  'EN', "NoBleme was yet again relaunched in 2021, shedding its old white and blue color theme in the process");
___('nobleme_history_img_2021_home',  'FR', "La page d'accueil de NoBleme après le redesign de 2021, marquant la fin du thème bleu et blanc");


// Header
___('nobleme_what_subtitle',  'EN', "Easy question, complicated answer");
___('nobleme_what_subtitle',  'FR', "Question simple, réponse compliquée");
___('nobleme_what_intro',     'EN', <<<EOT
NoBleme is a community which has continuously existed in its tiny corner of the Internet since 2005. With no specific theme, the website evolved over time to fit the needs of its community. In its early years, NoBleme was a {{external|https://en.wikipedia.org/wiki/Internet_forum|message board}}, which eventually shut down as the whole of the Internet changed and NoBleme's community didn't have any use for it anymore. Instead of trying to summarize the website's long and tortuous evolution, you will find further down this very page a full history of NoBleme from before its birth until now.
EOT
);
___('nobleme_what_intro',     'FR', <<<EOT
NoBleme est une communauté qui existe en continu dans son coin d'Internet depuis 2005. Sans thème spécifique, le site a évolué à travers les années pour s'adapter aux besoins de sa communauté. Plutôt que d'essayer de résumer la longue et tortueuse histoire de NoBleme, vous trouverez sur cette page l'histoire complète du site de sa préhistoire jusqu'à aujourd'hui.
EOT
);
___('nobleme_what_intro2',    'EN', <<<EOT
Telling the tale of NoBleme's past will help you better understand what it is and why it has existed for so long. It will also serve as a way to set up the answers to more questions afterwards: What is NoBleme's purpose? What is NoBleme's future? Why would I want to be a part of NoBleme? Strap yourself in and get ready for a long (but hopefully entertaining) story.
EOT
);
___('nobleme_what_intro2',    'FR', <<<EOT
En lisant l'histoire de NoBleme, vous devriez arriver à mieux comprendre d'où vient ce site et pourquoi il existe depuis si longtemps. Cela nous servira également de base pour répondre à d'autres questions par la suite : À quoi sert NoBleme ? Quel est le futur de NoBleme ? Pourquoi voudriez-vous faire partie de NoBleme ? Préparez vous pour une longue (mais j'espère divertissante) histoire.
EOT
);


// History: The before years
___('nobleme_history_title',    'EN', "NoBleme's story");
___('nobleme_history_title',    'FR', "L'histoire de NoBleme");
___('nobleme_history_beforet',  'EN', "Act I: The before years (2001-2005)");
___('nobleme_history_beforet',  'FR', "Acte I: Avant NoBleme (2001-2005)");
___('nobleme_history_before1',  'EN', <<<EOT
Let's go back in time together, to the early days of the modern Internet. Our time travel takes us to the dawn of the 21st century, back when most of the biggest websites of today didn't even exist yet, back when mobile phones were only used to make phone calls and send text messages. In France, few people had Internet access at home, many still used the competing {{external|https://en.wikipedia.org/wiki/Minitel|Minitel}} network rather than the Internet.
EOT
);
___('nobleme_history_before1',  'FR', <<<EOT
Remontons ensemble dans le temps, jusqu'aux débuts de l'Internet moderne. Notre voyage temporel nous amène au début du 21ème siècle, à une époque où la plupart des grands sites internet que vous connaissez aujourd'hui n'existaient pas encore, une époque où les téléphones ne servaient qu'à téléphoner et à s'envoyer des SMS. En France, la présence du {{external|https://fr.wikipedia.org/wiki/Minitel|Minitel}} servait de substitut à Internet dans beaucoup de foyers.
EOT
);
___('nobleme_history_before2',  'EN', <<<EOT
In this prehistoric environment, {{external|https://en.wikipedia.org/wiki/Internet_caf%C3%A9|cyber cafés}} thrived in the streets of France, allowing people to use the Internet without having access to it at home. As they were a business, there was a price - often steep - on Internet usage. Back then, young teenager {{link|pages/users/1|Bad}} was resorting to dealing {{external|https://en.wikipedia.org/wiki/Magic:_The_Gathering|Magic: The Gathering}} trading cards for cash, fueling the addiction of a few high school mates. Using the shadily acquired money, he went and spent it on local cyber cafés, which apparently had no issue taking the money of such a young customer, and used their computers to play multiplayer video games such as Starcraft: Brood War, Quake III Arena, and Warcraft III.
EOT
);
___('nobleme_history_before2',  'FR', <<<EOT
Dans cet environnement préhistorique, les {{external|https://fr.wikipedia.org/wiki/Cybercaf%C3%A9|cybercafés}} étaient le seul moyen d'accéder à Internet pour le grand nombre de gens qui ne l'avaient pas à domicile. Hélas, cela signifiait qu'il fallait payer un prix - souvent cher - pour pouvoir accéder à Internet. À cette époque, le jeune {{link|pages/users/1|Bad}} faisait du trafic de cartes à jouer {{external|https://fr.wikipedia.org/wiki/Magic_:_L%27Assembl%C3%A9e|Magic : L'assemblée}} dans son collège, profitant d'un filon lucratif reposant sur l'addiction de ses camarades de classe. L'argent ainsi acquis était ensuite utilisé pour acheter des heures d'Internet dans des cyber cafés, qui ne semblaient pas avoir de problème à prendre l'argent d'un jeune adolescent.
EOT
);
___('nobleme_history_before3',  'EN', <<<EOT
Not satisfied with just playing, the young protagonist of our story wanted to hone his skills and become a better, stronger video game player. This required joining various online communities, which communicated with each other through {{external|https://en.wikipedia.org/wiki/Internet_forum|message boards}} and {{external|https://en.wikipedia.org/wiki/Internet_Relay_Chat|irc chat servers}}.
EOT
);
___('nobleme_history_before3',  'FR', <<<EOT
Dans ces cyber cafés, notre jeune protagoniste jouait à des jeux vidéo compétitifs - principalement Starcraft, Quake III, et Warcraft III. Obsédé par un désir d'être aussi performant que possible à ces jeux, il rejoint les communautés de joueurs de l'époque, qui communiquent principalement via des {{external|https://fr.wikipedia.org/wiki/Forum_(informatique)|forums de discussion}} et sur des {{external|https://fr.wikipedia.org/wiki/Internet_Relay_Chat|salons de conversation IRC}}.
EOT
);
___('nobleme_history_before4',  'EN', <<<EOT
After a few years of going from online community to online community, our protagonist finally got Internet access at home in 2003, and thought about creating a community of his own. Being young and naive, he did not ask himself simple questions beforehand such as "how does one build a website", "does it cost money to host a website", "why would people even want to join my community". Undeterred by the challenges, he learned the basics of computer programming and website hosting, and eventually opened a website called "Leuphorie-world" (don't blame a 14 years old for having bad taste in naming). Leuphorie-world was comprised of a few pages containing random content (french puns, unfunny jokes, charades, stuff nobody cared about) and a message board which only a few schoolmates used, mostly to mock him for running a useless website. Great mindset, guys. Thanks.
EOT
);
___('nobleme_history_before4',  'FR', <<<EOT
Après quelques années à visiter ces communautés de joueurs en ligne, notre protagoniste finit par acquérir le graal en 2003 : un accès Internet à domicile. Sans raison particulière, il décide qu'il a lui aussi envie de créer sa propre communauté en ligne. Jeune et naïf, il ne se pose pas des questions essentielles telles que « comment construire un site Internet », « faut-il de l'argent pour héberger un site internet », ou « qu'est-ce qui motiverait des gens à rejoindre ma communauté ». Sans réfléchir à ces défis, il apprend les bases de la programmation informatique et ouvre son propre site Internet : Leuphorie-world (on a tous eu 14 ans un jour). Sur ce site, on ne trouve pas grand chose d'intéressant. Des blagues pas drôles, des charades, des jeux de mots, et un forum qui n'est utilisé que par quelques camarades de classe pour se moquer de la nullité du site. Merci les amis.
EOT
);
___('nobleme_history_before5',  'EN', <<<EOT
Meanwhile, the foundations of what would later become NoBleme were being seeded all around the Internet. In real life, our protagonist was making new friends who liked the idea of having a place online to talk together. For some video games, he was programming custom content and had various people tell him that he should host them on a website of his own. In a random corner of the french Internet, he was playing an online game called Super Robot Wars Online, which was doing well and building up a decently sized community at the time, but will play a role in the story of NoBleme later on.
EOT
);
___('nobleme_history_before5',  'FR', <<<EOT
Suite à cet échec, les fondations de ce qui deviendra par la suite NoBleme sont en train de germer. Dans le mondée réel, notre protagoniste se fait de nouveaux amis qui aiment bien l'idée d'avoir un lieu pour pouvoir discuter entre eux sur Internet. Du côté des jeux vidéo, il programme du contenu personnalisé et se fait régulièrement dire qu'il devrait créer son propre site pour le partager avec le grand public. Dans un coin de l'Internet francophone, il joue à un jeu en ligne nommé Super Robot Wars Online qui se construit une communauté plutôt grande de joueurs fidèles, qui auront beaucoup plus tard un rôle dans l'histoire de NoBleme.
EOT
);
___('nobleme_history_before6',  'EN', <<<EOT
And yes, let's address the elephant in the room: I am talking about myself in the third person and calling myself "the protagonist", for it is I, Bad, who is writing this very content. Am I doing it for the sake of quality storytelling, is it just cringe, is it a symptom of  megalomania, or could it be a combination of all three? You, lucky reader, get to decide for yourself. Don't worry though, we're almost done with that part, as what used to be the story of one person is about to become the story of a whole community…
EOT
);
___('nobleme_history_before6',  'FR', <<<EOT
Comme vous l'aurez assurément remarqué, je n'ai rien de plus intelligent à faire que de parler de moi à la troisième personne en me surnommant « le protagoniste ». Est-ce pour améliorer la qualité narrative de cette histoire, est-ce juste malaisant, est-ce un symptôme de mégalomanie, ou peut-être une combinaison des trois ? Je vous laisse la liberté de vous faire votre propre opinion sur ce sujet. Toutefois, ne vous inquiétez pas, nous en avons presque fini avec la troisième personne, car ce qui était jusque-là l'histoire d'un individu est sur le point de devenir l'histoire d'une communauté entière…
EOT
);


// History: Genesis
___('nobleme_history_earlyt', 'EN', "Act II: Genesis (2005)");
___('nobleme_history_earlyt', 'FR', "Acte II: Genèse (2005)");
___('nobleme_history_early1', 'EN', <<<EOT
In early 2005, the puzzle finally got assembled. A real life friend of our protagonist (yes I'm doing this again) was stuck with an issue: as an aspiring artist, they wanted to upload some of their custom made videos on the Internet, but websites like YouTube did not exist yet. Instead, videos had to be shared by being hosted on someone's server, then manually giving people a link to that video so that they could open a custom tool on their computer such as RealPlayer or Winamp to stream it. It was messy, complicated, unintuitive, and this is where the original idea for NoBleme appeared: assembling a website that could let people play videos online in a much simpler way.
EOT
);
___('nobleme_history_early1', 'FR', <<<EOT
Début 2005, la dernière pièce du puzzle s'assemble. Un ami de notre protagoniste avait un problème : en tant que jeune artiste, il réalisait des vidéos et voulait pouvoir les partager sur Internet. Hélas, les plateformes de partage de vidéo telles que YouTube n'existaient pas encore. À la place, il fallait héberger ses vidéos sur le serveur privé de quelqu'un, puis communiquer manuellement un lien vers cette vidéo à son public afin qu'ils puissent ouvrir un outil sur leurs ordinateurs leur permettant de visionner la vidéo en question. C'était long, compliqué, contre-intuitif, et c'est de là qu'est venu l'idée d'origine de NoBleme: créer une plateforme qui permettrait à n'importe qui de mettre en ligne ses propres vidéos pour qu'elles puissent y être visionnées sans avoir besoin d'utiliser d'outil tiers.
EOT
);
___('nobleme_history_early2', 'EN', <<<EOT
Reality quickly caught up with our protagonist. The concept behind being a streaming video host (such as YouTube) was actually fairly simple, but the scale of the required server infrastructure and the costs to maintain it were simply not affordable for a 16 years old. But by now, a server had already been pre-paid for a full year, and it would be silly to let it go to waste. After a bit of brainstorming with a few of the people mentioned in the previous section, the domain name "nobleme.com" was selected and bought - nobleme being shorthand for "no problem" in french.
EOT
);
___('nobleme_history_early2', 'FR', <<<EOT
Bien entendu, la réalité a rapidement rattrapé le rêve. Monter une plateforme de streaming de vidéo (telle que YouTube) est simple dans l'idée, mais l'échelle de l'infrastructure requise et les coûts récurrents du maintien de cette infrastructure n'étaient pas à la portée d'un jeune de 16 ans. Toutefois, pour faire des expériences, il avait déjà pré-payé un serveur pour une année entière, et ce serait idiot de le gâcher. Après une séance de réflexion collective avec quelques amis, le nom de domaine « nobleme.com » fut choisi et acheté.
EOT
);
___('nobleme_history_early3', 'EN', <<<EOT
Now armed with some basic technical knowledge, a server pre-paid for a year, and a domain name, but no idea what to do with any of them, it was decided that NoBleme would simply be a generic place where people can hang out. So creative. A message board was added on the website, and that was it: march 19th 2005, NoBleme opened its doors, with nothing more than a message board, no concept or theme, and a tiny community of french people who mostly didn't know eachother… and would soon come to dislike eachother. Great start.
EOT
);
___('nobleme_history_early3', 'FR', <<<EOT
Armé d'un peu de savoir techinque, d'un serveur prépayé pour un an, et d'un nom de demaine, mais sans aucune idée de quoi en faire, il fut finalement décidé que NoBleme serait un lieu générique sur lequel les gens pourraient discuter. Très créatif, super original. Pour ce faire, un forum de discussion fut ajouté sur le site, et il fut ouvert au public le 19 mars 2005. Nous voilà donc pour la première fois en présence de NoBleme : un site sans thème, sans concept, ne contenant qu'un forum et une communauté de personnes qui ne se connaissaient pas encore… et étaient sur le point de se détester. C'est un bon début, n'est-ce pas ?
EOT
);
___('nobleme_history_early4', 'EN', <<<EOT
In a plot twist that nobody expected at the time, the NoBleme forum (that's how we called the message board) actually had an explosive growth during its first few months, as the original "founding" members took part in various conversations with each other and recommended the website to their friends. And so, months after founding the website, our protagonist found himself doomed to actually do something with it. What should NoBleme become? Any ideas? Because I sure didn't have any at the time.
EOT
);
___('nobleme_history_early4', 'FR', <<<EOT
Ce que personne n'avait vu venir à l'époque, c'est que le forum NoBleme allait devenir populaire. Pendant ses premiers mois d'existence, des conversations ont lieu en continu, et certains membres du forum y amènent leurs connaissances, faisant grandir rapidement NoBleme. C'est ainsi qu'à peine quelques mois après avoir crée un site Internet au hasard et sans ambition, notre protagoniste se retrouve forcé d'en faire quelque chose. Que faire de NoBleme ? Des idées ? Parce qu'à l'époque, je n'en avais aucune.
EOT
);
___('nobleme_history_early5', 'EN', <<<EOT
As quickly as it rose, NoBleme's popularity waned. Such is fate, destroyer of hopes, cruel and heartless. Concepts such as {{external|https://en.wikipedia.org/wiki/Online_community_manager|community management}} were still in their infancy, and it seemed like a good idea at the time to let the forum run itself without any administrative team. If users got into fights, we'd bring out the popcorn and take sides instead of trying to deescalate the situation. Oddly enough, the only thing that made us bring out the moderation tools were grammar mistakes. A shared account called BrigadeAntisam was created by the "founding" members and used to delete messages that had too many grammar mistakes in them. Teenagers. Different times.
EOT
);
___('nobleme_history_early5', 'FR', <<<EOT
Aussi rapidement que la popularité de NoBleme a grimpé, elle s'est mise à dégringoler. Tel est le destin, cruel et tueur d'espoirs. Le concept du {{external|https://fr.wikipedia.org/wiki/Animateur_de_communaut%C3%A9|community management}} n'existait pas encore à l'époque, et l'idée de faire du forum un lieu de libre conversation sans aucune modération semblait être une bonne idée. Si des membres se retrouvaient en conflit, nous sortions le popcorn et prenions part au conflit au lieu de chercher à le désamorcer. Étrangement, la seule chose qui nous motivait à agir était l'orthographe. Un compte partagé nommé BrigadeAntispam fut crée dans le but de supprimer les messages qui contenaient trop de fautes d'orthographe. S'il y a le moindre doute que nous étions stupides, j'espère qu'il est maintenant levé.
EOT
);
___('nobleme_history_early6', 'EN', <<<EOT
Inevitably, the amount of drama happening on the forum caused some of the users to leave. At first, we thought it was funny, but soon enough came the realization that less users meant less activity, and that NoBleme was well on its way to dying before it even reached a year of age. Not only that, but we were beginning to realize how evil we were being in the way we ran the forum… quite far removed from the "no problem" attitude implied by the website's name. The time for change had come.
EOT
);
___('nobleme_history_early6', 'FR', <<<EOT
Inévitablement, certains membres n'avaient pas envie de rester sur un forum aussi conflictuel, et partirent de NoBleme. Au début, nous trouvions ça drôle, puis vint la réalisation que ces départs étaient en train de lentement tuer le forum, et que NoBleme était bien parti pour disparaître avant même d'avoir fini sa première année d'existence. Qui plus est, nous étions en train de réaliser à quel point notre attitude sur le forum était problématique, et éloignée de l'attitude "no problème" impliquée par le nom du site. Il fallait changer.
EOT
);


// History: Birth of a community
___('nobleme_history_communityt', 'EN', "Act III: Birth of a community (2006-2009)");
___('nobleme_history_communityt', 'FR', "Acte III: Naissance d'une communauté (2006-2009)");
___('nobleme_history_community1', 'EN', <<<EOT
The early years of NoBleme were a time of trials, successes, and failures. Instead of letting the community implode, it was decided that the forum would be properly moderated from now on, and that any aggressive users would be expelled. As a short term measure to stop the bleeding, it worked, but it was far too late: most of the original community had already left.
EOT
);
___('nobleme_history_community1', 'FR', <<<EOT
Les premières années de NoBleme furent remplies d'essais, de succès, et d'échecs. Au lieu de laisser la communauté imploser, il fut décidé que le forum devrait être correctement modéré, et que les membres agressifs se feraient exclure. En tant que mesure immédiate pour arrêter l'hémorragie, c'était un bon plan, mais il était trop tard : la majorité de la communauté d'origine était déjà partie.
EOT
);
___('nobleme_history_community2', 'EN', <<<EOT
At this point, a rational person would have stopped the experiment, learned a few lessons from it, and moved on. Our protagonist's strategy was quite the opposite: throw everything at the wall and see what sticks. Within the first months of 2006, many different new contents were added to NoBleme: an {{link|pages/social/irc|IRC chat server}} for the community to interact in real time, some {{link|pages/meetups/list|real life meetups}} to create bonds between those who lived around Paris, an arcade page full of small video games with high score contests to compete for, a text based roleplaying game over IRC, a forum based automated cycling race simulator, a short story writing competition, a {{external|https://en.wikipedia.org/wiki/Wiki|wiki}} open to everyone which would eventually become a documentation of early internet culture, and a browser based strategy game in which users would become {{external|https://en.wikipedia.org/wiki/Mecha|mecha}} pilots and fight each other over month long seasons.
EOT
);
___('nobleme_history_community2', 'FR', <<<EOT
C'est là qu'une personne rationelle aurait arrêté l'expérience, en aurait tiré des leçons, et serait passée à autre chose. Mais notre protagoniste a choisi la stratégie opposée : tenter le plus de choses possibles et voir ce qui fonctionnait. En 2006, de nombreux nouveaux contenus furent ajoutés à NoBleme : un {{link|pages/social/irc|serveur de chat IRC}} pour que la communauté puisse interagir en temps réel, des {{link|pages/meetups/list|rencontres IRL}} afin de créer des liens entre les membres habitant en région parisienne, une arcade remplie de minijeux et de concours pour obtenir les meilleurs scores, un jeu de rôle via IRC, un simulateur de course cycliste, une compétition d'écriture de nouvelles, un {{external|https://fr.wikipedia.org/wiki/Wiki|wiki}} ouvert à tous les membres qui deviendra par la suite une documentation de la culture Internet, et un jeu de stratégie dans lequel les membres incarnaient des pilotes de {{external|https://fr.wikipedia.org/wiki/Mecha|mechas}} qui se battaient entre eux.
EOT
);
___('nobleme_history_community3', 'EN', <<<EOT
Some of these ideas would succeed more than others, but ultimately, none of them grew NoBleme back to the size which it used to be. However, the real life meetups and the IRC chat server managed to create deeper bonds between some of the community's members, and built the foundation for NoBleme to become an actual community: people who knew each other, got along well, and enjoyed their little collective corner of the Internet. As for the other attempts at growing the website… let's quickly tell the story of some of them.
EOT
);
___('nobleme_history_community3', 'FR', <<<EOT
Certaines de ces idées ont plutôt bien fonctionné (d'autres moins), mais aucune d'entre elles n'a permis à NoBleme de retrouver sa taille initiale. Toutefois, les rencontres IRL et le serveur de chat IRC ont permis de développer des liens personnels entre certains membres, ce qui a transformé NoBleme en une réelle communauté: un groupe d'individus qui se connaissent, s'entendent bien, et apprécient leur coin collectif paumé d'Internet. Pour ce qui est des autres idées… parlons rapidement de certaines d'entre elles.
EOT
);
___('nobleme_history_community4', 'EN', <<<EOT
Remember the Super Robot Wars game which was mentioned much earlier, in the before-NoBleme times? By 2006, that game's maintainer was getting caught up with real life issues, and the game was dying. Plagued by cheaters and abuse, some of its players abandoned it, but others were striving to find an alternative game to play. And so, the NRM Online was born (it stands for NoBleme Robot Mayhem, and yes, it's an awful name). A fun strategy game, it peaked in popularity in 2007 with around a hundred regular users, but then fell apart as real life issues caught up with our protagonist, the game's sole maintainer. Ironic, isn't it? A few of the game's regular players joined NoBleme's community along the way, and the game eventually shut its doors in 2008. Lessons learned: game design is hard, balancing a multiplayer game is hard, and maintaining an online game takes a lot of time and effort. Like, a LOT. Much more than you'd think. It's a full time job.
EOT
);
___('nobleme_history_community4', 'FR', <<<EOT
Nous avons mentionné plus tôt un jeu nommé Super Robot Wars Online. Vers 2006, l'unique administrateur de ce jeu se retrouve rattrapé par sa vie et n'a plus le temps libre requis pour s'en occuper. Infesté de tricheurs, le jeu est mourant. La majorité de ses joueurs l'abandonnent, mais certains d'entre eux cherchent une alternative pour continuer à jouer à quelque chose d'au moins un peu similaire. C'est ainsi que le NRM Online est né (NRM signifie NoBleme Robot Mayhem - oui, c'est un nom tout naze). Un jeu de stratégie gratuit, amusant, et très peu chronophage, il a atteint le maximum de son succès en 2007 lorsqu'une centaine de personnes y jouaient simultanément. Ironiquement, notre protagoniste, unique administrateur de ce jeu, rattrapé par sa vie, n'a plus le temps libre requis pour s'en occuper. Le NRM ferme ses portes en 2008. Leçons apprises : le game design n'est pas quelque chose de simple, il est très complexe d'équilibrer un jeu multijoueur, et maintenir un jeu en ligne demande tellement de temps et d'efforts que c'est un travail à temps plein.
EOT
);
___('nobleme_history_community5', 'EN', <<<EOT
The text based roleplaying game mentioned earlier was played in real time over the IRC chat server. Our protagonist acted as the {{external|https://en.wikipedia.org/wiki/Dungeon_Master|dungeon master}}, guiding various player characters along a wacky custom made world filled with incoherent nonsense and unexpected plot twists. It wasn't the best game around, but it did have great success until its end in 2009. For nostalgia's sake, and due to popular demand, a new story arc of the game was played in 2015-2016, which concluded every previous story arc and filled every leftover plot hole from years earlier (continuity matters!). Lessons learned: people enjoy fun things, coming up with interesting stories and plotlines is very hard, creating your own tools instead of using existing ones is extremely time consuming for very little added value.
EOT
);
___('nobleme_history_community5', 'FR', <<<EOT
Le jeu de rôle mentionné plus tôt portait le nom de NoBlemeRPG, et était joué en temps réel sur le serveur de discussion IRC. Notre protagoniste était le {{external|https://fr.wikipedia.org/wiki/Ma%C3%AEtre_de_donjon|maître du donjon}}, guidant une équipe de personnages incarnés par des membres de NoBleme lors de leurs aventures à travers un monde rempli de non-sens incohérent et de rebondissements inattendus. Ce n'était assurément pas le meilleur jeu de rôle qui soit, mais il est resté populaire jusqu'à sa fin en 2009. Par pure nostalgie, le NoBlemeRPG fut ranimé plus tard, en 2015-2016, afin de conclure tous les arcs narratifs qui étaient restés ouverts à la fin du jeu en 2009 (la continuité, c'est important !). Leçons apprises : les gens aiment s'amuser, inventer un nouveau scénario chaque semaine devient vite très complexe, créer ses propres outils au lieu d'utiliser des outils déjà existants est une perte de temps gigantesque.
EOT
);
___('nobleme_history_community6', 'EN', <<<EOT
Last but not least, the very lazily named "Wiki NoBleme" was the most successful part of this era of NoBleme's history.
As modern {{link|pages/compendium/index|internet culture}} was starting to become a proper thing, and as {{link|pages/compendium/index|memes}} were becoming a big part of modern culture, NoBleme's wiki was from 2006 onwards the only french language website documenting memes, listing, categorizing, and explaining them. It became wildly popular, bringing thousands of new visitors per day to NoBleme. Sadly, very few of those visitors joined the community (or even knew that there was a community behind the website), and those who did were usually the undesirable kind: trolls, kids, edgy teenagers. Lessons learned: growing a community is truly hard, people were craving content about Internet culture, kids and teenagers love memes a lot more than you'd think (and that's great!).
EOT
);
___('nobleme_history_community6', 'FR', <<<EOT
Il faut également mentionner le créativement nommé Wiki NoBleme, qui fut la partie la plus populaire de cette époque de NoBleme. Tandis que la {{link|pages/compendium/index|culture internet}} moderne commençait à devenir quelque chose de concret, et que les {{link|pages/compendium/index|memes}} devenaient une partie importante de la culture populaire, le Wiki NoBleme était dès 2006 l'unique site Internet francophone listant, documentant, catégorisant, et expliquant les memes. Même si le Wiki amenait des milliers de visiteurs par jour sur NoBleme, la grande majorité de ces personnes ne rejoignaient pas la communauté (ou ne réalisaient même pas qu'elle existait), et lorsqu'un membre rejoignait la communauté depuis le Wiki il s'agissait souvent d'un indésirable : trolls, gamins, provocateurs. Leçons apprises : faire grandir une communauté n'est pas une chose simple, la culture Internet est un sujet populaire, les enfants et les jeunes adolescents s'intéressent beaucoup aux memes (et c'est tant mieux !).
EOT
);
___('nobleme_history_community7', 'EN', <<<EOT
And so, from the ashes of a dying forum, NoBleme's community was born. It had become clear that the website would never have a specific goal or purpose, other than being the home of its community. It had also become clear that growing the community was not an achievable goal. As most of us were maturing into young adults and getting better at hindsight, we realized that maybe things were fine that way and there was no need to look for a purpose to the website or for ways to grow the community. Finally, after over four years of being aimless, NoBleme was slowly developing into something concrete… or was it?
EOT
);
___('nobleme_history_community7', 'FR', <<<EOT
Et c'est ainsi que des cendres d'un forum mourant, la communauté de NoBleme est née. Il était maintenant clair que le site n'aurait jamais de but ou de raison d'être autre que d'être une maison pour sa communauté. Il était également clair que grandir la communauté n'était pas une possibilité. Tandis que nous devenions de jeunes adultes et que nous apprenions à prendre du recul, nous réalisions que peut-être qu'en fait les choses étaient bien comme ça. Il n'y avait pas forcément besoin de chercher une raison d'être à NoBleme, ni de faire grandir la communauté. Enfin, après quatre ans à tout essayer, NoBleme commençait à prendre forme.
EOT
);


// History: The long years
___('nobleme_history_longt',  'EN', "Act IV: The long years (2010-2015)");
___('nobleme_history_longt',  'FR', "Acte IV: Les années creuses (2010-2015)");
___('nobleme_history_long1',  'EN', <<<EOT
Entering into 2010, it had become clear that the website had way too much content, it was time to clean it all up. In early january, a "blackout" happened: the whole website got replaced by a black page, containing only a countdown to NoBleme's 5th birthday. For two months, only the IRC real time chat server remained. Finally, on march 19th 2010 at 00:00, NoBleme was relaunched. To the community's dismay, nothing new was released on that day, the website was simply stripped of all its content other than the barely active forum and the Internet culture Wiki.
EOT
);
___('nobleme_history_long1',  'FR', <<<EOT
Suite à toutes ces expérimentations, il devenait clair que le site avait trop de contenus différents. L'heure du nettoyage était venue. Début janvier 2010, un "blackout" a eu lieu : l'intégralité du site s'est fait remplacer par une page noire contenant un compte à rebours jusqu'au 5ème anniversaire de NoBleme. Pendant deux mois, le chat IRC était la seule partie utilisable du site. Le 19 mars 2010 à 00:00, à la déception générale, rien n'avait changé. NoBleme était de retour, mais avec moins de contenu qu'avant - il ne restait sur le site plus que le léthargique forum et la partie du wiki portant sur les memes et la culture internet.
EOT
);
___('nobleme_history_long2',  'EN', <<<EOT
The following years were a long crawl through the desert for NoBleme. Not much happened until 2012, when NoBleme was yet again "relaunched": this time, the forum and the wiki were both shut down, leaving nothing of use at all on the website. Our protagonist was going through a string of highly complicated real life situations that left him no time or willpower to take care of things (deaths of relatives, career burnout, medical issues: it wasn't a great time). But the community stayed there, its almost family like bonds maintaining themselves through regular real life meetups and on the IRC real time chat server.
EOT
);
___('nobleme_history_long2',  'FR', <<<EOT
Les années suivantes furent une longue période creuse pour NoBleme, à l'image de notre protagoniste initial, dont la vie privée traversait une période particulièrement compliquée (décès de proches, burnout professionnel, problèmes de santé : ce n'était pas la joie). Le seul évènement notable de cette période est une refonte intégrale du site en 2012. Le forum ferme enfin ses portes, le wiki est mis hors ligne car son contenu a mal vieilli et n'est plus pertinent, il ne reste presque plus rien sur NoBleme, qui n'est plus grand chose d'autre que son serveur de chat IRC.
EOT
);
___('nobleme_history_long3',  'EN', <<<EOT
Years passed, some of the older users left, new ones joined, the size of the community overall was falling in size. As 2015 ended, a tough call had to be made. Was it time to put an end to its misery, should we accept that NoBleme served no purpose that couldn't be fullfilled by a simple group chat hosted anywhere else? Surely, if you've paid attention to the story until now, you'd know that the answer was a big resounding no. Maybe this is how one could truly define what NoBleme is: stubborn. A monument to the early days of the Internet which refuses to die.
EOT
);
___('nobleme_history_long3',  'FR', <<<EOT
Les années passent. Des membres historiques partent, des nouveaux arrivent. Globalement, la taille de la communauté diminue. Fin 2015, l'heure de la décision est venue : faut-il sortir NoBleme de sa misère en fermant le site ? Devrions-nous accepter que NoBleme n'a plus aucune utilité qui ne pourrait pas être remplie tout aussi bien par une conversation de groupe via une autre plateforme ? Si vous avez fait attention à l'histoire jusqu'ici, vous savez ce qui suit. Peut-être que c'est ainsi que l'on peut résumer NoBleme : obstiné. Un monument aux vieux jours d'Internet qui refuse de mourir.
EOT
);
___('nobleme_history_long4',  'EN', <<<EOT
The band of silly teenagers who were throwing insults at each other on a random forum now felt like no more than a distant memory. Those of the originals who were still around were now proper adults who would rather forget about this era, and most of the community was not even around to remember it anymore. At least, NoBleme was now living up to its name: it was a calm place with few to no problems. Maybe it had been in the name all along, NoBleme's true purpose was to be a hideout for a few people who enjoyed peaceful conversation.
EOT
);
___('nobleme_history_long4',  'FR', <<<EOT
Le groupe d'adolescents qui s'insultaient sur un forum n'est à cette époque plus qu'un distant souvenir. Les quelques membres originaux qui sont toujours présents sont devenus des adultes qui préfèreraient oublier ce qui s'était passé il y a 10 ans. Les autres n'ont même pas connu cette époque. Au moins, NoBleme se met à bien porter son nom : c'est un lieu calme, où il n'y a pas (trop) de problèmes. Peut-être que c'était dans le nom depuis le début, et que le véritable destin de NoBleme était de devenir un recoin sans problèmes pour sa petite communauté.
EOT
);


// History: The hidden era
___('nobleme_history_hiddent',  'EN', "Act V: The hidden era (2016-2020)");
___('nobleme_history_hiddent',  'FR', "Acte V: Loin de tout (2016-2020)");
___('nobleme_history_hidden1',  'EN', <<<EOT
Emboldened by the belief that being an island of peace on the rowdy seas of the now mainstream Internet was actually a pretty nice idea, NoBleme became comfortable with its size. Being small meant being manageable: hard to find, easy to keep the negative elements out, easy to maintain privacy.
EOT
);
___('nobleme_history_hidden1',  'FR', <<<EOT
Convaincus que ce n'était pas si mal d'être un atoll de calme au sein du tumultueux océan qu'est devenu Internet, la communauté NoBleme était bien dans son coin. Une petite communauté signifie qu'elle est facile à gérer : difficile à trouver, simple d'éliminer les éléments négatifs, aisé de protéger la vie privée de ses membres.
EOT
);
___('nobleme_history_hidden2',  'EN', <<<EOT
Back when NoBleme was created, the Internet was mostly comprised of smaller communities. The bigger websites were search engines, online marketplaces, and had no proper community. Even social networks of this era, mainly MySpace and Friendster, were rather small and not well known to the general public. But things changed, the Internet became centralized around a few giant websites owned by a few companies (Google, Facebook, Microsoft), and smaller communities disappeared. Most people had a Facebook page, followed the news on Reddit, shared pictures on Instagram, used phone applications instead of websites.
EOT
);
___('nobleme_history_hidden2',  'FR', <<<EOT
Du temps de la création de NoBleme, en 2005, Internet était un assemblage hétéroclite de petites communautés. Les plus grands sites étaient des moteurs de recherche, des boutiques en ligne, et n'avaient pas de communauté. Même les réseaux sociaux de l'époque - principalement MySpace et Friendster - n'atteignaient pas le niveau de popularité attendu auprès du grand public et finirent par fermer leurs portes. Entre temps, les choses ont changé. Internet est devenu centralisé autour de quelques sites géants sous le contrôle de quelques entreprises (Google, Facebook, Microsoft), les petites communautés ont majoritairement disparu. En 2016, la majorité des gens utilisaient Facebook, suivaient l'actualité sur Reddit, partageaient leurs photos sur Instagram, utilisaient des applications sur leur téléphone plutôt que des sites Internet.
EOT
);
___('nobleme_history_hidden3',  'EN', <<<EOT
This shift in how the Internet was used brought its share of great things, along with some bad ones. Looking at the big picture, so many issues were solved and content became so easy to find that all in all, the Internet became a better place to use. However, in the process, something unexpected happened: NoBleme found its calling. Sure, it took more than a decade, but here it was, clear as day: NoBleme would become the spirit of the older Internet days. As the world changed around it, as websites grew to enormous sizes, NoBleme remained a tiny haven for its community, preserving the feeling of its earlier days through a veil of nostalgia.
EOT
);
___('nobleme_history_hidden3',  'FR', <<<EOT
Cette transformation de l'usage d'Internet a apporté son lot de positif, mais aussi de négatif. Beaucoup de problèmes ont été résolus par la centralisation des contenus, et Internet est devenu un lieu plus simple à utiliser. Toutefois, ces changements ont eu une conséquence inattendue : NoBleme a trouvé sa raison d'être. Certes, il aura fallu plus de 10 ans pour en arriver là, mais c'était maintenant évident : NoBleme préserverait l'esprit de cet ancien Internet. Tandis que le reste du monde a changé, que certaints sites sont devenus énormes et d'autres sont morts, NoBleme a su rester une zone de confort pour sa communauté.
EOT
);
___('nobleme_history_hidden4',  'EN', <<<EOT
Now having a clear reason to exist, NoBleme stopped slowly losing its userbase, and even started growing in size. An english speaking community appeared on the previously exclusively french website, international meetups were organized so that everyone could meet each other, and a feeling of peace and quiet surrounded the isolated community.
EOT
);
___('nobleme_history_hidden4',  'FR', <<<EOT
Ayant compris son utilité et arrêtant de toujours chercher à changer, NoBleme finit par arrêter de perdre ses membres. Au contraire, durant ces années, NoBleme se remit à lentement grandir. Une communauté anglophone fit également son apparition sur NoBleme pour la première fois depuis sa création, et des rencontres IRL internationales furent organisées pour que tout ce monde puisse se rencontrer en personne. Une sensation de paix et de tranquilité planait sur NoBleme.
EOT
);
___('nobleme_history_hidden5',  'EN', <<<EOT
During these years, the website remained mostly devoid of content. In 2019, a half-assed attempt was made at reviving the former Wiki documenting Internet culture, but its content was so old and dated by then that it felt worthless to spend any time or effort working on it. All in all, those were good years for NoBleme, but it was not its destiny to forever stay hidden in its corner of the internet…
EOT
);
___('nobleme_history_hidden5',  'FR', <<<EOT
Pendant cette époque, le site est resté majoritairement vide de contenu, l'activité se passait principalement sur le chat IRC. En 2019, une tentative de revivre le wiki eut lieu, sous un format différent mais toujours dans le but de documenter la culture Internet. Malheureusement, le contenu du wiki était réellement trop vieux, mal écrit, et l'effort fut abandonné. Malgré cela, ce furent de bonnes années pour la communauté de NoBleme, mais ce n'était pas son destin de rester à jamais loin des regards dans son coin d'Internet…
EOT
);


// History: Let's get political
___('nobleme_history_politicalt',  'EN', "Act VI: Let's get political (2021-?)");
___('nobleme_history_politicalt',  'FR', "Acte VI: Politisation (2021-?)");
___('nobleme_history_political1',  'EN', <<<EOT
Anyone who has lived through the second decade of the 21st century will remember how heavily political the Internet became. Used as a propaganda machine, it gave rise to the {{external|https://en.wikipedia.org/wiki/Alt-right|alt-right}} and other {{external|https://en.wikipedia.org/wiki/Neo-fascism|neofascist}} movements which found great success all over the world.
EOT
);
___('nobleme_history_political1',  'FR', <<<EOT
Toute personne qui a traversé la seconde décennie du 21ème siècle se souviendra d'à quel point Internet est devenu lourdement politisé. Terrain propice pour la propagande et la radicalisation, Internet permit la naissance de {{external|https://fr.wikipedia.org/wiki/Alt-right|l'alt-right}} et d'autres courants politiques similaires utilisant la peur, la haine, et la désinformation comme outils de recrutement de masse.
EOT
);
___('nobleme_history_political2',  'EN', <<<EOT
Back in the early days of NoBleme, the Wiki documenting Internet culture was devoid of all political content. It was a simple encyclopedia, listing and explaining {{link|pages/compendium/index|memes}}, assembling them into a fun little book of hilarious content. But now, Internet culture had changed. Even memes were weaponized with political discourse. And the rise of neofascism came with the resurgence of {{external|https://en.wikipedia.org/wiki/Social_justice|social justice}}, which felt now more than ever like a critical topic to address and support.
EOT
);
___('nobleme_history_political2',  'FR', <<<EOT
Du temps du wiki NoBleme, la culture Internet y était documentée sans aucune notion de politique. C'était une simple encyclopédie, listant et expliquant les {{link|pages/compendium/index|memes}}, formant un grand livre rigolo plein de contenus hilarants. Hélas, entre temps, la culture Internet a changé. Les memes sont devenus des outils du discours politique, sortant d'Internet et débordant sur le monde réel, au point où la séparation entre Internet et le monde réel n'existe presque plus. S'opposant au retour du fascisme dans la sphère publique, des courants de {{external|https://fr.wikipedia.org/wiki/Justice_sociale|justice sociale}} prirent de l'ampleur, en faveur desquels il semblait important de prendre position plutôt que de rester dans la neutralité.
EOT
);
___('nobleme_history_political3',  'EN', <<<EOT
NoBleme, as a small community, had no weight in that battle. We stayed on the side and watched for a decade as the situation grew worse and worse. Eventually, being idle seemed like being complicit with oppression. It was time for change. NoBleme's community leaned heavily on the side of social justice, which meant that rebranding the whole website in that direction was a no brainer, even if it meant breaking the comfort of being hidden from the rest of the Internet.
EOT
);
___('nobleme_history_political3',  'FR', <<<EOT
NoBleme, en tant que petite communauté isolée, ne cherchait pas à avoir la moindre influence dans ce combat. Nous étions de simples spectateurs pendant plus d'une décennie tandis que la situation empirait progressivement. Au bout de trop longtemps à attendre sans agir, la neutralité se met parfois à ressembler à une complicité avec l'oppression. La communauté de NoBleme étant majoritairement du côté de la justice sociale, cette passivité devenait de plus en plus problématique, jusqu'à atteindre le point où il semblait logique de sortir NoBleme de sa zone de confort loin du reste d'Internet et d'accepter de radicalement changer le contenu du site.
EOT
);
___('nobleme_history_political4',  'EN', <<<EOT
In late 2021, as NoBleme was in its 16th year, the website was yet again relaunched. The presence of a {{link|pages/politics/contramanifesto|political manifesto}} made it clear where NoBleme stood, and the old Wiki documenting Internet culture was modernized and rebranded as the {{link|pages/compendium/index|21st century compendium}}. But at its core, NoBleme didn't change: it remains to this day a small community centered website, a living memory of what the Internet used to be.
EOT
);
___('nobleme_history_political4',  'FR', <<<EOT
Fin 2021, lors de la 16ème année de NoBleme, une nouvelle refonte du site eut lieu. La présence d'un {{link|pages/politics/contramanifesto|manifeste politique}} ne laisse plus aucune ambiguité sur les opinions que soutiennent NoBleme, et l'ancien wiki documentant la culture Internet fut retravaillé intégralement et remis à neuf sous le nom du {{link|pages/compendium/index|compendium du 21ème siècle}}. Malgré tout cela, NoBleme n'a pas changé : il s'agit toujours d'un petit site Internet plutôt isolé et centré sur sa communauté, une mémoire vivante de ce qu'Internet était à ses débuts.
EOT
);


// Existential questions
___('nobleme_existential_title',    'EN', "Existential questions");
___('nobleme_existential_title',    'FR', "Questions existentielles");
___('nobleme_existential_whatt',    'EN', "What is NoBleme's purpose?");
___('nobleme_existential_whatt',    'FR', "À quoi sert NoBleme ?");
___('nobleme_existential_what1',    'EN', <<<EOT
As you might have gathered from the website's long history, NoBleme's core purpose will always remain being a nostalgic tribute to the early Internet era: a community of users who interact with each other far from the much bigger social networks that dominate the current Internet landscape. However, NoBleme isn't stuck in the past. It is an ever evolving website which stays in touch with the needs of its community.
EOT
);
___('nobleme_existential_what1',    'FR', <<<EOT
Vous l'aurez compris en lisant la longue histoire de NoBleme, sa vocation est nostalgique. C'est un hommage aux vieux jours d'Internet : une communauté loin de l'influence des réseaux sociaux géants qui dominent le paysage moderne d'Internet. Toutefois, NoBleme n'est pas coincé dans le passé. C'est un site en évolution constante, dont le contenu change selon les besoins de sa communauté.
EOT
);
___('nobleme_existential_what2',    'EN', <<<EOT
On top of that, NoBleme also aims to be a safe haven from the oppressive political discourse that you will find on most social networks. Anyone who joins NoBleme's community will be treated with the respect they deserve, as long as they themselves are willing to treat others in the same way. Basically, it is a place where the only rule is to be nice to each other, where one can find shelter from the exhausting aspects of bigger websites. It's in the name: NoBleme, no problem.
EOT
);
___('nobleme_existential_what2',    'FR', <<<EOT
NoBleme a également pour mission d'être une zone de confort pour sa communauté, la préservant des discours de désinformation et de la propagande politique qui prolifèrent sur les réseaux sociaux. Ainsi, toute personne rejoignant NoBleme sera traitée avec le respect qu'elle mérite, tant qu'elle est à son tour prête à traiter les autres avec le même respect. La seule règle importante est qu'il faut faire preuve de bienveillance envers les autres membres de la communauté. C'est dans le nom : NoBleme, no problème.
EOT
);
___('nobleme_existential_futuret',  'EN', "What is NoBleme's future?");
___('nobleme_existential_futuret',  'FR', "Quel est le futur de NoBleme ?");
___('nobleme_existential_future1',  'EN', <<<EOT
From NoBleme's many years of existence, several lessons have been learned about how to run the website - or rather about what to avoid doing when managing it. Possibly the most important lesson is that things happen organically in small communities. Instead of sticking to a roadmap and making grand plans, it makes more sense to simply maintain what already exists, and only add new content when it feels like it is truly necessary.
EOT
);
___('nobleme_existential_future1',  'FR', <<<EOT
Durant les nombreuses années de l'existence de NoBleme, plusieurs lessons ont été apprises sur la façon dont il faut gérer le site - ou plutôt, sur ce qu'il faut éviter de faire dans la gestion de ce site. La plus importante de ces lessons est qu'il faut laisser les choses se faire naturellement. Plutôt que d'avoir un plan de route rempli de grands projets, il vaut mieux se concentrer sur maintenir l'existant, et n'ajouter de nouveaux contenus que lorsque c'est réellement nécessaire.
EOT
);
___('nobleme_existential_future2',  'EN', <<<EOT
Therefore, NoBleme's future is unpredictable. There is no set roadmap, no focus and no specific plans.
EOT
);
___('nobleme_existential_future2',  'FR', <<<EOT
De ce fait, le futur de NoBleme est imprévisible. Il n'y a rien de fixe au programme, sinon de continuer à exister tant que la communauté est là.
EOT
);
___('nobleme_existential_whyt',     'EN', "Why would I want to be a part of NoBleme?");
___('nobleme_existential_whyt',     'FR', "Pourquoi rejoindre NoBleme ?");
___('nobleme_existential_why1',     'EN', <<<EOT
Well, why would you? If you like what you see on NoBleme, then go ahead and join us!
EOT
);
___('nobleme_existential_why1',     'FR', <<<EOT
Pourquoi pas ? Si ce que vous voyez sur NoBleme vous plait, rejoignez la communauté !
EOT
);
___('nobleme_existential_why2',     'EN', <<<EOT
The community is mostly active on the {{link|pages/social/irc|IRC chat server}} and on {{link|pages/social/discord|Discord}}, so hop in there and have a chat with us. Who knows, maybe we'll like eachother. And maybe we won't. Isn't it worth a try? If you feel shy, you can also just come and watch what happens on IRC, and judge by yourself whether you like it or not.
EOT
);
___('nobleme_existential_why2',     'FR', <<<EOT
Nous intéragissons principalement sur le {{link|pages/social/irc|serveur de chat IRC}} et sur {{link|pages/social/discord|Discord}}, venez y discuter avec nous. Qui sait, peut-être que nous nous apprécierons. Ou peut-être pas. Il n'y a rien à perdre à essayer. Si vous êtes timide, vous pouvez également venir observer ce qui s'y passe, et décider ensuite de si vous vous y sentez à l'aise.
EOT
);
___('nobleme_existential_why3',     'EN', <<<EOT
In any case, NoBleme's community is very welcoming of new people. Whether you are young or old, marginalized or privileged, introverted or extroverted, talkative or shy, we are a very varied bunch of people who will always give you a fair chance at including you in our community.
EOT
);
___('nobleme_existential_why3',     'FR', <<<EOT
Dans tous les cas, la communauté de NoBleme est très accueillante envers les personnes inconnues. Peu importe votre âge, que vous soyez dans une situation marginalisée ou privilégiée, que vous ayez une personnalité introvertie ou extravertie, que vous soyez plutôt bavardage ou timidité, nous sommes un groupe de gens variés qui saura toujours vous donner une chance de vous inclure parmi nous.
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   GAMING NIGHTS                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('nobleme_gaming_title',   'EN', "NoBleme gaming nights");
___('nobleme_gaming_title',   'FR', "Sessions de jeu collectives");
___('nobleme_gaming_body_1',  'EN', <<<EOT
Some members of NoBleme's community enjoy playing social video games together. There are members of the community who regularly play some games together in small numbers, but organizing bigger group events requires a bit of planning. Thus, we organize official "NoBleme gaming nights" every once in a while.
EOT
);
___('nobleme_gaming_body_1',  'FR', <<<EOT
Une partie de la communauté de NoBleme aime bien les jeux vidéos à dimension sociale. Certains membres de notre communauté jouent régulièrement en petits groupes, mais organiser des sessions de jeu à plus grande échelle requiert un effort de planification. C'est pour cela que nous organisons de temps en temps des sessions de jeu collectives officielles.
EOT
);
___('nobleme_gaming_body_2',  'EN', <<<EOT
These events are organized and planned in advance on NoBleme's {{link|pages/social/irc|IRC server}} and {{link|pages/social/discord|Discord server}}. Once a date and time have been set, the events take place on {{link|pages/social/Discord|Discord}}, as it provides us with voice chat communication, an essential part of what makes group gaming fun. Anyone can take part in those events - which, despite what their name implies, do not always happen at night.
EOT
);
___('nobleme_gaming_body_2',  'FR', <<<EOT
Ces sessions de jeu sont organisées et planifiées à l'avance sur les serveurs {{link|pages/social/irc|IRC}} et {{link|pages/social/discord|Discord}} de NoBleme. Une fois qu'une date et une heure ont été décidées, la session aura lieu sur {{link|pages/social/Discord|Discord}}, qui nous permet d'améliorer l'expérience de jeu collective via de la communication vocale. N'importe qui peut participer à ces sessions de jeu, même des personnes externes à NoBleme. Notez toutefois qu'un grand nombre de ces sessions de jeu sont uniquement anglophones : il s'agit d'une occasion de regrouper socialement les deux communautés linguistiques de NoBleme, et nous avons beaucoup plus de francophones parlant anglais que d'anglophones parlant français dans notre communauté.
EOT
);
___('nobleme_gaming_body_3',  'EN', <<<EOT
We are always open to new game ideas: any game with a strong social component, which is free to play (or not too expensive), and which can be played by many people at once might be of interest to us. Feel free to share game ideas with us on {{link|pages/social/irc|IRC}} and {{link|pages/social/discord|Discord}}, if they sound fun then we'll schedule an event to try them out!
EOT
);
___('nobleme_gaming_body_3',  'FR', <<<EOT
Nous sommes en permanence à la recherche de nouvelles idées de jeux. Si vous connaissez un jeu avec une forte composante sociale, qui est gratuit (ou peu cher), et qui ne demande pas de gros investissement de temps avant d'être intéressant, proposez-le sur {{link|pages/social/irc|IRC}} ou {{link|pages/social/discord|Discord}}. S'il intéresse assez de monde, nous organiserons une session de jeu pour l'essayer collectivement !
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 GAMES OF THE PAST                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('nobleme_gaming_history_title',     'EN', "Games of the past");
___('nobleme_gaming_history_title',     'FR', "Jeux du passé");
___('nobleme_gaming_history_subtitle',  'EN', "Gone from NoBleme, but never forgotten");
___('nobleme_gaming_history_subtitle',  'FR', "Disparus, mais jamais oubliés");
___('nobleme_gaming_history_body_1',    'EN', <<<EOT
During NoBleme's {{link|pages/doc/NoBleme|long history}}, there have been a few games designed especially for NoBleme and hosted on the website. Even though these games ended forever once it was considered that they had explored all they had to explore, some of NoBleme's community has fond memories of them, and thus this page serves as a short nostalgia trip documenting the most successful of NoBleme's past games.
EOT
);
___('nobleme_gaming_history_body_1',    'FR', <<<EOT
Lors de la {{link|pages/doc/NoBleme|longue vie}} de NoBleme, des jeux ont été fabriqués spécifiquement pour NoBleme et hébergés sur le site. Même si ces jeux ont été définitivement arrêtés lorsqu'ils avaient fini d'explorer tout ce qu'ils avaient à explorer, une partie de la communauté de NoBleme en garde de bons souvenirs. Par conséquent, cette page sert de voyage nostalgique rapide via les anciens jeux qui ont le mieux fonctionné sur NoBleme.
EOT
);
___('nobleme_gaming_history_body_2',    'EN', <<<EOT
As for everyone's favorite question, "when will [game] come back?", the answer is always the same: these games are best left as a good memory of a past era, rather than bringing them back by force and risking ruining those good memories. It was a hard decision to end them while they were still fun and active, but it was the correct one. There are no plans to bring any of them back, but they might serve as inspiration for future games or even sequels, who knows what the future holds!
EOT
);
___('nobleme_gaming_history_body_2',    'FR', <<<EOT
Pour ce qui est de la question préférée de tout le monde, « quand est-ce que [jeu] revient ? », la réponse est toujours la même : ils sont mieux en tant que bons souvenirs, ce n'est pas la peine de les faire revenir par la force si ce n'est de risquer de ruiner ces bons souvenirs. Mettre fin à ces jeux lorsqu'ils étaient toujours divertissants et populaires était une décision difficile, mais c'était la bonne. Même s'il n'est pas prévu de faire revenir ces jeux, ils pourraient servir d'inspiration pour de futurs jeux, qui sait de quoi le futur est fait !
EOT
);


// NBRPG
___('nobleme_gaming_history_nbrpg_title',   'EN', "NoBlemeRPG");
___('nobleme_gaming_history_nbrpg_title',   'FR', "NoBlemeRPG");
___('nobleme_gaming_history_nbrpg_image',   'EN', "Fan art drawn by good old {{external|https://mastodon.social/@pins|pins}}");
___('nobleme_gaming_history_nbrpg_image',   'FR', "Illustration de fan-art réalisée par ce bon vieux {{external|https://mastodon.social/@pins|pins}}");
___('nobleme_gaming_history_nbrpg_body_1',  'EN', <<<EOT
For a whole decade, some of NoBleme's users regularly met on our {{link|pages/social/irc|IRC chat server}} to spend some evenings playing a text based {{external|https://en.wikipedia.org/wiki/Role-playing_game|roleplaying game}} called the NoBlemeRPG (or NBRPG for short). In this non linear game, a group of players, which changed every session, had to accomplish errands for a mysterious entity called the Oracle, evolving through a game universe in which literally every action imaginable was possible.
EOT
);
___('nobleme_gaming_history_nbrpg_body_1',  'FR', <<<EOT
Durant une dizaine d'années, une partie des la communauté de NoBleme se retrouvait régulièrement le soir sur notre {{link|pages/social/irc|chat IRC}} pour y jouer à un {{external|https://fr.wikipedia.org/wiki/Jeu_de_r%C3%B4le_(activit%C3%A9_ludique)|jeu de rôle}} s'appelant le NoBlemeRPG (ou NBRPG). Dans ce jeu non linéaire, un groupe de personnages changeant à chaque session (selon les personnes présentes) évoluait à travers un univers de jeu où littéralement toutes les actions imaginables étaient possibles, devant rendre divers services à une entité mystérieuse s'appelant l'Oracle.
EOT
);
___('nobleme_gaming_history_nbrpg_body_2',  'EN', <<<EOT
After a final and epic story arc in 2015, which concluded ten years of open storylines, the NoBlemeRPG reached the end of its life cycle. During that time, 32 different players roleplayed as many different characters over more than a hundred game sessions. They made their way through a variety of uniquely designed places and enemies, at first doing errands for the Oracle, then attempting to fight it in a long final battle that lasted hours, only for it to be revealed that the Oracle was none other than {{link|pages/users/1|Bad}} himself, acting as a puppetmaster controlling the players and the game's world all along for his own entertainment.
EOT
);
___('nobleme_gaming_history_nbrpg_body_2',  'FR', <<<EOT
Après un dernier arc narratif en 2015, au cours duquel une décennie d'histoires en cours ont été conclues, le NoBlemeRPG a atteint la fin de son cycle de vie. Durant cette période, 32 personnes différentes ont interprété une cinquantaine de personnages durant plus d'une centaine de sessions de jeu. Leurs aventures au service de l'Oracle se sont conclues par un affrontement contre celui-ci qui, après plusieurs heures de tension, finit par la révélation que l'Oracle n'était autre que {{link|pages/users/1|Bad}} en personne, interprétant depuis le début du jeu un rôle de marionettiste, contrôlant le destin des personnages selon son bon vouloir pour son divertissement personnel.
EOT
);
___('nobleme_gaming_history_nbrpg_body_3',  'EN', <<<EOT
The NBRPG will no doubt be mostly remembered for the wacky rules of its game world, letting players try anything they wanted, whether it made sense or not. The game world itself seemed to be in a struggle with the players, often interpreting their desired actions too literally, or striking them with bad luck and improbable events at the worst possible times. Yet, despite this permanent unpredictability and antagonism of the game itself, the players carved themselves a road through world after world, quest after quest, story after story, and kept asking for more.
EOT
);
___('nobleme_gaming_history_nbrpg_body_3',  'FR', <<<EOT
Nous nous souviendrons du NBRPG avant tout pour les règles farfelues de son univers, permettant aux personnages d'essayer de faire tout et n'importe quoi, même des actions sans aucun sens logique. L'univers du jeu lui-même semblait être en conflit perpétuel avec les personnages, interprétant parfois leurs actions de façon trop littérale, ou leur infligeant de la malchance extrême aux pires moments possibles. Malgré cette imprévisibilité perpétuelle et malgré l'antagonisme du jeu, les personnages trouvaient toujours une façon de se frayer un chemin à travers de nombreux mondes, aventures, histoires, et en redemandaient toujours plus.
EOT
);
___('nobleme_gaming_history_nbrpg_body_4',  'EN', <<<EOT
Running the game was a very demanding ordeal, requiring dozens of hours of software programming, worldbuilding, and general preparations ahead of every gaming session. As much as it was worth it for all the fun memories that it provided us with, working on the NBRPG became less fun and more of a chore after several years, which is why it was eventually decided to end the game forever after a final story arc.
EOT
);
___('nobleme_gaming_history_nbrpg_body_4',  'FR', <<<EOT
Préparer les sessions du NBRPG à l'avance était un travail conséquent, requiérant des dizaines d'heures de programmation informatique, de construction de l'univers du jeu, et de préparations diverses en amont de chaque soirée de jeu. Cette phase de préparation, qui était pendant longtemps un plaisir, devint avec le temps de plus en plus un calvaire, d'où la décision de mettre fin définitivement au jeu après un dernier arc narratif.
EOT
);
___('nobleme_gaming_history_nbrpg_body_5',  'EN', <<<EOT
Much of NoBleme's early french speaking community bonded over the NBRPG, which greatly helped in growing and retaining our early userbase and establishing the NoBleme community over {{link|pages/social/irc|IRC}}. You will find below a few screenshots of the NBRPG's rather complex game master interface (which players could not see). Click on a screenshot to see it in its full size. As the game was in french, so are those screenshots, sorry about that.
EOT
);
___('nobleme_gaming_history_nbrpg_body_5',  'FR', <<<EOT
Le NoBlemeRPG a joué un rôle central dans la construction de la communauté francophone initiale de NoBleme, et reste une source majeure de nostalgie au sein de cette communauté. Vous trouverez ci-dessous quelques captures d'écrans de l'interface de maître du jeu du NoBlemeRPG (que les personnes participant au jeu ne pouvaient pas voir). Cliquez sur une des images pour la voir dans sa taille réelle.
EOT
);


// NRM Online
___('nobleme_gaming_history_nrm_title',   'EN', "NRM Online");
___('nobleme_gaming_history_nrm_title',   'FR', "NRM Online");
___('nobleme_gaming_history_nrm_image',   'EN', "The NRM Online's login page");
___('nobleme_gaming_history_nrm_image',   'FR', "La page de connexion au NRM Online");
___('nobleme_gaming_history_nrm_body_1',  'EN', <<<EOT
Inspired by another slowly dying game called Super Robot Wars Online, which was itself inspired by the {{external|https://en.wikipedia.org/wiki/Super_Robot_Wars|Super Robot Wars}} video game franchise, the NoBleme Robot Mayhem Online - or, for short, NRM - was a massively multiplayer game in which each player was a {{external|https://en.wikipedia.org/wiki/Mecha|mecha}} pilot trying to defeat other players in battles in order to ascend to the top of the global rankings.
EOT
);
___('nobleme_gaming_history_nrm_body_1',  'FR', <<<EOT
Inspiré par un autre jeu mourant nommé Super Robot Wars Online, qui était lui-même inspiré par la franchise de jeux vidéo {{external|https://fr.wikipedia.org/wiki/Super_Robot_Taisen|Super Robot Wars}}, le NoBleme Robot Mayhem Online - ou juste NRM - était un jeu massivement multijoueur dans lequel chaque personne incarnait un pilote de {{external|https://fr.wikipedia.org/wiki/Mecha|mecha}}, affrontant les autres mechas dans le but de grimper en haut d'un classement global.
EOT
);
___('nobleme_gaming_history_nrm_body_2',  'EN', <<<EOT
Focused entirely on planning, strategy, and battle tactics, the NRM was a mostly text based game with few images or glamour to it. Despite its simple appearance, it attracted a decently sized crowd culminating in over a hundred active simultaneous players at its most popular.
EOT
);
___('nobleme_gaming_history_nrm_body_2',  'FR', <<<EOT
Centré sur la planification, la stratégie, et les tactiques de combat, le NRM était majoritairement du texte, contenant peu d'images ou de glamour. Malgré son apparence très minimaliste, le jeu a su attirer une foule relativement grande, atteignant plus de 100 personnes actives simultanément à son plus populaire.
EOT
);
___('nobleme_gaming_history_nrm_body_3',  'EN', <<<EOT
The game was initially launched in early 2006 and ran for 26 seasons of roughly two months each until late 2008, when it was decided to have a 27th and final season which would have no end date, with the game shutting its doors once the last person stopped playing it. Each season of the game was a complete reset, allowing new players to be part of the competition from the start instead of having to catch up to the ones that had started before them.
EOT
);
___('nobleme_gaming_history_nrm_body_3',  'FR', <<<EOT
Initialement rendu public début 2006, le jeu a duré 26 saisons d'environ deux mois chacune jusqu'à fin 2008, où il a été décidé que la 27ème saison serait la dernière, n'aurait pas de date de fin, et que le jeu fermerait ses portes lorsque plus personne n'y jouerait activement. Chaque saison du jeu était une remise à zéro, permettant aux personnes nouvelles venues de participer à la compétition dès le début au lieu de devoir rattraper les autres qui y jouaient depuis plus longtemps.
EOT
);
___('nobleme_gaming_history_nrm_body_4',  'EN', <<<EOT
The first twenty seasons each brought improvements, balance changes, new mechas, and new features to the game, until real life issues caught up with {{link|pages/users/1|Bad}} and led the game to the same fate as the one that inspired it: a slow death as the bored playerbase slowly left the game, disappointed by the lack of new features. In retrospect, the timing was right for the NRM to be over: it had explored a lot of great ideas, to the point where it was getting harder and harder to come up with new ones without making the game overly complicated.
EOT
);
___('nobleme_gaming_history_nrm_body_4',  'FR', <<<EOT
Les vingt premières saisons contenaient chacune leur lot d'améliorations, d'équilibrage du jeu, de nouveaux mechas, et de nouveaux contenus, jusqu'à ce que des problèmes personnels forcent {{link|pages/users/1|Bad}} à arrêter de développer activement le jeu, faisant partir les personnes déçues par l'absence de nouveaux contenus, et condamnant le jeu à la même mort lente que son précedesseur. Rétrospectivement, il s'agissait du bon moment pour mettre fin au jeu : beaucoup de bonnes idées avaient été explorées, au point où il devenait difficile d'essayer de nouvelles choses sans rendre le jeu excessivement complexe.
EOT
);
___('nobleme_gaming_history_nrm_body_5',  'EN', <<<EOT
With the NRM came the first wave of NoBleme's french speaking community, most of which left after the game's demise, but some of which are still here to this day. You will find below a few screenshots of the NRM, which will probably look confusing and mysterious - even more so since they are in french. Click on a screenshot to see it in its full size.
EOT
);
___('nobleme_gaming_history_nrm_body_5',  'FR', <<<EOT
Le NRM permit d'attirer la première vague de la communauté francophone de NoBleme. Même si la plupart de ces personnes ont quitté la communauté suite à la fin du jeu, certaines sont toujours présentes sur NoBleme aujourd'hui. Vous trouverez ci-dessous quelques captures d'écran du NRM, qui auront probablement l'air très mystérieuses si vous n'avez jamais eu l'opportunité d'y jouer. Cliquez sur une des images pour la voir dans sa taille réelle.
EOT
);
___('nobleme_gaming_history_nrm_body_6',  'EN', <<<EOT
As a final and forever lasting tribute to the NRM Online and the players which took part in its numerous seasons, below is a screenshot of the game's hall of fame, which listed the winners and runner ups of most past seasons (a few have been lost in the sands of time).
EOT
);
___('nobleme_gaming_history_nrm_body_6',  'FR', <<<EOT
Afin de rendre hommage éternellement aux bons souvenirs du NRM et des personnes qui ont participé à ses nombreuses saisons, voici une capture d'écran du panthéon du jeu, listant les mechas qui ont gagné la plupart des saisons du jeu (le reste de l'historique a été perdu dans les sables du temps).
EOT
);