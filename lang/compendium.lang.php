<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       INDEX                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('compendium_index_title',   'EN', "Compendium");
___('compendium_index_title',   'FR', "Compendium");
___('compendium_index_subitle', 'EN', "Documenting 21st century culture");
___('compendium_index_subitle', 'FR', "Documentation du 21ème siècle");
___('compendium_index_intro_1', 'EN', <<<EOT
The turn of the century came with a globalization of communication through the spread of the Internet, exposing many people to overwhelming amount of contents - some funny, some good, some sad, some bad.
EOT
);
___('compendium_index_intro_1', 'FR', <<<EOT
Le 21ème siècle et l'avènement d'Internet ont exposé beaucoup de personnes à des quantités écrasantes de contenus, certains drôles ou divertissants, d'autres choquants ou dangereux.
EOT
);
___('compendium_index_intro_2', 'EN', <<<EOT
In this new hyperconnected society, it has become hard to keep up to date with everything. This compendium aims to be a documentation for elements of 21st century culture, making them as accessible as possible to those who are "out of the loop" on specific topics.
EOT
);
___('compendium_index_intro_2', 'FR', <<<EOT
Dans cette nouvelle société hyperconnectée, il est devenu impossible de suivre tous ces nouveaux contenus. Le but de ce compendium est de documenter et démystifier des éléments de la culture du 21ème siècle, en essayant de les rendre aussi accessibles que possible.
EOT
);
___('compendium_index_intro_3', 'EN', <<<EOT
You might be wondering why this compendium has been created, whether it has a deliberate political bias, who runs it, which guidelines it follows, all those questions and more are answered in our {{link|pages/compendium/mission_statement|mission statement}}.
EOT
);
___('compendium_index_intro_3', 'FR', <<<EOT
Si vous vous demandez dans quel but ce compendium a été crée, d'où viennent ses contenus, s'il a un biais politique délibéré, des réponses à ces questions et à d'autres se trouvent dans notre {{link|pages/compendium/mission_statement|foire aux questions}}.
EOT
);
___('compendium_index_intro_4', 'EN', <<<EOT
Subsections of this encyclopedia are dedicated to documenting {{link|todo_link|memes}}, a {{link|todo_link|slang dictionary}}, a {{link|todo_link|sociocultural guide}}, and more: all of the compendium's contents can be found on the {{link|todo_link|list of all pages}}. Though maybe you would rather get started in your browsing by reading a {{link|todo_link|randomly chosen page}}.
EOT
);
___('compendium_index_intro_4', 'FR', <<<EOT
Des sections de cette encyclopédie sont dédiées à la documentation des {{link|todo_link|memes}}, de {{link|todo_link|l'argot}}, et des concepts {{link|todo_link|socioculturels}} du 21ème siècle. Vous retrouverez tout ceci et plus encore sur la {{link|todo_link|liste des pages}}, ou peut-être préféreriez-vous commencer votre exploration en lisant une {{link|todo_link|page au hasard}}.
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 MISSION STATEMENT                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('compendium_faq_subtitle',  'EN', "Mission statement: methods and goals");
___('compendium_faq_subtitle',  'FR', "Foire aux questions (courtes et simples)");
___('compendium_faq_intro',     'EN', <<<EOT
Using a Q&A format, this page will attempt to answer some of the questions you might have about NoBleme's {{link|pages/compendium/index|21st century compendium}}'s goals and methods. Instead of needlessly going deep into detail, it will be a series of simple questions with quick answers. Any further questions you have can be answered by interacting with NoBleme's community on our {{link|pages/social/irc|IRC chat}} or {{link|pages/social/discord|Discord server}}.
EOT
);
___('compendium_faq_intro',     'FR', <<<EOT
En utilisant un format questions/réponses, cette page tentera de répondre à certaines des questions que vous pouvez avoir au sujet du {{link|pages/compendium/index|compendium du 21ème siècle}}. Plutôt que de rentrer dans les détails, il s'agit de questions simples et de réponses concises. S'il vous reste d'autres questions auxquelles cette page ne répond pas, vous pouvez venir les poser à la communauté de NoBleme sur notre {{link|pages/social/irc|chat IRC}} ou notre {{link|pages/social/discord|serveur Discord}}.
EOT
);
___('compendium_faq_contents',  'EN', "Table of contents:");
___('compendium_faq_contents',  'FR', "Sommaire des questions :");


// Questions
___('compendium_faq_question_1',  'EN', "What will I find in this compendium?");
___('compendium_faq_question_1',  'FR', "Que trouverais-je dans ce compendium ?");
___('compendium_faq_question_2',  'EN', "What are the compendium's goals?");
___('compendium_faq_question_2',  'FR', "Quels sont les objectifs de ce compendium ?");
___('compendium_faq_question_3',  'EN', "Is there a language / culture bias?");
___('compendium_faq_question_3',  'FR', "Y a-t-il un biais culturel / linguistique ?");
___('compendium_faq_question_4',  'EN', "Is there a deliberate political leaning?");
___('compendium_faq_question_4',  'FR', "Y a-t-il un biais politique délibéré ?");
___('compendium_faq_question_5',  'EN', "Is there a long term vision?");
___('compendium_faq_question_5',  'FR', "Y a-t-il une vision à long terme ?");
___('compendium_faq_question_6',  'EN', "Who writes the articles / pages?");
___('compendium_faq_question_6',  'FR', "Qui écrit les articles / pages ?");
___('compendium_faq_question_7',  'EN', "What are the guidelines for writing content?");
___('compendium_faq_question_7',  'FR', "Quelles consignes sont suivies lors de l'écriture de contenu ?");
___('compendium_faq_question_8',  'EN', "How can you ensure content is properly sourced?");
___('compendium_faq_question_8',  'FR', "Comment s'assurer que tout soit bien sourcé ?");
___('compendium_faq_question_9',  'EN', "How is controversial content handled?");
___('compendium_faq_question_9',  'FR', "Comment le contenu controversé est-il géré ?");
___('compendium_faq_question_10', 'EN', "What makes it different from other similar websites?");
___('compendium_faq_question_10', 'FR', "Qu'est-ce qui différencie ce compendium des autres sites similaires ?");
___('compendium_faq_question_11', 'EN', "Why is the compendium part of NoBleme?");
___('compendium_faq_question_11', 'FR', "Pourquoi ce compendium fait-il partie de NoBleme ?");
___('compendium_faq_question_12', 'EN', "What is NoBleme anyway?");
___('compendium_faq_question_12', 'FR', "Qu'est-ce que NoBleme ?");
___('compendium_faq_question_13', 'EN', "How can I report incorrect content / make a copyright claim?");
___('compendium_faq_question_13', 'FR', "Comment puis-je signaler du contenu incorrect / copyrighté ?");
___('compendium_faq_question_14', 'EN', "Can I help in any way?");
___('compendium_faq_question_14', 'FR', "Puis-je aider d'une façon quelconque ?");
___('compendium_faq_question_15', 'EN', "Where / how can I stay up to date with new content?");
___('compendium_faq_question_15', 'FR', "Où / comment se tenir au courant des futurs contenus ?");


// Answers
___('compendium_faq_answer_1_1',  'EN', <<<EOT
A documentation of elements of 21st century culture.
EOT
);
___('compendium_faq_answer_1_1',  'FR', <<<EOT
Une documentation d'éléments de la culture du 21ème siècle.
EOT
);
___('compendium_faq_answer_1_2',  'EN', <<<EOT
The hyperconnected era ushered in by the advent of the Internet altered both mainstream and underground culture in many ways, which this compendium tries to document as much as possible. The {{link|todo_link|list of all pages}} lets you see all the types and categories of contents which are covered by the compendium. Special attention is given to three types of contents in particular:
EOT
);
___('compendium_faq_answer_1_2',  'FR', <<<EOT
L'avènement d'Internet et d'une nouvelle ère hyperconnectée a modifié la culture populaire de nombreuses façons, que ce compendium essaye de documenter autant que possible. La {{link|todo_link|liste des pages}} vous permet de voir tous les types et catégories de contenus couvertes dans ce compendium. Une attention particulière est donnée aux trois types de contenus suivants:
EOT
);
___('compendium_faq_answer_1_3',  'EN', <<<EOT
{{link|todo_link|Memes}} have become an unavoidable source of entertainment and amusement, or sometimes controversy and confusion. Memes are documented with a focus on fun, featuring image and video galleries showcasing how entertaining and creative people can be.
EOT
);
___('compendium_faq_answer_1_3',  'FR', <<<EOT
{{link|todo_link|Les memes}} sont devenus une source omniprésente de divertissement et d'amusement, ou parfois de controverse et de confusion. Les memes sont documentés en mettant l'accent sur leur côté divertissant, via des galeries d'images et de vidéos montrant le potentiel de créativité des gens.
EOT
);
___('compendium_faq_answer_1_4',  'EN', <<<EOT
{{link|todo_link|Slang}} born or popularized in the 21st century gets featured in short pages explaining their meaning, and sometimes also the hidden meanings which can apear when used in funny or nefarious ways.
EOT
);
___('compendium_faq_answer_1_4',  'FR', <<<EOT
{{link|todo_link|L'argot}} propre à la culture du 21ème siècle est documenté dans des pages courtes explicant son sens, et parfois les sens cachés qui peuvent exister lorsque les mots sont utilisés dans un but comique ou néfaste.
EOT
);
___('compendium_faq_answer_1_5',  'EN', <<<EOT
{{link|todo_link|Sociocultural}} concepts which people were not aware of before the turn of the 21st century have become mainstream notions as many groups became able to express themselves on platforms that could reach a global audience. The 21st century compendium aims to demystify these sociocultural concepts by explaining them in simple terms, both the good and the bad, whether they belong to the oppressed or the oppressive, in order to explain their history, their meanings, their reach, and their real world consequences.
EOT
);
___('compendium_faq_answer_1_5',  'FR', <<<EOT
{{link|todo_link|Des concepts socioculturels}} sont également documentés. Pas tous propres au 21ème siècle, ils se sont popularisés grâce à la libération de la parole au tourant du siècle, Internet permettant à des groupes marginalisés de se faire entendre à une échelle globale. Ce compendium cherche à démystifier ces concepts socioculturels en les expliquant le plus simplement possible, qu'ils soient bons ou mauvais, oppressés ou oppressants, afin d'expliquer leur histoire, leur sens, leur portée, et leurs impacts dans le monde.
EOT
);
___('compendium_faq_answer_1_6',  'EN', <<<EOT
You might believe that these elements do not belong together, but they are fully interconnected. Most memes include slang and use sociocultural concepts as their theme, most sociocultural movements express themselves through slang and memes, and other types of contents covered in this compendium also contain callbacks to the three main themes mentioned above.
EOT
);

___('compendium_faq_answer_2_1',  'EN', <<<EOT
The 21st century compendium is trying to achieve three different goals.
EOT
);
___('compendium_faq_answer_2_1',  'FR', <<<EOT
Le compendium cherche à atteindre trois objectifs différents.
EOT
);
___('compendium_faq_answer_2_2',  'EN', <<<EOT
First and foremost, it strives to be an encyclopedia of its era. This is nothing unique, other websites are already doing the same thing, some of them much better, which is why there is a focus on quality over quantity. Entries are written at a slow pace, but are exhaustive, properly sourced, and follow strict style and content guidelines.
EOT
);
___('compendium_faq_answer_2_2',  'FR', <<<EOT
Avant tout, son but est d'être une encyclopédie de son époque. Ce n'est rien d'unique, il existe déjà d'autres sites cherchant à accomplir le même but. Nous ne cherchons pas à rivaliser avec ces autres sites, et nous concentrons plutôt sur la qualité que sur la quantité : les pages sont écrites à un rythme lent, mais sont complètes, correctement sourcées, et respectent une ligne directrice unique et clairement définie.
EOT
);
___('compendium_faq_answer_2_3',  'EN', <<<EOT
As a side effect of documenting its era, a secondary goal of this compendium is to help "out of the loop" people understand memes, slang, concepts, etc. which they are not at all or only partly aware of. In order to fulfill this goal, the language is kept simple, pages are short, the reader's limited attention span is always kept in mind.
EOT
);
___('compendium_faq_answer_2_3',  'FR', <<<EOT
En tant que documentation de son époque, un objectif secondaire de ce compendium est d'aider les personnes « hors de la boucle » à comprendre les memes, l'argot, les concepts socioculturels, etc. qui sont nombreux et souvent obscurs à comprendre. Dans ce but, le vocabulaire utilisé reste simple, les pages sont courtes, et l'attention limitée des personnes qui liront les pages est prise en compte lors de leur rédaction.
EOT
);
___('compendium_faq_answer_2_4',  'EN', <<<EOT
Lastly, as {{link|todo_link|sociocultural}} topics have to be explained when documenting 21st century culture, an effort is also done to try and explain those concepts in the clearest way possible. Having to explain basic concepts to people over and over can be exhausting, we try our best to demystify them in a simple to read and understand format which can be linked to people in order to hopefully relieve some of that burden.
EOT
);
___('compendium_faq_answer_2_4',  'FR', <<<EOT
Troisièmement, vu que des concepts {{link|todo_link|socioculturels}} doivent être documentés en tant qu'éléments de la culture du 21ème siècle, un effort est fait pour les expliquer de la façon la plus claire possible. Nous savons à quel point devoir expliquer encore et encore les mêmes concepts de base à d'autres personnes peut être épuisant, et espérons que certaines pages de ce compendium pourront vous libérer de ces efforts et vous servir de liens que vous pourrez partager avec les personnes non sensibilisées à ces sujets.
EOT
);

___('compendium_faq_answer_3_1',  'EN', <<<EOT
Yes. Everything in this compendium has been written as perceived through the prism of the english and french speaking world. This means that there is a strong european and american bias to the documented content, and that many non-english and non-french elements of 21st century culture will be missing.
EOT
);
___('compendium_faq_answer_3_1',  'FR', <<<EOT
Oui. Les contenus sont rédigés tels que perçus à travers le prisme du monde francophone et anglophone. Cela signifie qu'il y a un fort biais européen et américain au contenu documenté, et que de nombreux éléments non-francophones et non-anglophones de la culture du 21ème siècle seront manquants.
EOT
);
___('compendium_faq_answer_3_2',  'EN', <<<EOT
Attempts to fix this bias have been made, but led to the realization that it is simply not our place to document other people's cultures without experiencing them firsthand. As this compendium is the work of a single person, it will only cover the experiences relevant to the spheres of influence affecting said person.
EOT
);
___('compendium_faq_answer_3_2',  'FR', <<<EOT
Tenter de corriger ce biais ne ferait qu'amener un nouveau problème : ce n'est tout simplement pas notre rôle de documenter les cultures des autres personnes sans baigner dedans personnellement. Comme ce compendium est l'œuvre d'une seule personne, il ne couvrira que les sphères d'influence affectant la personne en question.
EOT
);
___('compendium_faq_answer_3_3',  'EN', <<<EOT
If you want to alleviate this issue by offering documentation on memes, slangs, sociocultural concepts of your language and/or culture, you can do so using our {{link|todo_link|contact form}}. We would be delighted with the help. Contributors are credited on the pages which they have contributed to (unless they asked to not be credited).
EOT
);
___('compendium_faq_answer_3_3',  'FR', <<<EOT
Toutefois, si vous voulez nous aider à remédier à ce problème en proposant de la documentation sur des memes, de l'argot, des concepts socioculturels propres à votre langue et/ou culture, vous pouvez le faire via notre {{link|todo_link|formulaire de contact}}. Nous apprécierons assurément votre aide. Les personnes offrant des contributions sont créditées sur les pages concernées (sauf si elles demandent à rester anonymes).
EOT
);

___('compendium_faq_answer_4_1',  'EN', <<<EOT
Yes. It might seem odd for encyclopedic content to take a political or social stance, but it is the very nature of the content being documented which leaves no choice.
EOT
);
___('compendium_faq_answer_4_1',  'FR', <<<EOT
Oui. Cela peut vous sembler étrange que du contenu encyclopédique soit politisé, mais la nature du contenu documenté ne laisse aucun choix.
EOT
);
___('compendium_faq_answer_4_2',  'EN', <<<EOT
You might think that not everything has to be political, but some people do not have much of a say in this: it is not minorities who made being a woman, black, queer, non-binary, jewish, etc. into a political topic, it is those who abuse their political power to actively discriminate and/or call for discrimination against them.
EOT
);
___('compendium_faq_answer_4_2',  'FR', <<<EOT
Peut-être que le fait que tout ce que vous voyez semble être politisé vous fatigue, mais ce n'est pas du fait des personnes concernées : ce ne sont pas les minorités qui ont décidé qu'être une femme, qu'avoir la peau noire, que d'être non-binaire, que d'avoir une mère juive, etc. sont des sujets politiques. Ce sont les personnes qui discriminent et/ou appellent à la discrimination envers ces groupes qui sont la cause de cet état de fait.
EOT
);
___('compendium_faq_answer_4_3',  'EN', <<<EOT
In topics related to social justice, staying neutral means siding with the statu quo: accepting that the current state of society is fine, including injustices. It is our encyclopedic duty to document them properly, which means actively listening to minorities, and using this compendium as a platform to relay their words.
EOT
);
___('compendium_faq_answer_4_3',  'FR', <<<EOT
Rester neutre politiquement tout en documentant des sujets socioculturels signifierait une acceptation du statu quo : accepter l'état actuel de la société comme une fatalité, incluant ses injustices. C'est notre devoir encyclopédique de documenter ces sujets correctement, ce qui implique d'écouter activement les minorités, et d'utiliser ce compendium comme une plateforme pour transmettre leurs paroles.
EOT
);
___('compendium_faq_answer_4_4',  'EN', <<<EOT
Some people fear that minorities exploit the goodwill of social justice movements in order to further an agenda. This fearmongering is an illusion which we are trying to dispel, by properly documenting not only the causes of social justice movements, but also their actual goals and demands.
EOT
);
___('compendium_faq_answer_4_4',  'FR', <<<EOT
Certaines personnes craignent que des minorités exploitent la bienveillance des mouvements de justice sociale afin d'accomplir des buts cachés néfastes. Cet alarmisme est une illusion que nous essayons de dissiper, en documentant non seulement les causes des mouvements de justice sociale, mais aussi leurs véritables objectifs et revendications.
EOT
);
___('compendium_faq_answer_4_5',  'EN', <<<EOT
If you are in full disagreement with political or social statements made in this compendium, it might be best for you to simply stop reading it. The Internet is a vast landscape with many other websites which might be more appropriate for your needs, and we have no desire to argue about basic empathy with contrarians.
EOT
);
___('compendium_faq_answer_4_5',  'FR', <<<EOT
Si vous êtes en désaccord avec la majorité des prises de position politiques de ce compendium, peut-être vaudrait-il mieux simplement arrêter de le lire. L'Internet est un monde vaste rempli de nombreux autres contenus qui pourraient être plus appropriés pour vos besoins, et nous n'avons aucun désir de débattre d'un sujet aussi simple que l'existence de l'empathie avec des personnes fermées d'esprit.
EOT
);

___('compendium_faq_answer_5_1',  'EN', <<<EOT
No. There are no fixed goals, short or long term, other than writing more content and improving the website.
EOT
);
___('compendium_faq_answer_5_1',  'FR', <<<EOT
Non. Aucun objectif n'a été fixé, à court ou long terme, à part de continuer à écrire plus de contenus.
EOT
);
___('compendium_faq_answer_5_2',  'EN', <<<EOT
Growth and exposure are appreciated, but not needed. Even if this compendium remained lost in its corner of the Internet and was seen by one new person every month, it would be enough to justify its existence. It is a work of passion, not an attempt at wealth or fame.
EOT
);
___('compendium_faq_answer_5_2',  'FR', <<<EOT
La croissance et la popularité sont appréciés, mais pas nécessaires. Même si ce compendium restait perdu dans son coin d'Internet et n'était vu que par une seule nouvelle personne chaque mois, ce serait suffisant pour justifier son existence. C'est une œuvre de passion, pas une tentative d'enrichissement ou de célébrité.
EOT
);

___('compendium_faq_answer_6_1',  'EN', <<<EOT
This compendium is the work of a single person, {{link|todo_link|Eric Bisceglia}}.
EOT
);
___('compendium_faq_answer_6_1',  'FR', <<<EOT
Ce compendium est l'œuvre d'une seule personne, {{link|todo_link|Eric Bisceglia}}.
EOT
);
___('compendium_faq_answer_6_2',  'EN', <<<EOT
Having only one main writer and editor is a deliberate choice in order to maintain quality over quantity. As a consequence, this compendium will never have the same amount of content that other bigger collaborative encyclopedias might have, but it ensures that editorial control is maintained over all of the compendium's contents. It also relieves the main editor from the pressure of having to review other people's contributions when time off is needed for personal reasons, thus mitigating burnout.
EOT
);
___('compendium_faq_answer_6_2',  'FR', <<<EOT
N'avoir qu'une seule personne en charge de la rédaction des contenus est un choix délibéré afin de s'assurer que la qualité prime sur la quantité. En conséquence, il n'y aura jamais autant de contenus dans ce compendium que dans des encyclopédies collaboratives couvrant les mêmes sujets, mais cela garantit que le contrôle éditorial est maintenu sur tous les contenus. Cela permet également d'avoir une très importante tranquillité mentale : la pression éditoriale de devoir examiner en continu les contenus proposés par d'autres personnes n'est pas présente, ce qui permet de faire des pauses à tout moment pour des raisons personnelles sans froisser personne, et ainsi d'éviter le surmenage sur le long terme.
EOT
);
___('compendium_faq_answer_6_3',  'EN', <<<EOT
However, third party contributors are more than welcome. Whether you would like to suggest new content or point out inaccuracies in existing content, you can do so using our {{link|todo_link|contact form}}. Contributors are credited on the pages which they have contributed to (unless they asked to not be credited).
EOT
);
___('compendium_faq_answer_6_3',  'FR', <<<EOT
Toutefois, les contributions tierces sont encouragées. Que vous vouliez proposer de nouveaux contenus ou signaler des erreurs dans du contenu existant, vous pouvez le faire via notre {{link|todo_link|formulaire de contact}}. Les personnes offrant des contributions sont créditées sur les pages concernées (sauf si elles demandent à rester anonymes).
EOT
);

___('compendium_faq_answer_7_1',  'EN', <<<EOT
The first and most important guideline is that all content must be short form rather than essays. The goal is to keep the reader's attention from start to finish, anything too lengthy or rambly might lose them halfway.
EOT
);
___('compendium_faq_answer_7_1',  'FR', <<<EOT
La première et plus importante des consignes est que tout le contenu doit être simple et concis plutôt que des dissertations. Le but est de conserver l'attention des personnes qui lisent les pages du début à la fin, un contenu verbeux ou complexe pourrait les perdre en route.
EOT
);
___('compendium_faq_answer_7_2',  'EN', <<<EOT
The second guideline is that everything must be written from the point of view of a reader who is fully "out of the loop", even if it means over-explaining things. The first guideline takes precedence however, explanations must stay short and might need to be skipped at times.
EOT
);
___('compendium_faq_answer_7_2',  'FR', <<<EOT
La seconde consigne est que tout doit être écrit du point de vue de personnes « hors de la boucle », même si cela implique de sur-expliquer certaines choses. La première consigne est toutefois prioritaire, les explications doivent toujours rester concises et peuvent être ignorées si elles rendent le contenu trop indigeste.
EOT
);
___('compendium_faq_answer_7_3',  'EN', <<<EOT
The third guideline is that each content should be documented in a fitting way: image galleries should be the focal point when documenting memes, controversial topics should be presented in a well sourced encyclopedic way, and a Q&A format should be used for complicated topics.
EOT
);
___('compendium_faq_answer_7_3',  'FR', <<<EOT
La troisième consigne est que tous les contenus doivent être documentés d'une façon appropriée : les memes via des galeries d'images, les sujets controversés de façon sourcée et encyclopédique, les sujets compliqués dans un format questions-réponses.
EOT
);
___('compendium_faq_answer_7_4',  'EN', <<<EOT
The fourth guideline is to write entries in a gender neutral way. The default pronoun in use should be `they`, unless referring to specific people.
EOT
);
___('compendium_faq_answer_7_4',  'FR', <<<EOT
La quatrième consigne est d'écrire les textes d'une façon non genrée. Les formes neutres sont préférées plutôt que les points médians ou les terminaisons mixtes (par exemple « les personnes lisant cette page » plutôt que « les lecteurs » ou « les lecteurices »). Cette documentation (et le reste de ce site) sert accessoirement la preuve qu'il est possible d'écrire du français non genré sans grand effort et sans que la lecture en soit pénible.
EOT
);

___('compendium_faq_answer_8_1',  'EN', <<<EOT
The short and honest answer is that you can't always guarantee it.
EOT
);
___('compendium_faq_answer_8_1',  'FR', <<<EOT
La réponse honnête est que c'est parfois impossible.
EOT
);
___('compendium_faq_answer_8_2',  'EN', <<<EOT
Some content can be traced back to its authentic origins, or can be backed up by academic sources. In these cases, it is easy to document said content in a properly sourced way. Sadly, it is impossible to guarantee that the original content has not been appropriated from someone else's work, or that the acamedic sources do not have a bias.
EOT
);
___('compendium_faq_answer_8_2',  'FR', <<<EOT
Certains contenus peuvent être remontés jusqu'à leurs origines authentiques, ou peuvent être soutenus par des études académiques. Malheureusement, même dans ces cas, il est impossible de garantir que le prétendu contenu d'origine n'est pas le produit d'une appropriation, ou que les études académiques ne sont pas biasées.
EOT
);
___('compendium_faq_answer_8_3',  'EN', <<<EOT
As our sources might be unreliable, the documentation will evolve as needed to correct inaccuracies. Please report any incorrect content using our {{link|todo_link|contact form}}.
EOT
);
___('compendium_faq_answer_8_3',  'FR', <<<EOT
Même si un gros effort est fait pour tout sourcer, les contenus évolueront autant que nécessaire pour corriger les erreurs qui peuvent s'y trouver. Signalez-nous les contenus inexacts ou les sources questionnables via notre {{link|todo_link|formulaire de contact}}.
EOT
);

___('compendium_faq_answer_9_1',  'EN', <<<EOT
There is more than one type of controversial content, each has its own answer to this question.
EOT
);
___('compendium_faq_answer_9_1',  'FR', <<<EOT
Il existe plusieurs types de contenus controversés. Chacun est géré d'une façon différente.
EOT
);
___('compendium_faq_answer_9_2',  'EN', <<<EOT
Extreme vulgarity, nudity, gross images, or anything else which could be considered not safe for work will be blurred, requiring an action (clicking the content) before it is revealed. You can permanently disable this feature by {{link|pages/account/register|registering an account}} on NoBleme and changing your {{link|pages/account/settings_nsfw|adult content settings}}.
EOT
);
___('compendium_faq_answer_9_2',  'FR', <<<EOT
La vulgarité extrême, la nudité, les images dégueulasses, ou tout ce qui pourrait être considéré problématique sur un lieu de travail est flouté, demandant une action délibérée (cliquer sur le contenu) pour retirer le floutage. Vous pouvez désactiver ce floutage sur toutes les pages en vous {{link|pages/account/register|créant un compte sur NoBleme}} puis en modifiant vos {{link|pages/account/settings_nsfw|options de vulgarité}}.
EOT
);
___('compendium_faq_answer_9_3',  'EN', <<<EOT
Politically incorrect and offensive content will be documented in this compendium, as it strives to be an exhaustive documentation of 21st century culture, including its bad sides. However, these contents will come with a warning at the top of the page, and we will ensure that they are portrayed in a negative light by explaining their real life consequences.
EOT
);
___('compendium_faq_answer_9_3',  'FR', <<<EOT
Des contenus politiquement incorrects ou offensants sont documentés dans ce compendium, vu qu'une documentation de la culture du 21ème siècle ne peut pas en ignorer les aspects problématiques. Toutefois, ces contenus viendront avec un avertissement en haut de la page, et seront représentés d'une façon négative.
EOT
);
___('compendium_faq_answer_9_4',  'EN', <<<EOT
Sociocultural content related to minorities will only be written with the help of those concerned. For example, a white european documenting an issue related to black americans might get everything right, but they might also be missing some critical elements which can only be understood by those who have to live with the weight of those issues on a daily basis. This means that some sociocultural topics will not be covered at all rather than risking documenting them in a non exhaustive or simply wrong way.
EOT
);
___('compendium_faq_answer_9_4',  'FR', <<<EOT
Les contenus socioculturels touchant à des minorités ne seront écrits qu'avec l'assistance de personnes concernées. Un blanc européen cherchant à documenter un problème spécifique aux personnes noires des USA pourrait le documenter de façon correcte, mais il serait également possible que des éléments critiques lui échappent, dont le poids ne se ressent que lorsqu'ils sont subis au quotidien. Cela signifie que certains sujets ne seront simplement pas couverts plutôt que de les documenter d'une façon potentiellement incorrecte.
EOT
);

___('compendium_faq_answer_10_1', 'EN', <<<EOT
There are many other websites already documenting subsets of 21st century culture, especially memes. It is their very existence which prompted the creation of the 21st century compendium: separating memes from their sociocultural context can turn them into propaganda tools. As unlikely as this seems, {{external|https://en.wikipedia.org/wiki/Memetic_warfare|memetic warfare}} is a legitimate concern, and led amongst other things to the {{external|https://en.wikipedia.org/wiki/Social_media_in_the_2016_United_States_presidential_election#Donald_Trump_campaign|2016 election}} of white supremacist president Donald Trump in the USA.
EOT
);
___('compendium_faq_answer_10_1', 'FR', <<<EOT
De nombreux autres sites documentent des aspects de la culture du 21ème siècle, particulièrement les memes. C'est l'existence même de ces sites qui a mené à la création de ce compendium : séparer les memes de leur contexte socioculturel peut les transformer en outils de propagande. Aussi improbable que cela peut vous sembler, la {{external|https://en.wikipedia.org/wiki/Memetic_warfare|guerre mémétique}} est une préoccupation légitime, qui a déjà {{external|https://en.wikipedia.org/wiki/Social_media_in_the_2016_United_States_presidential_election#Donald_Trump_campaign|joué un rôle central en 2016}} dans l'élection du suprémaciste blanc Donald Trump comme président des USA.
EOT
);
___('compendium_faq_answer_10_2', 'EN', <<<EOT
Once the decision to create this compendium had been made, the question of "what will set this documentation apart from the others" had to be asked, and the answer is the following :
EOT
);
___('compendium_faq_answer_10_2', 'FR', <<<EOT
Les éléments qui séparent ce compendium des autres sites silimaires sont les suivants :
EOT
);
___('compendium_faq_answer_10_3', 'EN', "Documenting all aspects of 21st century culture at once, not just memes or politics.");
___('compendium_faq_answer_10_3', 'FR', "Documenter tous les aspects de la culture du 21ème siècle d'un coup, pas uniquement les memes.");
___('compendium_faq_answer_10_4', 'EN', "A focus on quality over quantity: less content, but better content.");
___('compendium_faq_answer_10_4', 'FR', "Une focalisation sur la qualité plutôt que la quantité : moins de contenus, mais de meilleurs contenus.");
___('compendium_faq_answer_10_5', 'EN', "Short and simple pages with simple vocabulary, accessible to all.");
___('compendium_faq_answer_10_5', 'FR', "Des pages courtes et accessibles utilisant du vocabulaire simple.");
___('compendium_faq_answer_10_6', 'EN', "A single core writer/editor in order to have control over all content.");
___('compendium_faq_answer_10_6', 'FR', "Une seule personne rédigeant tous les contenus afin de garantir la ligne éditoriale.");
___('compendium_faq_answer_10_7', 'EN', "English/French bilingual, as the french community lacks such websites.");
___('compendium_faq_answer_10_7', 'FR', "Bilingue français/anglais, la communauté francophone ayant peu de sites en ce genre.");

___('compendium_faq_answer_11_1', 'EN', <<<EOT
NoBleme is more than just a domain name or a website, it is also a "framework", a set of development tools which make the creation of new components for the website much quicker than if they were created from scratch for a new platform. With this in mind, it made more sense to develop the 21st century compendium as a part of NoBleme rather than as a separate website.
EOT
);
___('compendium_faq_answer_11_1', 'FR', <<<EOT
NoBleme est plus qu'un nom de domaine ou un site internet, c'est également un « framework », une panoplie d'outils de développement qui rendent la création de nouveaux contenus sur le site plus rapide et facile que si ces contenus étaient crées à partir de rien pour une nouvelle plateforme.
EOT
);
___('compendium_faq_answer_11_2', 'EN', <<<EOT
As this whole platform is the work of one single person with limited time and energy to invest in the project, going with the quicker solution simply made more sense. Hopefully it will not affect your experience of browsing the 21st century compendium in any negative way.
EOT
);
___('compendium_faq_answer_11_2', 'FR', <<<EOT
Vu que tout ce site est l'œuvre d'une seule personne disposant d'une quantité limitée de temps et d'énergie à y investir, il était logique de choisir la solution la plus simple et rapide, et de faire de ce compendium une partie de NoBleme plutôt qu'un autre site séparé. Cela ne devrait toutefois pas affecter votre expérience lorsque vous parcourez le compendium.
EOT
);

___('compendium_faq_answer_12_1', 'EN', <<<EOT
NoBleme is an Internet community which has continuously existed since 2005. You can find out more about its history, its purpose, and its goals on the {{link|pages/doc/nobleme|what is NoBleme?}} page.
EOT
);
___('compendium_faq_answer_12_1', 'FR', <<<EOT
NoBleme est une communauté internet qui existe en continu depuis 2005. Vous pouvez en lire plus sur son histoire et sa raison d'être sur la page {{link|pages/doc/nobleme|qu'est-ce que NoBleme?}}
EOT
);
___('compendium_faq_answer_12_2', 'EN', <<<EOT
As a sidenote, a first attempt at documenting 21st century culture was already done on NoBleme all the way back in 2006, under the name "Wiki NoBleme". It was quite successful, attracting millions of readers, but had to eventually be shut down due to a few issues, the main one being that it attempted to keep politics out of everything and be a "neutral" documentation. Once it was clear that the neutral stance was actually helping the spread of harmful ideas, NoBleme's wiki was shut down in 2011. Ten years later, in 2021, this compendium is designed with the shortcomings of the first attempt in mind. Always learn from your past!
EOT
);
___('compendium_faq_answer_12_2', 'FR', <<<EOT
Par ailleurs, une première tentative de documenter la culture du 21ème siècle avait déjà eu lieu sur NoBleme en 2006, sous le nom « wiki NoBleme ». Cette tentative a connu un grand succès, attirant des millions de visites, mais a fini par fermer ses portes sous le poids de nombreux problèmes, le principal étant la règle de rendre le wiki NoBleme « apolitique » en prétendant que les contenus qui y étaient documentés pouvaient l'être sans prendre en compte leur impact social et politique. Lorsqu'il est devenu clair que le wiki NoBleme contribuait involontairement à répandre des contenus nocifs, il a été définitevement fermé en 2011. Dix ans plus tard, en 2021, ce compendium a été crée en prenant en compte les leçons qui ont été apprises lors de cette première tentative originelle. Il est important de toujours tirer des leçons du passé !
EOT
);

___('compendium_faq_answer_13_1', 'EN', <<<EOT
Please use our {{link|todo_link|contact form}} for any corrections or claims. Even if you are looking to have an e-mail or legal exchange with us, the contact form is our starting point for any conversation.
EOT
);
___('compendium_faq_answer_13_1', 'FR', <<<EOT
Utilisez notre {{link|todo_link|formulaire de contact}} pour tout signalement d'erreur ou toute réclamation. Même si vous désirez discuter par e-mail ou avoir un échange légal avec nous, le formulaire de contact est le point d'entrée de toute conversation.
EOT
);
___('compendium_faq_answer_13_2', 'EN', <<<EOT
A lot of material is being documented in this compendium for encyclopedic purposes. We try to steer clear of slandering anyone or hosting any copyrighted content without the appropriate permissions, but mistakes might happen and we are open to fixing them. Do not hesitate to get in touch with us.
EOT
);
___('compendium_faq_answer_13_2', 'FR', <<<EOT
Beaucoup de contenus sont documentés dans ce compendium dans un but purement encyclopédique. Nous essayons activement d'éviter les situations de diffamation en sourçant tous nos écrits, et évitons également d'héberger des contenus soumis à des limitations de propriété intellectuelle sans disposer des permissions requises. Toutefois, la nature chaotique des contenus partagés sur Internet fait que des erreurs peuvent avoir lieu, auquel cas nous désirons les corriger. N'hésitez pas à nous contacter à ces sujets.
EOT
);

___('compendium_faq_answer_14_1', 'EN', <<<EOT
Third party contributors are more than welcome. Whether you would like to suggest new content or point out inaccuracies in existing content, you can do so using our {{link|todo_link|contact form}}. Contributors are credited on the pages which they have contributed to (unless they asked to not be credited).
EOT
);
___('compendium_faq_answer_14_1', 'FR', <<<EOT
Les contributions sont plus que bienvenues. Que vous désiriez proposer des nouveaux contenus, signaler des erreurs, proposer des améliorations, vous pouvez le faire via notre {{link|todo_link|formulaire de contact}}. Les personnes offrant des contributions sont créditées sur les pages concernées (sauf si elles demandent à rester anonymes).
EOT
);
___('compendium_faq_answer_14_2', 'EN', <<<EOT
Do bear in mind however that, due to the compendium being the work of only one person, contributions can take a very long time to be used (unless they are pointing out errors of critical importance).
EOT
);
___('compendium_faq_answer_14_2', 'FR', <<<EOT
Gardez toutefois à l'esprit que, ce compendium étant l'œuvre d'une seule personne, beaucoup de temps peut parfois s'écouler avant que vos contributions soient traitées (sauf s'il s'agit de sujets d'importance critique).
EOT
);

___('compendium_faq_answer_15_1', 'EN', <<<EOT
NoBleme's {{link|pages/nobleme/activity|recent activity}} page and the compendium's {{link|todo_link|list of all pages}} both let you filter data in a way which allows you to track recent activity in the 21st century compendium.
EOT
);
___('compendium_faq_answer_15_1', 'FR', <<<EOT
La page {{link|pages/nobleme/activity|activité récente}} de NoBleme et la {{link|todo_link|liste des pages}} de ce compendium vous permettent de trier et filtrer les données afin de voir les pages crées ou modifiées récemment.
EOT
);
___('compendium_faq_answer_15_2', 'EN', <<<EOT
Automated messages are sent on both of NoBleme's {{link|pages/social/irc|IRC chat server}} and {{link|pages/social/discord|Discord server}} every time content is added or modified in the 21st century compendium.
EOT
);
___('compendium_faq_answer_15_2', 'FR', <<<EOT
Des messages automatisés sont envoyés sur le {{link|pages/social/irc|serveur de chat IRC}} et le {{link|pages/social/discord|serveur Discord}} de NoBleme à chaque fois qu'une nouvelle page est crée ou qu'une modification majeure a lieu sur le compendium.
EOT
);
___('compendium_faq_answer_15_3', 'EN', <<<EOT
We currently have no presence on other websites or social media, but might eventually share compendium updates on platforms other than NoBleme.
EOT
);
___('compendium_faq_answer_15_3', 'FR', <<<EOT
Nous n'avons actuellement aucune présence sur d'autres sites Internet ou réseaux sociaux, mais comptons à terme partager l'activité du compendium sur des plateformes autres que NoBleme.
EOT
);