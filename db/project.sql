-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2023 at 08:00 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `position_id`, `firstname`, `lastname`) VALUES
(1, 1, 'Ernie', 'Abella'),
(2, 1, 'Leody', 'De Guzman'),
(3, 1, 'Isko Moreno', 'Domagoso'),
(4, 1, 'Norberto', 'Gonzales'),
(5, 1, 'Ping', 'Lacson'),
(6, 1, 'Faisal', 'Mangondato'),
(7, 1, 'Bongbong', 'Marcos'),
(8, 1, 'Jose Jr', 'Montemayor'),
(9, 1, 'Manny Pacman', 'Pacquiao'),
(10, 1, 'Leni', 'Robredo'),
(11, 2, 'Lito', 'Atienza'),
(12, 2, 'Walden', 'Bello'),
(13, 2, 'Rizalitio', 'David'),
(14, 2, 'Sara', 'Duterte'),
(15, 2, 'Manny SD', 'Lopez'),
(16, 2, 'Doc Willie', 'Ong'),
(17, 2, 'Kiko', 'Pangilinan'),
(18, 2, 'Carlos', 'Serapio'),
(19, 2, 'Vicente Tito', 'Sotto'),
(20, 3, 'Abner', 'Afuang'),
(21, 3, 'Ibrahim', 'Albani'),
(22, 3, 'Mang Jess', 'Arranza'),
(23, 3, 'Teddy', 'Baguilat'),
(24, 3, 'Agnes', 'Bailen'),
(25, 3, 'Carl', 'Balita'),
(26, 3, 'Lutz', 'Barbo'),
(27, 3, 'Herbert Bistek', 'Bautista'),
(28, 3, 'Greco', 'Belgica'),
(29, 3, 'Silvestre Jr', 'Bello'),
(30, 3, 'Jojo', 'Binay'),
(31, 3, 'Roy', 'Cabonegro'),
(32, 3, 'Bro John', 'Castriciones'),
(33, 3, 'Alan Peter', 'Cayetano'),
(34, 3, 'Melchor', 'Chavez'),
(35, 3, 'Neri', 'Colmenares'),
(36, 3, 'David', 'D`Angelo'),
(37, 3, 'Leila', 'De Lima'),
(38, 3, 'Monsour', 'Del Rosario'),
(39, 3, 'Ding', 'Diaz'),
(40, 3, 'Chel', 'Diokno'),
(41, 3, 'Jv Estrada', 'Ejercito'),
(42, 3, 'Guillermo', 'Eleazar'),
(43, 3, 'Bro. Ernie', 'Ereño'),
(44, 3, 'Chiz', 'Escudero'),
(45, 3, 'Luke', 'Espiritu'),
(46, 3, 'Jinggoy', 'Estrada'),
(47, 3, 'Baldomero', 'Falcone'),
(48, 3, 'Larry', 'Gadon'),
(49, 3, 'Win', 'Gatchalian'),
(50, 3, 'Wow Dick', 'Gordon'),
(51, 3, 'Samira', 'Gutoc'),
(52, 3, 'Gringo', 'Honasan'),
(53, 3, 'Risa', 'Hontiveros'),
(54, 3, 'Rj', 'Javellana'),
(55, 3, 'Nur-Mahal', 'Kiram'),
(56, 3, 'Elmer', 'Labog'),
(57, 3, 'Kuya Alex', 'Lacson'),
(58, 3, 'Rey', 'Langit'),
(59, 3, 'Loren', 'Legarda'),
(60, 3, 'Ariel', 'Lim'),
(61, 3, 'Emily', 'Mallinllin'),
(62, 3, 'Francis Leo', 'Marcos'),
(63, 3, 'Sonny', 'Matula'),
(64, 3, 'Marieta', 'Mindalano-Adam'),
(65, 3, 'Atty/Dr. Leo', 'Olarte'),
(66, 3, 'Dra. Minguita', 'Padilla'),
(67, 3, 'Robin', 'Padilla'),
(68, 3, 'Sal Panalo', 'Panelo'),
(69, 3, 'Astra', 'Pimentel'),
(70, 3, 'Manny', 'Piñol'),
(71, 3, 'Willie Jr', 'Ricablanca'),
(72, 3, 'Harry Spox', 'Roque'),
(73, 3, 'Nur-ana', 'Sahidulla'),
(74, 3, 'Jopet', 'Sison'),
(75, 3, 'Gibo', 'Teodoro'),
(76, 3, 'Antonio VI', 'Trillanes'),
(77, 3, 'Tulfo', 'Idol Raffy'),
(78, 3, 'Rey', 'Valeros'),
(79, 3, 'Joel Tesdaman', 'Villanueva'),
(80, 3, 'Mark', 'Villar'),
(81, 3, 'Carmen', 'Zubiaga'),
(82, 3, 'Migz', 'Zubiri');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_votes`
--

CREATE TABLE `candidate_votes` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_votes`
--

