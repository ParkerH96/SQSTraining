-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 03, 2018 at 07:11 AM
-- Server version: 10.1.31-MariaDB-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wildnqhi_cs499`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned_features`
--

CREATE TABLE IF NOT EXISTS `assigned_features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feature_number` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `assigned_features`
--

INSERT INTO `assigned_features` (`id`, `feature_number`, `user_id`, `time_added`) VALUES
(1, 1, 8, '2017-03-13 02:30:12'),
(2, 100, 12, '2018-03-25 16:57:35'),
(4, 106, 8, '2018-03-25 22:46:28'),
(8, 107, 6, '2018-04-16 15:12:00'),
(9, 107, 92, '2018-04-23 16:10:22');

--
-- Triggers `assigned_features`
--
DROP TRIGGER IF EXISTS `UserAssignedChangeTrigger`;
DELIMITER //
CREATE TRIGGER `UserAssignedChangeTrigger` AFTER INSERT ON `assigned_features`
 FOR EACH ROW BEGIN
DELETE FROM auditTable WHERE user_id=NEW.user_id;
INSERT INTO auditTable (user_id) VALUES (NEW.user_id);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `UserAssignedDeleteTrigger`;
DELIMITER //
CREATE TRIGGER `UserAssignedDeleteTrigger` BEFORE DELETE ON `assigned_features`
 FOR EACH ROW BEGIN
DELETE FROM auditTable WHERE user_id=OLD.user_id;
INSERT INTO auditTable (user_id) VALUES (OLD.user_id);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `assigned_group_features`
--

