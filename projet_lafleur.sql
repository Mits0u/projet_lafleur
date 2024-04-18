-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 18 avr. 2024 à 11:46
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
-- Structure de la table `categorie_fleur`
--

DROP TABLE IF EXISTS `categorie_fleur`;
CREATE TABLE IF NOT EXISTS `categorie_fleur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `prix_commande` float DEFAULT NULL,
  `id_panier` int DEFAULT NULL,
  `adresse_livraison` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_panier` (`id_panier`),
  KEY `adresse_livraison` (`adresse_livraison`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `fleur`
--

DROP TABLE IF EXISTS `fleur`;
CREATE TABLE IF NOT EXISTS `fleur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `prix` float DEFAULT NULL,
  `categorie` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categorie` (`categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `fleur_junction_panier_fleur`
--

DROP TABLE IF EXISTS `fleur_junction_panier_fleur`;
CREATE TABLE IF NOT EXISTS `fleur_junction_panier_fleur` (
  `id_fleur` int NOT NULL,
  `id_junction_panier_fleur` int NOT NULL,
  PRIMARY KEY (`id_fleur`,`id_junction_panier_fleur`),
  KEY `id_junction_panier_fleur` (`id_junction_panier_fleur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `junction_panier_fleur`
--

DROP TABLE IF EXISTS `junction_panier_fleur`;
CREATE TABLE IF NOT EXISTS `junction_panier_fleur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_panier` int DEFAULT NULL,
  `id_fleur` int DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_panier` (`id_panier`),
  KEY `id_fleur` (`id_fleur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prix_panier` float DEFAULT NULL,
  `nombre_articles` int DEFAULT NULL,
  `date_panier` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `panier_junction_panier_fleur`
--

DROP TABLE IF EXISTS `panier_junction_panier_fleur`;
CREATE TABLE IF NOT EXISTS `panier_junction_panier_fleur` (
  `id_panier` int NOT NULL,
  `id_junction_panier_fleur` int NOT NULL,
  PRIMARY KEY (`id_panier`,`id_junction_panier_fleur`),
  KEY `id_junction_panier_fleur` (`id_junction_panier_fleur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `type_compte`
--

DROP TABLE IF EXISTS `type_compte`;
CREATE TABLE IF NOT EXISTS `type_compte` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_compte_id` int DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `date_creation` date DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `code_postal` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_compte_id` (`type_compte_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `type_compte_id`, `nom`, `prenom`, `email`, `mot_de_passe`, `date_creation`, `adresse`, `code_postal`) VALUES
(1, NULL, 'Poltron', 'Steven', 'stpoltron@stpbb.org', '$2y$10$5c8dw8K.pKvtDRlxhDF6s.9skh7i1JpMwRhKieVLiVoJJiAo7OC9u', '2024-04-18', NULL, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`id_panier`) REFERENCES `panier` (`id`),
  ADD CONSTRAINT `commande_ibfk_3` FOREIGN KEY (`adresse_livraison`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `fleur`
--
ALTER TABLE `fleur`
  ADD CONSTRAINT `fleur_ibfk_1` FOREIGN KEY (`categorie`) REFERENCES `categorie_fleur` (`id`);

--
-- Contraintes pour la table `fleur_junction_panier_fleur`
--
ALTER TABLE `fleur_junction_panier_fleur`
  ADD CONSTRAINT `fleur_junction_panier_fleur_ibfk_1` FOREIGN KEY (`id_fleur`) REFERENCES `fleur` (`id`),
  ADD CONSTRAINT `fleur_junction_panier_fleur_ibfk_2` FOREIGN KEY (`id_junction_panier_fleur`) REFERENCES `junction_panier_fleur` (`id`);

--
-- Contraintes pour la table `junction_panier_fleur`
--
ALTER TABLE `junction_panier_fleur`
  ADD CONSTRAINT `junction_panier_fleur_ibfk_1` FOREIGN KEY (`id_panier`) REFERENCES `panier` (`id`),
  ADD CONSTRAINT `junction_panier_fleur_ibfk_2` FOREIGN KEY (`id_fleur`) REFERENCES `fleur` (`id`);

--
-- Contraintes pour la table `panier_junction_panier_fleur`
--
ALTER TABLE `panier_junction_panier_fleur`
  ADD CONSTRAINT `panier_junction_panier_fleur_ibfk_1` FOREIGN KEY (`id_panier`) REFERENCES `panier` (`id`),
  ADD CONSTRAINT `panier_junction_panier_fleur_ibfk_2` FOREIGN KEY (`id_junction_panier_fleur`) REFERENCES `junction_panier_fleur` (`id`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`type_compte_id`) REFERENCES `type_compte` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
