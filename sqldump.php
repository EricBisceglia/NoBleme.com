<?php header("Location: ."); /************************************************************************************************************/
/*                                                                                                                                       */
/*                                              DUMP DE LA STRUCTURE DE LA BASE DE DONNÉES                                               */
/*                                                                                                                                       */
/******************************************************************************************************************************************

--
-- Database: `nobleme`
--

-- --------------------------------------------------------

--
-- Table structure for table `activite`
--

CREATE TABLE IF NOT EXISTS `activite` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) unsigned NOT NULL,
  `log_moderation` tinyint(1) NOT NULL,
  `FKmembres` int(11) NOT NULL,
  `pseudonyme` tinytext COLLATE utf8_unicode_ci,
  `action_type` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `action_id` int(11) NOT NULL,
  `action_titre` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `parent_titre` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `justification` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activite_diff`
--

CREATE TABLE IF NOT EXISTS `activite_diff` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `FKactivite` bigint(20) NOT NULL,
  `titre_diff` tinytext NOT NULL,
  `diff` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `anniv_flash`
--

CREATE TABLE IF NOT EXISTS `anniv_flash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_fichier` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `largeur` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devblog`
--

CREATE TABLE IF NOT EXISTS `devblog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) unsigned NOT NULL,
  `titre` mediumtext,
  `resume` mediumtext,
  `contenu` longtext,
  `score_popularite` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `devblog_commentaire`
--

CREATE TABLE IF NOT EXISTS `devblog_commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKdevblog` int(11) DEFAULT NULL,
  `FKmembres` int(11) DEFAULT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  `contenu` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `forum_loljk`
--

CREATE TABLE IF NOT EXISTS `forum_loljk` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) unsigned NOT NULL,
  `threadparent` int(11) NOT NULL,
  `FKauteur` int(11) NOT NULL,
  `titre` mediumtext,
  `contenu` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invites`
--

CREATE TABLE IF NOT EXISTS `invites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surnom` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `derniere_visite` int(11) NOT NULL,
  `derniere_visite_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `derniere_visite_url` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `irl`
--

CREATE TABLE IF NOT EXISTS `irl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `lieu` tinytext NOT NULL,
  `raison` text NOT NULL,
  `details_pourquoi` text NOT NULL,
  `details_ou` text NOT NULL,
  `details_quand` text NOT NULL,
  `details_quoi` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `irl_participants`
--

CREATE TABLE IF NOT EXISTS `irl_participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKirl` int(11) NOT NULL,
  `FKmembres` int(11) NOT NULL,
  `pseudonyme` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `confirme` tinyint(1) NOT NULL,
  `details` tinytext CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `membres`
--

CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudonyme` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `pass` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pass_old` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `sysop` int(11) NOT NULL,
  `moderateur` mediumtext COLLATE utf8_unicode_ci,
  `moderateur_description` mediumtext COLLATE utf8_unicode_ci,
  `bie` int(11) NOT NULL,
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
  `profil_last_edit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `membres_essais_login`
--

CREATE TABLE IF NOT EXISTS `membres_essais_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKmembres` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `ip` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `membres_secrets`
--

CREATE TABLE IF NOT EXISTS `membres_secrets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `FKmembres` int(11) unsigned NOT NULL,
  `FKsecrets` int(11) unsigned NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKmembres_destinataire` int(11) NOT NULL,
  `FKmembres_envoyeur` int(11) NOT NULL,
  `date_envoi` int(11) NOT NULL,
  `date_consultation` int(11) NOT NULL,
  `titre` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_nom` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `page_id` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `visite_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `visite_url` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE IF NOT EXISTS `quotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) unsigned NOT NULL,
  `contenu` longtext,
  `FKauteur` int(11) NOT NULL,
  `valide_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `secrets`
--

CREATE TABLE IF NOT EXISTS `secrets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom` mediumtext,
  `url` mediumtext,
  `titre` mediumtext,
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stats_pageviews`
--

CREATE TABLE IF NOT EXISTS `stats_pageviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `id_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `vues` bigint(20) NOT NULL,
  `vues_lastvisit` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stats_referer`
--

CREATE TABLE IF NOT EXISTS `stats_referer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `alias` text COLLATE utf8_unicode_ci NOT NULL,
  `nombre` int(11) NOT NULL,
  `nombre_lastvisit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `todo_categorie`
--

CREATE TABLE IF NOT EXISTS `todo_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `todo_commentaire`
--

CREATE TABLE IF NOT EXISTS `todo_commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKtodo` int(11) DEFAULT NULL,
  `FKmembres` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `contenu` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `todo_roadmap`
--

CREATE TABLE IF NOT EXISTS `todo_roadmap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_classement` int(11) DEFAULT NULL,
  `version` tinytext,
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vars_globales`
--

CREATE TABLE IF NOT EXISTS `vars_globales` (
  `mise_a_jour` tinyint(1) NOT NULL,
  `last_pageview_check` int(11) NOT NULL,
  `last_referer_check` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `mise_a_jour` (`mise_a_jour`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `version`
--

CREATE TABLE IF NOT EXISTS `version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `build` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
