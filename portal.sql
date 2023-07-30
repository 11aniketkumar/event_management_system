-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2023 at 06:25 AM
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
-- Database: `portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `SNO` int(5) NOT NULL,
  `COORDINATOR` int(5) NOT NULL,
  `HEADING` varchar(100) NOT NULL,
  `PHOTO` varchar(10) NOT NULL,
  `DATE` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `REGISTERED` int(5) NOT NULL DEFAULT 0,
  `FEEDBACK` float NOT NULL DEFAULT 0,
  `TYPE` varchar(20) NOT NULL,
  `DETAILS` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`SNO`, `COORDINATOR`, `HEADING`, `PHOTO`, `DATE`, `REGISTERED`, `FEEDBACK`, `TYPE`, `DETAILS`) VALUES
(14, 5, 'Hackathon', '14.jpg', '2023-08-04 16:04:00.000000', 2, 0, 'Tech Event', '1. Form the group of 3-4 students.\r\n2. Set of Problem statements (Software or Hardware) will be announced\r\non\r\n3. Each group can select any one problem statement and for which\r\nefficient solution has to be designed.\r\n4. Registration closes on 10th January 2023.\r\n5. Hackathon will be for 5 hours (4 hours for\r\ncoding/implementation/prototyping and 1 hour for evaluation).\r\n6. Participants can use any language, platform and components.\r\n7. Usage of internet is allowed.\r\n8. Participants needs to bring their ow'),
(22, 5, 'TOUCH ME NOT', '22.jpg', '2023-08-13 10:00:00.000000', 0, 0, 'Gaming', 'An electric circuit with a 9V battery , a bulb , a buzzer and a copper cable are connected in series .The other end of the wire should be moved without touching the copper cable. If the wire touches the copper cable the circuit closes and the bulb glows and the buzzer is on. RULES: 1. In the given time the player has to move a wire loop around a copper cable from one end to the other end. 2. The player who moves the loop to the longest distance in minimum time without touching the copper cable');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `SNO` int(5) NOT NULL,
  `NAME` varchar(30) NOT NULL,
  `EMAIL` varchar(30) NOT NULL,
  `PHONE` varchar(15) NOT NULL,
  `PASSWORD` varchar(500) NOT NULL,
  `RANK` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`SNO`, `NAME`, `EMAIL`, `PHONE`, `PASSWORD`, `RANK`) VALUES
(5, 'co', 'ccc', '435334', '$2y$10$I6EUJEqZceCmB8KSasXBPuR1Tx3F5rocg6.rBLR/9b.wnpO8EzIz2', 'coordinato'),
(6, 'hod', 'hhh', '4353453', '$2y$10$hKhxBD6Svrh6A8KdtrLJIeNwFG/cjVFXEb9EqSe3VPOHK2mQXVPYK', 'department');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `SNO` int(5) NOT NULL,
  `NAME` varchar(30) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `PHONE` varchar(15) NOT NULL,
  `PASSWORD` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`SNO`, `NAME`, `EMAIL`, `PHONE`, `PASSWORD`) VALUES
(3, 'aniket', 'kkk', '892384923', '$2y$10$8qw3cg7CcjgJBjElhQmZ/.Q8E3KiO.tql8Tp3zapMIbv9Mj.tnLUK'),
(4, 'dinesh', 'aa', '43985734', '$2y$10$Ogviiy2C8fhSc0.7NoxR5uBTmM8b0rwaEF.GGM/2NskmjutvSTBqG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`SNO`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`SNO`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`SNO`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `SNO` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `SNO` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `SNO` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
