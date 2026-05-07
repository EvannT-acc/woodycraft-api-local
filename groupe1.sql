-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour groupe1
CREATE DATABASE IF NOT EXISTS `groupe1` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `groupe1`;

-- Listage de la structure de table groupe1. adresses
CREATE TABLE IF NOT EXISTS `adresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'France',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `adresses_user_id_foreign` (`user_id`),
  CONSTRAINT `adresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table groupe1.adresses : ~2 rows (environ)
INSERT INTO `adresses` (`id`, `user_id`, `nom`, `rue`, `ville`, `code_postal`, `pays`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Domicile', '12 rue des Lilas', 'Lyon', '69003', 'France', '2026-03-23 09:17:09', '2026-03-23 09:17:09'),
	(2, 3, 'Domicile', '5 avenue Hugo', 'Paris', '75016', 'France', '2026-03-23 09:17:09', '2026-03-23 09:17:09');

-- Listage de la structure de table groupe1. appartient
CREATE TABLE IF NOT EXISTS `appartient` (
  `puzzle_id` bigint unsigned NOT NULL,
  `panier_id` bigint unsigned NOT NULL,
  `quantite` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`puzzle_id`,`panier_id`),
  KEY `appartient_panier_id_foreign` (`panier_id`),
  CONSTRAINT `appartient_panier_id_foreign` FOREIGN KEY (`panier_id`) REFERENCES `paniers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appartient_puzzle_id_foreign` FOREIGN KEY (`puzzle_id`) REFERENCES `puzzles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table groupe1.appartient : ~11 rows (environ)
INSERT INTO `appartient` (`puzzle_id`, `panier_id`, `quantite`) VALUES
	(2, 10, 2),
	(4, 10, 1);

-- Listage de la structure de table groupe1. approvisionnements
CREATE TABLE IF NOT EXISTS `approvisionnements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `puzzle_id` bigint unsigned NOT NULL,
  `quantite` int NOT NULL,
  `fournisseur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `approvisionnements_puzzle_id_foreign` (`puzzle_id`),
  CONSTRAINT `approvisionnements_puzzle_id_foreign` FOREIGN KEY (`puzzle_id`) REFERENCES `puzzles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table groupe1.approvisionnements : ~4 rows (environ)
INSERT INTO `approvisionnements` (`id`, `puzzle_id`, `quantite`, `fournisseur`, `created_at`, `updated_at`) VALUES
	(1, 4, 45, 'tertert', '2026-05-07 10:37:00', '2026-05-07 10:37:00'),
	(2, 2, 47, 'dgdfg', '2026-05-07 10:47:17', '2026-05-07 10:47:17'),
	(3, 2, 41, 'TATa', '2026-05-07 10:52:42', '2026-05-07 10:52:42'),
	(4, 14, 451, 'rive  de gier', '2026-05-07 10:53:42', '2026-05-07 10:53:42'),
	(5, 14, 14, 'jdjdj', '2026-05-07 11:14:50', '2026-05-07 11:14:50'),
	(6, 2, 54654, 'sfsdfdsf', '2026-05-07 11:15:15', '2026-05-07 11:15:15');

-- Listage de la structure de table groupe1. categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table groupe1.categories : ~3 rows (environ)
INSERT INTO `categories` (`id`, `nom`, `created_at`, `updated_at`) VALUES
	(1, 'Puzzle classique', '2026-03-23 09:17:09', '2026-03-23 09:17:09'),
	(2, 'Puzzle 3D', '2026-03-23 09:17:09', '2026-03-23 09:17:09'),
	(3, 'Puzzle en bois', '2026-03-23 09:17:09', '2026-03-23 09:17:09');

-- Listage de la structure de table groupe1. failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table groupe1.failed_jobs : ~0 rows (environ)

-- Listage de la structure de table groupe1. migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table groupe1.migrations : ~9 rows (environ)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_09_01_113505_create_categories_table', 1),
	(6, '2025_09_18_111445_create_puzzles_table', 1),
	(7, '2025_10_02_114641_create_paniers_table', 1),
	(8, '2025_10_02_114834_create_appartient_table', 1),
	(9, '2025_10_07_091446_create_adresses_table', 1),
	(10, '2026_05_07_121256_create_approvisionnements_table', 2);

-- Listage de la structure de table groupe1. paniers
CREATE TABLE IF NOT EXISTS `paniers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en cours',
  `total` decimal(8,2) NOT NULL DEFAULT '0.00',
  `mode_paiement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `paniers_user_id_foreign` (`user_id`),
  CONSTRAINT `paniers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table groupe1.paniers : ~12 rows (environ)
INSERT INTO `paniers` (`id`, `statut`, `total`, `mode_paiement`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'validé', 81.98, NULL, 1, '2025-10-02 08:48:09', '2026-03-30 05:32:11'),
	(10, 'en cours', 94.98, NULL, 1, '2026-03-30 08:10:15', '2026-03-30 06:24:40');

-- Listage de la structure de table groupe1. password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table groupe1.password_reset_tokens : ~0 rows (environ)

-- Listage de la structure de table groupe1. personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table groupe1.personal_access_tokens : ~0 rows (environ)

-- Listage de la structure de table groupe1. puzzles
CREATE TABLE IF NOT EXISTS `puzzles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie_id` bigint unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double(8,2) NOT NULL,
  `stock` int NOT NULL,
  `seuil_alerte` int NOT NULL DEFAULT '5',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `puzzles_categorie_id_foreign` (`categorie_id`),
  CONSTRAINT `puzzles_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table groupe1.puzzles : ~3 rows (environ)
INSERT INTO `puzzles` (`id`, `nom`, `categorie_id`, `description`, `image`, `prix`, `stock`, `seuil_alerte`, `created_at`, `updated_at`) VALUES
	(2, 'Tour Eiffel 4D', 2, 'La Tour Eiffel en 3D, 216 pièces.', 'Tower', 24.99, 54754, 5, '2026-03-23 09:17:09', '2026-05-07 11:15:15'),
	(4, 'Les dinosaures', 1, 'Puzzle enfant 24 pièces.', 'dino.jpg', 69.00, 53, 10, '2026-03-23 09:17:09', '2026-05-07 10:37:00'),
	(14, 'Test', 1, 'gaga', 'gaagg', 20.00, 468, 5, '2026-05-05 12:19:14', '2026-05-07 11:14:50'),
	(15, 'Test 2', 1, 'ddd', 'default.jpg', 9999.00, 45, 5, '2026-05-07 09:39:20', '2026-05-07 09:39:20'),
	(16, 'hht', 1, 'vd', 'dv', 44.00, 4, 5, '2026-05-07 10:01:08', '2026-05-07 10:01:08');

-- Listage de la structure de table groupe1. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'client',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table groupe1.users : ~4 rows (environ)
INSERT INTO `users` (`id`, `name`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Marie Dupont', 'admin', 'admin@woodycraft.fr', NULL, '$2y$12$92IXUNpkjO8i7amxqAJe6.WDbZmH1sOZB4vZy6OTGJkK0CuBqRHDi', NULL, '2026-03-23 09:17:09', '2026-03-23 09:17:09'),
	(2, 'Thomas Martin', 'client', 'thomas@gmail.com', NULL, '$2y$12$abcdefghijklmnopqrstuuVGMqzDp1234567890abcdefghijklmno', NULL, '2026-03-23 09:17:09', '2026-03-23 09:17:09'),
	(3, 'Sophie Bernard', 'client', 'sophie@gmail.com', NULL, '$2y$12$abcdefghijklmnopqrstuuVGMqzDp1234567890abcdefghijklmno', NULL, '2026-03-23 09:17:09', '2026-03-23 09:17:09'),
	(4, 'Mehdi', 'admin', 'mehdi@woodycraft.fr', NULL, '$2y$12$92IXUNpkjO8i7amxqAJe6.WDbZmH1sOZB4vZy6OTGJkK0CuBqRHDi', NULL, '2026-04-27 14:34:21', '2026-04-27 14:34:21');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
