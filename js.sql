-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2022 at 08:16 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `js`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `is_correct` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `content`, `question_id`, `is_correct`) VALUES
(309, '11', 2301, 0),
(310, '12', 2301, 0),
(311, '13', 2301, 0),
(312, '14', 2301, 1),
(345, '11', 2310, 0),
(346, '12', 2310, 1),
(347, '13', 2310, 0),
(348, '14', 2310, 0),
(349, '11', 2311, 0),
(350, '12', 2311, 1),
(351, '13', 2311, 0),
(352, '14', 2311, 0),
(353, '11', 2312, 0),
(354, '12', 2312, 1),
(355, '13', 2312, 0),
(356, '14', 2312, 0),
(953, '11', 2462, 1),
(954, '12', 2462, 0),
(955, '13', 2462, 0),
(956, '14', 2462, 0),
(957, '213', 2463, 1),
(958, '22', 2463, 0),
(959, '23', 2463, 0),
(960, '25', 2463, 0),
(961, '31', 2464, 0),
(962, '32', 2464, 1),
(963, '33', 2464, 0),
(964, '34', 2464, 0),
(965, '41', 2465, 0),
(966, '42', 2465, 1),
(967, '43', 2465, 0),
(968, '44', 2465, 0),
(969, '555', 2466, 0),
(970, '5', 2466, 1),
(971, '54', 2466, 0),
(972, '5234', 2466, 0),
(989, '11', 2471, 0),
(990, '12', 2471, 1),
(991, '13', 2471, 0),
(992, '14', 2471, 0),
(993, 'j', 2472, 0),
(994, 'j', 2472, 0),
(995, 'j', 2472, 1),
(996, 'j', 2472, 0),
(997, '11', 2473, 0),
(998, '12', 2473, 1),
(999, '13', 2473, 0),
(1000, '14', 2473, 0),
(1001, '21', 2474, 0),
(1002, '22', 2474, 0),
(1003, '23', 2474, 0),
(1004, '24', 2474, 1),
(1005, '31', 2475, 1),
(1006, '32', 2475, 0),
(1007, '33', 2475, 0),
(1008, '34', 2475, 0),
(1009, 'rfd', 2476, 1),
(1010, 'refer', 2476, 0),
(1011, 'ree', 2476, 0),
(1012, 'rere', 2476, 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `content`, `quiz_id`, `img`) VALUES
(2301, 'ch1', 41, NULL),
(2310, 'ch21', 42, NULL),
(2311, 'ch21', 43, NULL),
(2312, 'ch21', 44, NULL),
(2462, 'sddfgsd', 39, NULL),
(2463, 'sdf', 39, NULL),
(2464, 'ch3', 39, NULL),
(2465, 'ch4', 39, NULL),
(2466, 'd', 39, NULL),
(2471, 'ch21', 45, NULL),
(2472, 'd', 45, NULL),
(2473, 'ch1', 38, NULL),
(2474, 'ch4', 38, NULL),
(2475, 'ch3', 38, NULL),
(2476, 'sdgf', 38, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quizs`
--

CREATE TABLE `quizs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `start_time` date DEFAULT NULL,
  `end_time` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `is_shuffle` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `quizs`
--

INSERT INTO `quizs` (`id`, `name`, `subject_id`, `duration_minutes`, `start_time`, `end_time`, `status`, `is_shuffle`) VALUES
(38, 'Quiz 1', 2, 1, '2021-12-07', '2022-02-28', 1, 0),
(39, 'Quiz 2', 2, 1, '2022-01-29', '2022-02-28', 1, 0),
(41, 'Quiz 3', 2, 15, '2022-01-11', '2022-01-07', 1, 0),
(42, 'Quiz 4', 2, 15, '2022-01-13', '2022-01-06', 1, 0),
(43, 'Quiz 5', 2, 15, '2022-01-13', '2022-01-06', 1, 0),
(44, 'Quiz 6', 2, 15, '2022-01-13', '2022-01-06', 1, 0),
(45, 'Quiz 7', 2, 15, '2022-01-13', '2022-01-06', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Giáo viên'),
(2, 'Sinh viên');

-- --------------------------------------------------------

--
-- Table structure for table `student_quizs`
--

CREATE TABLE `student_quizs` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `score` float DEFAULT NULL,
  `is_end` int(11) DEFAULT NULL,
  `reattemp` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student_quizs`
--

INSERT INTO `student_quizs` (`id`, `student_id`, `quiz_id`, `start_time`, `end_time`, `score`, `is_end`, `reattemp`) VALUES
(14, 2, 38, '2022-01-27 18:24:49', '2022-01-28 19:01:51', 0, 1, 0),
(15, 2, 41, '2022-01-29 01:53:27', '2022-01-29 01:53:41', 0.2, 1, 0),
(16, 2, 42, '2022-01-29 01:15:47', '2022-01-29 01:23:34', 0, 1, 0),
(17, 2, 43, '2022-01-29 01:53:50', '2022-01-29 01:54:23', 0, 1, 0),
(18, 2, 39, '2022-02-25 06:17:57', '2022-02-25 06:18:31', 0.6, 1, 11),
(19, 2, 44, '2022-01-27 22:40:56', '2022-01-28 23:50:34', 0, 1, 0),
(20, 2, 45, '2022-01-27 22:41:02', '2022-01-28 23:50:37', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_quiz_detail`
--

CREATE TABLE `student_quiz_detail` (
  `id` int(11) NOT NULL,
  `student_quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student_quiz_detail`
--

INSERT INTO `student_quiz_detail` (`id`, `student_quiz_id`, `question_id`, `answer_id`) VALUES
(44, 18, 2462, 953),
(45, 18, 2463, 957),
(46, 18, 2464, 962);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `author_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `img`, `author_id`) VALUES
(2, 'Nhập môn lập trình - FA', '2.png', 1),
(3, 'Lập trình PHP2', '3.jpg', NULL),
(6, 'Javascript nâng cao', 'default.jpg', NULL),
(20, 'sdvf', '20.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'default.png',
  `role_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `avatar`, `role_id`) VALUES
(1, 'ldt', 'gv@abc.com', '$2y$10$xU/5lyveX2Ft0/KXJqe5uuHNxooIbDF4MTqiZfkZMC9ucaputLeFy', 'cc4886dc2ab7ca1522ce40d2266fb9a4.jpg', 2),
(2, 'Lee Duy The', 'sv@abc.com', '$2y$10$AoPaWXnUDBcCfhyA7TcRYOJH7V.PaK65LkBCtVYzH57oad7rLLJ/q', 'cc4886dc2ab7ca1522ce40d2266fb9a4.jpg', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_ibfk_1` (`question_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_ibfk_1` (`quiz_id`);

--
-- Indexes for table `quizs`
--
ALTER TABLE `quizs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quizs_ibfk_1` (`subject_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_quizs`
--
ALTER TABLE `student_quizs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_quizs_ibfk_1` (`quiz_id`),
  ADD KEY `student_quizs_ibfk_2` (`student_id`);

--
-- Indexes for table `student_quiz_detail`
--
ALTER TABLE `student_quiz_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_quiz_detail_ibfk_1` (`student_quiz_id`),
  ADD KEY `student_quiz_detail_ibfk_2` (`answer_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1013;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2477;

--
-- AUTO_INCREMENT for table `quizs`
--
ALTER TABLE `quizs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_quizs`
--
ALTER TABLE `student_quizs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `student_quiz_detail`
--
ALTER TABLE `student_quiz_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizs`
--
ALTER TABLE `quizs`
  ADD CONSTRAINT `quizs_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_quizs`
--
ALTER TABLE `student_quizs`
  ADD CONSTRAINT `student_quizs_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizs` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `student_quizs_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `student_quiz_detail`
--
ALTER TABLE `student_quiz_detail`
  ADD CONSTRAINT `student_quiz_detail_ibfk_1` FOREIGN KEY (`student_quiz_id`) REFERENCES `student_quizs` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `student_quiz_detail_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `student_quiz_detail_ibfk_4` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