CREATE TABLE IF NOT EXISTS `assigned_group_features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feature_number` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `feature_number` (`feature_number`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `assigned_group_features`
--

INSERT INTO `assigned_group_features` (`id`, `feature_number`, `group_id`, `time_added`) VALUES
(9, 2, 2, '2018-03-01 20:49:28'),
(11, 103, 1, '2018-04-24 01:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `auditTable`
--

CREATE TABLE IF NOT EXISTS `auditTable` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `changed_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `auditTable`
--

INSERT INTO `auditTable` (`UID`, `user_id`, `changed_on`) VALUES
(5, 6, '2018-04-16 15:12:00'),
(6, 92, '2018-04-23 16:10:22');

-- --------------------------------------------------------

--
-- Table structure for table `features_available`
--

CREATE TABLE IF NOT EXISTS `features_available` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `file` varchar(50) NOT NULL,
  `target` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=109 ;

--
-- Dumping data for table `features_available`
--

INSERT INTO `features_available` (`id`, `name`, `description`, `file`, `target`) VALUES
(1, 'Navigation', 'Provides the links in the menu bar used to navigate the site.', 'navigation_0.php', 'navigation'),
(2, 'Credit', 'Writes at the bottom of the page the authors of the website.', 'credit_0.php', 'credit'),
(4, 'Phone Sub', 'Messages shown when a phone subscription error occurs.', 'phonesub_0.php', 'phonesub'),
(5, 'Phone Display', 'Displays a list of the user''s phone numbers', 'phonedisplay_0.php', 'phonedisplay'),
(6, 'Address Display', 'Displays the user''s address', 'addressdisplay_0.php', 'addressdisplay'),
(7, 'Group Display', 'Displays the groups the user belongs to', 'groupdisplay_0.php', 'groupdisplay'),
(8, 'Name Display', 'Displays the user''s name on the profile page', 'namedisplay_0.php', 'namedisplay'),
(100, 'Phone Display (Error 1)', 'Display "No Registered Numbers", regardless of registered numbers', 'phonedisplay_1.php', 'phonedisplay'),
(101, 'Credit (Error 1)', 'Makes credit div background RED', 'credit_1.php', 'credit'),
(102, 'Credit (Error 2)', 'No text is displayed in the credit div', 'credit_2.php', 'credit'),
(103, 'Navigation (Error 1)', 'Allows any user to see admin navigation', 'navigation_1.php', 'navigation'),
(104, 'Navigation (Error 2)', 'Doesn''t display profile link', 'navigation_2.php', 'navigation'),
(105, 'Address Display (Error 1)', 'Displays no Address info, regardless if completed', 'addressdisplay_1.php', 'addressdisplay'),
(106, 'Group Display (Error 1)', 'Displays "None" for user''s group, regardless of assigned groups', 'groupdisplay_1.php', 'groupdisplay'),
(107, 'Name Display (Error 1)', 'Blanks out the user''s name', 'namedisplay_1.php', 'namedisplay'),
(108, 'Index (Home Page)', 'Displays the full Home Page for the site', 'index_0.php', 'index');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `date_established` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `UID` (`UID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`UID`, `name`, `date_established`) VALUES
(1, 'Group A', '2017-03-24 01:40:57'),
(2, 'Group B', '2017-03-24 01:43:25'),
(4, 'Group C', '2018-02-21 18:53:30');

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE IF NOT EXISTS `group_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `leader` tinyint(1) DEFAULT '0',
  `date_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `membership` (`group_id`,`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`id`, `group_id`, `leader`, `date_joined`, `uid`) VALUES
(14, 2, 1, '2018-02-24 06:13:31', 8),
(22, 2, 1, '2018-02-24 06:13:41', 19),
(30, 1, 1, '2018-04-16 15:15:03', 12),
(35, 1, 0, '2018-02-25 20:11:27', 30),
(38, 2, 0, '2018-02-27 13:30:33', 50),
(39, 4, 0, '2018-04-01 02:51:45', 8),
(41, 1, 0, '2018-04-01 02:59:15', 8),
(42, 1, 0, '2018-04-16 15:15:00', 6),
(43, 4, 1, '2018-04-16 15:15:13', 6),
(44, 1, 0, '2018-04-23 02:25:58', 92);

-- --------------------------------------------------------

--
-- Table structure for table `hardware_skills`
--

CREATE TABLE IF NOT EXISTS `hardware_skills` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `skill` char(30) NOT NULL,
  UNIQUE KEY `UID` (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `hardware_skills`
--

INSERT INTO `hardware_skills` (`UID`, `skill`) VALUES
(1, 'Computer Assembly'),
(2, 'Computer Maintenance'),
(15, 'Troubleshooting'),
(4, 'Printer & Cartage Refilling'),
(5, 'Operation Monitoring'),
(6, 'Network Processing'),
(7, 'Disaster Recovery'),
(8, 'Circuit Design Knowledge'),
(9, 'Systems Analysis'),
(10, 'Installing Applications'),
(11, 'Installing Components & Driver'),
(12, 'Backup Management, Reporting &');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `title`) VALUES
(0, 'NULL'),
(1, 'Not logged in'),
(2, 'Restricted'),
(3, 'User'),
(4, 'Super user'),
(5, 'Admin'),
(6, 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `phone_list`
--

CREATE TABLE IF NOT EXISTS `phone_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `carrier` varchar(10) DEFAULT NULL,
  `international_code` varchar(4) DEFAULT NULL,
  `primary_phone` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_phone_number` (`phone_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `phone_list`
--

INSERT INTO `phone_list` (`id`, `phone_number`, `user_id`, `date_added`, `carrier`, `international_code`, `primary_phone`) VALUES
(13, '4567891234', 10, '2017-04-09 18:20:23', NULL, NULL, 1),
(14, '9012345672', -1, '2017-04-09 18:59:15', NULL, NULL, 1),
(15, '3141592653', 27, '2017-04-09 19:02:59', NULL, NULL, 1),
(16, '4857693021', 28, '2017-04-09 19:06:13', NULL, NULL, 1),
(17, '9786542310', 29, '2017-04-09 19:07:18', NULL, NULL, 1),
(18, '7143562934', 30, '2017-04-09 19:08:42', NULL, NULL, 1),
(19, '3152456920', 31, '2017-04-09 19:10:02', NULL, NULL, 1),
(21, '9999999999', 34, '2018-02-08 23:05:03', NULL, NULL, 1),
(34, '8594320046', 50, '2018-02-27 13:27:33', NULL, NULL, 0),
(38, '8593589125', 8, '2018-02-28 02:09:53', NULL, NULL, 0),
(39, '8592487759', 8, '2018-02-28 02:10:06', NULL, NULL, 0),
(41, '2596563214', 8, '2018-03-02 01:25:42', NULL, NULL, 0),
(42, '8593213211', 6, '2018-04-16 15:15:36', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `session_users`
--

CREATE TABLE IF NOT EXISTS `session_users` (
  `session_id` varchar(128) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session_users`
--

INSERT INTO `session_users` (`session_id`, `user_id`) VALUES
('ekmgqa12rakiuo5na64mbfe697', '6'),
('3h2n43lqjm3q2ia8bvr5r8thg0', '8'),
('0thfi4lpli83r6idosfik1mki4', '50');

-- --------------------------------------------------------

--
-- Table structure for table `software_skills`
--

CREATE TABLE IF NOT EXISTS `software_skills` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `skill` varchar(30) NOT NULL,
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `software_skills`
--

INSERT INTO `software_skills` (`UID`, `skill`) VALUES
(1, 'C++'),
(42, 'C'),
(3, 'Python'),
(46, 'PHP'),
(5, 'Ruby'),
(6, 'Java'),
(43, 'C#'),
(9, 'Perl'),
(10, 'Graphics'),
(11, 'Javascript'),
(12, 'SQL'),
(13, '.NET'),
(14, 'Visual Basic'),
(15, 'Prolog'),
(16, 'Animation'),
(17, 'R'),
(18, 'Swift'),
(47, 'Assembly'),
(20, 'Pascal'),
(21, 'Go'),
(22, 'Web Design'),
(23, 'HTML'),
(24, 'CSS'),
(25, 'Objective-C'),
(26, 'Shell'),
(27, 'MATLAB'),
(28, 'SAS'),
(29, 'Scratch'),
(30, 'Cloud Computing'),
(31, 'Microsoft Office'),
(32, 'Enterprise Systems'),
(33, 'Android'),
(34, 'IOS/MAC OS X'),
(35, 'Windows'),
(36, 'Linux'),
(37, 'Client/Server');

-- --------------------------------------------------------

--
-- Table structure for table `subscriber`
--

CREATE TABLE IF NOT EXISTS `subscriber` (
  `phone_number` varchar(20) NOT NULL,
  `carrier` varchar(10) NOT NULL,
  `international_code` varchar(4) NOT NULL,
  PRIMARY KEY (`phone_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriber`
--

INSERT INTO `subscriber` (`phone_number`, `carrier`, `international_code`) VALUES
('12312312', 'AT&T', '1'),
('1231231234', 'VERIZON', '1'),
('1233142345', 'VERIZON', '1'),
('1234567890', 'VERIZON', '1'),
('3456781234', 'VERIZON', '1'),
('4562655625', 'VERIZON', '1'),
('6781234567', 'VERIZON', '1'),
('85912345687', 'VERIZON', '1'),
('8593141592', 'VERIZON', '1'),
('8598661234', 'VERIZON', '1'),
('98765432', 'VERIZON', '1'),
('9876543210', 'VERIZON', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `Email` varchar(254) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '3',
  `gender` varchar(6) DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` int(5) DEFAULT NULL,
  `photo` varchar(256) DEFAULT NULL,
  `progress` int(11) NOT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `UID` (`UID`),
  UNIQUE KEY `Email` (`Email`(54))
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UID`, `first_name`, `last_name`, `Email`, `Password`, `level`, `gender`, `dateofbirth`, `address`, `city`, `state`, `zip`, `photo`, `progress`) VALUES
(6, '', '', 'test@test.com', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 3, 'Female', '1993-11-29', 'Testing', 'test', 'KY', 40509, NULL, 80),
(8, 'John', 'Doe', 'johndoe@example.com', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 3, 'Male', '0199-11-29', '111 Main Street', 'Lexington', 'KY', 40504, 'Parker.jpg', 100),
(12, 'Hanker', 'Hill', 'hank@example.com', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 2, 'Male', '1993-11-29', '', '', '', 0, NULL, 0),
(18, 'Robinson', 'Crueso', 'test4@example.com', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 3, 'Male', '1993-11-29', NULL, NULL, NULL, NULL, NULL, 0),
(19, 'Peter', 'The Great', 'test5@example.com', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 3, 'Male', '1993-11-29', NULL, NULL, NULL, NULL, NULL, 0),
(20, 'Carl', 'the Great', 'test6@example.com', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 3, 'Male', '1993-11-29', NULL, NULL, NULL, NULL, NULL, 0),
(23, 'Alfred', 'the Great', 'test7@example.com', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 3, 'Male', '1993-11-29', NULL, NULL, NULL, NULL, NULL, 0),
(27, 'William', 'Conqueror', 'test8@example.com', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 3, 'Male', '1993-11-29', NULL, NULL, NULL, NULL, NULL, 0),
(28, 'King', 'Kong', 'test10@example.com', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 5, 'Male', '1993-11-29', NULL, NULL, NULL, NULL, NULL, 0),
(29, 'Queen', 'Kong', 'test11@example.com', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 3, 'Female', '1993-11-29', NULL, NULL, NULL, NULL, NULL, 0),
(30, 'Duke', 'Kong', 'test12@example.com', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 3, 'Male', '1993-11-29', NULL, NULL, NULL, NULL, NULL, 0),
(31, 'Prince', 'Buster', 'princebuster@example.com', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 4, 'Male', '1994-11-29', NULL, NULL, NULL, NULL, NULL, 0),
(50, 'Admin', 'Admin', 'admin@admin.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 6, 'Male', '2018-02-14', '110 Vine street', 'Lexington', 'KY', 40509, 'logo.png', 100),
(53, 'test', 'account', 'test@account.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(56, 'jim', 'bob', 'jimbob@gmail.com', '1389db06621a4e3493ef3a3087ea415e1d5512a50f76a8c8a8b9bb82ea38c5db', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(57, 'billy', 'bob', 'bill@gmail.com', '623210167553939c87ed8c5f2bfe0b3e0684e12c3a3dd2513613c4e67263b5a1', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(59, 'Test', 'User', 'zackary.arnett@uky.edu', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(60, 'test', 'fox', 'testfox@gmail.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 3, '', '0000-00-00', NULL, NULL, NULL, NULL, NULL, 40),
(61, 'hunter', 'bowman', 'huneyb.526@gmail.com', 'b96482290a873ee9875236c0b4455988a10a7ec28bba60419d449429d0ced0e0', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(66, 'john', 'berry', 'berry@gmail.com', 'e9a63a4eb15738ae85cd416221c8fcc4ccc0018fac91335b42eaa016c76e87f9', 3, '', '0000-00-00', '', '', '', 0, NULL, 0),
(69, 'Parker', 'Householder', 'paho224@g.uky.edu', 'c3e55a15eefa347a8131253129df7f273d5a95732b3d9c6736bbdc156fadec55', 3, 'Male', '1996-05-01', '750 Shaker Drive Apt. 524', 'Lexington', 'KY', 40504, 'Parker.jpg', 100),
(70, 'Morgan', 'Lewis', 'morganshaylewis2014@gmail.com', '442573aa9a62203dad068b092b932591924f844969da03661ddd26027a0aeaf1', 3, 'NULL', '0000-00-00', '', '', 'GA', 0, NULL, 43),
(71, 'john', 'jimmy', 'jimmyjohns@gmail.com', '8f5c570f55dd7921c9861e941be98a9492991d1a862d05283f6ddad56c891cca', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(73, 'jimmy', 'john', 'jimmyjohn@gmail.com', '48695422fbc25ad01b6371edbb9f7e8006522384ba4282787e385f3fbc8e5302', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 40),
(86, 'Parker', 'Householder', 'parker.a.householder@gmail.com', '91c1295a5a47644b8be7cdc027da09dcc7e9b401f001b49beeba7ba406f1bd35', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 40),
(92, 'Testing', 'Person (Demo)', 'Testing@person.com', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 3, 'Male', '0000-00-00', '', '', 'NU', 0, NULL, 40),
(93, 'test', 'test', 'testfox1@gmail.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_hardware_skills`
--

CREATE TABLE IF NOT EXISTS `user_hardware_skills` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `skill_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=481 ;

--
-- Dumping data for table `user_hardware_skills`
--

INSERT INTO `user_hardware_skills` (`UID`, `skill_id`, `user_id`) VALUES
(344, 8, 50),
(342, 5, 8),
(341, 2, 8),
(343, 1, 50),
(340, 4, 8),
(339, 15, 8),
(480, 1, 6),
(479, 2, 6),
(478, 15, 6),
(477, 4, 6),
(476, 5, 6),
(475, 6, 6),
(474, 7, 6),
(473, 8, 6),
(472, 9, 6),
(471, 10, 6),
(470, 11, 6),
(469, 12, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_software_skills`
--

CREATE TABLE IF NOT EXISTS `user_software_skills` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `skill_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2378 ;

--
-- Dumping data for table `user_software_skills`
--

INSERT INTO `user_software_skills` (`UID`, `skill_id`, `user_id`) VALUES
(1871, 37, 8),
(1870, 36, 8),
(1869, 35, 8),
(1868, 34, 8),
(1867, 33, 8),
(1866, 32, 8),
(1865, 31, 8),
(1864, 30, 8),
(1863, 29, 8),
(1862, 28, 8),
(77, 33, 60),
(78, 16, 60),
(1861, 27, 8),
(1860, 26, 8),
(1859, 25, 8),
(1858, 24, 8),
(1857, 23, 8),
(1856, 22, 8),
(1855, 21, 8),
(1854, 20, 8),
(1852, 18, 8),
(1851, 17, 8),
(1850, 16, 8),
(1849, 15, 8),
(1848, 14, 8),
(1847, 6, 8),
(1846, 42, 8),
(1845, 3, 8),
(1844, 46, 8),
(1843, 43, 8),
(1842, 9, 8),
(1841, 10, 8),
(1840, 11, 8),
(1839, 12, 8),
(1838, 5, 8),
(1837, 1, 8),
(1836, 13, 8),
(1877, 24, 50),
(1876, 42, 50),
(2377, 3, 6),
(1874, 1, 50),
(1873, 33, 50),
(1872, 13, 50),
(2376, 1, 6),
(2375, 37, 6),
(2374, 36, 6),
(2373, 35, 6),
(2372, 34, 6),
(2371, 33, 6),
(2370, 32, 6),
(2369, 31, 6),
(2368, 30, 6),
(2367, 29, 6),
(2366, 28, 6),
(2365, 27, 6),
(2364, 26, 6),
(2363, 25, 6),
(2362, 24, 6),
(2361, 23, 6),
(2360, 22, 6),
(2359, 21, 6),
(2358, 20, 6),
(2357, 47, 6),
(2356, 18, 6),
(2355, 17, 6),
(2354, 16, 6),
(2353, 15, 6),
(2352, 14, 6),
(2351, 13, 6),
(2350, 12, 6),
(2349, 11, 6),
(2348, 10, 6),
(2347, 9, 6),
(2346, 6, 6),
(2345, 5, 6),
(2344, 46, 6);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
