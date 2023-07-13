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
  `nom` VARCHAR(100) NOT NULL,
  `date_creation` DATE NOT NULL,
  `pays_origine` VARCHAR(50) NOT NULL,
  `image_principale` VARCHAR(100) NOT NULL,
  `etat` VARCHAR(20) NOT NULL COMMENT 'on utilise etat plutôt que condition étant donné que conditi',
  `tirage` INT NULL DEFAULT NULL,
  `longueur` DECIMAL(7,2) NOT NULL,
  `largeur` DECIMAL(7,2) NOT NULL,
  `certifie` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0 pour non/faux, 1 pour oui/vrai',
  `description` VARCHAR(2000) NULL DEFAULT NULL,
  `couleur` VARCHAR(20) NOT NULL,
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
  `fichier_image` VARCHAR(100) NOT NULL,
  UNIQUE KEY (`fichier_image`),
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
  `date_debut` DATETIME NOT NULL,
  `date_fin` DATETIME NOT NULL,
  `cdc_lord` TINYINT(1) NOT NULL DEFAULT 0,
  `prix_plancher` DECIMAL(7,2) NOT NULL,
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
  `montant` DECIMAL(7,2) NOT NULL,
  `date` DATETIME NOT NULL,
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
  `date` DATE NOT NULL,
  PRIMARY KEY (`favori_id`)
);

-- ---
-- Table 'utilisateur'
-- 
-- ---

DROP TABLE IF EXISTS `utilisateur`;
		
CREATE TABLE `utilisateur` (
  `utilisateur_id` INT NOT NULL AUTO_INCREMENT,
  `prenom` VARCHAR(100) NOT NULL,
  `nom` VARCHAR(100) NOT NULL,
  `pseudo` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `mdp` VARCHAR(128) NOT NULL,
  UNIQUE KEY (`pseudo`),
  UNIQUE KEY (`email`),
  UNIQUE KEY (`email`),
  PRIMARY KEY (`utilisateur_id`)
);

-- ---
-- Table 'admin'
-- 
-- ---

DROP TABLE IF EXISTS `admin`;
		
CREATE TABLE `admin` (
  `admin_id` SMALLINT NOT NULL AUTO_INCREMENT,
  `prenom` VARCHAR(100) NOT NULL,
  `nom` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `mdp` VARCHAR(128) NOT NULL,
  UNIQUE KEY (`email`),
  PRIMARY KEY (`admin_id`)
);

-- ---
-- Table 'role'
-- 
-- ---

DROP TABLE IF EXISTS `role`;
		
CREATE TABLE `role` (
  `role_id` INT NOT NULL AUTO_INCREMENT,
  `id_utilisateur` INT NOT NULL,
  `nom` VARCHAR(20) NOT NULL DEFAULT 'membre',
  PRIMARY KEY (`role_id`)
);

-- ---
-- Foreign Keys 
-- ---

ALTER TABLE `image` ADD FOREIGN KEY (id_timbre) REFERENCES `timbre` (`timbre_id`);
ALTER TABLE `enchere` ADD FOREIGN KEY (id_vendeur) REFERENCES `utilisateur` (`utilisateur_id`);
ALTER TABLE `enchere` ADD FOREIGN KEY (id_timbre) REFERENCES `timbre` (`timbre_id`);
ALTER TABLE `mise` ADD FOREIGN KEY (id_utilisateur) REFERENCES `utilisateur` (`utilisateur_id`);
ALTER TABLE `mise` ADD FOREIGN KEY (id_enchere) REFERENCES `enchere` (`enchere_id`);
ALTER TABLE `favori` ADD FOREIGN KEY (id_utilisateur) REFERENCES `utilisateur` (`utilisateur_id`);
ALTER TABLE `favori` ADD FOREIGN KEY (id_enchere) REFERENCES `enchere` (`enchere_id`);
ALTER TABLE `role` ADD FOREIGN KEY (id_utilisateur) REFERENCES `utilisateur` (`utilisateur_id`);

-- ---
-- Table Properties
-- ---

-- ALTER TABLE `timbre` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `image` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `enchere` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `mise` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `favori` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `utilisateur` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `admin` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `role` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO `timbre` (`timbre_id`,`nom`,`date_creation`,`pays_origine`,`image_principale`,`etat`,`tirage`,`longueur`,`largeur`,`certifie`,`description`,`couleur`) VALUES
-- ('','','','','','','','','','','','');
-- INSERT INTO `image` (`image_id`,`id_timbre`,`fichier_image`) VALUES
-- ('','','');
-- INSERT INTO `enchere` (`enchere_id`,`id_vendeur`,`id_timbre`,`date_debut`,`date_fin`,`cdc_lord`,`prix_plancher`) VALUES
-- ('','','','','','','');
-- INSERT INTO `mise` (`mise_id`,`id_utilisateur`,`id_enchere`,`montant`,`date`) VALUES
-- ('','','','','');
-- INSERT INTO `favori` (`favori_id`,`id_utilisateur`,`id_enchere`,`date`) VALUES
-- ('','','','');
-- INSERT INTO `utilisateur` (`utilisateur_id`,`prenom`,`nom`,`pseudo`,`email`,`mdp`) VALUES
-- ('','','','','','');
-- INSERT INTO `admin` (`admin_id`,`prenom`,`nom`,`email`,`mdp`) VALUES
-- ('','','','','');
-- INSERT INTO `role` (`role_id`,`id_utilisateur`,`nom`) VALUES
-- ('','','');