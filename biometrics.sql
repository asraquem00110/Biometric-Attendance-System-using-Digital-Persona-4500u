-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2018 at 09:38 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `biometrics`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_arealist`
--

CREATE TABLE IF NOT EXISTS `tbl_arealist` (
`ID` int(6) unsigned zerofill NOT NULL,
  `AreaName` varchar(50) NOT NULL,
  `AreaType` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_arealist`
--

INSERT INTO `tbl_arealist` (`ID`, `AreaName`, `AreaType`) VALUES
(000001, 'test', 'test'),
(000002, 'test1', 'test1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bio`
--

CREATE TABLE IF NOT EXISTS `tbl_bio` (
`IDno` int(11) NOT NULL,
  `AccessID` text NOT NULL,
  `fpData` longblob NOT NULL,
  `fpType` int(1) NOT NULL DEFAULT '0',
  `refno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_in_out`
--

CREATE TABLE IF NOT EXISTS `tbl_in_out` (
`IDno` int(11) NOT NULL,
  `AccessID` varchar(100) NOT NULL,
  `TimeRecord` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `TimeFlag` varchar(10) NOT NULL,
  `Remarks` text NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `AccessArea` varchar(100) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `ContactPerson` varchar(100) NOT NULL,
  `Company` varchar(100) NOT NULL,
  `refno` int(11) NOT NULL,
  `Approved_Status` varchar(100) NOT NULL,
  `Logs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_personnel`
--

CREATE TABLE IF NOT EXISTS `tbl_personnel` (
  `EmployeeID` varchar(50) NOT NULL,
  `AccessID` varchar(10) NOT NULL,
`EntryID` int(11) NOT NULL,
  `FullName` varchar(50) NOT NULL,
  `DateHired` varchar(50) NOT NULL,
  `Position` varchar(50) NOT NULL,
  `AgencyCompany` varchar(50) NOT NULL,
  `ProjectAssigned` varchar(50) NOT NULL,
  `ContactNo` varchar(50) NOT NULL,
  `AccessArea` varchar(50) NOT NULL,
  `Image` varchar(100) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `Remarks` varchar(50) NOT NULL,
  `TimeIN` time NOT NULL,
  `TimeOut` time NOT NULL,
  `schedule_dates` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_personnel`
--

INSERT INTO `tbl_personnel` (`EmployeeID`, `AccessID`, `EntryID`, `FullName`, `DateHired`, `Position`, `AgencyCompany`, `ProjectAssigned`, `ContactNo`, `AccessArea`, `Image`, `Status`, `Remarks`, `TimeIN`, `TimeOut`, `schedule_dates`) VALUES
('12345', 'B001\r\n    ', 1, 'Alvin Raquem', '2017-08-14', 'Web Dev', 'ESI', 'ESI', '', 'test,test1', '1_imageUser.png', '', '', '08:00:00', '17:00:00', 'Monday,Tuesday,Wednesday,Thursday,Friday');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
`IDno` int(3) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) NOT NULL,
  `pass_word` varchar(50) NOT NULL,
  `email_add` varchar(50) NOT NULL,
  `userlevel` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=726 ;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`IDno`, `user_name`, `full_name`, `LastName`, `FirstName`, `MiddleName`, `pass_word`, `email_add`, `userlevel`) VALUES
(720, 'admin', 'Juan Dela Cruz', '', '', '', 'admin', 'juandelacruz@gmail.com', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_arealist`
--
ALTER TABLE `tbl_arealist`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_bio`
--
ALTER TABLE `tbl_bio`
 ADD PRIMARY KEY (`IDno`);

--
-- Indexes for table `tbl_in_out`
--
ALTER TABLE `tbl_in_out`
 ADD PRIMARY KEY (`IDno`);

--
-- Indexes for table `tbl_personnel`
--
ALTER TABLE `tbl_personnel`
 ADD KEY `EntryID` (`EntryID`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
 ADD PRIMARY KEY (`IDno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_arealist`
--
ALTER TABLE `tbl_arealist`
MODIFY `ID` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_bio`
--
ALTER TABLE `tbl_bio`
MODIFY `IDno` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_in_out`
--
ALTER TABLE `tbl_in_out`
MODIFY `IDno` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_personnel`
--
ALTER TABLE `tbl_personnel`
MODIFY `EntryID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
MODIFY `IDno` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=726;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
