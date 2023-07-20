-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2023 at 09:03 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stampee`
--

-- --------------------------------------------------------

--
-- Table structure for table `enchere`
--

CREATE TABLE `enchere` (
  `enchere_id` bigint(20) NOT NULL,
  `id_vendeur` int(11) NOT NULL,
  `id_timbre` bigint(20) NOT NULL,
  `enchere_date_debut` datetime NOT NULL,
  `enchere_date_fin` datetime NOT NULL,
  `enchere_cdc_lord` tinyint(1) NOT NULL DEFAULT 0,
  `enchere_prix_plancher` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enchere`
--

INSERT INTO `enchere` (`enchere_id`, `id_vendeur`, `id_timbre`, `enchere_date_debut`, `enchere_date_fin`, `enchere_cdc_lord`, `enchere_prix_plancher`) VALUES
(1, 1, 1, '2023-07-08 09:00:00', '2023-07-23 18:00:00', 1, 10.00),
(2, 2, 2, '2023-07-08 09:00:00', '2023-07-23 18:00:00', 0, 20.00),
(3, 3, 3, '2023-07-08 09:00:00', '2023-07-23 18:00:00', 0, 30.00),
(4, 4, 4, '2023-07-08 09:00:00', '2023-07-23 18:00:00', 0, 40.00),
(5, 5, 5, '2023-07-08 09:00:00', '2023-07-23 18:00:00', 0, 50.00),
(6, 6, 6, '2023-07-08 09:00:00', '2023-07-23 18:00:00', 0, 60.00),
(7, 7, 7, '2023-07-08 09:00:00', '2023-07-23 18:00:00', 0, 70.00),
(8, 8, 8, '2023-07-08 09:00:00', '2023-07-23 18:00:00', 0, 80.00),
(9, 9, 9, '2023-07-08 09:00:00', '2023-07-23 18:00:00', 0, 90.00),
(10, 10, 10, '2023-07-08 09:00:00', '2023-07-23 18:00:00', 0, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `favori`
--

CREATE TABLE `favori` (
  `favori_id` bigint(20) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_enchere` bigint(20) NOT NULL,
  `favori_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favori`
--

INSERT INTO `favori` (`favori_id`, `id_utilisateur`, `id_enchere`, `favori_date`) VALUES
(1, 1, 1, '2022-06-01 04:00:00'),
(2, 2, 2, '2022-06-02 04:00:00'),
(3, 3, 3, '2022-06-03 04:00:00'),
(4, 4, 4, '2022-06-04 04:00:00'),
(5, 5, 5, '2022-06-05 04:00:00'),
(6, 6, 6, '2022-06-06 04:00:00'),
(7, 7, 7, '2022-06-07 04:00:00'),
(8, 8, 8, '2022-06-08 04:00:00'),
(9, 9, 9, '2022-06-09 04:00:00'),
(10, 10, 10, '2022-06-10 04:00:00'),
(36, 11, 3, '2023-07-18 22:32:00'),
(38, 11, 7, '2023-07-18 22:36:41'),
(39, 11, 5, '2023-07-18 22:36:45'),
(40, 11, 1, '2023-07-18 22:38:24');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `image_id` bigint(20) NOT NULL,
  `id_timbre` bigint(20) NOT NULL,
  `image_fichier` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`image_id`, `id_timbre`, `image_fichier`) VALUES
(1, 1, 'image1_1'),
(2, 1, 'image1_2'),
(3, 2, 'image2_1'),
(4, 2, 'image2_2'),
(5, 3, 'image3_1'),
(6, 3, 'image3_2'),
(7, 4, 'image4_1'),
(8, 4, 'image4_2'),
(9, 5, 'image5_1'),
(10, 5, 'image5_2');

-- --------------------------------------------------------

--
-- Table structure for table `mise`
--

CREATE TABLE `mise` (
  `mise_id` bigint(20) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_enchere` bigint(20) NOT NULL,
  `mise_montant` decimal(7,2) NOT NULL,
  `mise_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mise`
--

INSERT INTO `mise` (`mise_id`, `id_utilisateur`, `id_enchere`, `mise_montant`, `mise_date`) VALUES
(1, 1, 9, 15.00, '2022-06-01 10:00:00'),
(2, 1, 2, 20.00, '2022-06-01 10:05:00'),
(3, 1, 3, 25.00, '2022-06-01 10:10:00'),
(4, 2, 4, 30.00, '2022-06-02 10:00:00'),
(5, 2, 5, 35.00, '2022-06-02 10:05:00'),
(6, 3, 6, 40.00, '2022-06-03 10:00:00'),
(7, 4, 7, 45.00, '2022-06-04 10:00:00'),
(8, 5, 8, 50.00, '2022-06-05 10:00:00'),
(9, 6, 9, 55.00, '2022-06-06 10:00:00'),
(10, 7, 10, 60.00, '2022-06-07 10:00:00'),
(11, 11, 10, 60.10, '2023-07-17 19:53:56'),
(12, 11, 10, 60.10, '2023-07-17 19:54:07'),
(13, 11, 10, 60.00, '2023-07-17 19:54:18'),
(14, 11, 10, 60.20, '2023-07-17 19:54:29'),
(15, 11, 10, 60.20, '2023-07-17 19:59:22'),
(16, 11, 10, 80.00, '2023-07-17 21:28:24'),
(17, 11, 10, 80.00, '2023-07-17 21:39:09'),
(18, 11, 10, 80.00, '2023-07-17 21:39:12'),
(19, 11, 10, 80.00, '2023-07-17 21:39:17'),
(20, 11, 4, 30.00, '2023-07-17 22:09:53'),
(21, 11, 4, 30.00, '2023-07-17 22:10:04'),
(22, 11, 4, 30.50, '2023-07-17 22:10:35'),
(23, 11, 4, 30.50, '2023-07-17 22:12:16'),
(24, 11, 4, 30.50, '2023-07-17 23:05:54'),
(25, 11, 4, 30.00, '2023-07-17 23:06:14'),
(26, 11, 10, 80.02, '2023-07-17 23:12:54'),
(27, 11, 10, 80.02, '2023-07-17 23:15:24'),
(28, 11, 10, 80.02, '2023-07-17 23:15:33'),
(29, 11, 1, 10.00, '2023-07-17 23:16:28'),
(30, 11, 1, 10.10, '2023-07-17 23:16:57'),
(31, 11, 1, 10.10, '2023-07-17 23:19:39'),
(32, 11, 5, 35.08, '2023-07-18 18:39:26');

-- --------------------------------------------------------

--
-- Table structure for table `timbre`
--

CREATE TABLE `timbre` (
  `timbre_id` bigint(20) NOT NULL,
  `timbre_nom` varchar(100) NOT NULL,
  `timbre_date_creation` date NOT NULL,
  `timbre_pays_origine` varchar(50) NOT NULL,
  `timbre_image_principale` varchar(100) NOT NULL,
  `timbre_condition` varchar(20) NOT NULL,
  `timbre_tirage` int(11) DEFAULT NULL,
  `timbre_longueur` decimal(7,2) NOT NULL,
  `timbre_largeur` decimal(7,2) NOT NULL,
  `timbre_certifie` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 pour non/faux, 1 pour oui/vrai',
  `timbre_description` varchar(2000) DEFAULT NULL,
  `timbre_couleur` varchar(20) NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timbre`
--

INSERT INTO `timbre` (`timbre_id`, `timbre_nom`, `timbre_date_creation`, `timbre_pays_origine`, `timbre_image_principale`, `timbre_condition`, `timbre_tirage`, `timbre_longueur`, `timbre_largeur`, `timbre_certifie`, `timbre_description`, `timbre_couleur`, `id_utilisateur`) VALUES
(1, 'Nom 1', '2022-01-01', 'Pays 1', '1', 'parfaite', 1000, 2.50, 3.50, 1, 'Description 1', 'Rouge', 1),
(2, 'Nom 2', '2022-02-01', 'Pays 2', '2', 'excellente', 2000, 3.50, 4.50, 0, 'Description 2', 'Bleu', 2),
(3, 'Nom 3', '2022-03-01', 'Pays 3', '3', 'bonne', 3000, 4.50, 5.50, 1, 'Description 3', 'Orange', 3),
(4, 'Nom 4', '2022-04-01', 'Pays 4', '4', 'moyenne', 4000, 5.50, 6.50, 0, 'Description 4', 'Jaune', 4),
(5, 'Nom 5', '2022-05-01', 'Pays 5', '5', 'endommagé', 5000, 6.50, 7.50, 1, 'Description 5', 'Vert', 5),
(6, 'Nom 6', '2022-06-01', 'Pays 6', '6', 'parfaite', 6000, 7.50, 8.50, 0, 'Description 6', 'Rose', 6),
(7, 'Nom 7', '2022-07-01', 'Pays 7', '7', 'excellente', 7000, 8.50, 9.50, 1, 'Description 7', 'Mauve', 7),
(8, 'Nom 8', '2022-08-01', 'Pays 8', '8', 'bonne', 8000, 9.50, 10.50, 0, 'Description 8', 'Noir/Blanc', 8),
(9, 'Nom 9', '2022-09-01', 'Pays 9', '9', 'moyenne', 9000, 10.50, 11.50, 1, 'Description 9', 'Gris', 9),
(10, 'Nom 10', '2022-10-01', 'Pays 10', '10', 'endommagé', 10000, 11.50, 12.50, 0, 'Description 10', 'Argent', 10);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `utilisateur_id` int(11) NOT NULL,
  `utilisateur_prenom` varchar(100) NOT NULL,
  `utilisateur_nom` varchar(100) NOT NULL,
  `utilisateur_pseudo` varchar(20) NOT NULL,
  `utilisateur_courriel` varchar(100) NOT NULL,
  `utilisateur_mdp` varchar(128) NOT NULL,
  `utilisateur_profil` varchar(20) NOT NULL DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`utilisateur_id`, `utilisateur_prenom`, `utilisateur_nom`, `utilisateur_pseudo`, `utilisateur_courriel`, `utilisateur_mdp`, `utilisateur_profil`) VALUES
(1, 'Prénom 1', 'Nom 1', 'Pseudo1', 'prenom1.nom1@test.com', 'ec9b18e920517e35f4c3619469dcff80d46c2dd1f22fe9824585efaefffb1552b59697b236ed4db2a68c2d55367f1d71d3076410e1e962a3cbd8009ee7341ee2', 'client'),
(2, 'Prénom 2', 'Nom 2', 'Pseudo2', 'prenom2.nom2@test.com', '5e50a901a02d95654a8ff4d261772635e5fe19c435cc888e4f848325be25186100d36249a0739f0b9adcae173e11fd5ad6a0bdab381460555b3c665ff1f188c0', 'client'),
(3, 'Prénom 3', 'Nom 3', 'Pseudo3', 'prenom3.nom3@test.com', 'e40372c0966a7dac778a6de94f98adbdff504465897dc6f688cfae90102975a346ce8157ef5e102ea4d41086bb7afe2594fe0d18094e8965a53ce27a3811d24b', 'client'),
(4, 'Prénom 4', 'Nom 4', 'Pseudo4', 'prenom4.nom4@test.com', '58676f0b9d7a27aff6e684a62f86c9520f5192a04a244c1c29c16a61b5bc84db4253fdccbdf0a682bb881c711bffb5b2582930c0281af08edb0388d8c17f0177', 'client'),
(5, 'Prénom 5', 'Nom 5', 'Pseudo5', 'prenom5.nom5@test.com', 'bceaa7a8625cf33b000fb0e096a9597a8790741779c2f6aa1e2d1cecd6471268ad54115d56263af05ddf1af047cd6a71a210238501654271a5bb8e81ddf0ddf2', 'client'),
(6, 'Prénom 6', 'Nom 6', 'Pseudo6', 'prenom6.nom6@test.com', '98011440ff666c3516941074db8b3e742a65d82b6ad8004a0f5f7436b025636cc88fb9b369929054180c49850b5f46ba36aa7b4c13c1d1522f2f1b2dd46e3c7d', 'client'),
(7, 'Prénom 7', 'Nom 7', 'Pseudo7', 'prenom7.nom7@test.com', '40b5b611a68b1ecff5818011e8341bfc867091d47c934fd674a57ffbe82ceca32a390eaa1a92b44bf50fb265d2ff06e95784caa236cfd58f9c64a70321d1a872', 'client'),
(8, 'Prénom 8', 'Nom 8', 'Pseudo8', 'prenom8.nom8@test.com', '794e88f36f4da2d4b3341101dc2996b78f82b10c5f23d2453bb582014cc315b1beb7b0260b2e4e1076b2fe0ea41b440fc7856bd86d67181adcba8537e0746e87', 'client'),
(9, 'Prénom 9', 'Nom 9', 'Pseudo9', 'prenom9.nom9@test.com', '5a2f42ecbd2990d2e57e4c17a513b28507610936e53700014f1c92c965a65b845d516fee838968aa98316291fed6cf5dae7ccf4da59224a193a34be48e71373f', 'client'),
(10, 'Prénom 10', 'Nom 10', 'Pseudo10', 'prenom10.nom10@test.com', '5b4e10236bb9a6c46dcb9b41e20b45a909d818b4a99004afa6be191f465e1f0272f221ac19ac5e8705c9416011f868e86e19c9b683aabc3b9bd2a471224f19bf', 'client'),
(11, 'Cham', 'Victor', 'Cham', 'victor@test.com', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(12, 'Test', 'Victor', 'test', 'victor@administrateur.test', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(13, 'Test', 'Victor', 'vic', 'victor@test.ca', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(14, 'Test', 'Victor', 'vicvicvic', 'vic@test.com', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(15, 'Test', 'Victor', 'vivi', 'victor@correcteur.test', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(16, 'Test', 'Victor', 'vic1', 'victor@correcteur.test1', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(17, 'Test', 'Victor', 'VictorTest1', 'victor@test.ca1', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(18, 'Test', 'Victor', 'vivi1', 'victor1@test.ca', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(19, 'Test', 'Victor', 'vivi11', 'victor11@test.ca', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(20, 'Test', 'Victor', 'vivi111', 'victor@test.ca11', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(21, 'Test', 'Victor', 'Cham111', 'victor@test.ca111', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(22, 'Test', 'Victor', 'Cham1111', 'victor@test.ca1111', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(23, 'vddsada', 'Victo', '11111', 'victor@test.ca111111', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(24, 'Chammmm', 'Victor', 'Chammmm', 'victor@test.cham', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(25, 'dasdsa', 'Victor', 'ddafasdas', 'victor@test.ca1111111', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(26, 'dsadsa', 'Victor', 'testestestestestes', 'victor@test.test', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(27, 'viiiic', 'victor', '1421321321321', 'victor@test.ca121212', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client'),
(28, 'Chamaaaa', 'Victor', 'dsadasdsad', 'victor@test.ca11121', '1cb82f2da98eba8ca4aa14468a65f7353f4f2b69d2b06e96828d1190e83f9a3dd266ccad4e180c1cebb0f4f39630cb7b456f7e8e1f6b35ca9ca5d5f6b26e20cb', 'client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enchere`
--
ALTER TABLE `enchere`
  ADD PRIMARY KEY (`enchere_id`),
  ADD KEY `enchere_ibfk_1` (`id_vendeur`),
  ADD KEY `enchere_ibfk_2` (`id_timbre`);

--
-- Indexes for table `favori`
--
ALTER TABLE `favori`
  ADD PRIMARY KEY (`favori_id`),
  ADD KEY `favori_ibfk_1` (`id_utilisateur`),
  ADD KEY `favori_ibfk_2` (`id_enchere`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`image_id`),
  ADD UNIQUE KEY `image_fichier` (`image_fichier`),
  ADD KEY `image_ibfk_1` (`id_timbre`);

--
-- Indexes for table `mise`
--
ALTER TABLE `mise`
  ADD PRIMARY KEY (`mise_id`),
  ADD KEY `mise_ibfk_1` (`id_utilisateur`),
  ADD KEY `mise_ibfk_2` (`id_enchere`);

--
-- Indexes for table `timbre`
--
ALTER TABLE `timbre`
  ADD PRIMARY KEY (`timbre_id`),
  ADD KEY `timbre_ibfk_1` (`id_utilisateur`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`utilisateur_id`),
  ADD UNIQUE KEY `utilisateur_pseudo` (`utilisateur_pseudo`),
  ADD UNIQUE KEY `utilisateur_courriel` (`utilisateur_courriel`),
  ADD UNIQUE KEY `utilisateur_courriel_2` (`utilisateur_courriel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enchere`
--
ALTER TABLE `enchere`
  MODIFY `enchere_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `favori`
--
ALTER TABLE `favori`
  MODIFY `favori_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `image_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mise`
--
ALTER TABLE `mise`
  MODIFY `mise_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `timbre`
--
ALTER TABLE `timbre`
  MODIFY `timbre_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `utilisateur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enchere`
--
ALTER TABLE `enchere`
  ADD CONSTRAINT `enchere_ibfk_1` FOREIGN KEY (`id_vendeur`) REFERENCES `utilisateur` (`utilisateur_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enchere_ibfk_2` FOREIGN KEY (`id_timbre`) REFERENCES `timbre` (`timbre_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favori`
--
ALTER TABLE `favori`
  ADD CONSTRAINT `favori_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`utilisateur_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favori_ibfk_2` FOREIGN KEY (`id_enchere`) REFERENCES `enchere` (`enchere_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`id_timbre`) REFERENCES `timbre` (`timbre_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mise`
--
ALTER TABLE `mise`
  ADD CONSTRAINT `mise_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`utilisateur_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mise_ibfk_2` FOREIGN KEY (`id_enchere`) REFERENCES `enchere` (`enchere_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timbre`
--
ALTER TABLE `timbre`
  ADD CONSTRAINT `timbre_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`utilisateur_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
