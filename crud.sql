-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 06, 2020 at 11:15 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` int(10) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `jenis_kelamin` enum('Pria','Wanita') NOT NULL,
  `jurusan` varchar(128) NOT NULL,
  `tanggal_lahir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nim`, `nama`, `jenis_kelamin`, `jurusan`, `tanggal_lahir`) VALUES
(1, 16650077, 'Gayuh Ridho', 'Pria', 'Teknik Informatika', '1997-09-15'),
(2, 16650087, 'Aji Masaid', 'Pria', 'Teknik Kimia', '2020-04-01'),
(3, 16650048, 'Sri Maryati', 'Wanita', 'Pendidikan Biologi', '2020-04-03'),
(4, 16650099, 'haha', 'Wanita', 'ehe', '2020-04-09'),
(5, 111, 'eee', 'Pria', 'sdsds', '2020-04-02'),
(6, 222, 'eee', 'Wanita', 'ddd', '2020-04-05'),
(7, 222, 'eee', 'Wanita', 'eee', '2020-04-06'),
(12, 16650044, 'GG', 'Pria', 'DD', '2020-04-05'),
(13, 222, 'ddd', 'Wanita', 'edd', '2020-04-01'),
(14, 22, 'Anjingddd', 'Pria', 'ddd', '2020-04-20'),
(15, 22, 'ee', 'Pria', 'dd', '2020-04-07'),
(16, 11, 'ss', 'Wanita', 'ee', '2020-04-10'),
(17, 22, 'fwefdddd', 'Pria', 'ww', '2020-04-07'),
(18, 333, 'ddd', 'Pria', 'ss', '2020-04-06'),
(19, 222, 'dd', 'Pria', 'ddd', '2020-04-10'),
(20, 222, 'fwefdddd', 'Pria', 'ddd', '2020-04-09'),
(21, 22, 'sss', 'Pria', 'www', '2020-04-08'),
(22, 222, 'fwefdddd', 'Pria', 'ddd', '2020-04-03'),
(23, 22, 'dd', 'Pria', 'dd', '2020-04-10'),
(24, 22, 'ff', 'Wanita', 'dd', '2020-04-21'),
(25, 22, 'fwefdddd', 'Pria', 'dd', '2020-04-11'),
(26, 22, 'fwefdddd', 'Pria', 'eee', '2020-04-04'),
(27, 333, 'fwefdddd', 'Wanita', 'ww', '2020-04-09'),
(28, 22, 'fwefdddd', 'Wanita', 'dd', '2020-04-09'),
(29, 22, 'fwefdddd', 'Wanita', 'ss', '2020-04-18'),
(30, 22, 'ee', 'Wanita', 'sss', '2020-04-02'),
(31, 22, 'fwefdddd', 'Pria', 'dd', '2020-04-07'),
(32, 22, 'ss', 'Wanita', 'www', '2020-04-10'),
(33, 22, 'sss', 'Wanita', 'www', '2020-04-11'),
(34, 222, 'fwefdddd', 'Wanita', 'sss', '2020-04-09'),
(36, 222, 'ddd', 'Pria', 'ddd', '2020-04-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
