<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      COMMON                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Title
___('api_title', 'EN', "API");
___('api_title', 'FR', "API");


// Technical terms
___('api_parameters',       'EN', "Parameters");
___('api_parameters',       'FR', "Paramètres");
___('api_optional',         'EN', "optional");
___('api_optional',         'FR', "optionnel");
___('api_response_schema',  'EN', "Response schema");
___('api_response_schema',  'FR', "Schéma de la réponse");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       INTRO                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Menu & header
___('api_intro_menu',   'EN', "Introduction");
___('api_intro_menu',   'FR', "Introduction");


// Introduction
___('api_intro_title',  'EN', "NoBleme API");
___('api_intro_title',  'FR', "API NoBleme");
___('api_intro_body_1', 'EN', <<<EOD
An API ({{external_popup|https://en.wikipedia.org/wiki/API|Application Programming Interface}}) is a tool which allows developers to create their own third party software that interacts with an application. In NoBleme's case, it means that you can use its API to build custom applications which interact with the website.
EOD
);
___('api_intro_body_1', 'FR', <<<EOD
Une API ({{external_popup|https://fr.wikipedia.org/wiki/API|Application Programming Interface}}) est un outil permettant à des personnes de créer leurs propres logiciels tiers qui interagissent avec une application. Dans le cas de NoBleme, cela signifie que vous pouvez utiliser son API pour créer vos propres applications capables d'interagir avec le site.
EOD
);
___('api_intro_body_2', 'EN', <<<EOD
If you did not already know what an API is, then this part of the website is most likely not for you. It will only be of interest for people who have programming skills and want to create third party tools for NoBleme.
EOD
);
___('api_intro_body_2', 'FR', <<<EOD
Si vous ne saviez pas déjà ce qu'est une API, cette section de NoBleme n'est probablement pas faite pour vous. Elle ne sera pertinente que pour les personnes ayant des compétences en programmation et souhaitant créer des outils tiers pour NoBleme.
EOD
);


// Usage and limitations
___('api_intro_usage_title',  'EN', "Usage and limitations");
___('api_intro_usage_title',  'FR', "Utilisation et limites");
___('api_intro_usage_body_1', 'EN', <<<EOD
Every route in NoBleme's API must be queried using an URL beginning with {{external|{{1}}api/|{{1}}api/}}
EOD
);
___('api_intro_usage_body_1', 'FR', <<<EOD
Toutes les routes de l'API NoBleme doivent être utilisées via une URL commençant par {{external|{{1}}api/|{{1}}api/}}
EOD
);
___('api_intro_usage_body_2', 'EN', <<<EOD
NoBleme's API provides access to a limited number of website features. The complete documentation of all existing routes and their behaviors can be found through the dropdown menu at the top of the page.
EOD
);
___('api_intro_usage_body_2', 'FR', <<<EOD
L'API de NoBleme permet d'accéder à un nombre limité de fonctionnalités du site. La documentation complète de toutes les routes et de leurs comportements est accessible via le menu déroulant en haut de la page.
EOD
);
___('api_intro_usage_body_3', 'EN', <<<EOD
Currently, the API is read-only, meaning that you can use it to fetch data from NoBleme, but not to interact with the website. This could change in the future.
EOD
);
___('api_intro_usage_body_3', 'FR', <<<EOD
L'API est actuellement en lecture seule : vous pouvez l'utiliser pour lire des données sur NoBleme, mais pas pour interagir avec le site. Cela pourrait changer dans le futur.
EOD
);
___('api_intro_usage_body_4', 'EN', <<<EOD
Using the API currently does not require authentication. There are no access restrictions and no rate limiting. This could change in the future.
EOD
);
___('api_intro_usage_body_4', 'FR', <<<EOD
L'utilisation de l'API ne requiert actuellement pas d'authentification. Il n'y a aucune restriction d'accès ou de débit. Cela pourrait changer dans le futur.
EOD
);
___('api_intro_usage_body_5', 'EN', <<<EOD
The API is not versioned. This means if a breaking change happens, the previous way of interacting with the API will disappear, and you will need to update your applications accordingly. Although the API is designed so that breaking changes should ideally never need to happen, advance warnings will be given before any future API breaking changes on {{link|pages/dev/blog_list|the devblog}} and/or {{link|pages/social/irc|IRC}} and/or {{link|pages/social/discord|Discord}}.
EOD
);
___('api_intro_usage_body_5', 'FR', <<<EOD
L'API n'est pas versionnée. Cela signifie que si un changement majeur altère la structure de l'API dans le futur, la manière actuelle d'interagir avec l'API disparaîtra, et vous devrez mettre à jour vos applications en conséquence. Bien que l'API soit conçue de manière à ce que des changements majeurs ne soient pas nécessaires, s'il doit y en avoir, un avertissement sera fait à l'avance sur {{link|pages/dev/blog_list|le devblog}} et/ou {{link|pages/social/irc|IRC}} et/ou {{link|pages/social/discord|Discord}}.
EOD
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    COMPENDIUM                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Menu entry & introduction
___('api_compendium_menu',  'EN', "Compendium");
___('api_compendium_menu',  'FR', "Compendium");
___('api_compendium_intro', 'EN', <<<EOD
This part of {{link|api/doc/intro|NoBleme's API}} allows you to interact with {{link|pages/compendium/index|NoBleme's 21st century Compendium}}.
EOD
);
___('api_compendium_intro', 'FR', <<<EOD
Cette section de {{link|api/doc/intro|l'API NoBleme}} permet d'interagir avec {{link|pages/compendium/index|le Compendium du 21ème siècle de NoBleme}}.
EOD
);


// List pages
___('api_compendium_pages_list_summary',      'EN', <<<EOD
Retrieves a list of all compendium pages, sorted in reverse chronological order by date of initial publication or last major modification (only complete page reworks count as major modifications).
EOD
);
___('api_compendium_pages_list_summary',      'FR', <<<EOD
Récupère une liste de toutes les pages du compendium, triées dans l'ordre antéchronologique de publication initiale ou de dernière modification majeure (une modification majeure correspond à une refonte d'une page dans son intégralité).
EOD
);
___('api_compendium_pages_list_sort',         'EN', "Sorts the results in the specified way. The following sorting orders are available:");
___('api_compendium_pages_list_sort',         'FR', "Trie les résultats dans l'ordre spécifié. Les options de tri suivantes sont possibles :");
___('api_compendium_pages_list_sort_url',     'EN', "Sort by URL, alphabetically.");
___('api_compendium_pages_list_sort_url',     'FR', "Trie par URL, alphabétiquement.");
___('api_compendium_pages_list_sort_app',     'EN', "Sort by date of first appearance, in reverse chronological order.");
___('api_compendium_pages_list_sort_app',     'FR', "Trie par date de première apparition, antéchronologiquement.");
___('api_compendium_pages_list_sort_app_r',   'EN', "Sort by date of first appearance, in chronological order.");
___('api_compendium_pages_list_sort_app_r',   'FR', "Trie par date de première apparition, chronologiquement.");
___('api_compendium_pages_list_sort_peak',    'EN', "Sort by date of peak popularity, in reverse chronological order.");
___('api_compendium_pages_list_sort_peak',    'FR', "Trie par date de pic de popularité, antéchronologiquement.");
___('api_compendium_pages_list_sort_peak_r',  'EN', "Sort by date of peak popularity, in chronological order.");
___('api_compendium_pages_list_sort_peak_r',  'FR', "Trie par date de pic de popularité, chronologiquement.");
___('api_compendium_pages_list_redirections', 'EN', "If this parameter is set to `true`, pages which only serve as redirections will be also be returned.");
___('api_compendium_pages_list_redirections', 'FR', "Si ce paramètre vaut `true`, les pages qui ne servent que de redirection seront également renvoyées.");
___('api_compendium_pages_list_no_nsfw',      'EN', "If this parameter is set to `true`, pages with content warnings will not be returned.");
___('api_compendium_pages_list_no_nsfw',      'FR', "Si ce paramètre vaut `true`, les pages qui contiennent des avertissements de contenus ne seront pas renvoyées.");
___('api_compendium_pages_list_url',          'EN', "Return pages containing the specified string in their URL.");
___('api_compendium_pages_list_url',          'FR', "Renvoie les pages contenant la chaîne de caractères spécifiée dans leur URL.");
___('api_compendium_pages_list_title_en',     'EN', "Return pages containing the specified string in their english language title.");
___('api_compendium_pages_list_title_en',     'FR', "Renvoie les pages contenant la chaîne de caractères spécifiée dans leur titre en anglais.");
___('api_compendium_pages_list_title_fr',     'EN', "Return pages containing the specified string in their french language title.");
___('api_compendium_pages_list_title_fr',     'FR', "Renvoie les pages contenant la chaîne de caractères spécifiée dans leur titre en français.");
___('api_compendium_pages_list_contents_en',  'EN', "Return pages containing the specified string either in their english summary or their english body. The searched string must be at least 4 characters long.");
___('api_compendium_pages_list_contents_en',  'FR', "Renvoie les pages contenant la chaîne de caractères spécifiée dans leur résumé en anglais ou dans leur contenu en anglais. La chaîne de caractères recherchée doit être longue d'au minimum 4 caractères.");
___('api_compendium_pages_list_contents_fr',  'EN', "Return pages containing the specified string either in their french summary or their french body. The searched string must be at least 4 characters long.");
___('api_compendium_pages_list_contents_fr',  'FR', "Renvoie les pages contenant la chaîne de caractères spécifiée dans leur résumé en français ou dans leur contenu en français. La chaîne de caractères recherchée doit être longue d'au minimum 4 caractères.");
___('api_compendium_pages_list_type',         'EN', "Return pages of the specified {{external|#types_list|type}}.");
___('api_compendium_pages_list_type',         'FR', "Renvoie les pages du {{external|#types_list|type}} spécifié.");
___('api_compendium_pages_list_era',          'EN', "Return pages from the specified {{external|#eras_list|era}}.");
___('api_compendium_pages_list_era',          'FR', "Renvoie les pages de l'{{external|#eras_list|ère}} spécifiée.");
___('api_compendium_pages_list_category',     'EN', "Return pages from the specified {{external|#categories_list|category}}.");
___('api_compendium_pages_list_category',     'FR', "Renvoie les pages de la {{external|#categories_list|catégorie}} spécifiée.");


// Get one page by ID
___('api_compendium_pages_get_id_summary',  'EN', <<<EOD
Retrieves a compendium page with the specified ID.
EOD
);
___('api_compendium_pages_get_id_summary',  'FR', <<<EOD
Récupère une page du compendium, dont l'ID est spécifié.
EOD
);
___('api_compendium_pages_get_id',          'EN', "The desired compendium page's ID.");
___('api_compendium_pages_get_id',          'FR', "L'ID de la page du compendium désirée.");


// Get one page by URL
___('api_compendium_pages_get_url_summary', 'EN', <<<EOD
Retrieves a compendium page with the specified URL.<br>
<br>
As compendium pages can have different display names in different languages, retrieving them by their display name is not always the best way to fetch a page.<br>
<br>
Each compendium page has a unique page name valid in all languages, which can be seen in their URL. This name is what "URL" refers to in this part of NoBleme's API, and can be used to retrieve specific compendium pages regardless of language.<br>
<br>
For example, the compendium page named "13:37 troll" in english and "Troll de 13:37" in french is referred to by the URL {{link|pages/compendium/troll_de_1337|troll_de_1337}} in both languages.
EOD
);
___('api_compendium_pages_get_url_summary', 'FR', <<<EOD
Récupère une page du compendium, dont l'URL est spécifiée.<br>
<br>
Comme les pages du compendium peuvent avoir plusieurs noms d'affichage différents dans des langues différentes, récupérer des pages par leur nom d'affichage n'est pas toujours la meilleure façon de le faire.<br>
<br>
Chaque page du compendium dispose d'un nom de page unique valide dans toutes les langues, qui est visible dans leur URL. Ce nom est ce que signifie "URL" dans cette partie de l'API NoBleme, et peut être utilisé pour récupérer des pages spécifiques du compendium peu importe leur langue.<br>
<br>
Par exemple, la page du compendium nommée « Troll de 13:37 » en français et « 13:37 troll » en anglais utilise l'URL {{link|pages/compendium/troll_de_1337|troll_de_1337}} dans les deux langues.
EOD
);
___('api_compendium_pages_get_url',         'EN', "The desired compendium page's URL (ex. 'troll_de_1337').");
___('api_compendium_pages_get_url',         'FR', "L'URL de la page du compendium désirée (ex. 'troll_de_1337').");


// Get one random page
___('api_compendium_pages_get_random_summary',    'EN', <<<EOD
Retrieves a random compendium page.<br>
<br>
Unless extra parameters are specified, the returned page will not be a redirection, and will not include any NSFW content.
EOD
);
___('api_compendium_pages_get_random_summary',    'FR', <<<EOD
Récupère une page du compendium au hasard.<br>
<br>
Si aucun paramètre supplémentaire n'est renseigné, la page renvoyée ne sera pas une redirection, et n'incluera pas de contenu NSFW.
EOD
);
___('api_compendium_pages_get_random_type',       'EN', "Choose from compendium pages of the specified {{external|#types_list|type}}.");
___('api_compendium_pages_get_random_type',       'FR', "Choisit parmi les pages du compendium du {{external|#types_list|type}} spécifié.");
___('api_compendium_pages_get_random_language',   'EN', "Choose from compendium entries translated in the specified ISO 639-1 language (ex. 'en'). ");
___('api_compendium_pages_get_random_language',   'FR', "Choisit parmi les pages du compendium traduites dans la langue ISO 639-1 spécifiée (ex. 'en'). ");
___('api_compendium_pages_get_random_nsfw',       'EN', "If `true`, choose from all compendium pages, including those with a content warning (ex. nsfw).");
___('api_compendium_pages_get_random_nsfw',       'FR', "Si `true`, choisit parmi toutes les pages du compendium, même celles contenant un avertissement de contenu (par ex. nsfw).");
___('api_compendium_pages_get_random_redirects',  'EN', "If `true`, the randomly selected compendium page could be a redirection to another page.");
___('api_compendium_pages_get_random_redirects',  'FR', "Si `true`, la page du compendium choisie au hasard pourrait être une redirection vers une autre page.");


// List categories
___('api_compendium_categories_list_summary', 'EN', <<<EOD
Retrieves a list of all {{link|pages/compendium/category_list|categories}}.
EOD
);
___('api_compendium_categories_list_summary', 'FR', <<<EOD
Récupère une liste de toutes les {{link|pages/compendium/category_list|catégories}}.
EOD
);


// List cultural eras
___('api_compendium_eras_list_summary', 'EN', <<<EOD
Retrieves a list of all {{link|pages/compendium/cultural_era_list|eras}}.
EOD
);
___('api_compendium_eras_list_summary', 'FR', <<<EOD
Récupère une liste de toutes les {{link|pages/compendium/cultural_era_list|périodes}}.
EOD
);


// List page types
___('api_compendium_types_list_summary', 'EN', <<<EOD
Retrieves a list of all {{link|pages/compendium/page_type_list|page types}}.
EOD
);
___('api_compendium_types_list_summary', 'FR', <<<EOD
Récupère une liste de toutes les {{link|pages/compendium/page_type_list|thématiques}}.
EOD
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      MEETUPS                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Menu entry & introduction
___('api_irc_menu',   'EN', "IRC chat");
___('api_irc_menu',   'FR', "Chat IRC");
___('api_irc_intro',  'EN', <<<EOD
This part of {{link|api/doc/intro|NoBleme's API}} allows you to interact with {{link|pages/social/irc|NoBleme's IRC chat server}}.
EOD
);
___('api_irc_intro',  'FR', <<<EOD
Cette section de {{link|api/doc/intro|l'API NoBleme}} permet d'interagir avec {{link|pages/social/irc|le serveur de chat IRC de NoBleme}}.
EOD
);


// List irc channels
___('api_irc_channel_list_summary', 'EN', <<<EOD
Retrieves a list of all {{link|pages/social/irc?channels|public IRC channels}}.
EOD
);
___('api_irc_channel_list_summary', 'FR', <<<EOD
Récupère une liste de tous les {{link|pages/social/irc?channels|canaux IRC publics}}.
EOD
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      MEETUPS                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Menu entry & introduction
___('api_meetups_menu',   'EN', "Meetups");
___('api_meetups_menu',   'FR', "IRL");
___('api_meetups_intro',  'EN', <<<EOD
This part of {{link|api/doc/intro|NoBleme's API}} allows you to interact with {{link|pages/meetups/list|real life meetups}}.
EOD
);
___('api_meetups_intro', 'FR', <<<EOD
Cette section de {{link|api/doc/intro|l'API NoBleme}} permet d'interagir avec {{link|pages/meetups/list|les rencontres IRL}}.
EOD
);


// List meetups
___('api_meetups_list_summary',   'EN', <<<EOD
Retrieves a list of all past, present, and future real life meetups, in reverse chronological order.
EOD
);
___('api_meetups_list_summary',   'FR', <<<EOD
Récupère une liste de toutes les rencontres IRL passées, présentes, et futures, dans l'ordre antéchronologique.
EOD
);
___('api_meetups_list_user',      'EN', "Return meetups which were attended by the specified {{link|api/doc/users|user}}.");
___('api_meetups_list_user',      'FR', "Renvoie les rencontres IRL auxquelles ont participé la personne possédant le {{link|api/doc/users|compte}} spécifié.");
___('api_meetups_list_language',  'EN', "Return meetups in which the specified ISO 639-1 language was spoken (ex. 'en').");
___('api_meetups_list_language',  'FR', "Renvoie les rencontres IRL où la langue spécifiée au format ISO 639-1 a été parlée (ex. 'fr').");
___('api_meetups_list_year',      'EN', "Return meetups which took place in the specified year (ex. '2005').");
___('api_meetups_list_year',      'FR', "Renvoie les rencontres IRL qui ont lieu l'année spécifiée (ex. '2005').");
___('api_meetups_list_location',  'EN', "Return meetups which took place in the specified location.");
___('api_meetups_list_location',  'FR', "Renvoie les rencontres IRL qui ont lieu à l'endroit spécifié.");
___('api_meetups_list_attendees', 'EN', "Return meetups which had <span class=\"bold\">at least</span> the specified number of attendees.");
___('api_meetups_list_attendees', 'FR', "Renvoie les rencontres IRL où sont venues <span class=\"bold\">au minimum</span> le nombre de personnes spécifié.");


// Get one meetup
___('api_meetups_get_summary',  'EN', <<<EOD
Retrieves a real life meetup with the specified ID.<br>
<br>
Some attendees might not have accounts on NoBleme, in which case their `user_id` will show up as `null`.
EOD
);
___('api_meetups_get_summary',  'FR', <<<EOD
Récupère une rencontre IRL, dont l'ID est spécifié.<br>
<br>
Des personnes ayant participé à des rencontres IRL peuvent ne pas avoir de compte sur NoBleme, auquel cas leur `user_id` sera `null`.
EOD
);
___('api_meetups_get_id',       'EN', "The desired real life meetup's ID.");
___('api_meetups_get_id',       'FR', "L'ID de la rencontre IRL désirée.");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      QUOTES                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Menu entry & introduction
___('api_quotes_menu',  'EN', "Quotes");
___('api_quotes_menu',  'FR', "Citations");
___('api_quotes_intro', 'EN', <<<EOD
This part of {{link|api/doc/intro|NoBleme's API}} allows you to interact with the {{link|pages/quotes/list|quote database}}.
EOD
);
___('api_quotes_intro', 'FR', <<<EOD
Cette section de {{link|api/doc/intro|l'API NoBleme}} permet d'interagir avec {{link|pages/quotes/list|les citations}}.
EOD
);


// List quotes
___('api_quotes_list_summary',  'EN', <<<EOD
Retrieves a list of all quotes, in reverse chronological order of addition to the quote database.
EOD
);
___('api_quotes_list_summary',  'FR', <<<EOD
Récupère une liste de toutes les citations, dans l'ordre antéchronologique d'addition sur le site.
EOD
);
___('api_quotes_list_language', 'EN', "Return quotes in the specified ISO 639-1 language (ex. 'en').");
___('api_quotes_list_language', 'FR', "Renvoie les citations dans la langue spécifiée au format ISO 639-1 (ex. 'fr').");
___('api_quotes_list_user_id',  'EN', "Return quotes including the specified {{link|api/doc/users|user}}.");
___('api_quotes_list_user_id',  'FR', "Renvoie les citations contant le {{link|api/doc/users|compte}} spécifié.");
___('api_quotes_list_search',   'EN', "Return quotes which contain the specified string in their body.");
___('api_quotes_list_search',   'FR', "Renvoie les citations contenant la chaîne de caractère spécifiée dans leur contenu.");
___('api_quotes_list_year',     'EN', "Return quotes added to the database in a specific year (ex. '2005').");
___('api_quotes_list_year',     'FR', "Renvoie les citations ajoutées sur le site une année spécifiée (ex. '2005').");
___('api_quotes_list_nsfw',     'EN', "Return only SFW (0) or NSFW (1) quotes.");
___('api_quotes_list_nsfw',     'FR', "Renvoie uniquement les citations SFW (0) ou NSFW (1).");


// Get one quote
___('api_quotes_get_summary', 'EN', <<<EOD
Retrieves a quote with the specified ID.
EOD
);
___('api_quotes_get_summary', 'FR', <<<EOD
Récupère une citation, dont l'ID est spécifié.
EOD
);
___('api_quotes_get_id',      'EN', "The desired quote's ID.");
___('api_quotes_get_id',      'FR', "L'ID de la citation désirée.");


// Random quote
___('api_quotes_random_summary',  'EN', <<<EOD
Retrieves a random quote.
EOD
);
___('api_quotes_random_summary',  'FR', <<<EOD
Récupère une citation au hasard.
EOD
);
___('api_quotes_random_language', 'EN', "Choose from quotes in the specified ISO 639-1 language (ex. 'en').");
___('api_quotes_random_language', 'FR', "Choisit parmi les citations dans la langue spécifiée au format ISO 639-1 (ex. 'fr').");
___('api_quotes_random_user_id',  'EN', "Choose from quotes including the specified {{link|api/doc/users|user}}.");
___('api_quotes_random_user_id',  'FR', "Choisit parmi les citations contant le {{link|api/doc/users|compte}} spécifié.");
___('api_quotes_random_nsfw',     'EN', "Choose solely from SFW (0) or NSFW (1) quotes.");
___('api_quotes_random_nsfw',     'FR', "Choisit uniquement parmi les citations SFW (0) ou NSFW (1).");
___('api_quotes_random_year',     'EN', "Choose from quotes added to the database in a specific year (ex. '2005').");
___('api_quotes_random_year',     'FR', "Choisit parmi les citations ajoutées sur le site une année spécifiée (ex. '2005').");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       USERS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Menu entry & introduction
___('api_users_menu',   'EN', "Users");
___('api_users_menu',   'FR', "Comptes");
___('api_users_intro',  'EN', <<<EOD
This part of {{link|api/doc/intro|NoBleme's API}} allows you to interact with the website's {{link|pages/users/list|user accounts}}. Per our {{link|pages/doc/privacy|privacy policy}}, users have a "right to be forgotten": some accounts might have their username show as "[deleted]", and can not be interacted with.
EOD
);
___('api_users_intro',  'FR', <<<EOD
Cette section de {{link|api/doc/intro|l'API NoBleme}} permet d'interagir avec {{link|pages/users/list|les comptes}}. Dans notre {{link|pages/doc/privacy|politique de confidentialité}}, il est précisé que tout le monde dispose d'un « droit à l'oubli » : certains comptes auront pour pseudonyme « [deleted] », il n'est pas possible d'intéragir avec eux.
EOD
);


// List users
___('api_users_list_summary',       'EN', <<<EOD
Retrieves a list of all users, in chronological order of account creation.
EOD
);
___('api_users_list_summary',       'FR', <<<EOD
Récupère une liste de tous les comptes, dans l'ordre chronologique de création.
EOD
);
___('api_users_list_sort',          'EN', "Sorts the results in the specified way. The following sorting orders are available:");
___('api_users_list_sort',          'FR', "Trie les résultats dans l'ordre spécifié. Les options de tri suivantes sont possibles :");
___('api_users_list_sort_username', 'EN', "Sort by username, alphabetically.");
___('api_users_list_sort_username', 'FR', "Trie par pseudonyme, alphabétiquement.");
___('api_users_list_sort_created',  'EN', "Sort by account creation date, in reverse chronological order.");
___('api_users_list_sort_created',  'FR', "Trie par date de création du compte, antéchronologiquement.");
___('api_users_list_sort_activity', 'EN', "Sort by last account activity date, in reverse chronological order. Deleted users and users who {{link|pages/account/settings_privacy|opted out of activity stats}} will not be shown in the results.");
___('api_users_list_sort_activity', 'FR', "Trie par date de dernière activité du compte, antéchronologiquement. Les comptes supprimés et les comptes {{link|pages/account/settings_privacy|désirant être masqués dans l'activité}} n'apparaîtront pas dans le résultat.");
___('api_users_list_created',       'EN', "Returns only accounts created on the specified year.");
___('api_users_list_created',       'FR', "Ne renvoie que les comptes crées lors de l'année spécifiée");
___('api_users_list_admins',        'EN', "If this parameter is set to `true`, returns only members of the {{link|pages/users/admins|administrative team}}.");
___('api_users_list_admins',        'FR', "Si ce paramètre vaut `true`, ne renvoie que les membres de {{link|pages/users/admins|l'équipe administrative}}.");


// Get one user by ID
___('api_users_get_summary', 'EN', <<<EOD
Retrieves a user with the specified ID.
EOD
);
___('api_users_get_summary', 'FR', <<<EOD
Récupère un compte, dont l'ID est spécifié.
EOD
);
___('api_users_get_id',     'EN', "The desired user's ID.");
___('api_users_get_id',     'FR', "L'ID du compte désiré.");


// Get one user by username
___('api_users_get_username_summary', 'EN', <<<EOD
Retrieves a user with the specified username.
EOD
);
___('api_users_get_username_summary', 'FR', <<<EOD
Récupère un compte, dont le pseudonyme est spécifié.
EOD
);
___('api_users_get_username',         'EN', "The desired user's username.");
___('api_users_get_username',         'FR', "Le pseudonyme du compte désiré.");


// Random user
___('api_users_random_summary', 'EN', <<<EOD
Retrieves a random user.
EOD
);
___('api_users_random_summary', 'FR', <<<EOD
Récupère un compte au hasard.
EOD
);