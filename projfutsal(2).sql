-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2025 at 04:01 PM
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
(1, 'kumari', 'kathmandu', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.108541057246!2d85.30554127514783!3d27.71393482520147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb18fb7ea82b97%3A0x533a5f813eec590f!2sKumari%20Futsal!5e0!3m2!1sen!2snp!4v17', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxMTEhUTExMWFRUXGBcYGBgYGRsfHhoYFxgaHx8YGBgYHSggGBolGxgXIjEhJSsrLi8uGyAzODMtNygtLisBCgoKDg0OGhAQGy0lHSUtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS01Lf/AABEIAMMBAwMBIgACEQEDEQH/', 'booked', '349835', 12000.00, '2024-11-11 05:37:58', '2024-12-10 05:02:55'),
(2, 'vajra futsal', 'Sorakhutte', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.141893267904!2d85.29791957514783!3d27.71290492524688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb18f11b5a5e21%3A0xa5894f920b45e7ae!2sVajra%20Futsal!5e0!3m2!1sen!2snp!4v173', 'a', 'unbooked', '986667577', 120.00, '2024-11-11 07:04:34', '2024-12-10 05:04:10'),
(3, 'Kalanki', 'Kathmandu', '', 'uploads/6757ca9e19ca5_futsalarenaimg1.jpg', 'booked', '9811111111', 120.00, '2024-12-10 04:59:10', '2024-12-10 07:06:31'),
(4, 'Patan Futsal', 'Patan', 'ww', 'uploads/6757cae180147_futsalarenaimg2.jpg', 'booked', '9811222222', 130.00, '2024-12-10 05:00:17', '2024-12-10 05:00:17'),
(5, 'Gongabu Futsal', 'Kathmandu', 'ww', 'uploads/6757cb0e69a39_futsalarenaimg3.jpg', 'booked', '9833444444', 110.00, '2024-12-10 05:01:02', '2024-12-10 05:01:02');

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
(133, 1, 18, 'booked', '2025-01-14 08:04:02', 'la'),
(134, 2, 54, 'booked', '2025-01-14 08:12:33', 'ee'),
(135, 1, 18, 'booked', '2025-01-14 08:16:13', 'le'),
(136, 1, 54, 'booked', '2025-01-14 08:38:39', 'ee'),
(137, 1, 18, 'booked', '2025-02-01 14:49:39', 'em');

-- --------------------------------------------------------

--
-- Table structure for table `completed_matches`
--

CREATE TABLE `completed_matches` (
  `completed_match_id` int(11) NOT NULL,
  `arena_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `match_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `team_a_score` int(11) DEFAULT 0,
  `team_b_score` int(11) DEFAULT 0,
  `match_duration` time DEFAULT NULL,
  `result` varchar(50) DEFAULT NULL,
  `additional_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `completed_matches`
--

INSERT INTO `completed_matches` (`completed_match_id`, `arena_id`, `match_id`, `match_date`, `team_a_score`, `team_b_score`, `match_duration`, `result`, `additional_notes`) VALUES
(359, 1, 53, '2024-11-21 01:36:39', NULL, NULL, NULL, NULL, NULL),
(365, 1, 53, '2024-11-22 13:30:09', 1, 1, NULL, NULL, NULL),
(366, 1, 53, '2024-11-22 13:31:23', 0, 2, NULL, NULL, NULL),
(367, 1, 57, '2024-11-23 07:11:25', 2, 0, NULL, NULL, NULL),
(368, 1, 58, '2024-11-23 08:23:13', 0, 0, NULL, NULL, NULL),
(369, 1, 59, '2024-11-23 08:37:41', 10, 5, NULL, 'prabuddhashreshta', NULL),
(370, 1, 67, '2024-12-02 11:11:57', 0, 0, NULL, 'draw', NULL),
(371, 1, 68, '2024-12-02 12:22:15', 10, 5, NULL, 'shisir', NULL),
(372, 2, 72, '2024-12-03 15:57:12', 3, 5, NULL, 'manjil', NULL),
(373, 2, 80, '2024-12-04 07:55:40', 5, 7, NULL, 'prabuddha', NULL),
(374, 1, 90, '2024-12-07 21:40:48', 5, 2, NULL, 'nccs9', NULL),
(375, 1, 107, '2024-12-09 10:34:22', 5, 4, NULL, 'kiran', NULL),
(376, 2, 111, '2024-12-10 04:33:32', 5, 10, NULL, 'prasanna', NULL),
(377, 3, 113, '2024-12-10 00:26:14', 0, 0, NULL, NULL, NULL),
(378, 4, 119, '2024-12-10 01:15:11', 0, 0, NULL, NULL, NULL),
(379, 3, 115, '2024-12-10 09:28:56', 0, 0, NULL, 'draw', NULL),
(380, 3, 121, '2024-12-10 09:28:56', 0, 0, NULL, NULL, NULL),
(381, 2, 120, '2025-01-14 08:01:27', 0, 0, NULL, NULL, NULL),
(382, 3, 122, '2025-01-14 08:01:28', 0, 0, NULL, 'draw', NULL),
(383, 1, 125, '2025-01-15 06:34:54', 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `completed_match_participants`
--

CREATE TABLE `completed_match_participants` (
  `completed_match_participant_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `team_name` varchar(255) NOT NULL DEFAULT 'team not assigned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `completed_match_participants`
--

INSERT INTO `completed_match_participants` (`completed_match_participant_id`, `user_id`, `match_id`, `joined_at`, `team_name`) VALUES
(70, 1, 59, '2024-11-23 08:41:14', 'prabuddhashreshta'),
(71, 18, 59, '2024-11-23 08:41:14', 'shisir'),
(72, 20, 59, '2024-11-23 08:41:14', 'shisir'),
(73, 16, 59, '2024-11-23 08:41:14', 'shisir'),
(74, 21, 59, '2024-11-23 08:41:14', 'prabuddhashreshta'),
(75, 4, 59, '2024-11-23 08:41:14', 'prabuddhashreshta'),
(76, 22, 59, '2024-11-23 08:41:14', 'prabuddhashreshta'),
(77, 15, 59, '2024-11-23 08:41:14', 'shisir'),
(78, 19, 59, '2024-11-23 08:41:14', 'shisir'),
(79, 13, 59, '2024-11-23 08:41:14', 'prabuddhashreshta'),
(80, 18, 53, '2024-12-02 07:39:57', 'not assigned a team'),
(81, 18, 53, '2024-12-02 07:40:00', 'not assigned a team'),
(82, 18, 53, '2024-12-02 07:40:01', 'not assigned a team'),
(83, 18, 53, '2024-12-02 07:40:02', 'not assigned a team'),
(84, 18, 53, '2024-12-02 07:40:06', 'not assigned a team'),
(85, 18, 53, '2024-12-02 07:54:19', 'not assigned a team'),
(86, 1, 59, '2024-12-02 08:06:06', 'prabuddhashreshta'),
(87, 18, 59, '2024-12-02 08:06:06', 'shisir'),
(88, 20, 59, '2024-12-02 08:06:06', 'shisir'),
(89, 16, 59, '2024-12-02 08:06:06', 'shisir'),
(90, 21, 59, '2024-12-02 08:06:06', 'prabuddhashreshta'),
(91, 4, 59, '2024-12-02 08:06:06', 'prabuddhashreshta'),
(92, 22, 59, '2024-12-02 08:06:06', 'prabuddhashreshta'),
(93, 15, 59, '2024-12-02 08:06:06', 'shisir'),
(94, 19, 59, '2024-12-02 08:06:06', 'shisir'),
(95, 13, 59, '2024-12-02 08:06:06', 'prabuddhashreshta'),
(97, 18, 53, '2024-12-02 11:11:57', 'not assigned a team'),
(98, 16, 68, '2024-12-02 12:22:15', 'shisir'),
(99, 21, 68, '2024-12-02 12:22:15', 'shisir'),
(100, 17, 68, '2024-12-02 12:22:15', 'nccs1'),
(101, 4, 68, '2024-12-02 12:22:15', 'nccs1'),
(102, 22, 68, '2024-12-02 12:22:15', 'shisir'),
(103, 15, 68, '2024-12-02 12:22:15', 'nccs1'),
(104, 19, 68, '2024-12-02 12:22:15', 'shisir'),
(105, 23, 68, '2024-12-02 12:22:15', 'nccs1'),
(106, 20, 68, '2024-12-02 12:22:15', 'shisir'),
(107, 20, 57, '2024-12-02 12:24:11', 'not assigned a team'),
(108, 18, 53, '2024-12-03 08:46:45', 'not assigned a team'),
(109, 23, 72, '2024-12-03 15:57:12', 'nccs1'),
(110, 18, 72, '2024-12-03 15:57:12', 'manjil'),
(111, 16, 72, '2024-12-03 15:57:12', 'manjil'),
(112, 17, 72, '2024-12-03 15:57:12', 'manjil'),
(113, 4, 72, '2024-12-03 15:57:12', 'nccs1'),
(114, 22, 72, '2024-12-03 15:57:13', 'nccs1'),
(115, 19, 72, '2024-12-03 15:57:13', 'nccs1'),
(116, 13, 72, '2024-12-03 15:57:13', 'manjil'),
(117, 20, 72, '2024-12-03 15:57:13', 'nccs1'),
(118, 1, 72, '2024-12-03 15:57:13', 'manjil'),
(119, 18, 53, '2024-12-04 04:49:30', 'not assigned a team'),
(120, 20, 57, '2024-12-04 04:50:59', 'not assigned a team'),
(121, 13, 67, '2024-12-04 07:55:40', 'not assigned a team'),
(122, 16, 80, '2024-12-04 07:55:40', 'denny'),
(123, 18, 80, '2024-12-04 07:55:40', 'prabuddha'),
(124, 20, 80, '2024-12-04 07:55:40', 'denny'),
(125, 21, 80, '2024-12-04 07:55:40', 'prabuddha'),
(126, 17, 80, '2024-12-04 07:55:40', 'denny'),
(127, 23, 80, '2024-12-04 07:55:40', 'denny'),
(128, 4, 80, '2024-12-04 07:55:40', 'prabuddha'),
(129, 1, 80, '2024-12-04 07:55:40', 'prabuddha'),
(130, 22, 80, '2024-12-04 07:55:40', 'prabuddha'),
(131, 19, 80, '2024-12-04 07:55:40', 'denny'),
(132, 13, 67, '2024-12-04 19:04:11', 'not assigned a team'),
(133, 20, 57, '2024-12-04 19:05:57', 'not assigned a team'),
(134, 18, 53, '2024-12-06 05:55:01', 'not assigned a team'),
(135, 20, 57, '2024-12-06 06:13:26', 'not assigned a team'),
(136, 18, 53, '2024-12-06 06:16:39', 'not assigned a team'),
(137, 52, 90, '2024-12-07 21:40:48', 'nccs9'),
(138, 18, 90, '2024-12-07 21:40:48', 'nccs9'),
(139, 20, 90, '2024-12-07 21:40:48', 'bipin'),
(140, 16, 90, '2024-12-07 21:40:48', 'bipin'),
(141, 17, 90, '2024-12-07 21:40:48', 'nccs9'),
(142, 23, 90, '2024-12-07 21:40:48', 'bipin'),
(143, 49, 90, '2024-12-07 21:40:48', 'nccs9'),
(144, 4, 90, '2024-12-07 21:40:48', 'bipin'),
(145, 22, 90, '2024-12-07 21:40:48', 'bipin'),
(146, 15, 90, '2024-12-07 21:40:48', 'nccs9'),
(147, 18, 53, '2024-12-08 01:04:17', 'not assigned a team'),
(149, 16, 80, '2024-12-08 01:04:17', 'not assigned a team'),
(150, 19, 58, '2024-12-08 01:19:58', 'not assigned a team'),
(152, 13, 67, '2024-12-08 01:19:58', 'not assigned a team'),
(153, 18, 53, '2024-12-08 19:54:08', 'not assigned a team'),
(154, 20, 57, '2024-12-08 19:54:08', 'not assigned a team'),
(155, 13, 67, '2024-12-08 19:54:08', 'not assigned a team'),
(156, 21, 107, '2024-12-09 10:34:22', 'kiran'),
(157, 22, 107, '2024-12-09 10:34:22', 'kiran'),
(158, 18, 107, '2024-12-09 10:34:22', 'suman'),
(159, 16, 107, '2024-12-09 10:34:22', 'suman'),
(160, 17, 107, '2024-12-09 10:34:22', 'suman'),
(161, 23, 107, '2024-12-09 10:34:22', 'suman'),
(162, 49, 107, '2024-12-09 10:34:22', 'kiran'),
(163, 51, 107, '2024-12-09 10:34:22', 'kiran'),
(164, 19, 107, '2024-12-09 10:34:22', 'kiran'),
(165, 13, 107, '2024-12-09 10:34:22', 'suman'),
(166, 18, 53, '2024-12-10 01:22:52', 'not assigned a team'),
(167, 20, 111, '2024-12-10 04:33:32', 'manjil'),
(168, 21, 111, '2024-12-10 04:33:32', 'prasanna'),
(169, 18, 111, '2024-12-10 04:33:32', 'manjil'),
(170, 17, 111, '2024-12-10 04:33:32', 'manjil'),
(171, 4, 111, '2024-12-10 04:33:32', 'prasanna'),
(172, 23, 111, '2024-12-10 04:33:32', 'prasanna'),
(173, 49, 111, '2024-12-10 04:33:32', 'manjil'),
(174, 13, 111, '2024-12-10 04:33:32', 'prasanna'),
(175, 15, 111, '2024-12-10 04:33:32', 'prasanna'),
(176, 55, 113, '2024-12-10 00:26:14', 'not assigned a team'),
(177, 18, 122, '2025-01-14 08:01:28', 'suman'),
(178, 20, 122, '2025-01-14 08:01:28', 'suman'),
(179, 16, 122, '2025-01-14 08:01:28', 'suman'),
(180, 21, 122, '2025-01-14 08:01:28', 'prabuddha'),
(181, 17, 122, '2025-01-14 08:01:28', 'prabuddha'),
(182, 4, 122, '2025-01-14 08:01:28', 'prabuddha'),
(183, 22, 122, '2025-01-14 08:01:28', 'prabuddha'),
(184, 15, 122, '2025-01-14 08:01:28', 'prabuddha'),
(185, 19, 122, '2025-01-14 08:01:28', 'suman'),
(186, 13, 122, '2025-01-14 08:01:28', 'suman'),
(187, 18, 125, '2025-01-15 06:34:54', 'shisir'),
(188, 20, 125, '2025-01-15 06:34:54', 'suman'),
(189, 16, 125, '2025-01-15 06:34:54', 'shisir'),
(190, 21, 125, '2025-01-15 06:34:54', 'suman'),
(191, 4, 125, '2025-01-15 06:34:54', 'suman'),
(192, 1, 125, '2025-01-15 06:34:54', 'shisir'),
(193, 22, 125, '2025-01-15 06:34:54', 'shisir'),
(194, 15, 125, '2025-01-15 06:34:54', 'suman'),
(195, 19, 125, '2025-01-15 06:34:54', 'shisir'),
(196, 13, 125, '2025-01-15 06:34:54', 'suman');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `status` enum('pending','accepted','blocked') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `status`, `created_at`) VALUES
(1, 1, 17, 'accepted', '2024-11-25 21:29:48'),
(2, 1, 21, 'accepted', '2024-11-25 21:39:00'),
(3, 1, 22, 'pending', '2024-11-25 22:50:41'),
(4, 1, 15, 'accepted', '2024-11-25 22:56:41'),
(5, 13, 15, 'accepted', '2024-11-25 23:02:45');

-- --------------------------------------------------------

--
-- Table structure for table `friend_activities`
--

CREATE TABLE `friend_activities` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` enum('added','removed','blocked','unblocked') NOT NULL,
  `target_user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `request_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `status` enum('pending','rejected','accepted') DEFAULT 'pending',
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `responded_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`request_id`, `sender_id`, `receiver_id`, `status`, `sent_at`, `responded_at`) VALUES
(1, 1, 21, 'accepted', '2024-11-25 21:39:00', NULL),
(2, 1, 22, 'pending', '2024-11-25 22:50:41', NULL),
(3, 1, 15, 'accepted', '2024-11-25 22:56:41', NULL),
(4, 13, 15, 'accepted', '2024-11-25 23:02:45', NULL);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `player_ranking` varchar(255) NOT NULL DEFAULT 'beginner'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matchmaking`
--

INSERT INTO `matchmaking` (`match_id`, `arena_id`, `booking_datetime`, `match_creator_id`, `player_count`, `max_players`, `status`, `created_at`, `player_ranking`) VALUES
(53, 1, '2024-11-20 09:00:00', 18, 10, 10, 'fulltime', '2024-11-20 18:07:34', 'beginner'),
(57, 1, '2024-11-22 11:00:00', 20, 10, 10, 'fulltime', '2024-11-22 11:44:02', 'beginner'),
(58, 1, '2024-11-23 12:00:00', 19, 10, 10, 'fulltime', '2024-11-23 08:15:10', 'beginner'),
(59, 1, '2024-11-23 13:00:00', 1, 10, 10, 'fulltime', '2024-11-23 08:30:50', 'beginner'),
(67, 1, '2024-12-02 07:00:00', 13, 10, 10, 'fulltime', '2024-12-02 08:42:05', 'beginner'),
(68, 1, '2024-12-02 17:00:00', 18, 10, 10, 'fulltime', '2024-12-02 11:11:02', 'beginner'),
(72, 2, '2024-12-03 15:00:00', 23, 10, 10, 'fulltime', '2024-12-03 08:47:49', 'beginner'),
(80, 2, '2024-12-04 14:00:00', 16, 10, 10, 'fulltime', '2024-12-04 05:50:45', 'beginner'),
(90, 1, '2024-12-08 07:00:00', 52, 10, 10, 'fulltime', '2024-12-07 21:25:38', 'beginner'),
(107, 1, '2024-12-09 19:00:00', 21, 10, 10, 'fulltime', '2024-12-08 19:54:30', 'beginner'),
(111, 2, '2024-12-10 14:00:00', 20, 9, 10, 'fulltime', '2024-12-09 23:34:47', 'amateur'),
(113, 3, '2024-12-10 13:00:00', 55, 1, 10, 'fulltime', '2024-12-10 06:58:27', 'beginner'),
(115, 3, '2024-12-10 14:00:00', 20, 10, 10, 'fulltime', '2024-12-10 07:00:26', 'amateur'),
(119, 4, '2024-12-10 07:00:00', 18, 10, 10, 'fulltime', '2024-12-10 00:59:48', 'amateur'),
(120, 2, '2024-12-10 15:00:00', 18, 10, 10, 'fulltime', '2024-12-10 01:14:07', 'amateur'),
(121, 3, '2024-12-10 10:00:00', 18, 10, 10, 'fulltime', '2024-12-10 02:17:11', 'amateur'),
(122, 3, '2024-12-10 16:00:00', 18, 10, 10, 'fulltime', '2024-12-10 09:27:42', 'amateur'),
(125, 1, '2025-01-14 19:00:00', 18, 10, 10, 'fulltime', '2025-01-14 08:16:13', 'amateur');

-- --------------------------------------------------------

--
-- Table structure for table `match_participants`
--

CREATE TABLE `match_participants` (
  `participant_id` int(11) NOT NULL,
  `match_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `team_name` varchar(255) NOT NULL DEFAULT 'not assigned a team'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `payment_method` enum('Cash','E-sewa','Not-Verified') NOT NULL DEFAULT 'Not-Verified',
  `payment_status` enum('pending','successful') NOT NULL DEFAULT 'pending',
  `user_id` int(11) DEFAULT NULL,
  `match_id` int(11) NOT NULL,
  `payment_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `payment_method`, `payment_status`, `user_id`, `match_id`, `payment_time`) VALUES
(1, 'Not-Verified', 'pending', 18, 125, '2025-01-15 06:46:33'),
(2, '', 'pending', 20, 125, '2025-01-15 06:37:56'),
(3, '', 'pending', 16, 125, '2025-01-15 06:37:56'),
(4, '', 'pending', 21, 125, '2025-01-15 06:37:56'),
(5, '', 'pending', 4, 125, '2025-01-15 06:37:56'),
(6, '', 'pending', 1, 125, '2025-01-15 06:37:56'),
(7, '', 'pending', 22, 125, '2025-01-15 06:37:56'),
(8, '', 'pending', 15, 125, '2025-01-15 06:37:56'),
(9, '', 'pending', 19, 125, '2025-01-15 06:37:56'),
(10, '', 'pending', 13, 125, '2025-01-15 06:37:56');

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
  `elo` int(11) NOT NULL DEFAULT 350,
  `games_played` int(11) DEFAULT 0,
  `wins` int(11) DEFAULT 0,
  `losses` int(11) DEFAULT 0,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `player_ranking` enum('beginner','amateur','pro') NOT NULL DEFAULT 'beginner'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player_profiles`
