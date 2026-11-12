-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2026 at 05:07 PM
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
-- Database: `ep`
--

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `Budget_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Budget_Name` varchar(100) NOT NULL,
  `Amount_Limit` decimal(12,2) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Start_Date` date DEFAULT NULL,
  `End_Date` date DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`Budget_ID`, `User_ID`, `Budget_Name`, `Amount_Limit`, `Description`, `Start_Date`, `End_Date`, `Created_At`) VALUES
(1, 1, 'Monthly Budget', 20000.00, 'Monthly personal expense budget', '2026-08-17', '2026-09-17', '2026-08-17 12:44:49'),
(2, 31, 'Food Budget', 18000.00, 'Food and restaurant expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(3, 39, 'Student Budget', 20000.00, 'Student monthly expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(4, NULL, 'Family Budget', 30000.00, 'Family monthly expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(5, 40, 'Family Budget', 30000.00, 'Family monthly expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(6, 42, 'Monthly Budget', 25000.00, 'Monthly personal expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(7, 36, 'Monthly Budget', 25000.00, 'Monthly personal expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(8, 32, 'Personal Budget', 22000.00, 'Personal shopping and daily expenses', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(9, 29, 'Monthly Expense Budget', 24000.00, 'Monthly overall expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(10, 24, 'Monthly Budget', 25000.00, 'Monthly personal expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(11, 30, 'Monthly Budget', 25000.00, 'Monthly personal expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(12, 35, 'Monthly Expense Budget', 24000.00, 'Monthly overall expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(13, 25, 'Food Budget', 18000.00, 'Food and restaurant expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(14, 27, 'Student Budget', 20000.00, 'Student monthly expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(15, 37, 'Food Budget', 18000.00, 'Food and restaurant expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(16, 41, 'Monthly Expense Budget', 24000.00, 'Monthly overall expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(17, 3, 'Student Budget', 20000.00, 'Student monthly expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(18, 33, 'Student Budget', 20000.00, 'Student monthly expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(19, 2, 'Personal Budget', 22000.00, 'Personal shopping and daily expenses', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(20, 34, 'Family Budget', 30000.00, 'Family monthly expense budget', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(21, 38, 'Personal Budget', 22000.00, 'Personal shopping and daily expenses', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00'),
(22, 26, 'Personal Budget', 22000.00, 'Personal shopping and daily expenses', '2026-08-01', '2026-08-30', '2026-08-01 03:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_ID` int(11) NOT NULL,
  `Category_Name` varchar(100) NOT NULL,
  `Category_Type` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Day` int(11) DEFAULT NULL,
  `Status` varchar(30) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_ID`, `Category_Name`, `Category_Type`, `Description`, `Day`, `Status`) VALUES
