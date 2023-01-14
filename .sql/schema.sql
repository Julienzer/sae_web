-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 14 jan. 2023 à 17:41
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sae`
--

-- --------------------------------------------------------

--
-- Structure de la table `contrainte`
--

CREATE TABLE `contrainte` (
  `id_contrainte` int(11) NOT NULL,
  `heure_debut_contrainte` datetime DEFAULT NULL,
  `heure_fin_contrainte` datetime DEFAULT NULL,
  `id_enseignant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id_cours` varchar(50) NOT NULL,
  `heure_debut_cours` datetime DEFAULT NULL,
  `heure_fin_cours` datetime DEFAULT NULL,
  `type_cours` varchar(50) DEFAULT NULL,
  `id_regroupement` int(11) NOT NULL,
  `id_matière` int(11) NOT NULL,
  `id_enseignant` int(11) NOT NULL,
  `id_salle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id_cours`, `heure_debut_cours`, `heure_fin_cours`, `type_cours`, `id_regroupement`, `id_matière`, `id_enseignant`, `id_salle`) VALUES
('1', '2023-01-15 14:00:00', '2023-01-15 16:00:00', 'TD', 2, 3, 1, '101'),
('2', '2023-03-15 13:00:00', '2023-03-15 14:00:00', 'Amphi', 1, 4, 1, '100'),
('3', '2023-03-15 08:00:00', '2023-03-15 10:00:00', 'TD', 3, 2, 4, '106');

-- --------------------------------------------------------

--
-- Structure de la table `enseignant`
--

CREATE TABLE `enseignant` (
  `id_enseignant` int(11) NOT NULL,
  `prenom_enseignant` varchar(50) DEFAULT NULL,
  `nom_enseignant` varchar(50) DEFAULT NULL,
  `mail_enseignant` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `enseignant`
--

INSERT INTO `enseignant` (`id_enseignant`, `prenom_enseignant`, `nom_enseignant`, `mail_enseignant`) VALUES
(1, 'Jean-Baptiste', 'Masson', 'Jb.masson@gmail.com'),
(2, 'Amel', 'Sghaier', 'a.sghaier@gmail.com'),
(3, 'Claude', 'Pegard', 'claude.pegard@gmail.com'),
(4, 'Christophe', 'Logé', 'christophe.loge@gmail.com'),
(5, 'Laurent', 'Herjean', 'laurent.hearjean@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `id_etudiant` int(11) NOT NULL,
  `prenom_etudiant` varchar(50) DEFAULT NULL,
  `nom_etudaint` varchar(50) DEFAULT NULL,
  `mail_etudiant` varchar(50) DEFAULT NULL,
  `id_regroupement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id_etudiant`, `prenom_etudiant`, `nom_etudaint`, `mail_etudiant`, `id_regroupement`) VALUES
(1, 'Julien', 'Durieux', 'ju.durieux@gmail.com', 2),
(2, 'Raphael', 'Rault', 'raph.rault@gmail.com', 2),
(3, 'Théo', 'Quennehen', 't.quennehen@gmail.com', 5);

-- --------------------------------------------------------

--
-- Structure de la table `etudie`
--

CREATE TABLE `etudie` (
  `id_matière` int(11) NOT NULL,
  `id_parcours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `matière`
--

