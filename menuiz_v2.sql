-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 06 mai 2022 à 13:59
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `menuiz`
--
DROP DATABASE IF EXISTS `menuiz`;
CREATE DATABASE IF NOT EXISTS `menuiz` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `menuiz`;

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `prc_del_todo_task`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `prc_del_todo_task` (IN `idTick` INT)  NO SQL
BEGIN
DELETE FROM `doonticket` WHERE ticketID = idtick AND endingTime IS NULL ; 

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `action`
--

DROP TABLE IF EXISTS `action`;
CREATE TABLE IF NOT EXISTS `action` (
  `actionID` int(11) NOT NULL,
  `actionType` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`actionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `action`
--

INSERT INTO `action` (`actionID`, `actionType`) VALUES
(1, 'Création du ticket'),
(2, 'Réception'),
(3, 'Diagnostic'),
(4, 'Remboursement'),
(5, 'Remplacement'),
(6, 'Réexpédition'),
(7, 'Clôture');

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `addressID` int(11) NOT NULL AUTO_INCREMENT,
  `streetNumber` int(11) DEFAULT NULL,
  `streetName` varchar(100) NOT NULL,
  `COG` varchar(5) NOT NULL,
  `postCode` varchar(5) NOT NULL,
  PRIMARY KEY (`addressID`),
  KEY `COG` (`COG`),
  KEY `postCode` (`postCode`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`addressID`, `streetNumber`, `streetName`, `COG`, `postCode`) VALUES
(1, 5, 'Rue des roses', '14271', '14123'),
(2, 22, 'Rue des lilas', '14341', '14123'),
(3, 5, 'Rue des tournevis', '14118', '14000'),
(4, 23, 'Rue des rues', '75056', '75001'),
(5, 98, 'Boulevard de la-bas', '14118', '14032'),
(6, 9, 'Rue truc', '31555', '31000'),
(7, 5, 'Avenue machin', '14271', '14123'),
(8, 0, 'Lieu-dit des pres', '14118', '14000'),
(9, 8, 'Rue ici', '75056', '75001'),
(10, 45, 'Rue de Falaise', '14118', '14032'),
(11, 3, 'Avenue de Caen', '31555', '31000'),
(12, 6, 'Avenue Leclerc', '14271', '14123'),
(13, 24, 'Lieu-dit des pres', '14118', '14000'),
(14, 24, 'Rue du pet', '13000', '13000'),
(15, 30, 'Rue du pet', '13000', '13000'),
(16, 20, 'Rue de la paix', '14000', '14000'),
(17, 6, 'Rue des tournevis', '14118', '14000');

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `articleID` varchar(10) NOT NULL,
  `articleName` varchar(50) NOT NULL,
  `articlePrice` int(11) NOT NULL,
  `guarDuration` int(11) DEFAULT NULL,
  `note1` varchar(50) DEFAULT NULL,
  `note2` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`articleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`articleID`, `articleName`, `articlePrice`, `guarDuration`, `note1`, `note2`) VALUES
