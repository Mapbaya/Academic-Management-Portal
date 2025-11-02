-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 02 nov. 2025 à 15:46
-- Version du serveur : 12.0.2-MariaDB
-- Version de PHP : 8.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `r301project`
--

-- --------------------------------------------------------

--
-- Structure de la table `mp_cours`
--

CREATE TABLE `mp_cours` (
  `rowid` int(11) NOT NULL,
  `date_cours` date NOT NULL,
  `fk_matiere` int(11) NOT NULL,
  `fk_enseignant` int(11) NOT NULL,
  `groupe_td` varchar(10) DEFAULT NULL,
  `groupe_tp` varchar(10) DEFAULT NULL,
  `salle` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mp_cours`
--

INSERT INTO `mp_cours` (`rowid`, `date_cours`, `fk_matiere`, `fk_enseignant`, `groupe_td`, `groupe_tp`, `salle`) VALUES
(1, '2025-03-20', 1, 3, '1', 'A', '132'),
(2, '2026-01-28', 2, 4, '2', 'E', '126'),
(3, '2026-11-12', 3, 5, '3', 'A', '144');

-- --------------------------------------------------------

--
-- Structure de la table `mp_enseignants`
--

CREATE TABLE `mp_enseignants` (
  `rowid` int(11) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `birthday` date DEFAULT NULL,
  `adress` text DEFAULT NULL,
  `zipcode` varchar(8) DEFAULT NULL,
  `town` varchar(32) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `mp_enseignants`
--

INSERT INTO `mp_enseignants` (`rowid`, `firstname`, `lastname`, `birthday`, `adress`, `zipcode`, `town`, `fk_user`) VALUES
(2, 'Kevin', 'Guerrier', '1992-11-02', '23 Rue de Nantes', '75019', 'Paris', 4),
(3, 'Imene', 'Berhani', '2003-10-18', '38 rue de Macron', '59200', 'Roubaix', 6),
(4, 'Bryan', 'Gualier', '2000-05-28', '72 Rue Marie Curie', '27780', 'Garennes-Sur-Eure', 7),
(5, 'Vincent', 'Paco', '1983-03-01', '2 Rue de la Croix', '34080', 'Montpellier', 11);

-- --------------------------------------------------------

--
-- Structure de la table `mp_etudiants`
--

CREATE TABLE `mp_etudiants` (
  `rowid` int(11) NOT NULL,
  `numetu` varchar(16) DEFAULT NULL,
  `firstname` varchar(64) DEFAULT NULL,
  `lastname` varchar(64) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `diploma` varchar(16) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `td` varchar(2) DEFAULT NULL,
  `tp` varchar(2) DEFAULT NULL,
  `adress` text DEFAULT NULL,
  `zipcode` varchar(8) DEFAULT NULL,
  `town` varchar(32) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mp_etudiants`
--

INSERT INTO `mp_etudiants` (`rowid`, `numetu`, `firstname`, `lastname`, `birthday`, `diploma`, `year`, `td`, `tp`, `adress`, `zipcode`, `town`, `fk_user`) VALUES
(3, '291819910', 'Maya', 'Nali', '2003-09-01', 'Licence Pro', 2021, '2', 'B', '38 rue de Macron', '92100', 'Roubaix', 8),
(4, '234554376754', 'Cloé', 'Marechal', '2004-03-28', 'BUT', 2020, '3', 'B', '12 rue donald trump', '92250', 'Saint Denis', 9),
(5, '20299292929', 'Maua', 'Cbaliu', '2003-03-03', 'BUT', 2001, '1', 'b', '38 Rue de la Faye', '25770', 'Serre-Les-Sapins', 10),
(6, '10229101', 'Rémi', 'Delat', '2000-07-23', 'Licence Pro', 2025, '1', 'b', 'Rue Ordener', '75018', 'Paris', 12),
(7, '02829190', 'Rania', 'Verbaudet', '2002-11-03', 'BUT', 2024, '1', 'B', 'Rue Frederic Chopin', '83250', 'La Londe-Les-Maures', 13);

-- --------------------------------------------------------

--
-- Structure de la table `mp_matieres`
--

CREATE TABLE `mp_matieres` (
  `rowid` int(11) NOT NULL,
  `num_matiere` varchar(16) NOT NULL,
  `name` varchar(100) NOT NULL,
  `coef` float DEFAULT 1,
  `fk_module` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mp_matieres`
--

INSERT INTO `mp_matieres` (`rowid`, `num_matiere`, `name`, `coef`, `fk_module`) VALUES
(1, '23', 'Développement', 1, 1),
(2, '02', 'Programmation', 5, 1),
(3, '08', 'Gestion de projet', 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `mp_modules`
--

CREATE TABLE `mp_modules` (
  `rowid` int(11) NOT NULL,
  `num_module` varchar(16) NOT NULL,
  `name` varchar(100) NOT NULL,
  `coef` float DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mp_modules`
--

INSERT INTO `mp_modules` (`rowid`, `num_module`, `name`, `coef`) VALUES
(1, 'M658', 'Informatique Fondamental', 1),
(2, 'M593', 'Travail d\'équipe', 1);

-- --------------------------------------------------------

--
-- Structure de la table `mp_users`
--

CREATE TABLE `mp_users` (
  `rowid` int(11) NOT NULL,
  `username` varchar(64) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `firstname` varchar(64) DEFAULT NULL,
  `lastname` varchar(64) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mp_users`
--

INSERT INTO `mp_users` (`rowid`, `username`, `password`, `firstname`, `lastname`, `date_created`, `date_updated`, `admin`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', NULL, NULL, '2025-10-01 17:08:24', '2025-10-01 17:08:24', 1),
(4, 'kevin', '9d5e3ecdeb4cdb7acfd63075ae046672', 'kevin', 'guerrier', '2025-10-31 11:02:16', '2025-10-31 11:02:16', 0),
(6, 'imene', '73866e3b300bee44b14a6c79c4583074', 'Imene', 'Berhani', '2025-10-31 16:08:42', '2025-10-31 16:08:42', 0),
(7, 'bryan', '7d4ef62de50874a4db33e6da3ff79f75', 'Bryan', 'Gualier', '2025-10-31 19:32:41', '2025-10-31 19:32:41', 0),
(8, 'maya', 'b2693d9c2124f3ca9547b897794ac6a1', 'Maya', 'Nali', '2025-10-31 19:34:02', '2025-10-31 19:34:02', 0),
(9, 'Cloé', 'ef59a4d931bf59d90a04e68857fdc995', 'Cloé', 'marechal', '2025-11-01 12:31:05', '2025-11-01 12:31:05', 0),
(10, 'maua', '7c4c861680a0211c85d3e509f5a546da', 'Maua', 'Cbaliu', '2025-11-02 13:29:55', '2025-11-02 13:29:55', 0),
(11, 'vincent', 'b15ab3f829f0f897fe507ef548741afb', 'Vincent', 'Paco', '2025-11-02 14:31:30', '2025-11-02 14:31:30', 0),
(12, 'remi', 'f1067e7173c7b9e6714ec7c88cf04bb1', 'Rémi', 'Delat', '2025-11-02 14:33:00', '2025-11-02 14:33:00', 0),
(13, 'rania', 'd6bd4288dbcf5d2ae2053a35389e8c56', 'Rania', 'Verbaudet', '2025-11-02 15:17:51', '2025-11-02 15:17:51', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `mp_cours`
--
ALTER TABLE `mp_cours`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `fk_matiere` (`fk_matiere`),
  ADD KEY `fk_enseignant` (`fk_enseignant`);

--
-- Index pour la table `mp_enseignants`
--
ALTER TABLE `mp_enseignants`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `fk_user` (`fk_user`);

--
-- Index pour la table `mp_etudiants`
--
ALTER TABLE `mp_etudiants`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `numetu` (`numetu`),
  ADD KEY `fk_user` (`fk_user`);

--
-- Index pour la table `mp_matieres`
--
ALTER TABLE `mp_matieres`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `fk_module` (`fk_module`);

--
-- Index pour la table `mp_modules`
--
ALTER TABLE `mp_modules`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `mp_users`
--
ALTER TABLE `mp_users`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `mp_cours`
--
ALTER TABLE `mp_cours`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `mp_enseignants`
--
ALTER TABLE `mp_enseignants`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `mp_etudiants`
--
ALTER TABLE `mp_etudiants`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `mp_matieres`
--
ALTER TABLE `mp_matieres`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `mp_modules`
--
ALTER TABLE `mp_modules`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `mp_users`
--
ALTER TABLE `mp_users`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `mp_cours`
--
ALTER TABLE `mp_cours`
  ADD CONSTRAINT `mp_cours_ibfk_1` FOREIGN KEY (`fk_matiere`) REFERENCES `mp_matieres` (`rowid`),
  ADD CONSTRAINT `mp_cours_ibfk_2` FOREIGN KEY (`fk_enseignant`) REFERENCES `mp_enseignants` (`rowid`);

--
-- Contraintes pour la table `mp_enseignants`
--
ALTER TABLE `mp_enseignants`
  ADD CONSTRAINT `mp_enseignants_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `mp_users` (`rowid`) ON DELETE CASCADE;

--
-- Contraintes pour la table `mp_etudiants`
--
ALTER TABLE `mp_etudiants`
  ADD CONSTRAINT `mp_etudiants_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `mp_users` (`rowid`);

--
-- Contraintes pour la table `mp_matieres`
--
ALTER TABLE `mp_matieres`
  ADD CONSTRAINT `mp_matieres_ibfk_1` FOREIGN KEY (`fk_module`) REFERENCES `mp_modules` (`rowid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;