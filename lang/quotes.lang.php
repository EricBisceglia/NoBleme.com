<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    QUOTE  LIST                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('quotes_add',           'EN', "Submit a quote proposal");
___('quotes_add',           'FR', "Proposer une citation");
___('quotes_refresh',       'EN', "Recalculate all linked users");
___('quotes_refresh',       'FR', "Recalculer tous les comptes liés");
___('quotes_refresh_go',    'EN', "Confirm that you want to recalculate all linked users");
___('quotes_refresh_go',    'FR', "Confirmer que vous désirez recalculer tous les comptes liés");
___('quotes_back',          'EN', "Back to normal list");
___('quotes_back',          'FR', "Retour à la liste normale");
___('quotes_waiting',       'EN', "Quotes awaiting approval");
___('quotes_waiting',       'FR', "Citations en attente d'approbation");
___('quotes_deleted',       'EN', "Deleted quotes");
___('quotes_deleted',       'FR', "Citations supprimées");
___('quotes_subtitle',      'EN', "Words from NoBleme");
___('quotes_subtitle',      'FR', "Paroles de NoBleme");
___('quotes_header_intro',  'EN', <<<EOT
Sometimes, funny conversations or monologues happen on NoBleme, mostly on our {{link|pages/social/irc|IRC chat server}}. This page aims at preserving them for posterity. You will find all of our quotes below, presented to you in reverse chronological order. We have quality guidelines in place: we'd rather have a few great quotes than a lot of average ones, and we'd rather laugh with people than laugh at people. If you witness a conversation on NoBleme worthy of joining this collection, you can {{link|pages/quotes/submit|submit a quote proposal}}.
EOT
);
___('quotes_header_intro',  'FR', <<<EOT
Parfois, des conversations ou monologues amusants ont lieu sur NoBleme, principalement sur notre {{link|pages/social/irc|serveur de chat IRC}}. Cette page a pour but de les conserver pour la postérité. L'intégralité des citations est présente ci-dessous, dans l'ordre antéchronologique. Des consignes de qualité sont appliquées : nous préférons avoir un petit nombre de citations drôles plutôt qu'un grand nombre de citations bof, et nous préférons rire avec les gens que rire des gens. Si vous êtes témoin d'une conversation sur NoBleme qui mérite d'être immortalisée sur cette page, vous pouvez {{link|pages/quotes/submit|proposer une citation}}.
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


// Form
___('quotes_languages',       'EN', "Show quotes in the following languages (this setting will be saved):");
___('quotes_languages',       'FR', "Afficher les citations dans les langues suivantes (ce réglage sera enregistré) :");
___('quotes_languages_guest', 'EN', "Show quotes in the following languages:");
___('quotes_languages_guest', 'FR', "Afficher les citations dans les langues suivantes :");
___('quotes_search_label',    'EN', "Search quotes:");
___('quotes_search_label',    'FR', "Chercher parmi les citations :");


// List
___('quotes_blur',    'EN', <<<EOT
This quote is blurred as it contains crude or sensitive content. You can read it by hovering your pointer over the text. If you are bothered by the blurring or feel like you don't need it, you can permanently disable it in your account's {{link|pages/account/settings_nsfw|adult content options}}.
EOT
);
___('quotes_blur',    'FR', <<<EOT
Cette citation est floutée car elle contient des propos vulgaires ou sensibles. Vous pouvez révéler son contenu en passant votre curseur dessus. Si le floutage vous embête ou si vous n'en avez pas besoin, vous pouvez le désactiver de façon permanente dans vos {{link|pages/account/settings_nsfw|options de vulgarité}}.
EOT
);
___('quotes_none',              'EN', "No quotes have been found");
___('quotes_none',              'FR', "Aucune citation n'a été trouvée");
___('quotes_count_waitlist',    'EN', "{{1}} quote waiting for approval:");
___('quotes_count_waitlist',    'FR', "{{1}} citation en attente d'approbation :");
___('quotes_count_waitlist+',   'EN', "{{1}} quotes waiting for approval:");
___('quotes_count_waitlist+',   'FR', "{{1}} citations en attente d'approbation :");
___('quotes_count_deleted',     'EN', "{{1}} deleted quote:");
___('quotes_count_deleted',     'FR', "{{1}} citation supprimée :");
___('quotes_count_deleted+',    'EN', "{{1}} deleted quotes:");
___('quotes_count_deleted+',    'FR', "{{1}} citations supprimées :");
___('quotes_count',             'EN', "NoBleme's {{1}} quote:");
___('quotes_count',             'FR', "{{1}} citation NoBlemeuse :");
___('quotes_count+',            'EN', "NoBleme's {{1}} quotes:");
___('quotes_count+',            'FR', "{{1}} citations NoBlemeuses :");
___('quotes_count_filtered',    'EN', "{{1}} quote from {{2}}");
___('quotes_count_filtered',    'FR', "{{1}} citation de {{2}}");
___('quotes_count_filtered+',   'EN', "{{1}} quotes from {{2}}");
___('quotes_count_filtered+',   'FR', "{{1}} citations de {{2}}");
___('quotes_count_undated',     'EN', "an unknown date before {{1}}");
___('quotes_count_undated',     'FR', "date inconnue avant {{1}}");
___('quotes_id',                'EN', "Quote #{{1}}");
___('quotes_id',                'FR', "Citation #{{1}}");
___('quotes_nodate',            'EN', "Quote date unknown (before 2012)");
___('quotes_nodate',            'FR', "Date inconnue (avant 2012)");
___('quotes_users',             'EN', "Linked users");
___('quotes_users',             'FR', "Comptes liés");
___('quotes_approve',           'EN', "Approve");
___('quotes_approve',           'FR', "Approuver");
___('quotes_deny',              'EN', "Reject");
___('quotes_deny',              'FR', "Refuser");
___('quotes_hard_delete',       'EN', "Hard deletion");
___('quotes_hard_delete',       'FR', "Suppression définitive");
___('quotes_another',           'EN', "Show me another random quote");
___('quotes_another',           'FR', "Voir une autre citation au hasard");
___('quotes_is_deleted',        'EN', "This quote has been deleted, it is not publicly visible");
___('quotes_is_deleted',        'FR', "Cette citation a été supprimée, elle n'est pas visible publiquement");
___('quotes_unapproved',        'EN', "This quote is awaiting approval or rejection, it is not publicly visible");
___('quotes_unapproved',        'FR', "Cette citation est en attente d'approbation ou de refus, elle n'est pas visible publiquement");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  SUBMIT A QUOTE                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('quotes_add_intro_1',   'EN', <<<EOT
If you witness a funny conversation or monologue on NoBleme and think that it would fit well within our {{link|pages/quotes/list|quote database}}, you can submit it as a quote proposal here. It will then be added to a queue that our {{link|pages/users/admins|administrators}} will review, and will eventually be approved or rejected. Once a decision has been taken, you will recieve a private message informing you of the fate of your proposal.
EOT
);
___('quotes_add_intro_1',   'FR', <<<EOT
Si vous êtes témoin d'une conversation rigolote ou d'un monologue amusant sur NoBleme et pensez que cette scène mérite d'être immortalisée dans nos {{link|pages/quotes/list|citations}}, vous pouvez la proposer ici. Votre proposition sera mise dans une file d'attente que notre {{link|pages/users/admins|administration}} traitera tôt ou tard. Une fois une décision prise, vous recevrez un message privé vous informant de si votre proposition a été approuvée ou rejetée.
EOT
);
___('quotes_add_intro_2',   'EN', <<<EOT
Keep in mind that we strive for quality over quantity in our quote database, thus a lot of quotes get rejected. Do not get discouraged if your proposal gets rejected, we actually strongly appreciate contributions. The criteria used to judge whether to approve or reject a quote are the following:
EOT
);
___('quotes_add_intro_2',   'FR', <<<EOT
Les décisions sont prises dans une optique de qualité plutôt que de quantité, par conséquent beaucoup de propositions se font rejeter. Ne vous découragez pas si votre proposition se fait rejeter, nous apprécions fortement les contributions. Les critères utilisés pour juger les propositions sont les suivants :
EOT
);
___('quotes_add_rules_1',   'EN', "Is it funny enough?");
___('quotes_add_rules_1',   'FR', "Est-ce suffisamment drôle ?");
___('quotes_add_rules_2',   'EN', "Is there enough context to understand the quote?");
___('quotes_add_rules_2',   'FR', "Y a-t-il assez de contexte pour comprendre la citation ?");
___('quotes_add_rules_3',   'EN', "Will it stand the test of time and still be funny in a few years?");
___('quotes_add_rules_3',   'FR', "La citation sera-t-elle toujours drôle dans quelques années ?");
___('quotes_add_rules_4',   'EN', "Are we laughing *with* people rather than laughing *at* people?");
___('quotes_add_rules_4',   'FR', "Sommes-nous bien en train de rire *avec* des gens plutôt que de se moquer des gens ?");
___('quotes_add_rules_5',   'EN', "Can this quote be understood by people unfamiliar with NoBleme?");
___('quotes_add_rules_5',   'FR', "La citation peut-elle être comprise par des personnes ne connaissant pas bien NoBleme ?");
___('quotes_add_thanks',    'EN', <<<EOT
Your quote proposal has been added to our review queue. You will be notified whether it has been approved or rejected by private message. Thank you for contributing to NoBleme's quote database!
EOT
);
___('quotes_add_thanks',    'FR', <<<EOT
Votre proposition de citation a été ajoutée à notre file d'attente. Vous recevrez un message privé vous informant de si votre proposition a été acceptée ou refusée. Merci de votre contribution à la collection de citations de NoBleme !
EOT
);


// Form
___('quotes_add_body',    'EN', "Your quote proposal");
___('quotes_add_body',    'FR', "Votre proposition de citation");
___('quotes_add_submit',  'EN', "Submit quote proposal");
___('quotes_add_submit',  'FR', "Proposer la citation");
___('quotes_add_empty',   'EN', "Your quote proposal cannot be empty");
___('quotes_add_empty',   'FR', "Votre proposition de citation ne peut pas être vide");





/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   EDIT A QUOTE                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Quote contents
___('quotes_edit_submitted',  'EN', "Submitted by");
___('quotes_edit_submitted',  'FR', "Proposée par");
___('quotes_edit_date',       'EN', "Date (YYYY-MM-DD)");
___('quotes_edit_date',       'FR', "Date (YYYY-MM-DD)");
___('quotes_edit_nsfw',       'EN', "NSFW contents (blurred)");
___('quotes_edit_nsfw',       'FR', "Contenu vulgaire (floutée)");
___('quotes_edit_submit',     'EN', "Edit quote");
___('quotes_edit_submit',     'FR', "Modifier la citation");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                            ADMIN VALIDATION OF QUOTES                                             */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Approval
___('quotes_approve_confirm', 'EN', "Confirm that you want to approve this quote");
___('quotes_approve_confirm', 'FR', "Confirmer la validation de cette citation");
___('quotes_approve_already', 'EN', "This quote has already been approved");
___('quotes_approve_already', 'FR', "Cette citation a déjà été validée");
___('quotes_approve_ok',      'EN', "The quote has been approved and is now publicly visible");
___('quotes_approve_ok',      'FR', "La citation a été acceptée et est maintenant visible publiquement");


// Rejection
___('quotes_reject_subtitle', 'EN', "Reject the quote proposal");
___('quotes_reject_subtitle', 'FR', "Refuser la proposition de citation");
___('quotes_reject_reason',   'EN', "Reason for rejecting the quote (optional)");
___('quotes_reject_reason',   'FR', "Justification du refus (optionnel)");
___('quotes_reject_language', 'EN', "Submitter's language");
___('quotes_reject_language', 'FR', "Langue du message de refus");
___('quotes_reject_submit',   'EN', "Reject quote");
___('quotes_reject_submit',   'FR', "Refuser la citation");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  DELETE A QUOTE                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Soft deletion
___('quotes_delete_none',   'EN', "You must specify a quote ID");
___('quotes_delete_none',   'FR', "Vous devez spécifier un ID de citation");
___('quotes_delete_error',  'EN', "This quote does not exist or has already been deleted");
___('quotes_delete_error',  'FR', "Cette citation n'existe pas ou a déjà été supprimée");
___('quotes_delete_ok',     'EN', "The quote has been soft deleted");
___('quotes_delete_ok',     'FR', "La citation a été supprimée de façon non définitive");


// Hard deletion
___('quotes_delete_hard',     'EN', "Confirm the permanent and irreversible deletion of this quote");
___('quotes_delete_hard',     'FR', "Confirmer la suppression définitive et irréversible de cette citation");
___('quotes_delete_hard_ok',  'EN', "The quote has been deleted");
___('quotes_delete_hard_ok',  'FR', "La citation a été supprimée");


// Restoration
___('quotes_restore_error', 'EN', "This quote does not exist");
___('quotes_restore_error', 'FR', "Cette citation n'existe pas");
___('quotes_restore_ok',    'EN', "The quote has been restored");
___('quotes_restore_ok',    'FR', "La citation a été restaurée");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                              LINK ACCOUNTS TO QUOTES                                              */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Linked users
___('quotes_users_none',    'EN', "There are currently no accounts linked to this quote");
___('quotes_users_none',    'FR', "Aucun compte n'est actuellement lié à cette citation");
___('quotes_users_header',  'EN', "List of accounts linked to the quote:");
___('quotes_users_header',  'FR', "Liste de comptes liés à la citation :");
___('quotes_users_remove',  'EN', "Unlink account from quote");
___('quotes_users_remove',  'FR', "Dissocier le compte de la citation");
___('quotes_users_add',     'EN', "Link an account to the quote");
___('quotes_users_add',     'FR', "Lier un compte à la citation");
___('quotes_users_submit',  'EN', "Link account");
___('quotes_users_submit',  'FR', "Lier le compte");
___('quotes_users_empty',   'EN', "You must specify a username");
___('quotes_users_empty',   'FR', "Vous devez indiquer un pseudonyme");
___('quotes_users_error',   'EN', "This account does not exist");
___('quotes_users_error',   'FR', "Ce compte n'existe pas");
___('quotes_users_exists',  'EN', "This account has already been linked to this quote");
___('quotes_users_exists',  'FR', "Ce compte est déjà lié à cette citation");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       STATS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Page section selector
___('quotes_stats_selector_title',      'EN', "Quote database statistics");
___('quotes_stats_selector_title',      'FR', "Stats des citations");
___('quotes_stats_selector_featured',   'EN', "Featured users");
___('quotes_stats_selector_featured',   'FR', "Personnes citées");
___('quotes_stats_selector_submitted',  'EN', "Contributors");
___('quotes_stats_selector_submitted',  'FR', "Contributions");


// Recalculate all stats
___('quotes_stats_recalculate_button',  'EN', "Recalculate all quote database statistics");
___('quotes_stats_recalculate_button',  'FR', "Recalculer toutes les statistiques des citations");
___('quotes_stats_recalculate_alert',   'EN', "Are you sure you wish to recalculate all quote database statistics?");
___('quotes_stats_recalculate_alert',   'FR', "Confirmer que vous tenez à recalculer toutes les statistiques des citations");


// Overall stats
___('quotes_stats_overall_summary',       'EN', "There are currently <span class=\"bold\">{{1}}</span> quotes in {{link|pages/quotes/|NoBleme's quote database}}.");
___('quotes_stats_overall_summary',       'FR', "Il y a actuellement <span class=\"bold\">{{1}}</span> {{link|pages/quotes/|citations sur NoBleme}}.");
___('quotes_stats_overall_lang_en',       'EN', "<span class=\"bold\">{{1}}</span> quotes ({{2}}) are in english.");
___('quotes_stats_overall_lang_en',       'FR', "<span class=\"bold\">{{1}}</span> citations ({{2}}) sont en anglais.");
___('quotes_stats_overall_lang_fr',       'EN', "<span class=\"bold\">{{1}}</span> quotes ({{2}}) are in french.");
___('quotes_stats_overall_lang_fr',       'FR', "<span class=\"bold\">{{1}}</span> citations ({{2}}) sont en français.");
___('quotes_stats_overall_nsfw',          'EN', "<span class=\"bold\">{{1}}</span> quotes ({{2}}) contain crude or sensitive content.");
___('quotes_stats_overall_nsfw',          'FR', "<span class=\"bold\">{{1}}</span> citations ({{2}}) contiennent des propos vulgaires ou sensibles.");
___('quotes_stats_overall_deleted',       'EN', "<span class=\"bold\">{{1}}</span> {{link|pages/quotes/submit|quote proposals}} have been rejected ({{2}} of all quote proposals).");
___('quotes_stats_overall_deleted',       'FR', "<span class=\"bold\">{{1}}</span> {{link|pages/quotes/submit|propositions de citation}} ont été refusées ({{2}} de toutes les propositions).");
___('quotes_stats_overall_unvalidated',   'EN', "<span class=\"bold\">{{1}}</span> {{link|pages/quotes/submit|quote proposal}} is currently unvalidated, awaiting administrative review.");
___('quotes_stats_overall_unvalidated',   'FR', "<span class=\"bold\">{{1}}</span> {{link|pages/quotes/submit|proposition de citation}} est actuellement en attente d'approbation administrative.");
___('quotes_stats_overall_unvalidated+',  'EN', "<span class=\"bold\">{{1}}</span> {{link|pages/quotes/submit|quote proposals}} are currently unvalidated, awaiting administrative review.");
___('quotes_stats_overall_unvalidated+',  'FR', "<span class=\"bold\">{{1}}</span> {{link|pages/quotes/submit|propositions de citations}} sont actuellement en attente d'approbation administrative.");
___('quotes_stats_overall_more',          'EN', "You can find more stats about NoBleme's quote database by using the dropdown menu at the top.");
___('quotes_stats_overall_more',          'FR', "Vous trouverez d'autres stats sur les citations en utilisant le menu déroulant en haut de la page.");


// Featured users
___('quotes_stats_users_quotes',      'EN', "Quotes");
___('quotes_stats_users_quotes',      'FR', "Citations");
___('quotes_stats_users_quotes_en',   'EN', "English<br>quotes");
___('quotes_stats_users_quotes_en',   'FR', "Citations<br>anglaises");
___('quotes_stats_users_quotes_fr',   'EN', "French<br>quotes");
___('quotes_stats_users_quotes_fr',   'FR', "Citations<br>françaises");
___('quotes_stats_users_quotes_nsfw', 'EN', "Crude<br>quotes");
___('quotes_stats_users_quotes_nsfw', 'FR', "Citations<br>vulgaires");
___('quotes_stats_users_quotes_old',  'EN', "Oldest<br>quote");
___('quotes_stats_users_quotes_old',  'FR', "Première<br>citation");
___('quotes_stats_users_quotes_new',  'EN', "Newest<br>quote");
___('quotes_stats_users_quotes_new',  'FR', "Dernière<br>citation");


// Timeline
___('quotes_stats_years_quotes',  'EN', "Quotes<br>that year");
___('quotes_stats_years_quotes',  'FR', "Citations<br>de l'année");


// Contributors
___('quotes_stats_contrib_submitted',   'EN', "Quote<br>proposals");
___('quotes_stats_contrib_submitted',   'FR', "Propositions<br>de citations");
___('quotes_stats_contrib_approved',    'EN', "Quotes<br>approved");
___('quotes_stats_contrib_approved',    'FR', "Citations<br>approuvées");
___('quotes_stats_contrib_percentage',  'EN', "Proposals<br>approved");
___('quotes_stats_contrib_percentage',  'FR', "Propositions<br>approuvées");