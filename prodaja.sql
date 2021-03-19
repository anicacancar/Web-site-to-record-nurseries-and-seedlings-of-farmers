-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 06, 2021 at 03:15 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prodaja`
--

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

DROP TABLE IF EXISTS `komentari`;
CREATE TABLE IF NOT EXISTS `komentari` (
  `idProizv` int(11) NOT NULL,
  `komentarisao` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `komentar` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ocijena` int(11) NOT NULL,
  KEY `idProizv` (`idProizv`,`komentarisao`),
  KEY `komentarisao` (`komentarisao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`idProizv`, `komentarisao`, `komentar`, `ocijena`) VALUES
(6, 'ceani', 'Vrh', 8),
(4, 'nidzi', 'Meni je bas pomogao!', 9),
(3, 'nidzi', 'vrhunska', 10),
(1, 'Veki', 'Super', 6),
(6, 'Veki', 'Odlican proizvod!', 10),
(2, 'Veki', 'Super', 10),
(8, 'Veki', 'Odlicna!', 10);

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ime` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `prezime` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datum` date NOT NULL,
  `mjesto` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `telefon` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `tip` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `odobren` int(1) NOT NULL,
  UNIQUE KEY `username` (`username`),
  KEY `ime` (`ime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`username`, `password`, `ime`, `prezime`, `datum`, `mjesto`, `telefon`, `email`, `tip`, `odobren`) VALUES
