<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    QUOTE  LIST                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('quotes_subtitle',      'EN', "Words from NoBleme");
___('quotes_subtitle',      'FR', "Paroles de NoBleme");
___('quotes_header_intro',  'EN', <<<EOT
Sometimes, funny conversations or monologues happen on NoBleme, mostly on our {{link|todo_link|IRC chat server}}. This page aims at preserving them for posterity. You will find all of our quotes below, presented to you in reverse chronological order. We have quality guidelines in place: we'd rather have a few great quotes than a lot of average ones, and we'd rather laugh with people than laugh at people. If you witness a conversation on NoBleme worthy of joining this collection, you can {{link|todo_link|submit a quote proposal}}.
EOT
);
___('quotes_header_intro',  'FR', <<<EOT
Parfois, des conversations ou monologues amusants ont lieu sur NoBleme, principalement sur notre {{link|todo_link|serveur de chat IRC}}. Cette page a pour but de les conserver pour la postérité. Vous trouverez toutes les citations ci-dessous, présentées dans l'ordre antéchronologique. Des consignes de qualité sont appliquées : nous préférons avoir un petit nombre de citations drôles plutôt qu'un grand nombre de citations bof, et nous préférons rire avec les gens que rire des gens. Si vous êtes témoin d'une conversation sur NoBleme qui mérite d'être immortalisée sur cette page, vous pouvez {{link|todo_link|proposer une citation}}.
EOT
);
___('quotes_header_blur',   'EN', <<<EOT
Some of the quotes are blurred <span class="blur">like this</span> as they contain crude or sensitive content. You can read them by hovering your pointer over them. If you are bothered by the blurring or feel like you don't need it, you can permanently disable it in your account's {{link|pages/account/settings_nsfw|adult content options}}.
EOT
);
___('quotes_header_blur',   'FR', <<<EOT
Certaines citations sont floutées <span class="blur">comme ceci</span> car elles contiennent des propos vulgaires ou sensibles. Vous pouvez révéler leur contenu en passant votre curseur dessus. Si le floutage vous embête ou si vous n'en avez pas besoin, vous pouvez le désactiver de façon permanente dans vos {{link|pages/account/settings_nsfw|options de vulgarité}}.
EOT
);


// List
___('quotes_blur',    'EN', <<<EOT
This quote is blurred as it contains crude or sensitive content. You can read it by hovering your pointer over the text. If you are bothered by the blurring or feel like you don't need it, you can permanently disable it in your account's {{link|pages/account/settings_nsfw|adult content options}}.
EOT
);
___('quotes_blur',    'FR', <<<EOT
Cette citation est floutée car elle contient des propos vulgaires ou sensibles. Vous pouvez révéler son contenu en passant votre curseur dessus. Si le floutage vous embête ou si vous n'en avez pas besoin, vous pouvez le désactiver de façon permanente dans vos {{link|pages/account/settings_nsfw|options de vulgarité}}.
EOT
);
___('quotes_count',   'EN', "NoBleme's {{1}} quote:");
___('quotes_count',   'FR', "{{1}} citation NoBlemeuse :");
___('quotes_count+',  'EN', "NoBleme's {{1}} quotes:");
___('quotes_count+',  'FR', "{{1}} citations NoBlemeuses :");
___('quotes_id',      'EN', "Quote #{{1}}");
___('quotes_id',      'FR', "Citation #{{1}}");
___('quotes_nodate',  'EN', "Quote date unknown (before 2012)");
___('quotes_nodate',  'FR', "Date inconnue (avant 2012)");