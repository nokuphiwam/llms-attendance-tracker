-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 31, 2022 at 01:14 PM
-- Server version: 10.6.5-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms_attendance_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_table`
--

DROP TABLE IF EXISTS `attendance_table`;
CREATE TABLE IF NOT EXISTS `attendance_table` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `attendee_id` int(11) NOT NULL,
  `attendee_required` tinyint(1) DEFAULT NULL,
  `attended` tinyint(1) DEFAULT NULL,
  `communicated` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`attendance_id`),
  KEY `attendee_id` (`attendee_id`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_table`
--

INSERT INTO `attendance_table` (`attendance_id`, `class_id`, `attendee_id`, `attendee_required`, `attended`, `communicated`) VALUES
(1, 1, 3, 0, 0, 1),
(2, 10, 8, 1, 0, 0),
(3, 12, 9, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(100) NOT NULL,
  `class_description` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `class_capacity` int(11) DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `class_description`, `start_date`, `end_date`, `class_capacity`, `start_time`, `end_time`) VALUES
(1, 'mathsV2', 'calculus and algebra', '2022-08-24', '2022-08-24', 4, '10:00:00', '11:00:00'),
(2, 'NLP', 'natural language processing', '2022-08-25', '2022-08-25', 6, '08:00:00', '09:30:00'),
(7, 'NLP', 'This is natural language processing volume 2.', '2022-08-25', '2022-08-25', NULL, '08:00:00', '09:30:00'),
(8, 'Ontology', 'Ontology', '2022-08-27', '2022-08-27', NULL, '09:38:00', '10:38:00'),
(9, 'Research', 'Reasearch Topic', '2022-08-28', '2022-08-28', NULL, '10:46:00', '16:46:00'),
(10, 'ticket', '', '2022-08-27', '2022-09-01', NULL, '13:02:00', '15:02:00'),
(11, 'NLP7', '', '2022-08-10', '2022-08-10', NULL, '17:25:00', '19:25:00'),
(12, 'test fines', '', '2022-08-29', '2022-08-29', NULL, '05:06:00', '06:06:00');

-- --------------------------------------------------------

--
-- Table structure for table `class_attendees`
--

DROP TABLE IF EXISTS `class_attendees`;
CREATE TABLE IF NOT EXISTS `class_attendees` (
  `attendee_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  PRIMARY KEY (`attendee_id`),
  KEY `attendee_id` (`attendee_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_attendees`
--

INSERT INTO `class_attendees` (`attendee_id`, `first_name`, `last_name`) VALUES
(1, 'Noks', 'Masondo'),
(2, 'sipho', 'temu'),
(3, 'T', 'Majola'),
(4, 'Thabo', 'Mpofu'),
(5, 'Tracy', 'Page'),
(6, 'Sina', 'Tales'),
(7, 'hello', 'world'),
(8, 'hello', 'world'),
(9, 'hello', 'world');

-- --------------------------------------------------------

--
-- Table structure for table `fines`
--

DROP TABLE IF EXISTS `fines`;
CREATE TABLE IF NOT EXISTS `fines` (
  `fine_id` int(11) NOT NULL AUTO_INCREMENT,
  `attendance_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `fine_date` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`fine_id`),
  KEY `attendance_id` (`attendance_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fines`
--

INSERT INTO `fines` (`fine_id`, `attendance_id`, `amount`, `fine_date`) VALUES
(1, 2, 50, NULL),
(2, 3, 0, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
