-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 04:51 PM
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
(57, 1, 13, 'booked', '2024-11-19 18:08:41', 'em'),
(58, 1, 4, 'booked', '2024-11-20 05:01:33', 'mm'),
(59, 2, 13, 'booked', '2024-11-20 08:06:37', 'em'),
(60, 1, 13, 'booked', '2024-11-20 08:10:42', 'ee'),
(61, 1, 20, 'booked', '2024-11-20 08:21:51', 'mme');

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

-- --------------------------------------------------------

--
-- Table structure for table `completed_match_participants`
--

CREATE TABLE `completed_match_participants` (
  `completed_match_participant_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(52, 1, '2024-11-20 18:00:00', 20, 10, 10, 'lineups', '2024-11-20 08:21:51');

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
(156, 52, 20, '2024-11-20 08:21:51'),
(157, 52, 16, '2024-11-20 08:22:31'),
(158, 52, 21, '2024-11-20 08:23:24'),
(159, 52, 17, '2024-11-20 08:23:40'),
(160, 52, 4, '2024-11-20 08:23:54'),
(161, 52, 22, '2024-11-20 08:24:06'),
(162, 52, 15, '2024-11-20 08:24:18'),
(163, 52, 19, '2024-11-20 08:24:30'),
(164, 52, 18, '2024-11-20 08:24:47'),
(165, 52, 13, '2024-11-20 08:25:25');

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
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `player_ranking` enum('beginner','amateur','pro') NOT NULL DEFAULT 'beginner',
  `avaibility` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player_profiles`
--

INSERT INTO `player_profiles` (`player_id`, `age`, `location`, `preferred_position`, `team_affiliation`, `elo`, `games_played`, `wins`, `losses`, `bio`, `created_at`, `updated_at`, `user_id`, `player_ranking`, `avaibility`) VALUES
(1, 14, 'thamel', 'goalkeeper', NULL, 1000, 0, 0, 0, 'this is me', '2024-11-13 03:28:13', '2024-11-13 13:01:27', 1, 'pro', ''),
(3, 15, 'sorakhutte', 'goalkeeper', NULL, 600, 0, 0, 0, 'sasaasa', '2024-11-14 02:29:46', '2024-11-14 02:29:46', 11, 'beginner', ''),
(4, 15, 'nayabazaar', 'goalkeeper', NULL, 600, 0, 0, 0, 'this is suman', '2024-11-14 02:52:45', '2024-11-14 02:52:45', 13, 'beginner', ''),
(5, 18, 'thamel', 'defender', NULL, 600, 0, 0, 0, 'asasa', '2024-11-18 16:58:23', '2024-11-18 16:58:23', 4, 'beginner', ''),
(6, 23, 'tarakeswor', 'goalkeeper', NULL, 600, 0, 0, 0, 'sasasa', '2024-11-19 18:20:02', '2024-11-19 18:20:02', 15, 'beginner', ''),
(7, 16, 'samakhusi', 'midfielder', NULL, 600, 0, 0, 0, 'sadsasa', '2024-11-19 18:24:28', '2024-11-19 18:24:28', 17, 'beginner', ''),
(8, 23, 'baneshwor', 'forward', NULL, 600, 0, 0, 0, 'sdd', '2024-11-19 18:25:25', '2024-11-19 18:25:25', 16, 'beginner', ''),
(9, 25, 'saano bharang', 'midfielder', NULL, 600, 0, 0, 0, 'qq', '2024-11-19 18:26:36', '2024-11-19 18:26:36', 18, 'beginner', ''),
(10, 21, 'thulo bharang', 'forward', NULL, 600, 0, 0, 0, 'v', '2024-11-19 18:27:55', '2024-11-19 18:27:55', 19, 'beginner', ''),
(11, 23, 'townplanning', 'goalkeeper', NULL, 600, 0, 0, 0, 'qqq', '2024-11-19 18:28:58', '2024-11-19 18:28:58', 20, 'beginner', ''),
(12, 22, 'bouddha', 'defender', NULL, 600, 0, 0, 0, 'ff', '2024-11-19 18:30:43', '2024-11-19 18:30:43', 21, 'beginner', ''),
(13, 22, 'sorakhutte', 'goalkeeper', NULL, 600, 0, 0, 0, 'r', '2024-11-19 18:32:34', '2024-11-19 18:32:34', 22, 'beginner', '');

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
(3, 1, 52, '2024-11-20 08:25:25');

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
(13, 'suman', 'suman@gmail.com', '$2y$10$L2dZLye10InbqA8iHMy71OalhuBpZVqfevydxIlvxBvXEnVvpj.06', '2024-11-14 02:40:30'),
(15, 'prasanna', 'prasanna@gmail.com', '$2y$10$Uuk.C8xBLSalpPEUdnCwpuBUOYaGa92aBS.cLSyhNjaRL0q8VPcmi', '2024-11-19 18:17:39'),
(16, 'denny', 'denny@gmail.com', '$2y$10$otMpaOiUeHTMdtt/.HVSAOvf5.HYaaoredy2KPkhB0MboE45qXCl.', '2024-11-19 18:22:13'),
(17, 'manjil', 'manjil@gmail.com', '$2y$10$JH23QQk2Q0B8tAZa4NrWcO9FweqIlwsCzXwQYPM.yYQ0qlJqmtsHy', '2024-11-19 18:23:43'),
(18, 'aswikar', 'aswikar@gmail.com', '$2y$10$w9DvvWPEb3PZyjV2F9JTau1GwBv1W/lnYvD4PXr48na7DL1sHlaM2', '2024-11-19 18:25:57'),
(19, 'shisir', 'shisir@gmail.com', '$2y$10$srfda.FzQPmmFVwHMqQg/.SZm3VhgVUfBStLMgABBAbodrTgIt33G', '2024-11-19 18:27:22'),
(20, 'bipin', 'bipin@gmail.com', '$2y$10$neCv6W7c9BtrH1ASccocaOsZDH50VDL1irJ3ts1n31p0vNArUOSmW', '2024-11-19 18:28:32'),
(21, 'kiran', 'kiran@gmail.com', '$2y$10$X23BKmbEHSsFoiOLtoyNqOKuDOwObqsCNuQWyb0sd3/JOEv2eSz36', '2024-11-19 18:30:17'),
(22, 'pramit', 'pramit@gmail.com', '$2y$10$iVwRrRxj2/DOHd0efBVQGOJgbDPiV61CkTK8p2k93DzYVxo2UTfey', '2024-11-19 18:32:06');

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
-- Indexes for table `completed_match_participants`
--
ALTER TABLE `completed_match_participants`
  ADD PRIMARY KEY (`completed_match_participant_id`),
  ADD KEY `completed_match_participants_ibfk_1` (`user_id`),
  ADD KEY `completed_match_participants_ibfk_2` (`match_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `completed_matches`
--
ALTER TABLE `completed_matches`
  MODIFY `completed_match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=320;

--
-- AUTO_INCREMENT for table `completed_match_participants`
--
ALTER TABLE `completed_match_participants`
  MODIFY `completed_match_participant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `matchmaking`
--
ALTER TABLE `matchmaking`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `match_participants`
--
ALTER TABLE `match_participants`
  MODIFY `participant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `player_match_stats`
--
ALTER TABLE `player_match_stats`
  MODIFY `stat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `player_profiles`
--
ALTER TABLE `player_profiles`
  MODIFY `player_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `completed_matches`
--
ALTER TABLE `completed_matches`
  ADD CONSTRAINT `fk_match_id` FOREIGN KEY (`match_id`) REFERENCES `matchmaking` (`match_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `completed_match_participants`
--
ALTER TABLE `completed_match_participants`
  ADD CONSTRAINT `completed_match_participants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `player_profiles` (`user_id`),
  ADD CONSTRAINT `completed_match_participants_ibfk_2` FOREIGN KEY (`match_id`) REFERENCES `completed_matches` (`match_id`) ON DELETE NO ACTION;

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
