-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2024 at 07:35 PM
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
-- Database: `the_cryptoshow`
--

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `DeviceID` int(11) NOT NULL,
  `DeviceName` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`DeviceID`, `DeviceName`, `Description`, `Status`) VALUES
(1, 'DeviceName1', 'Description1', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `EventID` int(11) NOT NULL,
  'EventName' varchar(20) DEFAULT NULL,
  `OrganizerID` int(11) DEFAULT NULL,
  `DeviceID` int(11) DEFAULT NULL,
  `EventDate` date DEFAULT NULL,
  `EventTime` time DEFAULT NULL,
  `EventDescription` varchar(255) DEFAULT NULL,
  `EventLocation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `EventName`, `OrganizerID`, `DeviceID`, `EventDate`, `EventTime`, `EventDescription`, `EventLocation`) VALUES
(2, 1, 1, '2024-03-17', '20:00:00', 'Evening Gala', 'Hotel Ballroom'),
(3, 1, 1, '2024-03-15', '18:00:00', 'Annual General Meeting', 'Conference Room A'),
(4, 2, 1, '2024-03-16', '09:00:00', 'Tech Product Launch', 'Main Auditorium'),
(5, 3, 1, '2024-03-29', '15:00:00', 'Bitcoin Show', 'De Montfort University'),
(6, 13, 1, '2024-03-16', '09:00:00', 'Tech Product Launch', 'Main Auditorium'),
(7, 13, 1, '2024-03-16', '09:00:00', 'Cryptoshow', 'DSU');

-- --------------------------------------------------------

--
-- Table structure for table `loginhistory`
--

CREATE TABLE `loginhistory` (
  `LoginHistoryID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `LoginDT` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loginhistory`
--

INSERT INTO `loginhistory` (`LoginHistoryID`, `MemberID`, `LoginDT`) VALUES
(1, 2, '2024-03-13 00:34:02'),
(2, 2, '2024-03-13 01:23:24'),
(3, 3, '2024-03-13 01:24:18'),
(4, 3, '2024-03-13 01:32:41'),
(5, 3, '2024-03-13 01:34:31'),
(6, 3, '2024-03-13 01:34:49'),
(7, 3, '2024-03-13 07:32:37'),
(8, 2, '2024-03-13 21:40:03'),
(11, 2, '2024-03-14 00:38:07'),
(13, 3, '2024-03-14 01:51:56'),
(14, 2, '2024-03-14 02:14:52'),
(15, 13, '2024-03-14 15:18:25'),
(16, 2, '2024-03-15 10:32:35'),
(17, 2, '2024-03-15 12:31:29'),
(18, 2, '2024-03-15 13:50:45'),
(19, 2, '2024-03-15 13:51:31'),
(20, 2, '2024-03-15 16:03:34'),
(21, 13, '2024-03-15 18:15:44'),
(22, 13, '2024-03-15 18:20:16'),
(23, 13, '2024-03-15 18:21:25'),
(24, 2, '2024-03-15 18:21:44'),
(25, 2, '2024-03-15 18:25:44'),
(26, 2, '2024-03-15 18:26:05'),
(27, 2, '2024-03-15 18:29:56'),
(28, 2, '2024-03-15 18:30:34'),
(29, 2, '2024-03-15 18:31:25'),
(30, 2, '2024-03-15 18:32:57'),
(31, 2, '2024-03-15 18:34:36'),
(32, 2, '2024-03-15 18:35:13'),
(33, 2, '2024-03-15 18:35:14'),
(34, 2, '2024-03-15 18:35:14'),
(35, 2, '2024-03-15 18:35:14'),
(36, 2, '2024-03-15 18:35:33'),
(37, 1, '2024-03-15 18:35:57'),
(38, 2, '2024-03-15 18:39:21'),
(39, 1, '2024-03-15 18:41:49'),
(40, 2, '2024-03-15 18:42:24'),
(41, 2, '2024-03-15 18:42:25'),
(42, 2, '2024-03-15 18:42:25'),
(43, 2, '2024-03-15 18:42:25'),
(44, 2, '2024-03-15 18:42:42'),
(45, 2, '2024-03-15 18:42:54'),
(46, 14, '2024-03-15 18:50:37'),
(47, 1, '2024-03-15 18:51:08'),
(48, 14, '2024-03-15 18:55:25'),
(49, 1, '2024-03-15 18:56:32'),
(50, 14, '2024-03-15 18:58:48'),
(51, 2, '2024-03-16 12:09:56'),
(52, 1, '2024-03-16 12:11:00');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `MemberID` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(20) DEFAULT NULL,
  `UserType` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`MemberID`, `Name`, `Email`, `Password`, `UserType`) VALUES
(1, 'Karan F. Modi', 'karan@cryptoshow.com', '123456', 'admin'),
(2, 'Karan Modi', 'karanmodi3282@gmail.com', '123456', 'member'),
(3, 'Bhoomi Modi', 'b@gmail.com', '123456', 'member'),
(13, 'Karan Modi', 'k1@gmail.com', '123456', 'member'),
(14, 'Krish Patel', 'Krihu@gmail.com', '123456', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`DeviceID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventID`),
  ADD KEY `OrganizerID` (`OrganizerID`),
  ADD KEY `DeviceID` (`DeviceID`);

--
-- Indexes for table `loginhistory`
--
ALTER TABLE `loginhistory`
  ADD PRIMARY KEY (`LoginHistoryID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`MemberID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `DeviceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `loginhistory`
--
ALTER TABLE `loginhistory`
  MODIFY `LoginHistoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`OrganizerID`) REFERENCES `member` (`MemberID`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`DeviceID`) REFERENCES `devices` (`DeviceID`);

--
-- Constraints for table `loginhistory`
--
ALTER TABLE `loginhistory`
  ADD CONSTRAINT `loginhistory_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
