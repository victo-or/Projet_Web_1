-- ---
-- Globals
-- ---

-- BD 'stampee'
DROP DATABASE IF EXISTS stampee;
CREATE DATABASE stampee CHARACTER SET utf8mb4 COLLATE=utf8mb4_general_ci;
USE stampee;

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'timbre'
-- 
-- ---

DROP TABLE IF EXISTS `timbre`;
		
CREATE TABLE `timbre` (
  `timbre_id` BIGINT NOT NULL AUTO_INCREMENT,
  `timbre_nom` VARCHAR(100) NOT NULL,
  `timbre_date_creation` DATE NOT NULL,
  `timbre_pays_origine` VARCHAR(50) NOT NULL,
  `timbre_image_principale` VARCHAR(100) NOT NULL,
  `timbre_condition` VARCHAR(20) NOT NULL,
  `timbre_tirage` INT NULL DEFAULT NULL,
  `timbre_longueur` DECIMAL(7,2) NOT NULL,
  `timbre_largeur` DECIMAL(7,2) NOT NULL,
  `timbre_certifie` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0 pour non/faux, 1 pour oui/vrai',
  `timbre_description` VARCHAR(2000) NULL DEFAULT NULL,
  `timbre_couleur` VARCHAR(20) NOT NULL,
  `id_utilisateur` INT NOT NULL,
  PRIMARY KEY (`timbre_id`)
);

-- ---
-- Table 'image'
-- 
-- ---

DROP TABLE IF EXISTS `image`;
		
CREATE TABLE `image` (
  `image_id` BIGINT NOT NULL AUTO_INCREMENT,
  `id_timbre` BIGINT NOT NULL,
  `image_fichier` VARCHAR(100) NOT NULL,
  UNIQUE KEY (`image_fichier`),
  PRIMARY KEY (`image_id`)
);

-- ---
-- Table 'enchere'
-- 
-- ---

DROP TABLE IF EXISTS `enchere`;
		
CREATE TABLE `enchere` (
  `enchere_id` BIGINT NOT NULL AUTO_INCREMENT,
  `id_vendeur` INT NOT NULL,
  `id_timbre` BIGINT NOT NULL,
  `enchere_date_debut` DATETIME NOT NULL,
  `enchere_date_fin` DATETIME NOT NULL,
  `enchere_cdc_lord` TINYINT(1) NOT NULL DEFAULT 0,
  `enchere_prix_plancher` DECIMAL(7,2) NOT NULL,
  PRIMARY KEY (`enchere_id`)
);

-- ---
-- Table 'mise'
-- 
-- ---

DROP TABLE IF EXISTS `mise`;
		
CREATE TABLE `mise` (
  `mise_id` BIGINT NOT NULL AUTO_INCREMENT,
  `id_utilisateur` INT NOT NULL,
  `id_enchere` BIGINT NOT NULL,
  `mise_montant` DECIMAL(7,2) NOT NULL,
  `mise_date` DATETIME NOT NULL,
  PRIMARY KEY (`mise_id`)
);

-- ---
-- Table 'favori'
-- 
-- ---

DROP TABLE IF EXISTS `favori`;
		
CREATE TABLE `favori` (
  `favori_id` BIGINT NOT NULL AUTO_INCREMENT,
  `id_utilisateur` INT NOT NULL,
  `id_enchere` BIGINT NOT NULL,
  `favori_date` DATE NOT NULL,
  PRIMARY KEY (`favori_id`)
);

-- ---
-- Table 'utilisateur'
-- 
-- ---

DROP TABLE IF EXISTS `utilisateur`;
		
CREATE TABLE `utilisateur` (
  `utilisateur_id` INT NOT NULL AUTO_INCREMENT,
  `utilisateur_prenom` VARCHAR(100) NOT NULL,
  `utilisateur_nom` VARCHAR(100) NOT NULL,
  `utilisateur_pseudo` VARCHAR(20) NOT NULL,
  `utilisateur_courriel` VARCHAR(100) NOT NULL,
  `utilisateur_mdp` VARCHAR(128) NOT NULL,
  `utilisateur_profil` VARCHAR(20) NOT NULL DEFAULT 'client',
  UNIQUE KEY (`utilisateur_pseudo`),
  UNIQUE KEY (`utilisateur_courriel`),
  UNIQUE KEY (`utilisateur_courriel`),
  PRIMARY KEY (`utilisateur_id`)
);

-- ---
-- Foreign Keys 
-- ---

ALTER TABLE `timbre` ADD FOREIGN KEY (id_utilisateur) REFERENCES `utilisateur` (`utilisateur_id`);
ALTER TABLE `image` ADD FOREIGN KEY (id_timbre) REFERENCES `timbre` (`timbre_id`);
ALTER TABLE `enchere` ADD FOREIGN KEY (id_vendeur) REFERENCES `utilisateur` (`utilisateur_id`);
ALTER TABLE `enchere` ADD FOREIGN KEY (id_timbre) REFERENCES `timbre` (`timbre_id`);
ALTER TABLE `mise` ADD FOREIGN KEY (id_utilisateur) REFERENCES `utilisateur` (`utilisateur_id`);
ALTER TABLE `mise` ADD FOREIGN KEY (id_enchere) REFERENCES `enchere` (`enchere_id`);
ALTER TABLE `favori` ADD FOREIGN KEY (id_utilisateur) REFERENCES `utilisateur` (`utilisateur_id`);
ALTER TABLE `favori` ADD FOREIGN KEY (id_enchere) REFERENCES `enchere` (`enchere_id`);

-- ---
-- Table Properties
-- ---

-- ALTER TABLE `timbre` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `image` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `enchere` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `mise` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `favori` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `utilisateur` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO `timbre` (`timbre_id`,`timbre_nom`,`timbre_date_creation`,`timbre_pays_origine`,`timbre_image_principale`,`timbre_condition`,`timbre_tirage`,`timbre_longueur`,`timbre_largeur`,`timbre_certifie`,`timbre_description`,`timbre_couleur`,`id_utilisateur`) VALUES
-- ('','','','','','','','','','','','','');
-- INSERT INTO `image` (`image_id`,`id_timbre`,`image_fichier`) VALUES
-- ('','','');
-- INSERT INTO `enchere` (`enchere_id`,`id_vendeur`,`id_timbre`,`enchere_date_debut`,`enchere_date_fin`,`enchere_cdc_lord`,`enchere_prix_plancher`) VALUES
-- ('','','','','','','');
-- INSERT INTO `mise` (`mise_id`,`id_utilisateur`,`id_enchere`,`mise_montant`,`mise_date`) VALUES
-- ('','','','','');
-- INSERT INTO `favori` (`favori_id`,`id_utilisateur`,`id_enchere`,`favori_date`) VALUES
-- ('','','','');
-- INSERT INTO `utilisateur` (`utilisateur_id`,`utilisateur_prenom`,`utilisateur_nom`,`utilisateur_pseudo`,`utilisateur_courriel`,`utilisateur_mdp`,`utilisateur_profil`) VALUES
-- ('','','','','','','');