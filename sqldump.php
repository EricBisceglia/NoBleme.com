<?php header("Location: ."); /************************************************************************************************************/
/*                                                                                                                                       */
/*                                              DUMP DE LA STRUCTURE DE LA BASE DE DONNÉES                                               */
/*                                                                                                                                       */
/******************************************************************************************************************************************
/*                                                                                                                                       */
/*  Méthode d'exportation : Personnalisée                                                                                                */
/*  Ne pas exporter les données (structure uniquement)                                                                                   */
/*  Afficher les résultats (ne pas diriger vers un fichier)                                                                              */
/*  Ne pas afficher les commentaires                                                                                                     */
/*  Ajouter tous les énoncés sauf la valeur des auto increment                                                                           */
/*  Syntaxe : N'utiliser aucun mode prédéfini (insert into T values X)                                                                   */
/*                                                                                                                                       */
/******************************************************************************************************************************************

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `nobleme` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `nobleme`;

DROP TABLE IF EXISTS `activite`;
CREATE TABLE IF NOT EXISTS `activite` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `log_moderation` tinyint(1) NOT NULL,
  `FKmembres` int(11) NOT NULL,
  `pseudonyme` tinytext COLLATE utf8mb4_unicode_ci,
  `action_type` tinytext COLLATE utf8mb4_unicode_ci,
  `action_id` int(11) NOT NULL,
  `action_titre` mediumtext COLLATE utf8mb4_unicode_ci,
  `parent` mediumtext COLLATE utf8mb4_unicode_ci,
  `justification` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_membres` (`FKmembres`),
  KEY `index_action` (`action_id`),
  KEY `index_type` (`action_type`(10))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `activite_diff`;
CREATE TABLE IF NOT EXISTS `activite_diff` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `FKactivite` bigint(20) NOT NULL,
  `titre_diff` tinytext COLLATE utf8mb4_unicode_ci,
  `diff_avant` longtext COLLATE utf8mb4_unicode_ci,
  `diff_apres` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_activite` (`FKactivite`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `automatisation`;
CREATE TABLE IF NOT EXISTS `automatisation` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `action_id` int(11) UNSIGNED NOT NULL,
  `action_type` mediumtext COLLATE utf8mb4_unicode_ci,
  `action_description` mediumtext COLLATE utf8mb4_unicode_ci,
  `action_timestamp` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_action` (`action_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `devblog`;
CREATE TABLE IF NOT EXISTS `devblog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `titre` mediumtext COLLATE utf8mb4_unicode_ci,
  `contenu` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ecrivains_concours`;
CREATE TABLE IF NOT EXISTS `ecrivains_concours` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FKmembres_gagnant` int(11) UNSIGNED NOT NULL,
  `FKecrivains_texte_gagnant` int(11) UNSIGNED NOT NULL,
  `timestamp_debut` int(11) UNSIGNED NOT NULL,
  `timestamp_fin` int(11) UNSIGNED NOT NULL,
  `num_participants` int(11) UNSIGNED NOT NULL,
  `titre` text COLLATE utf8mb4_unicode_ci,
  `sujet` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_gagnant` (`FKecrivains_texte_gagnant`,`FKmembres_gagnant`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ecrivains_concours_vote`;
CREATE TABLE IF NOT EXISTS `ecrivains_concours_vote` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FKecrivains_concours` int(11) UNSIGNED NOT NULL,
  `FKecrivains_texte` int(11) UNSIGNED NOT NULL,
  `FKmembres` int(11) UNSIGNED NOT NULL,
  `poids_vote` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_texte` (`FKecrivains_concours`),
  KEY `index_concours` (`FKecrivains_texte`),
  KEY `index_membre` (`FKmembres`),
  KEY `index_poids` (`poids_vote`,`FKmembres`,`FKecrivains_texte`,`FKecrivains_concours`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ecrivains_note`;
CREATE TABLE IF NOT EXISTS `ecrivains_note` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FKecrivains_texte` int(11) UNSIGNED NOT NULL,
  `FKmembres` int(11) UNSIGNED NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `note` decimal(2,1) DEFAULT NULL,
  `anonyme` tinyint(1) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_texte` (`FKecrivains_texte`),
  KEY `index_membre` (`FKmembres`),
  KEY `index_note` (`note`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ecrivains_texte`;
CREATE TABLE IF NOT EXISTS `ecrivains_texte` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FKmembres` int(11) UNSIGNED NOT NULL,
  `FKecrivains_concours` int(11) UNSIGNED NOT NULL,
  `anonyme` tinyint(1) UNSIGNED NOT NULL,
  `timestamp_creation` int(11) UNSIGNED NOT NULL,
  `timestamp_modification` int(11) UNSIGNED NOT NULL,
  `niveau_feedback` int(4) UNSIGNED NOT NULL,
  `titre` text COLLATE utf8mb4_unicode_ci,
  `note_moyenne` decimal(2,1) DEFAULT NULL,
  `longueur_texte` int(11) UNSIGNED NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_auteur` (`anonyme`,`FKmembres`),
  KEY `index_concours` (`FKecrivains_concours`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `forum_categorie`;
CREATE TABLE IF NOT EXISTS `forum_categorie` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `par_defaut` tinyint(1) UNSIGNED NOT NULL,
  `classement` int(11) UNSIGNED NOT NULL,
  `nom_fr` tinytext COLLATE utf8mb4_unicode_ci,
  `nom_en` tinytext COLLATE utf8mb4_unicode_ci,
  `description_fr` mediumtext COLLATE utf8mb4_unicode_ci,
  `description_en` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_classement` (`par_defaut`,`classement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `forum_filtrage`;
CREATE TABLE IF NOT EXISTS `forum_filtrage` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FKmembres` int(11) UNSIGNED NOT NULL,
  `FKforum_categorie` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_membres` (`FKmembres`),
  KEY `index_categorie` (`FKforum_categorie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `forum_message`;
CREATE TABLE IF NOT EXISTS `forum_message` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FKforum_sujet` int(11) UNSIGNED NOT NULL,
  `FKforum_message_parent` int(11) UNSIGNED NOT NULL,
  `FKmembres` int(11) UNSIGNED NOT NULL,
  `timestamp_creation` int(11) UNSIGNED NOT NULL,
  `timestamp_modification` int(11) UNSIGNED NOT NULL,
  `message_supprime` tinyint(1) UNSIGNED NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_sujet` (`FKforum_sujet`),
  KEY `index_parent` (`FKforum_message_parent`),
  KEY `index_membres` (`FKmembres`),
  KEY `index_chronologie` (`timestamp_creation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `forum_sujet`;
CREATE TABLE IF NOT EXISTS `forum_sujet` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FKmembres_createur` int(11) UNSIGNED NOT NULL,
  `FKmembres_dernier_message` int(11) UNSIGNED NOT NULL,
  `FKforum_categorie` int(11) UNSIGNED NOT NULL,
  `timestamp_creation` int(11) UNSIGNED NOT NULL,
  `timestamp_dernier_message` int(11) UNSIGNED NOT NULL,
  `apparence` tinytext COLLATE utf8mb4_unicode_ci,
  `classification` tinytext COLLATE utf8mb4_unicode_ci,
  `public` tinyint(1) UNSIGNED NOT NULL,
  `ouvert` tinyint(1) UNSIGNED NOT NULL,
  `epingle` tinyint(1) UNSIGNED NOT NULL,
  `langue` tinytext COLLATE utf8mb4_unicode_ci,
  `titre` mediumtext COLLATE utf8mb4_unicode_ci,
  `nombre_reponses` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_createur` (`FKmembres_createur`),
  KEY `index_dernier` (`FKmembres_dernier_message`),
  KEY `index_categorie` (`FKforum_categorie`),
  KEY `index_chronologie` (`timestamp_dernier_message`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `invites`;
CREATE TABLE IF NOT EXISTS `invites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surnom` mediumtext COLLATE utf8mb4_unicode_ci,
  `derniere_visite` int(11) NOT NULL,
  `derniere_visite_page` mediumtext COLLATE utf8mb4_unicode_ci,
  `derniere_visite_url` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `irc_canaux`;
CREATE TABLE IF NOT EXISTS `irc_canaux` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `canal` tinytext COLLATE utf8mb4_unicode_ci,
  `langue` tinytext COLLATE utf8mb4_unicode_ci,
  `importance` tinyint(1) NOT NULL,
  `description_fr` mediumtext COLLATE utf8mb4_unicode_ci,
  `description_en` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `irl`;
CREATE TABLE IF NOT EXISTS `irl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `lieu` tinytext COLLATE utf8mb4_unicode_ci,
  `raison_fr` tinytext COLLATE utf8mb4_unicode_ci,
  `raison_en` tinytext COLLATE utf8mb4_unicode_ci,
  `details_fr` longtext COLLATE utf8mb4_unicode_ci,
  `details_en` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `irl_participants`;
CREATE TABLE IF NOT EXISTS `irl_participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKirl` int(11) NOT NULL,
  `FKmembres` int(11) NOT NULL,
  `pseudonyme` tinytext COLLATE utf8mb4_unicode_ci,
  `confirme` tinyint(1) NOT NULL,
  `details_fr` tinytext COLLATE utf8mb4_unicode_ci,
  `details_en` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_irl` (`FKirl`),
  KEY `index_membres` (`FKmembres`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudonyme` tinytext COLLATE utf8mb4_unicode_ci,
  `pass` mediumtext COLLATE utf8mb4_unicode_ci,
  `admin` tinyint(1) NOT NULL,
  `sysop` int(11) NOT NULL,
  `moderateur` mediumtext COLLATE utf8mb4_unicode_ci,
  `moderateur_description_fr` mediumtext COLLATE utf8mb4_unicode_ci,
  `moderateur_description_en` mediumtext COLLATE utf8mb4_unicode_ci,
  `email` tinytext COLLATE utf8mb4_unicode_ci,
  `date_creation` int(11) NOT NULL,
  `derniere_visite` int(11) NOT NULL,
  `derniere_visite_page` mediumtext COLLATE utf8mb4_unicode_ci,
  `derniere_visite_url` mediumtext COLLATE utf8mb4_unicode_ci,
  `derniere_visite_ip` tinytext COLLATE utf8mb4_unicode_ci,
  `derniere_activite` int(11) UNSIGNED NOT NULL,
  `banni_date` int(11) NOT NULL,
  `banni_raison` mediumtext COLLATE utf8mb4_unicode_ci,
  `langue` tinytext COLLATE utf8mb4_unicode_ci,
  `genre` tinytext COLLATE utf8mb4_unicode_ci,
  `anniversaire` date NOT NULL,
  `habite` tinytext COLLATE utf8mb4_unicode_ci,
  `metier` tinytext COLLATE utf8mb4_unicode_ci,
  `profil` longtext COLLATE utf8mb4_unicode_ci,
  `forum_messages` int(11) UNSIGNED NOT NULL,
  `forum_lang` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_login` (`pseudonyme`(20),`pass`(60)),
  KEY `index_droits` (`admin`,`sysop`,`moderateur`(10))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `membres_essais_login`;
CREATE TABLE IF NOT EXISTS `membres_essais_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKmembres` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `ip` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_membres` (`FKmembres`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `nbdb_web_categorie`;
CREATE TABLE IF NOT EXISTS `nbdb_web_categorie` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre_fr` mediumtext COLLATE utf8mb4_unicode_ci,
  `titre_en` mediumtext COLLATE utf8mb4_unicode_ci,
  `ordre_affichage` int(11) UNSIGNED NOT NULL,
  `description_fr` mediumtext COLLATE utf8mb4_unicode_ci,
  `description_en` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_ordre_affichage` (`ordre_affichage`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `nbdb_web_definition`;
CREATE TABLE IF NOT EXISTS `nbdb_web_definition` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre_fr` mediumtext COLLATE utf8mb4_unicode_ci,
  `titre_en` mediumtext COLLATE utf8mb4_unicode_ci,
  `redirection_fr` mediumtext COLLATE utf8mb4_unicode_ci,
  `redirection_en` mediumtext COLLATE utf8mb4_unicode_ci,
  `definition_fr` longtext COLLATE utf8mb4_unicode_ci,
  `definition_en` longtext COLLATE utf8mb4_unicode_ci,
  `est_vulgaire` tinyint(1) DEFAULT NULL,
  `est_politise` tinyint(1) DEFAULT NULL,
  `est_incorrect` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_titre_fr` (`titre_fr`(25)),
  KEY `index_titre_en` (`titre_en`(25))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `nbdb_web_image`;
CREATE TABLE IF NOT EXISTS `nbdb_web_image` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `timestamp_upload` int(11) UNSIGNED NOT NULL,
  `nom_fichier` mediumtext COLLATE utf8mb4_unicode_ci,
  `tags` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `nbdb_web_page`;
CREATE TABLE IF NOT EXISTS `nbdb_web_page` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FKnbdb_web_periode` int(11) UNSIGNED NOT NULL,
  `titre_fr` mediumtext COLLATE utf8mb4_unicode_ci,
  `titre_en` mediumtext COLLATE utf8mb4_unicode_ci,
  `redirection_fr` mediumtext COLLATE utf8mb4_unicode_ci,
  `redirection_en` mediumtext COLLATE utf8mb4_unicode_ci,
  `contenu_fr` longtext COLLATE utf8mb4_unicode_ci,
  `contenu_en` longtext COLLATE utf8mb4_unicode_ci,
  `annee_apparition` int(4) DEFAULT NULL,
  `mois_apparition` int(2) DEFAULT NULL,
  `annee_popularisation` int(4) DEFAULT NULL,
  `mois_popularisation` int(2) DEFAULT NULL,
  `est_vulgaire` tinyint(1) DEFAULT NULL,
  `est_politise` tinyint(1) DEFAULT NULL,
  `est_incorrect` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_periode` (`FKnbdb_web_periode`),
  KEY `index_apparition` (`annee_apparition`,`mois_apparition`),
  KEY `index_popularisation` (`annee_popularisation`,`mois_popularisation`),
  KEY `index_titre_fr` (`titre_fr`(25)),
  KEY `index_titre_en` (`titre_en`(25))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `nbdb_web_page_categorie`;
CREATE TABLE IF NOT EXISTS `nbdb_web_page_categorie` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FKnbdb_web_page` int(11) UNSIGNED NOT NULL,
  `FKnbdb_web_categorie` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_pages` (`FKnbdb_web_page`,`FKnbdb_web_categorie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `nbdb_web_periode`;
CREATE TABLE IF NOT EXISTS `nbdb_web_periode` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre_fr` mediumtext COLLATE utf8mb4_unicode_ci,
  `titre_en` mediumtext COLLATE utf8mb4_unicode_ci,
  `description_fr` mediumtext COLLATE utf8mb4_unicode_ci,
  `description_en` mediumtext COLLATE utf8mb4_unicode_ci,
  `annee_debut` int(4) DEFAULT NULL,
  `annee_fin` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKmembres_destinataire` int(11) NOT NULL,
  `FKmembres_envoyeur` int(11) NOT NULL,
  `date_envoi` int(11) NOT NULL,
  `date_consultation` int(11) NOT NULL,
  `titre` mediumtext COLLATE utf8mb4_unicode_ci,
  `contenu` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_destinataire` (`FKmembres_destinataire`),
  KEY `index_envoyeur` (`FKmembres_envoyeur`),
  KEY `index_chronologie` (`date_envoi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pageviews`;
CREATE TABLE IF NOT EXISTS `pageviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_page` mediumtext COLLATE utf8mb4_unicode_ci,
  `url_page` mediumtext COLLATE utf8mb4_unicode_ci,
  `vues` bigint(20) NOT NULL,
  `vues_lastvisit` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_tri` (`vues`,`vues_lastvisit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `quotes`;
CREATE TABLE IF NOT EXISTS `quotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci,
  `FKauteur` int(11) NOT NULL,
  `valide_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_membres` (`FKauteur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `quotes_membres`;
CREATE TABLE IF NOT EXISTS `quotes_membres` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FKquotes` int(11) UNSIGNED NOT NULL,
  `FKmembres` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_quotes` (`FKquotes`),
  KEY `index_membres` (`FKmembres`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `todo`;
CREATE TABLE IF NOT EXISTS `todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKmembres` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `importance` int(11) DEFAULT NULL,
  `titre` mediumtext COLLATE utf8mb4_unicode_ci,
  `contenu` longtext COLLATE utf8mb4_unicode_ci,
  `FKtodo_categorie` int(11) DEFAULT NULL,
  `FKtodo_roadmap` int(11) DEFAULT NULL,
  `valide_admin` tinyint(1) DEFAULT NULL,
  `public` tinyint(1) DEFAULT NULL,
  `timestamp_fini` int(11) DEFAULT NULL,
  `source` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_membres` (`FKmembres`),
  KEY `index_categorie` (`FKtodo_categorie`),
  KEY `index_roadmap` (`FKtodo_roadmap`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `todo_categorie`;
CREATE TABLE IF NOT EXISTS `todo_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `todo_roadmap`;
CREATE TABLE IF NOT EXISTS `todo_roadmap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_classement` int(11) DEFAULT NULL,
  `version` tinytext COLLATE utf8mb4_unicode_ci,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `index_classement` (`id_classement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `vars_globales`;
CREATE TABLE IF NOT EXISTS `vars_globales` (
  `mise_a_jour` tinyint(1) NOT NULL,
  `last_pageview_check` int(11) NOT NULL,
  UNIQUE KEY `mise_a_jour` (`mise_a_jour`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `version`;
CREATE TABLE IF NOT EXISTS `version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` tinytext COLLATE utf8mb4_unicode_ci,
  `build` tinytext COLLATE utf8mb4_unicode_ci,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `forum_message` ADD FULLTEXT KEY `index_contenu` (`contenu`);

ALTER TABLE `forum_sujet` ADD FULLTEXT KEY `index_titre` (`titre`);

ALTER TABLE `nbdb_web_categorie` ADD FULLTEXT KEY `index_description_fr` (`description_fr`);
ALTER TABLE `nbdb_web_categorie` ADD FULLTEXT KEY `index_description_en` (`description_en`);

ALTER TABLE `nbdb_web_definition` ADD FULLTEXT KEY `index_definition_en` (`definition_en`);
ALTER TABLE `nbdb_web_definition` ADD FULLTEXT KEY `index_definition_fr` (`definition_fr`);

ALTER TABLE `nbdb_web_page` ADD FULLTEXT KEY `index_contenu_en` (`contenu_en`);
ALTER TABLE `nbdb_web_page` ADD FULLTEXT KEY `index_contenu_fr` (`contenu_fr`);

ALTER TABLE `pageviews` ADD FULLTEXT KEY `index_recherche` (`nom_page`,`url_page`);

ALTER TABLE `todo` ADD FULLTEXT KEY `index_titre` (`titre`);
