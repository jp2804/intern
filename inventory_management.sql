-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2020 at 08:43 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `emp_id` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `Equipment_Description` varchar(2000) NOT NULL,
  `Equipment_ID` varchar(200) NOT NULL,
  `Equipment_Name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `company_employees`
--

CREATE TABLE `company_employees` (
  `emp_id` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE `components` (
  `Equipment_Description` varchar(2000) NOT NULL,
  `Equipment_ID` varchar(200) NOT NULL,
  `Equipment_Name` varchar(200) NOT NULL,
  `Equipment_Status` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `componentsremarks`
--

CREATE TABLE `componentsremarks` (
  `Date` date NOT NULL,
  `EquipmentID` varchar(200) NOT NULL,
  `Remarks` mediumtext NOT NULL,
  `employee_ID` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `duration`
--

CREATE TABLE `duration` (
  `EquipmentDescription` mediumtext NOT NULL,
  `EquipmentID` varchar(200) NOT NULL,
  `EquipmentName` varchar(2000) NOT NULL,
  `FromDate` date NOT NULL,
  `FromTime` time NOT NULL,
  `RegNo` varchar(2000) NOT NULL,
  `EmployeeName` varchar(2000) NOT NULL,
  `ToDate` date NOT NULL,
  `ToTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `Email` varchar(2000) NOT NULL,
  `Gender` varchar(200) NOT NULL,
  `Mobile` char(20) NOT NULL,
  `Name` varchar(2000) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Emp_ID` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `Date` date NOT NULL,
  `EquipmentID` varchar(200) NOT NULL,
  `EquipmentName` varchar(2000) NOT NULL,
  `EmID` varchar(200) NOT NULL,
  `Status` varchar(200) NOT NULL,
  `EmployeeName` varchar(2000) NOT NULL,
  `Time` time NOT NULL,
  `EquipmentDescription` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `Date` date NOT NULL,
  `EquipmentDescription` varchar(2000) NOT NULL,
  `EquipmentID` varchar(2000) NOT NULL,
  `EquipmentName` varchar(2000) NOT NULL,
  `EmpID` varchar(2000) NOT NULL,
  `Status` varchar(2000) NOT NULL,
  `EmployeeName` varchar(2000) NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`Equipment_ID`);

--
-- Indexes for table `company_employees`
--
ALTER TABLE `company_employees`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`Equipment_ID`);

--
-- Indexes for table `duration`
--
ALTER TABLE `duration`
  ADD PRIMARY KEY (`EquipmentID`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`Emp_ID`),
  ADD UNIQUE KEY `Mobile` (`Mobile`),
  ADD UNIQUE KEY `Email` (`Email`) USING HASH;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
