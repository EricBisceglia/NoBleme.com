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
The most important part of online privacy is the fate of your personal data. NoBleme collects the strict minimum personal data required to properly run the website, which is not much. If you are curious about what we specifically collect about you, how long we keep it, why we need it, how we use it, where it is hosted, etc. we have a whole page of the website dedicated to it: {{link|todo_link|Your personal data}}.
EOT
);
___('privacy_data_1',     'FR', <<<EOT
L'aspect le plus important d'une politique de confidentialité est le destin de vos données personnelles. NoBleme ne collecte de ces données que le strict minimum requis au bon fonctionnement du site. Si vous êtes curieux de ce que nous collectons exactement comme données personnelles, pendant combien de temps nous les conservons, comment nous les utilisons, pourquoi nous en avons besoin, où elles sont stockées, etc. nous avons une page entière du site dédiée à répondre à ces questions : {{link|todo_link|Vos données personnelles}}.
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
Further details about the legal implications of using NoBleme - for example, the intellectual property of any content you'd share on NoBleme - can be found on our {{link|todo_link|legal notices page}}.
EOT
);
___('privacy_agreement_3',      'FR', <<<EOT
Vous trouverez plus de détails sur les implications légales de l'utilisation de NoBleme - par exemple sur la propriété intellectuelle des contenus que vous partagez sur le site - dans les {{link|todo_link|mentions légales}}.
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