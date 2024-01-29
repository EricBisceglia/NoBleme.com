<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      BBCODES                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// BBCodes Header
___('bbcodes_subtitle', 'EN', "Message styling tool");
___('bbcodes_subtitle', 'FR', "Personnalisation des messages");
___('bbcodes_intro',    'EN', <<<EOT
If you need to add any styling (bold, links, images, etc.) to a message on NoBleme, you will have to do so using the available {{external|https://en.wikipedia.org/wiki/BBCode|BBCodes}}. All of the BBCodes that you can use on the website are documented below. You will also find, at the end of this page, a text area in which you can try out BBCodes.
EOT
);
___('bbcodes_intro',    'FR', <<<EOT
Si vous avez besoin de styliser le contenu de vos messages sur NoBleme (liens, images, texte gras, etc.), vous devrez le faire en utilisant des {{external|https://fr.wikipedia.org/wiki/BBCode|BBCodes}}. Tous les BBCodes à votre disposition sur NoBleme sont documentés ci-dessous. Vous trouverez également à la fin de cette page une zone de texte dans laquelle vous pouvez expérimenter avec les BBCodes.
EOT
);


// BBCodes table
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

___('bbcodes_doc_italics',      'EN', "[i]This text[/i] will be oblique");
___('bbcodes_doc_italics',      'FR', "[i]Ce texte[/i] sera incliné");

___('bbcodes_strike',           'EN', "Strikethrough");
___('bbcodes_strike',           'FR', "Barré");
___('bbcodes_doc_strike',       'EN', "[s]This text[/s] will be crossed off");
___('bbcodes_doc_strike',       'FR', "[s]Ce texte[/s] sera barré");

___('bbcodes_blur',             'EN', "Blurred");
___('bbcodes_blur',             'FR', "Flouté");
___('bbcodes_doc_blur',         'EN', "[blur]This is blurry[/blur], hover on it");
___('bbcodes_doc_blur',         'FR', "[blur]Ceci est flou[/blur], survolez-le");

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


// NBCodes header
___('nbcodes',          'EN', "NBCodes");
___('nbcodes',          'FR', "NBCodes");
___('nbcodes_subtitle', 'EN', "Admin only customization");
___('nbcodes_subtitle', 'FR', "Personnalisation des contenus administratifs");
___('nbcodes_intro',    'EN', <<<EOT
The tags listed in the table below can only be used by administrators, and only in specific contents where it is indicated that they are allowed. NBCodes can be used in combination with BBCodes. Visual examples will not be given, as they tend to be self explanatory.
EOT
);
___('nbcodes_intro',    'FR', <<<EOT
Les balises listées dans la table ci-dessous ne peuvent être utilisées que par l'administration, et seulement dans certains contenus où il est indiqués que les NBCodes sont autorisés. Les NBCodes peuvent être combinés avec des BBCodes. Des exemples visuels ne seront pas fournis, car les NBCodes ont un rôle simple et clair.
EOT
);


// NBCodes table
___('nbcodes_nbcode',           'EN', "NBCode");
___('nbcodes_nbcode',           'FR', "NBCode");
___('nbcodes_example',          'EN', "Example");
___('nbcodes_example',          'FR', "Exemple");

___('nbcodes_title_name',       'EN', "Title<br>Subtitle");
___('nbcodes_title_name',       'FR', "Titre<br>Sous-titre");
___('nbcodes_title_example',    'EN', "== Title ==<br>== anchor:id|Title with id ==<br>=== Subtitle ===<br>=== anchor:id|Subtitle with id ===");
___('nbcodes_title_example',    'FR', "== Titre ==<br>== anchor:id|Titre avec id ==<br>=== Sous-titre ===<br>=== anchor:id|Sous-titre avec id ===");

___('nbcodes_nsfw_name',        'EN', "Optional blur");
___('nbcodes_nsfw_name',        'FR', "Flou optionnel");
___('nbcodes_nsfw_example',     'EN', "[nsfw]Contents[/nsfw]");
___('nbcodes_nsfw_example',     'FR', "[nsfw]Contenu[/nsfw]");

___('nbcodes_nobleme_name',     'EN', "Internal link");
___('nbcodes_nobleme_name',     'FR', "Lien interne");
___('nbcodes_nobleme_example',  'EN', "[nobleme:pages/doc/bbcodes|Page name]");
___('nbcodes_nobleme_example',  'FR', "[nobleme:pages/doc/bbcodes|Nom de la page]");

___('nbcodes_page_name',        'EN', "Compendium link");
___('nbcodes_page_name',        'FR', "Lien compendium");
___('nbcodes_page_example',     'EN', "[page:page_url|Page name]");
___('nbcodes_page_example',     'FR', "[page:url_page|Nom de la page]");

___('nbcodes_link_name',        'EN', "External link");
___('nbcodes_link_name',        'FR', "Lien externe");
___('nbcodes_link_example',     'EN', "[link:example.com|External website]");
___('nbcodes_link_example',     'FR', "[link:example.com|Site externe]");

___('nbcodes_image_name',       'EN', "Compendium image<br>Blurry variant");
___('nbcodes_image_name',       'FR', "Image compendium<br>Variante floutée");
___('nbcodes_image_example',    'EN', "[image:image.png]<br>[image:image.png|left]<br>[image:image.png|right|Description]<br><br>[image-nsfw:image.png]<br>[image-nsfw:image.png|left]<br>[image-nsfw:image.png|right|Description]");
___('nbcodes_image_example',    'FR', "[image:image.png]<br>[image:image.png|left]<br>[image:image.png|right|Description]<br><br>[image-nsfw:image.png]<br>[image-nsfw:image.png|left]<br>[image-nsfw:image.png|right|Description]");

___('nbcodes_youtube_name',     'EN', "YouTube video<br>Blurry variant");
___('nbcodes_youtube_name',     'FR', "Vidéo YouTube<br>Variante floutée");
___('nbcodes_youtube_example',  'EN', "[youtube:video_id]<br>[youtube:video_id|left]<br>[youtube:video_id|right|Description]<br><br>[youtube-nsfw:video_id]<br>[youtube-nsfw:video_id|left]<br>[youtube-nsfw:video_id|right|Description]");
___('nbcodes_youtube_example',  'FR', "[youtube:video_id]<br>[youtube:video_id|left]<br>[youtube:video_id|right|Description]<br><br>[youtube-nsfw:video_id]<br>[youtube-nsfw:video_id|left]<br>[youtube-nsfw:video_id|right|Description]");

___('nbcodes_trends_name',      'EN', "Trends graph");
___('nbcodes_trends_name',      'FR', "Graphe Trends");
___('nbcodes_trends_example',   'EN', "[trends:Word]<br>[trends2:Word|Other word]<br>etc.");
___('nbcodes_trends_example',   'FR', "[trends:Mot]<br>[trends2:Mot|Autre mot]<br>etc.");

___('nbcodes_pasta_name',       'EN', "Copypasta<br>Blurry variant");
___('nbcodes_pasta_name',       'FR', "Copypasta<br>Variante floutée");
___('nbcodes_pasta_example',    'EN', "[copypasta=unique_id]Some text[/copypasta]<br>[copypasta-nsfw=unique_id]Some text[/copypasta-nsfw]");
___('nbcodes_pasta_example',    'FR', "[copypasta=id_unique]Un texte[/copypasta]<br>[copypasta-nsfw=id_unique]Un texte[/copypasta-nsfw]");

___('nbcodes_menu_name',        'EN', "Menu section<br>Menu item<br>Link anchor");
___('nbcodes_menu_name',        'FR', "Bloc menu<br>Élément de menu<br>Ancre de lien");
___('nbcodes_menu_example',     'EN', "[menu]<br>[menuitem:anchor_id|Menu entry]<br>[submenuitem:anchor_id_2|Menu entry]<br>[/menu]<br><br>[anchor:anchor_id]");
___('nbcodes_menu_example',     'FR', "[menu]<br>[menuitem:id_ancre|Élément du menu]<br>[submenuitem:id_ancre_2|Élément du menu]<br>[/menu]<br><br>[anchor:id_ancre]");

___('nbcodes_bullet_name',      'EN', "Bullet list<br>Bullet point<br>Sub bullet list<br>Sub bullet point");
___('nbcodes_bullet_name',      'FR', "Liste à puces<br>Élément de liste<br>Sous-liste à puces<br>Sous-élément de liste");
___('nbcodes_bullet_example',   'EN', "[bulletlist]<br>[bullet]List element[/bullet]<br>[subbulletlist]<br>[subbullet]Sub-element[/subbullet]<br>[/subbulletlist]<br>[/bulletlist]");
___('nbcodes_bullet_example',   'FR', "[bulletlist]<br>[bullet]Élément de liste[/bullet]<br>[subbulletlist]<br>[subbullet]Sous-élément[/subbullet]<br>[/subbulletlist]<br>[/bulletlist]");

___('nbcodes_gallery_name',      'EN', "Gallery<br>Gallery elements");
___('nbcodes_gallery_name',      'FR', "Galerie<br>Éléments de galerie");
___('nbcodes_gallery_example',   'EN', "[gallery]<br>[caption=Who]What[/caption]<br>[gallery:image.png]<br>[gallery:image.png|description]<br>[gallery-nsfw:image.png]<br>[gallery-nsfw:image.png|description]<br>[gallery-youtube:video_id]<br>[gallery-youtube:video_id|description]<br>[gallery-youtube-nsfw:video_id]<br>[gallery-youtube-nsfw:video_id|description]<br>[/gallery]");
___('nbcodes_gallery_example',   'FR', "[gallery]<br>[caption=Who]What[/caption]<br>[gallery:image.png]<br>[gallery:image.png|description]<br>[gallery-nsfw:image.png]<br>[gallery-nsfw:image.png|description]<br>[gallery-youtube:video_id]<br>[gallery-youtube:video_id|description]<br>[gallery-youtube-nsfw:video_id]<br>[gallery-youtube-nsfw:video_id|description]<br>[/gallery]");

___('nbcodes_source_name',       'EN', "Source link<br>Source reference");
___('nbcodes_source_name',       'FR', "Lien source<br>Référence source");
___('nbcodes_source_example',    'EN', "[source:1]<br>[sources:1|Source reference]");
___('nbcodes_source_example',    'FR', "[source:1]<br>[sources:1|Référence de la source]");


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
___('bbcodes_test_admin', 'EN', <<<EOT
This testing zone is for BBCodes only. NBCodes will not work here.
EOT
);
___('bbcodes_test_admin', 'FR', <<<EOT
Cette zone de test est pour les BBCodes uniquement. Les NBCodes ne fonctionneront pas ici.
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
Privacy is critical on NoBleme. If you've read the {{link|pages/doc/nobleme|website's history}}, you might understand that we stand against the modern state of the Internet, where your personal data is collected, shared, and sometimes even sold without your knowledge on nearly all websites and mobile applications.
EOT
);
___('privacy_intro_1',  'FR', <<<EOT
Le respect de votre vie privée est très important pour NoBleme. En lisant {{link|pages/doc/nobleme|l'histoire de NoBleme}}, vous comprendrez que nous sommes à l'opposé de l'état actuel d'Internet, où vos données personnelles sont collectées, partagées, et parfois même vendues sans que vous le sachiez lorsque vous utilisez la majorité des sites internet et des applications mobiles.
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
___('privacy_data_1',     'EN', <<<EOT
The most important part of online privacy is the fate of your personal data. NoBleme collects the strict minimum personal data required to properly run the website, which is not much. If you are curious about what we specifically collect about you, how long we keep it, why we need it, how we use it, where it is hosted, etc. we have a whole page of the website dedicated to it: {{link|pages/doc/data|your personal data}}.
EOT
);
___('privacy_data_1',     'FR', <<<EOT
L'aspect le plus important d'une politique de confidentialité est le destin de vos données personnelles. NoBleme ne collecte de ces données que le strict minimum requis au bon fonctionnement du site. Si vous voulez savoir ce que nous collectons exactement comme données personnelles, pendant combien de temps nous les conservons, comment nous les utilisons, pourquoi nous en avons besoin, où elles sont stockées, etc. nous avons une page entière du site dédiée à répondre à ces questions : {{link|pages/doc/data|vos données personnelles}}.
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
Toutefois, ayez conscience que l'anonymat sur Internet a ses limites. Il se peut que les forces de l'ordre nous demandent de partager des données sur nos membres dans le cadre d'une enquête, auquel cas nous n'aurions d'autre choix que de partager le peu de données personnelles que nous avons à votre sujet. Cela signifie que l'anonymat sur NoBleme (et ailleurs) protège votre identité réelle face aux autres membres du site, mais ne vous protège pas des conséquences d'actions illégales que vous pourriez réaliser.
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
Tout NoBleme est fabriqué à la main, sur mesure, avec amour. Le site n'utilise aucun script ou logiciel tiers. La plupart des sites Internet se servent de scripts externes pour la publicité, faire des statistiques, traquer les données privées, mais vu que nous ne faisons aucune de ces choses nous n'avons aucun besoin de partager vos données avec des tiers. C'est pour cela que vous n'avez pas eu de bannière vous demandant votre consentement pour utiliser vos cookies comme vous pouvez en trouver sur les autres sites : nous n'avons pas besoin de vous faire consentir au partage de vos données avec des tiers vu que nous ne le faisons pas.
EOT
);
___('privacy_external_2',     'EN', <<<EOT
There is however one area of NoBleme which contains third party content. For the purpose of documenting Internet culture, the {{link|pages/compendium/index|21st century compendium}} embeds external content in some of its pages (YouTube videos and Google Trends graphs). In order to minimize the potential for these third parties to do something nefarious with your data, we try to use as few of them as possible.
EOT
);
___('privacy_external_2',     'FR', <<<EOT
Il y a toutefois une partie de NoBleme où se trouvent des contenus tiers. Dans le {{link|pages/compendium/index|compendium du 21ème siècle}}, certaines pages incluent des contenus externes, qui servent d'illustration (des vidéos YouTube et des graphes Google Trends). Afin de minimiser le potentiel de collecte de vos données personnelles par ces tiers, nous en utilisons le plus petit nombre possible.
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
___('privacy_agreement_title',  'FR', "Contrat d'utilisation");
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
Sachez tout de même que les contrats d'utilisation ne concernent que les disputes légales, et n'ont donc aucun impact sur l'administration interne de NoBleme. Même si vous ne l'avez pas expressément accepté, vous restez sous la gouverne de notre simple et court {{link|pages/doc/coc|code de conduite}}, et nous gardons le droit de vous exclure de NoBleme si vous ne le respectez pas.
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
You can read more about the decision to open NoBleme's source code {{link|pages/doc/dev|behind the scenes}}.
EOT
);
___('privacy_source_2',     'FR', <<<EOT
Vous trouverez plus d'informations sur la décision de publier le code source dans les {{link|pages/doc/dev|coulisses de NoBleme}}.
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
NoBleme est basé et hébergé en France, par conséquent les lois françaises et européennes sur la propriété intellectuelle s'appliquent à tout contenu créatif et/ou original crée par ou pour NoBleme. Tout contenu tiers (qui n'est pas crée par ou pour NoBleme) appartient à ses créateurs et/ou aux détenteurs de leurs droits, par conséquent des droits internationaux de propriété intellectuelle peuvent s'appliquer à certains contenus de NoBleme. Si des contenus sur lesquels vous avez des droits ou représentez les détenteurs de droits sont utilisés sur NoBleme sans votre permission, effectuez une réclamation via le {{link|pages/messages/admins|formulaire de contact administratif}} - assurez-vous d'inclure une preuve de vos droits - et votre requête sera traitée au plus vite.
EOT
);


// Responsibility
___('legal_responsibility_title', 'EN', "Responsibility over user submitted content");
___('legal_responsibility_title', 'FR', "Responsabilité sur les contenus");
___('legal_responsibility_body',  'EN', <<<EOT
As it is free for anyone to create an account on NoBleme, and as moderation of user submitted content happens only after said content has been submitted on the website, we can not be held responsible for the content being submitted by users on the website until we see them. However, we have a clear {{link|pages/doc/coc|code of conduct}} which we expect both our users and ourselves to follow. Any content which goes against this code of conduct will be deleted as soon as possible, in a <span class="italics">best effort</span> manner, depending on the availability of our administrative team. Any users which go against this code of conduct will find themselves temporarily or permanently excluded from submitting content to NoBleme, preventing further abuse.
EOT
);
___('legal_responsibility_body',  'FR', <<<EOT
Vu que créer un compte sur NoBleme est gratuit, et vu que la modération des contenus partagés par les membres du site a lieu à postériori, nous ne pouvons pas être responsables des contenus partagés par les membres avant d'en avoir pris connaissance. Toutefois, nous avons un {{link|pages/doc/coc|code de conduite}} clair que tous les membres sont tenus de respecter - l'équipe administrative incluse. Tout contenu allant à l'encontre de ce code de conduite sera supprimé au plus vite, selon la disponibilité de l'équipe administrative. Tout membre allant à l'encontre de ce code de conduite se verra privé de façon temporaire ou permanente de la possibilité de partager du contenu sur NoBleme.
EOT
);


// User content
___('legal_user_content_title', 'EN', "Intellectual property rights over user submitted content");
___('legal_user_content_title', 'FR', "Propriété intellectuelle sur les contenus");
___('legal_user_content_body',  'EN', <<<EOT
Any time you submit your own creative and/or original content on NoBleme, you implicitly authorize NoBleme to reuse this content within the boundaries of the website or any other platform belonging to NoBleme, and authorize other users of the website to quote the content that you posted. However, as the author of these creative and/or original works, you automatically gain the ownership of the full intellectual property rights on any of those works by submitting them to NoBleme. This means that NoBleme does not own the right to reuse, distribute, or monetize your works in any way of form without your authorization. We respect ownership.
EOT
);
___('legal_user_content_body',  'FR', <<<EOT
En publiant du contenu original sur NoBleme, vous autorisez implicitement à titre gracieux leur reproduction et diffusion sur le reste de NoBleme et sur les autres plateformes appartenant à NoBleme, et autorisez les autres membres de NoBleme à citer vos contenus sur le reste de NoBleme. Toutefois, en tant qu'auteur de tout contenu original que vous publiez sur NoBleme, vous en conservez la propriété intellectuelle et les droits d'auteur assortis. NoBleme s'engage par conséquent à ne pas publier hors du site sans votre permission et à ne pas monétiser les contenus originaux que vous publiez sur le site. Nous respectons entièrement vos droits d'auteur et ne nous donnons pas les pouvoirs requis pour en prendre le contrôle.
EOT
);


// Fair use
___('legal_fair_title', 'EN', "Fair use of third party content");
___('legal_fair_title', 'FR', "Usage loyal de contenus tiers");
___('legal_fair_body',  'EN', <<<EOT
Some third party content might be used on NoBleme for educative or encyclopedic purposes, mainly in the {{link|pages/compendium/index|21st century compendium}}. For these use cases, credit will be given to the original author when possible. In some cases, due to the anonymous nature of many Internet platforms, it is hard or even impossible to find and credit the author of some original creative works. If you can demonstrate ownership of a piece of creative work hosted on NoBleme over which you hold intellectual property rights, use our {{link|pages/messages/admins|administrative contact form}} to make your request and it will be removed as soon as possible.
EOT
);
___('legal_fair_body',  'FR', <<<EOT
Certains contenus tiers sont utilisés sur NoBleme à titre pédagogique ou encyclopédique, principalement dans le {{link|pages/compendium/index|compendium du 21ème siècle}}. Dans ces cas, nous nous efforçons de créditer les auteurs de ces contenus. Malheureusement, de par la nature anonyme et chaotique d'Internet, il n'est pas toujours possible d'identifier l'auteur de contenus créatifs. Si vous pouvez démontrer que vous êtes à l'origine d'un contenu tiers hébergé sur NoBleme et que vous désirez vous faire créditer ou demander la suppression de ce contenu, utilisez notre {{link|pages/messages/admins|formulaire de contact administratif}} pour formuler votre requête, qui sera traitée dès que possible.
EOT
);


// Source code
___('legal_source_title', 'EN', "Using NoBleme's source code");
___('legal_source_title', 'FR', "Utiliser le code source de NoBleme");
___('legal_source_body',  'EN', <<<EOT
As stated {{link|pages/doc/dev|behind the scenes}}, NoBleme's source code has been open sourced - thus made available to the general public. However, please take note that open sourced does not necessarily mean free to re-use for your own projects. In NoBleme's case, it has been open sourced under the very permissive {{external|https://en.wikipedia.org/wiki/MIT_License|MIT license}}, which means that you are free to use any or all of NoBleme's source code in your own projects as long as you properly credit its author by including a copy of the permission notice included in NoBleme's licence in your own source code - along with the copyright notice: <span class="italics">Copyright (c) 2005 Eric Bisceglia / NoBleme.com</span>.
EOT
);
___('legal_source_body',  'FR', <<<EOT
Comme expliqué dans les {{link|pages/doc/dev|coulisses de NoBleme}}, le code source de NoBleme a été <span class="italics">open sourcé</span> - c'est à dire publié intégralement et publiquement. Notez toutefois que <span class="italics">open source</span> ne signifie pas libre de droit. Dans le cas de NoBleme, le code source a été publié sous la très permissive {{external|https://fr.wikipedia.org/wiki/Licence_MIT|licence MIT}}, ce qui signifie que vous êtes libre de réutiliser une partie du code source ou même tout le code source de NoBleme dans vos propres projets, à condition de correctement en créditer l'auteur d'origine en incluant une copie de la <span class="italics">permission notice</span> incluse dans la licence se trouvant dans le code source de NoBleme - ainsi que la <span class="italics">copyright notice</span> suivante : <span class="italics">Copyright (c) 2005 Eric Bisceglia / NoBleme.com</span>.
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
Nous utilisons les adresses IP pour différencier les personnes sur {{link|pages/users/online|qui est en ligne}}, ainsi que pour conserver les tentatives de connexions aux comptes afin de prévenir le {{external|https://fr.wikipedia.org/wiki/Attaque_par_force_brute|bruteforcing}} des mots de passe. Votre adresse IP n'est pas utilisée pour traquer votre activité sur le site, et n'apparait que dans des logs qui sont supprimés au bout d'un mois. Nous n'avons aucun intérêt à traquer l'activité des personnes sans compte à part pour préserver la sécurité des comptes.
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
Do note that only your <span class="bold">latest</span> IP address is kept in our database. If it changes, your previous IP address will immediately be deleted. We have no interest in logging your IP history. As outlined in our {{link|pages/doc/privacy|privacy policy}}, we strongly believe in your right to remain anonymous.
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
NoBleme n'a aucun intérêt à conserver les données de langue des personnes sans compte. Par conséquent, cette information est stockée sur votre ordinateur/appareil plutôt que sur NoBleme.
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
Conserver votre choix de langue nous permet de toujours afficher NoBleme dans la langue de votre choix, même si vous changez d'ordinateur/appareil. Cette information ne sera jamais affichée publiquement, c'est à vous de décider si vous désirez afficher votre langue sur votre {{link|pages/users/profile_edit|profil public}}.
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
Nous espérons que vous appréciez le respect que nous portons à votre vie privée, et que vous verrez le message que cela implique: le bon fonctionnement d'un site Internet ne dépend pas de la collecte, du partage, ou de la vente des données pesonnelles des pesonnes qui l'utilisent. C'est un choix délibéré que font la majorité des autres sites et applications.
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 BEHIND THE SCENES                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('doc_bts_subtitle', 'EN', "NoBleme's design choices and development methods");
___('doc_bts_subtitle', 'FR', "Design de NoBleme et méthodes de développement");
___('doc_bts_intro',    'EN', <<<EOT
NoBleme is a fully handcrafted website, developed entirely from scratch by Eric B. (known online as {{link|pages/users/1|Bad}}). Ever since its launch in 2005, NoBleme's policy on development has been to be as public as possible: its {{external|https://github.com/EricBisceglia/NoBleme.com|source code}} is publicly available, its {{link|pages/tasks/roadmap|roadmap}} allows you to follow the development progress, {{link|pages/dev/blog_list|devblogs}} keep you updated on what is going on, and this very page does its best to explain which philosophies and technologies are used in NoBleme's development.
EOT
);
___('doc_bts_intro',    'FR', <<<EOT
NoBleme est un site fabriqué artisanalement à partir de rien, développé intégralement par Eric B. (utilisant sur Internet le pseudonyme {{link|pages/users/1|Bad}}). Depuis sa création en 2005, le développement de NoBleme a toujours été délibérément aussi public que possible : le {{external|https://github.com/EricBisceglia/NoBleme.com|code source}} est disponible publiquement, le {{link|pages/tasks/roadmap|plan de route}} vous permet de suivre le progrès, les {{link|pages/dev/blog_list|devblogs}} vous tiennent à jour, et cette page vous explique les philosophies et technologies utilisées dans le développement de NoBleme.
EOT
);


// Creed
___('doc_bts_creed_title',  'EN', "The creed of NoBleme's design");
___('doc_bts_creed_title',  'FR', "Les convictions du design de NoBleme");
___('doc_bts_creed_intro',  'EN', <<<EOT
When working on content or features for NoBleme, the following guidelines are always taken into account in order to achieve the best possible and most inclusive user experience.
EOT
);
___('doc_bts_creed_intro',  'FR', <<<EOT
En travaillant sur du contenu pour NoBleme, les lignes directrices ci-dessous sont toujours prises en considération afin que le résultat soit autant que possible inclusif et agréable à utiliser.
EOT
);
___('doc_bts_creed_1',      'EN', <<<EOT
<span class="bold text_red">Free to use and ad-free:</span> The Internet is a wonderful place for creativity and self expression, hijacked in far too many places by advertisements, sponsored content, and begging for money. In NoBleme's case, the website shall forever remain free to use and ad-free. The running costs are entirely covered and budgetted for. NoBleme is a passion project. I do not accept donations. Just enjoy the service.
EOT
);
___('doc_bts_creed_1',      'FR', <<<EOT
<span class="bold text_red">Gratuit et sans publicités :</span> Internet est un lieu merveilleux pour la créativité et l'expression, pollué par les publicités, le contenu sponsorisé, et les demandes de financement. Dans le cas de NoBleme, le site restera toujours gratuit à utiliser et libre de toute publicité. Les coûts d'exploitation sont connus à l'avance et budgétisés. NoBleme est une œuvre de passion. Je n'accepte pas les donations.
EOT
);
___('doc_bts_creed_2',      'EN', <<<EOT
<span class="bold text_red">Privacy oriented:</span> As stated in our {{link|pages/doc/privacy|privacy policy}}, we highly respect your privacy and your right to stay anonymous if you desire. As you can see in {{link|pages/doc/data|your personal data}}, we only collect the strict minimum amount of personal data required to run the website, and will never share or sell it to third parties.
EOT
);
___('doc_bts_creed_2',      'FR', <<<EOT
<span class="bold text_red">Respect de la vie privée :</span> Comme précisé dans notre {{link|pages/doc/privacy|politique de confidentialité}}, nous respectons fortement votre vie privée et votre droit de rester anonyme si vous le désirez. Comme précisé dans {{link|pages/doc/data|vos données personnelles}}, nous ne collectons que le strict minimum de données requises au bon fonctionnement du site, et ne partagerons ou vendrons jamais à des tiers vos données personnelles.
EOT
);
___('doc_bts_creed_3',      'EN', <<<EOT
<span class="bold text_red">Consider all user experiences:</span> {{external|https://en.wikipedia.org/wiki/Dark_pattern|Dark patterns}} are strictly prohibited. All of NoBleme's content is tested not only on a desktop computer, but also simulated as being viewed on several different mobile phones and tablets. Screen readers for visually impaired people are also taken into account. While it is impossible to guarantee the best user experience on all devices, all of them should be considered when designing pages.
EOT
);
___('doc_bts_creed_3',      'FR', <<<EOT
<span class="bold text_red">Multiplicité des expériences d'utilisation:</span> Les {{external|https://fr.wikipedia.org/wiki/Dark_pattern|dark patterns}} sont strictement interdits. Tout le contenu de NoBleme doit être testé sur un ordinateur fixe, mais doit également être testé via simulateur comme étant utilisé sur divers appareils mobiles, smartphones, tablettes. Les lecteurs d'écran pour personnes malvoyantes doivent également être pris en compte. Il est impossible de garantir la meilleure expérience possible sur tous les appareils, mais ils doivent au moins tous être pris en compte lors des phases de design et de test.
EOT
);
___('doc_bts_creed_4',      'EN', <<<EOT
<span class="bold text_red">Educational transparency:</span> The role of a developer is not just to write code, it is also to share knowledge with other developers, so that we might all become collectively better at our craft. NoBleme's source code should always be heavily commented, to the extent that one should be able to understand what is going on in a source code file even without knowledge of the programming languages being used.
EOT
);
___('doc_bts_creed_4',      'FR', <<<EOT
<span class="bold text_red">Transparence et éducation :</span> Développer n'est pas juste écrire du code, c'est aussi partager ses connaissances avec les autres, afin de tous progresser collectivement dans notre métier et notre artisanat. Le code source de NoBleme doit toujours être lourdement commenté, au point où vous devriez arriver à comprendre la logique d'un fichier source même sans connaître les langages de programmation utilisés.
EOT
);
___('doc_bts_creed_5',      'EN', <<<EOT
<span class="bold text_red">Gender neutrality:</span> Every piece of text on NoBleme should be gender neutral. The default pronoun in use should be `they`, unless referring to specific people. Neutral forms are preferred for traditionally gendered nouns (eg. mailperson over mailman).
EOT
);
___('doc_bts_creed_5',      'FR', <<<EOT
<span class="bold text_red">Neutralité de genre :</span> Tout le contenu écrit pour NoBleme doit être non genré. Les variantes d'écriture inclusive (il·elle, ielle, etc.) ne prennent pas en compte les personnes non binaires, il faut donc aller plus loin encore et toujours privilégier les formes neutres (l'équipe d'administration plutôt que les administrateur·e·s, les personnes utilisant le site plutôt que les utilisateurices, etc.). Croyez-le ou non, le français est parfaitement compatible avec le neutre, il suffit de regarder la grande quantité de contenus écrits pour NoBleme !
EOT
);
___('doc_bts_creed_6',      'EN', <<<EOT
<span class="bold text_red">Sensitivity:</span> When writing text for NoBleme, a conscious effort should always be made to mind the sensitivities of potential readers. This goes further than simply not using slurs: common triggering topics should ideally be avoided, or at least preceded by a warning, and an effort in educating oneself on any sensitive topics (race, identity, politics, mental health, etc.) should always be done before writing about them.
EOT
);
___('doc_bts_creed_6',      'FR', <<<EOT
<span class="bold text_red">Respect des sensibilités :</span> Toute écriture de contenus pour NoBleme doit inclure un effort conscient pour prendre en compte la sensibilité des personnes qui les liront. Cela va plus loin que de juste utiliser un vocabulaire propre : les contenus potentiellement traumatisants sont idéalement à éviter, sinon à précéder d'un avertissement, et un réel effort de recherche doit être fait pour s'éduquer sur les sujets sensibles (race, identité, politique, santé mentale, etc.) avant d'écrire des textes qui en parlent.
EOT
);


// Stack
___('doc_bts_stack_title',    'EN', "NoBleme's technological stack");
___('doc_bts_stack_title',    'FR', "Technologies utilisées sur NoBleme");
___('doc_bts_stack_intro',    'EN', "Here is the exhaustive list of all applications, services, and technologies used in the process of developing, maintaining, and administrating NoBleme:");
___('doc_bts_stack_intro',    'FR', "Voici la liste exhaustive des applications, services, et technologies utilisés dans le processus de développement, de maintenance, et d'administration de NoBleme :");
___('doc_bts_stack_domain',   'EN', "The domain name (nobleme.com) is registered on {{external|https://www.ovh.com/|OVH}}");
___('doc_bts_stack_domain',   'FR', "Le nom de domaine (nobleme.com) est enregistré sur {{external|https://www.ovh.com/|OVH}}");
___('doc_bts_stack_server',   'EN', "The web server is hosted by {{external|https://www.ovh.com/|OVH}} and runs {{external|https://en.wikipedia.org/wiki/Fedora_Linux|Fedora Linux}}");
___('doc_bts_stack_server',   'FR', "Le serveur est hébergé chez {{external|https://www.ovh.com/|OVH}} et utilise {{external|https://fr.wikipedia.org/wiki/Fedora_Linux|Fedora Linux}}");
___('doc_bts_stack_http',     'EN', "Web pages are delivered by an {{external|https://en.wikipedia.org/wiki/Apache_HTTP_Server|Apache HTTP server}}");
___('doc_bts_stack_http',     'FR', "Les pages du site sont servies par un {{external|https://fr.wikipedia.org/wiki/Apache_HTTP_Server|serveur HTTP Apache}}");
___('doc_bts_stack_database', 'EN', "The website's database uses {{external|https://en.wikipedia.org/wiki/MySQL|MySQL}}");
___('doc_bts_stack_database', 'FR', "La base de données du site utilise {{external|https://fr.wikipedia.org/wiki/MySQL|MySQL}}");
___('doc_bts_stack_back',     'EN', "The {{external|https://en.wikipedia.org/wiki/Front_end_and_back_end|back end}} is coded entirely in pure {{external|https://en.wikipedia.org/wiki/Procedural_programming|procedural}} {{external|https://en.wikipedia.org/wiki/PHP|PHP}}, with no {{external|https://en.wikipedia.org/wiki/Software_framework|framework}}");
___('doc_bts_stack_back',     'FR', "Le {{external|https://fr.wikipedia.org/wiki/Backend|back end}} du site est codé entièrement en {{external|https://fr.wikipedia.org/wiki/PHP|PHP}} {{external|https://fr.wikipedia.org/wiki/Programmation_proc%C3%A9durale|procédural}}, sans {{external|https://fr.wikipedia.org/wiki/Framework|framework}}");
___('doc_bts_stack_front',    'EN', "The {{external|https://en.wikipedia.org/wiki/Front_end_and_back_end|front end}} is {{external|https://en.wikipedia.org/wiki/HTML|HTML}}, styled with {{external|https://en.wikipedia.org/wiki/CSS|CSS}}, dynamized with vanilla {{external|https://en.wikipedia.org/wiki/JavaScript|JavaScript}}");
___('doc_bts_stack_front',    'FR', "Le {{external|https://fr.wikipedia.org/wiki/D%C3%A9veloppement_web_frontal|front}} est du {{external|https://fr.wikipedia.org/wiki/HTML|HTML}}, stylé avec du {{external|https://fr.wikipedia.org/wiki/CSS|CSS}}, et dynamisé avec du {{external|https://en.wikipedia.org/wiki/JavaScript|JavaScript}}");
___('doc_bts_stack_images',   'EN', "Some of the icons used on the website come from {{external|https://feathericons.com/|Feather}}");
___('doc_bts_stack_images',   'FR', "Certaines des icônes utilisées viennent de {{external|https://feathericons.com/|Feather}}");
___('doc_bts_stack_machine',  'EN', "My development machine runs {{external|https://en.wikipedia.org/wiki/Microsoft_Windows|Windows}} and emulates the stack using {{external|https://www.wampserver.com/|WampServer}}");
___('doc_bts_stack_machine',  'FR', "Mon ordinateur de développement utilise {{external|https://fr.wikipedia.org/wiki/Microsoft_Windows|Windows}} et émule la production avec {{external|https://www.wampserver.com/|WampServer}}");
___('doc_bts_stack_editor',   'EN', "I use {{external|https://code.visualstudio.com/|VSCode}} as my text editor when writing the source code");
___('doc_bts_stack_editor',   'FR', "J'utilise {{external|https://code.visualstudio.com/|VSCode}} comme éditeur de texte pour écrire le code source");
___('doc_bts_stack_git',      'EN', "{{external|https://en.wikipedia.org/wiki/Software_versioning|Versioning}} is done in a {{external|https://en.wikipedia.org/wiki/Git|Git}} repository which is published on {{external|https://github.com/EricBisceglia/NoBleme.com|GitHub}}");
___('doc_bts_stack_git',      'FR', "Le {{external|https://fr.wikipedia.org/wiki/Gestion_de_versions|versionnage}} se fait dans un dépôt {{external|https://fr.wikipedia.org/wiki/Git|Git}} qui est publié sur {{external|https://github.com/EricBisceglia/NoBleme.com|GitHub}}");
___('doc_bts_stack_shell',    'EN', "The shells I use are {{external|https://github.com/microsoft/terminal|Windows Terminal}} and {{external|https://gitforwindows.org/|Git for Windows}}");
___('doc_bts_stack_shell',    'FR', "Les terminaux que j'utilise sont {{external|https://github.com/microsoft/terminal|Windows Terminal}} et {{external|https://gitforwindows.org/|Git pour Windows}}");


// Source code
___('doc_bts_source_title', 'EN', "NoBleme's source code");
___('doc_bts_source_title', 'FR', "Code source de NoBleme");
___('doc_bts_source_1',     'EN', <<<EOT
The entirety of NoBleme's source code has been publicly open sourced: {{external|https://github.com/EricBisceglia/NoBleme.com|NoBleme on Github}}.
EOT
);
___('doc_bts_source_1',     'FR', <<<EOT
L'intégralité du code source de NoBleme est disponible publiquement : {{external|https://github.com/EricBisceglia/NoBleme.com|NoBleme sur Github}}.
EOT
);
___('doc_bts_source_2',     'EN', <<<EOT
Reasons for open sourcing NoBleme include transparency (allowing you to check that our {{link|pages/doc/privacy|privacy policy}} contains no lies), education (allowing you to satisfy your curiosity about how things work), security (allowing everyone to help in finding bugs and vulnerabilities on the website), and personal convictions (leading by example - I believe open sourcing should be the norm and not the exception).
EOT
);
___('doc_bts_source_2',     'FR', <<<EOT
Les raisons derrière l'ouverture au public du code source de NoBleme sont la transparence (vous permettre de vérifier que ce que nous affirmons dans notre {{link|pages/doc/privacy|politique de confidentialité}} est vrai), l'éducation (satisfaire votre curiosité quant au fonctionnement interne du site), la sécurité (donner à un plus grand nombre de personnes la possibilité de trouver des bugs ou des vulnérabilités sur le site), et des convictions personnelles (mener par l'exemple - l'open source devrait être la norme et non l'exception).
EOT
);
___('doc_bts_source_3',     'EN', <<<EOT
NoBleme's source code is protected by the very permissive {{external|https://en.wikipedia.org/wiki/MIT_License|MIT license}}, which allows you to use any piece of code from NoBleme in your own projects without asking for permission first. The only condition is to properly credit NoBleme when reusing some of its code - as outlined in the {{external|https://github.com/EricBisceglia/NoBleme.com/blob/develop/LICENSE.md|LICENSE.MD}} file and in our {{link|pages/doc/legal|legal notice}}.
EOT
);
___('doc_bts_source_3',     'FR', <<<EOT
Le code source de NoBleme est protégé par la très permissive {{external|https://fr.wikipedia.org/wiki/Licence_MIT|licence MIT}}, qui vous autorise à réutiliser le code source de NoBleme dans vos propres projets sans avoir à demander la permission. La seule condition est de créditer NoBleme lorsque vous réutilisez du code qui en est issu - comme précisé dans {{external|https://github.com/EricBisceglia/NoBleme.com/blob/develop/LICENSE.md|LICENSE.MD}} et dans nos {{link|pages/doc/legal|mentions légales}}.
EOT
);
___('doc_bts_source_4',     'EN', <<<EOT
As the website has been started in 2005, and despite a few major rewrites, the way the website is coded might seem "old fashioned": all of the source code follows a {{external|https://en.wikipedia.org/wiki/Procedural_programming|procedural paradigm}} (there are no objects or classes). Despite this approach, and despite using technologies which often get labeled as "outdated" (PHP, MySQL), NoBleme's source code uses the latest versions available of every technology in its stack, respects modern standards, and keeps evolving over time.
EOT
);
___('doc_bts_source_4',     'FR', <<<EOT
Vu que NoBleme existe depuis 2005, et malgré quelques refontes intégrales du site, la façon dont le code source de NoBleme est structuré peut sembler « antique » : toute la logique du code est {{external|https://fr.wikipedia.org/wiki/Programmation_proc%C3%A9durale|procédurale}} (sans objets ni classes). Malgré cette approche, et malgré l'utilisation de technologies qui sont souvent considérées comme « dépassées » (PHP, MySQL), le code source de NoBleme utilise les dernières versions à jour de chaque technologie utilisée, respecte les standards modernes, et évolue avec son temps.
EOT
);
___('doc_bts_source_5',     'EN', <<<EOT
Every file in the source code is heavily commented, to the point where you should be able to understand what is going on in the codebase even if you're not familiar with the languages used. The {{external|https://github.com/EricBisceglia/NoBleme.com/blob/develop/README.md|README.MD}} file explains how the codebase is structured, aswell as how to install a local copy of NoBleme.
EOT
);
___('doc_bts_source_5',     'FR', <<<EOT
Tous les fichiers du code source de NoBleme sont lourdement commentés, au point où vous devriez pouvoir comprendre leur logique même si vous ne connaissez pas les langages de programmation utilisés. Le {{external|https://github.com/EricBisceglia/NoBleme.com/blob/develop/README.md|README.MD}} explique la structure de l'arborescence des fichiers, ainsi que comment installer une copie locale de NoBleme sur votre machine.
EOT
);


// Contributing
___('doc_bts_contributing_title', 'EN', "Contributing to NoBleme's source code");
___('doc_bts_contributing_title', 'FR', "Contribuer au code source de NoBleme");
___('doc_bts_contributing_body',  'EN', <<<EOT
NoBleme is open to contributions, as stated in {{external|https://github.com/EricBisceglia/NoBleme.com/blob/develop/CONTRIBUTING.md|CONTRIBUTING.MD}}. Bug fixes should be submitted as a pull request on the `develop` branch of the repository. If you spot a bug but don't want to fix it or can't be bothered doing a pull request, that's perfectly fine: please use our {{link|pages/tasks/proposal|bug report form}} instead. For any bigger contributions (refactoring, features), please discuss it on the <span class="bold">#dev</span> channel of {{link|pages/social/irc|NoBleme's IRC server}} before getting started.
EOT
);
___('doc_bts_contributing_body',  'FR', <<<EOT
Comme précisé dans {{external|https://github.com/EricBisceglia/NoBleme.com/blob/develop/CONTRIBUTING.md|CONTRIBUTING.MD}}, NoBleme accepte et encourage les contributions à son code source. Toute contribution doit être faite en anglais. Les correctifs de bugs doivent être soumis sous forme de pull request sur la branche `develop` du dépôt. Si vous avez repéré un bug mais n'avez pas envie de le corriger, ça me va très bien : utilisez notre {{link|pages/tasks/proposal|formulaire de rapport de bug}}. Pour toute contribution plus grosse (refactoring, feature), discutez-en sur le canal <span class="bold">#dev</span> du {{link|pages/social/irc|serveur IRC NoBleme}} avant de commencer.
EOT
);