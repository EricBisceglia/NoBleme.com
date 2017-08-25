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

-- --------------------------------------------------------

--
-- Structure de la table `activite_diff`
--

CREATE TABLE `activite_diff` (
  `id` bigint(20) NOT NULL,
  `FKactivite` bigint(20) NOT NULL,
  `titre_diff` tinytext NOT NULL,
  `diff` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `anniv_flash`
--

CREATE TABLE `anniv_flash` (
  `id` int(11) NOT NULL,
  `nom_fichier` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `largeur` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `devblog`
--

CREATE TABLE `devblog` (
  `id` int(11) NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `titre` mediumtext,
  `resume` mediumtext,
  `contenu` longtext,
  `score_popularite` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `devblog_commentaire`
--

CREATE TABLE `devblog_commentaire` (
  `id` int(11) NOT NULL,
  `FKdevblog` int(11) DEFAULT NULL,
  `FKmembres` int(11) DEFAULT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `contenu` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `forum_loljk`
--

CREATE TABLE `forum_loljk` (
  `id` int(11) UNSIGNED NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `threadparent` int(11) NOT NULL,
  `FKauteur` int(11) NOT NULL,
  `titre` mediumtext,
  `contenu` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `invites`
--

CREATE TABLE `invites` (
  `id` int(11) NOT NULL,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surnom` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `derniere_visite` int(11) NOT NULL,
  `derniere_visite_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `derniere_visite_url` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `irl`
--

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

-- --------------------------------------------------------

--
-- Structure de la table `irl_participants`
--

CREATE TABLE `irl_participants` (
  `id` int(11) NOT NULL,
  `FKirl` int(11) NOT NULL,
  `FKmembres` int(11) NOT NULL,
  `pseudonyme` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `confirme` tinyint(1) NOT NULL,
  `details` tinytext CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id` int(11) NOT NULL,
  `pseudonyme` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `pass` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `sysop` int(11) NOT NULL,
  `moderateur` mediumtext COLLATE utf8_unicode_ci,
  `moderateur_description` mediumtext COLLATE utf8_unicode_ci,
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

-- --------------------------------------------------------

--
-- Structure de la table `membres_essais_login`
--

CREATE TABLE `membres_essais_login` (
  `id` int(11) NOT NULL,
  `FKmembres` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `ip` tinytext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `membres_secrets`
--

CREATE TABLE `membres_secrets` (
  `id` int(11) UNSIGNED NOT NULL,
  `FKmembres` int(11) UNSIGNED NOT NULL,
  `FKsecrets` int(11) UNSIGNED NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `nbrpg_chatlog`
--

CREATE TABLE `nbrpg_chatlog` (
  `id` int(11) UNSIGNED NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `FKmembres` int(11) UNSIGNED NOT NULL,
  `nom_perso` mediumtext,
  `type_chat` tinytext,
  `message` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `nbrpg_effets`
--

CREATE TABLE `nbrpg_effets` (
  `id` int(11) UNSIGNED NOT NULL,
  `nom` mediumtext,
  `duree` int(11) UNSIGNED NOT NULL,
  `description` longtext,
  `flavortext` longtext,
  `url_icone` mediumtext,
  `supprimer_avant_et_apres_combat` tinyint(1) UNSIGNED NOT NULL,
  `ne_peut_pas_etre_debuff` tinyint(1) UNSIGNED NOT NULL,
  `reduction_effet_par_tour` int(11) NOT NULL,
  `reduction_effet_par_tour_pourcent` int(11) NOT NULL,
  `paralysie` tinyint(1) UNSIGNED NOT NULL,
  `degats` int(11) NOT NULL,
  `ne_peut_pas_tuer` tinyint(1) UNSIGNED NOT NULL,
  `buff_precision` int(11) NOT NULL,
  `buff_degats` int(11) NOT NULL,
  `buff_degats_pourcent` int(11) NOT NULL,
  `buff_hpmax` int(11) NOT NULL,
  `buff_hpmax_pourcent` int(11) NOT NULL,
  `buff_danger` int(11) NOT NULL,
  `buff_danger_pourcent` int(11) NOT NULL,
  `buff_physique` int(11) NOT NULL,
  `buff_physique_pourcent` int(11) NOT NULL,
  `buff_mental` int(11) NOT NULL,
  `buff_mental_pourcent` int(11) NOT NULL,
  `reduction_degats` int(11) NOT NULL,
  `reduction_degats_pourcent` int(11) NOT NULL,
  `amplification_soins` int(11) NOT NULL,
  `amplification_soins_pourcent` int(11) NOT NULL,
  `amplification_soins_recus` int(11) NOT NULL,
  `amplification_soins_recus_pourcent` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `nbrpg_monstres`
--

CREATE TABLE `nbrpg_monstres` (
  `id` int(11) UNSIGNED NOT NULL,
  `nom` mediumtext,
  `type` mediumtext,
  `description_publique` longtext,
  `max_vie` int(11) UNSIGNED NOT NULL,
  `type_degats` mediumtext,
  `degats_pourcent_physique` int(11) UNSIGNED NOT NULL,
  `degats_pourcent_mental` int(11) UNSIGNED NOT NULL,
  `attaque_precision` int(11) UNSIGNED NOT NULL,
  `physique` int(11) UNSIGNED NOT NULL,
  `mental` int(11) UNSIGNED NOT NULL,
  `danger` int(11) UNSIGNED NOT NULL,
  `resistance_physique` int(11) NOT NULL,
  `resistance_magique` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `nbrpg_objets`
--

CREATE TABLE `nbrpg_objets` (
  `id` int(11) UNSIGNED NOT NULL,
  `nom` mediumtext,
  `description` longtext,
  `flavortext` longtext,
  `niveau` int(11) UNSIGNED NOT NULL,
  `type` mediumtext,
  `rarete` mediumtext,
  `FKnbrpg_effets_passif` int(11) UNSIGNED NOT NULL,
  `FKnbrpg_effets_passif2` int(11) UNSIGNED NOT NULL,
  `FKnbrpg_effets_utilisation` int(11) UNSIGNED NOT NULL,
  `effets_utilisation_probabilite` int(11) UNSIGNED NOT NULL,
  `FKnbrpg_effets_utilisation2` int(11) UNSIGNED NOT NULL,
  `effets_utilisation_probabilite2` int(11) UNSIGNED NOT NULL,
  `type_degats` mediumtext,
  `degats_pourcent_physique` int(11) UNSIGNED NOT NULL,
  `degats_pourcent_mental` int(11) UNSIGNED NOT NULL,
  `attaque_precision` int(11) UNSIGNED NOT NULL,
  `buff_precision` int(11) NOT NULL,
  `buff_hpmax` int(11) NOT NULL,
  `buff_hpmax_pourcent` int(11) NOT NULL,
  `buff_danger` int(11) NOT NULL,
  `buff_danger_pourcent` int(11) NOT NULL,
  `buff_physique` int(11) NOT NULL,
  `buff_physique_pourcent` int(11) NOT NULL,
  `buff_mental` int(11) NOT NULL,
  `buff_mental_pourcent` int(11) NOT NULL,
  `reduction_degats` int(11) NOT NULL,
  `reduction_degats_pourcent` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `nbrpg_persos`
--

CREATE TABLE `nbrpg_persos` (
  `id` int(11) UNSIGNED NOT NULL,
  `FKmembres` int(11) UNSIGNED NOT NULL,
  `couleur_chat` tinytext,
  `dernier_chat_rp` int(11) UNSIGNED NOT NULL,
  `dernier_chat_hrp` int(11) UNSIGNED NOT NULL,
  `date_creation` int(11) UNSIGNED NOT NULL,
  `nom` mediumtext,
  `niveau` int(11) UNSIGNED NOT NULL,
  `experience` int(11) UNSIGNED NOT NULL,
  `prochain_niveau` int(11) UNSIGNED NOT NULL,
  `max_vie` int(11) UNSIGNED NOT NULL,
  `max_charges_oracle` int(11) UNSIGNED NOT NULL,
  `physique` int(11) UNSIGNED NOT NULL,
  `mental` int(11) UNSIGNED NOT NULL,
  `danger` int(11) UNSIGNED NOT NULL,
  `niveau_non_assigne` int(11) UNSIGNED NOT NULL,
  `niveau_combat` int(11) UNSIGNED NOT NULL,
  `niveau_magie` int(11) UNSIGNED NOT NULL,
  `niveau_strategie` int(11) UNSIGNED NOT NULL,
  `niveau_medecine` int(11) UNSIGNED NOT NULL,
  `niveau_aventure` int(11) UNSIGNED NOT NULL,
  `FKnbrpg_objets_arme` int(11) UNSIGNED NOT NULL,
  `FKnbrpg_objets_costume` int(11) UNSIGNED NOT NULL,
  `FKnbrpg_objets_objet1` int(11) UNSIGNED NOT NULL,
  `FKnbrpg_objets_objet2` int(11) UNSIGNED NOT NULL,
  `FKnbrpg_objets_objet3` int(11) UNSIGNED NOT NULL,
  `FKnbrpg_objets_objet4` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `nbrpg_session`
--

CREATE TABLE `nbrpg_session` (
  `id` int(11) UNSIGNED NOT NULL,
  `FKnbrpg_persos` int(11) UNSIGNED NOT NULL,
  `FKnbrpg_monstres` int(11) UNSIGNED NOT NULL,
  `monstre_niveau` int(11) UNSIGNED NOT NULL,
  `vie` int(11) UNSIGNED NOT NULL,
  `energie` int(11) UNSIGNED NOT NULL,
  `charges_oracle` int(11) UNSIGNED NOT NULL,
  `physique` int(11) UNSIGNED NOT NULL,
  `mental` int(11) UNSIGNED NOT NULL,
  `danger` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `nbrpg_session_effets`
--

CREATE TABLE `nbrpg_session_effets` (
  `id` int(11) UNSIGNED NOT NULL,
  `FKnbrpg_session` int(11) UNSIGNED NOT NULL,
  `FKnbrpg_effets` int(11) UNSIGNED NOT NULL,
  `duree_restante` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `FKmembres_destinataire` int(11) NOT NULL,
  `FKmembres_envoyeur` int(11) NOT NULL,
  `date_envoi` int(11) NOT NULL,
  `date_consultation` int(11) NOT NULL,
  `titre` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page_nom` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `page_id` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `visite_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `visite_url` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quotes`
--

CREATE TABLE `quotes` (
  `id` int(11) NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `contenu` longtext,
  `FKauteur` int(11) NOT NULL,
  `valide_admin` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `quotes_membres`
--

CREATE TABLE `quotes_membres` (
  `id` int(11) UNSIGNED NOT NULL,
  `FKquotes` int(11) UNSIGNED NOT NULL,
  `FKmembres` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `secrets`
--

CREATE TABLE `secrets` (
  `id` int(11) UNSIGNED NOT NULL,
  `nom` mediumtext,
  `url` mediumtext,
  `titre` mediumtext,
  `description` mediumtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `stats_pageviews`
--

CREATE TABLE `stats_pageviews` (
  `id` int(11) NOT NULL,
  `nom_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `id_page` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `vues` bigint(20) NOT NULL,
  `vues_lastvisit` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stats_referer`
--

CREATE TABLE `stats_referer` (
  `id` int(11) NOT NULL,
  `source` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `alias` text COLLATE utf8_unicode_ci NOT NULL,
  `nombre` int(11) NOT NULL,
  `nombre_lastvisit` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `todo`
--

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

-- --------------------------------------------------------

--
-- Structure de la table `todo_categorie`
--

CREATE TABLE `todo_categorie` (
  `id` int(11) NOT NULL,
  `categorie` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `todo_commentaire`
--

CREATE TABLE `todo_commentaire` (
  `id` int(11) NOT NULL,
  `FKtodo` int(11) DEFAULT NULL,
  `FKmembres` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `contenu` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `todo_roadmap`
--

CREATE TABLE `todo_roadmap` (
  `id` int(11) NOT NULL,
  `id_classement` int(11) DEFAULT NULL,
  `version` tinytext,
  `description` mediumtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `vars_globales`
--

CREATE TABLE `vars_globales` (
  `mise_a_jour` tinyint(1) NOT NULL,
  `last_pageview_check` int(11) NOT NULL,
  `last_referer_check` text COLLATE utf8_unicode_ci NOT NULL,
  `nbrpg_activite` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `version`
--

CREATE TABLE `version` (
  `id` int(11) NOT NULL,
  `version` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `build` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
