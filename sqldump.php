<?php header("Location: ."); /************************************************************************************************************/
/*                                                                                                                                       */
/*                                              DUMP DE LA STRUCTURE DE LA BASE DE DONNÉES                                               */
/*                                                                                                                                       */
/******************************************************************************************************************************************

CREATE TABLE `activite` (
  `id` bigint(20) NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `log_moderation` tinyint(1) NOT NULL,
  `FKmembres` int(11) NOT NULL,
  `pseudonyme` tinytext COLLATE utf8_unicode_ci,
  `action_type` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `action_id` int(11) NOT NULL,
  `action_titre` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `parent_titre` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `justification` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `activite_diff` (
  `id` bigint(20) NOT NULL,
  `FKactivite` bigint(20) NOT NULL,
  `titre_diff` tinytext NOT NULL,
  `diff` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `devblog` (
  `id` int(11) NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `titre` mediumtext,
  `resume` mediumtext,
  `contenu` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `invites` (
  `id` int(11) NOT NULL,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surnom` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `derniere_visite` int(11) NOT NULL,
  `derniere_visite_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `derniere_visite_url` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `irl` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `lieu` tinytext NOT NULL,
  `raison` text NOT NULL,
  `details_pourquoi` text NOT NULL,
  `details_ou` text NOT NULL,
  `details_quand` text NOT NULL,
  `details_quoi` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `irl_participants` (
  `id` int(11) NOT NULL,
  `FKirl` int(11) NOT NULL,
  `FKmembres` int(11) NOT NULL,
  `pseudonyme` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `confirme` tinyint(1) NOT NULL,
  `details` tinytext CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `membres` (
  `id` int(11) NOT NULL,
  `pseudonyme` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `pass` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `sysop` int(11) NOT NULL,
  `moderateur` mediumtext COLLATE utf8_unicode_ci,
  `moderateur_description_fr` mediumtext COLLATE utf8_unicode_ci,
  `moderateur_description_en` mediumtext COLLATE utf8_unicode_ci,
  `email` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `date_creation` int(11) NOT NULL,
  `derniere_visite` int(11) NOT NULL,
  `derniere_visite_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `derniere_visite_url` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `derniere_visite_ip` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `banni_date` int(11) NOT NULL,
  `banni_raison` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `sexe` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `anniversaire` date NOT NULL,
  `region` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `metier` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `profil` longtext COLLATE utf8_unicode_ci NOT NULL,
  `profil_last_edit` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `membres_essais_login` (
  `id` int(11) NOT NULL,
  `FKmembres` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `ip` tinytext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `FKmembres_destinataire` int(11) NOT NULL,
  `FKmembres_envoyeur` int(11) NOT NULL,
  `date_envoi` int(11) NOT NULL,
  `date_consultation` int(11) NOT NULL,
  `titre` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `quotes` (
  `id` int(11) NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `contenu` longtext,
  `FKauteur` int(11) NOT NULL,
  `valide_admin` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `quotes_membres` (
  `id` int(11) UNSIGNED NOT NULL,
  `FKquotes` int(11) UNSIGNED NOT NULL,
  `FKmembres` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `stats_pageviews` (
  `id` int(11) NOT NULL,
  `nom_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `url_page` mediumtext COLLATE utf8_unicode_ci,
  `vues` bigint(20) NOT NULL,
  `vues_lastvisit` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `todo` (
  `id` int(11) NOT NULL,
  `FKmembres` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `importance` int(11) DEFAULT NULL,
  `titre` mediumtext,
  `contenu` longtext,
  `FKtodo_categorie` int(11) DEFAULT NULL,
  `FKtodo_roadmap` int(11) DEFAULT NULL,
  `valide_admin` tinyint(1) DEFAULT NULL,
  `public` tinyint(1) DEFAULT NULL,
  `timestamp_fini` int(11) DEFAULT NULL,
  `source` mediumtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `todo_categorie` (
  `id` int(11) NOT NULL,
  `categorie` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `todo_roadmap` (
  `id` int(11) NOT NULL,
  `id_classement` int(11) DEFAULT NULL,
  `version` tinytext,
  `description` mediumtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `vars_globales` (
  `mise_a_jour` tinyint(1) NOT NULL,
  `last_pageview_check` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `version` (
  `id` int(11) NOT NULL,
  `version` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `build` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `activite`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `activite_diff`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `devblog`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `invites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip` (`ip`);

ALTER TABLE `irl`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `irl_participants`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `membres_essais_login`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `quotes_membres`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `stats_pageviews`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `todo_categorie`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `todo_roadmap`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `vars_globales`
  ADD UNIQUE KEY `mise_a_jour` (`mise_a_jour`);

ALTER TABLE `version`
  ADD PRIMARY KEY (`id`);