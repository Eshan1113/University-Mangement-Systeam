-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2023 at 04:08 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gg`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calculateGrade` (`marks` INT) RETURNS DECIMAL(4,2)  BEGIN
    DECLARE grade DECIMAL(4, 2);
    
    IF marks >= 80 THEN
        SET grade = 4.00;
    ELSEIF marks >= 70 THEN
        SET grade = 3.70;
    ELSEIF marks >= 65 THEN
        SET grade = 3.30;
    ELSEIF marks >= 60 THEN
        SET grade = 3.00;
    ELSEIF marks >= 55 THEN
        SET grade = 2.70;
    ELSEIF marks >= 50 THEN
        SET grade = 2.30;
    ELSEIF marks >= 45 THEN
        SET grade = 2.00;
    ELSEIF marks >= 40 THEN
        SET grade = 1.70;
    ELSEIF marks >= 35 THEN
        SET grade = 1.30;
    ELSEIF marks >= 30 THEN
        SET grade = 1.00;
    ELSE
        SET grade = 0.00;
    END IF;
    
    RETURN grade;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `login_tb`
--

CREATE TABLE `login_tb` (
  `id` int(255) NOT NULL,
  `Login_email` varchar(100) NOT NULL,
  `Login_pswrd` varchar(255) NOT NULL,
  `Login_role` varchar(10) NOT NULL,
  `age` int(255) NOT NULL,
  `nic` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_tb`
--

INSERT INTO `login_tb` (`id`, `Login_email`, `Login_pswrd`, `Login_role`, `age`, `nic`) VALUES
(13, 'admin@gmail.com', '1234', 'admin', 23, '19993181015'),
(25, 'user@gmail.com', '1234', 'user', 23, '19993181015');

-- --------------------------------------------------------

--
-- Table structure for table `student_tb`
--

CREATE TABLE `student_tb` (
  `stid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dgname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_tb`
--

INSERT INTO `student_tb` (`stid`, `name`, `age`, `email`, `dgname`) VALUES
(1234, 'Upeksha Bandara', 25, 'upeksha@gmail.com', 'BSc in INFORMATION TECHNOLOGY'),
(204516, 'Thennakoon Weerakkodi Eshan Dananjaya', 23, 'eshandananjaya99@gmail.com', 'BA General Degree program');

-- --------------------------------------------------------

--
-- Table structure for table `subjectmrks`
--

CREATE TABLE `subjectmrks` (
  `sid` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `marks` decimal(5,2) DEFAULT NULL,
  `credit` int(11) DEFAULT NULL,
  `stid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjectmrks`
--

INSERT INTO `subjectmrks` (`sid`, `subject`, `semester`, `marks`, `credit`, `stid`) VALUES
(4, 'DBMS', 1, '100.00', 3, 1234),
(6, 'Physics', 1, '75.00', 3, 1234),
(7, 'DBMS Lab', 2, '75.00', 3, 204516),
(8, 'DBMS', 2, '75.00', 3, 204516),
(9, 'DBMS Lab', 3, '45.00', 1, 1234),
(10, 'English', 1, '75.00', 4, 1234);

-- --------------------------------------------------------

--
-- Table structure for table `user_tb`
--

CREATE TABLE `user_tb` (
  `id` int(255) NOT NULL,
  `User_name` varchar(100) NOT NULL,
  `User_email` varchar(60) NOT NULL,
  `User_mobile` int(20) NOT NULL,
  `User_NIC` varchar(20) NOT NULL,
  `User_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_tb`
--

INSERT INTO `user_tb` (`id`, `User_name`, `User_email`, `User_mobile`, `User_NIC`, `User_status`) VALUES
(15, 'user', 'user@gmail.com', 778519383, '199931810150', 1),
(16, 'admin', 'admin@gmail.com', 778519383, '199931810150', 1),
(18, 'eshandananjaya98', 'eshandananjaya98@gmail.com', 778519383, '199931810150', 1),
(19, 'eshandananjaya97', 'eshandananjaya97@gmail.com', 778519384, '199931810150', 1),
(20, 'eshandananjaya96', 'eshandananjaya96@gmail.com', 778519384, '199931810150', 1),
(21, 'bscwd223501', 'eshandananjaya99@gmail.com', 778519383, '199931810150', 1),
(22, 'ESHAN Dananjaya', 'esh@gmail.com', 1234567, '12345432', 1),
(23, 'bscwd223501', 'eshan@123', 778519383, '199931810150', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_tb`
--
ALTER TABLE `login_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_tb`
--
ALTER TABLE `student_tb`
  ADD PRIMARY KEY (`stid`);

--
-- Indexes for table `subjectmrks`
--
ALTER TABLE `subjectmrks`
  ADD PRIMARY KEY (`sid`),
  ADD KEY `stid` (`stid`);

--
-- Indexes for table `user_tb`
--
ALTER TABLE `user_tb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_tb`
--
ALTER TABLE `login_tb`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `subjectmrks`
--
ALTER TABLE `subjectmrks`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subjectmrks`
--
ALTER TABLE `subjectmrks`
  ADD CONSTRAINT `subjectmrks_ibfk_1` FOREIGN KEY (`stid`) REFERENCES `student_tb` (`stid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
