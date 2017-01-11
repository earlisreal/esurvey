-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2017 at 09:14 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esurvey`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laraveldate2', 'eyJpdiI6Ik44cE1Oalh3VUdUOXI3OHU1a1wvNlhRPT0iLCJ2YWx1ZSI6Iit0dEpIU3VxTDVYazFxb1lUd080Y0pOTllOOVF0QjkzSHZyK1JKOXo2cjFCKzBPVXhqanVWcm5QWGJsNmp5NHZxWmtmSEVDYmRwTjlZa1ZDU2lSZTdOdWpBZGxaUlhqUW5PM1Frbm1NMEFBPSIsIm1hYyI6IjAzZDYxNGVmMzYyNzUwZDVkMDU5NGYyMGVjNjA5MWZiYTc3Mzk1YmMxZjVlNjA1ZGU2MjQzYjYyMmY2ZmQwYzYifQ==', 1799464766);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2013_10_02_000000_create_user_roles_table', 1),
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_08_02_022943_create_survey_categories_table', 1),
('2016_08_02_022953_create_surveys_table', 1),
('2016_08_02_023000_create_survey_pages_table', 1),
('2016_08_02_023007_create_question_types_table', 1),
('2016_08_02_023024_create_questions_table', 1),
('2016_08_02_023138_create_question_choices_table', 1),
('2016_08_02_023148_create_responses_table', 1),
('2016_08_02_023154_create_response_details_table', 1),
('2016_08_02_023211_create_response_sources_table', 1),
('2016_09_03_184333_create_modules_table', 1),
('2016_09_03_184437_create_role_modules_table', 1),
('2016_09_13_090702_create_survey_options_table', 1),
('2016_09_27_153950_create_question_options_table', 1),
('2016_12_23_170806_create_question_rows_table', 1),
('2017_01_03_141720_create_cache_table', 2),
('2017_01_04_210814_create_jobs_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `order_number` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `title`, `url`, `icon`, `order_number`, `created_at`, `updated_at`) VALUES
(1, 'User Management', 'users', 'fa fa-users', 1, '2016-12-23 09:27:59', NULL),
(2, 'Role Management', 'roles', 'fa fa-key', 2, '2016-12-23 09:27:59', NULL),
(3, 'Survey Templates', 'templates', 'fa fa-list-alt', 3, '2016-12-23 09:27:59', NULL),
(4, 'Survey Categories', 'categories', 'fa fa-bars', 4, '2016-12-23 09:27:59', NULL),
(5, 'Admin Modules', 'modules', 'fa fa-gears', 5, '2016-12-23 09:27:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_page_id` int(10) UNSIGNED NOT NULL,
  `question_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_no` smallint(6) NOT NULL,
  `question_type_id` int(10) UNSIGNED NOT NULL,
  `is_mandatory` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `survey_page_id`, `question_title`, `order_no`, `question_type_id`, `is_mandatory`, `created_at`, `updated_at`) VALUES
(9, 1, 'Rate This please', 5, 7, 1, '2016-12-27 08:15:06', '2016-12-27 08:15:06'),
(10, 2, 'Multiple Choice', 1, 1, 0, '2016-12-27 10:51:16', '2016-12-27 10:51:16'),
(11, 2, 'What''s youre favorite food?', 2, 3, 0, '2016-12-27 10:51:33', '2016-12-27 10:51:33'),
(12, 2, 'Things you like', 4, 5, 0, '2016-12-27 10:52:20', '2016-12-27 10:56:28'),
(13, 2, 'Rate Me', 5, 6, 0, '2016-12-27 10:52:55', '2016-12-27 10:56:28'),
(14, 2, 'Rate the Following', 3, 7, 0, '2016-12-27 10:56:07', '2016-12-27 10:56:28'),
(15, 3, 'How Are you?', 1, 1, 0, '2017-01-04 10:23:05', '2017-01-04 10:23:05'),
(16, 3, 'How do you feel?', 2, 4, 0, '2017-01-04 10:23:21', '2017-01-04 10:23:21'),
(17, 4, 'Hi This is a test question.', 1, 1, 0, '2017-01-04 13:54:41', '2017-01-04 13:54:41'),
(18, 4, 'Hey! How Are you today? Please Share your experience.', 2, 4, 0, '2017-01-04 13:55:03', '2017-01-04 13:55:03'),
(21, 6, ' How Are you Today?', 1, 4, 0, '2017-01-11 04:21:42', '2017-01-11 04:21:42'),
(22, 6, 'When you see a man walking around the street, begging for money. Is giving would be a great act? Define your answer in one sentence. ', 2, 4, 0, '2017-01-11 04:21:52', '2017-01-11 04:21:52');

-- --------------------------------------------------------

--
-- Table structure for table `question_choices`
--