CREATE TABLE `matière` (
  `id_matière` int(11) NOT NULL,
  `nom_matiere` varchar(50) DEFAULT NULL,
  `nbrheures_matiere` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `matière`
--

INSERT INTO `matière` (`id_matière`, `nom_matiere`, `nbrheures_matiere`) VALUES
(1, 'SQL', 20),
(2, 'Qualité Dev', 20),
(3, 'Anglais', 20),
(4, 'Probabilitées', 20);

-- --------------------------------------------------------

--
-- Structure de la table `parcours`
--

CREATE TABLE `parcours` (
  `id_parcours` int(11) NOT NULL,
  `nom_parcours` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `parcours`
--

INSERT INTO `parcours` (`id_parcours`, `nom_parcours`) VALUES
(1, 'Base de donnée'),
(2, 'Développement'),
(3, 'Réseau');

-- --------------------------------------------------------

--
-- Structure de la table `regroupement`
--

CREATE TABLE `regroupement` (
  `id_regroupement` int(11) NOT NULL,
  `nom_regroupement` varchar(50) DEFAULT NULL,
  `nbretudiant` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `groupe_parent` int(11) DEFAULT NULL,
  `id_parcours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `regroupement`
--

INSERT INTO `regroupement` (`id_regroupement`, `nom_regroupement`, `nbretudiant`, `type`, `groupe_parent`, `id_parcours`) VALUES
(1, 'PromoInfo2A', 100, 'Promotion', 0, 2),
(2, 'GrpA', 32, 'Groupe', 1, 2),
(3, 'GrpA-1', 15, 'Demi-Groupe', 2, 2),
(4, 'GrpA-2', 17, 'Demi-Groupe', 2, 2),
(5, 'GrpB', 30, 'Groupe', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `id_salle` varchar(50) NOT NULL,
  `capacite_salle` int(11) DEFAULT NULL,
  `disponibilite_salle` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `capacite_salle`, `disponibilite_salle`) VALUES
('100', 120, 1),
('101', 32, 1),
('103', 32, 1),
('106', 15, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `privilege` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`username`, `password`, `id_user`, `privilege`) VALUES
('julien', 'luigijtm', 1, 'admin'),
('theo', 'erwanjtm', 2, 'etudiant\r\n'),
('raphael', 'aurelienjtm', 3, 'enseignant');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `contrainte`
--
ALTER TABLE `contrainte`
  ADD PRIMARY KEY (`id_contrainte`),
  ADD KEY `id_enseignant` (`id_enseignant`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id_cours`),
  ADD KEY `id_regroupement` (`id_regroupement`),
  ADD KEY `id_matière` (`id_matière`),
  ADD KEY `id_enseignant` (`id_enseignant`),
  ADD KEY `id_salle` (`id_salle`);

--
-- Index pour la table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`id_enseignant`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id_etudiant`),
  ADD KEY `id_regroupement` (`id_regroupement`);

--
-- Index pour la table `etudie`
--
ALTER TABLE `etudie`
  ADD PRIMARY KEY (`id_matière`,`id_parcours`),
  ADD KEY `id_parcours` (`id_parcours`);

--
-- Index pour la table `matière`
--
ALTER TABLE `matière`
  ADD PRIMARY KEY (`id_matière`);

--
-- Index pour la table `parcours`
--
ALTER TABLE `parcours`
  ADD PRIMARY KEY (`id_parcours`);

--
-- Index pour la table `regroupement`
--
ALTER TABLE `regroupement`
  ADD PRIMARY KEY (`id_regroupement`),
  ADD KEY `id_parcours` (`id_parcours`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`id_salle`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contrainte`
--
ALTER TABLE `contrainte`
  ADD CONSTRAINT `contrainte_ibfk_1` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignant` (`id_enseignant`);

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `cours_ibfk_1` FOREIGN KEY (`id_regroupement`) REFERENCES `regroupement` (`id_regroupement`),
  ADD CONSTRAINT `cours_ibfk_2` FOREIGN KEY (`id_matière`) REFERENCES `matière` (`id_matière`),
  ADD CONSTRAINT `cours_ibfk_3` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignant` (`id_enseignant`),
  ADD CONSTRAINT `cours_ibfk_4` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`id_regroupement`) REFERENCES `regroupement` (`id_regroupement`);

--
-- Contraintes pour la table `etudie`
--
ALTER TABLE `etudie`
  ADD CONSTRAINT `etudie_ibfk_1` FOREIGN KEY (`id_matière`) REFERENCES `matière` (`id_matière`),
  ADD CONSTRAINT `etudie_ibfk_2` FOREIGN KEY (`id_parcours`) REFERENCES `parcours` (`id_parcours`);

--
-- Contraintes pour la table `regroupement`
--
ALTER TABLE `regroupement`
  ADD CONSTRAINT `regroupement_ibfk_1` FOREIGN KEY (`id_parcours`) REFERENCES `parcours` (`id_parcours`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
