-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 10:57 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `classhelp`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `classname` varchar(255) NOT NULL,
  `password` varchar(300) NOT NULL,
  `iv` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `status` int(11) DEFAULT 1,
  `date_added` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `classname`, `password`, `iv`, `key`, `status`, `date_added`) VALUES
(5, 'Jss1', 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', '', '', 1, '2024-11-02 14:00:22'),
(6, 'Jss2', 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', '', '', 1, '2024-11-02 14:00:32'),
(7, 'Jss3', 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', '', '', 1, '2024-11-02 14:00:40'),
(8, 'Sss1', 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', '', '', 1, '2024-11-02 14:00:46'),
(9, 'Sss2', 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', '', '', 1, '2024-11-02 14:00:52'),
(10, 'Sss3', 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', '', '', 1, '2024-11-02 14:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `class_teacher`
--

CREATE TABLE `class_teacher` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_teacher`
--

INSERT INTO `class_teacher` (`id`, `class_id`, `teacher_id`, `status`, `date_added`) VALUES
(1, 9, 4, 1, '2024-11-06 23:21:19'),
(3, 6, 4, 1, '2024-11-07 00:08:21'),
(4, 7, 4, 1, '2024-11-09 12:53:22'),
(5, 8, 3, 1, '2024-11-21 14:48:40'),
(6, 8, 4, 1, '2024-11-21 14:51:06'),
(7, 10, 4, 1, '2024-11-21 14:56:03'),
(8, 10, 2, 1, '2024-11-22 10:08:43');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `question_format` int(11) NOT NULL,
  `option` varchar(255) NOT NULL,
  `sentiment` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_format`, `option`, `sentiment`, `status`, `date_added`) VALUES
(1, 1, 'I understand it very well', 1, 1, '2024-11-04 01:41:01'),
(2, 1, 'I understand it well', 1, 1, '2024-11-04 01:41:41'),
(3, 1, 'I understand some of it', 2, 1, '2024-11-04 01:42:02'),
(4, 1, 'I don’t understand it yet', 0, 1, '2024-11-04 01:42:15'),
(5, 2, 'Very easy', 1, 1, '2024-11-04 01:42:27'),
(6, 2, 'Quite easy', 1, 1, '2024-11-04 01:42:42'),
(7, 2, 'A bit hard', 2, 1, '2024-11-04 01:42:57'),
(8, 2, 'Very hard', 0, 1, '2024-11-04 01:43:13'),
(9, 3, 'Very useful', 1, 1, '2024-11-04 01:43:36'),
(10, 3, 'Somewhat useful', 1, 1, '2024-11-04 01:44:00'),
(11, 3, 'Not useful', 0, 1, '2024-11-04 01:44:15'),
(12, 3, 'I’m not sure', 2, 1, '2024-11-04 01:44:32'),
(13, 4, 'Very confident', 1, 1, '2024-11-04 01:44:46'),
(14, 4, 'Fairly confident', 1, 1, '2024-11-04 01:44:59'),
(15, 4, 'A little unsure', 2, 1, '2024-11-04 01:45:18'),
(16, 4, 'Not confident at all', 0, 1, '2024-11-04 01:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `format` int(11) NOT NULL,
  `question` text NOT NULL,
  `status` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `format`, `question`, `status`, `date_added`) VALUES
(1, 1, 'How well do you understand this topic?', 1, '2024-11-04 01:27:22'),
(2, 1, 'How confident are you about your understanding of this topic?', 1, '2024-11-04 01:27:45'),
(3, 1, 'How clear is this topic to you?', 1, '2024-11-04 01:28:17'),
(4, 1, 'Do you feel you understand this topic?', 1, '2024-11-04 01:28:29'),
(5, 2, 'How easy or difficult do you find learning this topic?', 1, '2024-11-04 01:28:43'),
(6, 2, 'How has your learning experience been with this topic?', 1, '2024-11-04 01:28:55'),
(7, 2, 'How challenging do you find this topic?', 1, '2024-11-04 01:29:08'),
(8, 2, 'How is your progress with learning this topic?', 1, '2024-11-04 01:29:23'),
(9, 3, 'How useful do you think this topic is?', 1, '2024-11-04 01:29:38'),
(10, 3, 'How important do you feel this topic is?', 1, '2024-11-04 01:30:17'),
(11, 4, 'How much effort do you put into understanding this topic?', 1, '2024-11-04 01:30:42'),
(12, 4, 'How confident are you when answering questions on this topic?', 1, '2024-11-04 01:30:54'),
(13, 5, 'Can you explain any part of this topic that you find difficult or confusing?', 1, '2024-11-04 01:48:00'),
(14, 5, 'What aspects of this topic do you struggle with the most?', 1, '2024-11-04 01:48:13'),
(15, 5, 'Is there anything about this topic that you wish was explained differently?', 1, '2024-11-04 01:48:29'),
(16, 5, 'If you could change one thing about how this topic is taught, what would it be?', 1, '2024-11-04 01:48:52'),
(17, 5, 'Is there a part of this topic that feels more complicated than others?', 1, '2024-11-04 01:49:29'),
(18, 5, 'How comfortable do you feel with this topic? Explain in your own words.', 1, '2024-11-04 01:51:17'),
(19, 5, 'How has learning this topic been for you? Describe your experience.', 1, '2024-11-04 01:51:36'),
(20, 5, 'If someone asked you about this topic, how would you describe your understanding of it?', 1, '2024-11-04 01:51:54'),
(21, 5, 'If you had to describe your level of understanding for this topic, what would you say?', 1, '2024-11-04 01:52:15'),
(22, 5, 'Can you describe how you feel about learning this topic?', 1, '2024-11-04 01:52:38');

-- --------------------------------------------------------

--
-- Table structure for table `question_formats`
--

CREATE TABLE `question_formats` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_formats`
--

INSERT INTO `question_formats` (`id`, `type`, `status`, `date_added`) VALUES
(1, 'understanding', 1, '2024-11-03 14:22:32'),
(2, 'learning experience', 1, '2024-11-03 14:23:11'),
(3, 'application', 1, '2024-11-03 14:24:07'),
(4, 'confidence', 1, '2024-11-03 14:25:18'),
(5, 'write', 1, '2024-11-04 01:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `question_format` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `review` text NOT NULL,
  `status` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `student_id`, `subject_id`, `question_format`, `question_id`, `review`, `status`, `date_added`) VALUES
(1, 1, 1, 1, 2, '4', 1, '2024-12-04 08:13:56'),
(2, 1, 1, 2, 5, '8', 1, '2024-12-04 08:13:56'),
(3, 1, 1, 3, 10, '9', 1, '2024-12-04 08:13:56'),
(4, 1, 1, 4, 11, '14', 1, '2024-12-04 08:13:56'),
(5, 1, 2, 1, 2, '4', 1, '2024-12-04 08:15:55'),
(6, 1, 2, 2, 5, '8', 1, '2024-12-04 08:15:55'),
(7, 1, 2, 3, 10, '9', 1, '2024-12-04 08:15:55'),
(8, 1, 2, 4, 11, '14', 1, '2024-12-04 08:15:56'),
(9, 1, 1, 1, 2, '2', 1, '2024-12-04 08:29:27'),
(10, 1, 1, 2, 8, '6', 1, '2024-12-04 08:29:27'),
(11, 1, 1, 3, 10, '9', 1, '2024-12-04 08:29:27'),
(12, 1, 1, 4, 11, '13', 1, '2024-12-04 08:29:27'),
(13, 1, 1, 1, 2, '2', 1, '2024-12-04 08:32:15'),
(14, 1, 1, 2, 7, '6', 1, '2024-12-04 08:32:15'),
(15, 1, 1, 3, 10, '10', 1, '2024-12-04 08:32:15'),
(16, 1, 1, 4, 11, '13', 1, '2024-12-04 08:32:15');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL,
  `password` varchar(300) NOT NULL,
  `status` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `class`, `firstname`, `lastname`, `gender`, `password`, `status`, `date_added`) VALUES
(1, 10, 'Barnabas', 'Atunde', 0, 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1, '2024-11-03 11:34:06'),
(2, 9, 'Bola', 'Phillps', 0, 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', 1, '2024-11-03 12:25:32'),
(3, 9, 'John', 'Gabriel', 0, 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', 1, '2024-11-06 23:48:08'),
(4, 6, 'Faith', 'Victory', 1, 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', 1, '2024-11-07 00:42:40'),
(5, 9, 'Michael', 'Faraday', 0, 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', 1, '2024-11-07 07:42:05'),
(6, 7, 'Johnny', 'Frank', 0, 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', 1, '2024-11-09 12:52:34'),
(7, 8, 'Beauty', 'Peace', 1, '053441ce9d6b55a74717d586d2a6850fe65e33dc669c8317fe382b566838e833', 1, '2024-11-21 14:49:35'),
(8, 5, 'Love', 'May', 1, 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1, '2024-12-04 07:46:32');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `theme` varchar(240) NOT NULL,
  `status` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `subject_name`, `theme`, `status`, `date_added`) VALUES
(1, 'English Language', '#6168ca', 1, '2024-11-25 10:20:59'),
(2, 'Mathematics', '#910628', 1, '2024-11-25 10:21:04'),
(3, 'Geography', '#4617f1', 1, '2024-11-25 10:21:09'),
(4, 'Physics', '#87698d', 1, '2024-11-25 10:21:12'),
(5, 'Chemistry', '#ab0cab', 1, '2024-11-25 10:21:15'),
(6, 'Further Mathematics', '#c31f29', 1, '2024-11-25 10:21:27'),
(7, 'Biology', '#705ca8', 1, '2024-11-25 10:21:28'),
(8, 'Government', '#7c126a', 1, '2024-11-25 10:23:22'),
(9, 'Marketing', '#1052e1', 1, '2024-11-25 10:23:31'),
(10, 'Data Processing', '#943eba', 1, '2024-11-25 10:23:36'),
(11, 'Economics', '#114c36', 1, '2024-11-25 10:23:50'),
(12, 'Animal Husbandry', '#6d4519', 1, '2024-11-25 10:24:03'),
(13, 'Yoruba', '#0828e3', 1, '2024-11-25 10:24:29'),
(14, 'Igbo', '#8c6513', 1, '2024-11-25 10:24:34'),
(15, 'Hausa', '#010e1b', 1, '2024-11-25 10:24:41');

-- --------------------------------------------------------

--
-- Table structure for table `subject_teacher`
--

CREATE TABLE `subject_teacher` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL,
  `password` varchar(300) NOT NULL,
  `email` varchar(330) NOT NULL,
  `mobilenumber` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `title`, `firstname`, `lastname`, `gender`, `password`, `email`, `mobilenumber`, `status`, `date_added`) VALUES
(1, 'Mr', 'Bola', 'James', 0, 'A6xnQhbz4Vx2HuGl4lXwZ5U2I8iziLRFnhP5eNfIRvQ=', 'bolajames@gmail.com', '08077819333', 1, '2024-11-02 08:23:38'),
(2, 'Mr', 'sd', 'ddd', 0, '10/YKzIs9Eb/0Po3Y6WN1nasREvcuAIvk7U8xrMcXME=', 'Eddied@gmail.com', '434343434', 1, '2024-11-02 20:36:33'),
(3, 'Mr', 'ff', 'fff', 0, 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', 'Eddie@gmail.com', '44444444444444', 1, '2024-11-03 00:59:04'),
(4, 'Master', 'James', 'Folabi', 0, 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', 'folabijames@gmail.com', '08077882023', 1, '2024-11-06 14:43:51'),
(5, 'Mr', 'Bolaa', 'James', 0, 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=', 'bola@gmail.com', '09088374834', 1, '2024-11-09 12:59:21');

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`id`, `subject_id`, `class_id`, `title`, `description`, `status`, `date_added`) VALUES
(1, 1, 8, 'Essay Writing', '', 1, '2024-11-03 12:20:04'),
(2, 1, 8, 'Comprehension and Summary', '', 1, '2024-11-03 12:20:19'),
(3, 1, 8, 'Grammar and Structure', '', 1, '2024-11-03 12:20:46'),
(4, 1, 9, 'Literature', 'Literary Devices (Metaphor, Simile, Personification, etc.)\nAnalysis of Short Stories, Novels, and Poems\nCharacter and Theme Analysis', 1, '2024-11-03 12:21:05'),
(5, 2, 9, 'Quadratic Equations', '', 1, '2024-11-04 17:01:39'),
(6, 2, 9, 'Simultaneous Equations', '', 1, '2024-11-04 17:01:57'),
(7, 2, 9, 'Sequences and Series', '', 1, '2024-11-04 17:02:09'),
(8, 2, 9, 'Coordinate Geometry', '', 1, '2024-11-04 17:02:23'),
(9, 2, 9, 'Trigonometric Ratios and Identities', '', 1, '2024-11-04 17:02:34'),
(10, 2, 9, 'Functions and Graphs of Functions', '', 1, '2024-11-04 17:02:48'),
(11, 1, 8, 'Vowels', 'Vowels', 1, '2024-11-09 12:53:45'),
(12, 1, 8, 'Past tense', '', 1, '2024-11-21 14:49:01'),
(13, 1, 10, 'Vowels', '', 1, '2024-11-27 09:15:44'),
(14, 1, 10, 'Comprehension', '', 1, '2024-11-27 09:16:03'),
(15, 1, 10, 'Past Tense', '', 1, '2024-11-27 09:16:12'),
(16, 2, 10, 'Bearing and Distance', '', 1, '2024-11-27 09:16:36'),
(17, 2, 10, 'Moment', '', 1, '2024-11-27 09:16:43'),
(18, 2, 10, 'Trigonometry', '', 1, '2024-11-27 09:16:57'),
(19, 2, 10, 'Logarithms', '', 1, '2024-11-27 09:17:29'),
(20, 3, 10, 'Longitude and Latitude', '', 1, '2024-11-27 09:17:46'),
(21, 3, 10, 'Earth&#039;s Crust', '', 1, '2024-11-27 09:17:53'),
(22, 3, 10, 'Earth&#039;s Core', '', 1, '2024-11-27 09:17:57'),
(23, 3, 10, 'Earth&#039;s Mantle', '', 1, '2024-11-27 09:18:04'),
(24, 3, 10, 'Weather', '', 1, '2024-11-27 09:18:06'),
(25, 3, 10, 'Nebula&#039;s', '', 1, '2024-11-27 09:18:16'),
(26, 3, 10, 'Major Planents', '', 1, '2024-11-27 09:18:23'),
(27, 3, 10, 'Minor Planets', '', 1, '2024-11-27 09:18:30'),
(28, 4, 10, 'Pressure', '', 1, '2024-11-27 09:18:39'),
(29, 4, 10, 'Momentum', '', 1, '2024-11-27 09:18:44'),
(30, 4, 10, 'Moment', '', 1, '2024-11-27 09:18:46'),
(31, 4, 10, 'Force', '', 1, '2024-11-27 09:18:48'),
(32, 4, 10, 'Distance and Displacment', '', 1, '2024-11-27 09:19:02'),
(33, 4, 10, 'Velocity', '', 1, '2024-11-27 09:19:08'),
(34, 4, 10, 'Electricity', '', 1, '2024-11-27 09:19:18'),
(35, 4, 10, 'Flemings right hand', '', 1, '2024-11-27 09:19:31'),
(36, 4, 10, 'Flemings left hand', '', 1, '2024-11-27 09:19:37'),
(37, 5, 10, 'Atoms', '', 1, '2024-11-27 09:20:04'),
(38, 5, 10, 'Molecule', '', 1, '2024-11-27 09:20:08'),
(39, 5, 10, 'Electron', '', 1, '2024-11-27 09:20:15'),
(40, 5, 10, 'Proton', '', 1, '2024-11-27 09:20:24'),
(41, 5, 10, 'Neutrons', '', 1, '2024-11-27 09:21:08'),
(42, 5, 10, 'Alkanes', '', 1, '2024-11-27 09:21:17'),
(43, 6, 10, 'Calculus', '', 1, '2024-11-27 09:21:32'),
(44, 6, 10, 'Moment', '', 1, '2024-11-27 09:21:41'),
(45, 6, 10, 'Pascal distribution', '', 1, '2024-11-27 09:22:02'),
(46, 6, 10, 'Statistics', '', 1, '2024-11-27 09:22:15'),
(47, 7, 10, 'Cell', '', 1, '2024-11-27 09:22:24'),
(48, 7, 10, 'Plant and Animal', '', 1, '2024-11-27 09:22:33'),
(49, 7, 10, 'Arachnids', '', 1, '2024-11-27 09:22:41'),
(50, 7, 10, 'Vertebrate Animals', '', 1, '2024-11-27 09:22:53'),
(51, 7, 10, 'Invertebrate Animal', '', 1, '2024-11-27 09:23:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_teacher`
--
ALTER TABLE `class_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_formats`
--
ALTER TABLE `question_formats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_teacher`
--
ALTER TABLE `subject_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `class_teacher`
--
ALTER TABLE `class_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `question_formats`
--
ALTER TABLE `question_formats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `subject_teacher`
--
ALTER TABLE `subject_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;