-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2018 at 06:12 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `srms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '6a26249e7491b10f8b9df755d0d0e379', '2018-03-26 15:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `combinecourse`
--

CREATE TABLE `combinecourse` (
  `Combine_id` int(11) NOT NULL,
  `StudentId` int(11) NOT NULL,
  `PaperId` int(11) NOT NULL,
  `status` int(1) DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Updationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `combinecourse`
--

INSERT INTO `combinecourse` (`Combine_id`, `StudentId`, `PaperId`, `status`, `CreationDate`, `Updationdate`) VALUES
(1, 1, 1, 1, '2018-05-05 10:24:02', '2018-05-05 10:24:02'),
(2, 2, 1, 1, '2018-05-05 10:24:06', '2018-05-05 10:24:06'),
(3, 3, 1, 1, '2018-05-05 10:24:17', '2018-05-05 10:24:17'),
(4, 2, 4, 1, '2018-05-05 10:24:23', '2018-05-05 10:24:23'),
(5, 4, 4, 1, '2018-05-05 10:24:28', '2018-05-05 10:24:28'),
(6, 3, 2, 1, '2018-05-05 10:24:35', '2018-05-05 10:24:35'),
(7, 1, 2, 1, '2018-05-05 10:24:39', '2018-05-05 10:24:39'),
(8, 1, 3, 1, '2018-05-09 04:36:54', '2018-05-09 04:36:54'),
(9, 5, 3, 1, '2018-05-09 04:37:02', '2018-05-09 04:37:02'),
(10, 4, 3, 1, '2018-05-09 04:37:09', '2018-05-09 04:37:09'),
(11, 4, 2, 1, '2018-05-09 10:23:34', '2018-05-09 10:23:34'),
(12, 4, 1, 1, '2018-05-09 10:23:53', '2018-05-09 10:23:53'),
(13, 5, 6, 1, '2018-05-16 06:22:09', '2018-05-16 06:22:09'),
(14, 6, 1, 1, '2018-05-21 02:46:41', '2018-05-21 02:46:41'),
(15, 6, 2, 1, '2018-05-21 02:46:51', '2018-05-21 02:46:51');

-- --------------------------------------------------------

--
-- Table structure for table `examhall`
--

CREATE TABLE `examhall` (
  `HallId` int(11) NOT NULL,
  `HallName` varchar(255) NOT NULL,
  `HallCapacity` int(3) NOT NULL,
  `LevelNumber` int(2) NOT NULL,
  `Wing` varchar(5) NOT NULL,
  `Region` varchar(255) NOT NULL,
  `PaperId` int(11) NOT NULL,
  `StudentNumber` int(11) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `examhall`
--

INSERT INTO `examhall` (`HallId`, `HallName`, `HallCapacity`, `LevelNumber`, `Wing`, `Region`, `PaperId`, `StudentNumber`, `CreationDate`, `UpdationDate`) VALUES
(1, 'Hall 1', 6, 7, 'A', 'Main Campus', 1, 5, '2018-05-09 10:19:03', '2018-05-16 06:38:25'),
(2, 'Hall 2', 7, 7, 'A', 'Main Campus', 2, 5, '2018-05-09 10:19:59', '0000-00-00 00:00:00'),
(3, 'Hall 3', 7, 7, 'A', 'Main Campus', 3, 5, '2018-05-09 10:20:20', '0000-00-00 00:00:00'),
(4, 'Hall 4', 9, 7, 'B', 'Main Campus', 4, 5, '2018-05-09 10:21:09', '0000-00-00 00:00:00'),
(5, 'Hall 5', 9, 7, 'B', 'Main Campus', 5, 5, '2018-05-09 10:21:27', '0000-00-00 00:00:00'),
(6, 'Hall 5', 7, 7, 'A', 'Main Campus', 1, 6, '2018-05-21 02:48:35', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `exampaper`
--

CREATE TABLE `exampaper` (
  `Paper_id` int(11) NOT NULL,
  `Faculty` varchar(255) NOT NULL,
  `Programme` varchar(255) NOT NULL,
  `CourseName` varchar(100) NOT NULL,
  `CourseCode` varchar(100) NOT NULL,
  `Section` varchar(10) NOT NULL,
  `ExamDate` varchar(100) NOT NULL,
  `StartTime` varchar(100) NOT NULL,
  `EndTime` varchar(100) NOT NULL,
  `Creationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exampaper`
--

INSERT INTO `exampaper` (`Paper_id`, `Faculty`, `Programme`, `CourseName`, `CourseCode`, `Section`, `ExamDate`, `StartTime`, `EndTime`, `Creationdate`, `UpdationDate`) VALUES
(1, 'Faculty of Business Technology and Accounting', 'Bachelor of Information Technology (Hons)', 'Issues in ICT', 'ITIB3182', 'S1', '2018-02-05', '09:00', '12:00', '2018-05-05 10:00:31', '2018-05-16 05:51:57'),
(2, 'Faculty of Business Technology and Accounting', 'Bachelor of Information Technology (Hons)', 'Discrete Mathematics', 'ITNB1023', 'S2', '2018-03-05', '09:00', '12:00', '2018-05-05 10:01:35', '2018-05-13 07:10:22'),
(3, 'Faculty of Business Technology and Accounting', 'Bachelor of Information Technology (Hons)', 'Databases', 'ITIB2063', 'S2', '2018-02-05', '14:30', '17:30', '2018-05-05 10:02:41', '2018-05-13 07:12:36'),
(4, 'Faculty of Business Technology and Accounting', 'Bachelor of Information Technology (Hons)', 'Operating Systems', 'ITIB2063', 'S2', '2018-03-05', '13:30', '17:30', '2018-05-05 10:03:23', '2018-05-13 07:14:56'),
(5, 'Faculty of Education and Humanities', 'Bachelor of Communication (Hons)', 'News Writing', 'BCNW233', 'S3', '2018-05-04', '09:00', '12:00', '2018-05-05 10:04:47', '2018-05-13 07:15:31'),
(6, 'Faculty of Education and Humanities', 'Bachelor of Communication (Hons)', 'Online Journalism', 'BCOJ234', 'S4', '2018-12-31', '09:00', '12:00', '2018-05-13 06:58:32', '2018-05-13 07:15:50'),
(7, 'Faculty of Business Technology and Accounting', 'Bachelor of Information Technology (Hons)', 'Knowledge Management', 'ITIB2064', 'S2', '2018-04-06', '09:00', '12:00', '2018-05-21 02:43:33', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `seatnumber`
--

CREATE TABLE `seatnumber` (
  `Seat_id` int(11) NOT NULL,
  `PaperId` int(11) DEFAULT NULL,
  `HallId` int(11) DEFAULT NULL,
  `StudentId` int(11) DEFAULT NULL,
  `SeatingNumber` int(11) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seatnumber`
