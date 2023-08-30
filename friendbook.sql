-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 30, 2023 at 04:19 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `friendbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_verification`
--

CREATE TABLE `account_verification` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `admin_reply` text,
  `verification_status` varchar(255) NOT NULL,
  `upload_file_name` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_verification`
--

INSERT INTO `account_verification` (`id`, `user_id`, `admin_reply`, `verification_status`, `upload_file_name`, `date`, `updated_date`) VALUES
(10, 11, 'R48tHwUK51wT42Rhc37D/l19LjS1h+MvvGh+6LtykMWxIfsedtEPIncm26AWSuiECu0fDpyrYcne5mzZyyixfKt+V+ZOFnZ8M7/lLpSN1HM=', 'wuh64qIaLOuACyLVZELHhA==', 'HWA/zsxlaak43jS9DALU9wB2wyjZiPWwudnJ1Sed+6e1vfcjvi4ZH7C/XD4cGIJv', '2022-12-04 10:37:03', '2022-12-05 06:09:16'),
(11, 11, 'x2gKavLXrZenktmsB46JR3KYH8qtFqYLB5F2wpz2LRO5qr64LIG3ekORZb+4+duTw4ItsOtfIxH4haEUQPAkcw==', 'JCX9ETjKAUtr/wOHt7Q1wg==', 'Qsbau115ykbqwoH9A53zfxPnNkd+i9d3TeQt6VKTB/AvJbmmAQaube+lsu4axH6rRdZK1fchjudIYy9c8/kMyw==', '2022-12-04 10:39:27', '2022-12-05 06:09:20'),
(12, 41, 'cM9b/HcSZAJwaWIL1mZHV/liflIGZf3bcLS8pGPHPpl2PJ90Sr7wVMqq5fWOMw8s', 'wuh64qIaLOuACyLVZELHhA==', 'RWdnknwf36OETO2kXIuiVDl0MJbNdM1ERKDpF+hb7IAd1YUXbDSuHMugEVM2rCbxgV4K6ns/CV/ffWp3U6Xxiw==', '2023-01-08 19:27:53', '2023-01-09 17:25:06'),
(14, 41, NULL, 'w2mwBM2jG6gg7tXZOWOCWQ==', 'A1qDBsT4sYjOv86Sxi2Wy6moJy89OA7Tq2k+A/lnaeJwOeQyvIIXyNP+NuH11jQ+gj+6ENJImogMiJhj00ySmA==', '2023-01-09 17:25:51', '2023-01-09 17:25:51'),
(15, 17, NULL, 'w2mwBM2jG6gg7tXZOWOCWQ==', 'p1Ek+DfWm2Fwd1fKc5nfovFn7b962enxXYqyHtPU623+l1/Gt42JGoSYWtpirxsGIehhTKWlkZ7HUzzSHIf0pg==', '2023-01-09 17:28:33', '2023-01-09 17:28:33'),
(17, 26, NULL, 'w2mwBM2jG6gg7tXZOWOCWQ==', 'Fo8LR7ndGtSfpbHmZ2GV4hRjhyj/FLLI8ZObEejfxO+sZmTxTTsmr70l+q6/f6mhLhbnvm/tPqZiE6x45u0vKQ==', '2023-01-09 17:30:03', '2023-01-09 17:30:03'),
(18, 14, 'dOmGdaTsudTpJoG6Z5NwNDe5OrSI1uBuHxDXv6IHgCouoy5RSbBWkYWDeZcFQ3epRbLaQlI5bH/R6d1hS4FjUQ==', 'wuh64qIaLOuACyLVZELHhA==', 'rfM0FOmQJpSmfg1e4+3gDe9uezTUuKEp2RPP2pMN7kb0o8xJjwXprMwnuL1LwowzmTs3+EA8cxcQmo2m3ABneQ==', '2023-01-09 17:31:00', '2023-01-09 17:31:34'),
(19, 14, NULL, 'JCX9ETjKAUtr/wOHt7Q1wg==', 'SA8xN1UheeobzgPQQEXqZT1+ASpmCLL+l5aKPPp4XBea/HHADv6M6BzLnWWWRa7lYmyqzIsuZK9uUAgSO0ZeQA==', '2023-01-09 17:32:22', '2023-01-10 06:58:48');

-- --------------------------------------------------------

--
-- Table structure for table `account_warning`
--

CREATE TABLE `account_warning` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `complaint_id` int NOT NULL,
  `complaint_type` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_warning`
--

