-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 03:06 PM
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
-- Database: `projfutsal`
--

-- --------------------------------------------------------

--
-- Table structure for table `arenas`
--

CREATE TABLE `arenas` (
  `arena_id` int(11) NOT NULL,
  `arena_name` varchar(100) NOT NULL,
  `arena_location` varchar(255) NOT NULL,
  `location_link` varchar(255) DEFAULT NULL,
  `arena_image` varchar(255) DEFAULT NULL,
  `availability` varchar(100) DEFAULT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `rental_fee` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `arenas`
--

INSERT INTO `arenas` (`arena_id`, `arena_name`, `arena_location`, `location_link`, `arena_image`, `availability`, `contact_info`, `rental_fee`, `created_at`, `updated_at`) VALUES
(1, 'kumari', 'kathmandu', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.108541057246!2d85.30554127514783!3d27.71393482520147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb18fb7ea82b97%3A0x533a5f813eec590f!2sKumari%20Futsal!5e0!3m2!1sen!2snp!4v17', 'uploads/673198363fcda_coke.jpg', 'booked', '349835', 12000.00, '2024-11-11 05:37:58', '2024-11-11 05:37:58'),
(2, 'vajra futsal', 'bijeshwor', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.141893267904!2d85.29791957514783!3d27.71290492524688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb18f11b5a5e21%3A0xa5894f920b45e7ae!2sVajra%20Futsal!5e0!3m2!1sen!2snp!4v173', 'uploads/6731ac829f012_howzhublogo.JPG', 'unbooked', '986667577', 12300.00, '2024-11-11 07:04:34', '2024-11-11 07:04:34');

-- --------------------------------------------------------

--
-- Table structure for table `arena_bookings`
--

CREATE TABLE `arena_bookings` (
  `id` int(11) NOT NULL,
  `arena_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `status` enum('booked','unbooked') NOT NULL DEFAULT 'unbooked',
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `arena_bookings`
--

INSERT INTO `arena_bookings` (`id`, `arena_id`, `player_id`, `status`, `booking_date`, `booking_time`) VALUES
(32, 1, 13, 'booked', '2024-11-15 05:59:07', 'em'),
(33, 1, 13, 'booked', '2024-11-15 06:02:23', 'mm'),
(34, 2, 13, 'booked', '2024-11-15 06:13:49', 'ma'),
(35, 1, 13, 'booked', '2024-11-15 07:10:25', 'lm'),
(36, 1, 13, 'booked', '2024-11-15 07:12:52', 'bn'),
(37, 1, 13, 'booked', '2024-11-15 07:12:56', 'ea'),
(38, 1, 13, 'booked', '2024-11-15 07:45:29', '2024-11-15 13:30:29'),
(39, 1, 13, 'booked', '2024-11-15 07:45:39', '2024-11-15 13:30:39'),
(40, 1, 13, 'booked', '2024-11-15 07:45:40', '2024-11-15 13:30:40'),
(41, 1, 13, 'booked', '2024-11-15 07:45:54', '2024-11-15 13:30:54'),
(42, 1, 13, 'booked', '2024-11-15 07:46:00', '2024-11-15 13:31:00'),
(43, 1, 13, 'booked', '2024-11-15 07:46:01', '2024-11-15 13:31:01'),
(44, 1, 13, 'booked', '2024-11-15 07:46:06', '2024-11-15 13:31:06'),
(45, 1, 11, 'booked', '2024-11-16 04:17:19', '2024-11-16 10:02:19'),
(46, 1, 11, 'booked', '2024-11-16 04:19:03', '2024-11-16 10:04:03'),
(47, 1, 11, 'booked', '2024-11-16 04:23:20', '2024-11-16 10:08:20'),
(48, 1, 11, 'booked', '2024-11-16 04:30:24', '2024-11-16 10:15:24'),
(49, 1, 11, 'booked', '2024-11-16 04:44:40', 'ma'),
(50, 1, 11, 'booked', '2024-11-16 05:08:58', 'ee'),
(51, 2, 11, 'booked', '2024-11-16 05:15:45', 'le'),
(52, 2, 13, 'booked', '2024-11-16 07:26:28', 'la'),
(53, 1, 13, 'booked', '2024-11-16 07:30:09', 'mma'),
(54, 1, 13, 'booked', '2024-11-17 05:47:35', 'la'),
(55, 1, 13, 'booked', '2024-11-18 06:28:57', 'eee'),
(56, 1, 13, 'booked', '2024-11-18 06:31:53', 'me');

-- --------------------------------------------------------

--
-- Table structure for table `completed_matches`
--

CREATE TABLE `completed_matches` (
  `completed_match_id` int(11) NOT NULL,
  `arena_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `match_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `team_a_score` int(11) DEFAULT NULL,
  `team_b_score` int(11) DEFAULT NULL,
  `match_duration` time DEFAULT NULL,
  `result` varchar(50) DEFAULT NULL,
  `additional_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `completed_matches`
--

INSERT INTO `completed_matches` (`completed_match_id`, `arena_id`, `match_id`, `match_date`, `team_a_score`, `team_b_score`, `match_duration`, `result`, `additional_notes`) VALUES
(225, 1, 40, '2024-11-17 09:45:55', NULL, NULL, NULL, NULL, NULL),
(226, 1, 41, '2024-11-17 09:45:55', NULL, NULL, NULL, NULL, NULL),
(227, 2, 43, '2024-11-17 09:45:55', NULL, NULL, NULL, NULL, NULL),
(228, 1, 44, '2024-11-17 09:45:55', NULL, NULL, NULL, NULL, NULL),
(229, 1, 45, '2024-11-17 09:45:55', NULL, NULL, NULL, NULL, NULL),
(232, 1, 40, '2024-11-18 06:34:27', NULL, NULL, NULL, NULL, NULL),
(233, 1, 41, '2024-11-18 06:34:27', NULL, NULL, NULL, NULL, NULL),
(234, 2, 43, '2024-11-18 06:34:27', NULL, NULL, NULL, NULL, NULL),
(235, 1, 44, '2024-11-18 06:34:27', NULL, NULL, NULL, NULL, NULL),
(236, 1, 45, '2024-11-18 06:34:27', NULL, NULL, NULL, NULL, NULL),
(237, 1, 40, '2024-11-18 06:34:27', NULL, NULL, NULL, NULL, NULL),
(238, 1, 41, '2024-11-18 06:34:27', NULL, NULL, NULL, NULL, NULL),
(239, 2, 43, '2024-11-18 06:34:27', NULL, NULL, NULL, NULL, NULL),
(240, 1, 44, '2024-11-18 06:34:27', NULL, NULL, NULL, NULL, NULL),
(241, 1, 45, '2024-11-18 06:34:27', NULL, NULL, NULL, NULL, NULL),
(242, 1, 40, '2024-11-18 06:34:34', NULL, NULL, NULL, NULL, NULL),
(243, 1, 41, '2024-11-18 06:34:34', NULL, NULL, NULL, NULL, NULL),
(244, 2, 43, '2024-11-18 06:34:34', NULL, NULL, NULL, NULL, NULL),
(245, 1, 44, '2024-11-18 06:34:34', NULL, NULL, NULL, NULL, NULL),
(246, 1, 45, '2024-11-18 06:34:34', NULL, NULL, NULL, NULL, NULL),
(247, 1, 40, '2024-11-18 06:34:34', NULL, NULL, NULL, NULL, NULL),
(248, 1, 41, '2024-11-18 06:34:34', NULL, NULL, NULL, NULL, NULL),
(249, 2, 43, '2024-11-18 06:34:34', NULL, NULL, NULL, NULL, NULL),
(250, 1, 44, '2024-11-18 06:34:34', NULL, NULL, NULL, NULL, NULL),
(251, 1, 45, '2024-11-18 06:34:34', NULL, NULL, NULL, NULL, NULL),
(252, 1, 40, '2024-11-18 06:34:40', NULL, NULL, NULL, NULL, NULL),
(253, 1, 41, '2024-11-18 06:34:40', NULL, NULL, NULL, NULL, NULL),
(254, 2, 43, '2024-11-18 06:34:40', NULL, NULL, NULL, NULL, NULL),
(255, 1, 44, '2024-11-18 06:34:40', NULL, NULL, NULL, NULL, NULL),
(256, 1, 45, '2024-11-18 06:34:40', NULL, NULL, NULL, NULL, NULL),
(257, 1, 40, '2024-11-18 06:34:40', NULL, NULL, NULL, NULL, NULL),
(258, 1, 41, '2024-11-18 06:34:40', NULL, NULL, NULL, NULL, NULL),
(259, 2, 43, '2024-11-18 06:34:40', NULL, NULL, NULL, NULL, NULL),
(260, 1, 44, '2024-11-18 06:34:40', NULL, NULL, NULL, NULL, NULL),
(261, 1, 45, '2024-11-18 06:34:40', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `matchmaking`
--

CREATE TABLE `matchmaking` (
  `match_id` int(11) NOT NULL,
  `arena_id` int(11) DEFAULT NULL,
  `booking_datetime` datetime DEFAULT NULL,
  `match_creator_id` int(11) DEFAULT NULL,
  `player_count` int(11) DEFAULT 1,
  `max_players` int(11) DEFAULT 10,
  `status` enum('pending','lineups','inprogress','fulltime') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matchmaking`
--

INSERT INTO `matchmaking` (`match_id`, `arena_id`, `booking_datetime`, `match_creator_id`, `player_count`, `max_players`, `status`, `created_at`) VALUES
(40, 1, '2024-11-16 12:00:00', 11, 1, 10, 'fulltime', '2024-11-16 04:44:40'),
(41, 1, '2024-11-16 15:00:00', 11, 10, 10, 'fulltime', '2024-11-16 05:08:58'),
(43, 2, '2024-11-16 14:00:00', 13, 10, 10, 'fulltime', '2024-11-16 07:26:28'),
(44, 1, '2024-11-16 13:00:00', 13, 10, 10, 'fulltime', '2024-11-16 07:30:09'),
(45, 1, '2024-11-17 14:00:00', 13, 10, 10, 'fulltime', '2024-11-17 05:47:35'),
(46, 1, '2024-11-18 16:00:00', 13, 3, 10, 'pending', '2024-11-18 06:28:57'),
(47, 1, '2024-11-18 17:00:00', 13, 1, 10, 'pending', '2024-11-18 06:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `match_participants`
--

CREATE TABLE `match_participants` (
  `participant_id` int(11) NOT NULL,
  `match_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `match_participants`
--

INSERT INTO `match_participants` (`participant_id`, `match_id`, `user_id`, `joined_at`) VALUES
(85, 41, 11, '2024-11-16 07:13:27'),
(86, 41, 11, '2024-11-16 07:13:30'),
(87, 43, 13, '2024-11-16 07:26:28'),
(88, 43, 13, '2024-11-16 07:28:54'),
(89, 43, 13, '2024-11-16 07:29:19'),
(90, 43, 13, '2024-11-16 07:29:23'),
(91, 43, 13, '2024-11-16 07:30:09'),
(92, 43, 13, '2024-11-16 13:16:12'),
(93, 43, 13, '2024-11-16 13:16:20'),
(94, 43, 13, '2024-11-16 13:17:25'),
(95, 41, 13, '2024-11-16 13:17:30'),
(96, 41, 13, '2024-11-16 13:28:47'),
(97, 43, 13, '2024-11-16 19:04:03'),
(98, 43, 13, '2024-11-16 19:04:06'),
(99, 43, 13, '2024-11-16 19:04:09'),
(100, 41, 13, '2024-11-16 19:05:21'),
(101, 41, 13, '2024-11-16 19:05:24'),
(102, 41, 13, '2024-11-16 19:05:28'),
(103, 41, 13, '2024-11-16 19:05:34'),
(104, 41, 13, '2024-11-16 19:05:37'),
(105, 44, 13, '2024-11-17 05:45:57'),
(106, 44, 13, '2024-11-17 05:46:02'),
(107, 44, 13, '2024-11-17 05:46:06'),
(108, 44, 13, '2024-11-17 05:46:11'),
(109, 44, 13, '2024-11-17 05:46:13'),
(110, 44, 13, '2024-11-17 05:46:17'),
(111, 44, 13, '2024-11-17 05:46:20'),
(112, 44, 13, '2024-11-17 05:46:23'),
(113, 44, 13, '2024-11-17 05:46:26'),
(114, 43, 13, '2024-11-17 05:47:35'),
(115, 45, 13, '2024-11-17 05:47:47'),
(116, 45, 13, '2024-11-17 05:47:52'),
(117, 45, 13, '2024-11-17 05:47:57'),
(118, 45, 13, '2024-11-17 05:48:02'),
(119, 45, 13, '2024-11-17 05:48:05'),
(120, 45, 13, '2024-11-17 05:48:09'),
(121, 45, 13, '2024-11-17 05:48:13'),
(122, 45, 13, '2024-11-17 05:48:17'),
(123, 45, 13, '2024-11-17 05:48:21'),
(124, 43, 13, '2024-11-18 06:28:57'),
(125, 43, 13, '2024-11-18 06:31:53'),
(126, 46, 13, '2024-11-18 06:34:33'),
(127, 46, 13, '2024-11-18 06:34:39');

-- --------------------------------------------------------

--
-- Table structure for table `player_match_stats`
--

CREATE TABLE `player_match_stats` (
  `stat_id` int(11) NOT NULL,
  `completed_match_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `rating_id` int(11) NOT NULL,
  `goals` int(11) DEFAULT 0,
  `updated_elo` int(11) NOT NULL DEFAULT 600,
  `assists` int(11) DEFAULT 0,
  `fouls` int(11) DEFAULT 0,
  `performance_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `player_profiles`
--

CREATE TABLE `player_profiles` (
  `player_id` int(11) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `preferred_position` enum('goalkeeper','defender','midfielder','forward') DEFAULT NULL,
  `team_affiliation` varchar(100) DEFAULT NULL,
  `elo` int(11) NOT NULL DEFAULT 600,
  `games_played` int(11) DEFAULT 0,
  `wins` int(11) DEFAULT 0,
  `losses` int(11) DEFAULT 0,
  `availability` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `player_ranking` enum('beginner','amateur','pro') NOT NULL DEFAULT 'beginner'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player_profiles`
--

INSERT INTO `player_profiles` (`player_id`, `age`, `location`, `preferred_position`, `team_affiliation`, `elo`, `games_played`, `wins`, `losses`, `availability`, `bio`, `created_at`, `updated_at`, `user_id`, `player_ranking`) VALUES
(1, 14, 'thamel', 'goalkeeper', NULL, 1000, 0, 0, 0, NULL, 'this is me', '2024-11-13 03:28:13', '2024-11-13 13:01:27', 1, 'pro'),
(3, 15, 'sorakhutte', 'goalkeeper', NULL, 600, 0, 0, 0, NULL, 'sasaasa', '2024-11-14 02:29:46', '2024-11-14 02:29:46', 11, 'beginner'),
(4, 15, 'nayabazaar', 'goalkeeper', NULL, 600, 0, 0, 0, NULL, 'this is suman', '2024-11-14 02:52:45', '2024-11-14 02:52:45', 13, 'beginner');

-- --------------------------------------------------------

--
-- Table structure for table `player_ratings`
--

CREATE TABLE `player_ratings` (
  `id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `elo_points` int(11) NOT NULL,
  `matches_played` int(11) DEFAULT 0,
  `wins` int(11) DEFAULT 0,
  `losses` int(11) DEFAULT 0,
  `win_rate` decimal(5,2) GENERATED ALWAYS AS (case when `matches_played` > 0 then `wins` / `matches_played` * 100 else 0 end) STORED,
  `highest_elo` int(11) DEFAULT NULL,
  `lowest_elo` int(11) DEFAULT NULL,
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating_values`
--

CREATE TABLE `rating_values` (
  `rating_id` int(11) NOT NULL,
  `rating_category` varchar(20) NOT NULL,
  `points_adjustment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating_values`
--

INSERT INTO `rating_values` (`rating_id`, `rating_category`, `points_adjustment`) VALUES
(1, 'Beginner', -100),
(2, 'Amateur', 100),
(3, 'Pro', 200);

-- --------------------------------------------------------

--
-- Table structure for table `referee`
--

CREATE TABLE `referee` (
  `referee_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('assigned','unassigned') DEFAULT 'unassigned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `referee`
--

INSERT INTO `referee` (`referee_id`, `username`, `password`, `email`, `created_at`, `updated_at`, `status`) VALUES
(1, 'referee1', '420p420p420p', 'referee1@example.com', '2024-11-16 18:41:45', '2024-11-16 18:41:45', 'unassigned'),
(2, 'referee2', '420p420p420p', 'referee2@example.com', '2024-11-16 18:41:45', '2024-11-16 18:41:45', 'unassigned'),
(3, 'referee3', '420p420p420p', 'referee3@example.com', '2024-11-16 18:41:45', '2024-11-16 18:41:45', 'unassigned'),
(4, 'referee4', '420p420p420p', 'referee4@example.com', '2024-11-16 18:41:45', '2024-11-16 18:41:45', 'unassigned');

-- --------------------------------------------------------

--
-- Table structure for table `referee_matches`
--

CREATE TABLE `referee_matches` (
  `id` int(11) NOT NULL,
  `referee_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `referee_matches`
--

INSERT INTO `referee_matches` (`id`, `referee_id`, `match_id`, `assigned_at`) VALUES
(1, 1, 45, '2024-11-17 05:48:21');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(100) NOT NULL,
  `passkey` varchar(255) NOT NULL,
  `team_description` text DEFAULT NULL,
  `team_logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'prabuddhashreshta', 'prabud@gmail.com', '$2y$10$rEpK40pk/W4Vug98h7ynzuI23YJVL75Vxrw0HI0sqE9yLmXpQBNDi', '2024-11-10 07:10:28'),
(4, 'prabuddha', 'p@gmail.com', '$2y$10$ZPTXeRWb9RpR/ik9RUPGSOlSp/ZAqwiVDkDkx6Y7.rkPNeAq0CGWW', '2024-11-10 10:17:52'),
(10, 'prabuddhashreshta1', 'p1@gmail.com', '$2y$10$x4dpQCtFRYedpiZQPpwaA.eIKWe3we4NBrkplnibVOo//QMUmoiH6', '2024-11-10 10:49:56'),
(11, 'bibekhadkhale', 'bibek@gmail.com', '$2y$10$SbF2V4Fvw7b0IvZt7XYoYuGRxofEst2BR1VFnTf.4qHvKIB9QbT6u', '2024-11-14 01:03:02'),
(13, 'suman', 'suman@gmail.com', '$2y$10$L2dZLye10InbqA8iHMy71OalhuBpZVqfevydxIlvxBvXEnVvpj.06', '2024-11-14 02:40:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arenas`
--
ALTER TABLE `arenas`
  ADD PRIMARY KEY (`arena_id`);

--
-- Indexes for table `arena_bookings`
--
ALTER TABLE `arena_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_arena` (`arena_id`),
  ADD KEY `fk_player` (`player_id`);

--
-- Indexes for table `completed_matches`
--
ALTER TABLE `completed_matches`
  ADD PRIMARY KEY (`completed_match_id`),
  ADD KEY `fk_match_id` (`match_id`);

--
-- Indexes for table `matchmaking`
--
ALTER TABLE `matchmaking`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `arena_id` (`arena_id`),
  ADD KEY `match_creator_id` (`match_creator_id`);

--
-- Indexes for table `match_participants`
--
ALTER TABLE `match_participants`
  ADD PRIMARY KEY (`participant_id`),
  ADD KEY `match_id` (`match_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `player_match_stats`
--
ALTER TABLE `player_match_stats`
  ADD PRIMARY KEY (`stat_id`),
  ADD KEY `completed_match_id` (`completed_match_id`),
  ADD KEY `player_id` (`player_id`),
  ADD KEY `fk_rating_id` (`rating_id`);

--
-- Indexes for table `player_profiles`
--
ALTER TABLE `player_profiles`
  ADD PRIMARY KEY (`player_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `player_ratings`
--
ALTER TABLE `player_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- Indexes for table `rating_values`
--
ALTER TABLE `rating_values`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `referee`
--
ALTER TABLE `referee`
  ADD PRIMARY KEY (`referee_id`);

--
-- Indexes for table `referee_matches`
--
ALTER TABLE `referee_matches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referee_id` (`referee_id`),
  ADD KEY `match_id` (`match_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arenas`
--
ALTER TABLE `arenas`
  MODIFY `arena_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `arena_bookings`
--
ALTER TABLE `arena_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `completed_matches`
--
ALTER TABLE `completed_matches`
  MODIFY `completed_match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT for table `matchmaking`
--
ALTER TABLE `matchmaking`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `match_participants`
--
ALTER TABLE `match_participants`
  MODIFY `participant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `player_match_stats`
--
ALTER TABLE `player_match_stats`
  MODIFY `stat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `player_profiles`
--
ALTER TABLE `player_profiles`
  MODIFY `player_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `player_ratings`
--
ALTER TABLE `player_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rating_values`
--
ALTER TABLE `rating_values`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `referee`
--
ALTER TABLE `referee`
  MODIFY `referee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `referee_matches`
--
ALTER TABLE `referee_matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `completed_matches`
--
ALTER TABLE `completed_matches`
  ADD CONSTRAINT `fk_match_id` FOREIGN KEY (`match_id`) REFERENCES `matchmaking` (`match_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `matchmaking`
--
ALTER TABLE `matchmaking`
  ADD CONSTRAINT `matchmaking_ibfk_1` FOREIGN KEY (`arena_id`) REFERENCES `arenas` (`arena_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matchmaking_ibfk_2` FOREIGN KEY (`match_creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `match_participants`
--
ALTER TABLE `match_participants`
  ADD CONSTRAINT `match_participants_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `matchmaking` (`match_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `match_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `player_match_stats`
--
ALTER TABLE `player_match_stats`
  ADD CONSTRAINT `fk_rating_id` FOREIGN KEY (`rating_id`) REFERENCES `rating_values` (`rating_id`),
  ADD CONSTRAINT `player_match_stats_ibfk_1` FOREIGN KEY (`completed_match_id`) REFERENCES `completed_matches` (`completed_match_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `player_match_stats_ibfk_2` FOREIGN KEY (`player_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `player_profiles`
--
ALTER TABLE `player_profiles`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `player_ratings`
--
ALTER TABLE `player_ratings`
  ADD CONSTRAINT `player_ratings_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `player_profiles` (`player_id`) ON DELETE CASCADE;

--
-- Constraints for table `referee_matches`
--
ALTER TABLE `referee_matches`
  ADD CONSTRAINT `referee_matches_ibfk_1` FOREIGN KEY (`referee_id`) REFERENCES `referee` (`referee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `referee_matches_ibfk_2` FOREIGN KEY (`match_id`) REFERENCES `matchmaking` (`match_id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `update_matchmaking_status` ON SCHEDULE EVERY 10 MINUTE STARTS '2024-11-13 14:51:04' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE matchmaking
  SET status = 'fulltime'
  WHERE status = 'inprogress' 
    AND TIMESTAMPDIFF(MINUTE, status_updated_at, NOW()) >= 60$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
