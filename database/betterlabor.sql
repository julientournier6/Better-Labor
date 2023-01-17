-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2023 at 01:22 PM
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
  `statut` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `email`, `password`, `prenom`, `nom`, `created_at`, `updated_at`, `activated`, `code_verification`, `activation_expiry`, `statut`) VALUES
(12, 'alexisvafiadis+2@gmail.com', '$2y$10$cP2JtsRJchhW1.KmFmtW8uV4dueF4IaI7oU3vFZmHcsFHjFd/ZXM2', 'Alexis', 'Vafiadis', '2023-01-12 12:01:03', '2023-01-12 12:01:03', 0, '66ee300ec5f6240c', '2023-01-13 12:01:03', NULL),
(13, 'alexisvafiadis+2@gmail.com', '$2y$10$D03Av9A39dMLwlvN6mjNy.rQK2a/7U848RpQI3iRxxxRZmaNZc5PS', 'Alexis', 'Vafiadis', '2023-01-12 12:06:43', '2023-01-12 12:06:43', 0, '19eaa8c5bb2079e8', '2023-01-13 12:06:43', NULL);

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
  `nom` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`ID`, `nom`, `position`) VALUES
(1, 'Questions generales!', 1),
(2, 'Question pour chef de chantier', 2);

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
  `statut` tinyint(4) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chef`
--

INSERT INTO `chef` (`ID`, `email`, `password`, `prenom`, `nom`, `created_at`, `updated_at`, `activated`, `code_verification`, `activation_expiry`, `statut`) VALUES
(24, 'alexisvafiadis@gmail.com', '$2y$10$me5TfKduaPctXKyqT4qfeO1VGhlHa3Dtgdke8KQFz1Ga53xtD3HuW', 'Alexiszesazs', 'Vafiadisezseaz', '2023-01-10 09:24:03', '2023-01-10 09:24:03', 0, '38edf00c9c5d0cb9', '2023-01-11 09:24:03', 0),
(27, 'alexisvafiadis+a@gmail.com', '$2y$10$mC3Hrm1iSG7kw3xS22q6u.IX/7cHLAQo00QVf4s6ZrJjrlKbLeRlS', 'Alexisa', 'Vafiadis', '2023-01-16 19:07:59', '2023-01-16 19:07:59', 0, '1b03553310d1d6e8', '2023-01-17 19:07:59', 0);

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
('PDQ5695F2E36Z0M0P6L2', 0);

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
(14, 1, 1, 'Comment se connecter Ã  son compte', 'AprÃ¨s avoir crÃ©Ã© votre compte, cliquez sur \"sign in\" en haut Ã  droite de la page.'),
(10, 2, 1, 'Comment gÃ©rer ses employÃ©s', 'Une rÃ©ponse');

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
  `activated` tinyint(4) DEFAULT NULL,
  `statut` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`ID`, `id_chef`, `email`, `password`, `genre`, `prenom`, `nom`, `telephone`, `date_naissance`, `created_at`, `updated_at`, `activated`, `statut`) VALUES
(4, 24, 'alexisvafiadis+2@gmail.com', '$2y$10$31YlmcVfOyF7IDBmTlFLOusTxNEbmmdW8jrzY19AN3bEsK9Lq93Ze', '0', 'Big D', 'KE le booss', '0754832476', '1999-02-12', '2023-01-12 10:58:56', '2023-01-12 10:58:56', NULL, NULL),
(3, 24, 'alexisvafiadis+1@gmail.com', '$2y$10$ztH7hJlfKTYx2Pk0jdbYDempGXIrEoQZweMuChkcydF11gaAT26Hi', '0', 'Alexis', 'Vafiadis', '0754832476', '1990-01-01', '2023-01-11 18:31:21', '2023-01-11 18:31:21', NULL, NULL),
(10, 24, 'alexisvafiadis+3@gmail.com', '$2y$10$80CAjdrkOKfxWLURTDSTZO6TtFaRPJNEKgBkneNM345MTqZjbrfbm', '0', 'LÃ©oo', 'TOURON', '0754832476', '2001-11-01', '2023-01-12 14:07:08', '2023-01-12 14:07:08', NULL, NULL),
(11, 24, 'alexisvafiadis+6@gmail.com', '$2y$10$F/jCtMhxh9p.0VPV4m.DmOLOQxP9Ggsgv3pBXuf7OvDNXihu0/W9O', '0', 'Alexiss', 'Vafiadis', '0754832476', '1990-01-01', '2023-01-16 17:57:57', '2023-01-16 17:57:57', NULL, NULL);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `capteur`
--
ALTER TABLE `capteur`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `chef`
--
ALTER TABLE `chef`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `mesure`
--
ALTER TABLE `mesure`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
