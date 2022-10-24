-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2022 at 05:19 PM
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
  `Nom` varchar(100) NOT NULL,
  `position` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entreprise`
--

CREATE TABLE `entreprise` (
  `ID` bigint(20) NOT NULL,
  `ID_manager` bigint(20) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `activite` tinyint(4) NOT NULL,
  `nombre_slots` mediumint(9) NOT NULL,
  `adresse` varchar(120) NOT NULL,
  `codepostal` varchar(5) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `date_abonnement` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mesure`
--

CREATE TABLE `mesure` (
  `ID` int(11) NOT NULL,
  `ID_capteur` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  `valeur` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `ID` bigint(20) NOT NULL,
  `position` tinyint(4) NOT NULL,
  `sujet` varchar(300) NOT NULL,
  `reponse` varchar(9999) NOT NULL,
  `ID_categorie` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `IDEntreprise` int(10) NOT NULL,
  `statut` tinyint(4) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `homme` tinyint(4) DEFAULT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(60) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `datenaissance` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activated` tinyint(4) DEFAULT NULL,
  `code_verification` varchar(15) NOT NULL,
  `banni` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `capteur`
--
ALTER TABLE `capteur`
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
-- AUTO_INCREMENT for table `capteur`
--
ALTER TABLE `capteur`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mesure`
--
ALTER TABLE `mesure`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