(1, 'Salary', 'Income', 'Monthly salary', NULL, 'Active'),
(2, 'Food', 'Expense', 'Food and restaurant expenses', NULL, 'Active'),
(3, 'Shopping', 'Expense', 'Shopping expenses', NULL, 'Active'),
(4, 'Transport', 'Expense', 'Bus, CNG and transport', NULL, 'Active'),
(5, 'Education', 'Expense', 'Education related expenses', NULL, 'Active'),
(6, 'Medical', 'Expense', 'Medical expenses', NULL, 'Active'),
(7, 'Entertainment', 'Expense', 'Entertainment expenses', NULL, 'Active'),
(8, 'Bills', 'Expense', 'Utility and other bills', NULL, 'Active'),
(9, 'Others', 'Expense', 'Other expenses', NULL, 'Active'),
(10, 'Medicine', 'Expense', '', NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `goal`
--

CREATE TABLE `goal` (
  `Goal_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Goal_Name` varchar(100) NOT NULL,
  `Target_Amount` decimal(12,2) NOT NULL,
  `Current_Amount` decimal(12,2) DEFAULT 0.00,
  `Target_Date` date DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Status` varchar(30) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `goal`
--

INSERT INTO `goal` (`Goal_ID`, `User_ID`, `Goal_Name`, `Target_Amount`, `Current_Amount`, `Target_Date`, `Description`, `Status`) VALUES
(1, 1, 'Travel Fund', 50000.00, 10000.00, '2027-02-17', 'Savings for travel', 'Active'),
(2, 1, 'New Laptop', 80000.00, 35000.00, '2026-09-10', 'Save money to buy a new laptop', 'In Progress'),
(3, 31, 'New Laptop', 80000.00, 35000.00, '2026-09-10', 'Save money to buy a new laptop', 'Active'),
(4, 39, 'Education Fund', 40000.00, 15000.00, '2026-09-20', 'Save money for education and courses', 'Active'),
(5, NULL, 'New Phone', 50000.00, 28000.00, '2026-09-25', 'Save money to purchase a new phone', 'Completed'),
(6, 40, 'New Phone', 50000.00, 28000.00, '2026-09-25', 'Save money to purchase a new phone', 'Completed'),
(7, 42, 'Emergency Fund', 50000.00, 18000.00, '2026-09-05', 'Build an emergency savings fund', 'In Progress'),
(8, 36, 'Emergency Fund', 50000.00, 18000.00, '2026-09-05', 'Build an emergency savings fund', 'Completed'),
(9, 32, 'Travel Fund', 60000.00, 22000.00, '2026-09-15', 'Save money for a future trip', 'Completed'),
(10, 29, 'Savings Goal', 100000.00, 42000.00, '2026-09-30', 'Build personal savings', 'In Progress'),
(11, 24, 'Emergency Fund', 50000.00, 18000.00, '2026-09-05', 'Build an emergency savings fund', 'Completed'),
(12, 30, 'Emergency Fund', 50000.00, 18000.00, '2026-09-05', 'Build an emergency savings fund', 'In Progress'),
(13, 35, 'Savings Goal', 100000.00, 42000.00, '2026-09-30', 'Build personal savings', 'Active'),
(14, 25, 'New Laptop', 80000.00, 35000.00, '2026-09-10', 'Save money to buy a new laptop', 'In Progress'),
(15, 27, 'Education Fund', 40000.00, 15000.00, '2026-09-20', 'Save money for education and courses', 'Active'),
(16, 37, 'New Laptop', 80000.00, 35000.00, '2026-09-10', 'Save money to buy a new laptop', 'In Progress'),
(17, 41, 'Savings Goal', 100000.00, 42000.00, '2026-09-30', 'Build personal savings', 'In Progress'),
(18, 3, 'Education Fund', 40000.00, 15000.00, '2026-09-20', 'Save money for education and courses', 'Active'),
(19, 33, 'Education Fund', 40000.00, 15000.00, '2026-09-20', 'Save money for education and courses', 'In Progress'),
(20, 2, 'Travel Fund', 60000.00, 22000.00, '2026-09-15', 'Save money for a future trip', 'In Progress'),
(21, 34, 'New Phone', 50000.00, 28000.00, '2026-09-25', 'Save money to purchase a new phone', 'In Progress'),
(22, 38, 'Travel Fund', 60000.00, 22000.00, '2026-09-15', 'Save money for a future trip', 'In Progress'),
(23, 26, 'Travel Fund & Transport', 60000.00, 22000.00, '2026-09-15', 'Save money for a future trip', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_table`
--

CREATE TABLE `transaction_table` (
  `Transaction_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Category_ID` int(11) DEFAULT NULL,
  `Amount` decimal(12,2) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Transaction_Date` date NOT NULL,
  `Type` varchar(20) NOT NULL,
  `Payment_Method` varchar(50) DEFAULT NULL,
  `Reference_No` varchar(100) DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_table`
--

INSERT INTO `transaction_table` (`Transaction_ID`, `User_ID`, `Category_ID`, `Amount`, `Description`, `Transaction_Date`, `Type`, `Payment_Method`, `Reference_No`, `Created_At`) VALUES
(1, 1, 1, 30000.00, 'Monthly Salary', '2026-08-17', 'Income', 'Bank', NULL, '2026-08-17 12:44:49'),
(2, 1, 2, 500.00, 'Lunch and snacks', '2026-08-17', 'Expense', 'Cash', NULL, '2026-08-17 12:44:49'),
(3, 1, 3, 1500.00, 'Clothes and accessories', '2026-08-17', 'Expense', 'Card', NULL, '2026-08-17 12:44:49'),
(4, 1, 4, 800.00, 'Transport cost', '2026-08-17', 'Expense', 'Cash', NULL, '2026-08-17 12:44:49'),
(5, 1, 5, 1000.00, 'Books and study materials', '2026-08-17', 'Expense', 'Cash', NULL, '2026-08-17 12:44:49'),
(6, 1, 6, 700.00, 'Medicine', '2026-08-17', 'Expense', 'Cash', NULL, '2026-08-17 12:44:49'),
(7, 3, 5, 20000.00, '', '2026-08-17', 'Expense', 'Cash', NULL, '2026-08-17 16:19:52'),
(109, 1, 1, 30000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Cash', 'REF-001-01', '2026-08-01 03:00:00'),
(110, 1, 2, 600.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Cash', 'REF-001-02', '2026-08-05 08:00:00'),
(111, 1, 3, 1700.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Cash', 'REF-001-03', '2026-08-10 11:00:00'),
(112, 1, 4, 600.00, 'Transport Cost', '2026-08-13', 'Expense', 'Cash', 'REF-001-04', '2026-08-13 12:00:00'),
(113, 1, 5, 1000.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Cash', 'REF-001-05', '2026-08-17 06:00:00'),
(114, 1, 6, 500.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Cash', 'REF-001-06', '2026-08-21 14:00:00'),
(115, 31, 1, 30000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Cash', 'REF-031-01', '2026-08-01 03:00:00'),
(116, 31, 2, 600.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Cash', 'REF-031-02', '2026-08-05 08:00:00'),
(117, 31, 3, 1700.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Cash', 'REF-031-03', '2026-08-10 11:00:00'),
(118, 31, 4, 600.00, 'Transport Cost', '2026-08-13', 'Expense', 'Cash', 'REF-031-04', '2026-08-13 12:00:00'),
(119, 31, 5, 1000.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Cash', 'REF-031-05', '2026-08-17 06:00:00'),
(120, 31, 6, 500.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Cash', 'REF-031-06', '2026-08-21 14:00:00'),
(121, 39, 1, 32000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Bank', 'REF-039-01', '2026-08-01 03:00:00'),
(122, 39, 2, 800.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Bank', 'REF-039-02', '2026-08-05 08:00:00'),
(123, 39, 3, 3200.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Bank', 'REF-039-03', '2026-08-10 11:00:00'),
(124, 39, 4, 900.00, 'Transport Cost', '2026-08-13', 'Expense', 'Bank', 'REF-039-04', '2026-08-13 12:00:00'),
(125, 39, 5, 1600.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Bank', 'REF-039-05', '2026-08-17 06:00:00'),
(126, 39, 6, 800.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Bank', 'REF-039-06', '2026-08-21 14:00:00'),
(127, NULL, 1, 28000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Cash', 'REF-028-01', '2026-08-01 03:00:00'),
(128, NULL, 2, 900.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Cash', 'REF-028-02', '2026-08-05 08:00:00'),
(129, NULL, 3, 2700.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Cash', 'REF-028-03', '2026-08-10 11:00:00'),
(130, NULL, 4, 800.00, 'Transport Cost', '2026-08-13', 'Expense', 'Cash', 'REF-028-04', '2026-08-13 12:00:00'),
(131, NULL, 5, 1400.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Cash', 'REF-028-05', '2026-08-17 06:00:00'),
(132, NULL, 6, 700.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Cash', 'REF-028-06', '2026-08-21 14:00:00'),
(133, 40, 1, 40000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Cash', 'REF-040-01', '2026-08-01 03:00:00'),
(134, 40, 2, 900.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Cash', 'REF-040-02', '2026-08-05 08:00:00'),
(135, 40, 3, 1200.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Cash', 'REF-040-03', '2026-08-10 11:00:00'),
(136, 40, 4, 500.00, 'Transport Cost', '2026-08-13', 'Expense', 'Cash', 'REF-040-04', '2026-08-13 12:00:00'),
(137, 40, 5, 800.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Cash', 'REF-040-05', '2026-08-17 06:00:00'),
(138, 40, 6, 400.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Cash', 'REF-040-06', '2026-08-21 14:00:00'),
(139, 42, 1, 35000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Bank', 'REF-042-01', '2026-08-01 03:00:00'),
(140, 42, 2, 500.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Bank', 'REF-042-02', '2026-08-05 08:00:00'),
(141, 42, 3, 2200.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Bank', 'REF-042-03', '2026-08-10 11:00:00'),
(142, 42, 4, 700.00, 'Transport Cost', '2026-08-13', 'Expense', 'Bank', 'REF-042-04', '2026-08-13 12:00:00'),
(143, 42, 5, 1200.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Bank', 'REF-042-05', '2026-08-17 06:00:00'),
(144, 42, 6, 600.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Bank', 'REF-042-06', '2026-08-21 14:00:00'),
(145, 36, 1, 30000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Bank', 'REF-036-01', '2026-08-01 03:00:00'),
(146, 36, 2, 500.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Bank', 'REF-036-02', '2026-08-05 08:00:00'),
(147, 36, 3, 1700.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Bank', 'REF-036-03', '2026-08-10 11:00:00'),
(148, 36, 4, 600.00, 'Transport Cost', '2026-08-13', 'Expense', 'Bank', 'REF-036-04', '2026-08-13 12:00:00'),
(149, 36, 5, 1000.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Bank', 'REF-036-05', '2026-08-17 06:00:00'),
(150, 36, 6, 500.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Bank', 'REF-036-06', '2026-08-21 14:00:00'),
(151, 32, 1, 35000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Card', 'REF-032-01', '2026-08-01 03:00:00'),
(152, 32, 2, 700.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Card', 'REF-032-02', '2026-08-05 08:00:00'),
(153, 32, 3, 2200.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Card', 'REF-032-03', '2026-08-10 11:00:00'),
(154, 32, 4, 700.00, 'Transport Cost', '2026-08-13', 'Expense', 'Card', 'REF-032-04', '2026-08-13 12:00:00'),
(155, 32, 5, 1200.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Card', 'REF-032-05', '2026-08-17 06:00:00'),
(156, 32, 6, 600.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Card', 'REF-032-06', '2026-08-21 14:00:00'),
(157, 29, 1, 32000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Card', 'REF-029-01', '2026-08-01 03:00:00'),
(158, 29, 2, 1000.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Card', 'REF-029-02', '2026-08-05 08:00:00'),
(159, 29, 3, 3200.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Card', 'REF-029-03', '2026-08-10 11:00:00'),
(160, 29, 4, 900.00, 'Transport Cost', '2026-08-13', 'Expense', 'Card', 'REF-029-04', '2026-08-13 12:00:00'),
(161, 29, 5, 1600.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Card', 'REF-029-05', '2026-08-17 06:00:00'),
(162, 29, 6, 800.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Card', 'REF-029-06', '2026-08-21 14:00:00'),
(163, 24, 1, 32000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Bank', 'REF-024-01', '2026-08-01 03:00:00'),
(164, 24, 2, 500.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Bank', 'REF-024-02', '2026-08-05 08:00:00'),
(165, 24, 3, 3200.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Bank', 'REF-024-03', '2026-08-10 11:00:00'),
(166, 24, 4, 900.00, 'Transport Cost', '2026-08-13', 'Expense', 'Bank', 'REF-024-04', '2026-08-13 12:00:00'),
(167, 24, 5, 1600.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Bank', 'REF-024-05', '2026-08-17 06:00:00'),
(168, 24, 6, 800.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Bank', 'REF-024-06', '2026-08-21 14:00:00'),
(169, 30, 1, 40000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Bank', 'REF-030-01', '2026-08-01 03:00:00'),
(170, 30, 2, 500.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Bank', 'REF-030-02', '2026-08-05 08:00:00'),
(171, 30, 3, 1200.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Bank', 'REF-030-03', '2026-08-10 11:00:00'),
(172, 30, 4, 500.00, 'Transport Cost', '2026-08-13', 'Expense', 'Bank', 'REF-030-04', '2026-08-13 12:00:00'),
(173, 30, 5, 800.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Bank', 'REF-030-05', '2026-08-17 06:00:00'),
(174, 30, 6, 400.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Bank', 'REF-030-06', '2026-08-21 14:00:00'),
(175, 35, 1, 40000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Card', 'REF-035-01', '2026-08-01 03:00:00'),
(176, 35, 2, 1000.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Card', 'REF-035-02', '2026-08-05 08:00:00'),
(177, 35, 3, 1200.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Card', 'REF-035-03', '2026-08-10 11:00:00'),
(178, 35, 4, 500.00, 'Transport Cost', '2026-08-13', 'Expense', 'Card', 'REF-035-04', '2026-08-13 12:00:00'),
(179, 35, 5, 800.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Card', 'REF-035-05', '2026-08-17 06:00:00'),
(180, 35, 6, 400.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Card', 'REF-035-06', '2026-08-21 14:00:00'),
(181, 25, 1, 40000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Cash', 'REF-025-01', '2026-08-01 03:00:00'),
(182, 25, 2, 600.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Cash', 'REF-025-02', '2026-08-05 08:00:00'),
(183, 25, 3, 1200.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Cash', 'REF-025-03', '2026-08-10 11:00:00'),
(184, 25, 4, 500.00, 'Transport Cost', '2026-08-13', 'Expense', 'Cash', 'REF-025-04', '2026-08-13 12:00:00'),
(185, 25, 5, 800.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Cash', 'REF-025-05', '2026-08-17 06:00:00'),
(186, 25, 6, 400.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Cash', 'REF-025-06', '2026-08-21 14:00:00'),
(187, 27, 1, 35000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Bank', 'REF-027-01', '2026-08-01 03:00:00'),
(188, 27, 2, 800.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Bank', 'REF-027-02', '2026-08-05 08:00:00'),
(189, 27, 3, 2200.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Bank', 'REF-027-03', '2026-08-10 11:00:00'),
(190, 27, 4, 700.00, 'Transport Cost', '2026-08-13', 'Expense', 'Bank', 'REF-027-04', '2026-08-13 12:00:00'),
(191, 27, 5, 1200.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Bank', 'REF-027-05', '2026-08-17 06:00:00'),
(192, 27, 6, 600.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Bank', 'REF-027-06', '2026-08-21 14:00:00'),
(193, 37, 1, 35000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Cash', 'REF-037-01', '2026-08-01 03:00:00'),
(194, 37, 2, 600.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Cash', 'REF-037-02', '2026-08-05 08:00:00'),
(195, 37, 3, 2200.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Cash', 'REF-037-03', '2026-08-10 11:00:00'),
(196, 37, 4, 700.00, 'Transport Cost', '2026-08-13', 'Expense', 'Cash', 'REF-037-04', '2026-08-13 12:00:00'),
(197, 37, 5, 1200.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Cash', 'REF-037-05', '2026-08-17 06:00:00'),
(198, 37, 6, 600.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Cash', 'REF-037-06', '2026-08-21 14:00:00'),
(199, 41, 1, 30000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Card', 'REF-041-01', '2026-08-01 03:00:00'),
(200, 41, 2, 1000.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Card', 'REF-041-02', '2026-08-05 08:00:00'),
(201, 41, 3, 1700.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Card', 'REF-041-03', '2026-08-10 11:00:00'),
(202, 41, 4, 600.00, 'Transport Cost', '2026-08-13', 'Expense', 'Card', 'REF-041-04', '2026-08-13 12:00:00'),
(203, 41, 5, 1000.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Card', 'REF-041-05', '2026-08-17 06:00:00'),
(204, 41, 6, 500.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Card', 'REF-041-06', '2026-08-21 14:00:00'),
(205, 3, 1, 28000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Bank', 'REF-003-01', '2026-08-01 03:00:00'),
(206, 3, 2, 800.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Bank', 'REF-003-02', '2026-08-05 08:00:00'),
(207, 3, 3, 2700.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Bank', 'REF-003-03', '2026-08-10 11:00:00'),
(208, 3, 4, 800.00, 'Transport Cost', '2026-08-13', 'Expense', 'Bank', 'REF-003-04', '2026-08-13 12:00:00'),
(209, 3, 5, 1400.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Bank', 'REF-003-05', '2026-08-17 06:00:00'),
(210, 3, 6, 700.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Bank', 'REF-003-06', '2026-08-21 14:00:00'),
(211, 33, 1, 28000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Bank', 'REF-033-01', '2026-08-01 03:00:00'),
(212, 33, 2, 800.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Bank', 'REF-033-02', '2026-08-05 08:00:00'),
(213, 33, 3, 2700.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Bank', 'REF-033-03', '2026-08-10 11:00:00'),
(214, 33, 4, 800.00, 'Transport Cost', '2026-08-13', 'Expense', 'Bank', 'REF-033-04', '2026-08-13 12:00:00'),
(215, 33, 5, 1400.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Bank', 'REF-033-05', '2026-08-17 06:00:00'),
(216, 33, 6, 700.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Bank', 'REF-033-06', '2026-08-21 14:00:00'),
(217, 2, 1, 35000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Card', 'REF-002-01', '2026-08-01 03:00:00'),
(218, 2, 2, 700.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Card', 'REF-002-02', '2026-08-05 08:00:00'),
(219, 2, 3, 2200.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Card', 'REF-002-03', '2026-08-10 11:00:00'),
(220, 2, 4, 700.00, 'Transport Cost', '2026-08-13', 'Expense', 'Card', 'REF-002-04', '2026-08-13 12:00:00'),
(221, 2, 5, 1200.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Card', 'REF-002-05', '2026-08-17 06:00:00'),
(222, 2, 6, 600.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Card', 'REF-002-06', '2026-08-21 14:00:00'),
(223, 34, 1, 32000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Cash', 'REF-034-01', '2026-08-01 03:00:00'),
(224, 34, 2, 900.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Cash', 'REF-034-02', '2026-08-05 08:00:00'),
(225, 34, 3, 3200.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Cash', 'REF-034-03', '2026-08-10 11:00:00'),
(226, 34, 4, 900.00, 'Transport Cost', '2026-08-13', 'Expense', 'Cash', 'REF-034-04', '2026-08-13 12:00:00'),
(227, 34, 5, 1600.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Cash', 'REF-034-05', '2026-08-17 06:00:00'),
(228, 34, 6, 800.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Cash', 'REF-034-06', '2026-08-21 14:00:00'),
(229, 38, 1, 28000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Card', 'REF-038-01', '2026-08-01 03:00:00'),
(230, 38, 2, 700.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Card', 'REF-038-02', '2026-08-05 08:00:00'),
(231, 38, 3, 2700.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Card', 'REF-038-03', '2026-08-10 11:00:00'),
(232, 38, 4, 800.00, 'Transport Cost', '2026-08-13', 'Expense', 'Card', 'REF-038-04', '2026-08-13 12:00:00'),
(233, 38, 5, 1400.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Card', 'REF-038-05', '2026-08-17 06:00:00'),
(234, 38, 6, 700.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Card', 'REF-038-06', '2026-08-21 14:00:00'),
(235, 26, 1, 30000.00, 'Monthly Salary', '2026-08-01', 'Income', 'Card', 'REF-026-01', '2026-08-01 03:00:00'),
(236, 26, 2, 700.00, 'Food and Lunch Expense', '2026-08-05', 'Expense', 'Card', 'REF-026-02', '2026-08-05 08:00:00'),
(237, 26, 3, 1700.00, 'Shopping Expense', '2026-08-10', 'Expense', 'Card', 'REF-026-03', '2026-08-10 11:00:00'),
(238, 26, 4, 600.00, 'Transport Cost', '2026-08-13', 'Expense', 'Card', 'REF-026-04', '2026-08-13 12:00:00'),
(239, 26, 5, 1000.00, 'Education and Study Materials', '2026-08-17', 'Expense', 'Card', 'REF-026-05', '2026-08-17 06:00:00'),
(240, 26, 6, 500.00, 'Medical and Medicine Expense', '2026-08-21', 'Expense', 'Card', 'REF-026-06', '2026-08-21 14:00:00'),
(364, 1, 7, 1000.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Cash', 'REF-001-07', '2026-08-21 09:00:00'),
(365, 1, 8, 1800.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Cash', 'REF-001-08', '2026-08-21 09:00:00'),
(366, 1, 9, 750.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Cash', 'REF-001-09', '2026-08-21 09:00:00'),
(367, 1, 10, 500.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Cash', 'REF-001-10', '2026-08-21 09:00:00'),
(368, 31, 7, 1000.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Cash', 'REF-031-07', '2026-08-21 09:00:00'),
(369, 31, 8, 1800.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Cash', 'REF-031-08', '2026-08-21 09:00:00'),
(370, 31, 9, 750.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Cash', 'REF-031-09', '2026-08-21 09:00:00'),
(371, 31, 10, 500.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Cash', 'REF-031-10', '2026-08-21 09:00:00'),
(372, 39, 7, 1600.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Bank', 'REF-039-07', '2026-08-21 09:00:00'),
(373, 39, 8, 2700.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Bank', 'REF-039-08', '2026-08-21 09:00:00'),
(374, 39, 9, 1200.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Bank', 'REF-039-09', '2026-08-21 09:00:00'),
(375, 39, 10, 800.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Bank', 'REF-039-10', '2026-08-21 09:00:00'),
(376, NULL, 7, 1400.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Cash', 'REF-028-07', '2026-08-21 09:00:00'),
(377, NULL, 8, 2400.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Cash', 'REF-028-08', '2026-08-21 09:00:00'),
(378, NULL, 9, 1050.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Cash', 'REF-028-09', '2026-08-21 09:00:00'),
(379, NULL, 10, 700.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Cash', 'REF-028-10', '2026-08-21 09:00:00'),
(380, 40, 7, 800.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Cash', 'REF-040-07', '2026-08-21 09:00:00'),
(381, 40, 8, 1500.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Cash', 'REF-040-08', '2026-08-21 09:00:00'),
(382, 40, 9, 600.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Cash', 'REF-040-09', '2026-08-21 09:00:00'),
(383, 40, 10, 400.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Cash', 'REF-040-10', '2026-08-21 09:00:00'),
(384, 42, 7, 1200.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Bank', 'REF-042-07', '2026-08-21 09:00:00'),
(385, 42, 8, 2100.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Bank', 'REF-042-08', '2026-08-21 09:00:00'),
(386, 42, 9, 900.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Bank', 'REF-042-09', '2026-08-21 09:00:00'),
(387, 42, 10, 600.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Bank', 'REF-042-10', '2026-08-21 09:00:00'),
(388, 36, 7, 1000.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Bank', 'REF-036-07', '2026-08-21 09:00:00'),
(389, 36, 8, 1800.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Bank', 'REF-036-08', '2026-08-21 09:00:00'),
(390, 36, 9, 750.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Bank', 'REF-036-09', '2026-08-21 09:00:00'),
(391, 36, 10, 500.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Bank', 'REF-036-10', '2026-08-21 09:00:00'),
(392, 32, 7, 1200.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Card', 'REF-032-07', '2026-08-21 09:00:00'),
(393, 32, 8, 2100.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Card', 'REF-032-08', '2026-08-21 09:00:00'),
(394, 32, 9, 900.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Card', 'REF-032-09', '2026-08-21 09:00:00'),
(395, 32, 10, 600.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Card', 'REF-032-10', '2026-08-21 09:00:00'),
(396, 29, 7, 1600.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Card', 'REF-029-07', '2026-08-21 09:00:00'),
(397, 29, 8, 2700.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Card', 'REF-029-08', '2026-08-21 09:00:00'),
(398, 29, 9, 1200.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Card', 'REF-029-09', '2026-08-21 09:00:00'),
(399, 29, 10, 800.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Card', 'REF-029-10', '2026-08-21 09:00:00'),
(400, 24, 7, 1600.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Bank', 'REF-024-07', '2026-08-21 09:00:00'),
(401, 24, 8, 2700.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Bank', 'REF-024-08', '2026-08-21 09:00:00'),
(402, 24, 9, 1200.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Bank', 'REF-024-09', '2026-08-21 09:00:00'),
(403, 24, 10, 800.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Bank', 'REF-024-10', '2026-08-21 09:00:00'),
(404, 30, 7, 800.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Bank', 'REF-030-07', '2026-08-21 09:00:00'),
(405, 30, 8, 1500.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Bank', 'REF-030-08', '2026-08-21 09:00:00'),
(406, 30, 9, 600.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Bank', 'REF-030-09', '2026-08-21 09:00:00'),
(407, 30, 10, 400.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Bank', 'REF-030-10', '2026-08-21 09:00:00'),
(408, 35, 7, 800.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Card', 'REF-035-07', '2026-08-21 09:00:00'),
(409, 35, 8, 1500.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Card', 'REF-035-08', '2026-08-21 09:00:00'),
(410, 35, 9, 600.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Card', 'REF-035-09', '2026-08-21 09:00:00'),
(411, 35, 10, 400.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Card', 'REF-035-10', '2026-08-21 09:00:00'),
(412, 25, 7, 800.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Cash', 'REF-025-07', '2026-08-21 09:00:00'),
(413, 25, 8, 1500.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Cash', 'REF-025-08', '2026-08-21 09:00:00'),
(414, 25, 9, 600.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Cash', 'REF-025-09', '2026-08-21 09:00:00'),
(415, 25, 10, 400.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Cash', 'REF-025-10', '2026-08-21 09:00:00'),
(416, 27, 7, 1200.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Bank', 'REF-027-07', '2026-08-21 09:00:00'),
(417, 27, 8, 2100.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Bank', 'REF-027-08', '2026-08-21 09:00:00'),
(418, 27, 9, 900.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Bank', 'REF-027-09', '2026-08-21 09:00:00'),
(419, 27, 10, 600.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Bank', 'REF-027-10', '2026-08-21 09:00:00'),
(420, 37, 7, 1200.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Cash', 'REF-037-07', '2026-08-21 09:00:00'),
(421, 37, 8, 2100.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Cash', 'REF-037-08', '2026-08-21 09:00:00'),
(422, 37, 9, 900.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Cash', 'REF-037-09', '2026-08-21 09:00:00'),
(423, 37, 10, 600.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Cash', 'REF-037-10', '2026-08-21 09:00:00'),
(424, 41, 7, 1000.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Card', 'REF-041-07', '2026-08-21 09:00:00'),
(425, 41, 8, 1800.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Card', 'REF-041-08', '2026-08-21 09:00:00'),
(426, 41, 9, 750.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Card', 'REF-041-09', '2026-08-21 09:00:00'),
(427, 41, 10, 500.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Card', 'REF-041-10', '2026-08-21 09:00:00'),
(428, 3, 7, 1400.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Bank', 'REF-003-07', '2026-08-21 09:00:00'),
(429, 3, 8, 2400.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Bank', 'REF-003-08', '2026-08-21 09:00:00'),
(430, 3, 9, 1050.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Bank', 'REF-003-09', '2026-08-21 09:00:00'),
(431, 3, 10, 700.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Bank', 'REF-003-10', '2026-08-21 09:00:00'),
(432, 33, 7, 1400.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Bank', 'REF-033-07', '2026-08-21 09:00:00'),
(433, 33, 8, 2400.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Bank', 'REF-033-08', '2026-08-21 09:00:00'),
(434, 33, 9, 1050.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Bank', 'REF-033-09', '2026-08-21 09:00:00'),
(435, 33, 10, 700.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Bank', 'REF-033-10', '2026-08-21 09:00:00'),
(436, 2, 7, 1200.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Card', 'REF-002-07', '2026-08-21 09:00:00'),
(437, 2, 8, 2100.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Card', 'REF-002-08', '2026-08-21 09:00:00'),
(438, 2, 9, 900.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Card', 'REF-002-09', '2026-08-21 09:00:00'),
(439, 2, 10, 600.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Card', 'REF-002-10', '2026-08-21 09:00:00'),
(440, 34, 7, 1600.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Cash', 'REF-034-07', '2026-08-21 09:00:00'),
(441, 34, 8, 2700.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Cash', 'REF-034-08', '2026-08-21 09:00:00'),
(442, 34, 9, 1200.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Cash', 'REF-034-09', '2026-08-21 09:00:00'),
(443, 34, 10, 800.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Cash', 'REF-034-10', '2026-08-21 09:00:00'),
(444, 38, 7, 1400.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Card', 'REF-038-07', '2026-08-21 09:00:00'),
(445, 38, 8, 2400.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Card', 'REF-038-08', '2026-08-21 09:00:00'),
(446, 38, 9, 1050.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Card', 'REF-038-09', '2026-08-21 09:00:00'),
(447, 38, 10, 700.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Card', 'REF-038-10', '2026-08-21 09:00:00'),
(448, 26, 7, 1000.00, 'Movie and entertainment expense', '2026-08-06', 'Expense', 'Card', 'REF-026-07', '2026-08-21 09:00:00'),
(449, 26, 8, 1800.00, 'Electricity, internet and utility bills', '2026-08-09', 'Expense', 'Card', 'REF-026-08', '2026-08-21 09:00:00'),
(450, 26, 9, 750.00, 'Other personal expenses', '2026-08-14', 'Expense', 'Card', 'REF-026-09', '2026-08-21 09:00:00'),
(451, 26, 10, 500.00, 'Medicine and pharmacy expense', '2026-08-21', 'Expense', 'Card', 'REF-026-10', '2026-08-21 09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `First_Name` varchar(50) DEFAULT NULL,
  `Last_Name` varchar(50) DEFAULT NULL,
  `Email` varchar(120) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Gender` varchar(20) DEFAULT NULL,
  `Date_of_Birth` date DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Profile_Picture` varchar(255) DEFAULT NULL,
  `Registration_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Last_Login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Name`, `First_Name`, `Last_Name`, `Email`, `Password`, `Phone`, `Gender`, `Date_of_Birth`, `Address`, `Profile_Picture`, `Registration_Date`, `Last_Login`) VALUES
(1, 'Adiba Rahman', 'Adiba', 'Rahman', 'adiba@gmail.com', '123456', '01700000000', 'Female', NULL, NULL, NULL, '2026-08-17 12:44:49', NULL),
(2, 'Ashikuzzaman Tajim', 'Ashikuzzaman', 'Tajim', 'tajim21@gmail.com', '123456', '01219054532', 'Male', '2005-07-21', '', NULL, '2026-08-17 13:42:26', NULL),
(3, 'Effat Ara', 'Effat', 'Ara', 'sowrna3@gmail.com', '$2y$10$R4bk756NC0d6BNr84khneOtAMWsPqlBWYZdyTAL67cApH/21WU0Ti', '012478737', 'Female', '2004-09-09', '', NULL, '2026-08-17 16:19:14', NULL),
(24, 'Nusrat Jahan', 'Nusrat', 'Jahan', 'nusrat01@gmail.com', '123456', '01720000001', 'Female', '2002-08-20', 'Uttara, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(25, 'Sadia Islam', 'Sadia', 'Islam', 'sadia01@gmail.com', '123456', '01720000002', 'Female', '2003-01-15', 'Mirpur, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(26, 'Tanvir Ahmed', 'Tanvir', 'Ahmed', 'tanvir01@gmail.com', '123456', '01720000003', 'Male', '2001-11-10', 'Dhanmondi, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(27, 'Sakib Hasan', 'Sakib', 'Hasan', 'sakib01@gmail.com', '123456', '01720000004', 'Male', '2002-03-25', 'Mohammadpur, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(29, 'Mim Akter', 'Mim', 'Akter', 'mim01@gmail.com', '123456', '01720000006', 'Female', '2003-09-05', 'Bashundhara, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(30, 'Raisa Ahmed', 'Raisa', 'Ahmed', 'raisa01@gmail.com', '123456', '01720000007', 'Female', '2002-12-22', 'Gulshan, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(31, 'Arif Hossain', 'Arif', 'Hossain', 'arif01@gmail.com', '123456', '01720000008', 'Male', '2001-06-14', 'Jatrabari, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(32, 'Mehedi Hasan', 'Mehedi', 'Hasan', 'mehedi01@gmail.com', '123456', '01720000009', 'Male', '2003-02-28', 'Khilgaon, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(33, 'Sumaiya Islam', 'Sumaiya', 'Islam', 'sumaiya01@gmail.com', '123456', '01720000010', 'Female', '2002-04-17', 'Uttara, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(34, 'Tamanna Sultana', 'Tamanna', 'Sultana', 'tamanna01@gmail.com', '123456', '01720000011', 'Female', '2001-10-30', 'Rampura, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(35, 'Rakibul Hasan', 'Rakibul', 'Hasan', 'rakibul01@gmail.com', '123456', '01720000012', 'Male', '2000-05-09', 'Tejgaon, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(36, 'Jannatul Ferdous', 'Jannatul', 'Ferdous', 'jannatul01@gmail.com', '123456', '01720000013', 'Female', '2003-07-21', 'Wari, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(37, 'Shuvo Ahmed', 'Shuvo', 'Ahmed', 'shuvo01@gmail.com', '123456', '01720000014', 'Male', '2002-09-13', 'Motijheel, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(38, 'Tanjim Chowdhury', 'Tanjim', 'Chowdhury', 'tanjim01@gmail.com', '123456', '01720000015', 'Male', '2001-01-27', 'Farmgate, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(39, 'Ayesha Rahman', 'Ayesha', 'Rahman', 'ayesha01@gmail.com', '123456', '01720000016', 'Female', '2003-11-03', 'Kallyanpur, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(40, 'Farhan Kabir', 'Farhan', 'Kabir', 'farhan01@gmail.com', '123456', '01720000017', 'Male', '2000-12-19', 'Badda, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(41, 'Sohana Akter', 'Sohana', 'Akter', 'sohana01@gmail.com', '123456', '01720000018', 'Female', '2002-06-08', 'Pallabi, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56'),
(42, 'Imran Hossain', 'Imran', 'Hossain', 'imran01@gmail.com', '123456', '01720000019', 'Male', '2001-08-16', 'Lalbagh, Dhaka', NULL, '2026-08-23 03:48:56', '2026-08-23 09:48:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`Budget_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`);

--
-- Indexes for table `goal`
--
ALTER TABLE `goal`
  ADD PRIMARY KEY (`Goal_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `transaction_table`
--
ALTER TABLE `transaction_table`
  ADD PRIMARY KEY (`Transaction_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Category_ID` (`Category_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `Budget_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `goal`
--
ALTER TABLE `goal`
  MODIFY `Goal_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `transaction_table`
--
ALTER TABLE `transaction_table`
  MODIFY `Transaction_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=452;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget`
--
ALTER TABLE `budget`
  ADD CONSTRAINT `budget_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE SET NULL;

--
-- Constraints for table `goal`
--
ALTER TABLE `goal`
  ADD CONSTRAINT `goal_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE SET NULL;

--
-- Constraints for table `transaction_table`
--
ALTER TABLE `transaction_table`
  ADD CONSTRAINT `transaction_table_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaction_table_ibfk_2` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