CREATE TABLE `question_choices` (
  `id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `question_choices`
--

INSERT INTO `question_choices` (`id`, `question_id`, `label`, `weight`, `created_at`, `updated_at`) VALUES
(21, 9, 'Very Poor', 1, '2016-12-27 08:15:06', '2016-12-27 08:15:06'),
(22, 9, 'Poor', 2, '2016-12-27 08:15:06', '2016-12-27 08:15:06'),
(23, 9, 'Average', 3, '2016-12-27 08:15:06', '2016-12-27 08:15:06'),
(24, 9, 'Good', 4, '2016-12-27 08:15:06', '2016-12-27 08:15:06'),
(25, 9, 'Very Good', 5, '2016-12-27 08:15:06', '2016-12-27 08:15:06'),
(26, 10, 'Fine', NULL, '2016-12-27 10:51:16', '2016-12-27 10:51:16'),
(27, 10, 'Not Fine', NULL, '2016-12-27 10:51:16', '2016-12-27 10:51:16'),
(28, 10, 'Neutral', NULL, '2016-12-27 10:51:16', '2016-12-27 10:51:16'),
(29, 12, 'Food', NULL, '2016-12-27 10:52:20', '2016-12-27 10:52:20'),
(30, 12, 'Clothes', NULL, '2016-12-27 10:52:20', '2016-12-27 10:52:20'),
(31, 12, 'Gadget', NULL, '2016-12-27 10:52:20', '2016-12-27 10:52:20'),
(32, 12, 'Money', NULL, '2016-12-27 10:52:20', '2016-12-27 10:52:20'),
(33, 12, 'House', NULL, '2016-12-27 10:52:20', '2016-12-27 10:52:20'),
(34, 12, 'Car', NULL, '2016-12-27 10:52:20', '2016-12-27 10:52:20'),
(35, 14, 'Very Poor', 1, '2016-12-27 10:56:07', '2016-12-27 10:56:07'),
(36, 14, 'Poor', 2, '2016-12-27 10:56:07', '2016-12-27 10:56:07'),
(37, 14, 'Average', 3, '2016-12-27 10:56:07', '2016-12-27 10:56:07'),
(38, 14, 'Good', 4, '2016-12-27 10:56:07', '2016-12-27 10:56:07'),
(39, 14, 'Very Good', 5, '2016-12-27 10:56:07', '2016-12-27 10:56:07'),
(40, 15, 'Fine', NULL, '2017-01-04 10:23:05', '2017-01-04 10:23:05'),
(41, 15, 'Not Ok', NULL, '2017-01-04 10:23:05', '2017-01-04 10:23:05'),
(42, 17, 'Okay', NULL, '2017-01-04 13:54:41', '2017-01-04 13:54:41'),
(43, 17, 'Don''t Care', NULL, '2017-01-04 13:54:41', '2017-01-04 13:54:41');

-- --------------------------------------------------------

--
-- Table structure for table `question_options`
--

CREATE TABLE `question_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `max_rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `question_options`
--

INSERT INTO `question_options` (`id`, `question_id`, `max_rating`) VALUES
(1, 13, 10);

-- --------------------------------------------------------

--
-- Table structure for table `question_rows`
--

CREATE TABLE `question_rows` (
  `id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `question_rows`
--

INSERT INTO `question_rows` (`id`, `question_id`, `label`, `created_at`, `updated_at`) VALUES
(11, 9, 'Quality', '2016-12-27 08:15:06', '2016-12-27 08:15:06'),
(12, 9, 'Perfermance', '2016-12-27 08:15:06', '2016-12-27 08:15:06'),
(13, 9, 'Price', '2016-12-27 08:15:06', '2016-12-27 08:15:06'),
(14, 14, 'Quality', '2016-12-27 10:56:07', '2016-12-27 10:56:07'),
(15, 14, 'Price', '2016-12-27 10:56:07', '2016-12-27 10:56:07'),
(16, 14, 'Performance', '2016-12-27 10:56:07', '2016-12-27 10:56:07');

-- --------------------------------------------------------

--
-- Table structure for table `question_types`
--

CREATE TABLE `question_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `html` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `has_choices` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `question_types`
--

INSERT INTO `question_types` (`id`, `type`, `html`, `logo`, `has_choices`, `created_at`, `updated_at`) VALUES
(1, 'Multiple Choice', NULL, '', 1, '2016-12-23 09:27:59', NULL),
(2, 'Dropdown', NULL, '', 1, '2016-12-23 09:27:59', NULL),
(3, 'Textbox', NULL, '', 0, '2016-12-23 09:27:59', NULL),
(4, 'Text Area', NULL, '', 0, '2016-12-23 09:27:59', NULL),
(5, 'Checkbox', NULL, '', 1, '2016-12-23 09:27:59', NULL),
(6, 'Rating Scale', NULL, '', 0, '2016-12-23 09:27:59', NULL),
(7, 'Likert Scale', NULL, '', 1, '2016-12-23 09:27:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED NOT NULL,
  `source_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `responses`
--

INSERT INTO `responses` (`id`, `survey_id`, `source_ip`, `source`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '::1', 'Windows', NULL, '2016-12-27 09:11:46', '2016-12-27 09:11:46'),
(7, 1, '::1', 'Windows', NULL, '2016-12-27 09:29:44', '2016-12-27 09:29:44'),
(8, 2, '::1', 'Windows', NULL, '2016-12-30 02:22:33', '2016-12-30 02:22:33'),
(16, 2, '::1', 'Windows', NULL, '2016-12-30 02:35:04', '2016-12-30 02:35:04'),
(17, 2, '::1', 'Windows', NULL, '2016-12-30 02:36:06', '2016-12-30 02:36:06'),
(21, 2, '::1', 'Windows', NULL, '2016-12-30 02:55:27', '2016-12-30 02:55:27'),
(22, 2, '::1', 'Windows', NULL, '2016-12-30 02:58:59', '2016-12-30 02:58:59'),
(23, 2, '::1', 'Windows', NULL, '2016-12-30 03:03:00', '2016-12-30 03:03:00'),
(25, 2, '::1', 'Windows', NULL, '2017-01-01 11:42:31', '2017-01-01 11:42:31'),
(26, 2, '::1', 'Windows', NULL, '2017-01-01 14:07:38', '2017-01-01 14:07:38'),
(27, 2, '::1', 'Windows', NULL, '2017-01-01 14:07:56', '2017-01-01 14:07:56'),
(28, 2, '::1', 'Windows', NULL, '2017-01-01 14:08:17', '2017-01-01 14:08:17'),
(29, 2, '::1', 'Windows', NULL, '2017-01-01 14:11:33', '2017-01-01 14:11:33'),
(31, 2, '::1', 'Windows', NULL, '2017-01-01 14:14:40', '2017-01-01 14:14:40'),
(32, 2, '::1', 'Windows', NULL, '2017-01-01 14:15:22', '2017-01-01 14:15:22'),
(33, 2, '::1', 'Windows', NULL, '2017-01-01 14:15:52', '2017-01-01 14:15:52'),
(34, 2, '::1', 'Windows', NULL, '2017-01-01 14:22:18', '2017-01-01 14:22:18'),
(35, 2, '::1', 'Windows', NULL, '2017-01-01 15:14:53', '2017-01-01 15:14:53'),
(36, 2, '::1', 'Windows', NULL, '2017-01-01 15:15:09', '2017-01-01 15:15:09'),
(37, 2, '::1', 'Windows', NULL, '2017-01-01 15:40:22', '2017-01-01 15:40:22'),
(38, 2, '::1', 'Windows', NULL, '2017-01-02 06:46:53', '2017-01-02 06:46:53'),
(39, 2, '::1', 'Windows', NULL, '2017-01-04 07:16:44', '2017-01-04 07:16:44'),
(40, 2, '::1', 'Windows', NULL, '2017-01-04 07:17:53', '2017-01-04 07:17:53'),
(41, 2, '192.168.1.8', 'Android App', NULL, '2017-01-05 15:46:45', '2017-01-05 15:46:42'),
(42, 2, '::1', 'Windows', NULL, '2017-01-11 02:39:16', '2017-01-11 02:39:16'),
(43, 2, '::1', 'Windows', NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(44, 2, '::1', 'Windows', NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(45, 2, '::1', 'Windows', NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `response_details`
--

CREATE TABLE `response_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `response_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `text_answer` text COLLATE utf8_unicode_ci,
  `sentiment` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `row_id` int(10) UNSIGNED DEFAULT NULL,
  `choice_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `response_details`
--

INSERT INTO `response_details` (`id`, `response_id`, `question_id`, `text_answer`, `sentiment`, `row_id`, `choice_id`, `created_at`, `updated_at`) VALUES
(1, 1, 9, NULL, NULL, NULL, NULL, '2016-12-27 09:11:46', '2016-12-27 09:11:46'),
(6, 7, 9, NULL, NULL, 11, 25, '2016-12-27 09:29:44', '2016-12-27 09:29:44'),
(7, 7, 9, NULL, NULL, 12, 25, '2016-12-27 09:29:44', '2016-12-27 09:29:44'),
(8, 7, 9, NULL, NULL, 13, 25, '2016-12-27 09:29:44', '2016-12-27 09:29:44'),
(9, 8, 10, NULL, NULL, NULL, 26, '2016-12-30 02:22:33', '2016-12-30 02:22:33'),
(10, 8, 11, 'Pasta :)', 'positive', NULL, NULL, '2016-12-30 02:22:38', '2016-12-30 02:22:38'),
(11, 8, 12, NULL, NULL, NULL, 29, '2016-12-30 02:22:38', '2016-12-30 02:22:38'),
(12, 8, 12, NULL, NULL, NULL, 30, '2016-12-30 02:22:38', '2016-12-30 02:22:38'),
(13, 8, 13, '9', NULL, NULL, NULL, '2016-12-30 02:22:40', '2016-12-30 02:22:40'),
(14, 8, 14, NULL, NULL, 14, 38, '2016-12-30 02:22:40', '2016-12-30 02:22:40'),
(15, 8, 14, NULL, NULL, 15, 38, '2016-12-30 02:22:40', '2016-12-30 02:22:40'),
(16, 8, 14, NULL, NULL, 16, 38, '2016-12-30 02:22:40', '2016-12-30 02:22:40'),
(24, 16, 10, NULL, NULL, NULL, 26, '2016-12-30 02:35:04', '2016-12-30 02:35:04'),
(25, 16, 11, 'Anything with noodles', 'neutral', NULL, NULL, '2016-12-30 02:35:05', '2016-12-30 02:35:05'),
(26, 16, 12, NULL, NULL, NULL, 29, '2016-12-30 02:35:05', '2016-12-30 02:35:05'),
(27, 16, 12, NULL, NULL, NULL, 30, '2016-12-30 02:35:05', '2016-12-30 02:35:05'),
(28, 16, 13, '8', NULL, NULL, NULL, '2016-12-30 02:35:05', '2016-12-30 02:35:05'),
(29, 16, 14, NULL, NULL, 14, 38, '2016-12-30 02:35:05', '2016-12-30 02:35:05'),
(30, 16, 14, NULL, NULL, 15, 38, '2016-12-30 02:35:05', '2016-12-30 02:35:05'),
(31, 16, 14, NULL, NULL, 16, 39, '2016-12-30 02:35:05', '2016-12-30 02:35:05'),
(32, 17, 10, NULL, NULL, NULL, 26, '2016-12-30 02:36:06', '2016-12-30 02:36:06'),
(33, 17, 11, 'Burger with ham', 'neutral', NULL, NULL, '2016-12-30 02:36:08', '2016-12-30 02:36:08'),
(34, 17, 12, NULL, NULL, NULL, 30, '2016-12-30 02:36:08', '2016-12-30 02:36:08'),
(35, 17, 12, NULL, NULL, NULL, 31, '2016-12-30 02:36:08', '2016-12-30 02:36:08'),
(36, 17, 13, '', NULL, NULL, NULL, '2016-12-30 02:36:08', '2016-12-30 02:36:08'),
(37, 17, 14, NULL, NULL, 14, 38, '2016-12-30 02:36:08', '2016-12-30 02:36:08'),
(38, 17, 14, NULL, NULL, 15, 38, '2016-12-30 02:36:08', '2016-12-30 02:36:08'),
(39, 17, 14, NULL, NULL, 16, 39, '2016-12-30 02:36:08', '2016-12-30 02:36:08'),
(43, 21, 10, NULL, NULL, NULL, 26, '2016-12-30 02:55:27', '2016-12-30 02:55:27'),
(44, 21, 11, 'I really love bacon', 'positive', NULL, NULL, '2016-12-30 02:55:29', '2016-12-30 02:55:29'),
(45, 21, 12, NULL, NULL, NULL, 29, '2016-12-30 02:55:29', '2016-12-30 02:55:29'),
(46, 21, 12, NULL, NULL, NULL, 30, '2016-12-30 02:55:29', '2016-12-30 02:55:29'),
(47, 21, 13, '10', NULL, NULL, NULL, '2016-12-30 02:55:29', '2016-12-30 02:55:29'),
(48, 21, 14, NULL, NULL, 14, 36, '2016-12-30 02:55:29', '2016-12-30 02:55:29'),
(49, 21, 14, NULL, NULL, 15, 38, '2016-12-30 02:55:29', '2016-12-30 02:55:29'),
(50, 21, 14, NULL, NULL, 16, 38, '2016-12-30 02:55:29', '2016-12-30 02:55:29'),
(51, 22, 10, NULL, NULL, NULL, 26, '2016-12-30 02:58:59', '2016-12-30 02:58:59'),
(52, 22, 11, 'nothing', 'negative', NULL, NULL, '2016-12-30 02:59:02', '2016-12-30 02:59:02'),
(53, 22, 12, NULL, NULL, NULL, 29, '2016-12-30 02:59:02', '2016-12-30 02:59:02'),
(54, 22, 13, '6', NULL, NULL, NULL, '2016-12-30 02:59:02', '2016-12-30 02:59:02'),
(55, 22, 14, NULL, NULL, 14, 37, '2016-12-30 02:59:02', '2016-12-30 02:59:02'),
(56, 22, 14, NULL, NULL, 15, 37, '2016-12-30 02:59:02', '2016-12-30 02:59:02'),
(57, 22, 14, NULL, NULL, 16, 38, '2016-12-30 02:59:02', '2016-12-30 02:59:02'),
(58, 23, 10, NULL, NULL, NULL, 26, '2016-12-30 03:03:00', '2016-12-30 03:03:00'),
(59, 23, 11, 'fasdf', 'neutral', NULL, NULL, '2016-12-30 03:03:01', '2016-12-30 03:03:01'),
(60, 23, 12, NULL, NULL, NULL, 31, '2016-12-30 03:03:01', '2016-12-30 03:03:01'),
(61, 23, 13, '4', NULL, NULL, NULL, '2016-12-30 03:03:01', '2016-12-30 03:03:01'),
(62, 23, 14, NULL, NULL, 14, 35, '2016-12-30 03:03:01', '2016-12-30 03:03:01'),
(63, 23, 14, NULL, NULL, 15, 36, '2016-12-30 03:03:01', '2016-12-30 03:03:01'),
(64, 23, 14, NULL, NULL, 16, 37, '2016-12-30 03:03:01', '2016-12-30 03:03:01'),
(66, 25, 10, NULL, NULL, NULL, NULL, '2017-01-01 11:42:31', '2017-01-01 11:42:31'),
(67, 25, 11, '', NULL, NULL, NULL, '2017-01-01 11:42:31', '2017-01-01 11:42:31'),
(68, 25, 13, '', NULL, NULL, NULL, '2017-01-01 11:42:31', '2017-01-01 11:42:31'),
(69, 25, 14, NULL, NULL, 14, NULL, '2017-01-01 11:42:31', '2017-01-01 11:42:31'),
(70, 25, 14, NULL, NULL, 15, NULL, '2017-01-01 11:42:31', '2017-01-01 11:42:31'),
(71, 25, 14, NULL, NULL, 16, NULL, '2017-01-01 11:42:31', '2017-01-01 11:42:31'),
(72, 26, 10, NULL, NULL, NULL, 26, '2017-01-01 14:07:38', '2017-01-01 14:07:38'),
(73, 26, 11, NULL, NULL, NULL, NULL, '2017-01-01 14:07:38', '2017-01-01 14:07:38'),
(74, 26, 13, '8', NULL, NULL, NULL, '2017-01-01 14:07:38', '2017-01-01 14:07:38'),
(75, 26, 14, NULL, NULL, 14, 38, '2017-01-01 14:07:38', '2017-01-01 14:07:38'),
(76, 26, 14, NULL, NULL, 15, 38, '2017-01-01 14:07:38', '2017-01-01 14:07:38'),
(77, 26, 14, NULL, NULL, 16, 38, '2017-01-01 14:07:38', '2017-01-01 14:07:38'),
(78, 27, 10, NULL, NULL, NULL, 26, '2017-01-01 14:07:56', '2017-01-01 14:07:56'),
(79, 27, 11, NULL, NULL, NULL, NULL, '2017-01-01 14:07:56', '2017-01-01 14:07:56'),
(80, 27, 12, NULL, NULL, NULL, 30, '2017-01-01 14:07:56', '2017-01-01 14:07:56'),
(81, 27, 13, NULL, NULL, NULL, NULL, '2017-01-01 14:07:56', '2017-01-01 14:07:56'),
(82, 27, 14, NULL, NULL, 14, 35, '2017-01-01 14:07:56', '2017-01-01 14:07:56'),
(83, 27, 14, NULL, NULL, 15, 35, '2017-01-01 14:07:56', '2017-01-01 14:07:56'),
(84, 27, 14, NULL, NULL, 16, 35, '2017-01-01 14:07:56', '2017-01-01 14:07:56'),
(85, 28, 10, NULL, NULL, NULL, NULL, '2017-01-01 14:08:17', '2017-01-01 14:08:17'),
(86, 28, 11, NULL, NULL, NULL, NULL, '2017-01-01 14:08:17', '2017-01-01 14:08:17'),
(87, 28, 13, NULL, NULL, NULL, NULL, '2017-01-01 14:08:17', '2017-01-01 14:08:17'),
(88, 28, 14, NULL, NULL, 14, NULL, '2017-01-01 14:08:17', '2017-01-01 14:08:17'),
(89, 28, 14, NULL, NULL, 15, NULL, '2017-01-01 14:08:17', '2017-01-01 14:08:17'),
(90, 28, 14, NULL, NULL, 16, NULL, '2017-01-01 14:08:17', '2017-01-01 14:08:17'),
(91, 29, 10, NULL, NULL, NULL, NULL, '2017-01-01 14:11:33', '2017-01-01 14:11:33'),
(92, 29, 11, NULL, NULL, NULL, NULL, '2017-01-01 14:11:33', '2017-01-01 14:11:33'),
(93, 29, 13, NULL, NULL, NULL, NULL, '2017-01-01 14:11:33', '2017-01-01 14:11:33'),
(94, 29, 14, NULL, NULL, 14, NULL, '2017-01-01 14:11:33', '2017-01-01 14:11:33'),
(95, 29, 14, NULL, NULL, 15, NULL, '2017-01-01 14:11:33', '2017-01-01 14:11:33'),
(96, 29, 14, NULL, NULL, 16, NULL, '2017-01-01 14:11:33', '2017-01-01 14:11:33'),
(98, 31, 10, NULL, NULL, NULL, NULL, '2017-01-01 14:14:40', '2017-01-01 14:14:40'),
(99, 31, 11, NULL, NULL, NULL, NULL, '2017-01-01 14:14:40', '2017-01-01 14:14:40'),
(100, 31, 13, NULL, NULL, NULL, NULL, '2017-01-01 14:14:40', '2017-01-01 14:14:40'),
(101, 31, 14, NULL, NULL, 14, NULL, '2017-01-01 14:14:40', '2017-01-01 14:14:40'),
(102, 31, 14, NULL, NULL, 15, NULL, '2017-01-01 14:14:40', '2017-01-01 14:14:40'),
(103, 31, 14, NULL, NULL, 16, NULL, '2017-01-01 14:14:40', '2017-01-01 14:14:40'),
(104, 32, 10, NULL, NULL, NULL, NULL, '2017-01-01 14:15:22', '2017-01-01 14:15:22'),
(105, 32, 11, NULL, NULL, NULL, NULL, '2017-01-01 14:15:22', '2017-01-01 14:15:22'),
(106, 32, 13, NULL, NULL, NULL, NULL, '2017-01-01 14:15:22', '2017-01-01 14:15:22'),
(107, 32, 14, NULL, NULL, 14, NULL, '2017-01-01 14:15:22', '2017-01-01 14:15:22'),
(108, 32, 14, NULL, NULL, 15, NULL, '2017-01-01 14:15:22', '2017-01-01 14:15:22'),
(109, 32, 14, NULL, NULL, 16, NULL, '2017-01-01 14:15:22', '2017-01-01 14:15:22'),
(110, 33, 10, NULL, NULL, NULL, NULL, '2017-01-01 14:15:52', '2017-01-01 14:15:52'),
(111, 33, 11, NULL, NULL, NULL, NULL, '2017-01-01 14:15:52', '2017-01-01 14:15:52'),
(112, 33, 13, NULL, NULL, NULL, NULL, '2017-01-01 14:15:52', '2017-01-01 14:15:52'),
(113, 33, 14, NULL, NULL, 14, NULL, '2017-01-01 14:15:52', '2017-01-01 14:15:52'),
(114, 33, 14, NULL, NULL, 15, NULL, '2017-01-01 14:15:52', '2017-01-01 14:15:52'),
(115, 33, 14, NULL, NULL, 16, NULL, '2017-01-01 14:15:52', '2017-01-01 14:15:52'),
(116, 34, 10, NULL, NULL, NULL, NULL, '2017-01-01 14:22:18', '2017-01-01 14:22:18'),
(117, 34, 11, NULL, NULL, NULL, NULL, '2017-01-01 14:22:18', '2017-01-01 14:22:18'),
(118, 34, 13, NULL, NULL, NULL, NULL, '2017-01-01 14:22:18', '2017-01-01 14:22:18'),
(119, 34, 14, NULL, NULL, 14, NULL, '2017-01-01 14:22:18', '2017-01-01 14:22:18'),
(120, 34, 14, NULL, NULL, 15, NULL, '2017-01-01 14:22:18', '2017-01-01 14:22:18'),
(121, 34, 14, NULL, NULL, 16, NULL, '2017-01-01 14:22:18', '2017-01-01 14:22:18'),
(122, 35, 10, NULL, NULL, NULL, NULL, '2017-01-01 15:14:53', '2017-01-01 15:14:53'),
(123, 35, 11, NULL, NULL, NULL, NULL, '2017-01-01 15:14:53', '2017-01-01 15:14:53'),
(124, 35, 12, NULL, NULL, NULL, 29, '2017-01-01 15:14:53', '2017-01-01 15:14:53'),
(125, 35, 12, NULL, NULL, NULL, 30, '2017-01-01 15:14:53', '2017-01-01 15:14:53'),
(126, 35, 12, NULL, NULL, NULL, 31, '2017-01-01 15:14:53', '2017-01-01 15:14:53'),
(127, 35, 12, NULL, NULL, NULL, 32, '2017-01-01 15:14:53', '2017-01-01 15:14:53'),
(128, 35, 12, NULL, NULL, NULL, 33, '2017-01-01 15:14:53', '2017-01-01 15:14:53'),
(129, 35, 12, NULL, NULL, NULL, 34, '2017-01-01 15:14:53', '2017-01-01 15:14:53'),
(130, 35, 13, NULL, NULL, NULL, NULL, '2017-01-01 15:14:53', '2017-01-01 15:14:53'),
(131, 35, 14, NULL, NULL, 14, NULL, '2017-01-01 15:14:53', '2017-01-01 15:14:53'),
(132, 35, 14, NULL, NULL, 15, NULL, '2017-01-01 15:14:53', '2017-01-01 15:14:53'),
(133, 35, 14, NULL, NULL, 16, NULL, '2017-01-01 15:14:53', '2017-01-01 15:14:53'),
(134, 36, 10, NULL, NULL, NULL, NULL, '2017-01-01 15:15:09', '2017-01-01 15:15:09'),
(135, 36, 11, NULL, NULL, NULL, NULL, '2017-01-01 15:15:09', '2017-01-01 15:15:09'),
(136, 36, 13, NULL, NULL, NULL, NULL, '2017-01-01 15:15:09', '2017-01-01 15:15:09'),
(137, 36, 14, NULL, NULL, 14, NULL, '2017-01-01 15:15:09', '2017-01-01 15:15:09'),
(138, 36, 14, NULL, NULL, 15, NULL, '2017-01-01 15:15:09', '2017-01-01 15:15:09'),
(139, 36, 14, NULL, NULL, 16, NULL, '2017-01-01 15:15:09', '2017-01-01 15:15:09'),
(140, 37, 10, NULL, NULL, NULL, NULL, '2017-01-01 15:40:22', '2017-01-01 15:40:22'),
(141, 37, 11, '69', NULL, NULL, NULL, '2017-01-01 15:40:22', '2017-01-01 15:40:22'),
(142, 37, 13, NULL, NULL, NULL, NULL, '2017-01-01 15:40:22', '2017-01-01 15:40:22'),
(143, 37, 14, NULL, NULL, 14, NULL, '2017-01-01 15:40:22', '2017-01-01 15:40:22'),
(144, 37, 14, NULL, NULL, 15, NULL, '2017-01-01 15:40:22', '2017-01-01 15:40:22'),
(145, 37, 14, NULL, NULL, 16, NULL, '2017-01-01 15:40:22', '2017-01-01 15:40:22'),
(146, 38, 10, NULL, NULL, NULL, 27, '2017-01-02 06:46:53', '2017-01-02 06:46:53'),
(147, 38, 11, 'holiday', 'neutral', NULL, NULL, '2017-01-02 06:46:56', '2017-01-02 06:46:56'),
(148, 38, 12, NULL, NULL, NULL, 29, '2017-01-02 06:46:56', '2017-01-02 06:46:56'),
(149, 38, 12, NULL, NULL, NULL, 30, '2017-01-02 06:46:56', '2017-01-02 06:46:56'),
(150, 38, 13, '1', NULL, NULL, NULL, '2017-01-02 06:46:56', '2017-01-02 06:46:56'),
(151, 38, 14, NULL, NULL, 14, 35, '2017-01-02 06:46:56', '2017-01-02 06:46:56'),
(152, 38, 14, NULL, NULL, 15, 35, '2017-01-02 06:46:56', '2017-01-02 06:46:56'),
(153, 38, 14, NULL, NULL, 16, 35, '2017-01-02 06:46:56', '2017-01-02 06:46:56'),
(154, 39, 10, NULL, NULL, NULL, NULL, '2017-01-04 07:16:44', '2017-01-04 07:16:44'),
(155, 39, 11, NULL, NULL, NULL, NULL, '2017-01-04 07:16:44', '2017-01-04 07:16:44'),
(156, 39, 13, NULL, NULL, NULL, NULL, '2017-01-04 07:16:44', '2017-01-04 07:16:44'),
(157, 39, 14, NULL, NULL, 14, NULL, '2017-01-04 07:16:44', '2017-01-04 07:16:44'),
(158, 39, 14, NULL, NULL, 15, NULL, '2017-01-04 07:16:44', '2017-01-04 07:16:44'),
(159, 39, 14, NULL, NULL, 16, NULL, '2017-01-04 07:16:44', '2017-01-04 07:16:44'),
(160, 40, 10, NULL, NULL, NULL, NULL, '2017-01-04 07:17:53', '2017-01-04 07:17:53'),
(161, 40, 11, NULL, NULL, NULL, NULL, '2017-01-04 07:17:53', '2017-01-04 07:17:53'),
(162, 40, 13, NULL, NULL, NULL, NULL, '2017-01-04 07:17:53', '2017-01-04 07:17:53'),
(163, 40, 14, NULL, NULL, 14, NULL, '2017-01-04 07:17:53', '2017-01-04 07:17:53'),
(164, 40, 14, NULL, NULL, 15, NULL, '2017-01-04 07:17:53', '2017-01-04 07:17:53'),
(165, 40, 14, NULL, NULL, 16, NULL, '2017-01-04 07:17:53', '2017-01-04 07:17:53'),
(166, 41, 10, NULL, NULL, NULL, 26, '2017-01-05 15:46:42', '2017-01-05 15:46:42'),
(167, 41, 11, 'Code', NULL, NULL, NULL, '2017-01-05 15:46:42', '2017-01-05 15:46:42'),
(168, 41, 14, NULL, NULL, NULL, 38, '2017-01-05 15:46:42', '2017-01-05 15:46:42'),
(169, 41, 14, NULL, NULL, NULL, 38, '2017-01-05 15:46:42', '2017-01-05 15:46:42'),
(170, 41, 14, NULL, NULL, NULL, 37, '2017-01-05 15:46:42', '2017-01-05 15:46:42'),
(171, 41, 12, NULL, NULL, NULL, 30, '2017-01-05 15:46:42', '2017-01-05 15:46:42'),
(172, 41, 12, NULL, NULL, NULL, 31, '2017-01-05 15:46:42', '2017-01-05 15:46:42'),
(173, 41, 13, '8', NULL, NULL, NULL, '2017-01-05 15:46:42', '2017-01-05 15:46:42'),
(174, 42, 10, NULL, NULL, NULL, NULL, '2017-01-11 02:39:16', '2017-01-11 02:39:16'),
(175, 42, 11, NULL, NULL, NULL, NULL, '2017-01-11 02:39:16', '2017-01-11 02:39:16'),
(176, 42, 13, NULL, NULL, NULL, NULL, '2017-01-11 02:39:16', '2017-01-11 02:39:16'),
(177, 42, 14, NULL, NULL, 14, NULL, '2017-01-11 02:39:16', '2017-01-11 02:39:16'),
(178, 42, 14, NULL, NULL, 15, NULL, '2017-01-11 02:39:16', '2017-01-11 02:39:16'),
(179, 42, 14, NULL, NULL, 16, NULL, '2017-01-11 02:39:16', '2017-01-11 02:39:16'),
(180, 43, 10, NULL, NULL, NULL, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(181, 43, 11, NULL, NULL, NULL, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(182, 43, 13, NULL, NULL, NULL, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(183, 43, 14, NULL, NULL, 14, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(184, 43, 14, NULL, NULL, 15, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(185, 43, 14, NULL, NULL, 16, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(186, 44, 10, NULL, NULL, NULL, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(187, 44, 11, NULL, NULL, NULL, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(188, 44, 13, NULL, NULL, NULL, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(189, 44, 14, NULL, NULL, 14, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(190, 44, 14, NULL, NULL, 15, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(191, 44, 14, NULL, NULL, 16, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(192, 45, 10, NULL, NULL, NULL, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(193, 45, 11, NULL, NULL, NULL, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(194, 45, 13, NULL, NULL, NULL, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(195, 45, 14, NULL, NULL, 14, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(196, 45, 14, NULL, NULL, 15, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17'),
(197, 45, 14, NULL, NULL, 16, NULL, '2017-01-11 02:39:17', '2017-01-11 02:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `response_sources`
--

CREATE TABLE `response_sources` (
  `id` int(10) UNSIGNED NOT NULL,
  `source` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_modules`
--

CREATE TABLE `role_modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `module_id` int(10) UNSIGNED NOT NULL,
  `can_read` tinyint(1) NOT NULL DEFAULT '0',
  `can_write` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_modules`
--

INSERT INTO `role_modules` (`id`, `role_id`, `module_id`, `can_read`, `can_write`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '2016-12-23 09:27:59', NULL),
(2, 1, 2, 1, 1, '2016-12-23 09:27:59', NULL),
(3, 1, 3, 1, 1, '2016-12-23 09:27:59', NULL),
(4, 1, 4, 1, 1, '2016-12-23 09:27:59', NULL),
(5, 1, 5, 1, 1, '2016-12-23 09:27:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `survey_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `is_template` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `user_id`, `survey_title`, `category_id`, `published`, `is_template`, `created_at`, `updated_at`) VALUES
(1, 2, 'My very first Survey', NULL, 1, 0, '2016-12-23 09:30:32', '2016-12-27 09:24:08'),
(2, 2, 'Analyze Test', NULL, 1, 0, '2016-12-27 10:50:50', '2016-12-30 02:27:18'),
(3, 2, 'sound test', NULL, 1, 0, '2017-01-04 10:22:48', '2017-01-04 10:23:47'),
(4, 2, 'Testing pa', NULL, 1, 0, '2017-01-04 13:54:20', '2017-01-04 13:55:06'),
(6, 2, 'Earl awesome survey', NULL, 1, 0, '2017-01-11 04:21:31', '2017-01-11 04:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `survey_categories`
--

CREATE TABLE `survey_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `survey_categories`
--

INSERT INTO `survey_categories` (`id`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Other', '2016-12-23 09:27:59', NULL),
(2, 'Community', '2016-12-23 09:27:59', NULL),
(3, 'Customer Feedback', '2016-12-23 09:27:59', NULL),
(4, 'Health', '2016-12-23 09:27:59', NULL),
(5, 'Just for Fun', '2016-12-23 09:27:59', NULL),
(6, 'Software Evaluation', '2016-12-23 09:27:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `survey_options`
--

CREATE TABLE `survey_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED NOT NULL,
  `open` tinyint(1) NOT NULL DEFAULT '1',
  `closed_message` text COLLATE utf8_unicode_ci,
  `response_message` text COLLATE utf8_unicode_ci,
  `multiple_responses` tinyint(1) NOT NULL DEFAULT '0',
  `target_responses` int(11) DEFAULT NULL,
  `register_required` tinyint(1) NOT NULL DEFAULT '0',
  `date_close` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `survey_options`
--

INSERT INTO `survey_options` (`id`, `survey_id`, `open`, `closed_message`, `response_message`, `multiple_responses`, `target_responses`, `register_required`, `date_close`) VALUES
(1, 1, 1, NULL, '', 1, NULL, 0, NULL),
(2, 2, 1, NULL, '', 1, NULL, 0, NULL),
(3, 3, 1, NULL, NULL, 0, NULL, 0, NULL),
(4, 4, 1, NULL, NULL, 0, NULL, 0, NULL),
(6, 6, 1, NULL, NULL, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `survey_pages`
--

CREATE TABLE `survey_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED NOT NULL,
  `page_no` int(11) NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `survey_pages`
--

INSERT INTO `survey_pages` (`id`, `survey_id`, `page_no`, `page_title`, `page_description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '', '', '2016-12-23 09:30:32', '2016-12-27 08:22:43'),
(2, 2, 1, 'Test Title', 'Hi I''m Earl :) I''m just trying my Survey Thesis. Thanks!', '2016-12-27 10:50:50', '2016-12-27 11:15:37'),
(3, 3, 1, '', '', '2017-01-04 10:22:48', '2017-01-04 10:23:21'),
(4, 4, 1, '', '', '2017-01-04 13:54:20', '2017-01-04 13:55:03'),
(6, 6, 1, '', '', '2017-01-11 04:21:31', '2017-01-11 04:21:52');

-- --------------------------------------------------------

--
-- Table structure for table `text_analyses`
--

CREATE TABLE `text_analyses` (
  `id` int(10) UNSIGNED NOT NULL,
  `detail_id` int(10) UNSIGNED NOT NULL,
  `sentiment` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(10) UNSIGNED DEFAULT '2',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `phone`, `gender`, `birthday`, `country`, `state`, `city`, `role_id`, `verified`, `activation_code`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'earl', 'Earl', 'Savadera', 'earl_savadera@yahoo.com', '$2y$10$L5IrJ.nKqhy4Eboj3MRRI.ov1YAi49AV9S5BynnVeaWRqiaTvfEka', '', 'Male', '1997-02-22', 'PH', 'CAV', 'Dasmariñas', 1, 1, NULL, 'MioqyVhtz2Cxwop2gJZaptq8LDD353jVxIdRCXutRfx4qlzw5fBYOpt9srmn', '2016-12-23 09:27:59', '2016-12-27 08:11:03'),
(2, 'test', 'Test', 'User', 'test@e-survey.xyz', '$2y$10$ZmyeK53cg60P9xF6mPuZYe8Vee4BPvvRmEilTmureZMMPBvK6ZIce', '', '', '0000-00-00', '', '', '', 2, 1, NULL, 'tf36VRfJgTrPFS0BtdydHmvOfamYpzqXDmASNEScJYzqt1dETrCFjtaQ0tJh', '2016-12-23 09:27:59', '2016-12-24 05:47:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', '2016-12-23 09:27:59', NULL),
(2, 'User', '2016-12-23 09:27:59', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD UNIQUE KEY `cache_key_unique` (`key`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_reserved_at_index` (`queue`,`reserved`,`reserved_at`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_survey_page_id_foreign` (`survey_page_id`),
  ADD KEY `questions_question_type_id_foreign` (`question_type_id`);

--
-- Indexes for table `question_choices`
--
ALTER TABLE `question_choices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_choices_question_id_foreign` (`question_id`);

--
-- Indexes for table `question_options`
--
ALTER TABLE `question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_options_question_id_foreign` (`question_id`);

--
-- Indexes for table `question_rows`
--
ALTER TABLE `question_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_rows_question_id_foreign` (`question_id`);

--
-- Indexes for table `question_types`
--
ALTER TABLE `question_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `question_types_type_unique` (`type`);

--
-- Indexes for table `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `responses_survey_id_foreign` (`survey_id`),
  ADD KEY `responses_user_id_foreign` (`user_id`);

--
-- Indexes for table `response_details`
--
ALTER TABLE `response_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `response_details_response_id_foreign` (`response_id`),
  ADD KEY `response_details_question_id_foreign` (`question_id`),
  ADD KEY `response_details_choice_id_foreign` (`choice_id`),
  ADD KEY `row_id` (`row_id`);

--
-- Indexes for table `response_sources`
--
ALTER TABLE `response_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_modules`
--
ALTER TABLE `role_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_modules_role_id_foreign` (`role_id`),
  ADD KEY `role_modules_module_id_foreign` (`module_id`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surveys_user_id_foreign` (`user_id`),
  ADD KEY `surveys_category_id_foreign` (`category_id`);

--
-- Indexes for table `survey_categories`
--
ALTER TABLE `survey_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `survey_categories_category_unique` (`category`);

--
-- Indexes for table `survey_options`
--
ALTER TABLE `survey_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_options_survey_id_foreign` (`survey_id`);

--
-- Indexes for table `survey_pages`
--
ALTER TABLE `survey_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_pages_survey_id_foreign` (`survey_id`);

--
-- Indexes for table `text_analyses`
--
ALTER TABLE `text_analyses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `question_choices`
--
ALTER TABLE `question_choices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `question_options`
--
ALTER TABLE `question_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `question_rows`
--
ALTER TABLE `question_rows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `question_types`
--
ALTER TABLE `question_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `responses`
--
ALTER TABLE `responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `response_details`
--
ALTER TABLE `response_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;
--
-- AUTO_INCREMENT for table `response_sources`
--
ALTER TABLE `response_sources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `role_modules`
--
ALTER TABLE `role_modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `survey_categories`
--
ALTER TABLE `survey_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `survey_options`
--
ALTER TABLE `survey_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `survey_pages`
--
ALTER TABLE `survey_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `text_analyses`
--
ALTER TABLE `text_analyses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_question_type_id_foreign` FOREIGN KEY (`question_type_id`) REFERENCES `question_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `questions_survey_page_id_foreign` FOREIGN KEY (`survey_page_id`) REFERENCES `survey_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question_choices`
--
ALTER TABLE `question_choices`
  ADD CONSTRAINT `question_choices_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question_options`
--
ALTER TABLE `question_options`
  ADD CONSTRAINT `question_options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question_rows`
--
ALTER TABLE `question_rows`
  ADD CONSTRAINT `question_rows_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `responses`
--
ALTER TABLE `responses`
  ADD CONSTRAINT `responses_survey_id_foreign` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `responses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `response_details`
--
ALTER TABLE `response_details`
  ADD CONSTRAINT `response_details_choice_id_foreign` FOREIGN KEY (`choice_id`) REFERENCES `question_choices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `response_details_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `response_details_response_id_foreign` FOREIGN KEY (`response_id`) REFERENCES `responses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `response_details_row_id_foreign` FOREIGN KEY (`row_id`) REFERENCES `question_rows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_modules`
--
ALTER TABLE `role_modules`
  ADD CONSTRAINT `role_modules_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_modules_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `surveys`
--
ALTER TABLE `surveys`
  ADD CONSTRAINT `surveys_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `survey_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `surveys_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `survey_options`
--
ALTER TABLE `survey_options`
  ADD CONSTRAINT `survey_options_survey_id_foreign` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `survey_pages`
--
ALTER TABLE `survey_pages`
  ADD CONSTRAINT `survey_pages_survey_id_foreign` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