--

INSERT INTO `player_profiles` (`player_id`, `age`, `location`, `preferred_position`, `team_affiliation`, `elo`, `games_played`, `wins`, `losses`, `bio`, `created_at`, `updated_at`, `user_id`, `player_ranking`) VALUES
(1, 14, 'thamel', 'goalkeeper', NULL, 600, 0, 0, 0, 'this is me', '2024-11-13 03:28:13', '2024-12-10 02:15:51', 1, 'amateur'),
(3, 15, 'sorakhutte', 'goalkeeper', NULL, 600, 0, 0, 0, 'sasaasa', '2024-11-14 02:29:46', '2024-12-09 13:47:53', 11, 'amateur'),
(4, 15, 'nayabazaar', 'goalkeeper', NULL, 600, 0, 0, 0, 'this is suman', '2024-11-14 02:52:45', '2024-12-10 02:15:51', 13, 'amateur'),
(5, 18, 'thamel', 'defender', NULL, 600, 0, 0, 0, 'asasa', '2024-11-18 16:58:23', '2024-12-10 02:11:59', 4, 'amateur'),
(6, 23, 'tarakeswor', 'goalkeeper', NULL, 600, 0, 0, 0, 'sasasa', '2024-11-19 18:20:02', '2024-12-09 13:47:53', 15, 'amateur'),
(7, 16, 'samakhusi', 'midfielder', NULL, 660, 0, 0, 0, 'sadsasa', '2024-11-19 18:24:28', '2024-12-10 01:31:30', 17, 'amateur'),
(8, 23, 'baneshwor', 'forward', NULL, 600, 0, 0, 0, 'sdd', '2024-11-19 18:25:25', '2024-12-10 02:11:59', 16, 'amateur'),
(9, 25, 'saano bharang', 'midfielder', NULL, 650, 0, 0, 0, 'qq', '2024-11-19 18:26:36', '2024-12-10 01:31:30', 18, 'amateur'),
(10, 21, 'thulo bharang', 'forward', NULL, 600, 0, 0, 0, 'v', '2024-11-19 18:27:55', '2024-12-10 02:11:59', 19, 'amateur'),
(11, 23, 'townplanning', 'goalkeeper', NULL, 643, 0, 0, 0, 'qqq', '2024-11-19 18:28:58', '2024-12-10 06:43:47', 20, 'amateur'),
(12, 22, 'bouddha', 'defender', NULL, 685, 0, 0, 0, 'ff', '2024-11-19 18:30:43', '2024-12-10 01:31:30', 21, 'amateur'),
(13, 22, 'sorakhutte', 'goalkeeper', NULL, 600, 0, 0, 0, 'r', '2024-11-19 18:32:34', '2024-12-10 02:15:51', 22, 'amateur'),
(14, 16, 'thamel', 'defender', NULL, 600, 0, 0, 0, 'sasaa', '2024-11-30 08:59:12', '2024-12-10 02:15:51', 23, 'amateur'),
(15, 22, 'kathmandu', 'defender', NULL, 600, 0, 0, 0, 'dedicated player', '2024-12-07 12:45:54', '2024-12-09 13:47:53', 52, 'amateur'),
(16, 33, 'kathmandu', 'goalkeeper', NULL, 1003, 0, 0, 0, 'collge', '2024-12-07 21:28:32', '2024-12-10 06:55:28', 49, 'pro'),
(17, 44, 'kathmandu', 'goalkeeper', NULL, 600, 0, 0, 0, 'something', '2024-12-09 05:34:26', '2024-12-10 02:11:59', 51, 'amateur'),
(18, 17, 'kathmandu', 'goalkeeper', NULL, 600, 0, 0, 0, 'i like', '2024-12-10 04:40:55', '2024-12-10 04:40:55', 53, 'amateur'),
(19, 13, 'kathmandu', 'goalkeeper', NULL, 350, 0, 0, 0, 'sasasa', '2024-12-10 04:48:22', '2024-12-10 04:48:22', 54, 'beginner'),
(20, 21, 'kathmandu', 'goalkeeper', NULL, 350, 0, 0, 0, 'chill', '2024-12-10 06:57:53', '2024-12-10 06:57:53', 55, 'beginner'),
(21, 21, 'kathmandu', 'goalkeeper', NULL, 350, 0, 0, 0, 'sasasa', '2024-12-10 00:39:38', '2024-12-10 00:39:38', 56, 'beginner');

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
-- Table structure for table `player_stats`
--

