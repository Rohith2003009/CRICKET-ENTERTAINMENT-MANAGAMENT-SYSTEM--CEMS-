-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2025 at 08:04 AM
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
-- Database: `cricketdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `loginame` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `loginame`, `password`) VALUES
(101, 'admin', 'admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `sender` enum('user','admin') NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `issue_id`, `sender`, `message`, `created_at`) VALUES
(18, 7, 'user', 'gvals', '2024-12-04 09:56:35'),
(19, 7, 'admin', 'k', '2024-12-04 09:57:02'),
(20, 7, 'admin', 'no i cant', '2024-12-04 09:57:10'),
(21, 8, 'user', 'sdgdiughdog', '2024-12-04 10:12:55'),
(22, 8, 'admin', 'trhth', '2024-12-04 10:13:13'),
(23, 9, 'user', 'update points table', '2024-12-04 10:55:57'),
(24, 9, 'admin', 'k i will update', '2024-12-04 10:56:32'),
(27, 10, 'user', 'Update Points Table', '2025-03-25 05:23:20'),
(28, 10, 'admin', 'K It will be updated\r\n', '2025-03-25 05:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `issue` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`id`, `email`, `issue`, `created_at`) VALUES
(7, 'gagan2004@gmail.com', 'gvals', '2024-12-04 09:56:35'),
(8, 'rohith2000@gmail.com', 'sdgdiughdog', '2024-12-04 10:12:55'),
(9, 'gagan2000@gmail.com', 'update points table', '2024-12-04 10:55:57'),
(10, 'gagan2004v@gmail.com', 'sdgsdh', '2025-03-24 11:48:23');

-- --------------------------------------------------------

--
-- Table structure for table `points_table`
--

CREATE TABLE `points_table` (
  `id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `team_name` varchar(100) NOT NULL,
  `matches_played` int(11) NOT NULL,
  `won` int(11) NOT NULL,
  `lost` int(11) NOT NULL,
  `drawn` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `flag` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `points_table`
--

INSERT INTO `points_table` (`id`, `position`, `team_name`, `matches_played`, `won`, `lost`, `drawn`, `points`, `percentage`, `flag`) VALUES
(1, 1, 'India', 5, 4, 0, 1, 22, 80.00, NULL),
(2, 5, 'Australia', 4, 3, 1, 0, 15, 80.00, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAT4AAACfCAMAAABX0UX9AAAA2FBMVEUBIWn////kACvjACAAAF/iAAT75ufrcHvjABXzsbYAH2jO1OAAGmYAAF32+PoACWGWn7kABWEAGWaUFU4AAFn+9vjpACilqb26wNHjABrvACT73+QAFmX50tjylqIAD2PpS2DsaHgzRX3sYnTrWmzjAAwkOni/xNQaM3S0u84vQnw6SoDqU'),
(3, 3, 'England', 5, 3, 1, 1, 17, 75.00, 'https://static-00.iconduck.com/assets.00/flag-of-england-emoji-512x370-67p0qum9.png'),
(4, 4, 'New Zealand', 6, 3, 2, 1, 17, 60.00, 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3e/Flag_of_New_Zealand.svg/1200px-Flag_of_New_Zealand.svg.png'),
(5, 8, 'West Indies', 5, 1, 2, 2, 7, 60.00, 'https://static.vecteezy.com/system/resources/previews/024/289/394/non_2x/illustration-of-west-indies-flag-design-vector.jpg'),
(6, 10, 'Pakistan', 3, 0, 3, 0, 0, 0.00, 'https://upload.wikimedia.org/wikipedia/commons/3/32/Flag_of_Pakistan.svg'),
(7, 2, 'Srilanka', 4, 4, 0, 0, 20, 100.00, 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Flag_of_Sri_Lanka.svg/800px-Flag_of_Sri_Lanka.svg.png'),
(8, 7, 'Afghanistan', 5, 2, 3, 0, 10, 65.00, 'https://cdn.britannica.com/40/5340-004-B25ED5CF/Flag-Afghanistan.jpg'),
(9, 6, 'South Africa', 4, 2, 1, 1, 12, 79.00, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAARMAAAC3CAMAAAAGjUrGAAABZVBMVEUAd0ngPDIAE4kAAAD////+uBz///0AAIIAc0H3+/7eJRD66+x6q5X//v8AAAP7//8AAAh/sZp5rZSJtaGFs57p6ekAdkrV1dUAeUkAdET/txwAdUz8uRwAAH4AbTkAAAv/vBYAazQAcUwAAIniOzHgMyPG3tX68ez2uSH7tyMAeE8AeUTIl'),
(10, 9, 'Bangladesh', 3, 0, 2, 1, 2, 45.00, 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Flag_of_Bangladesh.svg/1200px-Flag_of_Bangladesh.svg.png');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `confirmpassword` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `username`, `password`, `confirmpassword`, `phone`, `email`, `photo`) VALUES
(1, 'Gvals004', '$2y$10$OFssNJPxDLfuuwqpgraJb.ygcs0dzrj7nioD0bixyfR/WW1X41BMu', '123', '1425346457568', 'gagan2004v@gmail.com', 'profile1.avif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_id` (`issue_id`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `points_table`
--
ALTER TABLE `points_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `points_table`
--
ALTER TABLE `points_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`issue_id`) REFERENCES `issues` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