INSERT INTO `account_warning` (`id`, `user_id`, `complaint_id`, `complaint_type`, `date`) VALUES
(34, 11, 19, 'yprzCk0hemUCcGccND99Gg==', '2023-01-05 07:24:41'),
(35, 13, 19, 'yprzCk0hemUCcGccND99Gg==', '2023-01-05 07:24:41'),
(36, 11, 12, '3TAJzKwumhhA5DrTwspC2lEJA1sV+5h5LARafZmlszE=', '2023-01-05 07:41:25');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `added_by` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `admin_password`, `added_by`, `created_at`) VALUES
(1, 'Zohaib Khan', 'juFB7a34XuvSMDn3qPHBV4K5uXBnQM68I0LHBZ3WjNk=', 'v4f67FpYCLr7l3BqxMFvXA==', NULL, '2022-12-10 17:39:59'),
(2, 'Rizwan Khan', 'Ukw/ZWWouyHN3sQTcLiw1d7NwW/SELheNKUCrhzdIjc=', 'v4f67FpYCLr7l3BqxMFvXA==', 1, '2023-01-23 13:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `follower`
--

CREATE TABLE `follower` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `follow_user_id` int NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follower`
--

INSERT INTO `follower` (`id`, `user_id`, `follow_user_id`, `date_time`) VALUES
(15, 17, 15, '2022-10-18 06:55:56'),
(16, 18, 11, '2022-10-18 06:56:30'),
(17, 25, 11, '2022-10-18 13:34:28'),
(50, 22, 11, '2022-10-21 06:28:15'),
(51, 11, 22, '2022-10-22 18:59:42'),
(58, 13, 17, '2022-10-23 19:34:40'),
(66, 15, 24, '2022-10-26 17:50:11'),
(67, 17, 21, '2022-10-26 18:29:52'),
(84, 11, 15, '2022-10-28 19:21:26'),
(86, 11, 19, '2022-10-29 09:31:28'),
(88, 19, 11, '2022-10-29 18:23:07'),
(89, 24, 11, '2022-10-29 19:16:13'),
(92, 25, 16, '2022-11-06 20:01:45'),
(93, 11, 27, '2022-12-24 09:35:49');

-- --------------------------------------------------------

--
-- Table structure for table `friend_request`
--

CREATE TABLE `friend_request` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `send_user_id` int NOT NULL,
  `request` varchar(255) NOT NULL,
  `request_sender_id` int DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friend_request`
--

INSERT INTO `friend_request` (`id`, `user_id`, `send_user_id`, `request`, `request_sender_id`, `date_time`, `updated_at`) VALUES
(167, 23, 11, 'twWDK6lcAWGMrrbPLz9DKA==', 23, '2022-10-26 19:05:10', '2022-10-27 05:54:27'),
(168, 11, 23, 'twWDK6lcAWGMrrbPLz9DKA==', NULL, '2022-10-26 19:05:10', '2022-10-27 05:54:27'),
(171, 22, 11, 'twWDK6lcAWGMrrbPLz9DKA==', 22, '2022-10-26 19:05:22', '2022-10-27 05:54:26'),
(172, 11, 22, 'twWDK6lcAWGMrrbPLz9DKA==', NULL, '2022-10-26 19:05:22', '2022-10-27 05:54:26'),
(183, 11, 21, 'twWDK6lcAWGMrrbPLz9DKA==', 11, '2022-10-27 06:29:12', '2022-10-27 06:29:54'),
(184, 21, 11, 'twWDK6lcAWGMrrbPLz9DKA==', NULL, '2022-10-27 06:29:12', '2022-10-27 06:29:54'),
(185, 11, 13, 'CwhumKYgJ1Lk30hI4T28wg==', 11, '2022-10-27 06:29:18', '2023-08-22 07:12:18'),
(186, 13, 11, 'pVyPstFtk4r3kddl8QaDUg==', NULL, '2022-10-27 06:29:18', '2023-08-22 07:12:18'),
(187, 11, 20, 'twWDK6lcAWGMrrbPLz9DKA==', 11, '2022-10-27 06:29:19', '2022-10-27 06:30:34'),
(188, 20, 11, 'twWDK6lcAWGMrrbPLz9DKA==', NULL, '2022-10-27 06:29:19', '2022-10-27 06:30:34'),
(189, 20, 13, 'aBrfjy92Vq95AdFHNtZITw==', 20, '2022-10-29 07:02:21', '2022-10-29 07:02:21'),
(190, 13, 20, 'aBrfjy92Vq95AdFHNtZITw==', NULL, '2022-10-29 07:02:21', '2022-10-29 07:02:21'),
(191, 11, 14, 'twWDK6lcAWGMrrbPLz9DKA==', 11, '2022-10-29 09:52:57', '2022-10-29 09:53:38'),
(192, 14, 11, 'twWDK6lcAWGMrrbPLz9DKA==', NULL, '2022-10-29 09:52:57', '2022-10-29 09:53:38'),
(194, 24, 11, 'aBrfjy92Vq95AdFHNtZITw==', NULL, '2022-11-01 05:24:44', '2022-11-01 05:24:44'),
(196, 19, 11, 'aBrfjy92Vq95AdFHNtZITw==', NULL, '2022-11-01 05:24:46', '2022-11-01 05:24:46'),
(198, 13, 22, 'aBrfjy92Vq95AdFHNtZITw==', NULL, '2022-11-12 08:13:39', '2022-11-12 08:13:39'),
(201, 27, 22, 'aBrfjy92Vq95AdFHNtZITw==', 27, '2022-11-12 15:22:25', '2022-11-12 15:22:25'),
(202, 22, 27, 'aBrfjy92Vq95AdFHNtZITw==', NULL, '2022-11-12 15:22:25', '2022-11-12 15:22:25'),
(209, 27, 11, 'twWDK6lcAWGMrrbPLz9DKA==', 27, '2022-11-14 06:32:42', '2022-11-14 06:33:12'),
(210, 11, 27, 'twWDK6lcAWGMrrbPLz9DKA==', NULL, '2022-11-14 06:32:42', '2022-11-14 06:33:12'),
(211, 27, 26, 'aBrfjy92Vq95AdFHNtZITw==', 27, '2022-12-02 08:25:13', '2022-12-02 08:25:13'),
(212, 26, 27, 'aBrfjy92Vq95AdFHNtZITw==', NULL, '2022-12-02 08:25:13', '2022-12-02 08:25:13'),
(265, 42, 37, 'aBrfjy92Vq95AdFHNtZITw==', 42, '2023-01-23 05:51:27', '2023-01-23 05:51:27'),
(266, 37, 42, 'aBrfjy92Vq95AdFHNtZITw==', NULL, '2023-01-23 05:51:28', '2023-01-23 05:51:28'),
(269, 43, 11, 'twWDK6lcAWGMrrbPLz9DKA==', 43, '2023-01-23 09:48:29', '2023-01-23 09:53:53'),
(270, 11, 43, 'twWDK6lcAWGMrrbPLz9DKA==', NULL, '2023-01-23 09:48:29', '2023-01-23 09:53:53'),
(271, 11, 17, 'CwhumKYgJ1Lk30hI4T28wg==', NULL, '2023-01-23 09:52:38', '2023-01-23 09:52:38'),
(272, 17, 11, 'pVyPstFtk4r3kddl8QaDUg==', NULL, '2023-01-23 09:52:38', '2023-01-23 09:52:38');

-- --------------------------------------------------------

--
-- Table structure for table `ip_address`
--

CREATE TABLE `ip_address` (
  `id` int NOT NULL,
  `email` varchar(225) NOT NULL,
  `ip_address` varchar(225) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ip_address`
--

INSERT INTO `ip_address` (`id`, `email`, `ip_address`, `date`) VALUES
(490, 'juFB7a34XuvSMDn3qPHBV4K5uXBnQM68I0LHBZ3WjNk=', 'CFn9cETbtX1RTAxVWUZlhA==', '2023-01-23 18:40:57');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempt`
--

CREATE TABLE `login_attempt` (
  `id` int NOT NULL,
  `email` varchar(225) NOT NULL,
  `ip_address` varchar(225) NOT NULL,
  `attempt` varchar(225) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `friend_id` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `file_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `seen_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `message_status` varchar(255) NOT NULL DEFAULT 'Null',
  `chatBox` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Null',
  `sended_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `friend_id`, `message`, `file_name`, `file_type`, `seen_status`, `message_status`, `chatBox`, `sended_at`, `updated_at`) VALUES
(72, 11, 22, 'c18e0d98ea7861e9bWwzOGJ1aDdJa2drN3JWUlpBMXliQT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-19 08:17:16', '2023-01-22 06:35:26'),
(898, 11, 14, '4b95d953c368cfe4eFg2b09DU3BpeXpKTjhNVm9ic052UT09', '', '', 'aBrfjy92Vq95AdFHNtZITw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-22 11:10:07', '2023-01-23 10:30:51'),
(900, 11, 14, '75d745af4f0a2513dTlKVmVaQ2d1K0x1b1p6ajRpODRGdz09', '', '', 'aBrfjy92Vq95AdFHNtZITw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-22 11:11:50', '2023-01-23 10:30:51'),
(902, 11, 14, 'a4af13548c2ff462MUxjZi9HWE1Od0s0cFlXZ2pPMytCdz09', '', '', 'aBrfjy92Vq95AdFHNtZITw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-22 11:12:54', '2023-01-23 10:30:51'),
(906, 11, 14, 'e15851c794f7d108clRqZytzWUxyWjJyRnF4TE9TZmIxQT09', '', '', 'aBrfjy92Vq95AdFHNtZITw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-22 11:15:11', '2023-01-23 10:30:51'),
(908, 11, 14, '72de10fe467c9ff9aDZsTTJnUjdkZzNzSURCajJCZE5yUT09', '', '', 'aBrfjy92Vq95AdFHNtZITw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-22 11:15:15', '2023-01-23 10:30:51'),
(914, 42, 41, '751bf7e2e8d19d1cSWdCa252NUJyZ2lNT3dkL2FJREIrUT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 05:52:58', '2023-01-23 10:33:58'),
(924, 11, 43, '966e0de5b4480496MHJCbGJQSmFjS2ZMb3ZlZHFORVN1UT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 09:54:52', '2023-01-23 10:30:45'),
(926, 11, 43, '57a5c58be0986fb4dUQ1cE1QS0JFVEFqQkMvK2E2N0pVdz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 09:55:04', '2023-01-23 10:30:45'),
(928, 11, 43, 'd78cc9f85c6a4eb0NnpDZGZvbXRnc2lPcTZDalRlOUNnQT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 09:55:15', '2023-01-23 10:30:45'),
(930, 11, 43, '9f1cb4411f8245e9UjlzNGt5VE05bjc2Q0k4NjlGZ2k0dz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 09:55:42', '2023-01-23 10:30:45'),
(932, 43, 11, 'afb35ae1e0c9bcefY25yMjBGUFY4YldvMzVNOHJaQTJHdz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 09:58:33', '2023-01-23 10:30:45'),
(934, 43, 11, 'b3ea53d7416e958fdVhmdUc0Q0FRQ0QySCs2dXVxWEJ4Zz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 09:59:14', '2023-01-23 10:30:45'),
(936, 43, 11, 'dcd57652ad71ec34c3hxTTV6SWsrUlpXZWwrT0U3eXQ5dz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 10:00:26', '2023-01-23 10:30:46'),
(938, 11, 43, '49010f2d8d10a9e9aUVHVjNvQUZGa045allzam5EWDcvZz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 10:02:44', '2023-01-23 10:30:46'),
(940, 11, 43, '2769f701dce8d79cR3JKOTVrRExybmxTd0hSbFhaK3BPZz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 10:03:05', '2023-01-23 10:30:46'),
(942, 43, 11, '81c5c60266514f46a1poc1hhQjIxNXBOc0dJZm0ydEhzdz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 10:04:52', '2023-01-23 10:30:46'),
(944, 43, 11, '24ed4fcd82903fe5MWFueDVFVmozaXBIL1JOeFU0S01DUT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 10:04:58', '2023-01-23 10:30:46'),
(946, 43, 11, 'f899594a74ecbdd3dG8vcFhNYm9lN0RJeTNzd2pIL0RBdz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 10:07:36', '2023-01-23 10:30:46'),
(948, 43, 11, 'fec68a6a1f0d8f3eYzJ0MkF6bytneHVOMHZIM24ybmN6UT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 10:07:51', '2023-01-23 10:30:46'),
(950, 43, 11, '9b7f31bcc6432323UkVlV3FObSs4dk9zMGs4bzhnR09mQT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 10:08:16', '2023-01-23 10:30:46'),
(952, 43, 11, '5311e269c57f3af4ZFlrZEhTeGJISFpWQkdRUXUrREIrQT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 10:11:09', '2023-01-23 10:30:46'),
(954, 43, 11, 'ca4718df04e3e714TWp6QkI2R2VWSXpWZVVtcldjYllPdz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 10:11:30', '2023-01-23 10:30:46'),
(956, 43, 11, '65a2844caaa32f71MFlrTU80ZVlMQ2ZzOVlRT29UeXZYUT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 10:13:45', '2023-01-23 10:30:46'),
(958, 43, 11, '976b4bc3a87c9dd5ckFtZ1YrbTl5WEs2djRQVElwMEFxQT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'tsy37Notc0AqmFEiK90/Cg==', '2023-01-23 10:13:50', '2023-01-23 10:30:46'),
(960, 41, 11, '21ae36f29a711e35ZWlvRGxaWmltcW8xTzJBNFM0dVkzZz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'f35IXkVKgh0e2vD+gH9Z4Q==', '2023-01-23 10:15:31', '2023-01-23 10:31:02'),
(962, 41, 11, '4a97e9fecf42917fM3VPUFY4U3RLa2dLVnBsaGN1bWU0QT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'f35IXkVKgh0e2vD+gH9Z4Q==', '2023-01-23 10:16:01', '2023-01-23 10:31:02'),
(964, 13, 11, '53d5f85c0142fa78MHI1RVBjeThURFpxcHk4MU1QYU1Hdz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 10:16:45', '2023-01-23 10:16:57'),
(966, 13, 11, 'e13e4f061528179db1dtUk5wNjBXQjhIdDhaRE9rYklNZz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 10:17:18', '2023-01-23 10:17:52'),
(968, 41, 11, '39704fc08a3f84c8K1Z4YTNReEdDY1pLV2NsbnZOWWZVdz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'f35IXkVKgh0e2vD+gH9Z4Q==', '2023-01-23 10:17:47', '2023-01-23 10:31:03'),
(971, 41, 11, 'a47e296988f8ccdcNVkzUFp0ZkozNjFVaHZnOFd2OVFmdz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'f35IXkVKgh0e2vD+gH9Z4Q==', '2023-01-23 10:18:59', '2023-01-23 10:31:03'),
(975, 41, 11, 'a9e346cd2365c257QUtCUWxtbnBKaDhsd1RjNkFCZlFiZz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'f35IXkVKgh0e2vD+gH9Z4Q==', '2023-01-23 10:20:11', '2023-01-23 10:31:03'),
(977, 41, 11, '7475ac59f29ed2e7TlVra0ttQXV3TDcwWWNPSDY3UWJqUT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'f35IXkVKgh0e2vD+gH9Z4Q==', '2023-01-23 10:22:01', '2023-01-23 10:31:03'),
(979, 41, 11, 'cfb30b37225024f0YUZXSnNFaW03VnFacDR3dFFORE1NQT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'f35IXkVKgh0e2vD+gH9Z4Q==', '2023-01-23 10:22:07', '2023-01-23 10:31:03'),
(981, 13, 11, '856a5f4a820ef354QzQrTWVENlRrZVRTdGUvbUxMOWpidz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 10:22:42', '2023-01-23 10:23:08'),
(985, 13, 11, '4de5b3ebb7113bd3ekE1TWVQL0tEa3EvblZMMThmYWtjZz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 10:23:14', '2023-01-23 10:26:37'),
(987, 41, 11, '7db1de557c4dd01dZU5NdHFZYTRmb0ZlSC9QNFJnYjl6Zz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'f35IXkVKgh0e2vD+gH9Z4Q==', '2023-01-23 10:23:43', '2023-01-23 10:31:03'),
(989, 41, 11, 'f8515a1cf4e6e953OFdBb093TWJGWldMbVM5cXFBRGUyQT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'f35IXkVKgh0e2vD+gH9Z4Q==', '2023-01-23 10:26:22', '2023-01-23 10:31:03'),
(991, 41, 11, '953c4efd00e7ec9bdFJVRktIeElLdVhMTVlnWDRLN3NCUT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'f35IXkVKgh0e2vD+gH9Z4Q==', '2023-01-23 10:27:22', '2023-01-23 10:31:03'),
(993, 13, 11, 'dca55a542c55aa03WFhsQ24yK2YvNGxWejgwNE91MUxJdz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 10:28:26', '2023-01-23 10:28:51'),
(995, 13, 11, '52a37bbeaab14ab3MjVLV2RNYXdCTGdXNHRLaXhlazE0Zz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 10:29:18', '2023-01-23 10:30:31'),
(997, 13, 11, '299e77d27ef21256VEN5WlIzUW5VNzBZYi92aUpiS1EzUT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 10:29:50', '2023-01-23 10:30:31'),
(999, 41, 11, 'de048740fbb87ae1cktNOXNkS0VielY1clRWbGFBWi9PQT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'f35IXkVKgh0e2vD+gH9Z4Q==', '2023-01-23 10:30:23', '2023-01-23 10:31:03'),
(1001, 42, 41, '975c23f6e651f81cN0FWOW5teCt6VkUxekRrdzF2cTV4UT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 10:34:21', '2023-01-23 10:52:46'),
(1003, 42, 41, '2dce1b3477d51f26MzIwVElPUm1jK2FwbHRLU0lkaEJpUT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 10:34:27', '2023-01-23 10:52:46'),
(1007, 41, 11, 'e3ca73e65824cbfbMEdQeVU0bDJyM0x1YTFEL0VMQzRzZz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 11:14:40', '2023-01-23 12:11:27'),
(1009, 42, 41, '1c3ab73b189454adbDJOd0VqL1E3ZTBqTTJwbG9keTRqQT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 11:16:23', '2023-01-23 11:16:33'),
(1011, 41, 42, '0b1458e69acdfb6eamppQnJ5czlwazVlWVNwamVPNWcyQT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 11:16:42', '2023-01-23 11:16:58'),
(1014, 42, 41, 'b512fd8dea353522UjJTaUt6R2huNEJMaTFUMXZad3VSQT09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 11:17:13', '2023-01-23 11:17:39'),
(1016, 42, 41, '5b76147370b23755dlJrUTN6NW1wRHp3b09COFlWTjFLdz09', '', '', 'WjmeJ8CFRvm6PZN8V44+dw==', 'Null', 'Null', '2023-01-23 11:28:11', '2023-01-23 11:28:18'),
(1017, 11, 13, '70c6fc4cdb218fc5N0RuY0FFTk1ITUVsdytQWkwzU3Z5UT09', '', '', 'aBrfjy92Vq95AdFHNtZITw==', 'Null', 'Null', '2023-01-23 18:19:25', '2023-01-23 18:19:25');

-- --------------------------------------------------------

--
-- Table structure for table `message_list`
--

CREATE TABLE `message_list` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `friend_id` int NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `message_list`
--

INSERT INTO `message_list` (`id`, `user_id`, `friend_id`, `date_time`) VALUES
(8, 11, 23, '2022-10-27 05:54:27'),
(10, 21, 11, '2022-10-27 06:29:54'),
(13, 11, 27, '2022-11-14 06:33:12'),
(16, 23, 11, '2022-10-27 05:54:27'),
(18, 11, 21, '2022-10-27 06:29:54'),
(21, 27, 11, '2022-11-14 06:33:12'),
(49, 11, 20, '2023-01-17 20:20:09'),
(50, 20, 11, '2023-01-17 20:20:09'),
(83, 11, 22, '2023-01-19 08:17:16'),
(84, 22, 11, '2023-01-19 08:17:16'),
(425, 11, 14, '2023-01-22 11:15:16'),
(426, 14, 11, '2023-01-22 11:15:16'),
(479, 43, 11, '2023-01-23 10:13:50'),
(480, 11, 43, '2023-01-23 10:13:50'),
(529, 41, 11, '2023-01-23 11:14:40'),
(530, 11, 41, '2023-01-23 11:14:40'),
(537, 42, 41, '2023-01-23 11:28:11'),
(538, 41, 42, '2023-01-23 11:28:11'),
(541, 11, 13, '2023-08-22 07:11:13'),
(542, 13, 11, '2023-08-22 07:11:13');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `post_user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `notif_type` varchar(255) NOT NULL,
  `notif_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `user_id`, `post_user_id`, `post_id`, `notif_type`, `notif_date`) VALUES
(1, 11, 11, 1, 'vBDE1K2ICSqFynA/Lrn7Og==', '2022-10-29 06:37:41'),
(3, 20, 20, 3, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-10-29 06:38:41'),
(4, 20, 20, 4, 'vBDE1K2ICSqFynA/Lrn7Og==', '2022-10-29 06:38:49'),
(5, 13, 13, 5, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-10-29 06:39:42'),
(6, 13, 13, 6, 'vBDE1K2ICSqFynA/Lrn7Og==', '2022-10-29 06:41:57'),
(9, 13, 11, 1, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-10-29 06:46:17'),
(12, 20, 11, 1, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 06:46:55'),
(13, 20, 11, 1, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-10-29 06:46:59'),
(14, 11, 11, 7, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 06:52:37'),
(16, 11, 11, 9, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 06:54:07'),
(17, 11, 11, 10, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 06:54:39'),
(18, 11, 11, 11, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 06:55:04'),
(19, 11, 11, 12, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 06:58:53'),
(20, 11, 11, 13, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 06:59:26'),
(21, 11, 11, 14, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 07:10:09'),
(22, 11, 11, 15, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 07:21:57'),
(23, 20, 11, 15, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 07:22:22'),
(24, 20, 11, 15, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-10-29 07:22:33'),
(25, 13, 11, 15, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 07:22:46'),
(26, 13, 11, 15, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-10-29 07:22:59'),
(27, 13, 11, 14, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 07:23:05'),
(28, 13, 11, 14, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-10-29 07:23:10'),
(29, 20, 11, 14, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 07:23:12'),
(30, 20, 11, 14, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-10-29 07:23:20'),
(31, 20, 11, 13, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 07:23:27'),
(32, 13, 11, 13, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 07:23:39'),
(33, 13, 11, 12, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 07:23:43'),
(36, 20, 11, 12, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 07:24:21'),
(37, 20, 11, 11, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-10-29 07:24:27'),
(38, 20, 11, 10, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-10-29 07:24:34'),
(39, 13, 11, 11, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 07:24:47'),
(40, 13, 11, 10, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-10-29 07:24:50'),
(41, 13, 11, 9, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 07:24:54'),
(42, 13, 11, 9, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-10-29 07:24:58'),
(43, 15, 15, 16, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-10-29 07:30:32'),
(44, 15, 15, 17, 'vBDE1K2ICSqFynA/Lrn7Og==', '2022-10-29 07:30:45'),
(45, 21, 21, 18, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-10-29 07:32:11'),
(46, 21, 21, 19, 'vBDE1K2ICSqFynA/Lrn7Og==', '2022-10-29 07:32:20'),
(47, 20, 20, 20, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 07:33:55'),
(48, 23, 23, 21, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-10-29 07:34:48'),
(49, 24, 24, 22, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-10-29 07:35:42'),
(50, 15, 15, 23, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 10:50:34'),
(51, 21, 21, 24, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 11:30:22'),
(53, 19, 19, 26, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-10-29 18:53:22'),
(54, 24, 24, 27, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-10-29 18:54:04'),
(58, 24, 11, 15, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-10-29 18:55:08'),
(60, 24, 11, 13, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-10-29 18:55:15'),
(61, 24, 11, 13, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-10-29 18:55:20'),
(63, 24, 11, 12, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-10-29 19:00:40'),
(66, 24, 11, 15, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 19:03:19'),
(67, 11, 11, 28, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 19:21:48'),
(69, 24, 11, 14, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-10-29 19:28:20'),
(70, 24, 11, 7, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 19:30:42'),
(71, 24, 11, 11, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 19:32:07'),
(72, 24, 11, 11, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 19:32:44'),
(73, 24, 11, 1, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-29 19:33:34'),
(74, 24, 11, 1, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-10-29 19:35:05'),
(75, 24, 11, 1, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-10-29 19:36:21'),
(76, 17, 17, 29, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 19:37:35'),
(82, 24, 24, 30, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 19:47:15'),
(83, 11, 11, 31, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-29 19:47:45'),
(84, 17, 17, 32, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-10-30 08:19:37'),
(85, 14, 14, 33, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-10-30 08:58:41'),
(87, 13, 13, 35, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-10-30 09:02:00'),
(88, 13, 13, 36, 'vBDE1K2ICSqFynA/Lrn7Og==', '2022-10-30 09:02:11'),
(89, 13, 13, 37, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-30 09:02:55'),
(90, 11, 11, 38, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-30 09:04:36'),
(91, 22, 22, 39, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-10-30 09:06:33'),
(92, 11, 11, 40, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-10-30 09:35:29'),
(93, 17, 11, 40, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-30 09:36:23'),
(94, 17, 24, 30, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-30 09:36:37'),
(95, 24, 11, 28, '8ySPln6LR6FcloxSLDL2Wg==', '2022-10-30 09:43:02'),
(96, 24, 11, 1, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-10-30 09:46:35'),
(97, 11, 20, 20, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-01 05:23:40'),
(101, 20, 20, 44, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-11-04 17:51:08'),
(110, 11, 11, 46, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-11-05 17:41:55'),
(115, 25, 11, 40, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-05 18:40:53'),
(117, 25, 11, 28, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-06 05:47:30'),
(119, 25, 11, 38, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 05:47:55'),
(120, 25, 11, 13, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 05:48:00'),
(121, 25, 11, 12, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 05:48:01'),
(122, 25, 11, 11, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 05:48:04'),
(123, 25, 11, 10, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 05:48:06'),
(125, 25, 11, 9, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-06 05:48:10'),
(126, 25, 11, 1, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 05:48:14'),
(128, 25, 11, 15, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 05:49:09'),
(129, 25, 11, 14, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 05:49:13'),
(132, 25, 25, 48, 'vBDE1K2ICSqFynA/Lrn7Og==', '2022-11-06 05:56:45'),
(133, 25, 25, 49, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-11-06 05:58:23'),
(135, 16, 16, 51, 'vBDE1K2ICSqFynA/Lrn7Og==', '2022-11-06 06:01:48'),
(136, 25, 11, 46, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 06:05:49'),
(137, 16, 11, 46, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 06:06:29'),
(140, 16, 11, 40, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-06 06:06:53'),
(141, 16, 11, 38, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 06:06:55'),
(142, 16, 11, 31, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 06:06:57'),
(143, 16, 11, 28, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 06:07:01'),
(144, 16, 11, 15, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 06:07:05'),
(145, 16, 11, 14, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-06 06:07:10'),
(146, 16, 11, 13, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 06:07:13'),
(147, 16, 11, 12, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-06 06:07:16'),
(148, 16, 11, 11, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-06 06:07:19'),
(149, 16, 11, 10, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-06 06:07:22'),
(150, 16, 11, 9, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 06:07:26'),
(152, 16, 11, 7, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-06 06:07:32'),
(154, 16, 11, 1, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-06 06:07:38'),
(156, 21, 21, 52, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-11-06 06:16:23'),
(158, 16, 16, 53, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-11-06 13:32:11'),
(159, 16, 16, 54, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2022-11-06 13:33:17'),
(160, 27, 11, 46, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 14:46:29'),
(161, 27, 11, 40, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 14:46:37'),
(162, 27, 11, 40, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-11-12 14:46:45'),
(163, 27, 11, 38, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 14:46:51'),
(164, 27, 11, 31, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 14:46:55'),
(165, 27, 11, 28, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-12 14:46:58'),
(166, 27, 11, 15, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 14:47:03'),
(167, 27, 11, 14, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-12 14:47:07'),
(168, 27, 11, 13, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 14:47:10'),
(169, 27, 11, 12, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-12 14:47:13'),
(170, 27, 11, 11, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 14:47:17'),
(171, 27, 11, 10, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-12 14:47:20'),
(172, 27, 11, 9, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 14:47:24'),
(174, 27, 11, 7, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 14:47:30'),
(176, 27, 11, 1, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 14:47:37'),
(177, 26, 11, 46, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 15:06:18'),
(179, 26, 11, 40, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-12 15:06:23'),
(180, 26, 11, 38, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-12 15:06:25'),
(181, 26, 11, 38, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-11-12 15:06:42'),
(182, 26, 11, 31, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 15:06:48'),
(183, 26, 11, 31, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-11-12 15:06:57'),
(184, 26, 11, 28, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 15:07:01'),
(185, 26, 11, 28, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-11-12 15:07:04'),
(186, 26, 11, 15, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 15:07:08'),
(188, 26, 11, 15, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-11-12 15:07:43'),
(189, 26, 11, 14, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 15:07:49'),
(190, 26, 11, 13, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 15:07:52'),
(191, 26, 11, 12, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 15:07:56'),
(192, 26, 11, 12, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-11-12 15:07:59'),
(193, 26, 11, 11, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 15:08:02'),
(194, 26, 11, 11, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-11-12 15:08:06'),
(195, 26, 11, 10, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 15:08:10'),
(196, 26, 11, 9, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 15:08:14'),
(198, 26, 11, 7, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 15:08:21'),
(200, 26, 11, 1, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-12 15:08:27'),
(201, 11, 11, 55, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-11-14 06:28:02'),
(202, 13, 11, 55, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-14 06:28:53'),
(203, 13, 11, 55, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-11-14 06:29:15'),
(204, 11, 11, 56, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-11-23 07:28:26'),
(205, 17, 17, 57, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-11-29 07:34:59'),
(207, 11, 17, 58, '8ySPln6LR6FcloxSLDL2Wg==', '2022-11-29 08:50:15'),
(210, 17, 17, 60, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-11-29 10:21:54'),
(214, 24, 11, 61, 'FF1ft8y9bMpHwp4kSHSIAA==', '2022-11-29 11:26:08'),
(215, 11, 11, 62, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-11-29 18:42:19'),
(216, 11, 21, 52, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-12-05 06:16:38'),
(218, 11, 20, 44, '8ySPln6LR6FcloxSLDL2Wg==', '2022-12-05 06:18:05'),
(219, 11, 21, 52, '8ySPln6LR6FcloxSLDL2Wg==', '2022-12-05 06:18:13'),
(220, 11, 13, 35, '8ySPln6LR6FcloxSLDL2Wg==', '2022-12-05 06:20:24'),
(242, 13, 11, 62, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-12-20 06:20:26'),
(243, 13, 11, 62, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-12-20 06:25:22'),
(244, 13, 11, 56, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-12-20 06:26:07'),
(245, 13, 11, 38, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-12-20 06:27:08'),
(246, 13, 11, 38, '8ySPln6LR6FcloxSLDL2Wg==', '2022-12-20 06:27:09'),
(253, 17, 11, 62, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-12-20 06:42:01'),
(263, 11, 22, 39, '8ySPln6LR6FcloxSLDL2Wg==', '2022-12-24 06:43:03'),
(264, 11, 22, 39, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-12-24 06:43:10'),
(265, 21, 21, 64, 'UmJtYQvALxFgkvjSqhSKUA==', '2022-12-24 07:15:33'),
(269, 22, 13, 37, '8ySPln6LR6FcloxSLDL2Wg==', '2022-12-27 08:03:12'),
(270, 22, 11, 62, '8ySPln6LR6FcloxSLDL2Wg==', '2022-12-27 08:03:56'),
(272, 22, 11, 62, 'QJzoP6ZehRn7KFVOOqoh1w==', '2022-12-27 08:04:30'),
(274, 13, 11, 62, '8ySPln6LR6FcloxSLDL2Wg==', '2023-01-11 08:54:51'),
(275, 11, 11, 65, 'HK6rr4her8JtKNIYeMSNAwJh+KPn6T8lpFS0unfXO5Y=', '2023-01-11 09:00:31'),
(277, 41, 41, 67, 'UmJtYQvALxFgkvjSqhSKUA==', '2023-01-13 07:39:11'),
(278, 21, 41, 67, '8ySPln6LR6FcloxSLDL2Wg==', '2023-01-13 07:40:44'),
(279, 21, 41, 67, 'QJzoP6ZehRn7KFVOOqoh1w==', '2023-01-13 07:41:09'),
(281, 11, 11, 56, 'QJzoP6ZehRn7KFVOOqoh1w==', '2023-01-21 07:48:26'),
(284, 11, 17, 60, 'QJzoP6ZehRn7KFVOOqoh1w==', '2023-01-21 11:57:08'),
(288, 11, 20, 3, '8ySPln6LR6FcloxSLDL2Wg==', '2023-01-22 11:38:17'),
(289, 11, 20, 4, '8ySPln6LR6FcloxSLDL2Wg==', '2023-01-22 11:38:21'),
(290, 42, 41, 67, '8ySPln6LR6FcloxSLDL2Wg==', '2023-01-23 05:53:19'),
(292, 42, 42, 68, 'UmJtYQvALxFgkvjSqhSKUA==', '2023-01-23 06:09:31'),
(293, 43, 11, 65, '8ySPln6LR6FcloxSLDL2Wg==', '2023-01-23 10:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `notification_pending`
--

CREATE TABLE `notification_pending` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `notif_id` int NOT NULL,
  `notif_user_id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification_pending`
--

INSERT INTO `notification_pending` (`id`, `post_id`, `notif_id`, `notif_user_id`, `date`) VALUES
(1, 1, 1, 20, '2022-10-29 06:37:41'),
(3, 1, 1, 21, '2022-10-29 06:37:41'),
(5, 1, 1, 23, '2022-10-29 06:37:41'),
(8, 1, 1, 18, '2022-10-29 06:37:41'),
(28, 7, 14, 20, '2022-10-29 06:52:37'),
(29, 7, 14, 13, '2022-10-29 06:52:37'),
(30, 7, 14, 21, '2022-10-29 06:52:37'),
(32, 7, 14, 23, '2022-10-29 06:52:37'),
(35, 7, 14, 18, '2022-10-29 06:52:37'),
(44, 9, 16, 20, '2022-10-29 06:54:07'),
(45, 9, 16, 13, '2022-10-29 06:54:07'),
(46, 9, 16, 21, '2022-10-29 06:54:07'),
(48, 9, 16, 23, '2022-10-29 06:54:07'),
(51, 9, 16, 18, '2022-10-29 06:54:07'),
(52, 10, 17, 20, '2022-10-29 06:54:39'),
(53, 10, 17, 13, '2022-10-29 06:54:39'),
(54, 10, 17, 21, '2022-10-29 06:54:39'),
(56, 10, 17, 23, '2022-10-29 06:54:39'),
(59, 10, 17, 18, '2022-10-29 06:54:39'),
(60, 11, 18, 20, '2022-10-29 06:55:04'),
(61, 11, 18, 13, '2022-10-29 06:55:04'),
(62, 11, 18, 21, '2022-10-29 06:55:04'),
(64, 11, 18, 23, '2022-10-29 06:55:04'),
(67, 11, 18, 18, '2022-10-29 06:55:05'),
(68, 12, 19, 20, '2022-10-29 06:58:53'),
(69, 12, 19, 13, '2022-10-29 06:58:53'),
(70, 12, 19, 21, '2022-10-29 06:58:53'),
(72, 12, 19, 23, '2022-10-29 06:58:53'),
(75, 12, 19, 18, '2022-10-29 06:58:53'),
(76, 13, 20, 20, '2022-10-29 06:59:26'),
(77, 13, 20, 13, '2022-10-29 06:59:26'),
(78, 13, 20, 21, '2022-10-29 06:59:26'),
(80, 13, 20, 23, '2022-10-29 06:59:26'),
(83, 13, 20, 18, '2022-10-29 06:59:26'),
(84, 14, 21, 20, '2022-10-29 07:10:10'),
(85, 14, 21, 13, '2022-10-29 07:10:10'),
(86, 14, 21, 21, '2022-10-29 07:10:10'),
(88, 14, 21, 23, '2022-10-29 07:10:10'),
(91, 14, 21, 18, '2022-10-29 07:10:10'),
(92, 15, 22, 20, '2022-10-29 07:21:57'),
(93, 15, 22, 13, '2022-10-29 07:21:57'),
(94, 15, 22, 21, '2022-10-29 07:21:57'),
(96, 15, 22, 23, '2022-10-29 07:21:57'),
(99, 15, 22, 18, '2022-10-29 07:21:57'),
(128, 22, 49, 15, '2022-10-29 07:35:42'),
(143, 27, 54, 15, '2022-10-29 18:54:04'),
(156, 28, 67, 14, '2022-10-29 19:21:48'),
(157, 28, 67, 20, '2022-10-29 19:21:48'),
(158, 28, 67, 13, '2022-10-29 19:21:48'),
(159, 28, 67, 21, '2022-10-29 19:21:48'),
(161, 28, 67, 23, '2022-10-29 19:21:48'),
(175, 29, 76, 13, '2022-10-29 19:37:35'),
(181, 30, 82, 15, '2022-10-29 19:47:15'),
(182, 31, 83, 14, '2022-10-29 19:47:45'),
(183, 31, 83, 20, '2022-10-29 19:47:45'),
(184, 31, 83, 13, '2022-10-29 19:47:45'),
(185, 31, 83, 21, '2022-10-29 19:47:45'),
(187, 31, 83, 23, '2022-10-29 19:47:45'),
(188, 31, 83, 24, '2022-10-29 19:47:45'),
(192, 31, 83, 18, '2022-10-29 19:47:45'),
(194, 32, 84, 13, '2022-10-30 08:19:39'),
(200, 38, 90, 14, '2022-10-30 09:04:36'),
(201, 38, 90, 20, '2022-10-30 09:04:36'),
(202, 38, 90, 13, '2022-10-30 09:04:36'),
(203, 38, 90, 21, '2022-10-30 09:04:36'),
(205, 38, 90, 23, '2022-10-30 09:04:36'),
(206, 38, 90, 24, '2022-10-30 09:04:36'),
(210, 38, 90, 18, '2022-10-30 09:04:37'),
(212, 40, 92, 14, '2022-10-30 09:35:29'),
(213, 40, 92, 20, '2022-10-30 09:35:29'),
(214, 40, 92, 13, '2022-10-30 09:35:29'),
(215, 40, 92, 21, '2022-10-30 09:35:29'),
(217, 40, 92, 23, '2022-10-30 09:35:29'),
(218, 40, 92, 24, '2022-10-30 09:35:29'),
(222, 40, 92, 18, '2022-10-30 09:35:30'),
(224, 30, 94, 24, '2022-10-30 09:36:37'),
(225, 20, 97, 20, '2022-11-01 05:23:40'),
(239, 46, 110, 14, '2022-11-05 17:41:55'),
(240, 46, 110, 20, '2022-11-05 17:41:55'),
(241, 46, 110, 13, '2022-11-05 17:41:55'),
(242, 46, 110, 21, '2022-11-05 17:41:55'),
(243, 46, 110, 22, '2022-11-05 17:41:55'),
(244, 46, 110, 23, '2022-11-05 17:41:55'),
(245, 46, 110, 24, '2022-11-05 17:41:55'),
(246, 46, 110, 19, '2022-11-05 17:41:55'),
(249, 46, 110, 18, '2022-11-05 17:41:55'),
(333, 55, 201, 14, '2022-11-14 06:28:02'),
(334, 55, 201, 20, '2022-11-14 06:28:02'),
(336, 55, 201, 21, '2022-11-14 06:28:02'),
(337, 55, 201, 22, '2022-11-14 06:28:02'),
(338, 55, 201, 23, '2022-11-14 06:28:02'),
(339, 55, 201, 24, '2022-11-14 06:28:02'),
(340, 55, 201, 19, '2022-11-14 06:28:03'),
(341, 55, 201, 25, '2022-11-14 06:28:03'),
(342, 55, 201, 18, '2022-11-14 06:28:03'),
(345, 56, 204, 27, '2022-11-23 07:28:26'),
(346, 56, 204, 14, '2022-11-23 07:28:26'),
(347, 56, 204, 20, '2022-11-23 07:28:26'),
(348, 56, 204, 13, '2022-11-23 07:28:26'),
(349, 56, 204, 21, '2022-11-23 07:28:26'),
(350, 56, 204, 22, '2022-11-23 07:28:26'),
(351, 56, 204, 23, '2022-11-23 07:28:26'),
(352, 56, 204, 24, '2022-11-23 07:28:26'),
(353, 56, 204, 19, '2022-11-23 07:28:26'),
(354, 56, 204, 25, '2022-11-23 07:28:26'),
(355, 56, 204, 18, '2022-11-23 07:28:26'),
(356, 57, 205, 13, '2022-11-29 07:34:59'),
(358, 58, 207, 17, '2022-11-29 08:50:15'),
(361, 60, 210, 13, '2022-11-29 10:21:54'),
(376, 62, 215, 27, '2022-11-29 18:42:19'),
(377, 62, 215, 14, '2022-11-29 18:42:19'),
(378, 62, 215, 20, '2022-11-29 18:42:19'),
(379, 62, 215, 13, '2022-11-29 18:42:19'),
(380, 62, 215, 21, '2022-11-29 18:42:19'),
(381, 62, 215, 22, '2022-11-29 18:42:19'),
(382, 62, 215, 23, '2022-11-29 18:42:19'),
(384, 62, 215, 24, '2022-11-29 18:42:19'),
(385, 62, 215, 19, '2022-11-29 18:42:19'),
(386, 62, 215, 25, '2022-11-29 18:42:19'),
(387, 62, 215, 18, '2022-11-29 18:42:19'),
(388, 52, 216, 21, '2022-12-05 06:16:39'),
(390, 44, 218, 20, '2022-12-05 06:18:05'),
(391, 52, 219, 21, '2022-12-05 06:18:13'),
(392, 35, 220, 13, '2022-12-05 06:20:25'),
(440, 39, 263, 22, '2022-12-24 06:43:03'),
(441, 39, 264, 22, '2022-12-24 06:43:10'),
(446, 37, 269, 13, '2022-12-27 08:03:12'),
(451, 62, 274, 11, '2023-01-11 08:54:51'),
(452, 65, 275, 27, '2023-01-11 09:00:31'),
(453, 65, 275, 14, '2023-01-11 09:00:31'),
(454, 65, 275, 20, '2023-01-11 09:00:31'),
(455, 65, 275, 13, '2023-01-11 09:00:31'),
(456, 65, 275, 21, '2023-01-11 09:00:31'),
(457, 65, 275, 22, '2023-01-11 09:00:31'),
(458, 65, 275, 23, '2023-01-11 09:00:31'),
(459, 65, 275, 24, '2023-01-11 09:00:31'),
(460, 65, 275, 19, '2023-01-11 09:00:31'),
(461, 65, 275, 25, '2023-01-11 09:00:31'),
(462, 65, 275, 18, '2023-01-11 09:00:31'),
(463, 67, 278, 41, '2023-01-13 07:40:44'),
(464, 67, 279, 41, '2023-01-13 07:41:09'),
(469, 60, 284, 17, '2023-01-21 11:57:08'),
(471, 64, 286, 21, '2023-01-22 11:17:52'),
(473, 3, 288, 20, '2023-01-22 11:38:17'),
(474, 4, 289, 20, '2023-01-22 11:38:21'),
(475, 67, 290, 41, '2023-01-23 05:53:19');

-- --------------------------------------------------------

--
-- Table structure for table `online_users`
--

CREATE TABLE `online_users` (
  `id` int NOT NULL,
  `activite_user_id` int NOT NULL,
  `status` varchar(255) NOT NULL,
  `current_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `online_users`
--

INSERT INTO `online_users` (`id`, `activite_user_id`, `status`, `current_date_time`) VALUES
(10, 24, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2022-10-30 09:46:15'),
(11, 15, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2022-10-29 20:36:49'),
(12, 21, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2022-11-06 06:36:36'),
(13, 11, 'mhBBjxO2Y68p6UugBD3s3Q==', '2023-08-22 07:19:50'),
(14, 23, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2022-10-26 20:14:22'),
(15, 17, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2022-12-26 12:24:18'),
(16, 22, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2023-01-18 18:07:39'),
(17, 20, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2023-01-17 20:28:34'),
(18, 13, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2023-01-23 10:30:01'),
(19, 14, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2023-01-22 11:20:39'),
(20, 19, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2022-11-03 07:12:26'),
(21, 25, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2022-11-08 07:38:57'),
(22, 16, 'mhBBjxO2Y68p6UugBD3s3Q==', '2022-11-06 20:04:27'),
(23, 27, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2022-12-02 08:42:39'),
(24, 28, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2022-11-12 14:44:12'),
(25, 30, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2022-11-29 20:15:18'),
(26, 26, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2022-12-02 08:30:44'),
(27, 41, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2023-01-23 17:05:51'),
(28, 42, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2023-01-23 11:33:18'),
(29, 43, 'BZUk1TEvez8Lj6Pn4tDFyg==', '2023-01-23 10:13:57');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `post_text` text,
  `post_file_name` varchar(255) DEFAULT NULL,
  `post_file_type` varchar(255) DEFAULT NULL,
  `post_status` varchar(255) NOT NULL,
  `admin_status` varchar(255) NOT NULL,
  `post_delete` varchar(255) NOT NULL DEFAULT 'NULL',
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_text`, `post_file_name`, `post_file_type`, `post_status`, `admin_status`, `post_delete`, `post_date`) VALUES
(1, '11', '51bG2gFk9iZMe3rT49gfhenacKClRuq0xUcXIEpitJw=', '46GyppDFQ0lhOa/Jod2G0Q==', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 06:37:41'),
(2, '11', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'ZLUorCYb8zhOqM09NXVvMzCOs6ndlxoEO/y+a4t0LNEusWkkIiT/KReoDLai3nVrtHh8wV+WklIt4H2Q0zlcng==', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', 'h43qhZZfC+vTmlbKUFxjLQ==', '9CXT3VqmgIQUzxNN9U7ckg==', '2022-10-29 06:37:54'),
(3, '20', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'p3ibeIRJWShvYzR0BCMev05K1EC8pBVm7Utpy7PhBQhOER1vD+g7MndDWpRiAiEo', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 06:38:41'),
(4, '20', '51bG2gFk9iZMe3rT49gfhenacKClRuq0xUcXIEpitJw=', 'qV+F5A57pdez97evUuhvc9vMp+25ORKWAVAUOhLzvstcnY90tTS8VLlRq96wsD86', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 06:38:49'),
(5, '13', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'WACwhVWPqVgX5pMJPB9nUj2hO4Z/jCTOHH5VXr9fxCWYL8CALi7Xds97AUcUf2Ig', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 06:39:42'),
(6, '13', '51bG2gFk9iZMe3rT49gfhenacKClRuq0xUcXIEpitJw=', 'gxxmB3nQF2Ki37Y2WnbyrfrLmsgetKXhXOr00rfZ2SbDVm09UpBLeU7rGF/qQhdj5bNDU7yeHguWmRI6/Tziow==', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 06:41:57'),
(7, '11', 'dB0HjWrey8W5sP9kvAjjnQ==', 'UOYSS+PdN9+LWuSSOggqzcfgUXM0T8SlQ+hPZrSzjeo=', 'video/mp4', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 06:52:37'),
(8, '11', 'wGUyYEyxjF5Kw2gjnw9jJE3cV7dNOU60P4SzLIZkSDA=', 'pxY6Uk6iUadXYRbb9D4uIuVhPp9HiJ00/ZW30CJxeUk=', 'video/mp4', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 06:53:23'),
(9, '11', 'uffXNWb16dWpYoHiM55L5A==', 'yJCAv0zfzoHMMhQdlEU/L5HCEqJZDMXB9DNhd1T5zYBntOViGYqvActLGWOD35vmQZ1A0ibV05CI9z2QQs6ERA==', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 06:54:07'),
(10, '11', NULL, 'Q5LArpSbMtiGc9AKViMidjDgxUHKCyMJtVHT0vQ3FaFbM861dnOOwIaA/7E45d9y', 'image/png', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 06:54:38'),
(11, '11', '4SDvvcXH5uSBD4ZeMlmDeg==', 'a9jAKP1ay7QIjBhMzl6AKK+TnKnlu1SUdTpXFK6SPodespRQp1cpa05aozBAXyZ3', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 06:55:04'),
(12, '11', NULL, '5Un9WzXxAV78b4zU/ZU1MsW6UbgsR7p31WPXC/CfQuM=', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 06:58:53'),
(13, '11', NULL, 'KwFrRyNbwSdZ3fdOtMlKfUAL5cgjnF/t/bdS1LXB04Q=', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 06:59:26'),
(14, '11', NULL, 'nMOX60h+m8/wSmSIE5T0YusKWz993hjwDQRH9Wrt0q4=', 'video/mp4', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 07:10:09'),
(15, '11', NULL, 'qu+16Nbdf39TljSQynM4bwnD+pixcjMkOmE8lL3GjHY=', 'video/mp4', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 07:21:57'),
(16, '15', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'Ql0tJmGqPBEJ/FEJxm2eXxoCM7lSIq0qCSP3loeZRj77X2dy+GW1Xs2/Li37XmjRxOprVyoDM5vep0AKdWZqxw==', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 07:30:32'),
(17, '15', '51bG2gFk9iZMe3rT49gfhenacKClRuq0xUcXIEpitJw=', 'KV00MOpoznWgXRfX2Z8PJRigxuUO5A3m/S/994fnzedy6/wHD/Tf1vgZC3qKgi5k', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 07:30:45'),
(18, '21', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'oxRAm2FvEGXV90YE7NWH6v2ecRnHPeNfVjvilfh/+QX31nDx3IPw+DzRGuGkXG3W', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 07:32:11'),
(19, '21', '51bG2gFk9iZMe3rT49gfhenacKClRuq0xUcXIEpitJw=', 'Awsfe1tk/I4Qnvca0LN3u/dQUc6YYR8KMoa84daBKo0ZxbrJLXqN+JEs2e1DuEcxsk0ALZtCSPHpIae/OMaXAg==', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 07:32:20'),
(20, '20', 'nNnI9lydL/FonOdx/FseQNz7c9VWDAj2MJOuyzV44Nom1L/LF7DSBo8jQoWyO0gV', NULL, NULL, 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 07:33:55'),
(21, '23', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', '5jD4472Jqg9L3siRZ8PDGPkzZ1g6uTBDj3mOqBlplQvpmMCj43jSu1aanx9Nh8Rc', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 07:34:48'),
(22, '24', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'gk7g3VixJFL62pqq2MqdUGPvevm5AnV1KtMHxzKRarRZk6BLVnZ4L1OVhDRQMIayO21s5GQXbWl+nKYQJx5g9A==', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 07:35:42'),
(23, '15', '/76llA3aFXzK7p1BteHaWw==', NULL, NULL, 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 10:50:34'),
(24, '21', 'ZR0eOmSIn22Uv6hNSg1vEcfW/7mtBOMAshgTkqvQzTtN6Nf94BMLiF1LYr9hPLbn', NULL, NULL, 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 11:30:22'),
(26, '19', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'KpzRSqcA9VYmF6R/8wKwyr3/ChQBPYQ20UXTpVc/1sOC5glYt2zHqSODEUxZ2WMwk3oMXxNt98DSOltLfEpMyA==', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 18:53:22'),
(27, '24', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'E3t5yv8Dt9x7/7CPMoxEknLcmmyrBQ7CotBfo38p6PjesxFmvrh/oZ7im+CP4sUQf02S+FdZ4nme34SzJLpYXA==', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 18:54:04'),
(28, '11', NULL, 'zHXWcP02c8xdqhgAN/ANtAPir6Tm+p3/e5Zu3iuQuwszLVc9wexi0NSZuN6O0obX', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 19:21:47'),
(29, '17', NULL, '193WoK6ORgEmtJY81InUX1QtFi+mTp6pPTzN9dv6a8XH1qaN/rgLHgpQtM+w0KXrDUwWAjIfhLfYd/lsxgRw3w==', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 19:37:35'),
(30, '24', 'KbYEj33X03H4+WjxgCjjYb4AFtSLjkIeeBPVwY3UZuA=', NULL, NULL, 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 19:47:15'),
(31, '11', 'HYe4VWmkJGbhE23gMofE9A==', NULL, NULL, 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-29 19:47:45'),
(32, '17', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'IhYGJNQsV/Nc1kqp4844BIlj2ihWeLu/tNLnEhlTVa2rODY3XmuZ58NFQFPpS+1X', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-30 08:19:37'),
(33, '14', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'ahn3scpuiyvXlWkl0dNSQN6hLvus/FPoRsY7ozN/fHzKpow59C/MBTOciVZ5qTcU', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-30 08:58:41'),
(35, '13', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'BxqqWUGPBCUSOruVfHiWLZnCX5TVxSlgOZDXfWSS57kAfqPicPxknqajH/6kJIzU', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-30 09:02:00'),
(36, '13', '51bG2gFk9iZMe3rT49gfhenacKClRuq0xUcXIEpitJw=', 'POJf0DmJAMpmfRWndGB5zN0obswa49R771DMQp4WStPGCHUH9jE3/cHCe4rCiuOgQxKOA7S5u8S0yBAKynvOo0hsxKXdZQqHlhwGsveDmmw=', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-30 09:02:11'),
(37, '13', '6FIHDYh8PieTTVDBfMEpUw==', NULL, NULL, 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-30 09:02:55'),
(38, '11', NULL, 'G8cRjAkfztU7jsrVjcxIgM1A2FqKC/ujEfAEi6OqoNtgWM36TTxwnzjKBpcfzoaH', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-30 09:04:36'),
(39, '22', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', '9vKO8n5eo0QAykVNNZ/bV8JDhgrQ4proVT7cpJ7fUj6H9dz3Ep/4J3GZxt17zq2v', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-30 09:06:33'),
(40, '11', 'uWr3cXdd9n0lj5DOKphZZw==', NULL, NULL, 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-10-30 09:35:29'),
(42, '14', NULL, 'pRuBaSZ0hst+n+5nN0lSZA==', 'video/mp4', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-04 17:42:26'),
(44, '20', 'Ze/Yu0M9b3wUSvsGsWpJ0w==', 'ATm6jDi2vw+eExmUCzouMw==', 'video/mp4', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-04 17:51:08'),
(45, '17', NULL, 'EYSxAcj7jXyhFHibqNMpVQ==', 'video/mp4', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-04 17:56:11'),
(46, '11', 'Ot4mt9qcF/yUU96NGlBHVKNMSL5og3/IxTGVchK9bLo=', 'yuIM3Vmit1i0G7VD8a9cU+RTwsKFb9uyrTXOeUSa8lM=', 'video/mp4', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-05 17:41:55'),
(48, '25', '51bG2gFk9iZMe3rT49gfhenacKClRuq0xUcXIEpitJw=', 'jHaNasYr+oASCB9rfayArUwSvdR1WSmVWaKYOL6VxaAvTZzSBwzhIz79FOQzhHoX', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-06 05:56:45'),
(49, '25', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'HRJOzoUgfEvCVrf/ByHxK/4JjiHGnvJEEjPhipC3JnSWBYF7HPKnAtbWWVlDp2+k', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-06 05:58:23'),
(51, '16', '51bG2gFk9iZMe3rT49gfhenacKClRuq0xUcXIEpitJw=', 'boEaxIFeg2hkrEv7ikfaA9/hWWcJ0+O0SaiO+36dZTlg785ycSbPDfbVXXBJgAy9', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-06 06:01:48'),
(52, '21', NULL, 'cAvz5dzEcxOUVGhtT+Zx/g==', 'video/mp4', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-06 06:16:23'),
(53, '16', 'xj9M4hVL2CVKn+hm1xNF1Qdi1JAMARo2Ls3D0aInr6stSVXy9Aqn16sWVCqBXz+PRoS6oD1l8D3k5C+DpfEakC8Q2jLBcL8+YoutyjEeE+c=', NULL, NULL, 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-06 13:32:11'),
(54, '16', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'n56wt4fx1mzqK+P4DryiMztGSHl6uqxvWq3zMz7DfmFxOt6Y+oQNWrhJSm97yx0mmMlrBWQViiZFpbnreSrLoSoqsT3sK2zmOdnrGj/h06w=', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-06 13:33:17'),
(55, '11', '9V1fpN6PtAMoR1mLbSKWBPOFepi6qU9Iv/MB3e6A9QU=', NULL, NULL, 'twWDK6lcAWGMrrbPLz9DKA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-14 06:28:02'),
(56, '11', NULL, 'ZuUut3JtnNaVX8quW4Xcpl4CFFIORzswQWn4Ax3uUb+uoy7tdsYinngQG91a5C9RqRx4PAC3w9uDt5hrpb0cXg==', 'image/jpeg', 'twWDK6lcAWGMrrbPLz9DKA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-23 07:28:26'),
(57, '17', 'VGUWbAKah8bLRUBkNv4yog2X9CWv0q35cIr8qUs/Uq0=', '72j11/kvTFZfjsv7N/6Zqw==', 'audio/mpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-29 07:34:59'),
(58, '17', '7vdflHMHVype22MCkPosKGIIROULeS9kr+tgKt8DVxM=', 'n0QMDoONptIB4lJ0GSgxtw==', 'audio/mpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-29 08:38:07'),
(60, '17', 'uWr3cXdd9n0lj5DOKphZZw==', NULL, NULL, 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-29 10:21:54'),
(62, '11', NULL, 'gIYOnenxsRNNJzyw0Ze0WTrSvJ+X72Rn2c3tugWnUeFPHPX657r5CFyDD+bdLm3I7TE4eHKFl/0AYhRuFZ4JE42BsV2o/mvhQhp5AjuwI5Q=', 'audio/mpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-11-29 18:42:19'),
(63, '22', NULL, 'oGb0csTj18MRALTxL6somQ==', 'audio/mpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-12-05 06:53:24'),
(64, '21', '2h4jsxuycYSaOi7HAd6485Lw11epERGcRbZktmfOz2E=', NULL, NULL, 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2022-12-24 07:15:33'),
(65, '11', 'NMhoWkek61IPXaKdxIqq8N4rsY93WrvPI2+Nn/kRE1Q=', 'sQndj1M+ZHA/a6Fw/h7afkWpPpz53HqI+rsj5v2//zFVhHLGDx1aoBdKj7icaRZK112mRbqXzkX71EyUMKhfnA==', 'image/jpeg', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2023-01-11 09:00:31'),
(66, '41', 'srtOxZglLoCSupkBROFrsbKoYsf0fxRLpA7RkIubkDo=', NULL, NULL, 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'UwYFDOooyP5WaWhrGDNqcg==', '2023-01-13 07:38:23'),
(67, '41', 'QsHGfyj9B4fSx9dYLo0X5itmSVfLkfjhJr2XjRq4Am8=', NULL, NULL, 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2023-01-13 07:39:11'),
(68, '42', NULL, 'J3Urj1wp5UsRs0+x3exdfVuap+YLfOJZeVkRcF/1avU=', 'video/mp4', 'njVAWfgJ8VddJZq1FVKXSA==', '2NZG5t0QMqo4s2M/WG9H7w==', 'NULL', '2023-01-23 06:09:31');

-- --------------------------------------------------------

--
-- Table structure for table `posts_likes`
--

CREATE TABLE `posts_likes` (
  `id` int NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `likes` int DEFAULT NULL,
  `dislikes` int DEFAULT NULL,
  `like_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts_likes`
--

INSERT INTO `posts_likes` (`id`, `post_id`, `user_id`, `likes`, `dislikes`, `like_date`) VALUES
(1, '2', '13', 1, 0, '2022-10-29 06:42:36'),
(2, '1', '13', 0, 1, '2022-10-29 06:46:17'),
(3, '2', '20', 1, 0, '2022-10-29 06:46:29'),
(4, '1', '20', 1, 0, '2022-10-29 06:46:55'),
(5, '15', '20', 1, 0, '2022-10-29 07:22:23'),
(6, '15', '13', 1, 0, '2022-10-29 07:22:46'),
(7, '14', '13', 1, 0, '2022-10-29 07:23:05'),
(8, '14', '20', 1, 0, '2022-10-29 07:23:12'),
(9, '13', '20', 1, 0, '2022-10-29 07:23:27'),
(10, '13', '13', 1, 0, '2022-10-29 07:23:39'),
(11, '12', '13', 1, 0, '2022-10-29 07:23:43'),
(12, '11', '20', 0, 1, '2022-10-29 07:23:50'),
(14, '12', '20', 1, 0, '2022-10-29 07:24:21'),
(15, '10', '20', 0, 1, '2022-10-29 07:24:34'),
(16, '11', '13', 1, 0, '2022-10-29 07:24:47'),
(17, '10', '13', 0, 1, '2022-10-29 07:24:50'),
(18, '9', '13', 1, 0, '2022-10-29 07:24:54'),
(19, '25', '24', 1, 0, '2022-10-29 18:54:41'),
(21, '14', '24', 0, 1, '2022-10-29 18:55:13'),
(22, '13', '24', 0, 1, '2022-10-29 18:55:15'),
(23, '12', '24', 0, 1, '2022-10-29 18:57:59'),
(24, '15', '24', 1, 0, '2022-10-29 19:03:19'),
(27, '28', '24', 1, 0, '2022-10-29 19:44:09'),
(28, '40', '17', 1, 0, '2022-10-30 09:36:23'),
(29, '30', '17', 1, 0, '2022-10-30 09:36:37'),
(30, '1', '24', 0, 1, '2022-10-30 09:46:35'),
(31, '20', '11', 1, 0, '2022-11-01 05:23:40'),
(38, '40', '25', 1, 0, '2022-11-05 18:40:53'),
(39, '28', '25', 0, 1, '2022-11-06 05:47:27'),
(41, '38', '25', 1, 0, '2022-11-06 05:47:55'),
(42, '13', '25', 1, 0, '2022-11-06 05:48:00'),
(43, '12', '25', 1, 0, '2022-11-06 05:48:01'),
(44, '11', '25', 1, 0, '2022-11-06 05:48:05'),
(45, '10', '25', 1, 0, '2022-11-06 05:48:06'),
(46, '2', '25', 1, 0, '2022-11-06 05:48:09'),
(47, '9', '25', 0, 1, '2022-11-06 05:48:10'),
(48, '1', '25', 1, 0, '2022-11-06 05:48:15'),
(50, '15', '25', 1, 0, '2022-11-06 05:49:09'),
(51, '14', '25', 1, 0, '2022-11-06 05:49:13'),
(52, '8', '25', 1, 0, '2022-11-06 05:49:18'),
(53, '46', '25', 1, 0, '2022-11-06 06:05:50'),
(54, '46', '16', 1, 0, '2022-11-06 06:06:29'),
(55, '40', '16', 0, 1, '2022-11-06 06:06:44'),
(56, '38', '16', 1, 0, '2022-11-06 06:06:50'),
(57, '31', '16', 1, 0, '2022-11-06 06:06:57'),
(58, '28', '16', 1, 0, '2022-11-06 06:07:01'),
(59, '15', '16', 1, 0, '2022-11-06 06:07:05'),
(60, '14', '16', 0, 1, '2022-11-06 06:07:10'),
(61, '13', '16', 1, 0, '2022-11-06 06:07:13'),
(62, '12', '16', 0, 1, '2022-11-06 06:07:16'),
(63, '11', '16', 0, 1, '2022-11-06 06:07:19'),
(64, '10', '16', 0, 1, '2022-11-06 06:07:22'),
(65, '9', '16', 1, 0, '2022-11-06 06:07:26'),
(66, '8', '16', 1, 0, '2022-11-06 06:07:29'),
(67, '7', '16', 1, 0, '2022-11-06 06:07:32'),
(68, '2', '16', 1, 0, '2022-11-06 06:07:36'),
(69, '1', '16', 0, 1, '2022-11-06 06:07:38'),
(70, '44', '11', 1, 0, '2022-11-06 06:08:43'),
(72, '46', '27', 1, 0, '2022-11-12 14:46:30'),
(73, '40', '27', 1, 0, '2022-11-12 14:46:37'),
(74, '38', '27', 1, 0, '2022-11-12 14:46:51'),
(75, '31', '27', 1, 0, '2022-11-12 14:46:55'),
(76, '28', '27', 0, 1, '2022-11-12 14:46:59'),
(77, '15', '27', 1, 0, '2022-11-12 14:47:04'),
(78, '14', '27', 0, 1, '2022-11-12 14:47:07'),
(79, '13', '27', 1, 0, '2022-11-12 14:47:10'),
(80, '12', '27', 0, 1, '2022-11-12 14:47:13'),
(81, '11', '27', 1, 0, '2022-11-12 14:47:17'),
(82, '10', '27', 0, 1, '2022-11-12 14:47:20'),
(83, '9', '27', 1, 0, '2022-11-12 14:47:24'),
(84, '8', '27', 1, 0, '2022-11-12 14:47:27'),
(85, '7', '27', 1, 0, '2022-11-12 14:47:31'),
(86, '2', '27', 1, 0, '2022-11-12 14:47:34'),
(87, '1', '27', 1, 0, '2022-11-12 14:47:37'),
(88, '46', '26', 1, 0, '2022-11-12 15:06:18'),
(89, '40', '26', 0, 1, '2022-11-12 15:06:20'),
(90, '38', '26', 0, 1, '2022-11-12 15:06:26'),
(91, '31', '26', 1, 0, '2022-11-12 15:06:48'),
(92, '28', '26', 1, 0, '2022-11-12 15:07:01'),
(93, '15', '26', 1, 0, '2022-11-12 15:07:09'),
(94, '14', '26', 1, 0, '2022-11-12 15:07:49'),
(95, '13', '26', 1, 0, '2022-11-12 15:07:52'),
(96, '12', '26', 1, 0, '2022-11-12 15:07:56'),
(97, '11', '26', 1, 0, '2022-11-12 15:08:02'),
(98, '10', '26', 1, 0, '2022-11-12 15:08:10'),
(99, '9', '26', 1, 0, '2022-11-12 15:08:14'),
(100, '8', '26', 1, 0, '2022-11-12 15:08:17'),
(101, '7', '26', 1, 0, '2022-11-12 15:08:21'),
(102, '2', '26', 1, 0, '2022-11-12 15:08:24'),
(103, '1', '26', 1, 0, '2022-11-12 15:08:27'),
(104, '55', '13', 1, 0, '2022-11-14 06:28:53'),
(105, '58', '11', 1, 0, '2022-11-29 08:50:15'),
(108, '61', '24', 0, 1, '2022-11-29 11:26:07'),
(109, '52', '11', 1, 0, '2022-12-05 06:18:13'),
(110, '35', '11', 1, 0, '2022-12-05 06:20:25'),
(111, '63', '11', 1, 0, '2022-12-05 07:00:08'),
(112, '38', '13', 1, 0, '2022-12-20 06:27:09'),
(113, '8', '13', 0, 1, '2022-12-20 06:28:42'),
(114, '8', '15', 1, 0, '2022-12-20 06:48:08'),
(115, '42', '22', 0, 1, '2022-12-20 06:50:13'),
(116, '42', '23', 1, 0, '2022-12-20 06:52:01'),
(117, '39', '11', 1, 0, '2022-12-24 06:43:03'),
(119, '37', '22', 1, 0, '2022-12-27 08:03:12'),
(120, '62', '22', 1, 0, '2022-12-27 08:03:56'),
(121, '42', '11', 1, 0, '2023-01-03 17:05:56'),
(122, '62', '13', 1, 0, '2023-01-11 08:54:51'),
(123, '67', '21', 1, 0, '2023-01-13 07:40:44'),
(124, '3', '11', 1, 0, '2023-01-22 11:38:17'),
(125, '4', '11', 1, 0, '2023-01-22 11:38:21'),
(126, '67', '42', 1, 0, '2023-01-23 05:53:19'),
(127, '65', '43', 1, 0, '2023-01-23 10:01:01');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `id` int NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'NULL',
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `post_id`, `user_id`, `comment`, `status`, `comment_date`) VALUES
(9, '2', '13', '9i9xfFUPEKdtioCcvTQsfw==', 'NULL', '2022-10-29 06:46:02'),
(10, '2', '20', 'id+Zl4XRTBVy2xKSMYHduQ==', 'NULL', '2022-10-29 06:46:47'),
(11, '1', '20', 'G1LmTxzCAwNNW0Bd14qSUA==', 'NULL', '2022-10-29 06:46:59'),
(12, '15', '20', 'LswTVQXpTQ5H+vJlmIkDsA==', 'NULL', '2022-10-29 07:22:33'),
(13, '15', '13', 'Lh1cGoemS/vHzMNDclxlTw==', 'NULL', '2022-10-29 07:22:59'),
(14, '14', '13', '+zSD1DMLYHLlxdmyxxf7sg==', 'NULL', '2022-10-29 07:23:10'),
(15, '14', '20', 'Jly8OkMy+IIbRYkL8t7a8A==', 'NULL', '2022-10-29 07:23:20'),
(16, '9', '13', 'FpcbEWxQgeUXRLjbyWQg3Q==', 'NULL', '2022-10-29 07:24:58'),
(17, '25', '24', 'w2QedubvdTeivZjFFoJ38g==', 'NULL', '2022-10-29 18:54:57'),
(18, '15', '24', 'M5GbD/w3Mz4zzFhpKKRB3A==', 'NULL', '2022-10-29 18:55:08'),
(19, '13', '24', 'FpcbEWxQgeUXRLjbyWQg3Q==', 'NULL', '2022-10-29 18:55:20'),
(20, '1', '24', 'ZDlWD5WMk25xlRB3ZGFeOw==', 'NULL', '2022-10-29 19:36:21'),
(21, '8', '25', 'lHz6M6irY8UlK6LfDCoHRg==', 'NULL', '2022-11-05 17:47:12'),
(22, '40', '27', 'rVq3cLppGNMy6E/pp/+y2Q==', 'NULL', '2022-11-12 14:46:45'),
(23, '38', '26', 'to2tZyXjBK7bz37UBPV8GQ==', 'NULL', '2022-11-12 15:06:42'),
(24, '31', '26', 'QlFU9hENNICy45RZmCvjmQ==', 'NULL', '2022-11-12 15:06:57'),
(25, '28', '26', 'FpcbEWxQgeUXRLjbyWQg3Q==', 'NULL', '2022-11-12 15:07:04'),
(27, '15', '26', 'BnsCW3SPkRNsaStdiw81jQ==', 'NULL', '2022-11-12 15:07:43'),
(28, '12', '26', 'M5GbD/w3Mz4zzFhpKKRB3A==', 'NULL', '2022-11-12 15:07:59'),
(29, '11', '26', '+zSD1DMLYHLlxdmyxxf7sg==', 'NULL', '2022-11-12 15:08:06'),
(30, '55', '13', 'i2JQ5Byfcov3xts3CsHnHsrBLfewe3s2H6LvYl6qL29vmusFG/rhcTZFEmK1/OFd', 'NULL', '2022-11-14 06:29:15'),
(31, '52', '11', '8cWVBpXMscEvrFbVwW5ODA==', 'NULL', '2022-12-05 06:16:38'),
(32, '44', '11', 'Q0Y+6kY5JPmlfKCNx4UJCA==', 'NULL', '2022-12-05 06:17:41'),
(42, '35', '11', 'BigKLuo4iVw+MW5uU3xIDA==', 'NULL', '2022-12-05 06:30:18'),
(47, '35', '11', 'BigKLuo4iVw+MW5uU3xIDA==', 'NULL', '2022-12-05 06:37:22'),
(48, '35', '11', 'BigKLuo4iVw+MW5uU3xIDA==', 'NULL', '2022-12-05 06:37:57'),
(49, '35', '11', 'BigKLuo4iVw+MW5uU3xIDA==', 'NULL', '2022-12-05 06:41:32'),
(50, '56', '11', 'BigKLuo4iVw+MW5uU3xIDA==', 'eMi9wXyGBk4KIJl3MCRcIQ==', '2022-12-13 08:53:49'),
(60, '42', '11', 'tpVSzY4P1SoLHFxOInpsWw==', 'NULL', '2022-12-18 10:01:22'),
(63, '62', '13', 'G1LmTxzCAwNNW0Bd14qSUA==', 'NULL', '2022-12-20 06:25:22'),
(64, '56', '13', '+zSD1DMLYHLlxdmyxxf7sg==', 'NULL', '2022-12-20 06:26:07'),
(65, '38', '13', 'vLfWP06K1P0y+Ee+86UVpQ==', 'eMi9wXyGBk4KIJl3MCRcIQ==', '2022-12-20 06:27:08'),
(66, '38', '11', 'BigKLuo4iVw+MW5uU3xIDA==', 'eMi9wXyGBk4KIJl3MCRcIQ==', '2022-12-20 06:27:53'),
(67, '8', '13', 'fAnQXIXL2H8BHteoqEvKxWyVDK0vY6Izo2yO33axpVE=', 'eMi9wXyGBk4KIJl3MCRcIQ==', '2022-12-20 06:28:55'),
(68, '63', '11', 'llxG9eEAE/QOzpfXZ8M4iCHpSN+Xh7E+6oKGDVO4o6Q=', 'eMi9wXyGBk4KIJl3MCRcIQ==', '2022-12-20 06:32:53'),
(70, '63', '13', 'FpcbEWxQgeUXRLjbyWQg3Q==', 'NULL', '2022-12-20 06:40:58'),
(71, '62', '17', 'WIjhUOJZOEAxdJL2FZI/gQ==', 'NULL', '2022-12-20 06:42:01'),
(72, '63', '17', 'z5qT3s210XV4pVFmR2CKyQ==', 'Sb+E3FxKst1QSEkdBESytA==', '2022-12-20 06:43:13'),
(73, '8', '22', 'WIjhUOJZOEAxdJL2FZI/gQ==', 'Sb+E3FxKst1QSEkdBESytA==', '2022-12-20 06:45:16'),
(74, '8', '15', '+zSD1DMLYHLlxdmyxxf7sg==', 'NULL', '2022-12-20 06:48:14'),
(75, '42', '22', 'DisIKApYLxHx8MT8D4D72g==', 'Sb+E3FxKst1QSEkdBESytA==', '2022-12-20 06:50:22'),
(76, '42', '21', 'UpDB58mXhInQYpj5FBLD7Q==', 'NULL', '2022-12-20 06:51:06'),
(77, '42', '23', 'z5qT3s210XV4pVFmR2CKyQ==', 'eMi9wXyGBk4KIJl3MCRcIQ==', '2022-12-20 06:52:10'),
(78, '39', '11', '2bdfzypLDhtalVrGM414Sw==', 'NULL', '2022-12-24 06:43:10'),
(79, '63', '22', 'ts+nB1AnyvZbXwNXWhOhrA==', 'eMi9wXyGBk4KIJl3MCRcIQ==', '2022-12-27 07:54:28'),
(80, '63', '22', '8++zSBFsFPwZCdVNkedr6Q==', 'NULL', '2022-12-27 07:54:44'),
(81, '62', '22', 'PgxIMwU0YdSsmQoyLVwdsQ==', 'Sb+E3FxKst1QSEkdBESytA==', '2022-12-27 08:04:11'),
(82, '62', '22', '+zSD1DMLYHLlxdmyxxf7sg==', 'NULL', '2022-12-27 08:04:30'),
(83, '67', '21', 'BQl4LS1U+PiSnQmExWYIpQ==', 'NULL', '2023-01-13 07:41:09'),
(84, '65', '11', 'sup6zpPkK+NMu09IMR7rfg==', 'eMi9wXyGBk4KIJl3MCRcIQ==', '2023-01-21 07:47:58'),
(85, '56', '11', 'ts+nB1AnyvZbXwNXWhOhrA==', 'NULL', '2023-01-21 07:48:26'),
(86, '65', '11', 'sup6zpPkK+NMu09IMR7rfg==', 'eMi9wXyGBk4KIJl3MCRcIQ==', '2023-01-21 07:49:10'),
(87, '65', '11', 'CYErylaczwt6hElYR5tSKg==', 'eMi9wXyGBk4KIJl3MCRcIQ==', '2023-01-21 07:49:19'),
(88, '60', '11', 'uWr3cXdd9n0lj5DOKphZZw==', 'NULL', '2023-01-21 11:57:08'),
(89, '64', '11', 'BigKLuo4iVw+MW5uU3xIDA==', 'Sb+E3FxKst1QSEkdBESytA==', '2023-01-22 11:17:43'),
(90, '64', '11', 'UfiGK88oPG+sX61xbXzHsA==', 'Sb+E3FxKst1QSEkdBESytA==', '2023-01-22 11:17:52'),
(91, '65', '11', 'Ej5LN52cz1M3Jd0JZPD5wQ==', 'eMi9wXyGBk4KIJl3MCRcIQ==', '2023-01-22 11:18:27'),
(92, '67', '42', 'bmqk5XQePuicjt29c9/miw==', 'Sb+E3FxKst1QSEkdBESytA==', '2023-01-23 05:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `post_complaint`
--

CREATE TABLE `post_complaint` (
  `id` int NOT NULL,
  `complaint_user_id` varchar(225) NOT NULL,
  `post_user_id` int NOT NULL,
  `post_id` varchar(225) NOT NULL,
  `complaint` text NOT NULL,
  `post_file_name` text NOT NULL,
  `admin_id` int DEFAULT NULL,
  `adminMsg` text,
  `admin_action` varchar(255) NOT NULL DEFAULT 'Null',
  `complaint_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_complaint`
--

INSERT INTO `post_complaint` (`id`, `complaint_user_id`, `post_user_id`, `post_id`, `complaint`, `post_file_name`, `admin_id`, `adminMsg`, `admin_action`, `complaint_date`, `updated_at`) VALUES
(1, '13', 11, '8', 'b+RTDV+Wm/ORH1hJ9eMXz334p4JyipjaL1w2evACv9c0uZhUgu/wgyaKzNGqlFdY', 'KCqrvSSH7cH3RXh22uQUL3yEdj0ZB46jO2jbs446XjhpgKp4LUQhyiGE183Gwu9O', NULL, NULL, 'Null', '2022-12-06 18:11:08', '2023-01-04 17:42:14'),
(2, '24', 14, '42', 'CxVzBoLlhp2jZEPUD/h5aqNpM1Q/a89S7GXfC9kKLXs=', '81gCRCy3QbA/a+OSn/iQsGZUO6fkAvQxKSIOTFwKJpQ=', NULL, NULL, 'Null', '2022-12-06 18:16:05', '2023-01-03 17:57:46'),
(3, '11', 22, '63', 'cURnFCj9vg4k/vhmqqOb87yxUE5W0eitNI1BkAm6WuU=', '7nBA6frkldH2teAQGTWQNW+onmXvfCRiL40nEWAxczg=', NULL, NULL, 'Null', '2022-12-18 09:28:17', '2022-12-31 08:41:51'),
(4, '11', 17, '45', 'wySXAB6o36rI5Je5miyZvA==', '14uFpbrKb5G7qJ7FqkheYGam41tHr9LlE+E6CceS1Fw=', NULL, NULL, 'Null', '2022-12-18 09:30:14', '2023-01-04 17:56:05'),
(13, '13', 22, '63', '2krg8usgCr68/d17bwYSAQ==', 't0UTGhGAO4rKTd8TemKqDyhXTur6d5ifFzeEuuQT9rg=', NULL, NULL, 'Null', '2022-12-27 09:33:54', '2022-12-31 08:41:55'),
(14, '24', 22, '63', 'MDvb6n04oAqs2nDRJfGDDaZUba8zRMzeBIChHMFAi/csEu5L8cmgsqHzOZWpzsaq', 'aCvdLOE08XVfvm0Uxtu5NGCesN3LaDLF1kbbyRVUObs=', NULL, NULL, 'Null', '2022-12-27 15:14:26', '2023-01-02 05:46:55'),
(15, '29', 22, '63', 'zLhHB2xmLrbqf85ADzb7jw==', 'fG1IQsqg+hNSLXLcbew5exxnJcYCPc8Sf85C6zmp3bY=', NULL, NULL, 'Null', '2022-12-27 16:22:37', '2023-01-03 07:07:10'),
(16, '13', 17, '45', '6qxvE+kUVEUA2ywmY6gax/VdowZEUQ7Vn18stsqlsZ+MY3ZnyB2ic8UNhqbWHPaH', 'vkfI0f2IUk9GvcU/g2pfXlL0BynK0d0R4JnqOIuVBHU=', NULL, NULL, 'Null', '2023-01-01 07:03:30', '2023-01-04 17:56:16'),
(17, '13', 11, '8', 'b+RTDV+Wm/ORH1hJ9eMXz334p4JyipjaL1w2evACv9c0uZhUgu/wgyaKzNGqlFdY', 'KCqrvSSH7cH3RXh22uQUL3yEdj0ZB46jO2jbs446XjhpgKp4LUQhyiGE183Gwu9O', NULL, NULL, 'Null', '2022-12-06 18:11:08', '2023-01-04 17:42:25'),
(18, '11', 14, '42', 'wucfFY2yH3w8/zxTX0IASA==', 'vth7tguQp2gj8/HwTgmZ70Qh0dj5vyflNyRqV8AFepw=', NULL, NULL, 'Null', '2023-01-03 17:06:46', '2023-01-03 17:57:58'),
(19, '21', 11, '2', 'jHb1Pyp0K6OBOMSzvE34MIsW2jNpnOXLvl+nPlAhkXs=', 'irKheY7lxrgChevxB/k20ox8LKC8y+szZVXUPCCeVvA=', 1, 'L3kNo4Ux+xbSoRSMMxho7drtsYivEgd4JlSlIkejkGM=', 'oWbXZrqESdYO16zDD67L2w==', '2023-01-05 07:21:29', '2023-01-05 07:24:41'),
(20, '14', 11, '2', 'u/Eyvs16YOdPYRa74AzxsvT2+viAs82kTAxllhutJek=', 'irKheY7lxrgChevxB/k20ox8LKC8y+szZVXUPCCeVvA=', 1, 'L3kNo4Ux+xbSoRSMMxho7drtsYivEgd4JlSlIkejkGM=', 'oWbXZrqESdYO16zDD67L2w==', '2023-01-05 07:21:29', '2023-01-05 09:37:54'),
(21, '14', 11, '38', 'YJY5FEgdnjSknbxf+LtczCKtUXqM0QFdS4iKfTHjnnA=', 'QFxHN10OqsguwlkGfBpFsaXTtRCEHNSNEJkhMjyr0sI=', 1, 'ZMMUUq4rO9PMu4hwdoy88V8uwsVARM7D7btMGH0+OYNiuFr3H/xpjL+C9kU7iwbM', 'wuh64qIaLOuACyLVZELHhA==', '2023-01-06 07:18:04', '2023-01-07 10:06:56'),
(22, '14', 11, '38', 'YJY5FEgdnjSknbxf+LtczCKtUXqM0QFdS4iKfTHjnnA=', 'QFxHN10OqsguwlkGfBpFsaXTtRCEHNSNEJkhMjyr0sI=', NULL, NULL, 'Null', '2023-01-06 07:18:04', '2023-01-07 10:06:56'),
(23, '11', 41, '67', 'wucfFY2yH3w8/zxTX0IASA==', 'JBQVTpKSWAAer+/QAiWbAW1rcJk7FzJOay496ykP0gI=', NULL, NULL, 'Null', '2023-01-22 11:32:02', '2023-01-22 11:32:02'),
(24, '11', 20, '44', 'zLhHB2xmLrbqf85ADzb7jw==', 'bABu8yWTgurBzQ+dY/iQQHaw+jsH66osZ1yN5vDHKmM=', NULL, NULL, 'Null', '2023-01-22 11:35:19', '2023-01-22 11:35:19'),
(25, '11', 20, '4', 'zLhHB2xmLrbqf85ADzb7jw==', 'czDdv3n/LDpJJ+vbHhPDKbEbreDCFX2R4tqsZRUQQUU=', NULL, NULL, 'Null', '2023-01-22 11:38:04', '2023-01-22 11:38:04'),
(26, '42', 41, '67', 'wRBzqB4Rf60jyrjQ5dbfxw==', 'nJaRlgDnUE/RQ+udDQ6jz8FMVOrDcvXB/I+ItPry8O1I8/bvs9mlDj/u1yaCPZPquBVCHg9/0qvpTf11ULmKrQ==', NULL, NULL, 'Null', '2023-01-23 05:55:35', '2023-01-23 05:55:35'),
(27, '42', 11, '65', 'wRBzqB4Rf60jyrjQ5dbfxw==', 'oKrUs+6DQ01JQQhk25pFlp91QJ+Vq7i3MqiGAGtyRjMNtlMwmBAM8Q6rHKlxIlgMWgQ9qV1z+HgD4scs+sLiCw==', NULL, NULL, 'Null', '2023-01-23 06:06:21', '2023-01-23 06:06:21'),
(28, '41', 11, '40', '4Cm3Nba87JpoFJwPHjHZVw==', 'vnKym96nEtOvxRxa2svjb4wNnuq8v8+b+dgSAu6KicXscclkVei5lY4Tx2Cf6pvqEBzlSZJK1BDPdNKTp3GrCA==', NULL, NULL, 'Null', '2023-01-23 11:21:55', '2023-01-23 11:21:55'),
(29, '42', 20, '20', 'zLhHB2xmLrbqf85ADzb7jw==', 'NnrbI+O0/DSsfiGUjpfTuq3JYy9/c/5vAKM/yvJL14Anh8PLqMYH4A1V+pA4iQ/ET+vCfxGoLvYh5LOauHJ0UKNf7Zj7q9+4Y/y5xk/unAA=', NULL, NULL, 'Null', '2023-01-23 11:25:01', '2023-01-23 11:25:01'),
(30, '41', 42, '68', '4Cm3Nba87JpoFJwPHjHZVw==', 'M4i1WhyUsBOORXF0u4lzurZWLnnVOuvyFV/VgJvRiMNdJ34J/SskiYtpXG7blKPT3+uWwKqFrjo730oSfAIZOg==', 2, 'TsKU53TUGkX0heLtbVOuGQ==', 'wuh64qIaLOuACyLVZELHhA==', '2023-01-23 11:28:42', '2023-01-23 13:42:25'),
(31, '41', 42, '68', 'c0S8qy2/02EB+8VkWf+3Iw==', 'H4f8fXLNSS6viiX6Cznw5kGVVcXwNp+FjA7FflnLO18rd/cKjZcWguLRRWeLcFcdiWrEtyRDg4Zin7c15yxltg==', 1, 'ZMMUUq4rO9PMu4hwdoy88TPDSqBZ9GoU4cXXOURgVLE=', 'wuh64qIaLOuACyLVZELHhA==', '2023-01-23 13:45:14', '2023-01-23 13:46:11');

-- --------------------------------------------------------

--
-- Table structure for table `update_profile_email`
--

CREATE TABLE `update_profile_email` (
  `id` int NOT NULL,
  `user_id` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `ip_address` varchar(225) NOT NULL,
  `code` varchar(225) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `update_profile_name`
--

CREATE TABLE `update_profile_name` (
  `id` int NOT NULL,
  `user_id` varchar(225) NOT NULL,
  `name` varchar(225) NOT NULL,
  `ip_address` varchar(225) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userprofile_complaint`
--

CREATE TABLE `userprofile_complaint` (
  `id` int NOT NULL,
  `complaint_user_id` varchar(255) NOT NULL,
  `profile_user_id` varchar(255) NOT NULL,
  `complaint` text NOT NULL,
  `upload_file_name` text NOT NULL,
  `admin_msg` text,
  `admin_id` int DEFAULT NULL,
  `admin_action` varchar(255) NOT NULL DEFAULT 'Null',
  `complaint_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userprofile_complaint`
--

INSERT INTO `userprofile_complaint` (`id`, `complaint_user_id`, `profile_user_id`, `complaint`, `upload_file_name`, `admin_msg`, `admin_id`, `admin_action`, `complaint_date`, `updated_at`) VALUES
(1, '11', '26', 'SbhmBaskvHwJzXJiBhcX3Q==', 'azLHe3q9oTFXrcpaBepFb0VoA5BW+KOHXz/8QbG+flk=', NULL, NULL, 'Null', '2022-12-06 18:06:05', '2023-01-04 17:19:48'),
(2, '13', '24', '0DCql09tiVlUUP5rbtn3ZvlQtqM35OOJCy8/l0Yjuwj3RYFNFdrJEAkVkxcD0G8pWzeDjCiCOc/5mP82n8I+GA==', 'fZelfO0isQcSOqRpa0+l8PwjzBzzYxd7pnrEApD/Zqg=', 'MxYlW6sokCjZBVyZqAJobg==', NULL, 'Null', '2022-12-06 18:07:52', '2023-01-08 16:08:14'),
(3, '24', '22', 'nEO01JrrcUU+qX6KQnOhRi6s77+u+4zrIJrVuTfMkj8=', '7YDqpAJL1LSeXiFfPglpWyyozZsEpgP/Zb7+hmcaHms=', NULL, NULL, 'Null', '2022-12-06 18:13:07', '2022-12-25 08:11:01'),
(4, '24', '14', 'lWhwP4hBqRo9jPJJTFFKMw==', 'DjirCjD52RagJP23+yGI+7qy/C7SKxOrBr9HqICP4tw=', NULL, NULL, 'Null', '2022-12-06 18:14:47', '2023-01-06 08:53:21'),
(5, '11', '22', '+4AdmF9/9xVwrTqGSTsmug==', 'CTwIF8vlZJRZwB48+eHmFYHQSsmaZW++5EAnUfSPSWw=', NULL, NULL, 'Null', '2022-12-24 06:43:56', '2022-12-25 08:11:07'),
(6, '29', '22', '+4AdmF9/9xVwrTqGSTsmug==', 'CTwIF8vlZJRZwB48+eHmFYHQSsmaZW++5EAnUfSPSWw=', NULL, NULL, 'Null', '2022-12-24 06:43:56', '2022-12-25 08:11:07'),
(8, '24', '14', 'lWhwP4hBqRo9jPJJTFFKMw==', 'DjirCjD52RagJP23+yGI+7qy/C7SKxOrBr9HqICP4tw=', NULL, NULL, 'Null', '2022-12-06 18:14:47', '2023-01-06 08:52:29'),
(9, '13', '26', '0DCql09tiVlUUP5rbtn3ZvlQtqM35OOJCy8/l0Yjuwj3RYFNFdrJEAkVkxcD0G8pWzeDjCiCOc/5mP82n8I+GA==', 'fZelfO0isQcSOqRpa0+l8PwjzBzzYxd7pnrEApD/Zqg=', NULL, NULL, 'Null', '2022-12-06 18:07:52', '2023-01-04 17:19:19'),
(10, '14', '22', '+4AdmF9/9xVwrTqGSTsmug==', 'CTwIF8vlZJRZwB48+eHmFYHQSsmaZW++5EAnUfSPSWw=', NULL, NULL, 'Null', '2022-12-24 06:43:56', '2022-12-25 08:11:07'),
(11, '14', '11', 'cg4MS4+f2TWLfpY6gEPvlKMgBHoxPTjoFH1Yrdk0VqM=', '3ImpD3pgzX8AxzNhXuSgoltIFqASqZNERvjTmSi7hGc=', 'UDIsZiMNQkEHMuoki9fPh3L73fPAcRPy6XzjjZu+iQcWthsWZJ2kEpfQ5mB3GwLp', 1, 'FFel/XoedKjWSBkXg7ksWg==', '2023-01-05 07:10:52', '2023-01-05 07:41:25'),
(12, '17', '11', 'lWhwP4hBqRo9jPJJTFFKMw==', 'irNqV+3X2qK0ssLzNtGaaCq6GyK/AAEKMZ7715AHhUE=', 'UDIsZiMNQkEHMuoki9fPh3L73fPAcRPy6XzjjZu+iQcWthsWZJ2kEpfQ5mB3GwLp', 1, 'FFel/XoedKjWSBkXg7ksWg==', '2023-01-05 07:11:52', '2023-01-05 07:41:25'),
(13, '13', '11', 'iDBVuXjZ1PlYoJku5/EALA==', 'irNqV+3X2qK0ssLzNtGaaCq6GyK/AAEKMZ7715AHhUE=', 'UDIsZiMNQkEHMuoki9fPh3L73fPAcRPy6XzjjZu+iQcWthsWZJ2kEpfQ5mB3GwLp', 1, 'FFel/XoedKjWSBkXg7ksWg==', '2023-01-05 07:11:52', '2023-01-05 10:16:12'),
(16, '14', '11', '5pQjOL5yRAtw51TAh/c8YQ==', 'hcnABTJNJ75S9DiS64oaB0jV54k7y/wDbNTE6OZUYNI=', 'OZQXu+bAN5WbLN5PyB+YoLHSe0NYBz+m4/zSrTX65uk=', 1, 'Tp1nN0ql8pMzfbrjZuI0UewJq6TwDLVkwlO5+mN/ZL0=', '2023-01-06 09:06:46', '2023-01-06 09:25:51'),
(17, '24', '11', 'lWhwP4hBqRo9jPJJTFFKMw==', 'DjirCjD52RagJP23+yGI+7qy/C7SKxOrBr9HqICP4tw=', 'OZQXu+bAN5WbLN5PyB+YoLHSe0NYBz+m4/zSrTX65uk=', 1, 'Tp1nN0ql8pMzfbrjZuI0UewJq6TwDLVkwlO5+mN/ZL0=', '2022-12-06 18:14:47', '2023-01-06 09:25:51'),
(19, '11', '41', 'depK6iXbVrIHd3y6+hUZGg==', 'emBpAtfDfnTwwYaeD291tXaINDVf3wAGiKhYef9/0Uc=', NULL, NULL, 'Null', '2023-01-22 11:30:37', '2023-01-22 11:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_type` varchar(255) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `online_status` varchar(255) NOT NULL DEFAULT 'BZUk1TEvez8Lj6Pn4tDFyg==',
  `country` varchar(225) NOT NULL,
  `state` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `bio` text,
  `work` varchar(255) DEFAULT NULL,
  `work_experiences` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `verification_code` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bg_image` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `bluetick` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_type`, `account_type`, `online_status`, `country`, `state`, `address`, `bio`, `work`, `work_experiences`, `language`, `password`, `gender`, `verification_code`, `image`, `bg_image`, `ip_address`, `status`, `bluetick`, `created_at`, `updated_at`) VALUES
(11, 'zohaib khan', 'juFB7a34XuvSMDn3qPHBV4K5uXBnQM68I0LHBZ3WjNk=', 'L91FPiDL2V+YZ1hdwTBZQg==', 'njVAWfgJ8VddJZq1FVKXSA==', 'mhBBjxO2Y68p6UugBD3s3Q==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', 'PA8E4yMhOM4+5Zub+CMKdmgWLA2PYOtvCONCnsuNREn7T27nxThpfuGgXcnttCFq', 'BjKtC0lTKYBXw0kmlT5qnuKbxB94INH14pBUka1Z9c8=', 'OZvaEwxTb+/dMwJqNzRLbA==', 'jhgCXR6LLhSjrdVcfBa5EQ==', 'cKIYLyedt8RwCzpe8bkrF2O6KFi8xtXy6ZvRZXL08cg=', 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'FbbEPfYruBXgUxzLZIqguQ==', 'sQndj1M+ZHA/a6Fw/h7afkWpPpz53HqI+rsj5v2//zFVhHLGDx1aoBdKj7icaRZK112mRbqXzkX71EyUMKhfnA==', '46GyppDFQ0lhOa/Jod2G0Q==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', 'Uv2UfqbhpdAYw1HJhM8saQ==', '2022-07-01 06:41:30', '2023-01-23 12:12:44'),
(13, 'shahzaib khan', 'r6HEfDWnUOkjPpnO6ygaUJyQol7gtBI1Dg6Sxvf/4pM=', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', 'PA8E4yMhOM4+5Zub+CMKdmgWLA2PYOtvCONCnsuNREn7T27nxThpfuGgXcnttCFq', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'G23JQhVmxoNUUKgzQrYa1Q==', 'BxqqWUGPBCUSOruVfHiWLZnCX5TVxSlgOZDXfWSS57kAfqPicPxknqajH/6kJIzU', 'POJf0DmJAMpmfRWndGB5zN0obswa49R771DMQp4WStPGCHUH9jE3/cHCe4rCiuOgQxKOA7S5u8S0yBAKynvOo0hsxKXdZQqHlhwGsveDmmw=', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-07-04 16:47:18', '2022-10-30 09:02:11'),
(14, 'rizwan khan', 'Ukw/ZWWouyHN3sQTcLiw1d7NwW/SELheNKUCrhzdIjc=', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', 'HCzqiZcoCRUQl5pQEt3nCg==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'ZU/fqs13WKaPwrqnZYsTOA==', 'ahn3scpuiyvXlWkl0dNSQN6hLvus/FPoRsY7ozN/fHzKpow59C/MBTOciVZ5qTcU', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', 'Uv2UfqbhpdAYw1HJhM8saQ==', '2022-07-04 16:48:34', '2023-01-09 17:49:44'),
(15, 'rida khan', 'Ps0AZNBFUSX4jt3Q/lbw8Q==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'o1ukZdQOpp9NHPSskpph3g==', 'sSOL9SPpiiqxgdrZPHbwdw==', 'zivwzPkaddUJ/2ggq9Xf/Q==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'SKNJy6jzu/C4Lb0FGDcZpg==', 'Z3iXJG7MVPT8SZJ+WrqhDA==', 'Ql0tJmGqPBEJ/FEJxm2eXxoCM7lSIq0qCSP3loeZRj77X2dy+GW1Xs2/Li37XmjRxOprVyoDM5vep0AKdWZqxw==', 'KV00MOpoznWgXRfX2Z8PJRigxuUO5A3m/S/994fnzedy6/wHD/Tf1vgZC3qKgi5k', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', 'Uv2UfqbhpdAYw1HJhM8saQ==', '2022-07-04 16:49:51', '2022-10-29 07:30:45'),
(16, 'fatima khan', 'Ts801+JkHRjGIZXn/UYURsMR5brVVe9UI9c+pYIxSZA=', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'mhBBjxO2Y68p6UugBD3s3Q==', 'Q1cYxJ/VpYWE4H3qlWVK0Q==', '+TmTD/dc/rLas6NgYakcEA==', '83RNZXSaNKoKF4FKyhMDgQ==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'SKNJy6jzu/C4Lb0FGDcZpg==', 'sm+UIw8BCFuWPBunoGARzg==', 'n56wt4fx1mzqK+P4DryiMztGSHl6uqxvWq3zMz7DfmFxOt6Y+oQNWrhJSm97yx0mmMlrBWQViiZFpbnreSrLoSoqsT3sK2zmOdnrGj/h06w=', 'boEaxIFeg2hkrEv7ikfaA9/hWWcJ0+O0SaiO+36dZTlg785ycSbPDfbVXXBJgAy9', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-07-04 16:51:10', '2022-11-06 13:33:17'),
(17, 'javeria khan', 'XuvNrVieSALjFZ6+QIYuauO6LRnFjkkbsBWpwW47p+o=', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', 'jOAZ04TMP+xm97ZHn4Y4xw==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'SKNJy6jzu/C4Lb0FGDcZpg==', 'jIkvsSTUxveY5SFMlddzXA==', 'IhYGJNQsV/Nc1kqp4844BIlj2ihWeLu/tNLnEhlTVa2rODY3XmuZ58NFQFPpS+1X', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-07-04 17:46:42', '2022-10-30 08:19:36'),
(18, 'afnan khan', 'ld1fBaUKPvyEwvEFpT36BA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Q1cYxJ/VpYWE4H3qlWVK0Q==', '+TmTD/dc/rLas6NgYakcEA==', '+TmTD/dc/rLas6NgYakcEA==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'snCVJH/XgZ5+J7njyzVn5g==', 'UmSEVyy/4Dwoz9B8qjMrAA==', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-07-07 19:00:47', '2022-11-03 06:42:16'),
(19, 'fasial iqbal', '2KAtSHbWbSoBOIRnO3MTMA/ZxoWjfkSR72jEotVJoUw=', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', 'PA8E4yMhOM4+5Zub+CMKdmgWLA2PYOtvCONCnsuNREn7T27nxThpfuGgXcnttCFq', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'CNP0Hie71ukMvfe8q0sjDg==', 'KpzRSqcA9VYmF6R/8wKwyr3/ChQBPYQ20UXTpVc/1sOC5glYt2zHqSODEUxZ2WMwk3oMXxNt98DSOltLfEpMyA==', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-07-07 19:41:04', '2022-10-29 18:53:22'),
(20, 'faizan khan', 'jXTw03Z6NpwsD5BXaJlppLRUnzfNDg+gzQ2gRo47Nbg=', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', 'PA8E4yMhOM4+5Zub+CMKdmgWLA2PYOtvCONCnsuNREn7T27nxThpfuGgXcnttCFq', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'hYtqr+d56LXuXpqZtMPbYw==', 'p3ibeIRJWShvYzR0BCMev05K1EC8pBVm7Utpy7PhBQhOER1vD+g7MndDWpRiAiEo', 'qV+F5A57pdez97evUuhvc9vMp+25ORKWAVAUOhLzvstcnY90tTS8VLlRq96wsD86', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-07-30 10:26:23', '2023-01-17 20:22:11'),
(21, 'kashif ', 'QO/lZzgHFWUsrcjyfbL7Gedpo8FVSqJImFhymLr0/ug=', 'njVAWfgJ8VddJZq1FVKXSA==', 'L91FPiDL2V+YZ1hdwTBZQg==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', 'PA8E4yMhOM4+5Zub+CMKdmgWLA2PYOtvCONCnsuNREn7T27nxThpfuGgXcnttCFq', '/ZFQEGj2/2iKcrgUvk7+9183CXmCt1Yv5f0XSvri41Y=', NULL, NULL, 'VGPMA656WpsPFTZBb53B6ZfS0QEg8TYHT3UHGc1Vt38=', 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'cnNFTrS0I3xm6mu07c0GvA==', 'oxRAm2FvEGXV90YE7NWH6v2ecRnHPeNfVjvilfh/+QX31nDx3IPw+DzRGuGkXG3W', 'Awsfe1tk/I4Qnvca0LN3u/dQUc6YYR8KMoa84daBKo0ZxbrJLXqN+JEs2e1DuEcxsk0ALZtCSPHpIae/OMaXAg==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-07-30 10:29:41', '2022-10-29 11:32:28'),
(22, 'khan zeb', 'FqwKwabCjqDdI16Ud13ttaYpgx3/8AYVp/xjutVRVzE=', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', 'bO6L0rR1Z/btM88IayKCV5cBK14m+bOXXwt5Dfh6FH0=', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'gSiYHb5UmJnvl8O3opvogQ==', '9vKO8n5eo0QAykVNNZ/bV8JDhgrQ4proVT7cpJ7fUj6H9dz3Ep/4J3GZxt17zq2v', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-10-12 16:14:23', '2022-10-30 09:06:32'),
(23, 'naseem khan', 'Dd12EYLpTroUamRuuuENuK4K539ymz39v6WHt8R2GjM=', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', 'wLB4nMLjerKm5MAh7b6Zi3vPUMPlaUSZsjjsjty1Vs0=', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', '2mDfT1izKd9wHm1nhvWb3g==', '5jD4472Jqg9L3siRZ8PDGPkzZ1g6uTBDj3mOqBlplQvpmMCj43jSu1aanx9Nh8Rc', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-10-12 16:15:39', '2022-10-29 07:34:48'),
(24, 'aqib khan', 'Qr167Kxjcxxl2ttTHDX38Q==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', 'PA8E4yMhOM4+5Zub+CMKdsNT/pYiY8Ob//nHnw73SbBRrVzeotnrJnWENfhbqA/S', 'qjN7/1beXFbojyx8EjJx0Q==', NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'FNtwddmxnkK3/fs/Xm2D5g==', 'E3t5yv8Dt9x7/7CPMoxEknLcmmyrBQ7CotBfo38p6PjesxFmvrh/oZ7im+CP4sUQf02S+FdZ4nme34SzJLpYXA==', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-10-12 16:17:41', '2022-10-29 18:54:04'),
(25, 'iqra khan', 'Yq2ZV27CD+61GRJytmjupg==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Q1cYxJ/VpYWE4H3qlWVK0Q==', '+TmTD/dc/rLas6NgYakcEA==', 'feKyPRi8Bz3DwpSh4O2pRcBqXA+pQcjEvk78EAUsuKA=', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'SKNJy6jzu/C4Lb0FGDcZpg==', '5BPxhXVaHs0mUn95Pf1ULw==', 'HRJOzoUgfEvCVrf/ByHxK/4JjiHGnvJEEjPhipC3JnSWBYF7HPKnAtbWWVlDp2+k', 'jHaNasYr+oASCB9rfayArUwSvdR1WSmVWaKYOL6VxaAvTZzSBwzhIz79FOQzhHoX', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-10-18 13:23:21', '2022-11-06 05:58:23'),
(26, 'aqsa', '1PoZS61zBNjqUN+a4e3nTA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', '76aRWsStASZkVc2akgrJJg==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'SKNJy6jzu/C4Lb0FGDcZpg==', 'wmFzB5A9qpfMFYgoHVe7Ww==', 'tFgMTDXzIeNDTkbw0s17tEVrvG/yFqfpjt9ZkB7tsMawl6Ucvp2ah2fNgQ1WB0xy', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-11-12 08:20:54', '2022-12-06 17:24:47'),
(27, 'qreeba khan', 'RKlnhSzPPQsH1wfU3kfVQtxnem383+vOHIT4Tq+Xsh8=', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', '3+uAb5tWrgTKRZYLv73ikQ==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'SKNJy6jzu/C4Lb0FGDcZpg==', '82J4TjRpucQ3qDC7e7YQjw==', 'BfaSzfblsJn+Skx/ZJhYA1gYC8WGK7ywRof9zDQtz7/1AjJ7JWc/ecFhDQHzY5CZ', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-11-12 08:22:12', '2022-12-06 17:24:44'),
(28, 'emaan gul', 'h0Cxa6lTiPeLuy+jtbaTxw==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', '4c4ojOlOOWh0ncUpdolBhg==', '4c4ojOlOOWh0ncUpdolBhg==', 'lU2zR7O6lscD011FxhgilgfbJjApfeUAReotMrcprTw=', 'OZvaEwxTb+/dMwJqNzRLbA==', 'R0AigouY2NW6kXU+N7Icyg==', 'cKIYLyedt8RwCzpe8bkrF2O6KFi8xtXy6ZvRZXL08cg=', 'v4f67FpYCLr7l3BqxMFvXA==', 'SKNJy6jzu/C4Lb0FGDcZpg==', 'GEIhZgcavqIz+rYu4CZsAw==', '2bW0KBMFyUSpWQ6GLimFKsV8AUpGhmVIHyPLVWJyspTRtO7Kw2VMSVVvDTDd9cUI', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-11-12 08:36:12', '2022-12-11 18:38:06'),
(29, 'Javeria', 'j8FpNzW2GorptA2+bwnHprEvNvTJ++GQWHe4krXwoJA=', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Q1cYxJ/VpYWE4H3qlWVK0Q==', '+TmTD/dc/rLas6NgYakcEA==', 'x/U5jifXnCwFTKDLw+AG0g==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'SKNJy6jzu/C4Lb0FGDcZpg==', 'HF+zuib2Rd+5YqdR2mcJbw==', '+5wvh8wkVZCa62DCXz/V1kitc6wasn4OGaLqq2Q69+ZNmNw817zFaeZYW/4s5xFD', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-11-23 19:02:28', '2023-01-04 17:03:27'),
(30, 'noor khan', 'AilejMSiGDxj7akwNXAEOA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Q1cYxJ/VpYWE4H3qlWVK0Q==', 'lCbJzCSkQDAb7Kz96GoRvg==', 'WyZwsloBOm0KJjZT07h5+w==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'bKQSClyx2W0DCTgDsPdymA==', '4TJG9IcDxwHuMGVaXq9LZIoqtNl0vvOcpAAiEdwUjzrn6jsTlmYirnbq4+X+sXdc', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-11-29 18:16:33', '2022-12-11 18:38:06'),
(31, 'ayaan khan', 'Rm0l9TD04rKPO8T2QnvR0w==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Q1cYxJ/VpYWE4H3qlWVK0Q==', '+TmTD/dc/rLas6NgYakcEA==', 'x/U5jifXnCwFTKDLw+AG0g==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', '0wu8z7W24ZX75LPvBS1Eng==', '9OZhb5KEY/kI3KqrtWLfFbknkfZkHep9/FLGJdb2/6+hfhzYAW/Ef/6ZPUw99Kph', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2022-12-06 17:14:29', '2022-12-11 18:38:06'),
(32, 'asif ali', 'Ahw4cwV+gMXfs+mNKHMF8Q==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Q1cYxJ/VpYWE4H3qlWVK0Q==', '+TmTD/dc/rLas6NgYakcEA==', 'x/U5jifXnCwFTKDLw+AG0g==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'yZ8krXLjQVhZikOZ+Z2HTA==', 'nHUZbtziRA8Yt3sP5c9qmA==', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'fYDKPQY0TjwXN+YirvD35Q==', NULL, '2022-12-06 17:17:41', '2022-12-11 18:40:08'),
(33, 'anas', '7AOz9q1CVcW0PtfAveTpJg==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Q1cYxJ/VpYWE4H3qlWVK0Q==', '+TmTD/dc/rLas6NgYakcEA==', 'x/U5jifXnCwFTKDLw+AG0g==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'QgtZCIDKsjOf/ED5qrq8/Q==', 'tWi/10ylBftU8l/3tmKqedHch6M/pcEvK9N12NoKTx1V7EdvhXiTWgWTha2rRcDq', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'fYDKPQY0TjwXN+YirvD35Q==', NULL, '2022-12-06 17:19:06', '2022-12-11 18:39:38'),
(34, 'abdullah', 'Zbc3OF+1TbIvuMh7ZkfPImbNGSsJYSRO20SJAPkI3jE=', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', '3+uAb5tWrgTKRZYLv73ikQ==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'ZG5GLeEsRPUVfN1OO2NdNg==', 'iOR0oS2urQKi3KEv3yzLP4uiy+g6jiH7ghjcYZpc5HCfFDKGrjLHN+bZzV54zFKH', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'pVyPstFtk4r3kddl8QaDUg==', NULL, '2022-12-06 17:21:42', '2022-12-11 18:37:20'),
(35, 'ashar', 'BSnc18RRuez76y5720kS2A==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', '3+uAb5tWrgTKRZYLv73ikQ==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'HSZLh10eX71a+ywFkcIcGw==', 'E45ga1w7UIFAI41CrK2W0+1EvjYSFmV2ouZ9ENbmQleEjMIKWvr4PI1f+4BrkHW/', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'Tp1nN0ql8pMzfbrjZuI0UewJq6TwDLVkwlO5+mN/ZL0=', NULL, '2022-12-06 17:22:28', '2022-12-11 18:35:50'),
(36, 'ali', '6936Viiq/+C3h7d7/vt+Ng==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', '3+uAb5tWrgTKRZYLv73ikQ==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'C4tKKIShtArKBIyfiEtpew==', 'oKdArL3RLddDv7MiVra8/OBT766z+4WIiLo/4vHv1+VKt5Kh3DK7R95rW0OLCHax', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'pVyPstFtk4r3kddl8QaDUg==', NULL, '2022-12-06 17:22:53', '2022-12-11 18:37:20'),
(37, 'atif khan', 'Wx1QVNALS4bu8bClognBxA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', '3+uAb5tWrgTKRZYLv73ikQ==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'hKPxEyX6qN+CmGqtkHD8Ww==', '32YDIsoa9vwTLlbBf+qy0Caq6TMKhe5noUqTOCi59juZ2BE+GCWWCVs6mVM0UdzD', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'Tp1nN0ql8pMzfbrjZuI0UewJq6TwDLVkwlO5+mN/ZL0=', NULL, '2022-12-06 17:23:39', '2023-01-13 07:36:35'),
(41, 'hamza khan', '5fkUWD/XjsC9beAOQLlljw==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'Z/ARVyGBP0Bl7miZozIdXXAAHrZqD5ajzcLLyYGtP0I=', 'fhlwTCVxhyIWUeUyQ4AvAZxBqLC6NjI057WaXGjT77g=', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', '/VDQXSmlWIhgD0E0nmKjwA==', 'sSAToSm3gGnN8ITvOMKub4cMCVC+hsfEBzm0mSBxItokbBrLHC7s2OBhXpRa37FrQ60BqGNBpc8xO70Bt4ERpg==', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2023-01-08 19:25:28', '2023-01-08 19:25:52'),
(42, 'ahmad khan', 'ZH6ZAyaCroQtfVwkIfUTnA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Z4nXrBBCqQh3HJjROtxaTw==', 'FEYV95ciO7OQM19zx5hn5ECf+/wMPvCMwTimnVz+vog=', 'DTDkQ28PBosgwH7gOTkWOg==', NULL, NULL, NULL, NULL, 'bHTTJau4DgkBsdbeL5j8LA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'pq2OQyujtoKgext9Pns7ow==', 'Cau2L4j0ZGfr5xcRH303QHcVp/KqxSOyFLHp+991144eFpPJNaf5GPHo59hMobu8', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2023-01-23 05:50:04', '2023-01-23 10:32:58'),
(43, 'shahzaib', 'GlLHhZMraacZtuIKMELKHgOJDNZVi8+8Tjv3a4Tqa18=', 'njVAWfgJ8VddJZq1FVKXSA==', 'njVAWfgJ8VddJZq1FVKXSA==', 'BZUk1TEvez8Lj6Pn4tDFyg==', 'Q1cYxJ/VpYWE4H3qlWVK0Q==', 'WZKGCF0wzjbYEY+6SUknog==', 'WZKGCF0wzjbYEY+6SUknog==', NULL, NULL, NULL, NULL, 'v4f67FpYCLr7l3BqxMFvXA==', 'pRlCM66ugAFeE3vyRmqUaA==', 'HEoAq56//7jE+W7o/1fj2A==', 'HWLcgEt3UmzR3SqDGvhQQ53PaeP/cG+uRsuv97OBlfGs3mQlytZQyw7CBZlS+QSW', 'tKJYB67gWd/TApLpI29PpA==', 'CFn9cETbtX1RTAxVWUZlhA==', 'JCX9ETjKAUtr/wOHt7Q1wg==', NULL, '2023-01-23 09:27:43', '2023-01-23 09:28:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_verification`
--
ALTER TABLE `account_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_warning`
--
ALTER TABLE `account_warning`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follower`
--
ALTER TABLE `follower`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_request`
--
ALTER TABLE `friend_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ip_address`
--
ALTER TABLE `ip_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempt`
--
ALTER TABLE `login_attempt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_list`
--
ALTER TABLE `message_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_pending`
--
ALTER TABLE `notification_pending`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_users`
--
ALTER TABLE `online_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts_likes`
--
ALTER TABLE `posts_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_complaint`
--
ALTER TABLE `post_complaint`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `update_profile_email`
--
ALTER TABLE `update_profile_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `update_profile_name`
--
ALTER TABLE `update_profile_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userprofile_complaint`
--
ALTER TABLE `userprofile_complaint`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_verification`
--
ALTER TABLE `account_verification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `account_warning`
--
ALTER TABLE `account_warning`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `follower`
--
ALTER TABLE `follower`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `friend_request`
--
ALTER TABLE `friend_request`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;

--
-- AUTO_INCREMENT for table `ip_address`
--
ALTER TABLE `ip_address`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=491;

--
-- AUTO_INCREMENT for table `login_attempt`
--
ALTER TABLE `login_attempt`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1020;

--
-- AUTO_INCREMENT for table `message_list`
--
ALTER TABLE `message_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=543;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT for table `notification_pending`
--
ALTER TABLE `notification_pending`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=478;

--
-- AUTO_INCREMENT for table `online_users`
--
ALTER TABLE `online_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `posts_likes`
--
ALTER TABLE `posts_likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `post_complaint`
--
ALTER TABLE `post_complaint`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `update_profile_email`
--
ALTER TABLE `update_profile_email`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `update_profile_name`
--
ALTER TABLE `update_profile_name`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userprofile_complaint`
--
ALTER TABLE `userprofile_complaint`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
