-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 12, 2018 at 12:11 PM
-- Server version: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `people_counter`
--

-- --------------------------------------------------------

--
-- Table structure for table `boats`
--

CREATE TABLE `boats` (
  `id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `boat_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `boats`
--

INSERT INTO `boats` (`id`, `timestamp`, `boat_code`, `active`) VALUES
(1, 1515755002, 'oomigr', 1);

-- --------------------------------------------------------

--
-- Table structure for table `people_on_board`
--

CREATE TABLE `people_on_board` (
  `id` int(11) NOT NULL,
  `boat_id` int(11) NOT NULL,
  `sex` varchar(2) COLLATE utf8_bin NOT NULL,
  `scabies` tinyint(1) NOT NULL DEFAULT '0',
  `needs_protection` tinyint(1) NOT NULL DEFAULT '0',
  `medical_case` tinyint(1) NOT NULL DEFAULT '0',
  `nationality` varchar(255) COLLATE utf8_bin NOT NULL,
  `age` varchar(255) COLLATE utf8_bin NOT NULL,
  `alone_traveling_woman` tinyint(1) NOT NULL,
  `unaccopanied_minor` tinyint(1) NOT NULL,
  `pregnant_woman` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `people_on_board`
--

INSERT INTO `people_on_board` (`id`, `boat_id`, `sex`, `scabies`, `needs_protection`, `medical_case`, `nationality`, `age`, `alone_traveling_woman`, `unaccopanied_minor`, `pregnant_woman`) VALUES
(1, 1, 'm', 0, 0, 0, 'Libya', '0-5', 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boats`
--
ALTER TABLE `boats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people_on_board`
--
ALTER TABLE `people_on_board`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boats`
--
ALTER TABLE `boats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `people_on_board`
--
ALTER TABLE `people_on_board`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
