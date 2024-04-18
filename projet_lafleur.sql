-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 18 avr. 2024 à 08:44
-- Version du serveur : 8.0.31
-- Version de PHP : 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_lafleur`
--

-- --------------------------------------------------------

--
-- Structure de la table `account_type`
--

DROP TABLE IF EXISTS `account_type`;
CREATE TABLE IF NOT EXISTS `account_type` (
  `id` int NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL,
  `cart_price` float DEFAULT NULL,
  `number_of_articles` int DEFAULT NULL,
  `cart_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cart_junction_cart_flower`
--

DROP TABLE IF EXISTS `cart_junction_cart_flower`;
CREATE TABLE IF NOT EXISTS `cart_junction_cart_flower` (
  `cart_id` int NOT NULL,
  `junction_cart_flower_id_cart` int NOT NULL,
  PRIMARY KEY (`cart_id`,`junction_cart_flower_id_cart`),
  KEY `junction_cart_flower_id_cart` (`junction_cart_flower_id_cart`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `command`
--

DROP TABLE IF EXISTS `command`;
CREATE TABLE IF NOT EXISTS `command` (
  `id` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `command_price` float DEFAULT NULL,
  `cart_id` int DEFAULT NULL,
  `delivery_adress` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `cart_id` (`cart_id`),
  KEY `delivery_adress` (`delivery_adress`(250))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `flower`
--

DROP TABLE IF EXISTS `flower`;
CREATE TABLE IF NOT EXISTS `flower` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `price` float DEFAULT NULL,
  `category` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `flower_category`
--

DROP TABLE IF EXISTS `flower_category`;
CREATE TABLE IF NOT EXISTS `flower_category` (
  `id` int NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `flower_junction_cart_flower`
--

DROP TABLE IF EXISTS `flower_junction_cart_flower`;
CREATE TABLE IF NOT EXISTS `flower_junction_cart_flower` (
  `flower_id` int NOT NULL,
  `junction_cart_flower_id_flower` int NOT NULL,
  PRIMARY KEY (`flower_id`,`junction_cart_flower_id_flower`),
  KEY `junction_cart_flower_id_flower` (`junction_cart_flower_id_flower`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `junction_cart_flower`
--

DROP TABLE IF EXISTS `junction_cart_flower`;
CREATE TABLE IF NOT EXISTS `junction_cart_flower` (
  `id_cart` int DEFAULT NULL,
  `id_flower` int DEFAULT NULL,
  `quantity` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL,
  `account_type` int DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `forename` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `age` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `adress` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_type` (`account_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `account_type`, `lastname`, `forename`, `email`, `password`, `age`, `created_at`, `adress`) VALUES
(0, 0, NULL, NULL, 'stpoltron@stpbb.org', '$2y$10$c2I4f8HyPgZskC0lfXX0o.zMZQZjQNbwKQHXsr.i3vEWup8FN9J6i', NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