CREATE TABLE `player_stats` (
  `stat_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `goals` int(11) DEFAULT 0,
  `assists` int(11) DEFAULT 0,
  `fouls` int(11) DEFAULT 0,
  `match_result` varchar(255) NOT NULL DEFAULT 'undecided'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player_stats`
--

INSERT INTO `player_stats` (`stat_id`, `match_id`, `player_id`, `goals`, `assists`, `fouls`, `match_result`) VALUES
(18, 57, 20, 0, 0, 0, 'undecided'),
(20, 58, 19, 1, 0, 0, 'undecided'),
(26, 58, 20, 1, 0, 0, 'undecided'),
(34, 59, 1, 0, 0, 0, 'undecided'),
(36, 59, 18, 1, 0, 0, 'undecided'),
(37, 59, 16, 1, 0, 0, 'undecided'),
(38, 59, 4, 3, 0, 0, 'undecided'),
(39, 59, 20, 2, 1, 0, 'undecided'),
(41, 72, 22, 1, 0, 0, 'undecided'),
(42, 72, 16, 4, 2, 0, 'undecided'),
(43, 72, 4, 3, 0, 0, 'undecided'),
(44, 68, 23, 10, 1, 0, 'undecided'),
(45, 59, 23, 7, 0, 0, 'undecided'),
(46, 80, 4, 3, 0, 0, 'undecided'),
(47, 80, 18, 2, 0, 0, 'undecided'),
(56, 80, 23, 1, 0, 0, 'undecided'),
(68, 90, 49, 5, 3, 0, 'undecided'),
(69, 107, 23, 3, 0, 0, 'undecided'),
(70, 107, 49, 0, 2, 2, 'undecided'),
(71, 107, 51, 1, 1, 1, 'undecided'),
(72, 111, 20, 3, 3, 1, 'undecided'),
(73, 111, 21, 5, 0, 0, 'undecided'),
(75, 111, 17, 6, 0, 0, 'undecided'),
(76, 111, 18, 5, 0, 0, 'undecided');

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
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `match_review_status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `referee_matches`
--

INSERT INTO `referee_matches` (`id`, `referee_id`, `match_id`, `assigned_at`, `match_review_status`) VALUES
(4, 1, 53, '2024-11-21 01:24:49', 'completed'),
(8, 1, 57, '2024-11-22 11:47:23', 'completed'),
(9, 1, 58, '2024-11-23 08:17:37', 'completed'),
(10, 1, 59, '2024-11-23 08:34:59', 'completed'),
(11, 1, 59, '2024-12-02 08:04:54', 'completed'),
(13, 1, 67, '2024-12-02 08:45:56', 'completed'),
(14, 1, 68, '2024-12-02 11:13:56', 'completed'),
(15, 1, 68, '2024-12-02 11:32:09', 'completed'),
(16, 1, 72, '2024-12-03 08:52:48', 'completed'),
(17, 1, 80, '2024-12-04 07:47:33', 'completed'),
(18, 1, 90, '2024-12-07 21:29:18', 'completed'),
(19, 1, 107, '2024-12-09 10:22:37', 'completed'),
(20, 1, 111, '2024-12-10 02:58:10', 'completed'),
(21, 1, 115, '2024-12-10 07:04:04', 'completed'),
(22, 1, 122, '2024-12-10 09:31:08', 'completed'),
(23, 1, 125, '2025-01-14 08:18:13', 'pending');

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
(22, 'pramit', 'pramit@gmail.com', '$2y$10$iVwRrRxj2/DOHd0efBVQGOJgbDPiV61CkTK8p2k93DzYVxo2UTfey', '2024-11-19 18:32:06'),
(23, 'nccs1', 'n1@gmail.com', '$2y$10$iiiEWMBgrx68sonT2JMjAu1iKmFLP2X9fi6ihnikG.8WgXLcY3WS2', '2024-11-30 08:49:14'),
(31, 'nccs2', 'nccs2@gmail.com', '$2y$10$ev1LAGV7pyadRztAkHUJVeUDVg7MNkmRUTkiazC9Tw/0LftwTvi9a', '2024-12-07 11:58:20'),
(45, 'nccs3', 'nccs3@gmail.com', '$2y$10$Xl3AbaOSkC8Xaa255lwtF.yMAAHZ6oVvRMTXtK8NMY/XhNjQO/FIG', '2024-12-07 12:22:39'),
(47, 'nccs4', 'n4@gmail.com', '$2y$10$08u/wuYPVK528QwxBAwRweceysibTVaIMC6RQ/KYL8OUuecGtqaeq', '2024-12-07 12:26:34'),
(48, 'nccs5', 'n5@gmail.com', '$2y$10$i.SE21j1P6.CcEiSWBV2CutafLGZa7HCFNoR8RdwuglEtgCgJl9Dm', '2024-12-07 12:31:19'),
(49, 'nccs6', 'n6@gmail.com', '$2y$10$uRAqxuju/BfPIaT2oYUmZuIigxwOgTLZbiqbirWKXtEW38ho0Q.LG', '2024-12-07 12:36:13'),
(50, 'nccs7', 'n7@gmail.com', '$2y$10$G/i.Kg4mhLjZsNWBwbPI/ejuBVYLqcM4QEkE/rZM8BXXYQHbAEqO6', '2024-12-07 12:38:36'),
(51, 'nccs8', 'n8@gmail.com', '$2y$10$PcZz/r7anlforHaF9QOrOOJt9XDNe.sy0Y3aAdBgn7nFSsN9eAM9C', '2024-12-07 12:43:27'),
(52, 'nccs9', 'n9@gmail.com', '$2y$10$9jsBzy4CKGs3Jou9yLWA1eZOWYaTXBkCYy6xPui17hOk3qI2jdPqi', '2024-12-07 12:45:04'),
(53, 'nccs421', 'n421@gmail.com', '$2y$10$lhje3cUa71SMrHAOZrp5DeMaBnelQSb1ntHN0Ad9XWji32Tz6k1/S', '2024-12-10 04:35:39'),
(54, 'nccs00', 'n0@gmail.com', '$2y$10$IcxSzZ1kmU0OnGWVRpTaN.EtJG/q2KAAQ7dAURPKlgd.UvtX/edz6', '2024-12-10 04:46:09'),
(55, 'nccs01', 'n01@gmail.com', '$2y$10$2C24lislEkMNc8WjW2cJEuxcPbwtlpP.anL7hmSwI/vb.Mk.JpKbW', '2024-12-10 06:56:33'),
(56, 'nccs02', 'n3@gmail.com', '$2y$10$nBmAve2ftdAegUjHQ2jCZ.KpLc7VkfEd0Xxu8efoXOEj3Y4Df5Ffm', '2024-12-10 00:38:31');

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
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `friend_id` (`friend_id`);

--
-- Indexes for table `friend_activities`
--
ALTER TABLE `friend_activities`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `target_user_id` (`target_user_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

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
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `match_id` (`match_id`);

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
-- Indexes for table `player_stats`
--
ALTER TABLE `player_stats`
  ADD PRIMARY KEY (`stat_id`),
  ADD UNIQUE KEY `match_id` (`match_id`,`player_id`),
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
  MODIFY `arena_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `arena_bookings`
--
ALTER TABLE `arena_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `completed_matches`
--
ALTER TABLE `completed_matches`
  MODIFY `completed_match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=384;

--
-- AUTO_INCREMENT for table `completed_match_participants`
--
ALTER TABLE `completed_match_participants`
  MODIFY `completed_match_participant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `friend_activities`
--
ALTER TABLE `friend_activities`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `matchmaking`
--
ALTER TABLE `matchmaking`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `match_participants`
--
ALTER TABLE `match_participants`
  MODIFY `participant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=483;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `player_profiles`
--
ALTER TABLE `player_profiles`
  MODIFY `player_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `player_ratings`
--
ALTER TABLE `player_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player_stats`
--
ALTER TABLE `player_stats`
  MODIFY `stat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

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
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friend_activities`
--
ALTER TABLE `friend_activities`
  ADD CONSTRAINT `friend_activities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_activities_ibfk_2` FOREIGN KEY (`target_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_requests_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`match_id`) REFERENCES `matchmaking` (`match_id`);

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
-- Constraints for table `player_stats`
--
ALTER TABLE `player_stats`
  ADD CONSTRAINT `player_stats_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `completed_matches` (`match_id`),
  ADD CONSTRAINT `player_stats_ibfk_2` FOREIGN KEY (`player_id`) REFERENCES `users` (`id`);

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
