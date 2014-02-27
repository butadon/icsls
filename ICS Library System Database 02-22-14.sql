-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 21, 2014 at 04:23 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `icsls`
--
CREATE DATABASE IF NOT EXISTS `icsls` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `icsls`;

-- --------------------------------------------------------

--
-- Table structure for table `reference_materials`
--

CREATE TABLE IF NOT EXISTS `reference_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `author` tinytext NOT NULL,
  `isbn` varchar(13) DEFAULT NULL,
  `category` char(1) NOT NULL,
  `description` text,
  `publisher` varchar(100) DEFAULT NULL,
  `publication_year` int(4) DEFAULT NULL,
  `access_type` char(1) NOT NULL,
  `course_code` varchar(6) NOT NULL,
  `total_available` int(2) NOT NULL,
  `total_stock` int(2) NOT NULL,
  `times_borrowed` int(5) DEFAULT '0',
  `item_image` varchar(20) NOT NULL DEFAULT '0.jpg',
  `for_deletion` char(1) NOT NULL DEFAULT 'F',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `reference_materials`
--

INSERT INTO `reference_materials` (`id`, `title`, `author`, `isbn`, `category`, `description`, `publisher`, `publication_year`, `access_type`, `course_code`, `total_available`, `total_stock`, `times_borrowed`, `item_image`, `for_deletion`) VALUES
(1, 'Computer Applications in Engineering Education', 'Magdy F. Iskander', NULL, 'J', NULL, 'Wiley Periodicals, Inc., A Wiley Company', 2014, 'F', 'CS128', 6, 6, 0, '0.jpg', 'F'),
(2, 'Model-Driven and Software Product Line Engineering', 'Hugo Arboleda', '9781848214279', 'B', NULL, 'ISTE Ltd', 2012, 'F', 'CS128', 5, 5, 0, '0.jpg', 'F'),
(3, 'Computational Intelligence', 'Ali Ghorbani', NULL, 'J', 'This leading international journal promotes and stimulates research in the field of artificial intelligence (AI).', 'Wiley Periodicals, Inc.', 2014, 'S', 'CS170', 5, 5, 0, '0.jpg', 'F'),
(4, 'Emerging Methods, Technologies, and Process Management in Software Engineering', 'Andrea De Lucia', '9780470085714', 'B', NULL, 'John Wiley & Sons, Inc.', 2008, 'S', 'CS128', 7, 7, 0, '0.jpg', 'F'),
(5, 'Process Control Engineering', 'M. Polke', '9783527286898', 'B', 'This book surveys methods, problems, and tools used in process control engineering. Its scope has been purposely made broad in order to permit an overall view of this subject.', 'VCH Verlagsgesellschaft mbH', 1994, 'F', 'CS125', 2, 2, 0, '0.jpg', 'F'),
(6, 'The Handbook of Information and Computer Ethics', 'Kenneth Einar Himma', '9780471799597', 'B', 'This handbook provides an accessible overview of the most important issues in information and computer ethics.', 'John Wiley & Sons, Inc.', 2008, 'F', 'CS11', 3, 3, 0, '0.jpg', 'F'),
(7, 'Random Structures & Algorithms', 'Michal Karonski', NULL, 'J', NULL, 'Wiley Periodicals, Inc., A Wiley Company', 2014, 'S', 'CS123', 9, 9, 0, '0.jpg', 'F'),
(8, 'Network Modeling and Simulation: A Practical Perspective', 'Mohsen Guizani', '9780470035870', 'B', 'Network Modeling and Simulation is a practical guide to using modeling and simulation to solve real-life problems.', 'John Wiley & Sons, Ltd', 2010, 'F', 'CS100', 2, 2, 0, '0.jpg', 'F'),
(9, 'Advanced Computer Architecture and Parallel Processing', 'Hesham El-Rewini', '9780471467403', 'B', 'Computer architecture deals with the physical configuration, logical structure, formats, protocols, and operational sequences for processing data, controlling the configuration, and controlling the operations over a computer.', 'John Wiley & Sons, Inc.', 2005, 'F', 'CS132', 8, 8, 0, '0.jpg', 'F'),
(10, 'Computer Animation and Virtual Worlds', 'Nadia Magnenat Thalmann', NULL, 'J', NULL, 'John Wiley & Sons, Ltd.', NULL, 'S', 'CS161', 6, 6, 0, '0.jpg', 'F'),
(11, '3D Object Processing: Compression, Indexing and Watermarking', 'Jean-Luc Dugelay', '9780470065426', 'B', NULL, 'John Wiley & Sons, Ltd', 2008, 'F', 'CS161', 4, 4, 0, '0.jpg', 'F'),
(12, 'Computer System Design: System-on-Chip', 'Michael J. Flynn', '9780470643365', 'B', NULL, 'John Wiley & Sons, Inc.', 2011, 'F', 'CS132', 3, 3, 0, '0.jpg', 'F'),
(13, 'Compiler Construction Using Java, JavaCC, and Yacc', 'Anthony J. Dos Reis', '9780470949597', 'B', 'Broad in scope, involving theory, the application of that theory, and programming technology, compiler construction is a moving target, with constant advances in compiler technology taking place.', 'the IEEE Computer Society, Inc.', 2012, 'S', 'CS129', 2, 2, 0, '0.jpg', 'F'),
(14, 'Concurrency and Computation: Practice and Experience', 'Geoffrey C. Fox', NULL, 'J', NULL, 'John Wiley & Sons, Ltd.', 2014, 'F', 'CS132', 1, 1, 0, '0.jpg', 'F'),
(15, 'Mobile 3D Graphics SoC: From Algorithm to Chip', 'Jeong-Ho Woo', '9780470823774', 'B', 'The first book to explain the principals behind mobile 3D hardware implementation, helping readers understand advanced algorithms, produce low-cost, low-power SoCs, or become familiar with embedded systems', 'John Wiley & Sons (Asia) Pte Ltd', 2010, 'F', 'CS161', 7, 7, 0, '0.jpg', 'F'),
(16, 'Journal of Computer-Mediated Communication', 'S. Shyam Sundar', NULL, 'J', NULL, 'International Communication Association', 2014, 'S', 'CS170', 6, 6, 0, '0.jpg', 'F'),
(17, 'Journal of Software: Evolution and Process', 'Gerardo Canfora', NULL, 'J', NULL, 'John Wiley & Sons, Ltd.', NULL, 'F', 'CS128', 6, 6, 0, '0.jpg', 'F'),
(18, 'Internet Technologies Handbook: Optimizing the IP Network', 'Mark A. Miller', '9780471480501', 'B', 'A comprehensive reference that addresses the need for solid understanding of the operation of IP networks, plus optimization and management techniques to keep those networks running at peak performance', 'Mark A. Miller. All rights reserved.', 2004, 'F', 'CS100', 7, 7, 0, '0.jpg', 'F'),
(19, 'International Journal of Network Management', 'James Won-Ki Hong', NULL, 'J', NULL, 'John Wiley & Sons, Ltd.', NULL, 'S', 'CS100', 3, 3, 0, '0.jpg', 'F'),
(20, 'Fundamentals of Software Testing', 'Bernard Homès', '9781848213241', 'B', NULL, 'ISTE Ltd', 2012, 'F', 'CS128', 5, 5, 0, '0.jpg', 'F'),
(21, 'Designing a Better Authentication Model', 'Prashasti Gehalot', NULL, 'T', NULL, NULL, 2013, 'S', 'CS132', 1, 1, 0, '0.jpg', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `reference_material_id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `waitlist_rank` int(2) DEFAULT NULL,
  `date_waitlisted` date DEFAULT NULL,
  `date_reserved` date DEFAULT NULL,
  `reservation_due_date` date DEFAULT NULL,
  `date_borrowed` date DEFAULT NULL,
  `borrow_due_date` date DEFAULT NULL,
  `date_returned` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `employee_number` varchar(9) DEFAULT NULL,
  `student_number` varchar(10) DEFAULT NULL,
  `last_name` varchar(32) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `middle_name` varchar(32) DEFAULT NULL,
  `user_type` char(1) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `college_address` varchar(150) NOT NULL,
  `email_address` varchar(60) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `borrow_limit` int(1) DEFAULT NULL,
  `waitlist_limit` int(1) DEFAULT NULL,
  `college` varchar(6) DEFAULT NULL,
  `degree` varchar(12) DEFAULT NULL,
  `profile_picture` varchar(20) NOT NULL DEFAULT '0.jpg',
  `is_activated` char(1) NOT NULL DEFAULT 'T',
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_number` (`employee_number`,`student_number`,`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_number`, `student_number`, `last_name`, `first_name`, `middle_name`, `user_type`, `username`, `password`, `college_address`, `email_address`, `contact_number`, `borrow_limit`, `waitlist_limit`, `college`, `degree`, `profile_picture`, `is_activated`) VALUES
(1, '000000001', NULL, 'Kimhoko', 'Erika', 'Cordova', 'A', 'admin1', '21232f297a57a5a743894a0e4a801fc3', 'Grove Street Los Banos Laguna', 'eckimhoko@gmail.com', '09058465816', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(2, '000000002', NULL, 'Jolloso', 'Leona', 'Jintalan', 'A', 'admin2', '21232f297a57a5a743894a0e4a801fc3', 'Men Residence Hall Dorm', 'maejolloso@gmail.com', '09157231682', NULL, NULL, NULL, NULL, '0.jpg', 'F'),
(3, '000000003', NULL, 'Cruz', 'kenneth', 'Cruz', 'A', 'admin3', '21232f297a57a5a743894a0e4a801fc3', 'Ilags Compound', 'kencruz07@gmail.com', '09064367611', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(4, '000000004', NULL, 'Balucating', 'Harland', 'Balucating', 'A', 'admin4', '21232f297a57a5a743894a0e4a801fc3', 'Groove Street Los Banos Laguna', 'harland@gmail.com', '09076547654', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(5, '000000005', NULL, 'Royo', 'Jeezle', 'Irish', 'A', 'admin5', '21232f297a57a5a743894a0e4a801fc3', 'La Ville', 'jeezleroyo@gmail.com', '09174976990', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(6, '000000011', NULL, 'Lee', 'Joanne', 'Evidor', 'L', 'librarian1', '35fa1bcb6fbfa7aa343aa7f253507176', 'Groove Street Los Banos Laguna', 'jelee@gmail.com', '09065757443', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(7, '000000012', NULL, 'Morada', 'Joar', 'Isaac', 'L', 'librarian2', '35fa1bcb6fbfa7aa343aa7f253507176', 'De Marces Compound', 'morada@gmail.com', '09065432765', NULL, NULL, NULL, NULL, '0.jpg', 'F'),
(8, '000000013', NULL, 'Kimhoko', 'Kim', 'Cordova', 'L', 'librarian3', '35fa1bcb6fbfa7aa343aa7f253507176', 'Mareha Residence Hall', 'kimVincent09@gmail.com', '09065754323', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(9, '000000014', NULL, 'Rugas', 'Beverly', 'Ruperez', 'L', 'librarian4', '35fa1bcb6fbfa7aa343aa7f253507176', 'Vet Med Residence Hall', 'rugas@gmail.com', '09065753223', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(10, '000000015', NULL, 'Padernal', 'Zara', 'Evidor', 'L', 'librarian5', '35fa1bcb6fbfa7aa343aa7f253507176', 'Batong Malake Hall', 'zel@gmail.com', '09065654223', NULL, NULL, NULL, NULL, '0.jpg', 'F'),
(11, '000000016', NULL, 'Ruperez', 'Carlo', 'Cordova', 'L', 'librarian6', '35fa1bcb6fbfa7aa343aa7f253507176', 'ATI Residence Hall', 'ccruperez@gmail.com', '09065654765', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(12, '000000017', NULL, 'Cordova', 'Remedios', 'Barrientos', 'L', 'librarian7', '35fa1bcb6fbfa7aa343aa7f253507176', 'ATI Residence Hall', 'remedios@gmail.com', '09056543211', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(13, '000000018', NULL, 'Vargas', 'Emman', 'Villapando', 'L', 'librarian8', '35fa1bcb6fbfa7aa343aa7f253507176', 'Catalan Compund', 'Vargas07@gmail.com', '09012343212', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(14, '000000019', NULL, 'Arcilla', 'Bernadette', 'Lariza', 'L', 'librarian9', '35fa1bcb6fbfa7aa343aa7f253507176', 'Raymundo Compound', 'arcilla@gmail.com', '09065432123', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(15, '000000021', NULL, 'Alano', 'James', 'Andal', 'L', 'librarian10', '35fa1bcb6fbfa7aa343aa7f253507176', 'White House', 'alano@gmail.com', '09067543654', NULL, NULL, NULL, NULL, '0.jpg', 'F'),
(16, '000000022', NULL, 'Andal', 'Feliz', 'Pamittan', 'L', 'librarian11', '35fa1bcb6fbfa7aa343aa7f253507176', 'Batong Malake Los Banos Laguna', 'flapamittan@gmail.com', '09067564654', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(17, '000000023', NULL, 'Aguila', 'Roinand', 'Baral', 'L', 'librarian12', '35fa1bcb6fbfa7aa343aa7f253507176', 'White House Compound', 'Aguila19@gmail.com', '09067564124', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(18, '000000024', NULL, 'Calayag', 'Maureen', 'Abogado', 'L', 'librarian13', '35fa1bcb6fbfa7aa343aa7f253507176', 'White House Compound', 'calayag@gmail.com', '09067564124', NULL, NULL, NULL, NULL, '0.jpg', 'F'),
(19, '000000025', NULL, 'Bulaong', 'Abby', 'Abogado', 'L', 'librarian14', '35fa1bcb6fbfa7aa343aa7f253507176', 'White House Compound', 'bulaong@gmail.com', '09067564124', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(20, '000000027', NULL, 'Almonte', 'Conrad', 'James', 'L', 'librarian15', '35fa1bcb6fbfa7aa343aa7f253507176', 'White House Compound', 'Almonte@gmail.com', '09067564124', NULL, NULL, NULL, NULL, '0.jpg', 'T'),
(21, '100000000', NULL, 'Samaniego', 'Kim', 'A', 'F', 'kimsamaniego', 'd561c7c03c1f2831904823a95835ff5f', 'Los Banos', 'kim@gmail.com', '09100000001', 3, 3, NULL, NULL, '0.jpg', 'T'),
(22, '100000001', NULL, 'Recario', 'Reginald', 'B', 'F', 'reggie', 'd561c7c03c1f2831904823a95835ff5f', 'Los Banos', 'reggie@gmail.com', '09111111111', 3, 3, NULL, NULL, '0.jpg', 'T'),
(23, '100000002', NULL, 'Danila', 'Lailani', 'C', 'F', 'ld', 'd561c7c03c1f2831904823a95835ff5f', 'Los Banos', 'lanie@gmail.com', '09123412341', 3, 3, NULL, NULL, '0.jpg', 'T'),
(24, '100000003', NULL, 'Manalang', 'Martee', 'A', 'F', 'martee', 'd561c7c03c1f2831904823a95835ff5f', 'Los Banos', 'martee@gmail.com', '09123412342', 3, 3, NULL, NULL, '0.jpg', 'F'),
(25, '100000004', NULL, 'Lo', 'John', 'C', 'F', 'john', 'd561c7c03c1f2831904823a95835ff5f', 'Los Banos', 'john@gmail.com', '09123412340', 3, 3, NULL, NULL, '0.jpg', 'T'),
(26, '100000005', NULL, 'Mariano', 'Vladimir', 'A', 'F', 'vlad', 'd561c7c03c1f2831904823a95835ff5f', 'Los Banos', 'vlad@gmail.com', '09100000012', 3, 3, NULL, NULL, '0.jpg', 'T'),
(27, '100000006', NULL, 'Aguila', 'Joy', 'A', 'F', 'joy', 'd561c7c03c1f2831904823a95835ff5f', 'Los Banos', 'joy@gmail.com', '09100000123', 3, 3, NULL, NULL, '0.jpg', 'T'),
(28, '100000007', NULL, 'Deeobles', 'Yvette', 'B', 'F', 'yvette', 'd561c7c03c1f2831904823a95835ff5f', 'Laguna', 'yvette@gmail.com', '09100000111', 3, 3, NULL, NULL, '0.jpg', 'F'),
(29, '100000008', NULL, 'Peralta', 'Kei', 'B', 'F', 'kei', 'd561c7c03c1f2831904823a95835ff5f', 'Laguna', 'kei@gmail.com', '09100000112', 3, 3, NULL, NULL, '0.jpg', 'T'),
(30, '100000009', NULL, 'Bulalacao', 'Rommel', 'C', 'F', 'rommel', 'd561c7c03c1f2831904823a95835ff5f', 'Laguna', 'rommel@gmail.com', '09926272711', 3, 3, NULL, NULL, '0.jpg', 'F'),
(31, NULL, '2011-12345', 'Ordillano', 'Janet', 'P', 'S', 'janet', 'cd73502828457d15655bbd7a63fb0bc8', 'Los Banos', 'janet@gmail.com', '09262738343', 3, 3, 'CAS', 'BSCS', '0.jpg', 'T'),
(32, NULL, '2011-10001', 'Agbay', 'Camille', 'A', 'S', 'camille', 'cd73502828457d15655bbd7a63fb0bc8', 'Laguna', 'camille@gmail.com', '09100000121', 3, 3, 'CA', 'BSA', '0.jpg', 'F'),
(33, NULL, '2011-00001', 'Linga', 'James', 'T', 'S', 'james', 'cd73502828457d15655bbd7a63fb0bc8', 'Los Banos', 'james@gmail.com', '09102700111', 3, 3, 'CA-CAS', 'BSAC', '0.jpg', 'T'),
(34, NULL, '2011-54111', 'Olano', 'Emmanuel', 'M', 'S', 'emman', 'cd73502828457d15655bbd7a63fb0bc8', 'Los Banos', 'emman@gmail.com', '09108520111', 3, 3, 'CA', 'BSA', '0.jpg', 'T'),
(35, NULL, '2010-12391', 'Marbello', 'Ella', 'S', 'S', 'ella', 'cd73502828457d15655bbd7a63fb0bc8', 'Los Banos', 'ella@gmail.com', '09100084311', 3, 3, 'CA', 'BSFT', '0.jpg', 'T'),
(36, NULL, '2009-10932', 'Mendoza', 'Zyrille', 'B', 'S', 'zyrille', 'cd73502828457d15655bbd7a63fb0bc8', 'Los Banos', 'zy@gmail.com', '09100230111', 3, 3, 'CEM', 'BSABM', '0.jpg', 'F'),
(37, NULL, '2012-12643', 'Lasac', 'Kristine', 'A', 'S', 'kristine', 'cd73502828457d15655bbd7a63fb0bc8', 'Laguna', 'kris@gmail.com', '09230050012', 3, 3, 'CEAT', 'BSIE', '0.jpg', 'T'),
(38, NULL, '2013-10943', 'Bernardo', 'Bernadeth', 'A', 'S', 'berna', 'cd73502828457d15655bbd7a63fb0bc8', 'Los Banos', 'bern@gmail.com', '09436023012', 3, 3, 'CHE', 'BSN', '0.jpg', 'T'),
(39, NULL, '2009-93521', 'Flores', 'Sabel', 'B', 'S', 'sabel', 'cd73502828457d15655bbd7a63fb0bc8', 'Los Banos', 'bel@gmail.com', '09104362711', 3, 3, 'CDC', 'BSDC', '0.jpg', 'F'),
(40, NULL, '2007-23498', 'Ricohermoso', 'Joselle', 'C', 'S', 'joselle', 'cd73502828457d15655bbd7a63fb0bc8', 'Los Banos', 'joselle@gmail.com', '09326000111', 3, 3, 'CVM', 'DVM', '0.jpg', 'T'),
(41, NULL, '2004-89341', 'Sy', 'Christian', 'A', 'S', 'chris', 'cd73502828457d15655bbd7a63fb0bc8', 'Laguna', 'chris@gmail.com', '09480000112', 3, 3, 'GS', 'MSCS', '0.jpg', 'T');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
