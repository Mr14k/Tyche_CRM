-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2026 at 11:12 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tyche_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `module` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `module`, `action`, `description`, `ip_address`, `created_at`) VALUES
(1, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 12:12:47'),
(2, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 12:12:54'),
(3, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 12:19:38'),
(4, 1, 'AUTH', 'LOGOUT', 'User logged out', '::1', '2026-07-27 12:21:01'),
(5, 2, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 12:21:10'),
(6, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 12:33:09'),
(7, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 12:33:19'),
(8, 2, 'AUTH', 'LOGOUT', 'User logged out', '::1', '2026-07-27 12:34:52'),
(9, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 12:35:18'),
(10, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 12:55:42'),
(11, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 12:55:50'),
(12, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 13:13:41'),
(13, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 13:15:10'),
(14, 1, 'AUTH', 'LOGOUT', 'User logged out', '::1', '2026-07-27 13:15:28'),
(15, 2, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 13:15:40'),
(16, 2, 'AUTH', 'LOGOUT', 'User logged out', '::1', '2026-07-27 13:16:26'),
(17, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 13:16:39'),
(18, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 13:23:05'),
(19, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 13:23:16'),
(20, 1, 'AUTH', 'LOGOUT', 'User logged out', '::1', '2026-07-27 13:25:30'),
(21, 2, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 13:25:47'),
(22, 2, 'AUTH', 'LOGOUT', 'User logged out', '::1', '2026-07-27 13:27:22'),
(23, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 13:27:42'),
(24, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 14:03:27'),
(25, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 14:04:23'),
(26, 1, 'AUTH', 'LOGOUT', 'User logged out', '::1', '2026-07-27 14:07:27'),
(27, 2, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 14:07:42'),
(28, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 14:12:27'),
(29, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 14:12:35'),
(30, 2, 'AUTH', 'LOGOUT', 'User logged out', '::1', '2026-07-27 14:17:13'),
(31, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 14:17:19'),
(32, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 14:19:32'),
(33, 1, 'LMS', 'CREATE_COURSE', 'Created course Programmatic Advertising & DV360 (Supreme)', '::1', '2026-07-27 14:24:19'),
(34, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 14:27:12'),
(35, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 14:38:33'),
(36, 1, 'LMS', 'UPDATE_COURSE', 'Updated course details and fees for Programmatic Advertising & DV360', '::1', '2026-07-27 14:41:56'),
(37, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 14:45:20'),
(38, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 14:57:30'),
(39, 1, 'LMS', 'CREATE_COURSE', 'Created course The Apex: Web Fundamentals for Marketers (Apex)', '::1', '2026-07-27 15:00:13'),
(40, 1, 'LMS', 'UPDATE_COURSE', 'Updated course details and fees for The Apex: Web Fundamentals for Marketers', '::1', '2026-07-27 15:00:37'),
(41, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 15:03:16'),
(42, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 15:07:23'),
(43, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 15:09:58'),
(44, 1, 'LMS', 'UPDATE_COURSE', 'Updated course details and custom highlights for The Coin: Meta & Google Performance Ads', '::1', '2026-07-27 15:16:44'),
(45, 1, 'LMS', 'UPDATE_COURSE', 'Updated course details and custom highlights for The Coin: Meta & Google Performance Ads', '::1', '2026-07-27 15:17:28'),
(46, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 15:23:40'),
(47, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 15:52:40'),
(48, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 17:05:28'),
(49, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 17:09:17'),
(50, 3, 'AUTH', 'REGISTER', 'Student self-registered account', '::1', '2026-07-27 17:15:49'),
(51, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 17:19:12'),
(52, 4, 'AUTH', 'REGISTER', 'Student self-registered account', '127.0.0.1', '2026-07-27 17:19:41'),
(53, 3, 'AUTH', 'LOGOUT', 'User logged out', '::1', '2026-07-27 17:21:47'),
(54, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 17:22:03'),
(55, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 17:24:19'),
(56, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 17:34:17'),
(57, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 17:36:53'),
(58, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 17:55:59'),
(59, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 18:27:23'),
(60, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-27 18:27:56'),
(61, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-27 18:59:49'),
(62, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-28 10:09:07'),
(63, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-28 10:09:41'),
(64, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-28 10:10:14'),
(65, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-28 18:52:35'),
(66, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-29 10:32:40'),
(67, 5, 'AUTH', 'REGISTER', 'Student self-registered account', '127.0.0.1', '2026-07-29 10:36:42'),
(68, 6, 'AUTH', 'REGISTER', 'Student self-registered account', '127.0.0.1', '2026-07-29 10:36:53'),
(69, 7, 'AUTH', 'REGISTER', 'Student self-registered account', '127.0.0.1', '2026-07-29 10:37:14'),
(70, 8, 'AUTH', 'REGISTER', 'Student self-registered account', '127.0.0.1', '2026-07-29 10:37:43'),
(71, 9, 'AUTH', 'REGISTER', 'Student self-registered account', '127.0.0.1', '2026-07-29 10:37:59'),
(72, 10, 'AUTH', 'REGISTER', 'Student self-registered account', '127.0.0.1', '2026-07-29 10:38:31'),
(73, 11, 'AUTH', 'REGISTER', 'Student self-registered account', '127.0.0.1', '2026-07-29 10:38:40'),
(74, 12, 'AUTH', 'REGISTER', 'Student self-registered account', '127.0.0.1', '2026-07-29 10:38:50'),
(75, 13, 'AUTH', 'REGISTER', 'Student self-registered account', '127.0.0.1', '2026-07-29 10:39:17'),
(76, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-29 10:39:22'),
(77, 14, 'AUTH', 'REGISTER', 'Student self-registered account', '127.0.0.1', '2026-07-29 10:42:16'),
(78, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-29 10:42:21'),
(79, 1, 'AUTH', 'LOGOUT', 'User logged out', '::1', '2026-07-29 10:43:09'),
(80, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-29 10:43:21'),
(81, 15, 'AUTH', 'REGISTER', 'Student self-registered account', '127.0.0.1', '2026-07-29 10:44:18'),
(82, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-29 10:44:25'),
(83, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-29 12:00:46'),
(84, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-29 12:37:11'),
(85, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-29 12:58:08'),
(86, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-29 13:03:22'),
(87, 1, 'USERS', 'CREATE', 'Created user account pragya@xtech.com', '::1', '2026-07-29 13:04:55'),
(88, 16, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-29 13:05:38'),
(89, 1, 'RBAC', 'UPDATE_MATRIX', 'Updated role permission matrix definitions', '::1', '2026-07-29 13:06:49'),
(90, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-29 13:07:25'),
(91, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '127.0.0.1', '2026-07-29 13:13:07'),
(92, 16, 'AUTH', 'LOGOUT', 'User logged out', '::1', '2026-07-29 13:13:56'),
(93, 16, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-29 13:14:06'),
(94, 1, 'AUTH', 'LOGOUT', 'User logged out', '::1', '2026-07-29 13:15:00'),
(95, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-29 13:15:11'),
(96, 1, 'AUTH', 'LOGIN', 'User logged in successfully', '::1', '2026-07-29 14:18:42');

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admission_number` varchar(50) NOT NULL,
  `lead_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `batch_name` varchar(100) NOT NULL DEFAULT 'Morning Batch A',
  `total_fee` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `final_fee` decimal(10,2) NOT NULL,
  `admission_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admissions`
--

INSERT INTO `admissions` (`id`, `admission_number`, `lead_id`, `user_id`, `course_id`, `batch_name`, `total_fee`, `discount_amount`, `final_fee`, `admission_date`) VALUES
(1, 'TYCHE-ADM-2026-0042', 1, 2, 1, 'Morning Batch A', 6000.00, 0.00, 6000.00, '2026-07-27 13:21:27');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `chapter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `instructions` longtext NOT NULL,
  `max_marks` int(10) UNSIGNED NOT NULL DEFAULT 100,
  `due_date` datetime NOT NULL,
  `attachment_url` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `course_id`, `chapter_id`, `title`, `instructions`, `max_marks`, `due_date`, `attachment_url`, `created_at`) VALUES
(1, 1, NULL, 'Capstone: Technical SEO Audit & AI Citation Strategy', 'Perform a complete technical crawl audit on a sample site, structure schema JSON-LD markup, and submit a PDF report or GitHub repository link.', 100, '2026-08-10 13:11:52', NULL, '2026-07-27 13:11:52');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assignment_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `submission_type` enum('file','github_url','drive_url','text') NOT NULL DEFAULT 'file',
  `submission_text` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `status` enum('submitted','under_review','graded','resubmission_requested') NOT NULL DEFAULT 'submitted',
  `marks_awarded` int(10) UNSIGNED DEFAULT NULL,
  `feedback_notes` text DEFAULT NULL,
  `graded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `submitted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `graded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assignment_submissions`
--

INSERT INTO `assignment_submissions` (`id`, `assignment_id`, `user_id`, `submission_type`, `submission_text`, `file_path`, `github_url`, `status`, `marks_awarded`, `feedback_notes`, `graded_by`, `submitted_at`, `graded_at`) VALUES
(1, 1, 2, 'github_url', NULL, NULL, 'https://github.com/student/seo-audit-capstone', 'graded', 92, 'Excellent crawl budget analysis and schema JSON-LD implementation.', 1, '2026-07-27 13:13:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `type` enum('hero','course','popup','announcement') NOT NULL DEFAULT 'hero',
  `image_url` varchar(255) NOT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `type`, `image_url`, `button_text`, `button_url`, `start_date`, `end_date`, `is_active`) VALUES
(1, 'Founding Cohort Open for Enrollment', 'hero', 'assets/img/banner_hero.jpg', 'Reserve Your Seat', '/#join', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `batch_name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `schedule_type` enum('weekend','weekday','evening') DEFAULT 'weekend',
  `capacity` int(11) NOT NULL DEFAULT 30,
  `seats_filled` int(11) NOT NULL DEFAULT 0,
  `status` enum('upcoming','active','completed','full') DEFAULT 'upcoming',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `course_id`, `batch_name`, `start_date`, `end_date`, `schedule_type`, `capacity`, `seats_filled`, `status`, `created_at`) VALUES
(1, 1, 'The Compass: SEO, AEO & GEO Mastery - Cohort Alpha 2026', '2026-08-05', '2026-10-04', 'weekend', 25, 8, 'active', '2026-07-29 07:03:25'),
(2, 2, 'The Coin: Meta & Google Performance Ads - Cohort Alpha 2026', '2026-08-05', '2026-10-04', 'weekend', 25, 3, 'active', '2026-07-29 07:03:25'),
(3, 3, 'Programmatic Advertising & DV360 - Cohort Alpha 2026', '2026-08-05', '2026-10-04', 'weekend', 25, 3, 'active', '2026-07-29 07:03:25'),
(4, 4, 'The Apex: Web Fundamentals for Marketers - Cohort Alpha 2026', '2026-08-05', '2026-10-04', 'weekend', 25, 3, 'active', '2026-07-29 07:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `bi_reports`
--

CREATE TABLE `bi_reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `category` varchar(50) NOT NULL,
  `query_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`query_config`)),
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `image_url`, `parent_id`, `sort_order`) VALUES
(1, 'SEO & Answer Engines', 'seo-answer-engines', 'Search Engine Optimization, AEO, and GEO strategies', NULL, NULL, 0),
(2, 'Performance Advertising', 'performance-advertising', 'Meta Ads, Google Ads, and ROAS optimization', NULL, NULL, 0),
(3, 'Programmatic Media', 'programmatic-media', 'DV360 and open web media buying', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(220) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `summary` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `reading_time_minutes` int(11) NOT NULL DEFAULT 5,
  `status` enum('draft','published','scheduled','archived') NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_sticky` tinyint(1) NOT NULL DEFAULT 0,
  `views_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `summary`, `content`, `featured_image`, `category_id`, `author_id`, `reading_time_minutes`, `status`, `is_featured`, `is_sticky`, `views_count`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'Optimizing for AI Overviews: The Rise of Generative Engine Optimization', 'optimizing-for-ai-overviews', 'How answer engines like ChatGPT and Gemini are changing SEO fundamentals.', '<h2>The Shift from Blue Links to Direct Answers</h2><p>In 2026, search optimization is no longer just about ranking #1 on a traditional SERP. It is about citation-worthiness in Generative AI models...</p>', NULL, 1, 1, 5, 'published', 1, 0, 1, '2026-07-27 12:53:15', '2026-07-27 12:53:15', '2026-07-27 14:19:03'),
(4, '2026 Guide to AEO & GEO Search Optimization', '2026-guide-to-aeo-geo-search-optimization-90', 'Discover how ChatGPT 4o, Perplexity AI, and Google AI Overviews surface digital marketing brands in 2026.', '<h2>Introduction</h2><p>Decorated blog content written using the <strong>Rich Text Editor</strong> inside Admin Dashboard.</p>', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80', 1, 1, 3, 'published', 1, 1, 129, '2026-07-28 06:39:36', '2026-07-28 10:09:36', '2026-07-28 10:13:06');

-- --------------------------------------------------------

--
-- Table structure for table `blog_tags`
--

CREATE TABLE `blog_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_studies`
--

CREATE TABLE `case_studies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_name` varchar(150) NOT NULL,
  `industry` varchar(100) NOT NULL,
  `title` varchar(220) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `problem_statement` text NOT NULL,
  `solution` text NOT NULL,
  `strategy` longtext NOT NULL,
  `results_summary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`results_summary`)),
  `featured_image` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_studies`
--

INSERT INTO `case_studies` (`id`, `client_name`, `industry`, `title`, `slug`, `problem_statement`, `solution`, `strategy`, `results_summary`, `featured_image`, `is_featured`, `created_at`) VALUES
(1, 'Fintech Growth Acceleration', 'Fintech', 'Scaling Meta Ads ROAS from 1.8x to 4.2x in 90 Days', 'fintech-growth-scaling', 'High customer acquisition cost and creative fatigue.', 'Re-architected campaign structure and deployed automated lookalike targeting.', 'Structured dynamic creative testing across Reels and Feed placements.', '{\"ROAS\": \"4.2x\", \"CAC Reduction\": \"45%\", \"Ad Spend Scaled\": \"₹25L/mo\"}', NULL, 1, '2026-07-27 12:53:15');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `certificate_code` varchar(50) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `issue_date` datetime NOT NULL DEFAULT current_timestamp(),
  `final_score_percentage` decimal(5,2) NOT NULL DEFAULT 100.00,
  `verification_hash` varchar(64) NOT NULL,
  `pdf_path` varchar(255) DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `certificate_code`, `user_id`, `course_id`, `issue_date`, `final_score_percentage`, `verification_hash`, `pdf_path`, `is_valid`) VALUES
(1, 'TYCHE-CERT-2026-4ABA91E6', 2, 1, '2026-07-27 13:13:41', 100.00, '713b880312a865002b1c76f12ce1482fc0fcfcc92268d6aa5a7beb17476d0408', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `communication_logs`
--

CREATE TABLE `communication_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `recipient` varchar(150) NOT NULL,
  `channel` enum('email','sms','whatsapp','in_app') NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message_body` text NOT NULL,
  `status` enum('sent','failed','queued') NOT NULL DEFAULT 'sent',
  `sent_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `communication_logs`
--

INSERT INTO `communication_logs` (`id`, `user_id`, `recipient`, `channel`, `subject`, `message_body`, `status`, `sent_at`) VALUES
(1, 2, 'student@tyche.academy', 'email', 'Course Enrollment Confirmation', 'Your admission is confirmed!', 'sent', '2026-07-27 13:23:05'),
(2, 2, 'student@tyche.academy', 'email', 'Course Enrollment Confirmation', 'Your admission is confirmed!', 'sent', '2026-07-27 13:23:16'),
(3, 2, 'Student', 'sms', 'Fee Receipt Issued', 'Payment of Rs 3000.00 received. Tax Invoice: TYCHE-INV-2026-2514D3', 'sent', '2026-07-27 15:58:50');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percentage','flat') NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL,
  `max_uses` int(10) UNSIGNED NOT NULL DEFAULT 100,
  `used_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `expires_at` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_value`, `max_uses`, `used_count`, `expires_at`, `is_active`, `created_at`) VALUES
(1, 'TYCHE2026', 'percentage', 15.00, 100, 4, '2026-08-26', 1, '2026-07-27 14:01:39'),
(2, 'EARLYBIRD500', 'flat', 500.00, 50, 2, '2026-08-26', 1, '2026-07-27 14:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `code` varchar(50) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` longtext NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `level` enum('beginner','intermediate','advanced','all_levels') NOT NULL DEFAULT 'all_levels',
  `language` varchar(50) NOT NULL DEFAULT 'English',
  `duration_weeks` int(11) NOT NULL DEFAULT 8,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `live_cohort_price` decimal(10,2) DEFAULT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `allow_skip_lessons` tinyint(1) NOT NULL DEFAULT 0,
  `highlights_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`highlights_json`)),
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `category_id`, `title`, `slug`, `code`, `short_description`, `description`, `thumbnail`, `banner`, `level`, `language`, `duration_weeks`, `price`, `live_cohort_price`, `discount_price`, `allow_skip_lessons`, `highlights_json`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'The Compass: SEO, AEO & GEO Mastery', 'the-compass-seo-mastery', 'COMPASS', 'Be found by search engines, answer engines, and AI models.', 'Full 8-week breakdown covering Technical SEO, Citation-Worthiness in AI Overviews, Schema markup, and keyword strategy.', NULL, NULL, 'all_levels', 'English', 8, 6000.00, 25000.00, NULL, 0, NULL, 'published', 1, '2026-07-27 12:53:15', '2026-07-27 14:37:31'),
(2, 2, 'The Coin: Meta & Google Performance Ads', 'the-coin-performance-ads', 'COIN', 'Turn attention into demand with high-converting campaign structures.', 'Master campaign budgeting, creative hooks, lookalike audiences, and tracking pixels.', NULL, NULL, 'all_levels', 'English', 8, 15000.00, 25000.00, NULL, 0, '{\"section_title\":\"Why Traditional Marketing Courses Fail in 2026\",\"traditional_title\":\"Traditional Coaching Institutes\",\"traditional_points\":[],\"blueprint_title\":\"The Tyche Executive Blueprint\",\"blueprint_points\":[]}', 'published', 1, '2026-07-27 12:53:15', '2026-07-27 15:17:28'),
(3, 3, 'Programmatic Advertising & DV360', 'programmatic-advertising-dv360', 'SUPREME', 'Learn the ad-buying skillset agencies pay premium salaries for', '<h2>Best for: Working marketers looking to upskill, media buyers, agency employees wanting a promotion-worthy skill\r\nDuration: 2–3 weeks\r\nPrerequisites: Basic understanding of digital ads recommended (Course 2 or equivalent experience)\r\nWhat\'s included: Full Module 3 content, DV360 media plan capstone\r\n</h2>', NULL, NULL, 'all_levels', 'English', 8, 25000.00, 35000.00, NULL, 0, NULL, 'published', 1, '2026-07-27 14:24:19', '2026-07-27 14:41:56'),
(4, 4, 'The Apex: Web Fundamentals for Marketers', 'the-apex-web-fundamentals-for-marketers', 'APEX', 'Understand the tech behind your campaigns — landing pages, forms, and tracking, explained for marketers.', 'Stop feeling lost when you talk to developers. This course bridges the gap between marketing strategy and technical execution. Learn the essentials of how the web works, focusing purely on what you need to build, launch, and track high-performing campaigns. From creating pixel-perfect landing pages to setting up accurate tracking, we\'ll strip away the jargon and give you practical, hands-on skills.\r\n\r\nIs This Course for You? (Best For)\r\n\r\nMarketers who feel a sense of dread when developers start talking about HTML, CSS, or APIs.\r\n\r\nFreelancers who want to offer end-to-end services by building client landing pages.\r\n\r\nGraduates of Courses 1–3 who understand SEO and ads but are missing the technical foundation to make their strategies truly effective.\r\n\r\n[What You’ll Gain Section]\r\n\r\nWhat’s Included in Your Learning Journey:\r\n\r\nFull Module 4 Curriculum: Access comprehensive, jargon-free lessons that demystify web technology.\r\n\r\nPractical, Step-by-Step Training: Learn how to create and manage landing pages, set up lead capture forms, and implement essential tracking codes.\r\n\r\nCapstone Project: Your Landing Page Build: Put your skills to the test! Design and build a functional, trackable landing page from scratch. This project becomes a powerful asset in your portfolio.\r\n\r\n[For Self-Paced] Flexibility to learn on your own schedule.\r\n\r\n[For Live Cohort] Expert instruction, peer interaction, and personalized feedback.\r\n\r\nAt a Glance:\r\n\r\nDuration: 2–3 weeks (intensive and focused).\r\n\r\nPrerequisites: None. No coding background is required. We start with the fundamentals.', NULL, NULL, 'all_levels', 'English', 8, 10000.00, 18000.00, NULL, 0, NULL, 'published', 1, '2026-07-27 15:00:13', '2026-07-27 15:00:37');

-- --------------------------------------------------------

--
-- Table structure for table `course_announcements`
--

CREATE TABLE `course_announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `faculty_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `attachment_url` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE `course_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon_class` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_categories`
--

INSERT INTO `course_categories` (`id`, `name`, `slug`, `description`, `icon_class`) VALUES
(1, 'Search Engine Optimization', 'seo', 'SEO, AEO, GEO and Technical Web Search', NULL),
(2, 'Paid Media Performance', 'paid-media', 'Meta Ads, Google Performance Max and Retargeting', NULL),
(3, 'Programmatic Media Buying', 'programmatic', 'DV360, Open Web, and Supply Side Platforms', NULL),
(4, 'Web Fundamentals for Marketers', 'web-fundamentals', 'HTML, Landing Pages, Analytics and Tracking', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_chapters`
--

CREATE TABLE `course_chapters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_chapters`
--

INSERT INTO `course_chapters` (`id`, `module_id`, `title`, `description`, `sort_order`) VALUES
(1, 1, 'Chapter 1: Understanding Search Engine Indexing & AI Crawlers', 'Technical breakdown of bot indexing and LLM citation retrieval', 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_enrollments`
--

CREATE TABLE `course_enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','completed','suspended','cancelled') NOT NULL DEFAULT 'active',
  `enrolled_at` datetime NOT NULL DEFAULT current_timestamp(),
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_enrollments`
--

INSERT INTO `course_enrollments` (`id`, `user_id`, `course_id`, `status`, `enrolled_at`, `completed_at`) VALUES
(1, 2, 1, 'completed', '2026-07-27 12:53:15', '2026-07-27 13:13:41'),
(2, 3, 3, 'active', '2026-07-27 17:15:49', NULL),
(3, 4, 3, 'active', '2026-07-27 17:19:41', NULL),
(4, 1, 3, 'active', '2026-07-27 17:26:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_instructors`
--

CREATE TABLE `course_instructors` (
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('primary','co_instructor','ta') NOT NULL DEFAULT 'primary'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_instructors`
--

INSERT INTO `course_instructors` (`course_id`, `user_id`, `role`) VALUES
(1, 1, 'primary');

-- --------------------------------------------------------

--
-- Table structure for table `course_lessons`
--

CREATE TABLE `course_lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chapter_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `content_type` enum('video','pdf','text','audio') NOT NULL DEFAULT 'video',
  `video_url` varchar(255) DEFAULT NULL,
  `duration_minutes` int(11) NOT NULL DEFAULT 15,
  `summary_text` longtext DEFAULT NULL,
  `transcript` longtext DEFAULT NULL,
  `is_preview` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_lessons`
--

INSERT INTO `course_lessons` (`id`, `chapter_id`, `title`, `slug`, `content_type`, `video_url`, `duration_minutes`, `summary_text`, `transcript`, `is_preview`, `sort_order`) VALUES
(1, 1, 'Lesson 1.1: Technical SEO Fundamentals & Site Crawlability', 'lesson-1-1-technical-seo', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 18, 'Introduction to crawl budgets, robots.txt, and sitemaps.', NULL, 1, 1),
(2, 1, 'Lesson 1.2: Structuring Content for ChatGPT & AI Overviews', 'lesson-1-2-ai-overviews', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 22, 'How to format text data so LLMs extract it for direct search answers.', NULL, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `course_modules`
--

CREATE TABLE `course_modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_modules`
--

INSERT INTO `course_modules` (`id`, `course_id`, `title`, `description`, `sort_order`) VALUES
(1, 1, 'Module I: Search & AI Answer Engine Architecture', 'Foundations of traditional SEO and modern AI Generative Engine Optimization', 1);

-- --------------------------------------------------------

--
-- Table structure for table `demo_classes`
--

CREATE TABLE `demo_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `faculty_id` bigint(20) UNSIGNED NOT NULL,
  `scheduled_at` datetime NOT NULL,
  `meeting_link` varchar(255) DEFAULT NULL,
  `attendance_status` enum('scheduled','attended','absent','rescheduled') NOT NULL DEFAULT 'scheduled',
  `feedback_notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employers`
--

CREATE TABLE `employers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `industry` varchar(100) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `contact_person` varchar(100) NOT NULL,
  `contact_email` varchar(150) NOT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employers`
--

INSERT INTO `employers` (`id`, `company_name`, `industry`, `website`, `logo_url`, `contact_person`, `contact_email`, `contact_phone`, `created_at`) VALUES
(1, 'Swiggy Performance Marketing', 'E-Commerce / FoodTech', 'https://swiggy.com', NULL, 'Ananya Roy', 'careers@swiggy.in', NULL, '2026-07-27 14:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `type` enum('workshop','webinar','masterclass') NOT NULL DEFAULT 'webinar',
  `description` longtext NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `event_date` datetime NOT NULL,
  `duration_minutes` int(11) NOT NULL DEFAULT 90,
  `meeting_link` varchar(255) DEFAULT NULL,
  `registration_limit` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_speakers`
--

CREATE TABLE `event_speakers` (
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_profiles`
--

CREATE TABLE `faculty_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `biography` text NOT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faculty_profiles`
--

INSERT INTO `faculty_profiles` (`id`, `user_id`, `name`, `designation`, `photo_url`, `biography`, `skills`, `social_links`, `is_featured`, `sort_order`) VALUES
(1, NULL, 'Manu Sharma', 'Lead Performance Marketing Instructor', NULL, 'Performance Marketing Lead with 6+ years managing multi-million budgets across Fintech, E-Commerce, and EdTech.', 'Meta Ads, Google Ads, Programmatic, SEO', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'General',
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `category`, `question`, `answer`, `sort_order`, `is_active`) VALUES
(1, 'General', 'What makes Tyche different from other digital marketing institutes?', 'Tyche focuses on live cohort practice led by working industry practitioners with real campaign budget case studies.', 1, 1),
(2, 'Admissions', 'What is the duration of the full bundle course?', 'The Full Bundle course runs for 3 months with 3 live sessions per week.', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fee_plans`
--

CREATE TABLE `fee_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admission_id` bigint(20) UNSIGNED NOT NULL,
  `installment_number` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `amount_due` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','partially_paid','paid','overdue') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_plans`
--

INSERT INTO `fee_plans` (`id`, `admission_id`, `installment_number`, `amount_due`, `due_date`, `amount_paid`, `status`) VALUES
(1, 1, 1, 3000.00, '2026-07-27', 3000.00, 'paid'),
(2, 1, 2, 3000.00, '2026-08-26', 0.00, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `form_submissions`
--

CREATE TABLE `form_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_type` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `status` enum('new','processed','archived') NOT NULL DEFAULT 'new',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_submissions`
--

INSERT INTO `form_submissions` (`id`, `form_type`, `name`, `email`, `phone`, `message`, `metadata`, `status`, `created_at`) VALUES
(1, 'contact', 'Jane Tester', 'jane@example.com', NULL, 'I would like to inquire about live cohorts.', '{\"ip\":\"127.0.0.1\",\"user_agent\":\"Unit Test\",\"submitted_at\":\"2026-07-27 12:33:10\"}', 'new', '2026-07-27 12:33:10'),
(2, 'contact', 'Jane Tester', 'jane@example.com', NULL, 'I would like to inquire about live cohorts.', '{\"ip\":\"127.0.0.1\",\"user_agent\":\"Unit Test\",\"submitted_at\":\"2026-07-27 12:33:19\"}', 'new', '2026-07-27 12:33:19'),
(3, 'course_enquiry', 'Anonymous', 'manu@xtech.com', NULL, NULL, '{\"ip\":\"::1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/150.0.0.0 Safari\\/537.36 Edg\\/150.0.0.0\",\"submitted_at\":\"2026-07-27 15:52:18\",\"learning_tier\":\"live_cohort\"}', 'new', '2026-07-27 15:52:19'),
(4, 'course_landing_page', 'Anonymous', 'manu@xtech.com', NULL, NULL, '{\"ip\":\"::1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/150.0.0.0 Safari\\/537.36 Edg\\/150.0.0.0\",\"submitted_at\":\"2026-07-27 15:59:28\",\"learning_tier\":\"live_cohort\"}', 'new', '2026-07-27 15:59:28'),
(5, 'course_landing_page', 'Anonymous', 'manu@xtech.com', NULL, NULL, '{\"ip\":\"::1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/150.0.0.0 Safari\\/537.36 Edg\\/150.0.0.0\",\"submitted_at\":\"2026-07-27 17:13:53\",\"learning_tier\":\"live_cohort\"}', 'new', '2026-07-27 17:13:53'),
(6, 'course_landing_page', 'Anonymous', 'manu@xtech.com', NULL, NULL, '{\"ip\":\"::1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/150.0.0.0 Safari\\/537.36 Edg\\/150.0.0.0\",\"submitted_at\":\"2026-07-27 17:14:13\",\"learning_tier\":\"live_cohort\"}', 'new', '2026-07-27 17:14:13'),
(7, 'course_landing_page', 'Anonymous', 'vishal@xtech.in', NULL, NULL, '{\"ip\":\"::1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/150.0.0.0 Safari\\/537.36 Edg\\/150.0.0.0\",\"submitted_at\":\"2026-07-29 14:20:48\",\"learning_tier\":\"live_cohort\"}', 'new', '2026-07-29 14:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_albums`
--

CREATE TABLE `gallery_albums` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_items`
--

CREATE TABLE `gallery_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `album_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `media_url` varchar(255) NOT NULL,
  `type` enum('image','video') NOT NULL DEFAULT 'image',
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homepage_sections`
--

CREATE TABLE `homepage_sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `section_key` varchar(50) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internal_messages`
--

CREATE TABLE `internal_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `recipient_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `cgst_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sgst_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `pdf_path` varchar(255) DEFAULT NULL,
  `issued_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `payment_id`, `user_id`, `subtotal`, `cgst_amount`, `sgst_amount`, `total_amount`, `pdf_path`, `issued_at`) VALUES
(1, 'TYCHE-INV-2026-0089', 1, 2, 2542.37, 228.81, 228.81, 3000.00, NULL, '2026-07-27 13:21:27'),
(2, 'TYCHE-INV-2026-4B6FDB', 1, 2, 2542.37, 228.82, 228.82, 3000.00, NULL, '2026-07-27 13:23:05'),
(3, 'TYCHE-INV-2026-2F2634', 1, 2, 2542.37, 228.82, 228.81, 3000.00, NULL, '2026-07-27 13:23:16'),
(4, 'TYCHE-INV-2026-2514D3', 2, 2, 2542.37, 228.82, 228.81, 3000.00, NULL, '2026-07-27 15:58:49'),
(5, 'TYCHE-INV-2026-D359D7', 3, 4, 21186.44, 1906.78, 1906.78, 25000.00, NULL, '2026-07-27 13:49:41'),
(6, 'TYCHE-INV-2026-2F1227', 4, 1, 21186.44, 1906.78, 1906.78, 25000.00, NULL, '2026-07-27 17:26:50'),
(7, 'TYCHE-INV-2026-472794', 5, 10, 25000.00, 2250.00, 2250.00, 29500.00, NULL, '2026-07-29 07:08:31'),
(8, 'TYCHE-INV-2026-085288', 7, 12, 25000.00, 2250.00, 2250.00, 29500.00, NULL, '2026-07-29 07:08:50'),
(9, 'TYCHE-INV-2026-062316', 8, 13, 25000.00, 2250.00, 2250.00, 29500.00, NULL, '2026-07-29 07:09:17'),
(10, 'TYCHE-INV-2026-235592', 9, 14, 25000.00, 2250.00, 2250.00, 29500.00, NULL, '2026-07-29 07:12:16'),
(11, 'TYCHE-INV-2026-901775', 10, 15, 25000.00, 2250.00, 2250.00, 29500.00, NULL, '2026-07-29 07:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('applied','shortlisted','interview_scheduled','rejected','offered','joined') NOT NULL DEFAULT 'applied',
  `cover_note` text DEFAULT NULL,
  `applied_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `job_id`, `user_id`, `status`, `cover_note`, `applied_at`) VALUES
(1, 1, 2, 'joined', 'Applying for Technical SEO role.', '2026-07-27 14:03:27');

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `type` enum('full_time','part_time','internship','freelance','remote') NOT NULL DEFAULT 'full_time',
  `location` varchar(100) NOT NULL DEFAULT 'Bangalore',
  `salary_range` varchar(50) DEFAULT NULL,
  `description` longtext NOT NULL,
  `requirements` text NOT NULL,
  `deadline` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `employer_id`, `title`, `slug`, `type`, `location`, `salary_range`, `description`, `requirements`, `deadline`, `is_active`, `created_at`) VALUES
(1, 1, 'Senior Technical SEO Specialist', 'senior-technical-seo-specialist', 'full_time', 'Bangalore', '₹8 - ₹12 LPA', 'Lead technical SEO audits, site speed optimization, and AI Overview citation strategies.', 'Minimum 2 years experience with schema JSON-LD, Core Web Vitals, and search logs.', '2026-08-26', 1, '2026-07-27 14:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_code` varchar(50) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `source` enum('website_form','landing_page','meta_ads','google_ads','whatsapp','phone_call','walk_in','referral','manual') NOT NULL DEFAULT 'website_form',
  `counselor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `priority` enum('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
  `status` enum('new','contacted','qualified','nurturing','application_sent','payment_link_generated','payment_received','enrolled','lost') DEFAULT 'new',
  `lost_reason` enum('no_response','not_interested','budget_issue','joined_elsewhere','course_mismatch','other') DEFAULT NULL,
  `lost_notes` text DEFAULT NULL,
  `lead_score` int(10) UNSIGNED NOT NULL DEFAULT 10,
  `sla_due_at` datetime DEFAULT NULL,
  `is_sla_breached` tinyint(1) NOT NULL DEFAULT 0,
  `last_interaction_at` datetime DEFAULT NULL,
  `reactivated_at` datetime DEFAULT NULL,
  `expected_admission_date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `lead_code`, `first_name`, `last_name`, `email`, `phone`, `course_id`, `batch_id`, `source`, `counselor_id`, `priority`, `status`, `lost_reason`, `lost_notes`, `lead_score`, `sla_due_at`, `is_sla_breached`, `last_interaction_at`, `reactivated_at`, `expected_admission_date`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'LEAD-2026-X812', 'Rahul', 'Sharma', 'rahul@example.com', '+919876543210', 1, 1, 'website_form', NULL, 'high', 'payment_link_generated', NULL, NULL, 85, NULL, 0, NULL, NULL, NULL, NULL, '2026-07-27 13:21:27', '2026-07-29 07:07:59'),
(2, 'LEAD-2026-F49DE4', 'Vikram', 'Aditya', 'vikram@example.com', '+919988776655', NULL, NULL, 'meta_ads', NULL, 'medium', '', NULL, NULL, 30, NULL, 0, NULL, NULL, NULL, NULL, '2026-07-27 13:23:05', '2026-07-27 13:23:05'),
(3, 'LEAD-2026-B3DE4A', 'Vikram', 'Aditya', 'vikram@example.com', '+919988776655', NULL, NULL, 'meta_ads', NULL, 'medium', '', NULL, NULL, 30, NULL, 0, NULL, NULL, NULL, NULL, '2026-07-27 13:23:16', '2026-07-27 13:23:16'),
(4, 'LEAD-2026-364A6E', 'Inquiry', '', 'manu@xtech.com', '+919999999999', NULL, NULL, 'landing_page', NULL, 'high', 'enrolled', NULL, NULL, 100, NULL, 0, NULL, NULL, NULL, NULL, '2026-07-27 15:52:19', '2026-07-27 17:38:37'),
(5, 'LEAD-2026-D619F8', 'Inquiry', '', 'manu@xtech.com', '+919999999999', NULL, NULL, 'landing_page', NULL, 'high', 'enrolled', NULL, NULL, 100, NULL, 0, NULL, NULL, NULL, NULL, '2026-07-27 15:59:28', '2026-07-27 17:38:48'),
(6, 'LEAD-2026-0C06EE', 'Inquiry', '', 'manu@xtech.com', '+919999999999', NULL, NULL, 'landing_page', NULL, 'high', 'enrolled', NULL, NULL, 100, NULL, 0, NULL, NULL, NULL, NULL, '2026-07-27 17:13:53', '2026-07-27 17:38:46'),
(7, 'LEAD-2026-113439', 'Inquiry', '', 'manu@xtech.com', '+919999999999', NULL, NULL, 'landing_page', NULL, 'high', 'enrolled', NULL, NULL, 100, NULL, 0, '2026-07-29 14:20:48', NULL, NULL, NULL, '2026-07-27 17:14:13', '2026-07-29 14:20:48'),
(8, 'LEAD-2026-637588', 'Vikram', 'Aditya', 'crm_test_522@example.com', '9876544954', 1, 1, 'google_ads', 1, 'medium', 'payment_link_generated', NULL, NULL, 0, '2026-07-29 09:06:31', 0, '2026-07-29 07:06:31', '2026-07-29 07:06:31', NULL, NULL, '2026-07-29 07:06:31', '2026-07-29 07:06:31'),
(9, 'LEAD-2026-421C21', 'Vikram', 'Aditya', 'crm_test_424@example.com', '9876515419', 1, 1, 'google_ads', 1, 'medium', 'payment_link_generated', NULL, NULL, 0, '2026-07-29 09:06:41', 0, '2026-07-29 07:06:41', '2026-07-29 07:06:41', NULL, NULL, '2026-07-29 07:06:41', '2026-07-29 07:06:41'),
(10, 'LEAD-2026-1B350D', 'Vikram', 'Aditya', 'crm_test_204@example.com', '9876583680', 1, 1, 'google_ads', 1, 'medium', 'payment_link_generated', NULL, NULL, 0, '2026-07-29 09:06:52', 0, '2026-07-29 07:06:52', '2026-07-29 07:06:52', NULL, NULL, '2026-07-29 07:06:52', '2026-07-29 07:06:52'),
(11, 'LEAD-2026-CFB996', 'Vikram', 'Aditya', 'crm_test_588@example.com', '9876590806', 1, 1, 'google_ads', 1, 'medium', 'payment_link_generated', NULL, NULL, 0, '2026-07-29 09:07:13', 0, '2026-07-29 07:07:13', '2026-07-29 07:07:13', NULL, NULL, '2026-07-29 07:07:13', '2026-07-29 07:07:13'),
(12, 'LEAD-2026-076FB9', 'Vikram', 'Aditya', 'crm_test_875@example.com', '9876528844', 1, 1, 'google_ads', 1, 'medium', 'payment_link_generated', NULL, NULL, 0, '2026-07-29 09:07:42', 0, '2026-07-29 07:07:42', '2026-07-29 07:07:42', NULL, NULL, '2026-07-29 07:07:42', '2026-07-29 07:07:42'),
(13, 'LEAD-2026-0C86F7', 'Vikram', 'Aditya', 'crm_test_770@example.com', '9876526799', 1, 1, 'google_ads', 1, 'medium', 'enrolled', NULL, NULL, 100, '2026-07-29 09:08:30', 0, '2026-07-29 07:08:30', '2026-07-29 07:08:31', NULL, NULL, '2026-07-29 07:08:30', '2026-07-29 07:08:31'),
(14, 'LEAD-2026-ABCBD6', 'Vikram', 'Aditya', 'crm_test_781@example.com', '9876549987', 1, 1, 'google_ads', 1, 'medium', 'payment_link_generated', NULL, NULL, 0, '2026-07-29 09:08:39', 0, '2026-07-29 07:08:39', '2026-07-29 07:08:39', NULL, NULL, '2026-07-29 07:08:39', '2026-07-29 12:04:14'),
(15, 'LEAD-2026-65F631', 'Vikram', 'Aditya', 'crm_test_173@example.com', '9876523791', 1, 1, 'google_ads', 1, 'medium', 'enrolled', NULL, NULL, 100, '2026-07-29 09:08:49', 0, '2026-07-29 07:08:49', '2026-07-29 07:08:49', NULL, NULL, '2026-07-29 07:08:49', '2026-07-29 07:08:50'),
(16, 'LEAD-2026-670CDC', 'Vikram', 'Aditya', 'crm_test_364@example.com', '9876582852', 1, 1, 'google_ads', 1, 'medium', 'enrolled', NULL, NULL, 100, '2026-07-29 09:09:17', 0, '2026-07-29 07:09:17', '2026-07-29 07:09:17', NULL, NULL, '2026-07-29 07:09:17', '2026-07-29 07:09:17'),
(17, 'LEAD-2026-ED29B6', 'Vikram', 'Aditya', 'crm_test_776@example.com', '9876521655', 1, 1, 'google_ads', 1, 'medium', 'enrolled', NULL, NULL, 100, '2026-07-29 09:12:15', 0, '2026-07-29 07:12:15', '2026-07-29 07:12:15', NULL, NULL, '2026-07-29 07:12:15', '2026-07-29 07:12:16'),
(18, 'LEAD-2026-3FEB14', 'Vikram', 'Aditya', 'crm_test_551@example.com', '9876599076', 1, 1, 'google_ads', 1, 'medium', 'enrolled', NULL, NULL, 100, '2026-07-29 09:14:18', 0, '2026-07-29 07:14:18', '2026-07-29 07:14:18', NULL, NULL, '2026-07-29 07:14:18', '2026-07-29 07:14:18'),
(19, 'LEAD-2026-C12687', 'Sujit', 'Kumar', 'sujit@xyz.com', '2345678901', 3, NULL, 'website_form', 1, 'medium', 'contacted', NULL, NULL, 25, '2026-07-29 14:49:23', 0, '2026-07-29 12:59:16', NULL, NULL, NULL, '2026-07-29 12:49:23', '2026-07-29 12:59:16');

-- --------------------------------------------------------

--
-- Table structure for table `lead_activities`
--

CREATE TABLE `lead_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('call','whatsapp','email','note','stage_change','payment_link','import','duplicate_hit') NOT NULL,
  `outcome` enum('connected','rnr','switched_off','busy','sent','delivered','read','replied','converted','lost','reactivated','duplicate_recorded') DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `duration_seconds` int(11) DEFAULT NULL,
  `metadata_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata_json`)),
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lead_activities`
--

INSERT INTO `lead_activities` (`id`, `lead_id`, `user_id`, `type`, `outcome`, `notes`, `duration_seconds`, `metadata_json`, `created_at`) VALUES
(1, 8, NULL, 'note', 'sent', 'Lead captured via [google_ads]. SLA Deadline set to 09:06', NULL, NULL, '2026-07-29 07:06:31'),
(2, 8, NULL, 'duplicate_hit', 'duplicate_recorded', 'Duplicate inquiry captured via [meta_ads]. Lead Score bumped (+5).', NULL, NULL, '2026-07-29 07:06:31'),
(3, 8, 1, 'stage_change', 'lost', 'Stage updated from \'new\' to \'lost\'. Reason: BUDGET ISSUE. Notes: Fee high for live cohort, requested discount', NULL, NULL, '2026-07-29 07:06:31'),
(4, 8, 1, 'stage_change', 'reactivated', 'Lead reactivated from Lost status. Moved to \'Contacted\' stage for fresh follow-up.', NULL, NULL, '2026-07-29 07:06:31'),
(5, 8, 1, 'payment_link', 'sent', 'Generated 18% GST Payment Link of ₹29,500.00 for Course ID 1. Code: PAYLINK-20260729-479868B5', NULL, NULL, '2026-07-29 07:06:31'),
(6, 9, NULL, 'note', 'sent', 'Lead captured via [google_ads]. SLA Deadline set to 09:06', NULL, NULL, '2026-07-29 07:06:41'),
(7, 9, NULL, 'duplicate_hit', 'duplicate_recorded', 'Duplicate inquiry captured via [meta_ads]. Lead Score bumped (+5).', NULL, NULL, '2026-07-29 07:06:41'),
(8, 9, 1, 'stage_change', 'lost', 'Stage updated from \'new\' to \'lost\'. Reason: BUDGET ISSUE. Notes: Fee high for live cohort, requested discount', NULL, NULL, '2026-07-29 07:06:41'),
(9, 9, 1, 'stage_change', 'reactivated', 'Lead reactivated from Lost status. Moved to \'Contacted\' stage for fresh follow-up.', NULL, NULL, '2026-07-29 07:06:41'),
(10, 9, 1, 'payment_link', 'sent', 'Generated 18% GST Payment Link of ₹29,500.00 for Course ID 1. Code: PAYLINK-20260729-FF4F80B5', NULL, NULL, '2026-07-29 07:06:41'),
(11, 10, NULL, 'note', 'sent', 'Lead captured via [google_ads]. SLA Deadline set to 09:06', NULL, NULL, '2026-07-29 07:06:52'),
(12, 10, NULL, 'duplicate_hit', 'duplicate_recorded', 'Duplicate inquiry captured via [meta_ads]. Lead Score bumped (+5).', NULL, NULL, '2026-07-29 07:06:52'),
(13, 10, 1, 'stage_change', 'lost', 'Stage updated from \'new\' to \'lost\'. Reason: BUDGET ISSUE. Notes: Fee high for live cohort, requested discount', NULL, NULL, '2026-07-29 07:06:52'),
(14, 10, 1, 'stage_change', 'reactivated', 'Lead reactivated from Lost status. Moved to \'Contacted\' stage for fresh follow-up.', NULL, NULL, '2026-07-29 07:06:52'),
(15, 10, 1, 'payment_link', 'sent', 'Generated 18% GST Payment Link of ₹29,500.00 for Course ID 1. Code: PAYLINK-20260729-735F64B1', NULL, NULL, '2026-07-29 07:06:52'),
(16, 11, NULL, 'note', 'sent', 'Lead captured via [google_ads]. SLA Deadline set to 09:07', NULL, NULL, '2026-07-29 07:07:13'),
(17, 11, NULL, 'duplicate_hit', 'duplicate_recorded', 'Duplicate inquiry captured via [meta_ads]. Lead Score bumped (+5).', NULL, NULL, '2026-07-29 07:07:13'),
(18, 11, 1, 'stage_change', 'lost', 'Stage updated from \'new\' to \'lost\'. Reason: BUDGET ISSUE. Notes: Fee high for live cohort, requested discount', NULL, NULL, '2026-07-29 07:07:13'),
(19, 11, 1, 'stage_change', 'reactivated', 'Lead reactivated from Lost status. Moved to \'Contacted\' stage for fresh follow-up.', NULL, NULL, '2026-07-29 07:07:13'),
(20, 11, 1, 'payment_link', 'sent', 'Generated 18% GST Payment Link of ₹29,500.00 for Course ID 1. Code: PAYLINK-20260729-F211EC2C', NULL, NULL, '2026-07-29 07:07:13'),
(21, 12, NULL, 'note', 'sent', 'Lead captured via [google_ads]. SLA Deadline set to 09:07', NULL, NULL, '2026-07-29 07:07:42'),
(22, 12, NULL, 'duplicate_hit', 'duplicate_recorded', 'Duplicate inquiry captured via [meta_ads]. Lead Score bumped (+5).', NULL, NULL, '2026-07-29 07:07:42'),
(23, 12, 1, 'stage_change', 'lost', 'Stage updated from \'new\' to \'lost\'. Reason: BUDGET ISSUE. Notes: Fee high for live cohort, requested discount', NULL, NULL, '2026-07-29 07:07:42'),
(24, 12, 1, 'stage_change', 'reactivated', 'Lead reactivated from Lost status. Moved to \'Contacted\' stage for fresh follow-up.', NULL, NULL, '2026-07-29 07:07:42'),
(25, 12, 1, 'payment_link', 'sent', 'Generated 18% GST Payment Link of ₹29,500.00 for Course ID 1. Code: PAYLINK-20260729-B561B237', NULL, NULL, '2026-07-29 07:07:42'),
(26, 1, 1, 'payment_link', 'sent', 'Generated 18% GST Payment Link of ₹29,500.00 for Course ID 1. Code: PAYLINK-20260729-AB113BFB', NULL, NULL, '2026-07-29 07:07:59'),
(27, 13, NULL, 'note', 'sent', 'Lead captured via [google_ads]. SLA Deadline set to 09:08', NULL, NULL, '2026-07-29 07:08:30'),
(28, 13, NULL, 'duplicate_hit', 'duplicate_recorded', 'Duplicate inquiry captured via [meta_ads]. Lead Score bumped (+5).', NULL, NULL, '2026-07-29 07:08:30'),
(29, 13, 1, 'stage_change', 'lost', 'Stage updated from \'new\' to \'lost\'. Reason: BUDGET ISSUE. Notes: Fee high for live cohort, requested discount', NULL, NULL, '2026-07-29 07:08:31'),
(30, 13, 1, 'stage_change', 'reactivated', 'Lead reactivated from Lost status. Moved to \'Contacted\' stage for fresh follow-up.', NULL, NULL, '2026-07-29 07:08:31'),
(31, 13, 1, 'payment_link', 'sent', 'Generated 18% GST Payment Link of ₹29,500.00 for Course ID 1. Code: PAYLINK-20260729-5A2BBB49', NULL, NULL, '2026-07-29 07:08:31'),
(32, 13, NULL, 'stage_change', 'converted', 'Payment of ₹29,500.00 received successfully. Lead status updated to ENROLLED. Student ID #10 created.', NULL, NULL, '2026-07-29 07:08:31'),
(33, 14, NULL, 'note', 'sent', 'Lead captured via [google_ads]. SLA Deadline set to 09:08', NULL, NULL, '2026-07-29 07:08:39'),
(34, 14, NULL, 'duplicate_hit', 'duplicate_recorded', 'Duplicate inquiry captured via [meta_ads]. Lead Score bumped (+5).', NULL, NULL, '2026-07-29 07:08:39'),
(35, 14, 1, 'stage_change', 'lost', 'Stage updated from \'new\' to \'lost\'. Reason: BUDGET ISSUE. Notes: Fee high for live cohort, requested discount', NULL, NULL, '2026-07-29 07:08:39'),
(36, 14, 1, 'stage_change', 'reactivated', 'Lead reactivated from Lost status. Moved to \'Contacted\' stage for fresh follow-up.', NULL, NULL, '2026-07-29 07:08:39'),
(37, 14, 1, 'payment_link', 'sent', 'Generated 18% GST Payment Link of ₹29,500.00 for Course ID 1. Code: PAYLINK-20260729-F1B7D0E9', NULL, NULL, '2026-07-29 07:08:39'),
(38, 15, NULL, 'note', 'sent', 'Lead captured via [google_ads]. SLA Deadline set to 09:08', NULL, NULL, '2026-07-29 07:08:49'),
(39, 15, NULL, 'duplicate_hit', 'duplicate_recorded', 'Duplicate inquiry captured via [meta_ads]. Lead Score bumped (+5).', NULL, NULL, '2026-07-29 07:08:49'),
(40, 15, 1, 'stage_change', 'lost', 'Stage updated from \'new\' to \'lost\'. Reason: BUDGET ISSUE. Notes: Fee high for live cohort, requested discount', NULL, NULL, '2026-07-29 07:08:49'),
(41, 15, 1, 'stage_change', 'reactivated', 'Lead reactivated from Lost status. Moved to \'Contacted\' stage for fresh follow-up.', NULL, NULL, '2026-07-29 07:08:49'),
(42, 15, 1, 'payment_link', 'sent', 'Generated 18% GST Payment Link of ₹29,500.00 for Course ID 1. Code: PAYLINK-20260729-AA375F5D', NULL, NULL, '2026-07-29 07:08:49'),
(43, 15, NULL, 'stage_change', 'converted', 'Payment of ₹29,500.00 received successfully. Lead status updated to ENROLLED. Student ID #12 created.', NULL, NULL, '2026-07-29 07:08:50'),
(44, 16, NULL, 'note', 'sent', 'Lead captured via [google_ads]. SLA Deadline set to 09:09', NULL, NULL, '2026-07-29 07:09:17'),
(45, 16, NULL, 'duplicate_hit', 'duplicate_recorded', 'Duplicate inquiry captured via [meta_ads]. Lead Score bumped (+5).', NULL, NULL, '2026-07-29 07:09:17'),
(46, 16, 1, 'stage_change', 'lost', 'Stage updated from \'new\' to \'lost\'. Reason: BUDGET ISSUE. Notes: Fee high for live cohort, requested discount', NULL, NULL, '2026-07-29 07:09:17'),
(47, 16, 1, 'stage_change', 'reactivated', 'Lead reactivated from Lost status. Moved to \'Contacted\' stage for fresh follow-up.', NULL, NULL, '2026-07-29 07:09:17'),
(48, 16, 1, 'payment_link', 'sent', 'Generated 18% GST Payment Link of ₹29,500.00 for Course ID 1. Code: PAYLINK-20260729-985E1455', NULL, NULL, '2026-07-29 07:09:17'),
(49, 16, NULL, 'stage_change', 'converted', 'Payment of ₹29,500.00 received successfully. Lead status updated to ENROLLED. Student ID #13 created.', NULL, NULL, '2026-07-29 07:09:17'),
(50, 17, NULL, 'note', 'sent', 'Lead captured via [google_ads]. SLA Deadline set to 09:12', NULL, NULL, '2026-07-29 07:12:15'),
(51, 17, NULL, 'duplicate_hit', 'duplicate_recorded', 'Duplicate inquiry captured via [meta_ads]. Lead Score bumped (+5).', NULL, NULL, '2026-07-29 07:12:15'),
(52, 17, 1, 'stage_change', 'lost', 'Stage updated from \'new\' to \'lost\'. Reason: BUDGET ISSUE. Notes: Fee high for live cohort, requested discount', NULL, NULL, '2026-07-29 07:12:15'),
(53, 17, 1, 'stage_change', 'reactivated', 'Lead reactivated from Lost status. Moved to \'Contacted\' stage for fresh follow-up.', NULL, NULL, '2026-07-29 07:12:15'),
(54, 17, 1, 'payment_link', 'sent', 'Generated 18% GST Payment Link of ₹29,500.00 for Course ID 1. Code: PAYLINK-20260729-2CBF0ACA', NULL, NULL, '2026-07-29 07:12:15'),
(55, 17, NULL, 'stage_change', 'converted', 'Payment of ₹29,500.00 received successfully. Lead status updated to ENROLLED. Student ID #14 created.', NULL, NULL, '2026-07-29 07:12:16'),
(56, 18, NULL, 'note', 'sent', 'Lead captured via [google_ads]. SLA Deadline set to 09:14', NULL, NULL, '2026-07-29 07:14:18'),
(57, 18, NULL, 'duplicate_hit', 'duplicate_recorded', 'Duplicate inquiry captured via [meta_ads]. Lead Score bumped (+5).', NULL, NULL, '2026-07-29 07:14:18'),
(58, 18, 1, 'stage_change', 'lost', 'Stage updated from \'new\' to \'lost\'. Reason: BUDGET ISSUE. Notes: Fee high for live cohort, requested discount', NULL, NULL, '2026-07-29 07:14:18'),
(59, 18, 1, 'stage_change', 'reactivated', 'Lead reactivated from Lost status. Moved to \'Contacted\' stage for fresh follow-up.', NULL, NULL, '2026-07-29 07:14:18'),
(60, 18, 1, 'payment_link', 'sent', 'Generated 18% GST Payment Link of ₹29,500.00 for Course ID 1. Code: PAYLINK-20260729-AA376E8A', NULL, NULL, '2026-07-29 07:14:18'),
(61, 18, NULL, 'stage_change', 'converted', 'Payment of ₹29,500.00 received successfully. Lead status updated to ENROLLED. Student ID #15 created.', NULL, NULL, '2026-07-29 07:14:18'),
(62, 14, 1, 'payment_link', 'sent', 'Generated 18% GST Payment Link of ₹6,000.00 for Course ID 1. Code: PAYLINK-20260729-4A1BEE4E', NULL, NULL, '2026-07-29 12:04:14'),
(63, 19, NULL, 'note', 'sent', 'Lead captured via [website_form]. SLA Deadline set to 14:49', NULL, NULL, '2026-07-29 12:49:23'),
(64, 19, 1, 'call', 'connected', 'Test follow-up call logged via Counselor Desk.', NULL, NULL, '2026-07-29 09:28:03'),
(65, 19, 1, 'whatsapp', 'connected', 'Broucher Sent', NULL, NULL, '2026-07-29 12:59:16'),
(66, 7, NULL, 'duplicate_hit', 'duplicate_recorded', 'Duplicate inquiry captured via [landing_page]. Lead Score bumped (+5).', NULL, NULL, '2026-07-29 14:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `lead_followups`
--

CREATE TABLE `lead_followups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `counselor_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('call','whatsapp','email','meeting') NOT NULL DEFAULT 'call',
  `notes` text NOT NULL,
  `next_followup_date` datetime DEFAULT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_followups`
--

INSERT INTO `lead_followups` (`id`, `lead_id`, `counselor_id`, `type`, `notes`, `next_followup_date`, `is_completed`, `created_at`) VALUES
(1, 1, 1, 'call', 'Discussed 8-week Technical SEO curriculum. Interested in morning batch.', NULL, 0, '2026-07-27 13:21:27'),
(3, 8, 1, 'call', 'Day 0 Mandatory Initial Outreach: Conduct introduction call & assess course fit.', '2026-07-29 09:06:31', 0, '2026-07-29 07:06:31'),
(4, 9, 1, 'call', 'Day 0 Mandatory Initial Outreach: Conduct introduction call & assess course fit.', '2026-07-29 09:06:41', 0, '2026-07-29 07:06:41'),
(5, 10, 1, 'call', 'Day 0 Mandatory Initial Outreach: Conduct introduction call & assess course fit.', '2026-07-29 09:06:52', 0, '2026-07-29 07:06:52'),
(6, 11, 1, 'call', 'Day 0 Mandatory Initial Outreach: Conduct introduction call & assess course fit.', '2026-07-29 09:07:13', 0, '2026-07-29 07:07:13'),
(7, 12, 1, 'call', 'Day 0 Mandatory Initial Outreach: Conduct introduction call & assess course fit.', '2026-07-29 09:07:42', 0, '2026-07-29 07:07:42'),
(8, 13, 1, 'call', 'Day 0 Mandatory Initial Outreach: Conduct introduction call & assess course fit.', '2026-07-29 09:08:30', 0, '2026-07-29 07:08:30'),
(9, 14, 1, 'call', 'Day 0 Mandatory Initial Outreach: Conduct introduction call & assess course fit.', '2026-07-29 09:08:39', 0, '2026-07-29 07:08:39'),
(10, 15, 1, 'call', 'Day 0 Mandatory Initial Outreach: Conduct introduction call & assess course fit.', '2026-07-29 09:08:49', 0, '2026-07-29 07:08:49'),
(11, 16, 1, 'call', 'Day 0 Mandatory Initial Outreach: Conduct introduction call & assess course fit.', '2026-07-29 09:09:17', 0, '2026-07-29 07:09:17'),
(12, 17, 1, 'call', 'Day 0 Mandatory Initial Outreach: Conduct introduction call & assess course fit.', '2026-07-29 09:12:15', 0, '2026-07-29 07:12:15'),
(13, 18, 1, 'call', 'Day 0 Mandatory Initial Outreach: Conduct introduction call & assess course fit.', '2026-07-29 09:14:18', 0, '2026-07-29 07:14:18'),
(14, 19, 1, 'call', 'Day 0 Mandatory Initial Outreach: Conduct introduction call & assess course fit.', '2026-07-29 14:49:23', 0, '2026-07-29 12:49:23'),
(16, 19, 1, 'call', 'Test follow-up call conducted. Lead interested in AEO & GEO module.', NULL, 1, '2026-07-29 09:28:03'),
(17, 19, 1, 'whatsapp', 'Broucher Sent', NULL, 1, '2026-07-29 12:59:16');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_bookmarks`
--

CREATE TABLE `lesson_bookmarks` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_notes`
--

CREATE TABLE `lesson_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `note_text` text NOT NULL,
  `timestamp_seconds` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_progress`
--

CREATE TABLE `lesson_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `watch_seconds` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` datetime DEFAULT NULL,
  `last_accessed_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lesson_progress`
--

INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `watch_seconds`, `is_completed`, `completed_at`, `last_accessed_at`) VALUES
(1, 2, 1, 900, 1, '2026-07-27 12:55:50', '2026-07-27 13:13:41'),
(3, 2, 2, 900, 1, '2026-07-27 13:13:41', '2026-07-27 13:13:41');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_resources`
--

CREATE TABLE `lesson_resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email_attempted` varchar(150) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `status` enum('success','failed_password','account_locked','user_not_found') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`id`, `user_id`, `email_attempted`, `ip_address`, `user_agent`, `status`, `created_at`) VALUES
(1, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 12:12:34'),
(2, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 12:12:47'),
(3, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 12:12:54'),
(4, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 12:19:38'),
(5, 2, 'student@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 12:21:10'),
(6, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 12:33:09'),
(7, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 12:33:19'),
(8, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 12:35:18'),
(9, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 12:55:42'),
(10, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 12:55:50'),
(11, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 13:13:41'),
(12, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'failed_password', '2026-07-27 13:14:32'),
(13, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 13:15:10'),
(14, 2, 'student@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 13:15:40'),
(15, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 13:16:39'),
(16, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 13:23:05'),
(17, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 13:23:16'),
(18, 2, 'student@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 13:25:47'),
(19, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 13:27:42'),
(20, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 14:03:27'),
(21, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 14:04:22'),
(22, 2, 'student@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 14:07:42'),
(23, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 14:12:27'),
(24, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 14:12:35'),
(25, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 14:17:19'),
(26, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 14:19:32'),
(27, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 14:27:12'),
(28, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 14:38:33'),
(29, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 14:45:20'),
(30, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 14:57:30'),
(31, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 15:03:16'),
(32, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 15:07:23'),
(33, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 15:09:58'),
(34, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 15:23:40'),
(35, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 15:52:40'),
(36, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 17:05:25'),
(37, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 17:09:17'),
(38, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 17:19:12'),
(39, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 17:22:03'),
(40, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 17:24:19'),
(41, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 17:34:17'),
(42, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 17:36:53'),
(43, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 17:55:59'),
(44, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 18:27:23'),
(45, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-27 18:27:55'),
(46, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-27 18:59:49'),
(47, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-28 10:09:07'),
(48, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-28 10:09:41'),
(49, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-28 10:10:14'),
(50, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-28 18:52:35'),
(51, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-29 10:32:40'),
(52, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-29 10:39:22'),
(53, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-29 10:42:21'),
(54, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-29 10:43:21'),
(55, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-29 10:44:25'),
(56, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-29 12:00:45'),
(57, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-29 12:37:11'),
(58, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-29 12:58:08'),
(59, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-29 13:03:22'),
(60, 16, 'pragya@xtech.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-29 13:05:38'),
(61, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-29 13:07:25'),
(62, 1, 'admin@tyche.academy', '127.0.0.1', 'PHPUnit Test', 'success', '2026-07-29 13:13:07'),
(63, 16, 'pragya@xtech.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-29 13:14:06'),
(64, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-29 13:15:11'),
(65, 1, 'admin@tyche.academy', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'success', '2026-07-29 14:18:42');

-- --------------------------------------------------------

--
-- Table structure for table `marketing_campaigns`
--

CREATE TABLE `marketing_campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `channel` enum('email','whatsapp','sms') NOT NULL DEFAULT 'email',
  `subject` varchar(200) DEFAULT NULL,
  `content_template` longtext NOT NULL,
  `target_segment` varchar(100) NOT NULL DEFAULT 'all_leads',
  `status` enum('draft','scheduled','running','completed') NOT NULL DEFAULT 'draft',
  `scheduled_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marketing_campaigns`
--

INSERT INTO `marketing_campaigns` (`id`, `title`, `channel`, `subject`, `content_template`, `target_segment`, `status`, `scheduled_at`, `created_at`) VALUES
(1, 'Q3 SEO Cohort Announcement', 'email', 'Unlock Generative Engine Optimization Skills', 'Dear Marketer, Admissions for our Q3 SEO Cohort are now open...', 'all_leads', 'completed', NULL, '2026-07-27 14:01:39'),
(2, 'test1', 'email', 'xtyc', 'Dear {{Leads name}}', 'all_leads', 'scheduled', '2026-07-27 15:57:54', '2026-07-27 15:57:54');

-- --------------------------------------------------------

--
-- Table structure for table `media_files`
--

CREATE TABLE `media_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `file_size` bigint(20) UNSIGNED NOT NULL,
  `folder` varchar(100) NOT NULL DEFAULT 'uncategorized',
  `tags` varchar(255) DEFAULT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `navigation_menus`
--

CREATE TABLE `navigation_menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `location` enum('header','footer','mobile') NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `target` varchar(20) DEFAULT '_self',
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `navigation_menus`
--

INSERT INTO `navigation_menus` (`id`, `location`, `title`, `url`, `target`, `parent_id`, `sort_order`, `is_active`) VALUES
(1, 'header', 'Curriculum', '/#modules', '_self', NULL, 1, 1),
(2, 'header', 'About Us', '/page/about-us', '_self', NULL, 2, 1),
(3, 'header', 'Placements', '/page/placements', '_self', NULL, 3, 1),
(4, 'footer', 'Privacy Policy', '/page/privacy-policy', '_self', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(150) NOT NULL,
  `status` enum('subscribed','unsubscribed') NOT NULL DEFAULT 'subscribed',
  `subscribed_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `channel` enum('email','sms','whatsapp','in_app') NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `body_template` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `code`, `channel`, `subject`, `body_template`) VALUES
(1, 'ADMISSION_WELCOME', 'email', 'Welcome to Tyche Digital Marketing Academy!', 'Dear {{name}}, Welcome to {{course_name}}! Your admission ID is {{admission_number}}.'),
(2, 'FEE_RECEIPT', 'sms', 'Tyche Academy Fee Receipt', 'Fee payment of Rs {{amount}} received for invoice {{invoice_number}}. Thank you!');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `content` longtext DEFAULT NULL,
  `template` varchar(50) NOT NULL DEFAULT 'default',
  `featured_image` varchar(255) DEFAULT NULL,
  `banner_title` varchar(200) DEFAULT NULL,
  `status` enum('draft','published','scheduled') NOT NULL DEFAULT 'draft',
  `published_at` datetime DEFAULT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `template`, `featured_image`, `banner_title`, `status`, `published_at`, `author_id`, `created_at`, `updated_at`) VALUES
(1, 'About Tyche Academy', 'about-us', '<h2>About Tyche Academy</h2><p>Tyche is an independent Digital Marketing Education platform offering structured, industry-focused live cohorts in SEO, Meta Ads, Programmatic, and Web Fundamentals.</p>', 'default', NULL, NULL, 'published', '2026-07-27 12:30:02', 1, '2026-07-27 12:30:02', '2026-07-27 12:30:02'),
(2, 'Placement & Careers', 'placements', '<h2>Our Career & Placement Assistance</h2><p>We partner with leading tech companies and agencies to provide 100% placement support for our graduates.</p>', 'default', NULL, NULL, 'published', '2026-07-27 12:30:02', 1, '2026-07-27 12:30:02', '2026-07-27 12:30:02'),
(3, 'Privacy Policy', 'privacy-policy', '<h2>Privacy Policy</h2><p>We value your privacy and handle all data securely in compliance with privacy regulations.</p>', 'default', NULL, NULL, 'published', '2026-07-27 12:30:02', 1, '2026-07-27 12:30:02', '2026-07-27 12:30:02');

-- --------------------------------------------------------

--
-- Table structure for table `page_revisions`
--

CREATE TABLE `page_revisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` longtext DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(150) NOT NULL,
  `token_hash` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_reference` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admission_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fee_plan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `gateway` enum('razorpay','cashfree','stripe','upi','bank_transfer','cash','cheque') NOT NULL DEFAULT 'razorpay',
  `transaction_id` varchar(150) DEFAULT NULL,
  `status` enum('pending','completed','failed','refunded') NOT NULL DEFAULT 'completed',
  `payment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_reference`, `user_id`, `course_id`, `admission_id`, `fee_plan_id`, `amount`, `gateway`, `transaction_id`, `status`, `payment_date`) VALUES
(1, 'PAY-2026-X771', NULL, NULL, 1, 1, 3000.00, 'razorpay', 'pay_N839219321', 'completed', '2026-07-27 13:21:27'),
(2, 'PAY-2026-72E418', NULL, NULL, 1, NULL, 3000.00, 'razorpay', '', 'completed', '2026-07-27 15:58:49'),
(3, 'PAY_F4889A0DE8', 4, 3, NULL, NULL, 25000.00, 'upi', 'TXN_91984C907C', 'completed', '2026-07-27 13:49:41'),
(4, 'PAY_27D96410BD', 1, 3, NULL, NULL, 25000.00, 'bank_transfer', 'TXN_9C903E086C', 'completed', '2026-07-27 17:26:50'),
(5, 'PAYREF-TEST-9988', 10, 1, NULL, NULL, 29500.00, 'razorpay', 'TXN-20260729070831-2276', 'completed', '2026-07-29 07:08:31'),
(7, 'PAYREF-TEST-63193', 12, 1, NULL, NULL, 29500.00, 'razorpay', 'TXN-20260729070850-8659', 'completed', '2026-07-29 07:08:50'),
(8, 'PAYREF-TEST-53735', 13, 1, NULL, NULL, 29500.00, 'razorpay', 'TXN-20260729070917-7305', 'completed', '2026-07-29 07:09:17'),
(9, 'PAYREF-TEST-65695', 14, 1, NULL, NULL, 29500.00, 'razorpay', 'TXN-20260729071216-6416', 'completed', '2026-07-29 07:12:16'),
(10, 'PAYREF-TEST-76796', 15, 1, NULL, NULL, 29500.00, 'razorpay', 'TXN-20260729071418-3450', 'completed', '2026-07-29 07:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `payment_links`
--

CREATE TABLE `payment_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `link_code` varchar(100) NOT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `gateway` enum('razorpay','cashfree','payu','stripe','upi') DEFAULT 'razorpay',
  `gateway_link_id` varchar(150) DEFAULT NULL,
  `payment_url` varchar(255) DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `status` enum('active','paid','expired','failed') DEFAULT 'active',
  `paid_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_links`
--

INSERT INTO `payment_links` (`id`, `link_code`, `lead_id`, `course_id`, `batch_id`, `amount`, `gateway`, `gateway_link_id`, `payment_url`, `expires_at`, `status`, `paid_at`, `created_at`) VALUES
(1, 'PAYLINK-20260729-479868B5', 8, 1, 1, 29500.00, 'razorpay', NULL, 'http://localhost/tyche/pay/PAYLINK-20260729-479868B5', '2026-08-05 07:06:31', 'paid', '2026-07-29 07:06:31', '2026-07-29 07:06:31'),
(2, 'PAYLINK-20260729-FF4F80B5', 9, 1, 1, 29500.00, 'razorpay', NULL, 'http://localhost/tyche/pay/PAYLINK-20260729-FF4F80B5', '2026-08-05 07:06:41', 'paid', '2026-07-29 07:06:41', '2026-07-29 07:06:41'),
(3, 'PAYLINK-20260729-735F64B1', 10, 1, 1, 29500.00, 'razorpay', NULL, 'http://localhost/tyche/pay/PAYLINK-20260729-735F64B1', '2026-08-05 07:06:52', 'paid', '2026-07-29 07:06:52', '2026-07-29 07:06:52'),
(4, 'PAYLINK-20260729-F211EC2C', 11, 1, 1, 29500.00, 'razorpay', NULL, 'http://localhost/tyche/pay/PAYLINK-20260729-F211EC2C', '2026-08-05 07:07:13', 'paid', '2026-07-29 07:07:13', '2026-07-29 07:07:13'),
(5, 'PAYLINK-20260729-B561B237', 12, 1, 1, 29500.00, 'razorpay', NULL, 'http://localhost/tyche/pay/PAYLINK-20260729-B561B237', '2026-08-05 07:07:42', 'paid', '2026-07-29 07:07:42', '2026-07-29 07:07:42'),
(6, 'PAYLINK-20260729-AB113BFB', 1, 1, 1, 29500.00, 'razorpay', NULL, 'http://localhost/tyche/pay/PAYLINK-20260729-AB113BFB', '2026-08-05 07:07:59', 'paid', '2026-07-29 07:07:59', '2026-07-29 07:07:59'),
(7, 'PAYLINK-20260729-5A2BBB49', 13, 1, 1, 29500.00, 'razorpay', NULL, 'http://localhost/tyche/pay/PAYLINK-20260729-5A2BBB49', '2026-08-05 07:08:31', 'paid', '2026-07-29 07:08:31', '2026-07-29 07:08:31'),
(8, 'PAYLINK-20260729-F1B7D0E9', 14, 1, 1, 29500.00, 'razorpay', NULL, 'http://localhost/tyche/pay/PAYLINK-20260729-F1B7D0E9', '2026-08-05 07:08:39', 'paid', '2026-07-29 07:08:39', '2026-07-29 07:08:39'),
(9, 'PAYLINK-20260729-AA375F5D', 15, 1, 1, 29500.00, 'razorpay', NULL, 'http://localhost/tyche/pay/PAYLINK-20260729-AA375F5D', '2026-08-05 07:08:49', 'paid', '2026-07-29 07:08:49', '2026-07-29 07:08:49'),
(10, 'PAYLINK-20260729-985E1455', 16, 1, 1, 29500.00, 'razorpay', NULL, 'http://localhost/tyche/pay/PAYLINK-20260729-985E1455', '2026-08-05 07:09:17', 'paid', '2026-07-29 07:09:17', '2026-07-29 07:09:17'),
(11, 'PAYLINK-20260729-2CBF0ACA', 17, 1, 1, 29500.00, 'razorpay', NULL, 'http://localhost/tyche/pay/PAYLINK-20260729-2CBF0ACA', '2026-08-05 07:12:15', 'paid', '2026-07-29 07:12:15', '2026-07-29 07:12:15'),
(12, 'PAYLINK-20260729-AA376E8A', 18, 1, 1, 29500.00, 'razorpay', NULL, 'http://localhost/tyche/pay/PAYLINK-20260729-AA376E8A', '2026-08-05 07:14:18', 'paid', '2026-07-29 07:14:18', '2026-07-29 07:14:18'),
(13, 'PAYLINK-20260729-4A1BEE4E', 14, 1, 1, 6000.00, 'razorpay', NULL, 'http://localhost/tyche/pay/PAYLINK-20260729-4A1BEE4E', '2026-08-05 12:04:14', 'active', NULL, '2026-07-29 12:04:14');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `module` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `code` varchar(100) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `module`, `action`, `code`, `display_name`, `description`, `created_at`) VALUES
(1, 'USERS', 'VIEW', 'USERS.View', 'View Users', 'View user profiles and list', '2026-07-27 12:11:05'),
(2, 'USERS', 'CREATE', 'USERS.Create', 'Create Users', 'Create new user accounts', '2026-07-27 12:11:05'),
(3, 'USERS', 'EDIT', 'USERS.Edit', 'Edit Users', 'Modify user profiles', '2026-07-27 12:11:05'),
(4, 'USERS', 'DELETE', 'USERS.Delete', 'Delete Users', 'Delete user accounts', '2026-07-27 12:11:05'),
(5, 'ROLES', 'MANAGE', 'ROLES.Manage', 'Manage Roles', 'Manage role permission matrix', '2026-07-27 12:11:05'),
(6, 'CMS', 'MANAGE', 'CMS.ManageContent', 'Manage CMS', 'Edit website pages and blog posts', '2026-07-27 12:11:05'),
(7, 'LMS', 'VIEW', 'LMS.ViewCourse', 'View Courses', 'Access learning modules', '2026-07-27 12:11:05'),
(8, 'LMS', 'CREATE', 'LMS.CreateCourse', 'Create Courses', 'Create & publish courses', '2026-07-27 12:11:05'),
(9, 'LMS', 'GRADE', 'LMS.GradeAssignment', 'Grade Assignments', 'Review student submissions', '2026-07-27 12:11:05'),
(10, 'CRM', 'VIEW', 'CRM.ViewLead', 'View Leads', 'View CRM lead pipelines', '2026-07-27 12:11:05'),
(11, 'CRM', 'ASSIGN', 'CRM.AssignLead', 'Assign Leads', 'Assign leads to counselors', '2026-07-27 12:11:05'),
(17, 'CMS', 'VIEW_PAGES', 'CMS.ViewPages', 'View CMS Pages', 'View CMS pages list', '2026-07-27 12:30:02'),
(18, 'CMS', 'CREATE_PAGE', 'CMS.CreatePage', 'Create CMS Page', 'Create new page', '2026-07-27 12:30:02'),
(19, 'CMS', 'EDIT_PAGE', 'CMS.EditPage', 'Edit CMS Page', 'Modify page content and revisions', '2026-07-27 12:30:02'),
(20, 'CMS', 'DELETE_PAGE', 'CMS.DeletePage', 'Delete CMS Page', 'Delete pages', '2026-07-27 12:30:02'),
(21, 'CMS', 'MANAGE_MENUS', 'CMS.ManageMenus', 'Manage Menus', 'Manage navigation menus', '2026-07-27 12:30:02'),
(22, 'CMS', 'MANAGE_BANNERS', 'CMS.ManageBanners', 'Manage Banners', 'Manage promotional sliders and banners', '2026-07-27 12:30:02'),
(23, 'CMS', 'MANAGE_FACULTY', 'CMS.ManageFaculty', 'Manage Faculty Showcase', 'Manage faculty profiles on public site', '2026-07-27 12:30:02'),
(24, 'CMS', 'MANAGE_TESTIMONIALS', 'CMS.ManageTestimonials', 'Manage Testimonials', 'Approve & edit student testimonials', '2026-07-27 12:30:02'),
(25, 'CMS', 'MANAGE_MEDIA', 'CMS.ManageMedia', 'Manage Media Library', 'Upload and organize media assets', '2026-07-27 12:30:02'),
(26, 'CMS', 'MANAGE_FAQS', 'CMS.ManageFaqs', 'Manage FAQs', 'Manage FAQ items and categories', '2026-07-27 12:30:02'),
(27, 'CMS', 'MANAGE_FORMS', 'CMS.ManageForms', 'Manage Form Submissions', 'Review contact and inquiry form submissions', '2026-07-27 12:30:02'),
(28, 'CMS', 'MANAGE_SETTINGS', 'CMS.ManageSettings', 'Manage Site Settings', 'Manage global SEO, scripts, and site branding', '2026-07-27 12:30:02'),
(29, 'BLOG', 'VIEW', 'BLOG.View', 'View Blog Posts', 'View blog articles list', '2026-07-27 12:53:15'),
(30, 'BLOG', 'CREATE', 'BLOG.Create', 'Create Blog Post', 'Create new blog posts', '2026-07-27 12:53:15'),
(31, 'BLOG', 'EDIT', 'BLOG.Edit', 'Edit Blog Post', 'Modify blog posts', '2026-07-27 12:53:15'),
(32, 'BLOG', 'DELETE', 'BLOG.Delete', 'Delete Blog Post', 'Delete blog posts', '2026-07-27 12:53:15'),
(33, 'CONTENT', 'MANAGE_CASE_STUDIES', 'CASE_STUDIES.Manage', 'Manage Case Studies', 'Manage case studies & success stories', '2026-07-27 12:53:15'),
(34, 'CONTENT', 'MANAGE_EVENTS', 'EVENTS.Manage', 'Manage Events', 'Manage webinars and workshops', '2026-07-27 12:53:15'),
(35, 'LMS', 'VIEW_COURSES', 'LMS.ViewCourses', 'View LMS Courses', 'View course catalog and modules', '2026-07-27 12:53:15'),
(37, 'LMS', 'EDIT_COURSE', 'LMS.EditCourse', 'Edit Course', 'Modify course hierarchy and lessons', '2026-07-27 12:53:15'),
(38, 'LMS', 'DELETE_COURSE', 'LMS.DeleteCourse', 'Delete Course', 'Delete courses', '2026-07-27 12:53:15'),
(39, 'LMS', 'MANAGE_LESSONS', 'LMS.ManageLessons', 'Manage Lessons', 'Manage lesson videos and resources', '2026-07-27 12:53:15'),
(40, 'LMS', 'MANAGE_ENROLLMENTS', 'LMS.ManageEnrollments', 'Manage Enrollments', 'Manage student course enrollments', '2026-07-27 12:53:15'),
(41, 'STUDENT', 'PORTAL', 'STUDENT.Portal', 'Access Student Portal', 'Access student classroom dashboard', '2026-07-27 13:11:52'),
(42, 'FACULTY', 'WORKSPACE', 'FACULTY.Workspace', 'Access Faculty Workspace', 'Access instructor teaching portal', '2026-07-27 13:11:52'),
(43, 'FACULTY', 'GRADE', 'FACULTY.GradeAssignments', 'Grade Assignments', 'Review and grade student assignments', '2026-07-27 13:11:52'),
(44, 'FACULTY', 'ANNOUNCEMENTS', 'FACULTY.ManageAnnouncements', 'Manage Course Announcements', 'Dispatch course announcements', '2026-07-27 13:11:52'),
(45, 'ASSESSMENT', 'MANAGE_QUIZZES', 'ASSESSMENT.ManageQuizzes', 'Manage Quizzes', 'Build quizzes and question banks', '2026-07-27 13:11:52'),
(46, 'CERTIFICATE', 'ISSUE', 'CERTIFICATE.Issue', 'Issue Certificates', 'Issue official course completion certificates', '2026-07-27 13:11:52'),
(47, 'CERTIFICATE', 'VERIFY', 'CERTIFICATE.Verify', 'Verify Certificates', 'Verify public certificate hashes', '2026-07-27 13:11:52'),
(48, 'CRM', 'VIEW_LEADS', 'CRM.ViewLeads', 'View Leads', 'Access CRM lead pipeline', '2026-07-27 13:21:27'),
(49, 'CRM', 'CREATE_LEAD', 'CRM.CreateLead', 'Create Lead', 'Capture new CRM leads', '2026-07-27 13:21:27'),
(50, 'CRM', 'EDIT_LEAD', 'CRM.EditLead', 'Edit Lead', 'Update lead status and follow-ups', '2026-07-27 13:21:27'),
(51, 'CRM', 'COUNSELOR_DASHBOARD', 'CRM.CounselorDashboard', 'Counselor Dashboard', 'Access counselor sales desk', '2026-07-27 13:21:27'),
(52, 'FINANCE', 'VIEW_PAYMENTS', 'FINANCE.ViewPayments', 'View Payments', 'View fee payments and ledgers', '2026-07-27 13:21:27'),
(53, 'FINANCE', 'MANAGE_INVOICES', 'FINANCE.ManageInvoices', 'Manage Invoices', 'Generate and view GST Tax Invoices', '2026-07-27 13:21:27'),
(54, 'FINANCE', 'REFUND', 'FINANCE.Refund', 'Process Refunds', 'Approve and process fee refunds', '2026-07-27 13:21:27'),
(55, 'COMMUNICATION', 'SEND_BROADCAST', 'COMMUNICATION.SendBroadcast', 'Send Broadcast', 'Dispatch multi-channel broadcasts', '2026-07-27 13:21:27'),
(56, 'BI', 'VIEW_REPORTS', 'BI.ViewReports', 'View BI Dashboards', 'Access executive BI & reporting telemetry', '2026-07-27 14:01:38'),
(57, 'BI', 'EXPORT_DATA', 'BI.ExportData', 'Export CSV/PDF Reports', 'Download system CSV & PDF reports', '2026-07-27 14:01:38'),
(58, 'PLACEMENT', 'MANAGE_JOBS', 'PLACEMENT.ManageJobs', 'Manage Job Postings', 'Manage placement cell job board', '2026-07-27 14:01:38'),
(59, 'PLACEMENT', 'VIEW_APPLICATIONS', 'PLACEMENT.ViewApplications', 'View Job Applications', 'View student job applications', '2026-07-27 14:01:38'),
(60, 'AUTOMATION', 'MANAGE_CAMPAIGNS', 'AUTOMATION.ManageCampaigns', 'Manage Campaigns', 'Create automated marketing campaigns', '2026-07-27 14:01:39'),
(61, 'AUTOMATION', 'MANAGE_COUPONS', 'AUTOMATION.ManageCoupons', 'Manage Coupons', 'Manage discount codes and referrals', '2026-07-27 14:01:39'),
(62, 'SYSTEM', 'ADMIN_CONSOLE', 'SYSTEM.AdminConsole', 'System Console', 'Access system settings & cache tools', '2026-07-27 14:01:39'),
(63, 'SYSTEM', 'BACKUP', 'SYSTEM.Backup', 'Database Backup', 'Generate and download database backups', '2026-07-27 14:01:39'),
(64, 'SYSTEM', 'HEALTH', 'SYSTEM.Health', 'System Health', 'Monitor server health & logs', '2026-07-27 14:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE `post_tags` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `chapter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `time_limit_minutes` int(10) UNSIGNED NOT NULL DEFAULT 30,
  `passing_score_percentage` int(10) UNSIGNED NOT NULL DEFAULT 70,
  `max_attempts` int(10) UNSIGNED NOT NULL DEFAULT 3,
  `shuffle_questions` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `course_id`, `chapter_id`, `title`, `description`, `time_limit_minutes`, `passing_score_percentage`, `max_attempts`, `shuffle_questions`, `is_active`, `created_at`) VALUES
(1, 1, NULL, 'Technical SEO & Generative Engine Assessment', 'Final module assessment for search crawlers, AI citation mechanics, and robots.txt rules.', 20, 70, 3, 1, 1, '2026-07-27 13:11:52');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `attempt_number` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `score_obtained` decimal(5,2) NOT NULL DEFAULT 0.00,
  `total_marks` decimal(5,2) NOT NULL DEFAULT 0.00,
  `percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `is_passed` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('in_progress','completed','timed_out') NOT NULL DEFAULT 'in_progress',
  `started_at` datetime NOT NULL DEFAULT current_timestamp(),
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `quiz_id`, `user_id`, `attempt_number`, `score_obtained`, `total_marks`, `percentage`, `is_passed`, `status`, `started_at`, `completed_at`) VALUES
(1, 1, 2, 1, 10.00, 10.00, 100.00, 1, 'completed', '2026-07-27 13:13:41', '2026-07-27 13:13:41');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempt_answers`
--

CREATE TABLE `quiz_attempt_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attempt_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `selected_option_id` bigint(20) UNSIGNED DEFAULT NULL,
  `text_answer` text DEFAULT NULL,
  `marks_awarded` decimal(5,2) NOT NULL DEFAULT 0.00,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_attempt_answers`
--

INSERT INTO `quiz_attempt_answers` (`id`, `attempt_id`, `question_id`, `selected_option_id`, `text_answer`, `marks_awarded`, `is_correct`) VALUES
(1, 1, 1, 1, NULL, 5.00, 1),
(2, 1, 2, 5, NULL, 5.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_options`
--

CREATE TABLE `quiz_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_options`
--

INSERT INTO `quiz_options` (`id`, `question_id`, `option_text`, `is_correct`, `sort_order`) VALUES
(1, 1, '301 Moved Permanently', 1, 1),
(2, 1, '302 Found', 0, 2),
(3, 1, '404 Not Found', 0, 3),
(4, 1, '500 Server Error', 0, 4),
(5, 2, 'True', 1, 1),
(6, 2, 'False', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `question_text` text NOT NULL,
  `question_type` enum('mcq','multi_select','true_false','short_answer','file_upload') NOT NULL DEFAULT 'mcq',
  `marks` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `explanation_text` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `quiz_id`, `question_text`, `question_type`, `marks`, `explanation_text`, `sort_order`) VALUES
(1, 1, 'Which HTTP status code communicates a permanent 301 redirect to search crawlers?', 'mcq', 5, NULL, 1),
(2, 1, 'LLM Answer Engines prioritize structured schema markup for direct answer citations.', 'true_false', 5, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referrer_user_id` bigint(20) UNSIGNED NOT NULL,
  `referred_email` varchar(150) NOT NULL,
  `referral_code` varchar(50) NOT NULL,
  `status` enum('invited','registered','enrolled') NOT NULL DEFAULT 'invited',
  `reward_amount` decimal(10,2) NOT NULL DEFAULT 500.00,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refunds`
--

CREATE TABLE `refunds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` text NOT NULL,
  `status` enum('requested','approved','processed','rejected') NOT NULL DEFAULT 'requested',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--

CREATE TABLE `resumes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `headline` varchar(200) NOT NULL,
  `summary` text DEFAULT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `portfolio_url` varchar(255) DEFAULT NULL,
  `resume_file` varchar(255) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `is_system`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Super Administrator', 'Unrestricted platform access', 1, '2026-07-27 12:11:05', '2026-07-27 12:11:05'),
(2, 'Admin', 'Administrator', 'Full administrative management', 1, '2026-07-27 12:11:05', '2026-07-27 12:11:05'),
(3, 'Faculty', 'Faculty / Instructor', 'Course creation and grading', 1, '2026-07-27 12:11:05', '2026-07-27 12:11:05'),
(4, 'Counselor', 'Admissions Counselor', 'CRM and lead management', 1, '2026-07-27 12:11:05', '2026-07-27 12:11:05'),
(5, 'Student', 'Student Learner', 'Learning portal access', 1, '2026-07-27 12:11:05', '2026-07-27 12:11:05');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62),
(1, 63),
(1, 64),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 33),
(2, 34),
(2, 35),
(2, 37),
(2, 38),
(2, 39),
(2, 40),
(2, 41),
(2, 42),
(2, 43),
(2, 44),
(2, 45),
(2, 46),
(2, 47),
(2, 48),
(2, 49),
(2, 50),
(2, 51),
(2, 52),
(2, 53),
(2, 54),
(2, 55),
(3, 42),
(3, 43),
(3, 44),
(3, 45),
(4, 10),
(4, 11),
(4, 46),
(4, 47),
(4, 48),
(4, 49),
(4, 50),
(4, 51),
(4, 56),
(4, 57),
(4, 58),
(4, 59),
(5, 41);

-- --------------------------------------------------------

--
-- Table structure for table `seo_metadata`
--

CREATE TABLE `seo_metadata` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entity_type` varchar(50) NOT NULL,
  `entity_id` bigint(20) UNSIGNED NOT NULL,
  `meta_title` varchar(200) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `og_title` varchar(200) DEFAULT NULL,
  `og_description` varchar(255) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `robots` varchar(50) DEFAULT 'index, follow'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('address', 'Tyche Academy Building, Tech Park Road, Bengaluru, India'),
('contact_email', 'info@tyche.academy'),
('contact_phone', '+91 9876543210'),
('footer_copyright', '© 2026 Tyche Digital Marketing Academy. All rights reserved.'),
('maintenance_mode', 'false'),
('site_name', 'Tyche Digital Marketing Academy');

-- --------------------------------------------------------

--
-- Table structure for table `student_achievements`
--

CREATE TABLE `student_achievements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `badge_icon` varchar(50) NOT NULL DEFAULT 'bi-award-fill',
  `description` varchar(255) NOT NULL,
  `awarded_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_achievements`
--

INSERT INTO `student_achievements` (`id`, `user_id`, `title`, `badge_icon`, `description`, `awarded_at`) VALUES
(1, 2, 'SEO Pioneer', 'bi-lightning-charge-fill', 'Completed first technical SEO module video and notes.', '2026-07-27 13:11:52');

-- --------------------------------------------------------

--
-- Table structure for table `success_stories`
--

CREATE TABLE `success_stories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `student_photo` varchar(255) DEFAULT NULL,
  `company_joined` varchar(100) NOT NULL,
  `role_title` varchar(100) NOT NULL,
  `salary_package` varchar(50) DEFAULT NULL,
  `course_completed` varchar(150) NOT NULL,
  `story_content` text NOT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_backups`
--

CREATE TABLE `system_backups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_size` bigint(20) UNSIGNED NOT NULL,
  `backup_type` enum('database','files','full') NOT NULL DEFAULT 'database',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_backups`
--

INSERT INTO `system_backups` (`id`, `filename`, `file_size`, `backup_type`, `created_at`) VALUES
(1, 'tyche_db_backup_2026-07-27_14-03-27.sql', 2430, 'database', '2026-07-27 14:03:27'),
(2, 'tyche_db_backup_2026-07-27_14-12-27.sql', 2430, 'database', '2026-07-27 14:12:27'),
(3, 'tyche_db_backup_2026-07-27_14-12-35.sql', 2430, 'database', '2026-07-27 14:12:35'),
(4, 'tyche_db_backup_2026-07-27_14-17-19.sql', 2430, 'database', '2026-07-27 14:17:19'),
(5, 'tyche_db_backup_2026-07-27_14-27-12.sql', 2430, 'database', '2026-07-27 14:27:12'),
(6, 'tyche_db_backup_2026-07-27_14-38-33.sql', 2430, 'database', '2026-07-27 14:38:33'),
(7, 'tyche_db_backup_2026-07-27_14-45-21.sql', 2430, 'database', '2026-07-27 14:45:21'),
(8, 'tyche_db_backup_2026-07-27_15-03-16.sql', 2430, 'database', '2026-07-27 15:03:16'),
(9, 'tyche_db_backup_2026-07-27_15-07-23.sql', 2430, 'database', '2026-07-27 15:07:23'),
(10, 'tyche_db_backup_2026-07-27_15-09-58.sql', 2430, 'database', '2026-07-27 15:09:58'),
(11, 'tyche_db_backup_2026-07-27_15-23-41.sql', 2430, 'database', '2026-07-27 15:23:41'),
(12, 'tyche_db_backup_2026-07-27_17-05-29.sql', 2430, 'database', '2026-07-27 17:05:29'),
(13, 'tyche_db_backup_2026-07-27_17-09-17.sql', 2430, 'database', '2026-07-27 17:09:17'),
(14, 'tyche_db_backup_2026-07-27_17-19-12.sql', 2430, 'database', '2026-07-27 17:19:12'),
(15, 'tyche_db_backup_2026-07-27_17-24-20.sql', 2430, 'database', '2026-07-27 17:24:20'),
(16, 'tyche_db_backup_2026-07-27_17-34-17.sql', 2430, 'database', '2026-07-27 17:34:17'),
(17, 'tyche_db_backup_2026-07-27_17-36-53.sql', 2430, 'database', '2026-07-27 17:36:53'),
(18, 'tyche_db_backup_2026-07-27_18-27-23.sql', 2430, 'database', '2026-07-27 18:27:23'),
(19, 'tyche_db_backup_2026-07-27_18-27-56.sql', 2430, 'database', '2026-07-27 18:27:57'),
(20, 'tyche_db_backup_2026-07-28_10-09-07.sql', 2430, 'database', '2026-07-28 10:09:07'),
(21, 'tyche_db_backup_2026-07-28_10-09-41.sql', 2430, 'database', '2026-07-28 10:09:41'),
(22, 'tyche_db_backup_2026-07-29_10-39-22.sql', 2522, 'database', '2026-07-29 10:39:22'),
(23, 'tyche_db_backup_2026-07-29_10-42-21.sql', 2522, 'database', '2026-07-29 10:42:21'),
(24, 'tyche_db_backup_2026-07-29_10-44-25.sql', 2522, 'database', '2026-07-29 10:44:25'),
(25, 'tyche_db_backup_2026-07-29_12-58-08.sql', 2522, 'database', '2026-07-29 12:58:08'),
(26, 'tyche_db_backup_2026-07-29_13-03-22.sql', 2522, 'database', '2026-07-29 13:03:22'),
(27, 'tyche_db_backup_2026-07-29_13-13-07.sql', 2522, 'database', '2026-07-29 13:13:07');

-- --------------------------------------------------------

--
-- Table structure for table `system_notifications`
--

CREATE TABLE `system_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_notifications`
--

INSERT INTO `system_notifications` (`id`, `user_id`, `type`, `title`, `message`, `action_url`, `is_read`, `created_at`) VALUES
(1, 1, 'system', 'Welcome to Tyche Admin Panel', 'Your Phase 0 - Phase 3 Control Center and CMS engine are active.', '/admin/dashboard', 0, '2026-07-27 12:30:02'),
(2, NULL, 'lead', 'New Public Inquiry (CONTACT)', 'Inquiry received from Jane Tester (jane@example.com)', '/admin/cms/forms', 0, '2026-07-27 12:33:10'),
(3, NULL, 'lead', 'New Public Inquiry (CONTACT)', 'Inquiry received from Jane Tester (jane@example.com)', '/admin/cms/forms', 0, '2026-07-27 12:33:19'),
(4, 2, 'system', 'Course Enrollment Confirmation', 'Your admission is confirmed!', '/dashboard', 0, '2026-07-27 13:23:05'),
(5, 2, 'system', 'Course Enrollment Confirmation', 'Your admission is confirmed!', '/dashboard', 0, '2026-07-27 13:23:16'),
(6, NULL, 'lead', 'New Public Inquiry (COURSE_ENQUIRY)', 'Inquiry received from User (manu@xtech.com)', '/admin/crm/leads', 0, '2026-07-27 15:52:19'),
(7, NULL, 'lead', 'New Public Inquiry (COURSE_LANDING_PAGE)', 'Inquiry received from User (manu@xtech.com)', '/admin/crm/leads', 0, '2026-07-27 15:59:28'),
(8, NULL, 'lead', 'New Public Inquiry (COURSE_LANDING_PAGE)', 'Inquiry received from User (manu@xtech.com)', '/admin/crm/leads', 0, '2026-07-27 17:13:53'),
(9, NULL, 'lead', 'New Public Inquiry (COURSE_LANDING_PAGE)', 'Inquiry received from User (manu@xtech.com)', '/admin/crm/leads', 0, '2026-07-27 17:14:13'),
(10, 1, 'student', 'Course Enrollment & GST Receipt Confirmed!', 'You have successfully enrolled in Programmatic Advertising & DV360. Happy Learning!', '/courses/programmatic-advertising-dv360', 0, '2026-07-27 17:26:50'),
(11, NULL, 'lead', 'New Public Inquiry (COURSE_LANDING_PAGE)', 'Inquiry received from User (vishal@xtech.in)', '/admin/crm/leads', 0, '2026-07-29 14:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `role_title` varchar(100) DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `type` enum('student','corporate','video') NOT NULL DEFAULT 'student',
  `video_url` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'approved',
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','suspended','pending') NOT NULL DEFAULT 'active',
  `email_verified_at` datetime DEFAULT NULL,
  `failed_login_attempts` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `locked_until` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `password_hash`, `avatar`, `status`, `email_verified_at`, `failed_login_attempts`, `locked_until`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'User', 'admin@tyche.academy', '+91 9876543210', '$2y$12$xeIRQUyqwmrevkCOSS7B2Os.0pwqrrHraNcNquPJxRMxWpWnRWlAq', NULL, 'active', '2026-07-27 12:11:06', 0, NULL, '2026-07-27 12:11:06', '2026-07-27 13:15:10'),
(2, 'Student', 'User', 'student@tyche.academy', '+91 9876543211', '$2y$12$nazmz/VR5xuoXCni3PxsEes3La5gM5HPIi5EnlRBNEEQpS3S/q9Ua', NULL, 'active', '2026-07-27 12:11:06', 0, NULL, '2026-07-27 12:11:06', '2026-07-27 12:11:06'),
(3, 'Manu', '', 'manu@xtech.com', NULL, '$argon2id$v=19$m=65536,t=4,p=1$dE83UTRIemx0YWZNLm91eQ$4VxSmjWFX3PxojxM/C73zx2jj4lSwE7C2qqJpu1es8k', NULL, 'active', NULL, 0, NULL, '2026-07-27 17:15:49', '2026-07-27 17:15:49'),
(4, 'Automated', 'Tester', 'teststudent_1785152980@example.com', '9988776655', '$argon2id$v=19$m=65536,t=4,p=1$L0k2SlhpRzZIVldBa0xpZQ$ZrogYJJKUK+1x3Y4Zd5bXQ14yKoiTl8E3thP47+uvfw', NULL, 'active', NULL, 0, NULL, '2026-07-27 17:19:41', '2026-07-27 17:19:41'),
(5, 'Vikram', 'Aditya', 'crm_test_424@example.com', '9876515419', '$argon2id$v=19$m=65536,t=4,p=1$bHg5Tm0vcHdOMjkxYlNabQ$yRdslR+qZUFnhI7se89wf4qL7jisYi4RpyZEl2aUBcI', NULL, 'active', NULL, 0, NULL, '2026-07-29 10:36:42', '2026-07-29 10:36:42'),
(6, 'Vikram', 'Aditya', 'crm_test_204@example.com', '9876583680', '$argon2id$v=19$m=65536,t=4,p=1$TS9nYzFNZ0RxY2U1VlYxYw$t3n4JA4BNvKajVgEDBtxfmuopoBFWVExqDgZPWjLL0A', NULL, 'active', NULL, 0, NULL, '2026-07-29 10:36:53', '2026-07-29 10:36:53'),
(7, 'Vikram', 'Aditya', 'crm_test_588@example.com', '9876590806', '$argon2id$v=19$m=65536,t=4,p=1$YUM2c0FFZGd2cExWLjZoVQ$0Fl0EWIwJ7NUg1vYLqWOOp6c3MR/pUaIdgw27ZCMlx4', NULL, 'active', NULL, 0, NULL, '2026-07-29 10:37:14', '2026-07-29 10:37:14'),
(8, 'Vikram', 'Aditya', 'crm_test_875@example.com', '9876528844', '$argon2id$v=19$m=65536,t=4,p=1$OUE2VG5UTUQxenJKZDhjcQ$F1YWIkur8VjTx2QnJFUw+xH6O7kDRgqbf34p4aSJwF4', NULL, 'active', NULL, 0, NULL, '2026-07-29 10:37:43', '2026-07-29 10:37:43'),
(9, 'Rahul', 'Sharma', 'rahul@example.com', '+919876543210', '$argon2id$v=19$m=65536,t=4,p=1$QWpKTmVtSVUvOXY1cnpJSQ$+lC8xjDRXouQDKRQtJESYlfHrNVSFNHUy4w9KBv4Ecg', NULL, 'active', NULL, 0, NULL, '2026-07-29 10:37:59', '2026-07-29 10:37:59'),
(10, 'Vikram', 'Aditya', 'crm_test_770@example.com', '9876526799', '$argon2id$v=19$m=65536,t=4,p=1$NXdiZjYyWWp5a2NWdXRXcg$DY3VVQnUXQ2NtHBvkvLFpSAnvC7fEPEpe+JflnY/cN8', NULL, 'active', NULL, 0, NULL, '2026-07-29 10:38:31', '2026-07-29 10:38:31'),
(11, 'Vikram', 'Aditya', 'crm_test_781@example.com', '9876549987', '$argon2id$v=19$m=65536,t=4,p=1$SHdnRkhvNWVPSkxnTkVXVQ$LQdsGZXXgSUKdaGENJHrvh96u9SYQS1T7czmHKEYcAM', NULL, 'active', NULL, 0, NULL, '2026-07-29 10:38:40', '2026-07-29 10:38:40'),
(12, 'Vikram', 'Aditya', 'crm_test_173@example.com', '9876523791', '$argon2id$v=19$m=65536,t=4,p=1$RFljeDR2VTVlSHFGM0JsUQ$gWOb76+sgYELWpeMumOPHeGaKyXAX2zX2tght9xfVI4', NULL, 'active', NULL, 0, NULL, '2026-07-29 10:38:50', '2026-07-29 10:38:50'),
(13, 'Vikram', 'Aditya', 'crm_test_364@example.com', '9876582852', '$argon2id$v=19$m=65536,t=4,p=1$cGtQcXNrVUpadmZka1RCTg$x/kwPLkcapwHEzCKpJCTHQ/eg1untuMa4GhCaum0DfM', NULL, 'active', NULL, 0, NULL, '2026-07-29 10:39:17', '2026-07-29 10:39:17'),
(14, 'Vikram', 'Aditya', 'crm_test_776@example.com', '9876521655', '$argon2id$v=19$m=65536,t=4,p=1$STBQVm9FVEpWbWd0eWI5Mw$PHJF9YDbwynN29YvimC1cDmvFufeaPL/W9rM7valztg', NULL, 'active', NULL, 0, NULL, '2026-07-29 10:42:16', '2026-07-29 10:42:16'),
(15, 'Vikram', 'Aditya', 'crm_test_551@example.com', '9876599076', '$argon2id$v=19$m=65536,t=4,p=1$emZZT0tVWFJ6Njdna3hUYw$kQxljgdK/KAYsfbEV5jNxlrh7zTrY25XAoXgzEiMuKs', NULL, 'active', NULL, 0, NULL, '2026-07-29 10:44:18', '2026-07-29 10:44:18'),
(16, 'Pragya', 'Bhart', 'pragya@xtech.com', '8210840604', '$argon2id$v=19$m=65536,t=4,p=1$VHV4NWQ5YW9lTTFNZGhkUg$CEr4ojMlftnSu8pn6qi/ZOPC6/AndlheZZFiC9tgj1c', NULL, 'active', '2026-07-29 13:04:55', 0, NULL, '2026-07-29 13:04:55', '2026-07-29 13:04:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 5),
(3, 5),
(4, 5),
(5, 5),
(6, 5),
(7, 5),
(8, 5),
(9, 5),
(10, 5),
(11, 5),
(12, 5),
(13, 5),
(14, 5),
(15, 5),
(16, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` varchar(128) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `last_activity` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `last_activity`) VALUES
('', 1, '127.0.0.1', 'PHPUnit Test', '2026-07-29 13:13:07'),
('1eo1ssst4do39ps4qqol5qvv7q', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-29 12:00:46'),
('3e907qbkddjlpqlicrg2saqfs7', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-29 14:18:42'),
('56sfrnkp7jotj9s1itn2vnh00b', 9, '127.0.0.1', 'CRM Payment Link Webhook', '2026-07-29 10:37:59'),
('6k856r85luc3bqib6h1kovn82q', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-27 14:19:32'),
('aer1bjrru7jbfehku88bb7ft6n', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-29 12:37:11'),
('ckcon7rk7itqrfeg7td4ri2kv6', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-27 15:52:40'),
('g3v46a3k95p5tfs47h8j2rdodb', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-27 18:59:49'),
('gfh6fevpis06pv8gjn37iq0lje', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-27 13:27:42'),
('ju0brc9gjsb67vbsj37hlhafam', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-27 17:22:03'),
('lmruatldf3nb8p8f593kgd88bd', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-29 10:43:21'),
('p03u27ujvhj1dq3n25g4qfcm4s', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-27 12:35:18'),
('q1umg7137e7upf6fdtk4r4gi3t', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-28 10:10:14'),
('qp3v3nv0o6tqj1l4v6pfqkpg9g', 16, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-29 13:14:06'),
('rgnlqu6u0shjgr310a7qg9vr9d', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-27 14:57:30'),
('s6bsdum7evhl9oge61ri069rj3', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-27 17:55:59'),
('u4ghnral0tsqlch8ehoiqeo2v4', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-28 18:52:35'),
('u9j7kuooam7do96bctqm7i8g7b', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-29 13:15:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admission_number` (`admission_number`),
  ADD KEY `lead_id` (`lead_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `chapter_id` (`chapter_id`);

--
-- Indexes for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `graded_by` (`graded_by`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `bi_reports`
--
ALTER TABLE `bi_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `blog_tags`
--
ALTER TABLE `blog_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `case_studies`
--
ALTER TABLE `case_studies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_code` (`certificate_code`),
  ADD UNIQUE KEY `verification_hash` (`verification_hash`),
  ADD UNIQUE KEY `uk_student_course_cert` (`user_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `communication_logs`
--
ALTER TABLE `communication_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `course_announcements`
--
ALTER TABLE `course_announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `course_categories`
--
ALTER TABLE `course_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `course_chapters`
--
ALTER TABLE `course_chapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `course_enrollments`
--
ALTER TABLE `course_enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_user_course` (`user_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_instructors`
--
ALTER TABLE `course_instructors`
  ADD PRIMARY KEY (`course_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `course_lessons`
--
ALTER TABLE `course_lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_id` (`chapter_id`);

--
-- Indexes for table `course_modules`
--
ALTER TABLE `course_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `demo_classes`
--
ALTER TABLE `demo_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `employers`
--
ALTER TABLE `employers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `event_speakers`
--
ALTER TABLE `event_speakers`
  ADD PRIMARY KEY (`event_id`,`name`);

--
-- Indexes for table `faculty_profiles`
--
ALTER TABLE `faculty_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_plans`
--
ALTER TABLE `fee_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admission_id` (`admission_id`);

--
-- Indexes for table `form_submissions`
--
ALTER TABLE `form_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `gallery_items`
--
ALTER TABLE `gallery_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `album_id` (`album_id`);

--
-- Indexes for table `homepage_sections`
--
ALTER TABLE `homepage_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_key` (`section_key`);

--
-- Indexes for table `internal_messages`
--
ALTER TABLE `internal_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_job_user` (`job_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lead_code` (`lead_code`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `counselor_id` (`counselor_id`);

--
-- Indexes for table `lead_activities`
--
ALTER TABLE `lead_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `lead_followups`
--
ALTER TABLE `lead_followups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`),
  ADD KEY `counselor_id` (`counselor_id`);

--
-- Indexes for table `lesson_bookmarks`
--
ALTER TABLE `lesson_bookmarks`
  ADD PRIMARY KEY (`user_id`,`lesson_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `lesson_notes`
--
ALTER TABLE `lesson_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_user_lesson` (`user_id`,`lesson_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `lesson_resources`
--
ALTER TABLE `lesson_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `marketing_campaigns`
--
ALTER TABLE `marketing_campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_files`
--
ALTER TABLE `media_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `navigation_menus`
--
ALTER TABLE `navigation_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `page_revisions`
--
ALTER TABLE `page_revisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_reference` (`payment_reference`),
  ADD KEY `admission_id` (`admission_id`),
  ADD KEY `fee_plan_id` (`fee_plan_id`);

--
-- Indexes for table `payment_links`
--
ALTER TABLE `payment_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `link_code` (`link_code`),
  ADD KEY `lead_id` (`lead_id`),
  ADD KEY `link_code_2` (`link_code`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_module` (`module`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`post_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `chapter_id` (`chapter_id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `quiz_attempt_answers`
--
ALTER TABLE `quiz_attempt_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attempt_id` (`attempt_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `quiz_options`
--
ALTER TABLE `quiz_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referrer_user_id` (`referrer_user_id`);

--
-- Indexes for table `refunds`
--
ALTER TABLE `refunds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `resumes`
--
ALTER TABLE `resumes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_student_resume` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `seo_metadata`
--
ALTER TABLE `seo_metadata`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_entity` (`entity_type`,`entity_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `student_achievements`
--
ALTER TABLE `student_achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `success_stories`
--
ALTER TABLE `success_stories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_backups`
--
ALTER TABLE `system_backups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_notifications`
--
ALTER TABLE `system_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_read` (`user_id`,`is_read`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bi_reports`
--
ALTER TABLE `bi_reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blog_tags`
--
ALTER TABLE `blog_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_studies`
--
ALTER TABLE `case_studies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `communication_logs`
--
ALTER TABLE `communication_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `course_announcements`
--
ALTER TABLE `course_announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_categories`
--
ALTER TABLE `course_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `course_chapters`
--
ALTER TABLE `course_chapters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course_enrollments`
--
ALTER TABLE `course_enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `course_lessons`
--
ALTER TABLE `course_lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course_modules`
--
ALTER TABLE `course_modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `demo_classes`
--
ALTER TABLE `demo_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employers`
--
ALTER TABLE `employers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculty_profiles`
--
ALTER TABLE `faculty_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fee_plans`
--
ALTER TABLE `fee_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `form_submissions`
--
ALTER TABLE `form_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_items`
--
ALTER TABLE `gallery_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `homepage_sections`
--
ALTER TABLE `homepage_sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internal_messages`
--
ALTER TABLE `internal_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `lead_activities`
--
ALTER TABLE `lead_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `lead_followups`
--
ALTER TABLE `lead_followups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `lesson_notes`
--
ALTER TABLE `lesson_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lesson_resources`
--
ALTER TABLE `lesson_resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `marketing_campaigns`
--
ALTER TABLE `marketing_campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `media_files`
--
ALTER TABLE `media_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `navigation_menus`
--
ALTER TABLE `navigation_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `page_revisions`
--
ALTER TABLE `page_revisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment_links`
--
ALTER TABLE `payment_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_attempt_answers`
--
ALTER TABLE `quiz_attempt_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quiz_options`
--
ALTER TABLE `quiz_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refunds`
--
ALTER TABLE `refunds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resumes`
--
ALTER TABLE `resumes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `seo_metadata`
--
ALTER TABLE `seo_metadata`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_achievements`
--
ALTER TABLE `student_achievements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `success_stories`
--
ALTER TABLE `success_stories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_backups`
--
ALTER TABLE `system_backups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `system_notifications`
--
ALTER TABLE `system_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admissions`
--
ALTER TABLE `admissions`
  ADD CONSTRAINT `admissions_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `admissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admissions_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`chapter_id`) REFERENCES `course_chapters` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD CONSTRAINT `assignment_submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignment_submissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignment_submissions_ibfk_3` FOREIGN KEY (`graded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bi_reports`
--
ALTER TABLE `bi_reports`
  ADD CONSTRAINT `bi_reports_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD CONSTRAINT `blog_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `blog_posts_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `course_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `course_announcements`
--
ALTER TABLE `course_announcements`
  ADD CONSTRAINT `course_announcements_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_announcements_ibfk_2` FOREIGN KEY (`faculty_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_chapters`
--
ALTER TABLE `course_chapters`
  ADD CONSTRAINT `course_chapters_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `course_modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_enrollments`
--
ALTER TABLE `course_enrollments`
  ADD CONSTRAINT `course_enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_instructors`
--
ALTER TABLE `course_instructors`
  ADD CONSTRAINT `course_instructors_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_instructors_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_lessons`
--
ALTER TABLE `course_lessons`
  ADD CONSTRAINT `course_lessons_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `course_chapters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_modules`
--
ALTER TABLE `course_modules`
  ADD CONSTRAINT `course_modules_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `demo_classes`
--
ALTER TABLE `demo_classes`
  ADD CONSTRAINT `demo_classes_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `demo_classes_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `demo_classes_ibfk_3` FOREIGN KEY (`faculty_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_speakers`
--
ALTER TABLE `event_speakers`
  ADD CONSTRAINT `event_speakers_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `faculty_profiles`
--
ALTER TABLE `faculty_profiles`
  ADD CONSTRAINT `faculty_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `fee_plans`
--
ALTER TABLE `fee_plans`
  ADD CONSTRAINT `fee_plans_ibfk_1` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gallery_items`
--
ALTER TABLE `gallery_items`
  ADD CONSTRAINT `gallery_items_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `gallery_albums` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `internal_messages`
--
ALTER TABLE `internal_messages`
  ADD CONSTRAINT `internal_messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `internal_messages_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job_postings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD CONSTRAINT `job_postings_ibfk_1` FOREIGN KEY (`employer_id`) REFERENCES `employers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `leads_ibfk_2` FOREIGN KEY (`counselor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `lead_followups`
--
ALTER TABLE `lead_followups`
  ADD CONSTRAINT `lead_followups_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lead_followups_ibfk_2` FOREIGN KEY (`counselor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_bookmarks`
--
ALTER TABLE `lesson_bookmarks`
  ADD CONSTRAINT `lesson_bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_bookmarks_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `course_lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_notes`
--
ALTER TABLE `lesson_notes`
  ADD CONSTRAINT `lesson_notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_notes_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `course_lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD CONSTRAINT `lesson_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_progress_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `course_lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_resources`
--
ALTER TABLE `lesson_resources`
  ADD CONSTRAINT `lesson_resources_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `course_lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `login_history`
--
ALTER TABLE `login_history`
  ADD CONSTRAINT `login_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `media_files`
--
ALTER TABLE `media_files`
  ADD CONSTRAINT `media_files_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `navigation_menus`
--
ALTER TABLE `navigation_menus`
  ADD CONSTRAINT `navigation_menus_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `navigation_menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `page_revisions`
--
ALTER TABLE `page_revisions`
  ADD CONSTRAINT `page_revisions_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `page_revisions_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`fee_plan_id`) REFERENCES `fee_plans` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `blog_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quizzes_ibfk_2` FOREIGN KEY (`chapter_id`) REFERENCES `course_chapters` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD CONSTRAINT `quiz_attempts_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_attempts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_attempt_answers`
--
ALTER TABLE `quiz_attempt_answers`
  ADD CONSTRAINT `quiz_attempt_answers_ibfk_1` FOREIGN KEY (`attempt_id`) REFERENCES `quiz_attempts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_attempt_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_options`
--
ALTER TABLE `quiz_options`
  ADD CONSTRAINT `quiz_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `referrals`
--
ALTER TABLE `referrals`
  ADD CONSTRAINT `referrals_ibfk_1` FOREIGN KEY (`referrer_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `refunds`
--
ALTER TABLE `refunds`
  ADD CONSTRAINT `refunds_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `refunds_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `resumes`
--
ALTER TABLE `resumes`
  ADD CONSTRAINT `resumes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_achievements`
--
ALTER TABLE `student_achievements`
  ADD CONSTRAINT `student_achievements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `system_notifications`
--
ALTER TABLE `system_notifications`
  ADD CONSTRAINT `system_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
