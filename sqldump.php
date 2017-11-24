<?php header("Location: ."); /************************************************************************************************************/
/*                                                                                                                                       */
/*                                              DUMP DE LA STRUCTURE DE LA BASE DE DONNÉES                                               */
/*                                                                                                                                       */
/******************************************************************************************************************************************

CREATE DATABASE IF NOT EXISTS `nobleme` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `nobleme`;

DROP TABLE IF EXISTS `activite`;
CREATE TABLE IF NOT EXISTS `activite` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `log_moderation` tinyint(1) NOT NULL,
  `FKmembres` int(11) NOT NULL,
  `pseudonyme` tinytext COLLATE utf8_unicode_ci,
  `action_type` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `action_id` int(11) NOT NULL,
  `action_titre` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `parent` mediumtext COLLATE utf8_unicode_ci,
  `justification` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `activite_diff`;
CREATE TABLE IF NOT EXISTS `activite_diff` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `FKactivite` bigint(20) NOT NULL,
  `titre_diff` tinytext NOT NULL,
  `diff_avant` longtext,
  `diff_apres` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `devblog`;
CREATE TABLE IF NOT EXISTS `devblog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `titre` mediumtext,
  `contenu` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `invites`;
CREATE TABLE IF NOT EXISTS `invites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surnom` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `derniere_visite` int(11) NOT NULL,
  `derniere_visite_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `derniere_visite_url` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `irc_canaux`;
CREATE TABLE IF NOT EXISTS `irc_canaux` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `canal` tinytext,
  `langue` tinytext,
  `importance` tinyint(1) NOT NULL,
  `description_fr` mediumtext,
  `description_en` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `irl`;
CREATE TABLE IF NOT EXISTS `irl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `lieu` tinytext NOT NULL,
  `raison_fr` tinytext NOT NULL,
  `raison_en` tinytext NOT NULL,
  `details_fr` longtext NOT NULL,
  `details_en` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `irl_participants`;
CREATE TABLE IF NOT EXISTS `irl_participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKirl` int(11) NOT NULL,
  `FKmembres` int(11) NOT NULL,
  `pseudonyme` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `confirme` tinyint(1) NOT NULL,
  `details_fr` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `details_en` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `genre` tinytext COLLATE utf8_unicode_ci,
  `anniversaire` date NOT NULL,
  `habite` tinytext COLLATE utf8_unicode_ci,
  `metier` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `profil` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `membres_essais_login`;
CREATE TABLE IF NOT EXISTS `membres_essais_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKmembres` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `ip` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKmembres_destinataire` int(11) NOT NULL,
  `FKmembres_envoyeur` int(11) NOT NULL,
  `date_envoi` int(11) NOT NULL,
  `date_consultation` int(11) NOT NULL,
  `titre` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `pageviews`;
CREATE TABLE IF NOT EXISTS `pageviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `url_page` mediumtext COLLATE utf8_unicode_ci,
  `vues` bigint(20) NOT NULL,
  `vues_lastvisit` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `quotes`;
CREATE TABLE IF NOT EXISTS `quotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `contenu` longtext,
  `FKauteur` int(11) NOT NULL,
  `valide_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `quotes_membres`;
CREATE TABLE IF NOT EXISTS `quotes_membres` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FKquotes` int(11) UNSIGNED NOT NULL,
  `FKmembres` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `todo`;
CREATE TABLE IF NOT EXISTS `todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `source` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `todo_categorie`;
CREATE TABLE IF NOT EXISTS `todo_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `todo_roadmap`;
CREATE TABLE IF NOT EXISTS `todo_roadmap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_classement` int(11) DEFAULT NULL,
  `version` tinytext,
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `vars_globales`;
CREATE TABLE IF NOT EXISTS `vars_globales` (
  `mise_a_jour` tinyint(1) NOT NULL,
  `last_pageview_check` int(11) NOT NULL,
  UNIQUE KEY `mise_a_jour` (`mise_a_jour`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `version`;
CREATE TABLE IF NOT EXISTS `version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `build` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;