-- Emergency SQL Schema for Casino Platform
-- Use this if you are missing the original .sql dump.
-- This creates the core tables required for the admin panel and user management.

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `balance` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `bonus` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `wager` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `rating` int(11) NOT NULL DEFAULT '0',
  `address` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `last_online` timestamp NULL DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active',
  `role_id` int(10) unsigned NOT NULL DEFAULT '1',
  `shop_id` int(11) DEFAULT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'USD',
  `auth_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_shop_id_foreign` (`shop_id`),
  CONSTRAINT `users_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CH COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for shops 
-- ----------------------------
CREATE TABLE IF NOT EXISTS `shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `balance` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `percent` int(11) NOT NULL DEFAULT '90',
  `max_win` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `frontend` varchar(191) DEFAULT 'Default',
  `currency` varchar(10) DEFAULT 'USD',
  `shop_limit` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `is_blocked` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `happyhours_active` tinyint(1) NOT NULL DEFAULT '1',
  `progress_active` tinyint(1) NOT NULL DEFAULT '1',
  `invite_active` tinyint(1) NOT NULL DEFAULT '1',
  `welcome_bonuses_active` tinyint(1) NOT NULL DEFAULT '1',
  `sms_bonuses_active` tinyint(1) NOT NULL DEFAULT '1',
  `wheelfortune_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for game_bank
-- ----------------------------
CREATE TABLE IF NOT EXISTS `game_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slots` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `little` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `table_bank` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `bonus` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `shop_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for fish_bank
-- ----------------------------
CREATE TABLE IF NOT EXISTS `fish_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fish` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `shop_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for statistics
-- ----------------------------
CREATE TABLE IF NOT EXISTS `statistics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `payeer_id` int(11) DEFAULT NULL,
  `system` varchar(50) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `sum` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `sum2` decimal(15,4) DEFAULT '0.0000',
  `shop_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for statistics_add
-- ----------------------------
CREATE TABLE IF NOT EXISTS `statistics_add` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `statistic_id` bigint(20) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `money_in` decimal(15,4) DEFAULT '0.0000',
  `money_out` decimal(15,4) DEFAULT '0.0000',
  `credit_in` decimal(15,4) DEFAULT '0.0000',
  `credit_out` decimal(15,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for open_shift
-- ----------------------------
CREATE TABLE IF NOT EXISTS `open_shift` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `balance` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `money_in` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `money_out` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `users` decimal(15,4) DEFAULT '0.0000',
  `shop_id` int(11) NOT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for games
-- ----------------------------
CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `shop_id` int(11) NOT NULL DEFAULT '0',
  `device` int(11) NOT NULL DEFAULT '0',
  `gamebank` varchar(191) DEFAULT NULL,
  `view` tinyint(1) NOT NULL DEFAULT '1',
  `stat_in` decimal(15,4) DEFAULT '0.0000',
  `stat_out` decimal(15,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Roles & Permissions (Laravel Roles)
-- ----------------------------
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `model` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------- 
-- Other required tables
-- ----------------------------
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(191) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
