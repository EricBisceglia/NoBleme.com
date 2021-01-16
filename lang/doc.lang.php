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

___('bbcodes_youtube',          'EN', "Youtube video");
___('bbcodes_youtube',          'FR', "Vidéo Youtube");
___('bbcodes_doc_youtube',      'EN', "You need to find the video's ID");
___('bbcodes_doc_youtube',      'FR', "Vous devez trouver l'ID de la vidéo");
___('bbcodes_doc_youtube_vid',  'EN', "[youtube]4o5baMYWdtQ[/youtube]");
___('bbcodes_doc_youtube_vid',  'FR', "[youtube]4o5baMYWdtQ[/youtube]");


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

[align=right][youtube]q6EoRBvdVPQ[/youtube][/align]
EOT
);
___('bbcodes_test_input', 'FR', <<<EOT
[s][b][i][color=orange][size=2]BBCodes combinés[/size][/color][/i][/b][/s]

[spoiler][spoiler=Encore un][spoiler=Le dernier][quote][code]Divulgâchages encastrés[/code][/quote][/spoiler][/spoiler][/spoiler]

[align=right][youtube]q6EoRBvdVPQ[/youtube][/align]
EOT
);