INSERT INTO `candidate_votes` (`id`, `position_id`, `candidate_id`, `count`) VALUES
(1, 1, 1, 0),
(2, 1, 2, 1),
(3, 1, 3, 0),
(4, 1, 4, 0),
(5, 1, 5, 1),
(6, 1, 6, 0),
(7, 1, 7, 0),
(8, 1, 8, 0),
(9, 1, 9, 1),
(10, 1, 10, 3),
(11, 2, 11, 0),
(12, 2, 12, 0),
(13, 2, 13, 0),
(14, 2, 14, 0),
(15, 2, 15, 0),
(16, 2, 16, 2),
(17, 2, 17, 3),
(18, 2, 18, 0),
(19, 2, 19, 1),
(20, 3, 20, 0),
(21, 3, 21, 5),
(22, 3, 22, 2),
(23, 3, 23, 2),
(24, 3, 24, 1),
(25, 3, 25, 1),
(26, 3, 26, 2),
(27, 3, 27, 3),
(28, 3, 28, 1),
(29, 3, 29, 2),
(30, 3, 30, 3),
(31, 3, 31, 1),
(32, 3, 32, 0),
(33, 3, 33, 5),
(34, 3, 34, 1),
(35, 3, 35, 2),
(36, 3, 36, 0),
(37, 3, 37, 2),
(38, 3, 38, 2),
(39, 3, 39, 1),
(40, 3, 40, 0),
(41, 3, 41, 3),
(42, 3, 42, 1),
(43, 3, 43, 1),
(44, 3, 44, 1),
(45, 3, 45, 3),
(46, 3, 46, 1),
(47, 3, 47, 0),
(48, 3, 48, 0),
(49, 3, 49, 2),
(50, 3, 50, 2),
(51, 3, 51, 0),
(52, 3, 52, 0),
(53, 3, 53, 2),
(54, 3, 54, 1),
(55, 3, 55, 0),
(56, 3, 56, 0),
(57, 3, 57, 2),
(58, 3, 58, 1),
(59, 3, 59, 0),
(60, 3, 60, 0),
(61, 3, 61, 1),
(62, 3, 62, 2),
(63, 3, 63, 0),
(64, 3, 64, 0),
(65, 3, 65, 1),
(66, 3, 66, 0),
(67, 3, 67, 1),
(68, 3, 68, 1),
(69, 3, 69, 1),
(70, 3, 70, 1),
(71, 3, 71, 0),
(72, 3, 72, 0),
(73, 3, 73, 2),
(74, 3, 74, 0),
(75, 3, 75, 0),
(76, 3, 76, 0),
(77, 3, 77, 1),
(78, 3, 78, 0),
(79, 3, 79, 1),
(80, 3, 80, 1),
(81, 3, 81, 1),
(82, 3, 82, 2);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `position_id`, `name`) VALUES
(1, 1, 'President'),
(2, 2, 'Vice-President'),
(3, 3, 'Senator');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `voted` int(1) NOT NULL DEFAULT 0,
  `firstname` varchar(30) NOT NULL,
  `middlename` varchar(30) NOT NULL,
  `usertype` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `birthdate` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contactnumber` varchar(12) NOT NULL,
  `barangay` varchar(30) NOT NULL,
  `municipality` varchar(30) NOT NULL,
  `province` varchar(30) NOT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `voted`, `firstname`, `middlename`, `usertype`, `lastname`, `birthdate`, `password`, `email`, `contactnumber`, `barangay`, `municipality`, `province`, `gender`) VALUES
(1, 0, 'Mikael', 'Ramos', 'official', 'Aggarao', '1999-12-22', 'admin', 'mikael@gmail.com', '09662773090', 'Casibarag Norte', 'Cabagan', 'Isabela', 'Male'),
(11, 0, 'dummy', 'dummy', 'voter', 'dummy', '1998-12-28', '123', 'dummy@gmail.com', '09999999999', 'dummy', 'dummy', 'dummy', 'Other');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidate_votes`
--
ALTER TABLE `candidate_votes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `candidate_votes`
--
ALTER TABLE `candidate_votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
