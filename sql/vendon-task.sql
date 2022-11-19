-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:8889
-- Generation Time: Nov 19, 2022 at 07:35 PM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vendon-task`
--

-- --------------------------------------------------------

--
-- Table structure for table `answered_questions`
--

CREATE TABLE `answered_questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_chosen_id` int(11) NOT NULL,
  `attempt_id` int(11) NOT NULL,
  `correct` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answered_questions`
--

INSERT INTO `answered_questions` (`id`, `user_id`, `test_id`, `question_id`, `answer_chosen_id`, `attempt_id`, `correct`) VALUES
(182, 26, 3, 6, 20, 70, 1),
(183, 26, 3, 7, 26, 70, 0),
(184, 26, 3, 8, 33, 70, 1),
(185, 26, 3, 9, 37, 70, 1),
(186, 27, 1, 1, 2, 71, 1),
(187, 27, 1, 2, 9, 71, 1),
(188, 27, 1, 10, 40, 71, 1),
(189, 27, 1, 11, 46, 71, 1),
(190, 28, 1, 1, 1, 72, 0),
(191, 28, 1, 2, 9, 72, 1),
(192, 28, 1, 10, 42, 72, 0),
(193, 28, 1, 11, 46, 72, 1),
(194, 26, 2, 3, 3, 73, 1),
(195, 26, 2, 4, 7, 73, 1),
(196, 26, 2, 5, 14, 73, 1),
(197, 27, 2, 3, 3, 74, 1),
(198, 27, 2, 4, 7, 74, 1),
(199, 27, 2, 5, 14, 74, 1);

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer`, `is_correct`) VALUES
(1, 1, 'three', 0),
(2, 1, 'four', 1),
(3, 3, 'Latvia', 1),
(4, 3, 'Estonia', 0),
(5, 3, 'Spain', 0),
(6, 3, 'Ethiopia', 0),
(7, 4, 'A contintent', 1),
(8, 4, 'A country', 0),
(9, 2, '8', 1),
(10, 2, '6', 0),
(11, 2, '65', 0),
(12, 2, '104', 0),
(13, 5, 'Africa', 0),
(14, 5, 'Asia', 1),
(15, 5, 'Antarctica', 0),
(16, 5, 'Oceania', 0),
(18, 6, 'Stockholm', 0),
(19, 6, 'Riga', 0),
(20, 6, 'Helsinki', 1),
(21, 6, 'Berlin', 0),
(22, 6, 'Reykjavík', 0),
(23, 6, 'Oslo', 0),
(24, 7, 'Michelangelo', 0),
(25, 7, 'Leonardo DiCaprio', 0),
(26, 7, 'Barrack Obama', 0),
(27, 7, 'Vincent van Gogh', 0),
(28, 7, 'Rowan Atkinson', 0),
(29, 7, 'Leonardo da Vinci', 1),
(30, 8, 'Hare', 0),
(31, 8, 'Rabbit', 0),
(32, 8, 'Kid', 0),
(33, 8, 'Bunny', 1),
(34, 9, '117', 0),
(35, 9, '119', 0),
(36, 9, '201', 0),
(37, 9, '118', 1),
(38, 9, '98', 0),
(39, 9, '132', 0),
(40, 10, '0', 1),
(41, 10, '991', 0),
(42, 10, '1000', 0),
(43, 10, '9999', 0),
(44, 11, 'Around 600', 0),
(45, 11, '473', 0),
(46, 11, 'Infinite', 1),
(47, 11, '314', 0);

-- --------------------------------------------------------

--
-- Table structure for table `attempts`
--

CREATE TABLE `attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `finished` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attempts`
--

INSERT INTO `attempts` (`id`, `user_id`, `test_id`, `finished`) VALUES
(70, 26, 3, 1),
(71, 27, 1, 1),
(72, 28, 1, 1),
(73, 26, 2, 1),
(74, 27, 2, 1),
(75, 27, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `finished_tests`
--

CREATE TABLE `finished_tests` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `test_id` int(11) NOT NULL,
  `attempt_id` int(11) NOT NULL,
  `total_question_count` int(11) NOT NULL,
  `correct_answers` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `finished_tests`
--

INSERT INTO `finished_tests` (`id`, `username`, `test_id`, `attempt_id`, `total_question_count`, `correct_answers`) VALUES
(63, 'John', 3, 70, 4, 3),
(64, 'Doe', 1, 71, 4, 4),
(65, 'test', 1, 72, 4, 2),
(66, 'John', 2, 73, 3, 3),
(67, 'Doe', 2, 74, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `test_id`, `question`) VALUES
(1, 1, 'What is 2+2'),
(2, 1, 'What is 4+4'),
(3, 2, 'Where is Riga located?'),
(4, 2, 'What is North America?'),
(5, 2, 'What\'s the biggest continent?'),
(6, 3, 'What is the capital of Finland?\r\n'),
(7, 3, 'Who painted the Mona Lisa?'),
(8, 3, 'What\'s a baby rabbit called?'),
(9, 3, 'How many elements are there in the periodic table?\r\n'),
(10, 1, 'What is the only number that does not have its Roman numeral? '),
(11, 1, 'How many digits does the value of Pi have? ');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `test_name` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `test_name`) VALUES
(1, 'Math Test'),
(2, 'Geography Test'),
(3, 'General knowledge');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`) VALUES
(26, 'John'),
(27, 'Doe'),
(28, 'test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answered_questions`
--
ALTER TABLE `answered_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attempts`
--
ALTER TABLE `attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finished_tests`
--
ALTER TABLE `finished_tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
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
-- AUTO_INCREMENT for table `answered_questions`
--
ALTER TABLE `answered_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `attempts`
--
ALTER TABLE `attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `finished_tests`
--
ALTER TABLE `finished_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
