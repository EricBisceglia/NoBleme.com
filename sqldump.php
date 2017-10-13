<?php header("Location: ."); /************************************************************************************************************/
/*                                                                                                                                       */
/*                                              DUMP DE LA STRUCTURE DE LA BASE DE DONNÉES                                               */
/*                                                                                                                                       */
/******************************************************************************************************************************************

--
-- Base de données :  `nobleme`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

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
  `parent_id` int(11) NOT NULL,
  `parent_titre` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `justification` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20424 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `activite_diff`
--

DROP TABLE IF EXISTS `activite_diff`;
CREATE TABLE IF NOT EXISTS `activite_diff` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `FKactivite` bigint(20) NOT NULL,
  `titre_diff` tinytext NOT NULL,
  `diff` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=479 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `anniv_flash`
--

DROP TABLE IF EXISTS `anniv_flash`;
CREATE TABLE IF NOT EXISTS `anniv_flash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_fichier` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `largeur` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `devblog`
--

DROP TABLE IF EXISTS `devblog`;
CREATE TABLE IF NOT EXISTS `devblog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `titre` mediumtext,
  `resume` mediumtext,
  `contenu` longtext,
  `score_popularite` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `devblog_commentaire`
--

DROP TABLE IF EXISTS `devblog_commentaire`;
CREATE TABLE IF NOT EXISTS `devblog_commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKdevblog` int(11) DEFAULT NULL,
  `FKmembres` int(11) DEFAULT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `contenu` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `forum_loljk`
--

DROP TABLE IF EXISTS `forum_loljk`;
CREATE TABLE IF NOT EXISTS `forum_loljk` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `threadparent` int(11) NOT NULL,
  `FKauteur` int(11) NOT NULL,
  `titre` mediumtext,
  `contenu` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=178 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `invites`
--

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
) ENGINE=MyISAM AUTO_INCREMENT=88910 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `irl`
--

DROP TABLE IF EXISTS `irl`;
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
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `irl_participants`
--

DROP TABLE IF EXISTS `irl_participants`;
CREATE TABLE IF NOT EXISTS `irl_participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKirl` int(11) NOT NULL,
  `FKmembres` int(11) NOT NULL,
  `pseudonyme` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `confirme` tinyint(1) NOT NULL,
  `details` tinytext CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=335 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

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
  `sexe` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `anniversaire` date NOT NULL,
  `region` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `metier` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `profil` longtext COLLATE utf8_unicode_ci NOT NULL,
  `profil_last_edit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=416 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `membres_essais_login`
--

DROP TABLE IF EXISTS `membres_essais_login`;
CREATE TABLE IF NOT EXISTS `membres_essais_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKmembres` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `ip` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `membres_secrets`
--

DROP TABLE IF EXISTS `membres_secrets`;
CREATE TABLE IF NOT EXISTS `membres_secrets` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FKmembres` int(11) UNSIGNED NOT NULL,
  `FKsecrets` int(11) UNSIGNED NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

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
) ENGINE=MyISAM AUTO_INCREMENT=866 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_nom` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `page_id` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `visite_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `visite_url` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quotes`
--

DROP TABLE IF EXISTS `quotes`;
CREATE TABLE IF NOT EXISTS `quotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `contenu` longtext,
  `FKauteur` int(11) NOT NULL,
  `valide_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=245 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `quotes_membres`
--

DROP TABLE IF EXISTS `quotes_membres`;
CREATE TABLE IF NOT EXISTS `quotes_membres` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FKquotes` int(11) UNSIGNED NOT NULL,
  `FKmembres` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=136 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `secrets`
--

DROP TABLE IF EXISTS `secrets`;
CREATE TABLE IF NOT EXISTS `secrets` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` mediumtext,
  `url` mediumtext,
  `titre` mediumtext,
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `stats_pageviews`
--

DROP TABLE IF EXISTS `stats_pageviews`;
CREATE TABLE IF NOT EXISTS `stats_pageviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `url_page` mediumtext COLLATE utf8_unicode_ci,
  `vues` bigint(20) NOT NULL,
  `vues_lastvisit` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `todo`
--

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
) ENGINE=MyISAM AUTO_INCREMENT=374 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `todo_categorie`
--

DROP TABLE IF EXISTS `todo_categorie`;
CREATE TABLE IF NOT EXISTS `todo_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `todo_commentaire`
--

DROP TABLE IF EXISTS `todo_commentaire`;
CREATE TABLE IF NOT EXISTS `todo_commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKtodo` int(11) DEFAULT NULL,
  `FKmembres` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `contenu` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `todo_roadmap`
--

DROP TABLE IF EXISTS `todo_roadmap`;
CREATE TABLE IF NOT EXISTS `todo_roadmap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_classement` int(11) DEFAULT NULL,
  `version` tinytext,
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `vars_globales`
--

DROP TABLE IF EXISTS `vars_globales`;
CREATE TABLE IF NOT EXISTS `vars_globales` (
  `mise_a_jour` tinyint(1) NOT NULL,
  `last_pageview_check` int(11) NOT NULL,
  `last_referer_check` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `mise_a_jour` (`mise_a_jour`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `version`
--

DROP TABLE IF EXISTS `version`;
CREATE TABLE IF NOT EXISTS `version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `build` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;