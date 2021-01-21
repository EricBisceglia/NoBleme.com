<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      BBCODES                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('bbcodes_subtitle', 'EN', "Message styling tool");
___('bbcodes_subtitle', 'FR', "Personnalisation des messages");
___('bbcodes_intro',    'EN', <<<EOT
If you need to add any styling (bold, links, images, etc.) to a message on NoBleme, you will have to do so using the available {{external|https://en.wikipedia.org/wiki/BBCode|BBCodes}}. All of the BBCodes that you can use on the website are documented below. You will also find, at the end of this page, a text area in which you can try out BBCodes.
EOT
);
___('bbcodes_intro',    'FR', <<<EOT
Si vous avez besoin de styliser le contenu de vos messages sur NoBleme (liens, images, texte gras, etc.), vous devrez le faire en utilisant des {{external|https://fr.wikipedia.org/wiki/BBCode|BBCodes}}. Tous les BBCodes à votre disposition sur NoBleme sont documentés ci-dessous. Vous trouverez égalament à la fin de cette page une zone de texte dans laquelle vous pouvez expérimenter avec les BBCodes.
EOT
);


// Table
___('bbcodes_bbcode',           'EN', "BBCode");
___('bbcodes_bbcode',           'FR', "BBCode");
___('bbcodes_effect',           'EN', "Effect");
___('bbcodes_effect',           'FR', "Effet");
___('bbcodes_result',           'EN', "Example / Result");
___('bbcodes_result',           'FR', "Exemple / Résultat");

___('bbcodes_doc_link',         'EN', "[url]https://nobleme.com[/url]");
___('bbcodes_doc_link',         'FR', "[url]https://nobleme.com[/url]");
___('bbcodes_doc_link_full',    'EN', "[url=https://nobleme.com]Link to NoBleme[/url]");
___('bbcodes_doc_link_full',    'FR', "[url=https://nobleme.com]Lien vers NoBleme[/url]");

___('bbcodes_doc_image',        'EN', "[img]https://nobleme.com/favicon.ico[/img]");
___('bbcodes_doc_image',        'FR', "[img]https://nobleme.com/favicon.ico[/img]");

___('bbcodes_doc_bold',         'EN', "[b]This text[/b] will be bolded");
___('bbcodes_doc_bold',         'FR', "[b]Ce texte[/b] apparaîtra en gras");

___('bbcodes_underlined',       'EN', "Underlined");
___('bbcodes_underlined',       'FR', "Souligné");
___('bbcodes_doc_underlined',   'EN', "[u]This text[/u] will be underlined");
___('bbcodes_doc_underlined',   'FR', "[u]Ce texte[/u] sera souligné");

___('bbcodes_italics',          'EN', "Italics");
___('bbcodes_italics',          'FR', "Italique");
___('bbcodes_doc_italics',      'EN', "[i]This text[/i] will be oblique");
___('bbcodes_doc_italics',      'FR', "[i]Ce texte[/i] sera incliné");

___('bbcodes_strike',           'EN', "Strikethrough");
___('bbcodes_strike',           'FR', "Barré");
___('bbcodes_doc_strike',       'EN', "[s]This text[/s] will be crossed off");
___('bbcodes_doc_strike',       'FR', "[s]Ce texte[/s] sera barré");

___('bbcodes_blur',             'EN', "Blurred");
___('bbcodes_blur',             'FR', "Flouté");
___('bbcodes_doc_blur',         'EN', "[blur]This is blurry[/blur], click on it");
___('bbcodes_doc_blur',         'FR', "[blur]Ceci est flou[/blur], cliquez dessus");

___('bbcodes_align',            'EN', "Alignment");
___('bbcodes_align',            'FR', "Alignement");
___('bbcodes_doc_align_left',   'EN', "[align=left]To the left[/align]");
___('bbcodes_doc_align_left',   'FR', "[align=left]Vers la gauche[/align]");
___('bbcodes_doc_align_center', 'EN', "[align=center]To the middle[/align]");
___('bbcodes_doc_align_center', 'FR', "[align=center]Vers le milieu[/align]");
___('bbcodes_doc_align_right',  'EN', "[align=right]To the right[/align]");
___('bbcodes_doc_align_right',  'FR', "[align=right]Vers la droite[/align]");

___('bbcodes_color',            'EN', "Color");
___('bbcodes_color',            'FR', "Couleur");
___('bbcodes_doc_color_name',   'EN', "[color=red]Color name[/color]");
___('bbcodes_doc_color_name',   'FR', "[color=red]Nom de couleur (en anglais)[/color]");
___('bbcodes_doc_color_hex',    'EN', "[color=#0069C0]Hexadecimal color[/align]");
___('bbcodes_doc_color_hex',    'FR', "[color=#0069C0]Couleur hexadécimale[/align]");

___('bbcodes_size',             'EN', "Size");
___('bbcodes_size',             'FR', "Taille");
___('bbcodes_doc_size',         'EN', "[size=2]Bigger size[/size]");
___('bbcodes_doc_size',         'FR', "[size=2]Grand texte[/size]");

___('bbcodes_code',             'EN', "Code block");
___('bbcodes_code',             'FR', "Bloc de code");
___('bbcodes_doc_code',         'EN', "[code]Monospaced text in a code block[/code]");
___('bbcodes_doc_code',         'FR', "[code]Texte monospace dans un bloc de code[/code]");

___('bbcodes_space',            'EN', "Space");
___('bbcodes_space',            'FR', "Espace");
___('bbcodes_doc_space',        'EN', "Lets you add [space] spaces");
___('bbcodes_doc_space',        'FR', "Permet d'ajouter des [space] espaces");

___('bbcodes_line',             'EN', "Line");
___('bbcodes_line',             'FR', "Ligne");
___('bbcodes_doc_line',         'EN', "Have a [line] horizontal separator");
___('bbcodes_doc_line',         'FR', "Voici une [line] séparation horizontale");

___('bbcodes_doc_quote',        'EN', "[quote]Quoting someone or something[/quote]");
___('bbcodes_doc_quote',        'FR', "[quote]Citation de quelqu'un ou quelque chose[/quote]");
___('bbcodes_doc_quote_full',   'EN', "[quote=Bad]Hi, I'm Bad[/quote]");
___('bbcodes_doc_quote_full',   'FR', "[quote=Bad]Salut, je suis Bad[/quote]");

___('bbcodes_doc_spoiler',      'EN', "[spoiler]This content is hidden[/spoiler]");
___('bbcodes_doc_spoiler',      'FR', "[spoiler]Ce contenu est caché[/spoiler]");
___('bbcodes_doc_spoiler_full', 'EN', "[spoiler=Star Wars]Han shot first[/spoiler]");
___('bbcodes_doc_spoiler_full', 'FR', "[spoiler=Star Wars]Han a tiré en premier[/spoiler]");


// Experimental zone
___('bbcodes_experiment', 'EN', "Experimental zone");
___('bbcodes_experiment', 'FR', "Zone d'expérimentation");
___('bbcodes_test_zone',  'EN', <<<EOT
The best way to understand how BBCodes work is to try them out! Type anything you want in the text area below, the transformed result will appear in real time underneath. A few BBCodes have been pre-entered in the text area, feel free to delete them and try your own experiments.
EOT
);
___('bbcodes_test_zone',  'FR', <<<EOT
La meilleure façon de comprendre comment les BBCodes fonctionnent est de les utiliser ! Écrivez ce que vous voulez dans la zone de texte ci-dessous, le résultat transformé apparaîtra en temps réel en dessous. Quelques BBCodes y ont été pré-remplis , libre à vous de les supprimer et de faire vos propres expériences.
EOT
);
___('bbcodes_test_input', 'EN', <<<EOT
[s][b][i][color=orange][size=2]Combined BBCodes[/size][/color][/i][/b][/s]

[spoiler][spoiler=One more][spoiler=Last one][quote][code]Nested spoilers[/code][/quote][/spoiler][/spoiler][/spoiler]
EOT
);
___('bbcodes_test_input', 'FR', <<<EOT
[s][b][i][color=orange][size=2]BBCodes combinés[/size][/color][/i][/b][/s]

[spoiler][spoiler=Encore un][spoiler=Le dernier][quote][code]Divulgâchages encastrés[/code][/quote][/spoiler][/spoiler][/spoiler]
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  PRIVACY  POLICY                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('privacy_intro_1',  'EN', <<<EOT
Privacy is critical on NoBleme. If you've read the {{link|pages/nobleme/nobleme|website's history}}, you might understand that we stand against the modern state of the Internet, where your personal data is collected, shared, and sometimes even sold without your knowledge on nearly all websites and mobile applications.
EOT
);
___('privacy_intro_1',  'FR', <<<EOT
Le respect de votre vie privée est très important pour NoBleme. En lisant {{link|pages/nobleme/nobleme|l'histoire de NoBleme}}, vous comprendrez que nous sommes à l'opposé de l'état actuel d'Internet, où vos données personnelles sont collectées, partagées, et parfois même vendues sans que vous le sachiez lorsque vous utilisez la majorité des sites internet et des applications mobiles.
EOT
);
___('privacy_intro_2',  'EN', <<<EOT
Privacy policies are usually deliberately obscure and complicated in order to force users to accept them without thinking about their consequences and implications. In order to prove how much privacy matters to us, we will do the exact opposite. This page will try to use the simplest vocabulary possible and to cover every privacy related question which you might have about NoBleme - including how to prove that we are telling the truth.
EOT
);
___('privacy_intro_2',  'FR', <<<EOT
Les politiques de confidentialité sont souvent délibérément obscures et complexes anfin de vous forcer à les accepter sans réfléchir à leurs conséquences. Afin de prouver à quel point le respect de la vie privée compte pour nous, NoBleme vous propose l'opposé : cette page essaye de couvrir toutes les questions que vous pourriez vous poser au sujet du respect de votre vie privée sur NoBleme, en utilisant un vocabulaire simple.
EOT
);


// GDPR
___('privacy_data_title', 'EN', "Your personal data");
___('privacy_data_title', 'FR', "Vos données personnelles");
___('privacy_data_1',     'EN', <<<EOT
The most important part of online privacy is the fate of your personal data. NoBleme collects the strict minimum personal data required to properly run the website, which is not much. If you are curious about what we specifically collect about you, how long we keep it, why we need it, how we use it, where it is hosted, etc. we have a whole page of the website dedicated to it: {{link|pages/doc/data|Your personal data}}.
EOT
);
___('privacy_data_1',     'FR', <<<EOT
L'aspect le plus important d'une politique de confidentialité est le destin de vos données personnelles. NoBleme ne collecte de ces données que le strict minimum requis au bon fonctionnement du site. Si vous êtes curieux de ce que nous collectons exactement comme données personnelles, pendant combien de temps nous les conservons, comment nous les utilisons, pourquoi nous en avons besoin, où elles sont stockées, etc. nous avons une page entière du site dédiée à répondre à ces questions : {{link|pages/doc/data|Vos données personnelles}}.
EOT
);
___('privacy_data_2',     'EN', <<<EOT
In accordance with {{external|https://en.wikipedia.org/wiki/General_Data_Protection_Regulation|GDPR}} legislation, you are granted a "right to be forgotten". If, for any reason, at any given time, you feel like you want to disappear from NoBleme and have your personal data removed from the website, we have a form allowing you to {{link|pages/messages/admins?delete|opt out of NoBleme}}.
EOT
);
___('privacy_data_2',     'FR', <<<EOT
Tel qu'imposé par le {{external|https://fr.wikipedia.org/wiki/R%C3%A8glement_g%C3%A9n%C3%A9ral_sur_la_protection_des_donn%C3%A9es|RGPD}}, vous disposez d'un « droit à l'oubli » (oui, c'est également le cas sur tous les autres sites Internet). Si, pour n'importe quelle raison, vous désirez disparaître de NoBleme et faire disparaître vos données personnelles par la même occasion, utilisez le formulaire vous permettant de {{link|pages/messages/admins?delete|demander la suppression de votre compte}}.
EOT
);


// Anonymity
___('privacy_anonymity_title', 'EN', "Guaranteed anonymity");
___('privacy_anonymity_title', 'FR', "Anonymat garanti");
___('privacy_anonymity_1',     'EN', <<<EOT
On NoBleme, you have a right to remain fully anonymous. No element that links you to your private identity is required at any point of the account registration process. Any extra elements are optional, it is up to you whether you want to fill in or leave empty {{link|pages/users/profile_edit|your public profile}} aswell as {{link|pages/account/settings_email|your e-mail address}} (which will never be shown publicly or shared).
EOT
);
___('privacy_anonymity_1',     'FR', <<<EOT
Sur NoBleme, nous vous offrons la possibilité de rester entièrement anonyme. Lors de la création d'un compte, aucun élément lié à votre identité réelle n'est requis. Tout est optionnel, c'est à vous de décider si vous voulez laisser vide ou remplir {{link|pages/users/profile_edit|votre profil public}}, ainsi que {{link|pages/account/settings_email|votre adresse e-mail}} (qui ne sera jamais affichée publiquement ni partagée).
EOT
);
___('privacy_anonymity_2',     'EN', <<<EOT
However, stay aware that anonymity on the public Internet has its limits. It is not uncommon for websites to be asked to share some user information with law enforcement, in which case we would be obligated to share what little of your personal data we have. This means that while anonymity might protect you from other people knowing who you are, it does not protect you from the consequences of committing illegal activities.
EOT
);
___('privacy_anonymity_2',     'FR', <<<EOT
Toutefois, ayez conscience que l'anonymat sur Internet a ses limites. Il se peut que les forces de l'ordre nous demandent de partager des données sur nos utilisateurs dans le cadre d'une enquête, auquel cas nous serons forcés de partager le peu de données personnelles que nous avons à votre sujet. Cela signifie que l'anonymat sur NoBleme (et ailleurs) protège votre identité réelle face aux autres membres du site, mais ne vous protège pas des conséquences d'actions illégales que vous pourriez réaliser.
EOT
);


// Third parties
___('privacy_external_title', 'EN', "Third parties");
___('privacy_external_title', 'FR', "Contenus tiers");
___('privacy_external_1',     'EN', <<<EOT
Everything on NoBleme is custom made and handcrafted with love, none of the website's features use any third party scripts or software. Most websites use third party services for advertisements, metrics, user tracking, but since we don't do any of those things we have no reason to share your personal data with any third parties. This is why you did not see the usual consent banner which you get on most other websites: we do not share your personal data, thus we don't need you to consent to having your data shared.
EOT
);
___('privacy_external_1',     'FR', <<<EOT
Tout NoBleme est fabriqué à la main, sur mesure, avec amour. Le site n'utilise aucun script ou logiciel tiers. La plupart des sites Internet se servent de scripts externes pour la publicité, faire des statistiques, traquer les utilisateurs, mais vu que nous ne faisons aucune de ces choses nous n'avons aucun besoin de partager vos données avec des tiers. C'est pour cela que vous n'avez pas eu de bannière vous demandant votre consentement pour utiliser vos cookies comme vous pouvez en trouver sur les autres sites : nous n'avons pas besoin de vous faire consentir au partage de vos données avec des tiers vu que nous ne le faisons pas.
EOT
);
___('privacy_external_2',     'EN', <<<EOT
There is however one area of NoBleme which contains third party content. For the purpose of documenting Internet culture, the {{link|todo_link|21st century compendium}} embeds external content in some of its pages. In order to minimize the potential for these third parties to do something nefarious with your data, we try to use as few of them as possible - at the moment, YouTube videos and Google Trends graphs are the only external content which you will find on NoBleme.
EOT
);
___('privacy_external_2',     'FR', <<<EOT
Il y a toutefois une partie de NoBleme où se trouvent des contenus tiers. Dans le {{link|todo_link|compendium du 21ème siècle}}, certaines pages incluent des contenus externes, qui servent d'illustration. Afin de minimiser le potentiel de collecte de vos données personnelles par ces tiers, nous en utilisons le plus petit nombre possible : actuellement, les seuls contenus tiers que vous trouverez sur NoBleme sont des vidéos YouTube et des graphes Google Trends.
EOT
);
___('privacy_external_3',     'EN', <<<EOT
Even though they do not get access to any user data (we do not share anything with them), these third party embeds might still include external scripts over which we have no control, and thus manage to gather some data about you in their own ways. If you're not comfortable with that risk, we give you the ability to {{link|pages/account/settings_privacy|disable all third party content}} on NoBleme.
EOT
);
___('privacy_external_3',     'FR', <<<EOT
Même si ces tiers ne peuvent pas avoir accès aux données personnelles que nous avons (nous ne les partageons pas), nous n'avons aucun contrôle sur la possible collecte de données qu'ils pourraient faire lorsqu'ils sont inclus sur une page du site. C'est pourquoi, si vous craignez qu'ils trouvent une façon de collecter vos données et que vous n'êtes pas confortable avec cette situation, nous vous proposons de totalement {{link|pages/account/settings_privacy|désactiver les contenus tiers}} sur NoBleme.
EOT
);


// User agreement
___('privacy_agreement_title',  'EN', "User agreement");
___('privacy_agreement_title',  'FR', "Contrat utilisateur");
___('privacy_agreement_1',      'EN', <<<EOT
When registering an account on a website, you might be used to having to accept a very long user agreement. The lack of such a user agreement on NoBleme is a guarantee of privacy: it means that we have no legal rights to do anything with your personal data.
EOT
);
___('privacy_agreement_1',      'FR', <<<EOT
Lorsque vous créez un compte sur un site Internet, vous avez probablement l'habitude de devoir accepter un long texte que vous ne lisez pas portant le nom de « contrat de licence utilisateur final ». L'absence de ce type de contrat lors de la création de votre compte sur NoBleme est une garantie du respect de votre vie privée : cela signifie que nous ne vous demandons aucune dérogation légale particulière, et n'avons donc légalement pas le droit d'exploiter vos données personnelles.
EOT
);
___('privacy_agreement_2',      'EN', <<<EOT
Do keep in mind though that user agreements are only used for legal disputes, and have no impact on the rules we apply when administrating the website - even if you did not expressedly accept it, you are still implicitly bound to respect NoBleme's short and simple {{link|pages/doc/coc|code of conduct}}, and we have the right to exclude you from the website if you don't.
EOT
);
___('privacy_agreement_2',      'FR', <<<EOT
Sachez tout de même que les contrats utilisateur ne concernent que les disputes légales, et n'ont donc aucun impact sur l'administration interne de NoBleme. Même si vous ne l'avez pas expressément accepté, vous restez sous la gouverne de notre simple et court {{link|pages/doc/coc|code de conduite}}, et nous gardons le droit de vous exclure de NoBleme si vous ne le respectez pas.
EOT
);
___('privacy_agreement_3',      'EN', <<<EOT
Further details about the legal implications of using NoBleme - for example, the intellectual property of any content you'd share on NoBleme - can be found in our {{link|pages/doc/legal|legal notice}}.
EOT
);
___('privacy_agreement_3',      'FR', <<<EOT
Vous trouverez plus de détails sur les implications légales de l'utilisation de NoBleme - par exemple sur la propriété intellectuelle des contenus que vous partagez sur le site - dans les {{link|pages/doc/legal|mentions légales}}.
EOT
);


// Open source
___('privacy_source_title', 'EN', "Open sourced code");
___('privacy_source_title', 'FR', "Code source public");
___('privacy_source_1',     'EN', <<<EOT
Understandably, you have no reason to believe any of the things listed above. This is why we've decided to {{external|https://github.com/EricBisceglia/NoBleme.com|publicly share NoBleme's entire source code}}. If you are tech savvy or know someone who is, feel free to dive in our source code, or even set up a local copy of NoBleme's source code on your computer, and verify all of our claims above.
EOT
);
___('privacy_source_1',     'FR', <<<EOT
Naturellement, vous n'avez pas de raison de croire en tout ce qui est écrit ci-dessus. C'est pourquoi nous avons décidé de {{external|https://github.com/EricBisceglia/NoBleme.com|partager publiquement le code source de NoBleme}}. Si vous avez des connaissances techniques ou connaissez quelqu'un qui en a, n'hésitez pas à plonger dans ce code source, ou même à installer une copie locale de NoBleme sur votre ordinateur, afin de vérifier nos propos.
EOT
);
___('privacy_source_2',     'EN', <<<EOT
You can read more about the decision to open source NoBleme's source code {{link|todo_link|behind the scenes}}.
EOT
);
___('privacy_source_2',     'FR', <<<EOT
Vous trouverez plus d'informations sur la décision de publier le code source dans les {{link|todo_link|coulisses de NoBleme}}.
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   LEGAL  NOTICE                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('legal_intro',  'EN', <<<EOT
NoBleme is based and hosted in France, thus french and european intellectual property laws apply to any creative and/or original content created by or for NoBleme. Any third party content (not created by or for NoBleme) still belongs to its creators and/or rights holder and thus international intellectual property laws may apply to some of the contents hosted on NoBleme. If any content over which you hold rights or for which you represent the rights holders is being used on NoBleme without your permission and you would like for it to be removed, please use the {{link|pages/messages/admins|administrative contact form}} - make sure to include proof of intellectual property ownership - and your request will be treated as soon as possible.
EOT
);
___('legal_intro',  'FR', <<<EOT
NoBleme est basé et hébergé en France, par conséquent les lois françaises et européennes sur la propriété intellectuelle s'appliquent à tout contenu créatif et/ou original crée par ou pour NoBleme. Tout contenu tiers (qui n'est pas crée par ou pour NoBleme) appartient à ses créateurs et/ou aux détenteurs de leurs droits, par conséquent des droits internationaux de propriété intellectuelle peuveunt s'appliquer à certains contenus de NoBleme. Si des contenus sur lesquels vous avez droits ou représentez les détenteurs de droits sont utilisés sur NoBleme sans votre permission, effectuez une réclamation via le {{link|pages/messages/admins|formulaire de contact administratif}} - assurez-vous d'inclure une preuve de vos droits - et votre requête sera traitée au plus vite.
EOT
);


// Responsibility
___('legal_responsibility_title', 'EN', "Responsibility over user submitted content");
___('legal_responsibility_title', 'FR', "Responsabilité sur les contenus utilisateur");
___('legal_responsibility_body',  'EN', <<<EOT
As it is free for anyone to create an account on NoBleme, and as moderation of user submitted content happens only after said content has been submitted on the website, we can not be held responsible for the content being submitted by users on the website until we see them. However, we have a clear {{link|pages/doc/coc|code of conduct}} which we expect both our users and ourselves to follow. Any content which goes against this code of conduct will be deleted as soon as possible, in a <i>best effort</i> manner, depending on the availability of our administrative team. Any users which go against this code of conduct will find themselves temporarily or permanently excluded from submitting content to NoBleme, preventing further abuse.
EOT
);
___('legal_responsibility_body',  'FR', <<<EOT
Vu que créer un compte sur NoBleme est gratuit, et vu que la modération des contenus partagés par les membres du site a lieu à postériori, nous ne pouvons pas être responsables des contenus partagés par les membres avant d'en avoir pris connaissance. Toutefois, nous avons un {{link|pages/doc/coc|code de conduite}} clair que tous les membres sont tenus de respecter - l'équipe administrative incluse. Tout contenu allant à l'encontre de ce code de conduite sera supprimé au plus vite, selon la disponibilité de l'équipe administrative. Tout membre allant à l'encontre de ce code de conduite se verra privé de façon temporaire ou permanente de la possibilité de partager du contenu sur NoBleme.
EOT
);


// User content
___('legal_user_content_title', 'EN', "Intellectual property rights over user submitted content");
___('legal_user_content_title', 'FR', "Propriété intellectuelle des contenus utilisateur");
___('legal_user_content_body',  'EN', <<<EOT
Any time you submit your own creative and/or original content on NoBleme, you implicitly authorize NoBleme to reuse this content within the boundaries of the website or any other platform belonging to NoBleme, and authorize other users of the website to quote the content that you posted. However, as the author of these creative and/or original works, you automatically gain the ownership of the full intellectual property rights on any of those works by submitting them to NoBleme. This means that NoBleme does not own the right to reuse, distribute, or monetize your works in any way of form without your authorization. We respect ownership.
EOT
);
___('legal_user_content_body',  'FR', <<<EOT
En publiant du contenu original sur NoBleme, vous autorisez implicitement à titre gracieux leur reproduction et diffusion sur le reste de NoBleme et sur les autres plateformes appartenent à NoBleme, et autorisez les autres membres de NoBleme à citer vos contenus sur le reste de NoBleme. Toutefois, en tant qu'auteur de tout contenu original que vous publiez sur NoBleme, vous en conservez la propriété intellectuelle et les droits d'auteur assortis. NoBleme s'engage par conséquent à ne pas publier hors du site sans votre permission et à ne pas monétiser les contenus originaux que vous publiez sur le site. Nous respectons entièrement vos droits d'auteur et ne nous donnons pas les pouvoirs requis pour en prendre le contrôle.
EOT
);


// Fair use
___('legal_fair_title', 'EN', "Fair use of third party content");
___('legal_fair_title', 'FR', "Usage loyal de contenus tiers");
___('legal_fair_body',  'EN', <<<EOT
Some third party content might be used on NoBleme for educative or encyclopedic purposes, mainly in the {{link|todo_link|21st century compendium}}. For these use cases, credit will be given to the original author when possible. In some cases, due to the anonymous nature of many Internet platforms, it is hard or even impossible to find and credit the author of some original creative works. If you can demonstrate ownership of a piece of creative work hosted on NoBleme over which you hold intellectual property rights, use our {{link|pages/messages/admins|administrative contact form}} to make your request and it will be removed as soon as possible.
EOT
);
___('legal_fair_body',  'FR', <<<EOT
Certains contenus tiers sont utilisés sur NoBleme à titre pédagogique ou encyclopédique, principalement dans le {{link|todo_link|compendium du 21ème siècle}}. Dans ces cas, nous nous efforçons de créditer les auteurs de ces contenus. Malheureusement, de par la nature anonyme et chaotique d'Internet, il n'est pas toujours possible d'identifier l'auteur de contenus créatifs. Si vous pouvez démontrer que vous êtes à l'origine d'un contenu tiers hébergé sur NoBleme et que vous désirez vous faire créditer ou demander la suppression de ce contenu, utilisez notre {{link|pages/messages/admins|formulaire de contact administratif}} pour formuler votre requête, qui sera traitée dès que possible.
EOT
);


// Source code
___('legal_source_title', 'EN', "Using NoBleme's source code");
___('legal_source_title', 'FR', "Utiliser le code source de NoBleme");
___('legal_source_body',  'EN', <<<EOT
As stated {{link|todo_link|behind the scenes}}, NoBleme's source code has been open sourced - thus made available to the general public. However, please take note that open sourced does not necessarily mean free to re-use for your own projects. In NoBleme's case, it has been open sourced under the very permissive {{external|https://en.wikipedia.org/wiki/MIT_License|MIT license}}, which means that you are free to use any or all of NoBleme's source code in your own projects as long as you properly credit its author by including a copy of the permission notice included in NoBleme's licence in your own source code - along with the copyright notice: <i>Copyright (c) 2005 Eric Bisceglia / NoBleme.com</i>.
EOT
);
___('legal_source_body',  'FR', <<<EOT
Comme expliqué dans les {{link|todo_link|coulisses de NoBleme}}, le code source de NoBleme a été <i>open sourcé</i> - c'est à dire publié intégralement et publiquement. Notez toutefois que <i>open source</i> ne signifie pas libre de droit. Dans le cas de NoBleme, le code source a été publié sous la très permissive {{external|https://fr.wikipedia.org/wiki/Licence_MIT|licence MIT}}, ce qui signifie que vous êtes libre de réutiliser une partie du code source ou même tout le code source de NoBleme dans vos propres projets, à condition de correctement en créditer l'auteur d'origine en incluant une copie de la <i>permission notice</i> incluse dans la licence se trouvant dans le code source de NoBleme - ainsi que la <i>copyright notice</i> suivante : <i>Copyright (c) 2005 Eric Bisceglia / NoBleme.com</i>.
EOT
);


// Conclusion
___('legal_conclusion_title', 'EN', "Questions, takedown notices, disputes");
___('legal_conclusion_title', 'FR', "Questions, requêtes, disputes");
___('legal_conclusion_body',  'EN', <<<EOT
If you have any questions regarding our legal notice, if you would like to exercise your intellectual property rights through a takedown notice, or if you would like to open a legal dispute with NoBleme, please do so through our {{link|pages/messages/admins|administrative contact form}}. It is the only proper and guaranteed way to reach our administrative team. Using the form requires the creation of a NoBleme account, which is free, quick, and does not require you to submit any personal data. Replies to your inquiry will be done through a private message which you will find on your {{link|pages/messages/inbox|account's message inbox}}, unless you specify an e-mail address in your message in which case the conversation will continue through e-mails.
EOT
);
___('legal_conclusion_body',  'FR', <<<EOT
Si vous avez des questions sur nos mentions légales, si vous voulez exercer vos droits de propriété intellectuelle sur des contenus de NoBleme, ou si vous désirez initier une dispute légale avec NoBleme, merci de le faire via notre {{link|pages/messages/admins|formulaire de contact administratif}}. Il s'agit du seul moyen garanti de vous assurer que votre requête atteigne l'équipe d'administration du site. Pour utiliser ce formulaire, vous devrez créer un compte sur NoBleme, ce qui est gratuit, rapide, et ne requiert le partage d'aucune information personnelle. Les réponses à vos questions ou requêtes se feront via message privé que vous pourrez trouver sur la {{link|pages/messages/inbox|boîte de réception de votre compte}}, sauf si vous précisez une adresse e-mail à utiliser dans votre question ou requête, auquel cas la conversation pourra continuer par e-mail.
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   PERSONAL DATA                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('doc_data_intro_1', 'EN', <<<EOT
As outlined in our {{link|pages/doc/privacy|privacy policy}} (which is short and simple - give it a read!), NoBleme collects the strict minimum amount of personal data required to make the website work correctly. On this page, you will find a list of all the personal data NoBleme collected about you, and for each element an explanation of why we gathered it, how long we plan to keep it, and how we use it. Move your pointer over or click on blurred text to reveal it.
EOT
);
___('doc_data_intro_1', 'FR', <<<EOT
Comme précisé dans notre {{link|pages/doc/privacy|politique de confidentialité}}, NoBleme collecte le strict minimum de vos données personnelles requis pour le bon fonctionnement du site. Sur cette page, vous trouverez la liste de toutes les données personnelles stockées par NoBleme à votre sujet, et pour chacune d'entre elle une explication de pourquoi nous les collectons, combien de temps nous comptons les garder, et comment nous les utilisons. Déplacez votre pointeur ou cliquez sur les textes floutés pour les révéler.
EOT
);
___('doc_data_intro_2', 'EN', "The following statements are true for all of the personal data gathered on NoBleme:");
___('doc_data_intro_2', 'FR', "Les affirmations suivantes sont vraies pour toutes les données personnelles collectées sur NoBleme :");
___('doc_data_list_1',  'EN', "This data is only used within the confines of NoBleme.com");
___('doc_data_list_1',  'FR', "Ces données ne seront utilisées que sur NoBleme.com");
___('doc_data_list_2',  'EN', "This data will never be used outside of NoBleme.com");
___('doc_data_list_2',  'FR', "Ces données ne seront jamais utilisées hors de NoBleme.com");
___('doc_data_list_3',  'EN', "This data will never be shared or sold to third parties");
___('doc_data_list_3',  'FR', "Ces données ne seront jamais partagées ou vendues à des tiers");
___('doc_data_list_4',  'EN', "This data is only visible to yourself and the website's {{link|pages/users/admins|administrators}}");
___('doc_data_list_4',  'FR', "Ces données ne sont visibles que par vous et par {{link|pages/users/admins|l'administration}}");
___('doc_data_list_5',  'EN', "This data will be stored solely on our servers in France");
___('doc_data_list_5',  'FR', "Ces données sont exclusivement stockées sur nos serveurs en France");


// IP address
___('doc_data_ip_title',    'EN', "Your IP address:");
___('doc_data_ip_title',    'FR', "Votre adresse IP :");
___('doc_data_ip_guest_1',  'EN', <<<EOT
As a guest (not logged into an account), your IP address is kept in NoBleme's database for <span class="bold">up to a month</span>.
EOT
);
___('doc_data_ip_guest_1',  'FR', <<<EOT
En tant que visiteur (non connecté à un compte), votre adresse IP sera gardée dans la base de données de NoBleme pendant <span class="bold">un maximum d'un mois</span>.
EOT
);
___('doc_data_ip_guest_2',  'EN', <<<EOT
We use IP addresses as a way to differentiate guests on the {{link|pages/users/online|who's online}} page, and as a way to track login attempts done on each user account in order to prevent {{external|https://en.wikipedia.org/wiki/Brute-force_attack|bruteforcing}} of account passwords. Your IP address is not used to track your activity on the website, and it is not used in any website logs that are kept for more than a month. We have no interest in tracking guest activity beyond security measures.
EOT
);
___('doc_data_ip_guest_2',  'FR', <<<EOT
Nous utilisons les adresses IP pour différencier les invités sur {{link|pages/users/online|qui est en ligne}}, ainsi que pour conserver les tentatives de connexions aux comptes utilisateur afin de prévenir le {{external|https://fr.wikipedia.org/wiki/Attaque_par_force_brute|bruteforcing}} des mots de passe. Votre adresse IP n'est pas utilisée pour traquer votre activité sur le site, et n'apparait que dans des logs qui sont supprimés au bout d'un mois. Nous n'avons aucun intérêt à traquer l'activité des invités à part pour préserver la sécurité des comptes.
EOT
);
___('doc_data_ip_user_1',  'EN', <<<EOT
Your IP address is kept in NoBleme's database <span class="bold">indefinitely</span>, or until it changes.
EOT
);
___('doc_data_ip_user_1',  'FR', <<<EOT
Votre adresse IP sera gardée dans la base de données de NoBleme <span class="bold">indéfiniment</span>, ou jusqu'à ce qu'elle change.
EOT
);
___('doc_data_ip_user_2',  'EN', <<<EOT
We use IP addresses as a way to detect multiple accounts (users creating more than one account), as a way to detect ban evasions (users creating new accounts in order to avoid a ban), and as a way to IP ban users that try to use ban evasion methods (a security measure necessary to enforce our {{link|pages/doc/coc|code of conduct}}).
EOT
);
___('doc_data_ip_user_2',  'FR', <<<EOT
Nous utilisons les adresses IP pour détecter les comptes multiples (une personne ayant plusieurs comptes), pour détecter les évasions de bannissements (une personne créant un nouveau compte lorsque son compte princpal est banni), et pour bannir par IP les personnes utilisant des méthodes d'évasion de bannissement (une mesure de sécurité requise pour le maintien de notre {{link|pages/doc/coc|code de conduite}}).
EOT
);
___('doc_data_ip_user_3',  'EN', <<<EOT
Do note that only your <span class="bold">latest</span> IP address is kept in our database. In case of change your previous IP address will immediately be deleted. We have no interest in logging your IP history. As outlined in our {{link|pages/doc/privacy|privacy policy}}, we strongly believe in your right to remain anonymous.
EOT
);
___('doc_data_ip_user_3',  'FR', <<<EOT
Notez que seule votre adresse IP <span class="bold">la plus récente</span> est conservée dans notre base de données. En cas de changement, votre adresse IP précédente sera immédiatement supprimée. Nous n'avons aucun intérêt à conserver votre historique d'adresses IP. Comme précisé dans notre {{link|pages/doc/privacy|politique de confidentialité}}, nous respectons votre droit à l'anonymat.
EOT
);


// E-mail
___('doc_data_email_title', 'EN', "Your e-mail address:");
___('doc_data_email_title', 'FR', "Votre adresse e-mail :");
___('doc_data_email_1',     'EN', <<<EOT
Your e-mail address will be kept in NoBleme's database <span class="bold">indefinitely</span>, or until you change or delete it.
EOT
);
___('doc_data_email_1',     'FR', <<<EOT
Votre adresse e-mail sera gardée dans la base de données de NoBleme <span class="bold">indéfiniment</span>, ou jusqu'à ce qu'elle change ou soit supprimée.
EOT
);
___('doc_data_email_2',     'EN', <<<EOT
Even though NoBleme allows you to optionally link an e-mail address to your account, you are free to change or delete it at any time in your {{link|pages/account/settings_email|e-mail settings}}. The only use to your e-mail address is for account recovery in the event that you would forget your username or password. NoBleme will never send you e-mails, and will never publicly display your e-mail address.
EOT
);
___('doc_data_email_2',     'FR', <<<EOT
Même si NoBleme vous propose de relier votre compte à votre adresse e-mail, vous êtes libre à tout moment de modifier ou supprimer l'adresse e-mail liée à votre compte via vos {{link|pages/account/settings_email|réglages e-mail}}. La seule utilisation que nous ferons de votre adresse e-mail est comme outil de récupération de l'accès à votre compte dans l'éventualité où vous oblieriez votre pseudonyme ou votre mot de passe. NoBleme ne vous enverra jamais d'e-mails, et ne partagera jamais publiquement votre adresse e-mail.
EOT
);


// Language
___('doc_data_lang_title',    'EN', "Your chosen language:");
___('doc_data_lang_title',    'FR', "Votre choix de langue :");
___('doc_data_lang_guest_1',  'EN', <<<EOT
Your language settings will <span class="bold">not be stored at all</span> in NoBleme's database.
EOT
);
___('doc_data_lang_guest_1',  'FR', <<<EOT
Votre choix de langue n'est <span class="bold">pas du tout conservé</span> dans la base de données de NoBleme.
EOT
);
___('doc_data_lang_guest_2',  'EN', <<<EOT
NoBleme has no interest in tracking the language of guests browsing the website. Thus, this data is stored on your computer/device rather than on NoBleme.
EOT
);
___('doc_data_lang_guest_2',  'FR', <<<EOT
NoBleme n'a aucun intérêt à conserver les données de langue des invités. Par conséquent, cette information est stockée sur votre ordinateur/appareil plutôt que sur NoBleme.
EOT
);
___('doc_data_lang_users_1',  'EN', <<<EOT
Your language settings will be kept in NoBleme's database <span class="bold">indefinitely</span>, or until you switch language.
EOT
);
___('doc_data_lang_users_1',  'FR', <<<EOT
Votre choix de langue sera stocké dans la base de données de NoBleme <span class="bold">indéfiniment</span>, ou jusqu'à ce que vous changiez de langue.
EOT
);
___('doc_data_lang_users_2',  'EN', <<<EOT
Keeping your chosen language in our database allows us to always show you NoBleme in your language of choice, even if you change computer/device. This information will never publicly be shared on the website, it is up to you whether you want to display your language(s) of choice in your {{link|pages/users/profile_edit|public profile}}.
EOT
);
___('doc_data_lang_users_2',  'FR', <<<EOT
Conserver votre choix de langue nous permet de toujours afficher NoBleme dans le langage de votre choix, même si vous changez d'ordinateur/appareil. Cette information ne sera jamais affichée publiquement, c'est à vous de décider si vous désirez afficher votre langue sur votre {{link|pages/users/profile_edit|profil public}}.
EOT
);


// Conclusion
___('doc_data_conclusion_title',  'EN', "This is it");
___('doc_data_conclusion_title',  'FR', "C'est tout");
___('doc_data_conclusion_1',      'EN', <<<EOT
We stand by the statements of our {{link|pages/doc/privacy|privacy policy}}: only the bare minimum amount of personal data is gathered on NoBleme, all of it is necessary to operating the website properly, and none of it will ever be shared to third parties unless under legal constraint.
EOT
);
___('doc_data_conclusion_1',      'FR', <<<EOT
Nous maintenons les affirmations de notre {{link|pages/doc/privacy|politique de confidentialité}} : seul le strict minimum de vos données personnelles est récolté sur NoBleme, l'intégralité de ce que nous récoltons comme données est requis pour le bon fonctionnement de NoBleme, et aucune de ces données ne sera partagée avec des tiers sauf sous la contrainte légale.
EOT
);
___('doc_data_conclusion_2',      'EN', <<<EOT
We hope that you appreciate our respect for your privacy, and will understand the underlying message: it is possible to properly operate a website without collecting, sharing, or selling the personal data of its users. Most other websites simply deliberately decide to do so.
EOT
);
___('doc_data_conclusion_2',      'FR', <<<EOT
Nous espérons que vous appréciez le respect que nous portons à votre vie privée, et que vous verrez le message que cela implique: le bon fonctionnement d'un site Internet ne dépend pas de la collecte, du partage, ou de la vente des données pesonnelles de ses visiteurs. C'est un choix délibéré que font la majorité des autres sites et applications.
EOT
);