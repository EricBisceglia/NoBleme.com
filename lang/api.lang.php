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
Retrieves a list of all meetups, in reverse chronological order.
EOD
);
___('api_meetups_list_summary',   'FR', <<<EOD
Récupère une liste de toutes les rencontres IRL, dans l'ordre antéchronologique.
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