-- MariaDB dump 10.19  Distrib 10.9.4-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: sae
-- ------------------------------------------------------
-- Server version	10.10.2-MariaDB-1:10.10.2+maria~ubu2204

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `api_token`
--

DROP TABLE IF EXISTS `api_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_token` (
  `id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contrainte`
--

DROP TABLE IF EXISTS `contrainte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrainte` (
  `id_contrainte` int(11) NOT NULL,
  `heure_debut_contrainte` datetime DEFAULT NULL,
  `heure_fin_contrainte` datetime DEFAULT NULL,
  `id_enseignant` int(11) NOT NULL,
  PRIMARY KEY (`id_contrainte`),
  KEY `id_enseignant` (`id_enseignant`),
  CONSTRAINT `contrainte_ibfk_1` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignant` (`id_enseignant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cours`
--

DROP TABLE IF EXISTS `cours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cours` (
  `id_cours` varchar(50) NOT NULL,
  `heure_debut_cours` datetime DEFAULT NULL,
  `heure_fin_cours` datetime DEFAULT NULL,
  `type_cours` varchar(50) DEFAULT NULL,
  `id_regroupement` int(11) NOT NULL,
  `id_matière` int(11) NOT NULL,
  `id_enseignant` int(11) NOT NULL,
  `id_salle` varchar(50) NOT NULL,
  PRIMARY KEY (`id_cours`),
  KEY `id_regroupement` (`id_regroupement`),
  KEY `id_matière` (`id_matière`),
  KEY `id_enseignant` (`id_enseignant`),
  KEY `id_salle` (`id_salle`),
  CONSTRAINT `cours_ibfk_1` FOREIGN KEY (`id_regroupement`) REFERENCES `regroupement` (`id_regroupement`),
  CONSTRAINT `cours_ibfk_2` FOREIGN KEY (`id_matière`) REFERENCES `matière` (`id_matière`),
  CONSTRAINT `cours_ibfk_3` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignant` (`id_enseignant`),
  CONSTRAINT `cours_ibfk_4` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enseignant`
--

DROP TABLE IF EXISTS `enseignant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enseignant` (
  `id_enseignant` int(11) NOT NULL,
  `prenom_enseignant` varchar(50) DEFAULT NULL,
  `nom_enseignant` varchar(50) DEFAULT NULL,
  `mail_enseignant` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_enseignant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etudiant` (
  `id_etudiant` int(11) NOT NULL,
  `prenom_etudiant` varchar(50) DEFAULT NULL,
  `nom_etudaint` varchar(50) DEFAULT NULL,
  `mail_etudiant` varchar(50) DEFAULT NULL,
  `id_regroupement` int(11) NOT NULL,
  PRIMARY KEY (`id_etudiant`),
  KEY `id_regroupement` (`id_regroupement`),
  CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`id_regroupement`) REFERENCES `regroupement` (`id_regroupement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `etudie`
--

DROP TABLE IF EXISTS `etudie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etudie` (
  `id_matière` int(11) NOT NULL,
  `id_parcours` int(11) NOT NULL,
  PRIMARY KEY (`id_matière`,`id_parcours`),
  KEY `id_parcours` (`id_parcours`),
  CONSTRAINT `etudie_ibfk_1` FOREIGN KEY (`id_matière`) REFERENCES `matière` (`id_matière`),
  CONSTRAINT `etudie_ibfk_2` FOREIGN KEY (`id_parcours`) REFERENCES `parcours` (`id_parcours`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `matière`
--

DROP TABLE IF EXISTS `matière`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matière` (
  `id_matière` int(11) NOT NULL,
  `nom_matiere` varchar(50) DEFAULT NULL,
  `nbrheures_matiere` double DEFAULT NULL,
  PRIMARY KEY (`id_matière`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `parcours`
--

DROP TABLE IF EXISTS `parcours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parcours` (
  `id_parcours` int(11) NOT NULL,
  `nom_parcours` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_parcours`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `regroupement`
--

DROP TABLE IF EXISTS `regroupement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regroupement` (
  `id_regroupement` int(11) NOT NULL,
  `nom_regroupement` varchar(50) DEFAULT NULL,
  `nbretudiant` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `groupe_parent` int(11) DEFAULT NULL,
  `id_parcours` int(11) NOT NULL,
  PRIMARY KEY (`id_regroupement`),
  KEY `id_parcours` (`id_parcours`),
  CONSTRAINT `regroupement_ibfk_1` FOREIGN KEY (`id_parcours`) REFERENCES `parcours` (`id_parcours`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `salle`
--

DROP TABLE IF EXISTS `salle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salle` (
  `id_salle` varchar(50) NOT NULL,
  `capacite_salle` int(11) DEFAULT NULL,
  `disponibilite_salle` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_salle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_id_uindex` (`id`),
  UNIQUE KEY `token_token_uindex` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `privilege` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-14 19:55:38