('0010001001', 'Clôture aluminium sur mesure ATHENES', 17885, 192, NULL, NULL),
('0010001002', 'Clôture aluminium sur mesure ATHENES', 17885, 192, NULL, NULL),
('0010001003', 'Clôture aluminium sur mesure ATHENES', 17885, 192, NULL, NULL),
('0010001004', 'Clôture aluminium sur mesure ATHENES', 17885, 192, NULL, NULL),
('0010001005', 'Clôture aluminium sur mesure ATHENES', 17885, 192, NULL, NULL),
('0010001006', 'Clôture aluminium sur mesure ATHENES', 17885, 192, NULL, NULL),
('0010001007', 'Clôture aluminium sur mesure ATHENES', 17885, 192, NULL, NULL),
('0010001008', 'Clôture aluminium sur mesure ATHENES', 17885, 192, NULL, NULL),
('0010002001', 'Clôture aluminium sur mesure NAUPLIE', 19327, 192, NULL, NULL),
('0010002002', 'Clôture aluminium sur mesure NAUPLIE', 19327, 192, NULL, NULL),
('0010002003', 'Clôture aluminium sur mesure NAUPLIE', 19327, 192, NULL, NULL),
('0010002004', 'Clôture aluminium sur mesure NAUPLIE', 19327, 192, NULL, NULL),
('0010002005', 'Clôture aluminium sur mesure NAUPLIE', 19327, 192, NULL, NULL),
('0010002006', 'Clôture aluminium sur mesure NAUPLIE', 19327, 192, NULL, NULL),
('0010002007', 'Clôture aluminium sur mesure NAUPLIE', 19327, 192, NULL, NULL),
('0010002008', 'Clôture aluminium sur mesure NAUPLIE', 19327, 192, NULL, NULL),
('0010003001', 'Clôture aluminium sur mesure OLYMPIE', 19880, 192, NULL, NULL),
('0010003002', 'Clôture aluminium sur mesure OLYMPIE', 19880, 192, NULL, NULL),
('0010003003', 'Clôture aluminium sur mesure OLYMPIE', 19880, 192, NULL, NULL),
('0010003004', 'Clôture aluminium sur mesure OLYMPIE', 19880, 192, NULL, NULL),
('0010003005', 'Clôture aluminium sur mesure OLYMPIE', 19880, 192, NULL, NULL),
('0010003006', 'Clôture aluminium sur mesure OLYMPIE', 19880, 192, NULL, NULL),
('0010003007', 'Clôture aluminium sur mesure OLYMPIE', 19880, 192, NULL, NULL),
('0010003008', 'Clôture aluminium sur mesure OLYMPIE', 19880, 192, NULL, NULL),
('0020001003', 'Porte d’entrée aluminium HUDSON', 219472, 120, NULL, NULL),
('0020001004', 'Porte d’entrée aluminium HUDSON', 219472, 120, NULL, NULL),
('0020001008', 'Porte d’entrée aluminium HUDSON', 219472, 120, NULL, NULL),
('0020002002', 'Porte d’entrée aluminium FACTORY', 145972, 120, NULL, NULL),
('0020002003', 'Porte d’entrée aluminium FACTORY', 145972, 120, NULL, NULL),
('0020002004', 'Porte d’entrée aluminium FACTORY', 145972, 120, NULL, NULL),
('0020002006', 'Porte d’entrée aluminium FACTORY', 145972, 120, NULL, NULL),
('0020003003', 'Porte d’entrée aluminium LISBONNE', 145972, 120, NULL, NULL),
('0020003004', 'Porte d’entrée aluminium LISBONNE', 145972, 120, NULL, NULL),
('0020003005', 'Porte d’entrée aluminium LISBONNE', 145972, 120, NULL, NULL),
('0030001000', 'Moteur portail coulissant ROAD400', 99900, 60, NULL, NULL),
('0030002000', 'Moteur portail coulissant CAME BX-78 U2643ML 230V', 119760, 60, NULL, NULL),
('0030004000', 'Moteur portail 2 battants FAST-U1872', 105880, 120, NULL, NULL),
('0040001000', 'Télécommande universelle moteur Lenier', 5000, 6, NULL, NULL),
('0040002000', 'Télécommande portail coullissant ROAD400', 2500, 6, NULL, NULL),
('0040003000', 'Télécommande portail coulissant CAME BX-78 U2643ML', 2500, 6, NULL, NULL),
('0040004000', 'Télécommande universelle moteur Rolie', 4500, 6, NULL, NULL),
('0050001000', 'Crémaillère nylon 1m', 1500, 6, NULL, NULL),
('0050002000', 'Crémaillère acier 1m', 2000, 6, NULL, NULL),
('0060001000', 'Kit moteur ROAD400 + 4m crémaillère + télécommande', 103700, NULL, NULL, NULL),
('0060002000', 'Kit moteur CAME BX-78 +4m crémaillère', 123960, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `articletype`
--

DROP TABLE IF EXISTS `articletype`;
CREATE TABLE IF NOT EXISTS `articletype` (
  `artTypeID` varchar(3) NOT NULL,
  `artTypeName` varchar(50) NOT NULL,
  PRIMARY KEY (`artTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articletype`
--

INSERT INTO `articletype` (`artTypeID`, `artTypeName`) VALUES
('001', 'Cloture'),
('002', 'Porte d entree'),
('003', 'Moteur portail'),
('004', 'Telecommande'),
('005', 'Cremaillere'),
('006', 'Kit');

-- --------------------------------------------------------

--
-- Structure de la table `canreplace`
--

DROP TABLE IF EXISTS `canreplace`;
CREATE TABLE IF NOT EXISTS `canreplace` (
  `articleID_is_replaced` varchar(10) NOT NULL,
  `articleID_is_replacing` varchar(10) NOT NULL,
  PRIMARY KEY (`articleID_is_replaced`,`articleID_is_replacing`),
  KEY `articleID_is_replaced` (`articleID_is_replacing`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `canreplace`
--

INSERT INTO `canreplace` (`articleID_is_replaced`, `articleID_is_replacing`) VALUES
('0040002000', '0010001001'),
('0020002004', '0040001000'),
('0040003000', '0040001000'),
('0060001000', '0040001000'),
('0040001000', '0040002000'),
('0040002000', '0040004000'),
('0040003000', '0040004000');

--
-- Déclencheurs `canreplace`
--
DROP TRIGGER IF EXISTS `before_replace_insert`;
DELIMITER $$
CREATE TRIGGER `before_replace_insert` BEFORE INSERT ON `canreplace` FOR EACH ROW BEGIN

IF ((NEW.articleID_is_replacing, NEW.articleID_is_replaced) IN (SELECT * FROM canreplace)) THEN
	SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Le remplacement existe déjà";
END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `COG` varchar(5) NOT NULL,
  `postCode` varchar(5) NOT NULL,
  `cityName` varchar(50) NOT NULL,
  PRIMARY KEY (`COG`,`postCode`),
  KEY `COG` (`COG`),
  KEY `postCode` (`postCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `city`
--

INSERT INTO `city` (`COG`, `postCode`, `cityName`) VALUES
('13000', '13000', 'Marseille'),
('14000', '14000', 'Caen'),
('14118', '14000', 'Caen'),
('14118', '14032', 'Caen cedex 5'),
('14271', '14123', 'Fleury-sur-Orne'),
('14341', '14123', 'Ifs'),
('31555', '31000', 'Toulouse'),
('75056', '75001', 'Paris 1e arr');

-- --------------------------------------------------------

--
-- Structure de la table `color`
--

DROP TABLE IF EXISTS `color`;
CREATE TABLE IF NOT EXISTS `color` (
  `colorID` varchar(3) NOT NULL,
  `colorName` varchar(50) NOT NULL,
  PRIMARY KEY (`colorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `color`
--

INSERT INTO `color` (`colorID`, `colorName`) VALUES
('000', 'Pas de couleur'),
('001', 'Gris anthracite'),
('002', 'Blanc'),
('003', 'Noir'),
('004', 'Bleu marine'),
('005', 'Bordeaux'),
('006', 'Rose poudre'),
('007', 'Gris'),
('008', 'Cuivre');

-- --------------------------------------------------------

--
-- Structure de la table `composed`
--

DROP TABLE IF EXISTS `composed`;
CREATE TABLE IF NOT EXISTS `composed` (
  `articleID_is_composed` varchar(10) NOT NULL,
  `articleID_is_composing` varchar(10) NOT NULL,
  `articleQty` int(11) NOT NULL,
  PRIMARY KEY (`articleID_is_composed`,`articleID_is_composing`),
  KEY `articleID_is_composing` (`articleID_is_composing`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `composed`
--

INSERT INTO `composed` (`articleID_is_composed`, `articleID_is_composing`, `articleQty`) VALUES
('0030001000', '0040002000', 1),
('0030002000', '0040003000', 1),
('0060001000', '0030001000', 1),
('0060001000', '0040002000', 1),
('0060001000', '0050001000', 4),
('0060002000', '0030002000', 1),
('0060002000', '0050001000', 4);

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customerID` int(11) NOT NULL AUTO_INCREMENT,
  `custLastName` varchar(20) NOT NULL,
  `custFirstName` varchar(20) NOT NULL,
  `phoneNumber` varchar(10) DEFAULT NULL,
  `addressID` int(11) DEFAULT NULL,
  PRIMARY KEY (`customerID`),
  KEY `customer_ibfk_1` (`addressID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `customer`
--

INSERT INTO `customer` (`customerID`, `custLastName`, `custFirstName`, `phoneNumber`, `addressID`) VALUES
(1, 'Dupont', 'Jade', '6853251', 1),
(2, 'Durand', 'Leo', '564', 2),
(3, 'Martin', 'Louise', '13513521', 17),
(4, 'Dubois', 'Gabriel', '543216544', 4),
(5, 'Moreau', 'Alice', '5463468464', 5),
(6, 'Lefebvre', 'Louis', NULL, 6),
(7, 'Lefevre', 'Ambre', NULL, 7),
(8, 'Roux', 'Louise', '546541', 15),
(9, 'Girard', 'Arthur', '1', 9),
(10, 'Bonnet', 'Rose', NULL, 16),
(11, 'Dubois', 'Gabriel', '5631465', 11),
(12, 'Roux', 'Thierry', '5464646847', 12);

-- --------------------------------------------------------

--
-- Structure de la table `doonticket`
--

DROP TABLE IF EXISTS `doonticket`;
CREATE TABLE IF NOT EXISTS `doonticket` (
  `doID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `ticketID` int(11) NOT NULL,
  `actionID` int(11) NOT NULL,
  `startingTime` datetime DEFAULT NULL,
  `endingTime` datetime DEFAULT NULL,
  `commentary` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`doID`),
  KEY `ticketID` (`ticketID`),
  KEY `actionID` (`actionID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `doonticket`
--

INSERT INTO `doonticket` (`doID`, `userID`, `ticketID`, `actionID`, `startingTime`, `endingTime`, `commentary`) VALUES
(144, 14, 59, 1, '2022-05-06 08:24:45', '2022-05-06 08:24:45', 'Commande n°2'),
(145, NULL, 59, 2, NULL, NULL, 'Réf. article n°0060001000 (x 1)'),
(146, 14, 60, 1, '2022-05-06 08:25:09', '2022-05-06 08:25:09', 'Commande n°3'),
(147, NULL, 60, 2, NULL, NULL, 'Réf. article n°0010002001 (x 2)'),
(148, NULL, 60, 3, NULL, NULL, 'Garantie ?'),
(149, 14, 61, 1, '2022-05-06 08:25:37', '2022-05-06 08:25:37', 'Commande n°4'),
(150, NULL, 61, 2, NULL, NULL, 'Toute la commande'),
(151, NULL, 61, 6, NULL, NULL, 'Réexpédition à: 6 Rue des tournevis 14000 Caen'),
(162, 13, 64, 1, '2022-05-06 09:03:58', '2022-05-06 09:03:58', 'Commande n°5'),
(163, NULL, 64, 2, NULL, NULL, 'Toute la commande'),
(164, NULL, 64, 6, NULL, NULL, 'Réexpédition à: 23 Rue des rues 75001 Paris 1e arr'),
(165, 13, 65, 1, '2022-05-06 09:04:38', '2022-05-06 09:04:38', 'Commande n°6'),
(166, 13, 65, 2, '2022-05-06 09:10:21', '2022-05-06 09:10:23', 'Réf. article n°0010002006 (x 9)'),
(167, 13, 65, 4, '2022-05-06 09:10:26', '2022-05-06 09:10:27', 'Remboursement de 1739.43€'),
(168, 13, 66, 1, '2022-05-06 09:05:17', '2022-05-06 09:05:17', 'Commande n°7'),
(169, NULL, 66, 2, NULL, NULL, 'Réf. article n°0030002000 (x 1)'),
(170, 13, 67, 1, '2022-05-06 09:05:53', '2022-05-06 09:05:53', 'Commande n°8'),
(171, 13, 67, 2, '2022-05-06 09:10:42', '2022-05-06 09:10:47', 'Réf. article n°0060001000 (x 1)'),
(172, 13, 67, 3, '2022-05-06 09:10:53', NULL, 'Garantie ?'),
(173, 13, 68, 1, '2022-05-06 09:05:54', '2022-05-06 09:05:54', 'Commande n°8'),
(174, 13, 68, 2, '2022-05-08 14:47:46', '2022-05-08 14:47:48', 'Réf. article n°0020002006 (x 2)'),
(175, 13, 68, 3, '2022-05-08 14:47:51', '2022-05-08 14:47:54', 'Garantie ?'),
(176, 13, 65, 7, '2022-05-06 09:10:31', '2022-05-06 09:10:31', NULL),
(183, 13, 71, 1, '2022-05-06 11:02:27', '2022-05-06 11:02:27', 'Commande n°15'),
(184, NULL, 71, 2, NULL, NULL, 'Toute la commande'),
(185, NULL, 71, 6, NULL, NULL, 'Réexpédition à: 3 Avenue de Caen 31000 Toulouse'),
(210, 14, 80, 1, '2022-05-08 14:36:56', '2022-05-08 14:36:56', 'Commande n°6'),
(211, 13, 80, 2, '2022-05-08 14:52:13', '2022-05-08 14:52:15', 'Réf. article n°0010002006 (x 9)'),
(213, 14, 81, 1, '2022-05-08 14:37:39', '2022-05-08 14:37:39', 'Commande n°11'),
(214, 13, 81, 2, '2022-05-08 14:48:42', '2022-05-08 14:48:44', 'Toute la commande'),
(215, NULL, 81, 6, NULL, NULL, 'Réexpédition à: 5 Avenue machin 14123 Fleury-sur-Orne'),
(216, 14, 82, 1, '2022-05-08 14:38:18', '2022-05-08 14:38:18', 'Commande n°14'),
(217, 13, 82, 2, '2022-05-08 14:50:12', '2022-05-08 14:50:14', 'Toute la commande'),
(218, 13, 82, 6, '2022-05-08 14:50:16', '2022-05-08 14:50:17', 'Réexpédition à: 20 Rue de la paix 14000 Caen'),
(219, 14, 83, 1, '2022-05-08 14:39:38', '2022-05-08 14:39:38', 'Commande n°17'),
(220, NULL, 83, 2, NULL, NULL, 'Réf. article n°0040002000 (x 1)'),
(221, 13, 84, 1, '2022-05-08 14:41:26', '2022-05-08 14:41:26', 'Commande n°9'),
(222, NULL, 84, 2, NULL, NULL, 'Réf. article n°0010001001 (x 1)'),
(223, NULL, 84, 3, NULL, NULL, 'Garantie ?'),
(224, 13, 85, 1, '2022-05-08 14:42:43', '2022-05-08 14:42:43', 'Commande n°12'),
(225, 13, 85, 2, '2022-05-08 14:49:19', '2022-05-08 14:49:21', 'Réf. article n°0040004000 (x 1)'),
(226, NULL, 85, 3, NULL, NULL, 'Garantie ?'),
(227, 13, 86, 1, '2022-05-08 14:42:44', '2022-05-08 14:42:44', 'Commande n°12'),
(228, 13, 86, 2, '2022-05-08 14:49:00', '2022-05-08 14:49:02', 'Réf. article n°0050001000 (x 2)'),
(229, NULL, 86, 3, NULL, NULL, 'Garantie ?'),
(230, 13, 87, 1, '2022-05-08 14:42:44', '2022-05-08 14:42:44', 'Commande n°12'),
(231, 13, 87, 2, '2022-05-08 14:49:53', '2022-05-08 14:49:55', 'Réf. article n°0050002000 (x 2)'),
(232, NULL, 87, 3, NULL, NULL, 'Garantie ?'),
(233, 13, 88, 1, '2022-05-08 14:44:55', '2022-05-08 14:44:55', 'Commande n°13'),
(234, 13, 88, 2, '2022-05-08 14:53:53', '2022-05-08 14:53:55', 'Réf. article n°0020001003 (x 1)'),
(236, 13, 89, 1, '2022-05-08 14:46:57', '2022-05-08 14:46:57', 'Commande n°13'),
(237, NULL, 89, 2, NULL, NULL, 'Réf. article n°0040002000 (x 1)'),
(238, NULL, 89, 3, NULL, NULL, 'Garantie ?'),
(239, 13, 68, 4, '2022-05-08 14:48:14', '2022-05-08 14:48:17', 'Remboursement de 2919.44€'),
(240, 13, 68, 7, '2022-05-08 14:48:23', '2022-05-08 14:48:23', NULL),
(241, 13, 82, 7, '2022-05-08 14:50:21', '2022-05-08 14:50:21', NULL),
(242, 13, 80, 5, '2022-05-08 14:52:30', '2022-05-08 14:52:32', 'Remplacement par: 0010002008'),
(243, 13, 80, 6, NULL, NULL, 'Réexpédition à: 98 Boulevard de la-bas 14032 Caen cedex 5'),
(244, 13, 88, 5, NULL, NULL, NULL);

--
-- Déclencheurs `doonticket`
--
DROP TRIGGER IF EXISTS `after_insert_doonticket`;
DELIMITER $$
CREATE TRIGGER `after_insert_doonticket` AFTER INSERT ON `doonticket` FOR EACH ROW BEGIN

	IF(new.actionID = 7) THEN
    	UPDATE `ticket` SET `closed`= 1 WHERE ticketID = new.ticketID;
    END IF;

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_update_doonticket`;
DELIMITER $$
CREATE TRIGGER `after_update_doonticket` AFTER UPDATE ON `doonticket` FOR EACH ROW BEGIN 

DECLARE type VARCHAR(10) DEFAULT "";
DECLARE article VARCHAR(10) DEFAULT "";
DECLARE newQty INT(11) DEFAULT 0;
DECLARE idReplace VARCHAR(50) DEFAULT "";

SELECT t.ticketTypeID, t.articleID,t.treatedQty INTO type,article,newQty FROM ticket t JOIN doonticket d ON t.ticketID = d.ticketID WHERE t.ticketID = new.ticketID GROUP BY t.ticketID;

IF(new.actionID =2 AND new.endingTime IS NOT NULL AND type IN ("SAV","EP","EC")) THEN  
    -- Reception entrée en stock SAV 
    UPDATE `stocked` SET `storagedQty`= (storagedQty + newqty) WHERE articleID = article AND storageID = 1;
END IF;

IF ((new.actionID = 4 OR new.actionID = 5) AND new.endingTime IS NOT NULL) THEN
    -- Remboursement/Remplacement = sortie de stock SAV
    UPDATE `stocked` SET `storagedQty`= (stocked.storagedQty - newQty) WHERE articleID = article AND storageID = 1;
    IF(type = "SAV") THEN
    -- Si ticket SAV = entrée dans stock rebus
        UPDATE `stocked` SET `storagedQty`= (storagedQty + newQty) WHERE articleID = article AND storageID = 3;
    ELSE 
    -- Sinon entrée dans stock Physique
        UPDATE `stocked` SET `storagedQty`= (storagedQty + newQty) WHERE articleID = article AND storageID = 2;
    END IF;
    
END IF;

IF (new.actionID = 6 AND new.endingTime IS NOT NULL AND type IN ("SAV","EP","EC")) THEN
    -- REEXPEDITION = sortie du stock Physique de l'article expédié

    -- Prendre l'id article sortant si existe action remplacement
    IF ((SELECT COUNT(*) FROM doonticket WHERE ticketID = new.ticketID AND actionID = 5) <> 0) THEN
        SET idReplace := (SELECT REPLACE(commentary, "Remplacement par: ", "") FROM doonticket WHERE ticketID = new.ticketID AND actionID = 5 ORDER BY doID DESC LIMIT 1);
    ELSE 
        SET idReplace := article;
    END IF;

    UPDATE `stocked` SET `storagedQty`= (storagedQty - newQty) WHERE articleID = idReplace AND storageID = 2;

END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_doonticket`;
DELIMITER $$
CREATE TRIGGER `before_update_doonticket` BEFORE UPDATE ON `doonticket` FOR EACH ROW BEGIN 

DECLARE type VARCHAR(10) DEFAULT "";
DECLARE article VARCHAR(10) DEFAULT "";
DECLARE newQty INT(11) DEFAULT 0;
DECLARE idReplace VARCHAR(50) DEFAULT "";
DECLARE stockTest INT DEFAULT 0;

SELECT t.ticketTypeID, t.articleID,t.treatedQty INTO type,article,newQty FROM ticket t JOIN doonticket d ON t.ticketID = d.ticketID WHERE t.ticketID = new.ticketID GROUP BY t.ticketID;


IF ((new.actionID = 4 OR new.actionID = 5) AND new.endingTime IS NOT NULL) THEN

    -- Remboursement/Remplacement = sortie de stock SAV
    SELECT storagedQty - newQty INTO stockTest FROM stocked WHERE articleID = article AND storageID = 1;

    IF (stockTest < 0) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Stock SAV insuffisant";
    END IF;

END IF;

IF (new.actionID = 6 AND new.endingTime IS NOT NULL AND type IN ("SAV","EP","EC")) THEN
    -- REEXPEDITION = sortie du stock Physique de l'article expédié

    -- Prendre l'id article sortant si existe action remplacement
    IF ((SELECT COUNT(*) FROM doonticket WHERE ticketID = new.ticketID AND actionID = 5) <> 0) THEN
        SET idReplace := (SELECT REPLACE(commentary, "Remplacement par: ", "") FROM doonticket WHERE ticketID = new.ticketID AND actionID = 5 ORDER BY doID DESC LIMIT 1);
    ELSE 
        SET idReplace := article;
    END IF;

    SELECT storagedQty - newQty INTO stockTest FROM stocked WHERE articleID = idReplace AND storageID = 2;
    
    IF (stockTest < 0) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Stock physique insuffisant";
    END IF;

END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `isaboutarticle`
--

DROP TABLE IF EXISTS `isaboutarticle`;
CREATE TABLE IF NOT EXISTS `isaboutarticle` (
  `articleID` varchar(10) NOT NULL,
  `purchaseID` int(11) NOT NULL,
  `articleQty` int(11) NOT NULL,
  `articleDelivQty` int(11) NOT NULL,
  PRIMARY KEY (`articleID`,`purchaseID`),
  KEY `purchaseID` (`purchaseID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `isaboutarticle`
--

INSERT INTO `isaboutarticle` (`articleID`, `purchaseID`, `articleQty`, `articleDelivQty`) VALUES
('0010001001', 1, 10, 10),
('0010001001', 9, 25, 25),
('0010001001', 10, 2, 2),
('0010001003', 16, 30, 15),
('0010001006', 5, 10, 8),
('0010002001', 3, 3, 3),
('0010002006', 6, 9, 9),
('0010002006', 16, 30, 30),
('0010003002', 14, 27, 20),
('0010003005', 11, 60, 60),
('0010003008', 18, 5, 5),
('0020001003', 13, 1, 1),
('0020002004', 4, 2, 2),
('0020002006', 1, 1, 0),
('0020002006', 8, 3, 3),
('0020002006', 15, 1, 1),
('0020003003', 15, 1, 1),
('0030002000', 7, 1, 1),
('0030002000', 16, 1, 1),
('0030004000', 15, 1, 1),
('0040001000', 1, 2, 1),
('0040001000', 4, 1, 1),
('0040001000', 13, 2, 2),
('0040003000', 15, 1, 1),
('0040004000', 12, 1, 0),
('0040004000', 19, 15, 15),
('0050001000', 19, 4, 4),
('0050002000', 4, 6, 6),
('0050002000', 12, 12, 12),
('0050002000', 15, 4, 4),
('0050002000', 19, 4, 4),
('0060001000', 2, 1, 1),
('0060001000', 4, 1, 1),
('0060001000', 8, 1, 1),
('0060001000', 13, 1, 1),
('0060001000', 17, 1, 0),
('0060001000', 18, 1, 1),
('0060001000', 19, 5, 5),
('0060002000', 12, 1, 1),
('0060002000', 19, 5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `purchase`
--

DROP TABLE IF EXISTS `purchase`;
CREATE TABLE IF NOT EXISTS `purchase` (
  `purchaseID` int(11) NOT NULL AUTO_INCREMENT,
  `payment` tinyint(4) NOT NULL,
  `purchaseDate` datetime NOT NULL,
  `purchaseInvoice` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  PRIMARY KEY (`purchaseID`),
  UNIQUE KEY `purchaseInvoice` (`purchaseInvoice`),
  KEY `customerID` (`customerID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `purchase`
--

INSERT INTO `purchase` (`purchaseID`, `payment`, `purchaseDate`, `purchaseInvoice`, `customerID`) VALUES
(1, 1, '2022-03-01 08:06:00', 1, 1),
(2, 1, '2022-03-02 10:06:00', 2, 2),
(3, 0, '2022-03-03 10:06:00', 3, 1),
(4, 1, '2022-03-04 10:06:00', 4, 3),
(5, 1, '2022-03-04 10:35:00', 5, 4),
(6, 1, '2022-03-04 11:06:00', 6, 5),
(7, 1, '2022-03-05 14:06:00', 7, 6),
(8, 1, '2022-03-05 15:22:00', 8, 6),
(9, 0, '2022-03-06 08:15:00', 9, 6),
(10, 1, '2022-03-06 10:06:00', 10, 1),
(11, 0, '2022-03-07 11:06:00', 11, 7),
(12, 1, '2022-03-09 15:06:00', 12, 8),
(13, 1, '2022-03-10 10:06:00', 13, 9),
(14, 1, '2022-03-10 22:06:00', 14, 10),
(15, 1, '2022-03-15 07:06:00', 15, 11),
(16, 1, '2022-03-16 10:06:00', 16, 12),
(17, 0, '2022-03-16 19:06:00', 17, 12),
(18, 1, '2022-03-20 23:06:00', 18, 10),
(19, 1, '2022-03-21 10:06:00', 19, 11);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `roleID` varchar(5) NOT NULL,
  `roleName` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`roleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`roleID`, `roleName`) VALUES
('ADM', 'Admin'),
('AST', 'After Sale Tech'),
('HLT', 'Hotline Tech'),
('MNG', 'Manager'),
('NO', 'No role');

-- --------------------------------------------------------

--
-- Structure de la table `stocked`
--

DROP TABLE IF EXISTS `stocked`;
CREATE TABLE IF NOT EXISTS `stocked` (
  `articleID` varchar(10) NOT NULL,
  `storageID` int(11) NOT NULL,
  `storagedQty` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`articleID`,`storageID`),
  KEY `storageID` (`storageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stocked`
--

INSERT INTO `stocked` (`articleID`, `storageID`, `storagedQty`) VALUES
('0010001001', 1, 5),
('0010001001', 2, 50),
('0010001001', 3, 0),
('0010001002', 1, 0),
('0010001002', 2, 50),
('0010001002', 3, 0),
('0010001003', 1, 0),
('0010001003', 2, 50),
('0010001003', 3, 0),
('0010001004', 1, 0),
('0010001004', 2, 50),
('0010001004', 3, 0),
('0010001005', 1, 0),
('0010001005', 2, 50),
('0010001005', 3, 0),
('0010001006', 1, 0),
('0010001006', 2, 50),
('0010001006', 3, 0),
('0010001007', 1, 0),
('0010001007', 2, 50),
('0010001007', 3, 0),
('0010001008', 1, 0),
('0010001008', 2, 50),
('0010001008', 3, 0),
('0010002001', 1, 0),
('0010002001', 2, 50),
('0010002001', 3, 0),
('0010002002', 1, 0),
('0010002002', 2, 50),
('0010002002', 3, 0),
('0010002003', 1, 0),
('0010002003', 2, 50),
('0010002003', 3, 0),
('0010002004', 1, 0),
('0010002004', 2, 50),
('0010002004', 3, 0),
('0010002005', 1, 0),
('0010002005', 2, 50),
('0010002005', 3, 0),
('0010002006', 1, 0),
('0010002006', 2, 50),
('0010002006', 3, 0),
('0010002007', 1, 0),
('0010002007', 2, 50),
('0010002007', 3, 0),
('0010002008', 1, 0),
('0010002008', 2, 50),
('0010002008', 3, 0),
('0010003001', 1, 0),
('0010003001', 2, 50),
('0010003001', 3, 0),
('0010003002', 1, 0),
('0010003002', 2, 50),
('0010003002', 3, 0),
('0010003003', 1, 0),
('0010003003', 2, 50),
('0010003003', 3, 0),
('0010003004', 1, 0),
('0010003004', 2, 50),
('0010003004', 3, 0),
('0010003005', 1, 0),
('0010003005', 2, 50),
('0010003005', 3, 0),
('0010003006', 1, 0),
('0010003006', 2, 50),
('0010003006', 3, 0),
('0010003007', 1, 0),
('0010003007', 2, 50),
('0010003007', 3, 0),
('0010003008', 1, 0),
('0010003008', 2, 50),
('0010003008', 3, 0),
('0020001003', 1, 0),
('0020001003', 2, 50),
('0020001003', 3, 0),
('0020001004', 1, 0),
('0020001004', 2, 50),
('0020001004', 3, 0),
('0020001008', 1, 0),
('0020001008', 2, 50),
('0020001008', 3, 0),
('0020002002', 1, 0),
('0020002002', 2, 50),
('0020002002', 3, 0),
('0020002003', 1, 0),
('0020002003', 2, 50),
('0020002003', 3, 0),
('0020002004', 1, 0),
('0020002004', 2, 50),
('0020002004', 3, 0),
('0020002006', 1, 0),
('0020002006', 2, 50),
('0020002006', 3, 0),
('0020003003', 1, 0),
('0020003003', 2, 50),
('0020003003', 3, 0),
('0020003004', 1, 0),
('0020003004', 2, 50),
('0020003004', 3, 0),
('0020003005', 1, 0),
('0020003005', 2, 50),
('0020003005', 3, 0),
('0030001000', 1, 0),
('0030001000', 2, 50),
('0030001000', 3, 0),
('0030002000', 1, 0),
('0030002000', 2, 50),
('0030002000', 3, 0),
('0030004000', 1, 0),
('0030004000', 2, 50),
('0030004000', 3, 0),
('0040001000', 1, 0),
('0040001000', 2, 50),
('0040001000', 3, 0),
('0040002000', 1, 0),
('0040002000', 2, 50),
('0040002000', 3, 0),
('0040003000', 1, 0),
('0040003000', 2, 50),
('0040003000', 3, 0),
('0040004000', 1, 0),
('0040004000', 2, 50),
('0040004000', 3, 0),
('0050001000', 1, 2),
('0050001000', 2, 50),
('0050001000', 3, 1),
('0050002000', 1, 0),
('0050002000', 2, 50),
('0050002000', 3, 0),
('0060001000', 1, 3),
('0060001000', 2, 50),
('0060001000', 3, 0),
('0060002000', 1, 0),
('0060002000', 2, 50),
('0060002000', 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `storage`
--

DROP TABLE IF EXISTS `storage`;
CREATE TABLE IF NOT EXISTS `storage` (
  `storageID` int(11) NOT NULL,
  `storageType` varchar(10) NOT NULL,
  PRIMARY KEY (`storageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `storage`
--

INSERT INTO `storage` (`storageID`, `storageType`) VALUES
(1, 'stock SAV'),
(2, 'stock Phys'),
(3, 'stock Rebu');

-- --------------------------------------------------------

--
-- Structure de la table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `ticketID` int(11) NOT NULL AUTO_INCREMENT,
  `ticketTypeID` varchar(5) NOT NULL,
  `purchaseID` int(11) NOT NULL,
  `closed` tinyint(1) NOT NULL,
  `urgent` tinyint(1) NOT NULL,
  `articleID` varchar(10) DEFAULT NULL,
  `treatedQty` int(11) DEFAULT NULL,
  `commentary` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ticketID`),
  KEY `purchaseID` (`purchaseID`),
  KEY `articleID` (`articleID`),
  KEY `ticketTypeID` (`ticketTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ticket`
--

INSERT INTO `ticket` (`ticketID`, `ticketTypeID`, `purchaseID`, `closed`, `urgent`, `articleID`, `treatedQty`, `commentary`) VALUES
(59, 'EP', 2, 0, 0, '0060001000', 1, ''),
(60, 'SAV', 3, 0, 0, '0010002001', 2, ''),
(61, 'NPAI', 4, 0, 0, NULL, NULL, NULL),
(64, 'NP', 5, 0, 0, NULL, 0, 'Même adresse, non présent à la livraison'),
(65, 'EC', 6, 1, 0, '0010002006', 9, 'Autre couleur'),
(66, 'EP', 7, 0, 0, '0030002000', 1, ''),
(67, 'SAV', 8, 0, 0, '0060001000', 1, NULL),
(68, 'SAV', 8, 1, 0, '0020002006', 2, ''),
(71, 'NP', 15, 0, 0, NULL, 0, ''),
(80, 'EC', 6, 0, 0, '0010002006', 9, 'Le client souhaitait la couleur \"Cuivre\" (008)'),
(81, 'NP', 11, 0, 0, NULL, 0, ''),
(82, 'NP', 14, 1, 0, NULL, 0, ''),
(83, 'EP', 17, 0, 0, '0040002000', 1, 'Télécommande manquante'),
(84, 'SAV', 9, 0, 0, '0010001001', 1, '1 Clotûre cassée'),
(85, 'SAV', 12, 0, 1, '0040004000', 1, 'Télécommande en panne'),
(86, 'SAV', 12, 0, 1, '0050001000', 2, '2 crémaillères cassées'),
(87, 'SAV', 12, 0, 1, '0050002000', 2, '2 crémaillères manquantes'),
(88, 'EC', 13, 0, 0, '0020001003', 1, 'Porte bleue marine (004) à la place de noire'),
(89, 'SAV', 13, 0, 0, '0040002000', 1, 'Télécommande manquante');

-- --------------------------------------------------------

--
-- Structure de la table `tickettype`
--

DROP TABLE IF EXISTS `tickettype`;
CREATE TABLE IF NOT EXISTS `tickettype` (
  `ticketTypeID` varchar(5) NOT NULL,
  `ticketTypeName` varchar(30) NOT NULL,
  PRIMARY KEY (`ticketTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tickettype`
--

INSERT INTO `tickettype` (`ticketTypeID`, `ticketTypeName`) VALUES
('EC', 'Erreur commande'),
('EP', 'Erreur préparation'),
('NP', 'Non présent'),
('NPAI', "N\'habite pas à adresse"),
('SAV', 'Service après-vente');

-- --------------------------------------------------------

--
-- Structure de la table `_user`
--

DROP TABLE IF EXISTS `_user`;
CREATE TABLE IF NOT EXISTS `_user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `login` varchar(16) NOT NULL,
  `password` varchar(256) NOT NULL,
  `roleID` varchar(5) NOT NULL,
  PRIMARY KEY (`userID`),
  KEY `roleID` (`roleID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `_user`
--

INSERT INTO `_user` (`userID`, `firstName`, `lastName`, `login`, `password`, `roleID`) VALUES
(3, 'ADMIN', 'Admin', 'Admin', '$2y$10$U.3x0V9dEM7inKaugIn6Ke0cJZYTPSEFIe01PF3OtiT4mD6e9L2Za', 'ADM'),
(12, 'Manager', 'MANAGER', 'Manager', '$2y$10$j/xjmnND4n5bxjuNIiDWTOkSgJjOIcSP5BNuMKg7mabQrWIROXoZm', 'MNG'),
(13, 'Astech', 'ASTECH', 'Astech', '$2y$10$geenOxDgyqBxBL5IGo3Mouptneu1v5E1V7sL8g6uKphk2kAaboVry', 'AST'),
(14, 'Hltech', 'HLTECH', 'Hltech', '$2y$10$gJ7LYP8O3i7NZFN7ZrOGi.zpO0zZrhvwvNLKozYP0sLSckScY4LCm', 'HLT');

--
-- Déclencheurs `_user`
--
DROP TRIGGER IF EXISTS `before_delete_user`;
DELIMITER $$
CREATE TRIGGER `before_delete_user` BEFORE DELETE ON `_user` FOR EACH ROW BEGIN 
	DECLARE nbadm INT DEFAULT 0;

IF(old.roleID = "ADM") THEN 
SELECT COUNT(*) INTO nbadm FROM _user WHERE roleID = "ADM";
    IF(nbadm = 1) THEN
    	SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Impossible de supprimer le dernier Admninistrateur";
    END IF;
END IF;

END
$$
DELIMITER ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_2` FOREIGN KEY (`COG`) REFERENCES `city` (`COG`),
  ADD CONSTRAINT `address_ibfk_3` FOREIGN KEY (`postCode`) REFERENCES `city` (`postCode`);

--
-- Contraintes pour la table `canreplace`
--
ALTER TABLE `canreplace`
  ADD CONSTRAINT `canreplace_ibfk_1` FOREIGN KEY (`articleID_is_replacing`) REFERENCES `article` (`articleID`),
  ADD CONSTRAINT `canreplace_ibfk_2` FOREIGN KEY (`articleID_is_replaced`) REFERENCES `article` (`articleID`);

--
-- Contraintes pour la table `composed`
--
ALTER TABLE `composed`
  ADD CONSTRAINT `composed_ibfk_1` FOREIGN KEY (`articleID_is_composed`) REFERENCES `article` (`articleID`),
  ADD CONSTRAINT `composed_ibfk_2` FOREIGN KEY (`articleID_is_composing`) REFERENCES `article` (`articleID`);

--
-- Contraintes pour la table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`addressID`) REFERENCES `address` (`addressID`);

--
-- Contraintes pour la table `doonticket`
--
ALTER TABLE `doonticket`
  ADD CONSTRAINT `doonticket_ibfk_1` FOREIGN KEY (`ticketID`) REFERENCES `ticket` (`ticketID`),
  ADD CONSTRAINT `doonticket_ibfk_2` FOREIGN KEY (`actionID`) REFERENCES `action` (`actionID`),
  ADD CONSTRAINT `doonticket_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `_user` (`userID`);

--
-- Contraintes pour la table `isaboutarticle`
--
ALTER TABLE `isaboutarticle`
  ADD CONSTRAINT `isaboutarticle_ibfk_1` FOREIGN KEY (`purchaseID`) REFERENCES `purchase` (`purchaseID`),
  ADD CONSTRAINT `isaboutarticle_ibfk_2` FOREIGN KEY (`articleID`) REFERENCES `article` (`articleID`);

--
-- Contraintes pour la table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`);

--
-- Contraintes pour la table `stocked`
--
ALTER TABLE `stocked`
  ADD CONSTRAINT `stocked_ibfk_1` FOREIGN KEY (`articleID`) REFERENCES `article` (`articleID`),
  ADD CONSTRAINT `stocked_ibfk_2` FOREIGN KEY (`storageID`) REFERENCES `storage` (`storageID`);

--
-- Contraintes pour la table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`purchaseID`) REFERENCES `purchase` (`purchaseID`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`articleID`) REFERENCES `article` (`articleID`),
  ADD CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`ticketTypeID`) REFERENCES `tickettype` (`ticketTypeID`);

--
-- Contraintes pour la table `_user`
--
ALTER TABLE `_user`
  ADD CONSTRAINT `_user_ibfk_1` FOREIGN KEY (`roleID`) REFERENCES `role` (`roleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Création des utilisateurs
--

-- Utilisateur par defaut
DROP USER IF EXISTS 'DEFAULT'@'localhost';
CREATE USER IF NOT EXISTS 'DEFAULT'@'localhost' IDENTIFIED BY 'DEFAULT';
GRANT USAGE ON *.* TO 'DEFAULT'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

-- Utilisateur administrateur
DROP USER IF EXISTS 'ADMIN'@'localhost';
CREATE USER IF NOT EXISTS 'ADMIN'@'localhost' IDENTIFIED BY 'ADMIN';
GRANT USAGE ON *.* TO 'ADMIN'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

-- Utilisateur manager
DROP USER IF EXISTS 'MANAGER'@'localhost';
CREATE USER IF NOT EXISTS 'MANAGER'@'localhost' IDENTIFIED BY 'MANAGER';
GRANT USAGE ON *.* TO 'MANAGER'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

-- Utilisateur technicien SAV
DROP USER IF EXISTS 'ASTECH'@'localhost';
CREATE USER IF NOT EXISTS 'ASTECH'@'localhost' IDENTIFIED BY 'ASTECH';
GRANT USAGE ON *.* TO 'ASTECH'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

-- Utilisateur technicien HotLine
DROP USER IF EXISTS 'HLTECH'@'localhost';
CREATE USER IF NOT EXISTS 'HLTECH'@'localhost' IDENTIFIED BY 'HLTECH';
GRANT USAGE ON *.* TO 'HLTECH'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

--
-- Création des droits sur les utilisateurs
--

-- Privilèges pour `ADMIN`@`localhost`

GRANT SELECT ON `menuiz`.* TO 'ADMIN'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `menuiz`.`_user` TO 'ADMIN'@'localhost';


-- Privilèges pour `ASTECH`@`localhost`

GRANT SELECT ON `menuiz`.* TO 'ASTECH'@'localhost';
GRANT INSERT, UPDATE, DELETE ON `menuiz`.`doonticket` TO 'ASTECH'@'localhost';
GRANT INSERT, UPDATE ON `menuiz`.`address` TO 'ASTECH'@'localhost';
GRANT INSERT, UPDATE ON `menuiz`.`ticket` TO 'ASTECH'@'localhost';
GRANT UPDATE ON `menuiz`.`stocked` TO 'ASTECH'@'localhost';
GRANT INSERT, UPDATE ON `menuiz`.`canreplace` TO 'ASTECH'@'localhost';
GRANT INSERT, UPDATE ON `menuiz`.`city` TO 'ASTECH'@'localhost';
GRANT UPDATE ON `menuiz`.`customer` TO 'ASTECH'@'localhost';
GRANT UPDATE ON `menuiz`.`_user` TO 'ASTECH'@'localhost';
GRANT EXECUTE ON PROCEDURE `menuiz`.`prc_del_todo_task` TO 'ASTECH'@'localhost';

-- Privilèges pour `HLTECH`@`localhost`

GRANT SELECT ON `menuiz`.* TO 'HLTECH'@'localhost';
GRANT UPDATE ON `menuiz`.`_user` TO 'HLTECH'@'localhost';
GRANT INSERT, UPDATE ON `menuiz`.`city` TO 'HLTECH'@'localhost';
GRANT UPDATE ON `menuiz`.`customer` TO 'HLTECH'@'localhost';
GRANT INSERT ON `menuiz`.`doonticket` TO 'HLTECH'@'localhost';
GRANT INSERT, UPDATE ON `menuiz`.`address` TO 'HLTECH'@'localhost';
GRANT UPDATE ON `menuiz`.`stocked` TO 'HLTECH'@'localhost';
GRANT INSERT ON `menuiz`.`ticket` TO 'HLTECH'@'localhost';


-- Privilèges pour `MANAGER`@`localhost`

GRANT SELECT ON `menuiz`.* TO 'MANAGER'@'localhost';
GRANT UPDATE ON `menuiz`.`stocked` TO 'MANAGER'@'localhost';
GRANT UPDATE ON `menuiz`.`ticket` TO 'MANAGER'@'localhost';
GRANT INSERT, UPDATE, DELETE ON `menuiz`.`doonticket` TO 'MANAGER'@'localhost';
GRANT UPDATE ON `menuiz`.`_user` TO 'MANAGER'@'localhost';
GRANT EXECUTE ON PROCEDURE `menuiz`.`prc_del_todo_task` TO 'MANAGER'@'localhost';

-- Privilèges pour `DEFAULT`@`localhost`
GRANT SELECT ON `menuiz`.`_user` TO 'DEFAULT'@'localhost';
GRANT SELECT ON `menuiz`.`role` TO 'DEFAULT'@'localhost';