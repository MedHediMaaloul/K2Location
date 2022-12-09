-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 12 oct. 2020 à 16:43
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `k2location`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `cin` varchar(255) NOT NULL,
  `num_siret` varchar(255) NOT NULL,
  `permis` varchar(255) NOT NULL,
  `kbis` varchar(255) NOT NULL,
  `rib` varchar(255) NOT NULL,
  `nom_societe` varchar(255) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `contrat`
--

DROP TABLE IF EXISTS `contrat`;
CREATE TABLE IF NOT EXISTS `contrat` (
  `id_contrat` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `id_voiture` int(11) NOT NULL,
  `id_materiel` int(11) NOT NULL,
  `date_contrat` int(11) NOT NULL,
  `type_location` int(11) NOT NULL,
  `num_contrat` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `prix` double NOT NULL,
  `assurance` varchar(255) NOT NULL,
  `mode_de_paiement` varchar(255) NOT NULL,
  `nom_client` varchar(255) NOT NULL,
  `adresse_client` varchar(255) NOT NULL,
  `tel_client` varchar(255) NOT NULL,
  `siret_client` varchar(255) NOT NULL,
  `cin_cilent` varchar(255) NOT NULL,
  `kbis_client` varchar(255) NOT NULL,
  `rib_client` varchar(255) NOT NULL,
  `permis_client` varchar(255) NOT NULL,
  `marque_voiture` varchar(255) NOT NULL,
  `modele_voiture` varchar(255) NOT NULL,
  `pimm_voiture` varchar(255) NOT NULL,
  `categorie_materiel` varchar(255) NOT NULL,
  `numserie_materiel` varchar(255) NOT NULL,
  PRIMARY KEY (`id_contrat`),
  KEY `id_client` (`id_client`),
  KEY `id_voiture` (`id_voiture`),
  KEY `id_materiel` (`id_materiel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `entretien`
--

DROP TABLE IF EXISTS `entretien`;
CREATE TABLE IF NOT EXISTS `entretien` (
  `id_entretien` int(11) NOT NULL AUTO_INCREMENT,
  `id_voiture` int(11) NOT NULL,
  `id_materiel` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  `marque_voiture` varchar(255) NOT NULL,
  `modele_voiture` varchar(255) NOT NULL,
  `km_voiture` varchar(255) NOT NULL,
  `pimm_voiture` varchar(255) NOT NULL,
  `categorie_materiel` varchar(255) NOT NULL,
  `date_achat` date NOT NULL,
  `num_serie` varchar(255) NOT NULL,
  PRIMARY KEY (`id_entretien`),
  KEY `id_voiture` (`id_voiture`),
  KEY `id_materiel` (`id_materiel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

DROP TABLE IF EXISTS `materiel`;
CREATE TABLE IF NOT EXISTS `materiel` (
  `id_materiel` int(11) NOT NULL AUTO_INCREMENT,
  `nom_materiel` varchar(255) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `fournisseur` varchar(255) NOT NULL,
  `date_achat` date NOT NULL,
  `num_serie` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  PRIMARY KEY (`id_materiel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

DROP TABLE IF EXISTS `voiture`;
CREATE TABLE IF NOT EXISTS `voiture` (
  `id_voiture` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `pimm` varchar(255) NOT NULL,
  `marque` varchar(255) NOT NULL,
  `modele` varchar(255) NOT NULL,
  `fournisseur` varchar(255) NOT NULL,
  `km` varchar(255) NOT NULL,
  `date_achat` date NOT NULL,
  `dispo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_voiture`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contrat`
--
ALTER TABLE `contrat`
  ADD CONSTRAINT `contrat_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `contrat_ibfk_2` FOREIGN KEY (`id_materiel`) REFERENCES `materiel` (`id_materiel`),
  ADD CONSTRAINT `contrat_ibfk_3` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);

--
-- Contraintes pour la table `entretien`
--
ALTER TABLE `entretien`
  ADD CONSTRAINT `entretien_ibfk_1` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`),
  ADD CONSTRAINT `entretien_ibfk_2` FOREIGN KEY (`id_materiel`) REFERENCES `materiel` (`id_materiel`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
