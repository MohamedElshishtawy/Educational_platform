-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2023 at 07:09 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isef`
--

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `exam_name` varchar(100) NOT NULL,
  `se` varchar(5) NOT NULL,
  `vilablility` int(1) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `exam_name`, `se`, `vilablility`, `date`) VALUES
(1, 'First_Year', '1se', 1, '2023-08-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `exams_for_1`
--

CREATE TABLE `exams_for_1` (
  `student_id` int(11) NOT NULL,
  `First_Year` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exams_for_1`
--

INSERT INTO `exams_for_1` (`student_id`, `First_Year`) VALUES
(34627, '1 / 2 @ 18-08-2023 07:07:26 ^1');

-- --------------------------------------------------------

--
-- Table structure for table `exams_for_2`
--

CREATE TABLE `exams_for_2` (
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exams_for_3`
--

CREATE TABLE `exams_for_3` (
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `ar_name` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` varchar(200) NOT NULL,
  `money` int(11) NOT NULL,
  `se` varchar(10) NOT NULL,
  `groub` varchar(20) NOT NULL,
  `state` int(5) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `ar_name`, `phone`, `password`, `money`, `se`, `groub`, `state`) VALUES
(18542, 'Educater', '01093033115', '123', 0, 'AD', '0', 11),
(34627, 'محمد وجدى ', '01093033166', '123456', 1, '1se', 'Boys 1', 10),
(49173, 'Mohaned', '01068353563', '111', 0, '1se', 'boys 1', 10);

-- --------------------------------------------------------

--
-- Table structure for table `timer`
--

CREATE TABLE `timer` (
  `student_id` int(11) NOT NULL,
  `back_time` varchar(100) NOT NULL,
  `for_exam` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49174;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
