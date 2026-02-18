-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 17 nov. 2024 à 11:08
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `agri_solutions`
--
CREATE DATABASE IF NOT EXISTS `agri_solutions` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `agri_solutions`;

-- --------------------------------------------------------

--
-- Structure de la table `advisories`
--

CREATE TABLE `advisories` (
  `id` bigint UNSIGNED NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_sent` date NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `alerts`
--

CREATE TABLE `alerts` (
  `id` bigint UNSIGNED NOT NULL,
  `farm_id` bigint UNSIGNED NOT NULL,
  `alert_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alert_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `climatic_data`
--

CREATE TABLE `climatic_data` (
  `id` bigint UNSIGNED NOT NULL,
  `farm_id` bigint UNSIGNED NOT NULL,
  `record_date` date NOT NULL,
  `temperature` decimal(5,2) NOT NULL,
  `humidity` decimal(5,2) NOT NULL,
  `rainfall` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

CREATE TABLE `countries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Democratic Republic Of Congo', '243', '2024-09-15 08:45:29', '2024-09-15 08:45:29'),
(2, 'Rwanda', '242', '2024-09-15 09:47:40', '2024-09-15 09:47:40');

-- --------------------------------------------------------

--
-- Structure de la table `crop_management`
--

CREATE TABLE `crop_management` (
  `id` bigint UNSIGNED NOT NULL,
  `growing_season` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `crop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `farmer_id` bigint UNSIGNED NOT NULL,
  `crop_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `variety_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disease_resistance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `growth_duration` int DEFAULT NULL,
  `fertilizer_requirements` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `planting_date` date NOT NULL,
  `harvest_date` date DEFAULT NULL,
  `growth_stage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `crop_management`
--

INSERT INTO `crop_management` (`id`, `growing_season`, `crop_id`, `farmer_id`, `crop_type`, `variety_name`, `disease_resistance`, `growth_duration`, `fertilizer_requirements`, `planting_date`, `harvest_date`, `growth_stage`, `created_at`, `updated_at`) VALUES
(1, 'Pluie', 'CT-00001', 1, 'Mais', 'Variete01, Variete02', 'Pluie', 90, 'Polooo', '2024-09-01', '2024-12-31', '3 mois', '2024-11-17 07:36:00', '2024-11-17 07:36:00');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `farmers`
--

CREATE TABLE `farmers` (
  `id` bigint UNSIGNED NOT NULL,
  `farmer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `state_province_id` bigint UNSIGNED NOT NULL,
  `territory_id` bigint UNSIGNED NOT NULL,
  `village` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operational_site` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_family_members` int DEFAULT NULL,
  `main_occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level_of_education` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `civil_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_member_of_association` tinyint(1) DEFAULT NULL,
  `association_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doc_recto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_verso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `farmers`
--

INSERT INTO `farmers` (`id`, `farmer_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `country_id`, `state_province_id`, `territory_id`, `village`, `operational_site`, `number_of_family_members`, `main_occupation`, `level_of_education`, `civil_status`, `is_member_of_association`, `association_name`, `contact_number`, `photo`, `doc_recto`, `doc_verso`, `bank_name`, `account_name`, `branch`, `account_number`, `created_at`, `updated_at`) VALUES
(1, 'YT-00001', 'Akheem', 'Changu', '2024-05-29', 'male', 1, 1, 1, 'Kavumu', 'Miti', 2, 'Farmer', 'Primary', 'married', 0, NULL, '0978333654', 'photos/CzzWRbXiGzs2oVro93gMQKItPHTYk9DRdli6ftWh.jpg', 'documents/ufx9UZEKiEnJjYD2kslmHRibR4FEoLIzO4nMxrZG.jpg', 'documents/KOa3WtB82jOZz5j0WXsFsDC5MHuuXlAWRHiDqSox.jpg', 'SMICO', 'AKHEEM', NULL, 'BK01200', '2024-11-17 06:24:11', '2024-11-17 06:40:30');

-- --------------------------------------------------------

--
-- Structure de la table `farms`
--

CREATE TABLE `farms` (
  `id` bigint UNSIGNED NOT NULL,
  `farm_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `farmer_id` bigint UNSIGNED NOT NULL,
  `farm_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_cultivated_crop` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proposed_planting_area` decimal(20,2) NOT NULL,
  `land_topography` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_land_holding` decimal(20,2) NOT NULL,
  `land_ownership` enum('leased','owned','renting') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nearby` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gps_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documents_upload` json DEFAULT NULL,
  `registration_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `farms`
--

INSERT INTO `farms` (`id`, `farm_id`, `farmer_id`, `farm_name`, `previous_cultivated_crop`, `address`, `proposed_planting_area`, `land_topography`, `total_land_holding`, `land_ownership`, `nearby`, `gps_location`, `photo`, `documents_upload`, `registration_date`, `created_at`, `updated_at`) VALUES
(1, 'YFRM-0001', 1, 'Champs Katana', 'Manioc', 'Katana/Kabare', 4.00, 'Topo1', 3.00, 'leased', 'River', '28.84349, -2.4846063', 'photos/Rvuz1JH7cpwmOBn1FohONV2gmoWYibyEkmdBuAUY.png', '[{\"path\": \"documents_upload/SIgpPAn9OIlSQjnan4zQbccvivht7M4zWmiMMa5I.pdf\", \"type\": \"application/pdf\", \"filename\": \"doc.pdf\"}, {\"path\": \"documents_upload/OiDES4fYJu7hhl8cMayTQMr6oBRAhM8Fdyb7sYAW.pdf\", \"type\": \"application/pdf\", \"filename\": \"État de Sortie du Fermier.pdf\"}]', '2024-10-18', '2024-10-18 05:35:05', '2024-11-04 05:30:38');

-- --------------------------------------------------------

--
-- Structure de la table `farm_conversions`
--

CREATE TABLE `farm_conversions` (
  `id` bigint UNSIGNED NOT NULL,
  `farm_id` bigint UNSIGNED NOT NULL,
  `last_date_chemical_applied` date DEFAULT NULL,
  `estimated_yield` decimal(8,2) DEFAULT NULL,
  `conventional_lands` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conventional_crops` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inspector_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualified_inspector` tinyint(1) NOT NULL DEFAULT '0',
  `date_of_inspection` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `farm_conversions`
--

INSERT INTO `farm_conversions` (`id`, `farm_id`, `last_date_chemical_applied`, `estimated_yield`, `conventional_lands`, `conventional_crops`, `inspector_name`, `qualified_inspector`, `date_of_inspection`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-03-18', 3.00, 'Conventional Lands', 'Conventional Crops', 'Inspector Name', 1, '2024-10-18', '2024-10-18 05:36:48', '2024-10-18 05:36:48');

-- --------------------------------------------------------

--
-- Structure de la table `farm_labours`
--

CREATE TABLE `farm_labours` (
  `id` bigint UNSIGNED NOT NULL,
  `farm_id` bigint UNSIGNED NOT NULL,
  `full_time_workers` int NOT NULL DEFAULT '0',
  `seasonal_workers` int NOT NULL DEFAULT '0',
  `part_time_workers` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `farm_labours`
--

INSERT INTO `farm_labours` (`id`, `farm_id`, `full_time_workers`, `seasonal_workers`, `part_time_workers`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 4, 6, '2024-10-18 05:35:55', '2024-10-18 05:35:55');

-- --------------------------------------------------------

--
-- Structure de la table `fields`
--

CREATE TABLE `fields` (
  `id` bigint UNSIGNED NOT NULL,
  `field_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `farmer_id` bigint UNSIGNED NOT NULL,
  `total_area` decimal(8,2) NOT NULL,
  `soil_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `irrigation_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gps_location` polygon DEFAULT NULL,
  `registration_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fields`
--

INSERT INTO `fields` (`id`, `field_id`, `field_name`, `farmer_id`, `total_area`, `soil_type`, `irrigation_type`, `gps_location`, `registration_date`, `created_at`, `updated_at`) VALUES
(1, 'LP-00001', 'Mais', 1, 4.00, 'Humid', 'Arrosage', 0x000000000103000000010000000500000015797697b8423c40e8aa652dd402ffbf7a024ca4ee4e3c4021862255b91effbfca38c7f6374c3c40f6ee8137348bffbfe7eaa964c8403c40db123873b39affbf15797697b8423c40e8aa652dd402ffbf, '2024-10-17', '2024-10-18 05:38:03', '2024-10-18 05:38:03'),
(2, 'LP-00002', 'Mais', 1, 4.00, 'Chalky', 'Sprinkler', 0x00000000010300000001000000070000008f99b7db72483c40859f799c8a06ffbf4ec0637e0a4b3c4020447235a608ffbf3c8ccfcbda493c40c34f569c8754ffbfaba4a2e937473c40ebf27f2db937ffbfad9ab4dd45483c401ab0d8a28920ffbf815147115f493c407f9eb3fb8219ffbf8f99b7db72483c40859f799c8a06ffbf, '2024-11-16', '2024-11-17 08:33:03', '2024-11-17 08:33:03');

-- --------------------------------------------------------

--
-- Structure de la table `field_visits`
--

CREATE TABLE `field_visits` (
  `id` bigint UNSIGNED NOT NULL,
  `field_staff_id` bigint UNSIGNED NOT NULL,
  `field_id` bigint UNSIGNED NOT NULL,
  `visit_date` date NOT NULL,
  `gps_location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `photos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimated_yield` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `field_visits`
--

INSERT INTO `field_visits` (`id`, `field_staff_id`, `field_id`, `visit_date`, `gps_location`, `notes`, `photos`, `estimated_yield`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-10-17', '28.8555008, -2.5034752', 'Notes', '[\"photos\\/r97o1PzJWG4HIxNVF8dWISlbUEkIdJfp91uVica8.png\",\"photos\\/pczt0holIao8E32QsdPz9WkXkbxT6RQn3BxcRzrF.png\"]', 3.00, '2024-10-18 07:42:41', '2024-10-18 07:42:41'),
(2, 1, 1, '2024-10-31', '28.854770509814017, -2.497516618433565', 'Visit note', '[\"photos\\/hXfO51LMgoCMWM5oVO87y3duAjFS0lRDtrilVGGw.png\"]', 2.00, '2024-11-05 04:23:31', '2024-11-05 04:23:31');

-- --------------------------------------------------------

--
-- Structure de la table `geolocations`
--

CREATE TABLE `geolocations` (
  `id` bigint UNSIGNED NOT NULL,
  `farm_id` bigint UNSIGNED NOT NULL,
  `gps_coordinates` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `harvests`
--

CREATE TABLE `harvests` (
  `id` bigint UNSIGNED NOT NULL,
  `crop_id` bigint UNSIGNED NOT NULL,
  `estimated_yield` decimal(10,2) NOT NULL,
  `actual_yield` decimal(10,2) DEFAULT NULL,
  `post_harvest_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint UNSIGNED NOT NULL,
  `seed_variety_id` bigint UNSIGNED NOT NULL,
  `quantity_available` int NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_08_13_134059_create_settings_table', 1),
(6, '2024_08_29_094108_create_regions_table', 1),
(7, '2024_09_05_093323_create_countries_table', 1),
(8, '2024_09_05_093532_create_provinces_table', 1),
(9, '2024_09_05_093806_create_territories_table', 1),
(10, '2024_09_05_145706_create_farmers_table', 1),
(11, '2024_09_05_150221_create_farms_table', 1),
(13, '2024_09_05_150611_create_seed_varieties_table', 1),
(14, '2024_09_05_150715_create_seed_distributions_table', 1),
(15, '2024_09_05_150751_create_products_table', 1),
(16, '2024_09_05_150813_create_inventories_table', 1),
(17, '2024_09_05_150858_create_quality_controls_table', 1),
(18, '2024_09_05_150949_create_transactions_table', 1),
(19, '2024_09_05_151021_create_payments_table', 1),
(20, '2024_09_05_151101_create_harvests_table', 1),
(21, '2024_09_05_151141_create_advisories_table', 1),
(22, '2024_09_05_151226_create_climatic_data_table', 1),
(23, '2024_09_05_151303_create_alerts_table', 1),
(24, '2024_09_05_151353_create_geolocations_table', 1),
(25, '2024_09_05_151425_create_risk_assessments_table', 1),
(26, '2024_09_06_061917_create_farm_labours_table', 1),
(27, '2024_09_06_080414_create_farm_conversions_table', 1),
(28, '2024_09_06_110442_create_fields_table', 1),
(29, '2024_09_06_150455_create_field_visits_table', 1),
(30, '2024_10_16_102529_create_sowing_records_table', 1),
(35, '2024_09_05_150322_create_crop_management_table', 2);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `farmer_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(50,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `provinces`
--

CREATE TABLE `provinces` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'Sud-Kivu', 1, '2024-09-15 08:47:40', '2024-09-15 08:47:40'),
(2, 'Nord-Kivu', 1, '2024-09-15 08:47:56', '2024-09-15 08:47:56');

-- --------------------------------------------------------

--
-- Structure de la table `quality_controls`
--

CREATE TABLE `quality_controls` (
  `id` bigint UNSIGNED NOT NULL,
  `seed_variety_id` bigint UNSIGNED NOT NULL,
  `test_date` date NOT NULL,
  `results` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `regions`
--

CREATE TABLE `regions` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `risk_assessments`
--

CREATE TABLE `risk_assessments` (
  `id` bigint UNSIGNED NOT NULL,
  `farm_id` bigint UNSIGNED NOT NULL,
  `risk_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk_level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assessment_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `seed_distributions`
--

CREATE TABLE `seed_distributions` (
  `id` bigint UNSIGNED NOT NULL,
  `farmer_id` bigint UNSIGNED NOT NULL,
  `seed_variety_id` bigint UNSIGNED NOT NULL,
  `quantity_distributed` int NOT NULL,
  `distribution_date` date NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `seed_varieties`
--

CREATE TABLE `seed_varieties` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `certification_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'AALI', '2024-09-15 08:40:18', '2024-09-15 08:40:18'),
(2, 'phone', '09984567235', '2024-09-15 08:40:18', '2024-09-15 08:40:18'),
(3, 'email', 'aali@aali.org', '2024-09-15 08:40:18', '2024-09-15 08:40:18'),
(4, 'adress', 'Bukavu/Ibanda/Ndendere/Kalambo', '2024-09-15 08:40:18', '2024-09-15 08:40:18'),
(5, 'currency', '$', '2024-09-15 08:40:18', '2024-09-15 08:40:18'),
(6, 'logo', '1726425619_SAVE_20240710_120558.jpg', '2024-09-15 08:40:18', '2024-09-15 08:40:19');

-- --------------------------------------------------------

--
-- Structure de la table `sowing_records`
--

CREATE TABLE `sowing_records` (
  `id` bigint UNSIGNED NOT NULL,
  `field_id` bigint UNSIGNED NOT NULL,
  `crop_id` bigint UNSIGNED NOT NULL,
  `sowing_date` date NOT NULL,
  `area_sown` decimal(8,2) NOT NULL,
  `gps_coordinates` polygon DEFAULT NULL,
  `geo_map_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sowing_records`
--

INSERT INTO `sowing_records` (`id`, `field_id`, `crop_id`, `sowing_date`, `area_sown`, `gps_coordinates`, `geo_map_url`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-10-17', 3.00, 0x00000000010300000001000000050000003a25a16a21473c40f0c318480703ffbfbb3f68fb4d4b3c40c518c825bb03ffbff3c65a84834a3c40c91704254342ffbf04a899efb0463c40fcc4a0d2bf3effbf3a25a16a21473c40f0c318480703ffbf, NULL, '2024-10-18 07:48:33', '2024-10-18 07:48:33'),
(2, 1, 1, '2024-10-17', 3.00, 0x00000000010300000001000000050000003a25a16a21473c40f0c318480703ffbfbb3f68fb4d4b3c40c518c825bb03ffbff3c65a84834a3c40c91704254342ffbf04a899efb0463c40fcc4a0d2bf3effbf3a25a16a21473c40f0c318480703ffbf, NULL, '2024-10-18 07:51:26', '2024-10-18 07:51:26'),
(3, 1, 1, '2024-10-17', 3.00, 0x00000000010300000001000000050000003a25a16a21473c40f0c318480703ffbfbb3f68fb4d4b3c40c518c825bb03ffbff3c65a84834a3c40c91704254342ffbf04a899efb0463c40fcc4a0d2bf3effbf3a25a16a21473c40f0c318480703ffbf, NULL, '2024-10-18 07:52:56', '2024-10-18 07:52:56');

-- --------------------------------------------------------

--
-- Structure de la table `territories`
--

CREATE TABLE `territories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `territories`
--

INSERT INTO `territories` (`id`, `name`, `province_id`, `created_at`, `updated_at`) VALUES
(1, 'Kabare', 1, '2024-09-15 08:48:17', '2024-09-15 12:13:38'),
(2, 'Mwenga', 1, '2024-09-15 08:48:33', '2024-09-15 08:48:33'),
(3, 'Rutshuru', 2, '2024-09-15 08:48:51', '2024-09-15 08:48:51');

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `farmer_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `transaction_date` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$2oYLstk./yLFXX7dtwz7vOqqt338wKXlIdvVX1TqyQprp34gMO0M2', 'super-admin', NULL, '2024-09-15 08:34:16', '2024-09-15 08:34:16');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `advisories`
--
ALTER TABLE `advisories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advisories_recipient_id_foreign` (`recipient_id`);

--
-- Index pour la table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alerts_farm_id_foreign` (`farm_id`);

--
-- Index pour la table `climatic_data`
--
ALTER TABLE `climatic_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `climatic_data_farm_id_foreign` (`farm_id`);

--
-- Index pour la table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_name_unique` (`name`),
  ADD UNIQUE KEY `countries_code_unique` (`code`);

--
-- Index pour la table `crop_management`
--
ALTER TABLE `crop_management`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crop_management_farmer_id_foreign` (`farmer_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `farmers`
--
ALTER TABLE `farmers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `farmers_country_id_foreign` (`country_id`),
  ADD KEY `farmers_state_province_id_foreign` (`state_province_id`),
  ADD KEY `farmers_territory_id_foreign` (`territory_id`);

--
-- Index pour la table `farms`
--
ALTER TABLE `farms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `farms_farm_id_unique` (`farm_id`),
  ADD KEY `farms_farmer_id_foreign` (`farmer_id`);

--
-- Index pour la table `farm_conversions`
--
ALTER TABLE `farm_conversions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `farm_conversions_farm_id_foreign` (`farm_id`);

--
-- Index pour la table `farm_labours`
--
ALTER TABLE `farm_labours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `farm_labours_farm_id_foreign` (`farm_id`);

--
-- Index pour la table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fields_farmer_id_foreign` (`farmer_id`);

--
-- Index pour la table `field_visits`
--
ALTER TABLE `field_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `field_visits_field_staff_id_foreign` (`field_staff_id`),
  ADD KEY `field_visits_field_id_foreign` (`field_id`);

--
-- Index pour la table `geolocations`
--
ALTER TABLE `geolocations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `geolocations_farm_id_foreign` (`farm_id`);

--
-- Index pour la table `harvests`
--
ALTER TABLE `harvests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `harvests_crop_id_foreign` (`crop_id`);

--
-- Index pour la table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventories_seed_variety_id_foreign` (`seed_variety_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_farmer_id_foreign` (`farmer_id`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provinces_country_id_foreign` (`country_id`);

--
-- Index pour la table `quality_controls`
--
ALTER TABLE `quality_controls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quality_controls_seed_variety_id_foreign` (`seed_variety_id`);

--
-- Index pour la table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `risk_assessments`
--
ALTER TABLE `risk_assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `risk_assessments_farm_id_foreign` (`farm_id`);

--
-- Index pour la table `seed_distributions`
--
ALTER TABLE `seed_distributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seed_distributions_farmer_id_foreign` (`farmer_id`),
  ADD KEY `seed_distributions_seed_variety_id_foreign` (`seed_variety_id`);

--
-- Index pour la table `seed_varieties`
--
ALTER TABLE `seed_varieties`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Index pour la table `sowing_records`
--
ALTER TABLE `sowing_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sowing_records_field_id_foreign` (`field_id`),
  ADD KEY `sowing_records_crop_id_foreign` (`crop_id`);

--
-- Index pour la table `territories`
--
ALTER TABLE `territories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `territories_province_id_foreign` (`province_id`);

--
-- Index pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_farmer_id_foreign` (`farmer_id`),
  ADD KEY `transactions_product_id_foreign` (`product_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `advisories`
--
ALTER TABLE `advisories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `climatic_data`
--
ALTER TABLE `climatic_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `crop_management`
--
ALTER TABLE `crop_management`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `farmers`
--
ALTER TABLE `farmers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `farms`
--
ALTER TABLE `farms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `farm_conversions`
--
ALTER TABLE `farm_conversions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `farm_labours`
--
ALTER TABLE `farm_labours`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `fields`
--
ALTER TABLE `fields`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `field_visits`
--
ALTER TABLE `field_visits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `geolocations`
--
ALTER TABLE `geolocations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `harvests`
--
ALTER TABLE `harvests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `quality_controls`
--
ALTER TABLE `quality_controls`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `risk_assessments`
--
ALTER TABLE `risk_assessments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `seed_distributions`
--
ALTER TABLE `seed_distributions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `seed_varieties`
--
ALTER TABLE `seed_varieties`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `sowing_records`
--
ALTER TABLE `sowing_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `territories`
--
ALTER TABLE `territories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `advisories`
--
ALTER TABLE `advisories`
  ADD CONSTRAINT `advisories_recipient_id_foreign` FOREIGN KEY (`recipient_id`) REFERENCES `farmers` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_farm_id_foreign` FOREIGN KEY (`farm_id`) REFERENCES `farms` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `climatic_data`
--
ALTER TABLE `climatic_data`
  ADD CONSTRAINT `climatic_data_farm_id_foreign` FOREIGN KEY (`farm_id`) REFERENCES `farms` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `crop_management`
--
ALTER TABLE `crop_management`
  ADD CONSTRAINT `crop_management_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`);

--
-- Contraintes pour la table `farmers`
--
ALTER TABLE `farmers`
  ADD CONSTRAINT `farmers_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `farmers_state_province_id_foreign` FOREIGN KEY (`state_province_id`) REFERENCES `provinces` (`id`),
  ADD CONSTRAINT `farmers_territory_id_foreign` FOREIGN KEY (`territory_id`) REFERENCES `territories` (`id`);

--
-- Contraintes pour la table `farms`
--
ALTER TABLE `farms`
  ADD CONSTRAINT `farms_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`);

--
-- Contraintes pour la table `farm_conversions`
--
ALTER TABLE `farm_conversions`
  ADD CONSTRAINT `farm_conversions_farm_id_foreign` FOREIGN KEY (`farm_id`) REFERENCES `farms` (`id`);

--
-- Contraintes pour la table `farm_labours`
--
ALTER TABLE `farm_labours`
  ADD CONSTRAINT `farm_labours_farm_id_foreign` FOREIGN KEY (`farm_id`) REFERENCES `farms` (`id`);

--
-- Contraintes pour la table `fields`
--
ALTER TABLE `fields`
  ADD CONSTRAINT `fields_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`);

--
-- Contraintes pour la table `field_visits`
--
ALTER TABLE `field_visits`
  ADD CONSTRAINT `field_visits_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `fields` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `field_visits_field_staff_id_foreign` FOREIGN KEY (`field_staff_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `geolocations`
--
ALTER TABLE `geolocations`
  ADD CONSTRAINT `geolocations_farm_id_foreign` FOREIGN KEY (`farm_id`) REFERENCES `farms` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `harvests`
--
ALTER TABLE `harvests`
  ADD CONSTRAINT `harvests_crop_id_foreign` FOREIGN KEY (`crop_id`) REFERENCES `crop_management` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_seed_variety_id_foreign` FOREIGN KEY (`seed_variety_id`) REFERENCES `seed_varieties` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `provinces`
--
ALTER TABLE `provinces`
  ADD CONSTRAINT `provinces_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quality_controls`
--
ALTER TABLE `quality_controls`
  ADD CONSTRAINT `quality_controls_seed_variety_id_foreign` FOREIGN KEY (`seed_variety_id`) REFERENCES `seed_varieties` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `risk_assessments`
--
ALTER TABLE `risk_assessments`
  ADD CONSTRAINT `risk_assessments_farm_id_foreign` FOREIGN KEY (`farm_id`) REFERENCES `farms` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `seed_distributions`
--
ALTER TABLE `seed_distributions`
  ADD CONSTRAINT `seed_distributions_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seed_distributions_seed_variety_id_foreign` FOREIGN KEY (`seed_variety_id`) REFERENCES `seed_varieties` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sowing_records`
--
ALTER TABLE `sowing_records`
  ADD CONSTRAINT `sowing_records_crop_id_foreign` FOREIGN KEY (`crop_id`) REFERENCES `crop_management` (`id`),
  ADD CONSTRAINT `sowing_records_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `fields` (`id`);

--
-- Contraintes pour la table `territories`
--
ALTER TABLE `territories`
  ADD CONSTRAINT `territories_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