--

INSERT INTO `seatnumber` (`Seat_id`, `PaperId`, `HallId`, `StudentId`, `SeatingNumber`, `PostingDate`, `UpdationDate`) VALUES
(1, 1, 1, 4, 1, '2018-05-09 10:24:21', '2018-05-10 11:36:02'),
(2, 1, 1, 1, 2, '2018-05-09 10:24:21', NULL),
(3, 1, 1, 3, 3, '2018-05-09 10:24:21', NULL),
(4, 1, 1, 2, 4, '2018-05-09 10:24:21', NULL),
(5, 2, 2, 4, 1, '2018-05-09 10:24:46', '2018-05-11 12:47:44'),
(6, 2, 2, 1, 2, '2018-05-09 10:24:46', NULL),
(7, 2, 2, 3, 3, '2018-05-09 10:24:46', NULL),
(8, 3, 3, 4, 1, '2018-05-09 10:24:56', NULL),
(9, 3, 3, 5, 2, '2018-05-09 10:24:56', NULL),
(10, 3, 3, 1, 3, '2018-05-09 10:24:56', NULL),
(11, 1, 6, 1, 1, '2018-05-21 02:49:10', NULL),
(12, 1, 6, 6, 2, '2018-05-21 02:49:10', NULL),
(13, 1, 6, 3, 3, '2018-05-21 02:49:10', NULL),
(14, 1, 6, 2, 4, '2018-05-21 02:49:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `studentinfo`
--

CREATE TABLE `studentinfo` (
  `id` int(11) NOT NULL,
  `StudentName` varchar(100) NOT NULL,
  `MatricNumber` varchar(100) NOT NULL,
  `StudentEmail` varchar(100) NOT NULL,
  `MobileNumber` char(14) NOT NULL,
  `CourseName` varchar(100) NOT NULL,
  `Section` varchar(10) NOT NULL,
  `ExamDate` varchar(100) NOT NULL,
  `StartTime` varchar(100) NOT NULL,
  `EndTime` varchar(100) NOT NULL,
  `HallName` varchar(100) NOT NULL,
  `LevelNumber` int(2) NOT NULL,
  `Wing` varchar(5) NOT NULL,
  `Region` varchar(100) NOT NULL,
  `SeatingNumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentinfo`
--

INSERT INTO `studentinfo` (`id`, `StudentName`, `MatricNumber`, `StudentEmail`, `MobileNumber`, `CourseName`, `Section`, `ExamDate`, `StartTime`, `EndTime`, `HallName`, `LevelNumber`, `Wing`, `Region`, `SeatingNumber`) VALUES
(5, 'Khairy Kelifa', 'MC1506BC9049', 'khairykelifa@aol.com', '00601113022530', 'Issues in ICT (ITIB3182)', 'S1', '2018-02-05', '09:00', '12:00', 'Hall 5', 7, 'A', 'Main Campus', 1),
(6, 'Suhaib Al-tamzani', 'MC1506BC9822', 'khairykelifa@aol.com', '00601113022530', 'Issues in ICT (ITIB3182)', 'S1', '2018-02-05', '09:00', '12:00', 'Hall 5', 7, 'A', 'Main Campus', 4),
(7, 'Nader Kelifa', 'MC1506BC9048', 'khairykelifa@aol.com', '00601113022530', 'Issues in ICT (ITIB3182)', 'S1', '2018-02-05', '09:00', '12:00', 'Hall 5', 7, 'A', 'Main Campus', 3),
(8, 'Mohd', 'MC1504BC9048', 'khairykelifa@aol.com', '00601113022530', 'Issues in ICT (ITIB3182)', 'S1', '2018-02-05', '09:00', '12:00', 'Hall 5', 7, 'A', 'Main Campus', 2),
(9, 'Khairy Kelifa', 'MC1506BC9049', 'khairykelifa@aol.com', '00601113022530', 'Discrete Mathematics (ITNB1023)', 'S2', '2018-03-05', '09:00', '12:00', 'Hall 2', 7, 'A', 'Main Campus', 2),
(10, 'Nader Kelifa', 'MC1506BC9048', 'khairykelifa@aol.com', '00601113022530', 'Discrete Mathematics (ITNB1023)', 'S2', '2018-03-05', '09:00', '12:00', 'Hall 2', 7, 'A', 'Main Campus', 3),
(11, 'Khairy Kelifa', 'MC1506BC9049', 'khairykelifa@aol.com', '00601113022530', 'Databases (ITIB2063)', 'S2', '2018-02-05', '14:30', '17:30', 'Hall 3', 7, 'A', 'Main Campus', 3),
(12, 'Anuj kumar ', 'MC1601BC9874', 'khairykelifa@aol.com', '00601113022530', 'Databases (ITIB2063)', 'S2', '2018-02-05', '14:30', '17:30', 'Hall 3', 7, 'A', 'Main Campus', 2);

-- --------------------------------------------------------

--
-- Table structure for table `unistudents`
--

CREATE TABLE `unistudents` (
  `Student_id` int(11) NOT NULL,
  `StudentName` varchar(100) NOT NULL,
  `MatricNumber` varchar(100) NOT NULL,
  `StudentEmail` varchar(100) NOT NULL,
  `MobileNumber` char(14) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `CurrentSemester` varchar(100) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unistudents`
--

INSERT INTO `unistudents` (`Student_id`, `StudentName`, `MatricNumber`, `StudentEmail`, `MobileNumber`, `Gender`, `CurrentSemester`, `RegDate`, `UpdationDate`, `Status`) VALUES
(1, 'Khairy Kelifa', 'MC1506BC9049', 'khairykelifa@aol.com', '00601113022530', 'Male', '2018-01', '2018-05-05 10:08:36', '2018-05-16 07:46:24', 1),
(2, 'Suhaib Al-tamzani', 'MC1506BC9822', 'khairykelifa@aol.com', '00601113022530', 'Male', '2018-01', '2018-05-05 10:12:11', '2018-05-15 13:15:12', 1),
(3, 'Nader Kelifa', 'MC1506BC9048', 'khairykelifa@aol.com', '00601113022530', 'Male', '2018-01', '2018-05-05 10:14:30', '2018-05-15 13:18:42', 1),
(5, 'Anuj kumar ', 'MC1601BC9874', 'khairykelifa@aol.com', '00601113022530', 'Female', '2018-01', '2018-05-05 10:16:41', '2018-05-15 13:19:47', 1),
(6, 'Mohd', 'MC1504BC9048', 'khairykelifa@aol.com', '00601113022530', 'Male', '2018-01', '2018-05-21 02:45:38', '2018-05-21 02:46:04', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `combinecourse`
--
ALTER TABLE `combinecourse`
  ADD PRIMARY KEY (`Combine_id`);

--
-- Indexes for table `examhall`
--
ALTER TABLE `examhall`
  ADD PRIMARY KEY (`HallId`);

--
-- Indexes for table `exampaper`
--
ALTER TABLE `exampaper`
  ADD PRIMARY KEY (`Paper_id`);

--
-- Indexes for table `seatnumber`
--
ALTER TABLE `seatnumber`
  ADD PRIMARY KEY (`Seat_id`);

--
-- Indexes for table `studentinfo`
--
ALTER TABLE `studentinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unistudents`
--
ALTER TABLE `unistudents`
  ADD PRIMARY KEY (`Student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `combinecourse`
--
ALTER TABLE `combinecourse`
  MODIFY `Combine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `examhall`
--
ALTER TABLE `examhall`
  MODIFY `HallId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `exampaper`
--
ALTER TABLE `exampaper`
  MODIFY `Paper_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seatnumber`
--
ALTER TABLE `seatnumber`
  MODIFY `Seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `studentinfo`
--
ALTER TABLE `studentinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `unistudents`
--
ALTER TABLE `unistudents`
  MODIFY `Student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
