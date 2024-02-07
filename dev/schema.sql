SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `nobleme` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `nobleme`;

DROP TABLE IF EXISTS `compendium_admin_tools`;
CREATE TABLE IF NOT EXISTS `compendium_admin_tools` (
  `global_notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `snippets` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_en` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_fr` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `compendium_categories`;
CREATE TABLE IF NOT EXISTS `compendium_categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `display_order` int UNSIGNED NOT NULL DEFAULT '0',
  `name_en` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_fr` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description_fr` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_display_order` (`display_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `compendium_eras`;
CREATE TABLE IF NOT EXISTS `compendium_eras` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `year_start` smallint UNSIGNED NOT NULL DEFAULT '0',
  `year_end` smallint UNSIGNED NOT NULL DEFAULT '0',
  `name_en` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_fr` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name_en` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name_fr` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description_fr` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `compendium_images`;
CREATE TABLE IF NOT EXISTS `compendium_images` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_deleted` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `uploaded_at` int UNSIGNED NOT NULL DEFAULT '0',
  `file_name` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_count` int UNSIGNED NOT NULL DEFAULT '0',
  `last_seen_on` int UNSIGNED NOT NULL DEFAULT '0',
  `is_nsfw` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_gross` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_offensive` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `used_in_pages_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `used_in_pages_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption_en` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption_fr` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_deleted` (`is_deleted`),
  KEY `index_seen` (`last_seen_on`),
  KEY `index_views` (`view_count`),
  KEY `index_uploaded` (`uploaded_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `compendium_missing`;
CREATE TABLE IF NOT EXISTS `compendium_missing` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_compendium_types` int UNSIGNED NOT NULL DEFAULT '0',
  `page_url` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_a_priority` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_url` (`page_url`(250))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `compendium_pages`;
CREATE TABLE IF NOT EXISTS `compendium_pages` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_compendium_types` int UNSIGNED NOT NULL DEFAULT '0',
  `fk_compendium_eras` int UNSIGNED NOT NULL DEFAULT '0',
  `is_deleted` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_draft` tinyint NOT NULL DEFAULT '0',
  `created_at` int UNSIGNED NOT NULL,
  `last_edited_at` int UNSIGNED NOT NULL,
  `page_url` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_fr` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirection_en` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirection_fr` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_external_redirection` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `view_count` int UNSIGNED NOT NULL DEFAULT '0',
  `last_seen_on` int UNSIGNED NOT NULL DEFAULT '0',
  `year_appeared` smallint UNSIGNED NOT NULL DEFAULT '0',
  `month_appeared` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `year_peak` smallint UNSIGNED NOT NULL DEFAULT '0',
  `month_peak` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_nsfw` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_gross` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_offensive` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `title_is_nsfw` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `summary_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `definition_en` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `definition_fr` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `character_count_en` int UNSIGNED NOT NULL DEFAULT '0',
  `character_count_fr` int UNSIGNED NOT NULL DEFAULT '0',
  `admin_notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_urls` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_type` (`fk_compendium_types`),
  KEY `index_era` (`fk_compendium_eras`),
  KEY `index_activity` (`created_at`,`last_edited_at`),
  KEY `index_url` (`page_url`(250)),
  KEY `index_appeared` (`year_appeared`,`month_appeared`),
  KEY `index_spread` (`year_peak`,`month_peak`),
  KEY `index_deleted` (`is_deleted`),
  KEY `index_seen` (`last_seen_on`),
  KEY `index_views` (`view_count`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `compendium_pages_categories`;
CREATE TABLE IF NOT EXISTS `compendium_pages_categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_compendium_pages` int UNSIGNED NOT NULL DEFAULT '0',
  `fk_compendium_categories` int UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_page` (`fk_compendium_pages`),
  KEY `index_category` (`fk_compendium_categories`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `compendium_pages_history`;
CREATE TABLE IF NOT EXISTS `compendium_pages_history` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_compendium_pages` int UNSIGNED NOT NULL,
  `edited_at` int UNSIGNED NOT NULL,
  `is_major_edit` tinyint UNSIGNED NOT NULL,
  `summary_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_page` (`fk_compendium_pages`),
  KEY `index_history` (`edited_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `compendium_types`;
CREATE TABLE IF NOT EXISTS `compendium_types` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `display_order` int UNSIGNED NOT NULL DEFAULT '0',
  `name_en` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_fr` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_fr` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_display_order` (`display_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dev_blogs`;
CREATE TABLE IF NOT EXISTS `dev_blogs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_deleted` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `posted_at` int UNSIGNED NOT NULL DEFAULT '0',
  `title_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_fr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_en` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_fr` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_deleted` (`is_deleted`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dev_tasks`;
CREATE TABLE IF NOT EXISTS `dev_tasks` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_users` int UNSIGNED NOT NULL DEFAULT '0',
  `is_deleted` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` int UNSIGNED NOT NULL DEFAULT '0',
  `finished_at` int UNSIGNED NOT NULL DEFAULT '0',
  `admin_validation` int UNSIGNED NOT NULL DEFAULT '0',
  `is_public` int UNSIGNED NOT NULL DEFAULT '0',
  `priority_level` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `title_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_dev_tasks_categories` int UNSIGNED NOT NULL DEFAULT '0',
  `fk_dev_tasks_milestones` int UNSIGNED NOT NULL DEFAULT '0',
  `source_code_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_author` (`fk_users`),
  KEY `index_category` (`fk_dev_tasks_categories`),
  KEY `index_milestone` (`fk_dev_tasks_milestones`),
  KEY `index_deleted` (`is_deleted`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dev_tasks_categories`;
CREATE TABLE IF NOT EXISTS `dev_tasks_categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_archived` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `title_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_fr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dev_tasks_milestones`;
CREATE TABLE IF NOT EXISTS `dev_tasks_milestones` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_archived` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `sorting_order` int UNSIGNED NOT NULL DEFAULT '0',
  `title_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary_en` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary_fr` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_sorting_order` (`sorting_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `irc_channels`;
CREATE TABLE IF NOT EXISTS `irc_channels` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(153) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel_type` int UNSIGNED NOT NULL DEFAULT '0',
  `languages` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_channel_type` (`channel_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `logs_activity`;
CREATE TABLE IF NOT EXISTS `logs_activity` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_users` int UNSIGNED NOT NULL DEFAULT '0',
  `is_deleted` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `happened_at` int UNSIGNED NOT NULL DEFAULT '0',
  `is_moderators_only` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `language` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_id` int UNSIGNED NOT NULL DEFAULT '0',
  `activity_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_amount` int UNSIGNED NOT NULL DEFAULT '0',
  `activity_summary_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_summary_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_username` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_moderator_username` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `moderation_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_related_user` (`fk_users`),
  KEY `index_language` (`language`),
  KEY `index_related_foreign_key` (`activity_id`),
  KEY `index_activity_type` (`activity_type`),
  KEY `index_deleted` (`is_deleted`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `logs_activity_details`;
CREATE TABLE IF NOT EXISTS `logs_activity_details` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_logs_activity` int UNSIGNED NOT NULL DEFAULT '0',
  `content_description_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_description_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_before` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_after` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_logs_activity` (`fk_logs_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `logs_bans`;
CREATE TABLE IF NOT EXISTS `logs_bans` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_banned_user` int UNSIGNED NOT NULL DEFAULT '0',
  `banned_ip_address` varchar(156) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_a_total_ip_ban` tinyint NOT NULL DEFAULT '0',
  `fk_banned_by_user` int UNSIGNED NOT NULL DEFAULT '0',
  `fk_unbanned_by_user` int UNSIGNED NOT NULL DEFAULT '0',
  `banned_at` int UNSIGNED NOT NULL DEFAULT '0',
  `banned_until` int UNSIGNED NOT NULL DEFAULT '0',
  `unbanned_at` int UNSIGNED NOT NULL DEFAULT '0',
  `ban_reason_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ban_reason_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unban_reason_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unban_reason_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_banned_user` (`fk_banned_user`),
  KEY `index_banned_until` (`banned_until`),
  KEY `index_unbanned_at` (`unbanned_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `logs_irc_bot`;
CREATE TABLE IF NOT EXISTS `logs_irc_bot` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `sent_at` int UNSIGNED NOT NULL DEFAULT '0',
  `channel` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_silenced` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_failed` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_manual` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_action` tinyint UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_sent_at` (`sent_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `logs_scheduler`;
CREATE TABLE IF NOT EXISTS `logs_scheduler` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `happened_at` int UNSIGNED NOT NULL DEFAULT '0',
  `task_id` int UNSIGNED NOT NULL DEFAULT '0',
  `task_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `execution_report` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_happened_at` (`happened_at`),
  KEY `index_related_foreign_key` (`task_id`),
  KEY `index_task_type` (`task_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `meetups`;
CREATE TABLE IF NOT EXISTS `meetups` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_deleted` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `event_date` date NOT NULL DEFAULT '0000-00-00',
  `location` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `languages` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attendee_count` int UNSIGNED NOT NULL DEFAULT '0',
  `details_en` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `details_fr` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_deleted` (`is_deleted`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `meetups_people`;
CREATE TABLE IF NOT EXISTS `meetups_people` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_meetups` int UNSIGNED NOT NULL DEFAULT '0',
  `fk_users` int UNSIGNED NOT NULL DEFAULT '0',
  `username` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attendance_confirmed` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `extra_information_en` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_information_fr` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_meetup` (`fk_meetups`),
  KEY `index_people` (`fk_users`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `quotes`;
CREATE TABLE IF NOT EXISTS `quotes` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_users_submitter` int UNSIGNED NOT NULL DEFAULT '0',
  `is_deleted` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `admin_validation` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `submitted_at` int UNSIGNED NOT NULL DEFAULT '0',
  `is_nsfw` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `language` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `linked_users` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_submitter` (`fk_users_submitter`),
  KEY `index_deleted` (`is_deleted`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `quotes_users`;
CREATE TABLE IF NOT EXISTS `quotes_users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_quotes` int UNSIGNED NOT NULL DEFAULT '0',
  `fk_users` int UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_quote` (`fk_quotes`),
  KEY `index_user` (`fk_users`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `stats_pages`;
CREATE TABLE IF NOT EXISTS `stats_pages` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_name_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_name_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_viewed_at` int UNSIGNED NOT NULL DEFAULT '0',
  `view_count` int UNSIGNED NOT NULL DEFAULT '0',
  `view_count_archive` int UNSIGNED NOT NULL DEFAULT '0',
  `query_count` int UNSIGNED NOT NULL DEFAULT '0',
  `load_time` int UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_view_count` (`view_count`,`view_count_archive`),
  KEY `index_queries` (`query_count`),
  KEY `index_load_time` (`load_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `system_ip_bans`;
CREATE TABLE IF NOT EXISTS `system_ip_bans` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(156) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_a_total_ban` tinyint NOT NULL DEFAULT '0',
  `banned_since` int UNSIGNED NOT NULL DEFAULT '0',
  `banned_until` int UNSIGNED NOT NULL DEFAULT '0',
  `ban_reason_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ban_reason_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `system_scheduler`;
CREATE TABLE IF NOT EXISTS `system_scheduler` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `planned_at` int UNSIGNED NOT NULL DEFAULT '0',
  `task_id` int UNSIGNED NOT NULL DEFAULT '0',
  `task_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_task_id` (`task_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `system_variables`;
CREATE TABLE IF NOT EXISTS `system_variables` (
  `website_is_closed` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `latest_query_id` smallint UNSIGNED NOT NULL DEFAULT '0',
  `last_pageview_check` int UNSIGNED NOT NULL DEFAULT '0',
  `unread_mod_mail_count` int UNSIGNED NOT NULL DEFAULT '0',
  `unread_admin_mail_count` int UNSIGNED NOT NULL DEFAULT '0',
  `current_version_number_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `current_version_number_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `registrations_are_closed` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `irc_bot_is_silenced` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `discord_is_silenced` tinyint UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`website_is_closed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `system_versions`;
CREATE TABLE IF NOT EXISTS `system_versions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `major` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `minor` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `patch` int UNSIGNED NOT NULL DEFAULT '0',
  `extension` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_date` (`release_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_deleted` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `deleted_at` int UNSIGNED NOT NULL DEFAULT '0',
  `deleted_username` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_administrator` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_moderator` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `current_language` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_theme` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_visited_at` int UNSIGNED NOT NULL DEFAULT '0',
  `last_action_at` int UNSIGNED NOT NULL DEFAULT '0',
  `last_visited_page_en` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_visited_page_fr` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_visited_url` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `visited_page_count` int UNSIGNED NOT NULL DEFAULT '0',
  `unread_private_message_count` int UNSIGNED NOT NULL DEFAULT '0',
  `current_ip_address` varchar(135) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `is_banned_since` int UNSIGNED NOT NULL DEFAULT '0',
  `is_banned_until` int UNSIGNED NOT NULL DEFAULT '0',
  `is_banned_because_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_banned_because_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_access_rights` (`is_administrator`,`is_moderator`),
  KEY `index_doppelganger` (`current_ip_address`),
  KEY `index_banned` (`is_banned_until`),
  KEY `index_deleted` (`is_deleted`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users_guests`;
CREATE TABLE IF NOT EXISTS `users_guests` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(135) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `randomly_assigned_name_en` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `randomly_assigned_name_fr` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_language` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_theme` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_visited_at` int UNSIGNED NOT NULL DEFAULT '0',
  `last_visited_page_en` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_visited_page_fr` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_visited_url` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `visited_page_count` int UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users_login_attempts`;
CREATE TABLE IF NOT EXISTS `users_login_attempts` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_users` int UNSIGNED NOT NULL DEFAULT '0',
  `ip_address` varchar(135) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `attempted_at` int UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_user` (`fk_users`),
  KEY `index_guest` (`ip_address`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users_private_messages`;
CREATE TABLE IF NOT EXISTS `users_private_messages` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `deleted_by_recipient` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `deleted_by_sender` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `fk_users_recipient` int UNSIGNED NOT NULL DEFAULT '0',
  `fk_users_sender` int UNSIGNED NOT NULL DEFAULT '0',
  `fk_users_true_sender` int UNSIGNED NOT NULL DEFAULT '0',
  `fk_parent_message` int UNSIGNED NOT NULL DEFAULT '0',
  `is_admin_only_message` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `hide_from_admin_mail` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `sent_at` int UNSIGNED NOT NULL DEFAULT '0',
  `read_at` int UNSIGNED NOT NULL DEFAULT '0',
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_inbox` (`fk_users_recipient`),
  KEY `index_outbox` (`fk_users_sender`),
  KEY `index_message_chain` (`fk_parent_message`),
  KEY `index_read` (`read_at`),
  KEY `index_deleted_by_recipient` (`deleted_by_recipient`),
  KEY `index_deleted_by_sender` (`deleted_by_sender`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users_profile`;
CREATE TABLE IF NOT EXISTS `users_profile` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_users` int UNSIGNED NOT NULL DEFAULT '0',
  `email_address` varchar(510) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` int UNSIGNED NOT NULL DEFAULT '0',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `spoken_languages` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lives_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pronouns_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pronouns_fr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_text_en` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_text_fr` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_user` (`fk_users`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users_settings`;
CREATE TABLE IF NOT EXISTS `users_settings` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_users` int UNSIGNED NOT NULL DEFAULT '0',
  `show_nsfw_content` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `hide_youtube` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `hide_google_trends` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `hide_discord` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `hide_kiwiirc` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `hide_from_activity` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `quotes_languages` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_user` (`fk_users`),
  KEY `index_nsfw_filter` (`show_nsfw_content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users_stats`;
CREATE TABLE IF NOT EXISTS `users_stats` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_users` int UNSIGNED NOT NULL DEFAULT '0',
  `quotes` int UNSIGNED NOT NULL DEFAULT '0',
  `quotes_en` int UNSIGNED NOT NULL DEFAULT '0',
  `quotes_fr` int UNSIGNED NOT NULL DEFAULT '0',
  `quotes_nsfw` int UNSIGNED NOT NULL DEFAULT '0',
  `quotes_oldest_id` int UNSIGNED NOT NULL DEFAULT '0',
  `quotes_oldest_date` int UNSIGNED NOT NULL DEFAULT '0',
  `quotes_newest_id` int UNSIGNED NOT NULL DEFAULT '0',
  `quotes_newest_date` int UNSIGNED NOT NULL DEFAULT '0',
  `quotes_submitted` int UNSIGNED NOT NULL DEFAULT '0',
  `quotes_approved` int UNSIGNED NOT NULL DEFAULT '0',
  `meetups` int UNSIGNED NOT NULL DEFAULT '0',
  `meetups_en` int UNSIGNED NOT NULL DEFAULT '0',
  `meetups_fr` int UNSIGNED NOT NULL DEFAULT '0',
  `meetups_bilingual` int UNSIGNED NOT NULL DEFAULT '0',
  `meetups_oldest_id` int UNSIGNED NOT NULL DEFAULT '0',
  `meetups_oldest_date` int UNSIGNED NOT NULL DEFAULT '0',
  `meetups_newest_id` int UNSIGNED NOT NULL DEFAULT '0',
  `meetups_newest_date` int UNSIGNED NOT NULL DEFAULT '0',
  `tasks_submitted` int UNSIGNED NOT NULL DEFAULT '0',
  `tasks_solved` int UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_user` (`fk_users`),
  KEY `index_quotes` (`quotes`),
  KEY `index_quotes_approved` (`quotes_approved`),
  KEY `index_meetups` (`meetups`),
  KEY `index_tasks_submitted` (`tasks_submitted`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users_tokens`;
CREATE TABLE IF NOT EXISTS `users_tokens` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_users` int UNSIGNED NOT NULL DEFAULT '0',
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `regenerate_at` int UNSIGNED NOT NULL DEFAULT '0',
  `delete_at` int UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_user` (`fk_users`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `compendium_images` ADD FULLTEXT KEY `index_file_name` (`file_name`);

ALTER TABLE `compendium_pages` ADD FULLTEXT KEY `index_title_en` (`title_en`,`redirection_en`);
ALTER TABLE `compendium_pages` ADD FULLTEXT KEY `index_title_fr` (`title_fr`,`redirection_fr`);

ALTER TABLE `dev_tasks` ADD FULLTEXT KEY `index_title_en` (`title_en`);
ALTER TABLE `dev_tasks` ADD FULLTEXT KEY `index_title_fr` (`title_fr`);

ALTER TABLE `users_tokens` ADD FULLTEXT KEY `index_token` (`token`);
