-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 22, 2025 at 02:12 PM
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
-- Database: `brngydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--

CREATE TABLE `Admins` (
  `AdminID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Admins`
--

INSERT INTO `Admins` (`AdminID`, `Username`, `Password`, `FullName`, `Email`, `CreatedAt`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'admin@barangay.com', '2025-11-22 13:10:58');

-- --------------------------------------------------------

--
-- Table structure for table `Households`
--

CREATE TABLE `Households` (
  `HouseholdID` int(11) NOT NULL,
  `HouseNumber` varchar(20) DEFAULT NULL,
  `Street` varchar(50) DEFAULT NULL,
  `BarangayName` varchar(50) DEFAULT NULL,
  `HeadOfHousehold` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Incidents`
--

CREATE TABLE `Incidents` (
  `IncidentID` int(11) NOT NULL,
  `TrackingNumber` varchar(50) DEFAULT NULL,
  `IncidentType` varchar(50) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `DateReported` date DEFAULT NULL,
  `ReportedBy` int(11) DEFAULT NULL,
  `HandledBy` int(11) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `AdminResponse` text DEFAULT NULL,
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Incidents`
--

INSERT INTO `Incidents` (`IncidentID`, `TrackingNumber`, `IncidentType`, `Description`, `DateReported`, `ReportedBy`, `HandledBy`, `Status`, `AdminResponse`, `UpdatedAt`) VALUES
(1, 'TRK-2024-ABC12345', 'Noise Complaint', 'Loud music from neighbor until late night', '2024-11-20', 1, NULL, 'Pending', NULL, '2025-11-22 13:10:58'),
(2, 'TRK-2024-DEF67890', 'Street Light', 'Broken street light on Main Street', '2024-11-21', 2, NULL, 'In Progress', NULL, '2025-11-22 13:10:58');

-- --------------------------------------------------------

--
-- Table structure for table `Officials`
--

CREATE TABLE `Officials` (
  `OfficialID` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `Position` varchar(50) DEFAULT NULL,
  `TermStart` date DEFAULT NULL,
  `TermEnd` date DEFAULT NULL,
  `ContactNumber` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Officials`
--

INSERT INTO `Officials` (`OfficialID`, `FullName`, `Position`, `TermStart`, `TermEnd`, `ContactNumber`) VALUES
(1, 'Roberto Garcia', 'Barangay Captain', '2023-01-01', '2026-12-31', '09191234567'),
(2, 'Ana Reyes', 'Barangay Secretary', '2023-01-01', '2026-12-31', '09192345678'),
(3, 'Carlos Torres', 'Barangay Treasurer', '2023-01-01', '2026-12-31', '09193456789');

-- --------------------------------------------------------

--
-- Table structure for table `Reports`
--

CREATE TABLE `Reports` (
  `ReportID` int(11) NOT NULL,
  `ReportType` varchar(50) DEFAULT NULL,
  `DateGenerated` date DEFAULT NULL,
  `GeneratedBy` int(11) DEFAULT NULL,
  `Content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Residents`
--

CREATE TABLE `Residents` (
  `ResidentID` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `BirthDate` date DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `ContactNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Role` varchar(20) DEFAULT 'resident',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `HouseholdID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Residents`
--

INSERT INTO `Residents` (`ResidentID`, `FirstName`, `LastName`, `BirthDate`, `Gender`, `Address`, `ContactNumber`, `Email`, `Password`, `Role`, `CreatedAt`, `HouseholdID`) VALUES
(1, 'Juan', 'Dela Cruz', '1990-05-15', 'Male', '123 Main St, Barangay Centro', '09171234567', 'juan@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'resident', '2025-11-22 13:10:58', NULL),
(2, 'Maria', 'Santos', '1985-08-20', 'Female', '456 Second St, Barangay Centro', '09187654321', 'maria@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'resident', '2025-11-22 13:10:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Services`
--

CREATE TABLE `Services` (
  `ServiceID` int(11) NOT NULL,
  `ServiceName` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `ResponsibleOfficialID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `Households`
--
ALTER TABLE `Households`
  ADD PRIMARY KEY (`HouseholdID`),
  ADD KEY `fk_households_head` (`HeadOfHousehold`);

--
-- Indexes for table `Incidents`
--
ALTER TABLE `Incidents`
  ADD PRIMARY KEY (`IncidentID`),
  ADD UNIQUE KEY `TrackingNumber` (`TrackingNumber`),
  ADD KEY `fk_incidents_reportedby` (`ReportedBy`),
  ADD KEY `fk_incidents_handledby` (`HandledBy`);

--
-- Indexes for table `Officials`
--
ALTER TABLE `Officials`
  ADD PRIMARY KEY (`OfficialID`);

--
-- Indexes for table `Reports`
--
ALTER TABLE `Reports`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `fk_reports_generatedby` (`GeneratedBy`);

--
-- Indexes for table `Residents`
--
ALTER TABLE `Residents`
  ADD PRIMARY KEY (`ResidentID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `fk_residents_household` (`HouseholdID`);

--
-- Indexes for table `Services`
--
ALTER TABLE `Services`
  ADD PRIMARY KEY (`ServiceID`),
  ADD KEY `fk_services_official` (`ResponsibleOfficialID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admins`
--
ALTER TABLE `Admins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Households`
--
ALTER TABLE `Households`
  MODIFY `HouseholdID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Incidents`
--
ALTER TABLE `Incidents`
  MODIFY `IncidentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Officials`
--
ALTER TABLE `Officials`
  MODIFY `OfficialID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Reports`
--
ALTER TABLE `Reports`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Residents`
--
ALTER TABLE `Residents`
  MODIFY `ResidentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Services`
--
ALTER TABLE `Services`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Households`
--
ALTER TABLE `Households`
  ADD CONSTRAINT `fk_households_head` FOREIGN KEY (`HeadOfHousehold`) REFERENCES `Residents` (`ResidentID`);

--
-- Constraints for table `Incidents`
--
ALTER TABLE `Incidents`
  ADD CONSTRAINT `fk_incidents_handledby` FOREIGN KEY (`HandledBy`) REFERENCES `Officials` (`OfficialID`),
  ADD CONSTRAINT `fk_incidents_reportedby` FOREIGN KEY (`ReportedBy`) REFERENCES `Residents` (`ResidentID`);

--
-- Constraints for table `Reports`
--
ALTER TABLE `Reports`
  ADD CONSTRAINT `fk_reports_generatedby` FOREIGN KEY (`GeneratedBy`) REFERENCES `Officials` (`OfficialID`);

--
-- Constraints for table `Residents`
--
ALTER TABLE `Residents`
  ADD CONSTRAINT `fk_residents_household` FOREIGN KEY (`HouseholdID`) REFERENCES `Households` (`HouseholdID`);

--
-- Constraints for table `Services`
--
ALTER TABLE `Services`
  ADD CONSTRAINT `fk_services_official` FOREIGN KEY (`ResponsibleOfficialID`) REFERENCES `Officials` (`OfficialID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