('aco', 'Aco$2809', 'Aleksandar', 'Cancar', '2000-09-17', 'Focaaa', '+387/65-555-555', 'aco@gmail.com', 'P', 1),
('boletus', 'Bol$2809', 'Boletus d.o.o', NULL, '2000-02-02', 'Foca', NULL, 'boletus@gmail.com', 'C', 1),
('ceani', '', 'Anica', 'Cancar', '1997-09-28', 'Foca', '0645483475', 'anica.cancar@gmail.com', 'A', 1),
('fix', 'Filip.1', 'Filip', 'Nikolic', '1994-11-23', 'Bajina Basta', '+387/65-440-805', 'fico@gmail.com', 'P', 1),
('goca', 'Goca$2809', 'Gordana', 'Cancar', '1968-07-14', 'Foca', '+387/65-444-444', 'goca@gmail.com', 'P', 0),
('heko', '1111', 'Heko', NULL, '2020-07-07', 'Beograd', NULL, 'heko@gmail.com', 'C', 1),
('lenki', 'LENA', 'Lena', 'Perisic', '1997-12-27', 'Foca', '+387/65-555-555', 'lena@gmail.com', 'P', 0),
('nidzi', 'ana', 'Nikola', 'Gagovic', '1997-08-13', 'Foca', '065555555', 'nikola.gagovic97@gmail.com', 'P', 1),
('nik', 'Nik$2809', 'NIK PROM d.o.o', NULL, '2005-02-02', 'Bileca', NULL, 'nik@gmail.com', 'C', 1),
('ratar', 'Ratar.1', 'Ratar poljoprivredna apoteka', NULL, '2020-06-10', 'Kragujevac', NULL, 'ratar@gmail.com', 'C', 1),
('sezona', 'Seyona$2809', 'Sezona', NULL, '2002-02-02', 'Foca', NULL, 'sezona@gmail.com', 'C', 1),
('Veki', '1111', 'Vesna', 'Zivanovic', '1955-02-08', 'Skoplje', '065555555', 'veki@gmail.com', 'P', 1),
('win', '1111', 'Agricom', NULL, '2002-02-02', 'Beograd', NULL, 'agro@gmail.com', 'C', 1),
('zoka', 'Zoka$2809', 'Zoran', 'Cancar', '1967-01-02', 'Foca', '+387/65-555-555', 'zoka@gmail.com', 'P', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kuriri`
--

DROP TABLE IF EXISTS `kuriri`;
CREATE TABLE IF NOT EXISTS `kuriri` (
  `userPred` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `brojSlobodnihKurira` int(11) NOT NULL,
  KEY `userPred` (`userPred`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kuriri`
--

INSERT INTO `kuriri` (`userPred`, `brojSlobodnihKurira`) VALUES
('sezona', 3),
('win', 3),
('heko', 1),
('boletus', 3),
('ratar', 3);

-- --------------------------------------------------------

--
-- Table structure for table `magacin`
--

DROP TABLE IF EXISTS `magacin`;
CREATE TABLE IF NOT EXISTS `magacin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idRas` int(11) NOT NULL,
  `idProizvoda` int(11) NOT NULL,
  `kolicina` int(11) NOT NULL,
  `tip` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idRas` (`idRas`,`idProizvoda`),
  KEY `tip` (`tip`),
  KEY `idProizvoda` (`idProizvoda`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `magacin`
--

INSERT INTO `magacin` (`id`, `idRas`, `idProizvoda`, `kolicina`, `tip`) VALUES
(1, 2, 4, 0, 'P'),
(3, 2, 1, 0, 'S'),
(4, 2, 5, 1, 'P'),
(5, 1, 5, 12, 'P'),
(6, 2, 3, 6, 'S'),
(7, 2, 6, 2, 'S'),
(8, 7, 6, 27, 'S'),
(9, 2, 8, 4, 'S'),
(10, 2, 9, 1, 'S'),
(11, 2, 10, 1, 'S'),
(12, 5, 7, 2, 'P'),
(13, 5, 8, 2, 'S'),
(14, 2, 7, 3, 'P'),
(15, 7, 7, 1, 'P');

-- --------------------------------------------------------

--
-- Table structure for table `narudzbine`
--

DROP TABLE IF EXISTS `narudzbine`;
CREATE TABLE IF NOT EXISTS `narudzbine` (
  `idNarudzbine` int(11) NOT NULL AUTO_INCREMENT,
  `idRasNar` int(11) NOT NULL,
  `porucio` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `preduzece` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`idNarudzbine`),
  KEY `porucio` (`porucio`,`preduzece`),
  KEY `preduzece` (`preduzece`),
  KEY `idRas` (`idRasNar`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `narudzbine`
--

INSERT INTO `narudzbine` (`idNarudzbine`, `idRasNar`, `porucio`, `preduzece`, `status`, `datum`) VALUES
(6, 2, 'Veki', 'sezona', 'ISPORUCENA', '2020-07-02'),
(8, 2, 'Veki', 'heko', 'ISPORUCENA', '2020-07-02'),
(14, 8, 'nidzi', 'sezona', 'ISPORUCENA', '2020-07-01'),
(15, 7, 'nidzi', 'sezona', 'ISPORUCENA', '2020-06-18'),
(17, 2, 'Veki', 'sezona', 'ISPORUCENA', '2020-07-06'),
(19, 2, 'Veki', 'heko', 'DOSTAVA U TOKU', '2020-07-08'),
(20, 2, 'Veki', 'sezona', 'ISPORUCENA', '2020-07-08'),
(23, 2, 'Veki', 'sezona', 'ISPORUCENA', '2020-07-10'),
(24, 2, 'Veki', 'sezona', 'ISPORUCENA', '2020-07-11'),
(25, 2, 'Veki', 'heko', 'ISPORUCENA', '2020-07-11'),
(26, 2, 'Veki', 'sezona', 'ISPORUCENA', '2020-07-12'),
(30, 5, 'Veki', 'sezona', 'ISPORUCENA', '2020-07-13'),
(31, 6, 'Veki', 'heko', 'DOSTAVA U TOKU', '2020-07-13'),
(32, 6, 'Veki', 'win', 'NIJE ISPORUCENA', '2020-07-13'),
(34, 2, 'Veki', 'sezona', 'ISPORUCENA', '2020-07-14'),
(35, 7, 'nidzi', 'heko', 'NIJE ISPORUCENA', '2020-07-14'),
(36, 7, 'nidzi', 'sezona', 'ISPORUCENA', '2020-07-14'),
(38, 2, 'Veki', 'sezona', 'ISPORUCENA', '2020-07-15');

-- --------------------------------------------------------

--
-- Table structure for table `proizvod`
--

DROP TABLE IF EXISTS `proizvod`;
CREATE TABLE IF NOT EXISTS `proizvod` (
  `idProiz` int(11) NOT NULL AUTO_INCREMENT,
  `usernameProiz` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `naziv` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `proizvodjac` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `vrijeme` int(11) NOT NULL,
  `tip` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `kolicina` int(11) NOT NULL,
  `cijena` int(11) NOT NULL,
  PRIMARY KEY (`idProiz`),
  KEY `tip` (`tip`),
  KEY `usernameProiz` (`usernameProiz`),
  KEY `proizvodjac` (`proizvodjac`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `proizvod`
--

INSERT INTO `proizvod` (`idProiz`, `usernameProiz`, `naziv`, `proizvodjac`, `vrijeme`, `tip`, `kolicina`, `cijena`) VALUES
(1, 'heko', 'Jabuka', 'Heko', 3, 'S', 10, 15),
(2, 'heko', 'Kruska', 'Heko', 5, 'S', 8, 10),
(3, 'sezona', 'Malina', 'Sezona', 4, 'S', 0, 12),
(4, 'heko', 'Djubrivo', 'Heko', 2, 'P', 8, 18),
(5, 'sezona', 'Urea', 'Sezona', 1, 'P', 9, 30),
(6, 'win', 'Aronija', 'Agricom', 10, 'S', 15, 20),
(7, 'sezona', 'Sprej', 'Sezona', 2, 'P', 3, 13),
(8, 'sezona', 'Jagoda', 'Sezona', 10, 'S', 5, 20),
(9, 'sezona', 'Vrganj', 'Sezona', 5, 'S', 9, 20),
(10, 'sezona', 'Sljiva', 'Sezona', 10, 'S', 49, 20),
(11, 'heko', 'Rastvor za brzi rast', 'Heko', 5, 'P', 30, 15),
(12, 'sezona', 'prehrana', 'Sezona', 3, 'P', 50, 300);

-- --------------------------------------------------------

--
-- Table structure for table `rasadnik`
--

DROP TABLE IF EXISTS `rasadnik`;
CREATE TABLE IF NOT EXISTS `rasadnik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mjesto` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `duzina` int(11) NOT NULL,
  `sirina` int(11) NOT NULL,
  `temperatura` int(11) NOT NULL DEFAULT 18,
  `nivo` int(11) NOT NULL DEFAULT 200,
  `vlasnik` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vlasnik` (`vlasnik`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rasadnik`
--

INSERT INTO `rasadnik` (`id`, `naziv`, `mjesto`, `duzina`, `sirina`, `temperatura`, `nivo`, `vlasnik`) VALUES
(1, 'Sezona maline', 'Foca', 10, 20, 18, 200, 'sezona'),
(2, 'Velecevo basta', 'Foca', 10, 10, 14, 41, 'Veki'),
(3, 'Handici', 'Foca', 5, 5, 14, 152, 'Veki'),
(4, 'Brioni', 'Foca', 8, 8, 18, 200, 'Veki'),
(5, 'Crvica', 'Bajina Basta', 15, 15, 18, 200, 'Veki'),
(6, 'Crvica', 'Bajina Basta', 15, 15, 18, 200, 'Veki'),
(7, 'Lazija', 'Foca', 20, 20, 17, 188, 'nidzi'),
(8, 'Filipovici', 'Foca', 10, 10, 18, 200, 'nidzi'),
(12, 'Luka', 'Foca', 10, 20, 18, 200, 'Veki'),
(13, 'Potpece', 'Foca', 10, 10, 18, 200, 'Veki'),
(14, 'Luke', 'Foca', 10, 10, 18, 200, 'goca'),
(15, 'Naziv', 'Bajina Basta', 20, 20, 18, 200, 'Veki');

-- --------------------------------------------------------

--
-- Table structure for table `sadrzajnar`
--

DROP TABLE IF EXISTS `sadrzajnar`;
CREATE TABLE IF NOT EXISTS `sadrzajnar` (
  `idNar` int(11) NOT NULL,
  `idPro` int(11) NOT NULL,
  KEY `idNar` (`idNar`,`idPro`),
  KEY `idPro` (`idPro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sadrzajnar`
--

INSERT INTO `sadrzajnar` (`idNar`, `idPro`) VALUES
(23, 5),
(23, 8),
(24, 5),
(24, 8),
(24, 9),
(24, 10),
(25, 4),
(26, 7),
(26, 8),
(30, 7),
(30, 7),
(30, 8),
(30, 8),
(31, 1),
(31, 4),
(32, 6),
(34, 7),
(34, 8),
(35, 2),
(36, 7),
(38, 5),
(38, 7);

-- --------------------------------------------------------

--
-- Table structure for table `zasadjene`
--

DROP TABLE IF EXISTS `zasadjene`;
CREATE TABLE IF NOT EXISTS `zasadjene` (
  `idSadnje` int(11) NOT NULL AUTO_INCREMENT,
  `idRasadnik` int(11) NOT NULL,
  `idSadnica` int(11) NOT NULL,
  `pozicija` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `datumVadjenja` date NOT NULL,
  PRIMARY KEY (`idSadnje`),
  KEY `idRasadnik` (`idRasadnik`,`idSadnica`),
  KEY `idSadnica` (`idSadnica`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `zasadjene`
--

INSERT INTO `zasadjene` (`idSadnje`, `idRasadnik`, `idSadnica`, `pozicija`, `datumVadjenja`) VALUES
(36, 7, 6, '34', '2020-07-11'),
(39, 7, 6, '617', '2020-07-11'),
(41, 2, 3, '52', '2020-07-12'),
(42, 2, 8, '20', '2020-07-18'),
(43, 2, 8, '95', '2020-07-18'),
(44, 2, 6, '26', '2020-07-21'),
(45, 2, 3, '54', '2020-07-12'),
(46, 2, 3, '88', '2020-07-12'),
(50, 2, 3, '38', '2020-07-12'),
(51, 2, 6, '23', '2020-07-25');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentari`
--
ALTER TABLE `komentari`
  ADD CONSTRAINT `komentari_ibfk_1` FOREIGN KEY (`idProizv`) REFERENCES `proizvod` (`idProiz`),
  ADD CONSTRAINT `komentari_ibfk_2` FOREIGN KEY (`komentarisao`) REFERENCES `korisnik` (`username`);

--
-- Constraints for table `kuriri`
--
ALTER TABLE `kuriri`
  ADD CONSTRAINT `kuriri_ibfk_1` FOREIGN KEY (`userPred`) REFERENCES `korisnik` (`username`);

--
-- Constraints for table `magacin`
--
ALTER TABLE `magacin`
  ADD CONSTRAINT `magacin_ibfk_1` FOREIGN KEY (`idRas`) REFERENCES `rasadnik` (`id`),
  ADD CONSTRAINT `magacin_ibfk_2` FOREIGN KEY (`IdProizvoda`) REFERENCES `proizvod` (`idProiz`),
  ADD CONSTRAINT `magacin_ibfk_3` FOREIGN KEY (`tip`) REFERENCES `proizvod` (`tip`),
  ADD CONSTRAINT `magacin_ibfk_4` FOREIGN KEY (`idProizvoda`) REFERENCES `proizvod` (`idProiz`);

--
-- Constraints for table `narudzbine`
--
ALTER TABLE `narudzbine`
  ADD CONSTRAINT `narudzbine_ibfk_1` FOREIGN KEY (`porucio`) REFERENCES `korisnik` (`username`),
  ADD CONSTRAINT `narudzbine_ibfk_2` FOREIGN KEY (`preduzece`) REFERENCES `korisnik` (`username`),
  ADD CONSTRAINT `narudzbine_ibfk_3` FOREIGN KEY (`idRasNar`) REFERENCES `rasadnik` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `proizvod`
--
ALTER TABLE `proizvod`
  ADD CONSTRAINT `proizvod_ibfk_1` FOREIGN KEY (`usernameProiz`) REFERENCES `korisnik` (`username`),
  ADD CONSTRAINT `proizvod_ibfk_2` FOREIGN KEY (`proizvodjac`) REFERENCES `korisnik` (`ime`) ON UPDATE CASCADE;

--
-- Constraints for table `rasadnik`
--
ALTER TABLE `rasadnik`
  ADD CONSTRAINT `rasadnik_ibfk_1` FOREIGN KEY (`vlasnik`) REFERENCES `korisnik` (`username`);

--
-- Constraints for table `sadrzajnar`
--
ALTER TABLE `sadrzajnar`
  ADD CONSTRAINT `sadrzajnar_ibfk_1` FOREIGN KEY (`idNar`) REFERENCES `narudzbine` (`idNarudzbine`),
  ADD CONSTRAINT `sadrzajnar_ibfk_2` FOREIGN KEY (`idPro`) REFERENCES `proizvod` (`idProiz`);

--
-- Constraints for table `zasadjene`
--
ALTER TABLE `zasadjene`
  ADD CONSTRAINT `zasadjene_ibfk_1` FOREIGN KEY (`idRasadnik`) REFERENCES `rasadnik` (`id`),
  ADD CONSTRAINT `zasadjene_ibfk_2` FOREIGN KEY (`idSadnica`) REFERENCES `proizvod` (`idProiz`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
