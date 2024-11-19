-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 19.11.2024 klo 09:35
-- Palvelimen versio: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oppilaitos`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `kurssikirjautumiset`
--

CREATE TABLE `kurssikirjautumiset` (
  `tunnus` int(11) NOT NULL,
  `opiskelija_id` int(11) DEFAULT NULL,
  `kurssi_id` int(11) DEFAULT NULL,
  `kirjautumispaiva` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Vedos taulusta `kurssikirjautumiset`
--

INSERT INTO `kurssikirjautumiset` (`tunnus`, `opiskelija_id`, `kurssi_id`, `kirjautumispaiva`) VALUES
(12, 1, 4, '2024-11-12 14:31:38'),
(13, 4, 5, '2024-11-12 14:43:24'),
(14, 3, 5, '2024-11-12 14:43:33'),
(15, 1, 6, '2024-11-12 14:55:39'),
(16, 3, 6, '2024-11-12 14:55:43'),
(17, 4, 6, '2024-11-12 14:55:46');

-- --------------------------------------------------------

--
-- Rakenne taululle `kurssit`
--

CREATE TABLE `kurssit` (
  `tunnus` int(11) NOT NULL,
  `nimi` varchar(100) NOT NULL,
  `kuvaus` text DEFAULT NULL,
  `alkupaiva` date DEFAULT NULL,
  `loppupaiva` date DEFAULT NULL,
  `opettaja_id` int(11) DEFAULT NULL,
  `tila_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Vedos taulusta `kurssit`
--

INSERT INTO `kurssit` (`tunnus`, `nimi`, `kuvaus`, `alkupaiva`, `loppupaiva`, `opettaja_id`, `tila_id`) VALUES
(4, 'Ohjelmointi', 'Ohjelmoinnin edistys kurssi', '2024-10-05', '2024-12-20', 2, 1),
(5, 'Äidinkieli', 'Se on äidinkieli eikä suomenkieli!', '2024-09-12', '2024-11-25', 3, 2),
(6, 'Matematiikka', 'Geometrian kurssi', '2024-08-12', '2024-12-19', 4, 3);

-- --------------------------------------------------------

--
-- Rakenne taululle `opettajat`
--

CREATE TABLE `opettajat` (
  `tunnusnumero` int(11) NOT NULL,
  `etunimi` varchar(50) NOT NULL,
  `sukunimi` varchar(50) NOT NULL,
  `aine` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Vedos taulusta `opettajat`
--

INSERT INTO `opettajat` (`tunnusnumero`, `etunimi`, `sukunimi`, `aine`) VALUES
(2, 'Bogdan', 'Udrescu', 'Ohjelmointi'),
(3, 'Virpi', 'Laaksonen', 'Äidinkieli'),
(4, 'Anton', 'Nurmi', 'Matematiikka ja Fysiikka');

-- --------------------------------------------------------

--
-- Rakenne taululle `opiskelijat`
--

CREATE TABLE `opiskelijat` (
  `opiskelijanumero` int(11) NOT NULL,
  `etunimi` varchar(50) NOT NULL,
  `sukunimi` varchar(50) NOT NULL,
  `syntymapaiva` date DEFAULT NULL,
  `vuosikurssi` int(11) DEFAULT NULL CHECK (`vuosikurssi` between 1 and 3)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Vedos taulusta `opiskelijat`
--

INSERT INTO `opiskelijat` (`opiskelijanumero`, `etunimi`, `sukunimi`, `syntymapaiva`, `vuosikurssi`) VALUES
(1, 'Anna', 'Virtanen', '2000-05-20', 1),
(2, 'Mika', 'Lindstrom', '1998-02-10', 2),
(3, 'Jorma', 'Nurmi', '1994-07-15', 3),
(4, 'Niko', 'Makinen', '2024-11-30', 2),
(5, 'Liisa', 'Koskinen', '2001-08-21', 1),
(6, 'Jari', 'Hamalainen', '1997-03-12', 3),
(7, 'Paula', 'Heikkinen', '2000-12-01', 1),
(8, 'Antti', 'Jarvinen', '1999-06-18', 2),
(9, 'Sanna', 'Lehtonen', '1998-11-05', 3),
(10, 'Markus', 'Salminen', '2002-09-28', 1),
(11, 'Ella', 'Korhonen', '2003-01-17', 1),
(12, 'Janne', 'Ranta', '1996-04-11', 2),
(13, 'Laura', 'Saarinen', '2000-02-09', 2),
(14, 'Mikko', 'Vainio', '2001-07-04', 1),
(15, 'Kaisa', 'Pekonen', '1997-10-25', 3);

-- --------------------------------------------------------

--
-- Rakenne taululle `tilat`
--

CREATE TABLE `tilat` (
  `tunnus` int(11) NOT NULL,
  `nimi` varchar(50) NOT NULL,
  `kapasiteetti` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Vedos taulusta `tilat`
--

INSERT INTO `tilat` (`tunnus`, `nimi`, `kapasiteetti`) VALUES
(1, 'A302', 20),
(2, 'A216', 30),
(3, 'A207', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kurssikirjautumiset`
--
ALTER TABLE `kurssikirjautumiset`
  ADD PRIMARY KEY (`tunnus`),
  ADD KEY `opiskelija_id` (`opiskelija_id`),
  ADD KEY `kurssi_id` (`kurssi_id`);

--
-- Indexes for table `kurssit`
--
ALTER TABLE `kurssit`
  ADD PRIMARY KEY (`tunnus`),
  ADD KEY `opettaja_id` (`opettaja_id`),
  ADD KEY `tila_id` (`tila_id`);

--
-- Indexes for table `opettajat`
--
ALTER TABLE `opettajat`
  ADD PRIMARY KEY (`tunnusnumero`);

--
-- Indexes for table `opiskelijat`
--
ALTER TABLE `opiskelijat`
  ADD PRIMARY KEY (`opiskelijanumero`);

--
-- Indexes for table `tilat`
--
ALTER TABLE `tilat`
  ADD PRIMARY KEY (`tunnus`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kurssikirjautumiset`
--
ALTER TABLE `kurssikirjautumiset`
  MODIFY `tunnus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kurssit`
--
ALTER TABLE `kurssit`
  MODIFY `tunnus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `opettajat`
--
ALTER TABLE `opettajat`
  MODIFY `tunnusnumero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `opiskelijat`
--
ALTER TABLE `opiskelijat`
  MODIFY `opiskelijanumero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tilat`
--
ALTER TABLE `tilat`
  MODIFY `tunnus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `kurssikirjautumiset`
--
ALTER TABLE `kurssikirjautumiset`
  ADD CONSTRAINT `kurssikirjautumiset_ibfk_1` FOREIGN KEY (`opiskelija_id`) REFERENCES `opiskelijat` (`opiskelijanumero`),
  ADD CONSTRAINT `kurssikirjautumiset_ibfk_2` FOREIGN KEY (`kurssi_id`) REFERENCES `kurssit` (`tunnus`);

--
-- Rajoitteet taululle `kurssit`
--
ALTER TABLE `kurssit`
  ADD CONSTRAINT `kurssit_ibfk_1` FOREIGN KEY (`opettaja_id`) REFERENCES `opettajat` (`tunnusnumero`),
  ADD CONSTRAINT `kurssit_ibfk_2` FOREIGN KEY (`tila_id`) REFERENCES `tilat` (`tunnus`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
