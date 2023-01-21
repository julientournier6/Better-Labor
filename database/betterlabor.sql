-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2023 at 01:19 AM
-- Server version: 5.7.17
-- PHP Version: 7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `betterlabor`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activated` tinyint(4) DEFAULT '0',
  `code_verification` varchar(50) NOT NULL,
  `activation_expiry` datetime NOT NULL,
  `statut` tinyint(4) DEFAULT NULL,
  `badge` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `email`, `password`, `prenom`, `nom`, `created_at`, `updated_at`, `activated`, `code_verification`, `activation_expiry`, `statut`, `badge`) VALUES
(15, 'alexisvafiadis@gmail.com', '$2y$10$ZDv7NtqDFtgfAxpRp2pD8ehJtZ8pCMtj6DvqLxrg9wzPgMdpHgpQu', 'Alexis', 'Vafiadis', '2023-01-20 11:57:47', '2023-01-20 11:57:47', 0, 'c2e63b8368abbf54', '2023-01-21 11:57:47', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `capteur`
--

CREATE TABLE `capteur` (
  `ID` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `unite` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `ID` int(11) NOT NULL,
  `nom` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`ID`, `nom`, `position`) VALUES
(1, 'Questions generales!', 1),
(2, 'Questions pour chef de chantier', 2);

-- --------------------------------------------------------

--
-- Table structure for table `chef`
--

CREATE TABLE `chef` (
  `ID` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(60) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activated` tinyint(4) DEFAULT '0',
  `code_verification` varchar(20) NOT NULL,
  `activation_expiry` datetime NOT NULL,
  `statut` tinyint(4) DEFAULT '0',
  `badge` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chef`
--

INSERT INTO `chef` (`ID`, `email`, `password`, `prenom`, `nom`, `created_at`, `updated_at`, `activated`, `code_verification`, `activation_expiry`, `statut`, `badge`) VALUES
(29, 'alexisvafiadis@gmail.com', '$2y$10$nJPQANhvnj3Xuj/lzuhhC.jcw7kP4klkqB2wZgX6VP/kxp.NVbTMW', 'Alexis', 'Vafiadis', '2023-01-20 13:05:34', '2023-01-20 13:05:34', 0, '9b07fe615e4429c7', '2023-01-21 13:05:34', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `code_admin`
--

CREATE TABLE `code_admin` (
  `code` varchar(20) NOT NULL,
  `valide` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `code_admin`
--

INSERT INTO `code_admin` (`code`, `valide`) VALUES
('PDQ5695F2E36Z0M0P6L2', 0),
('PDQ5695F2E36Z0M0P6L3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mesure`
--

CREATE TABLE `mesure` (
  `ID` int(11) NOT NULL,
  `ID_capteur` int(11) NOT NULL,
  `ID_utilisateur` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  `valeur` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `ID` int(11) NOT NULL,
  `ID_categorie` int(11) NOT NULL,
  `position` tinyint(4) NOT NULL,
  `sujet` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `reponse` varchar(9999) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`ID`, `ID_categorie`, `position`, `sujet`, `reponse`) VALUES
(14, 1, 1, 'Comment se connecter Ã  son compte?', 'AprÃ¨s avoir crÃ©Ã© votre compte, cliquez sur \\\"sign in\\\" en haut Ã  droite de la page.'),
(10, 2, 1, 'Comment gÃ©rer ses employÃ©s?', 'Une rÃ©ponse');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID` int(10) UNSIGNED NOT NULL,
  `id_chef` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `genre` varchar(1) DEFAULT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(60) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activated` tinyint(4) DEFAULT '0',
  `statut` tinyint(4) DEFAULT '0',
  `badge` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`ID`, `id_chef`, `email`, `password`, `genre`, `prenom`, `nom`, `telephone`, `date_naissance`, `created_at`, `updated_at`, `activated`, `statut`, `badge`) VALUES
(13, 29, 'alexisvafiadis+2@gmail.com', '$2y$10$eggRv7x3JVXHVY0wgkElSe.hV.cLqSV.pE2ITFOXo38GAMppSHHNO', '0', 'Dylan', 'KE', '0754832476', '1990-01-01', '2023-01-20 14:30:16', '2023-01-20 14:30:16', 0, 0, 2),
(12, 29, 'alexisvafiadis+1@gmail.com', '$2y$10$2ypAa2xiegGFOvhp9a99VeQn5pb3KoZiTFUjpFnAuWmxmeWvIxun2', '0', 'Alexis', 'Vafiadis', '0754832476', '2000-06-01', '2023-01-20 14:11:00', '2023-01-20 14:11:00', 0, 0, 0),
(14, 29, 'alexisvafiadis+4@gmail.com', '$2y$10$aywQK6aNZxUM.XbOe/ROyeqxUYl1H1lh2odw3mxFiHzedjTZn4KiC', '1', 'Meishan', 'CHEN', '0754832476', '1990-01-01', '2023-01-20 14:30:43', '2023-01-20 14:30:43', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `capteur`
--
ALTER TABLE `capteur`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `chef`
--
ALTER TABLE `chef`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `code_admin`
--
ALTER TABLE `code_admin`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `mesure`
--
ALTER TABLE `mesure`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `capteur`
--
ALTER TABLE `capteur`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `chef`
--
ALTER TABLE `chef`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `mesure`
--
ALTER TABLE `mesure`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
