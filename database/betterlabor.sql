-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2022 at 02:49 PM
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
  `genre` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `activated` tinyint(4) NOT NULL,
  `code_verification` varchar(50) NOT NULL,
  `statut` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
(1, 'Questions generales', 1);

-- --------------------------------------------------------

--
-- Table structure for table `entreprise`
--

CREATE TABLE `entreprise` (
  `ID` int(11) NOT NULL,
  `ID_manager` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `activite` tinyint(4) NOT NULL,
  `adresse` varchar(120) NOT NULL,
  `codepostal` varchar(5) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `date_abonnement` datetime DEFAULT NULL,
  `nombre_slots` mediumint(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
(1, 1, 1, 'Comment visualiser ses donnees?', 'ed,ks'),
(2, 1, 2, 'Comment gerer ses employés?', 'sjqdjsdjdqsjq');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID` int(10) UNSIGNED NOT NULL,
  `ID_entreprise` int(10) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `homme` tinyint(4) DEFAULT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(60) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activated` tinyint(4) DEFAULT NULL,
  `code_verification` varchar(15) NOT NULL,
  `statut` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
-- Indexes for table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`ID`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `capteur`
--
ALTER TABLE `capteur`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mesure`
--
ALTER TABLE `mesure`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
