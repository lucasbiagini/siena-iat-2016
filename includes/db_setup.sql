CREATE DATABASE IF NOT EXISTS sienasel_iat
  DEFAULT CHARACTER SET utf8;
USE sienasel_iat;

-- Might want to add drops here
CREATE TABLE IF NOT EXISTS `survey` (
  `idperson`    BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `gender`      VARCHAR(6) DEFAULT NULL,
  `age`         TINYINT UNSIGNED DEFAULT NULL,
  `ethnicity`   VARCHAR(45) DEFAULT NULL,
  `numberiats`  TINYINT UNSIGNED DEFAULT NULL,
  `country`     VARCHAR(45) DEFAULT NULL,
  `field`       VARCHAR(45) DEFAULT NULL,
  `background`  VARCHAR(45) DEFAULT NULL,
  `reg_date`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (`idperson`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `iat` (
  `idiat`             INT(11) NOT NULL AUTO_INCREMENT,
  `idperson`          INT(11) DEFAULT NULL,
  `reg_date`          TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `score_original`    DOUBLE DEFAULT NULL,
  `score`             DOUBLE DEFAULT NULL,
  `iat_type`          VARCHAR(1) DEFAULT NULL,
  `categories_order`  VARCHAR(100) DEFAULT NULL,
  `label`             INT(11) NOT NULL DEFAULT '0',

  PRIMARY KEY (`idiat`)
) ENGINE=MyISAM AUTO_INCREMENT=15; -- What is this auto_i for?

CREATE TABLE IF NOT EXISTS `trials` (
  `idiat`         INT(11) NOT NULL,
  `trial_seq`     INT(11) NOT NULL,
  `trial_number`  INT(11) DEFAULT NULL,
  `response_time` DOUBLE DEFAULT NULL,
  `item`          VARCHAR(45) DEFAULT NULL,
  `category`      VARCHAR(45) DEFAULT NULL,
  `error`         INT(11) DEFAULT NULL,
  `block`         INT(11) DEFAULT NULL,

  PRIMARY KEY (`idiat`,`trial_seq`) -- Primary key should be idiat, block, trial_something
) ENGINE=MyISAM;
