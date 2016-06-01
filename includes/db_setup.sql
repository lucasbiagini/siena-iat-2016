CREATE DATABASE IF NOT EXISTS sienasel_iat
  DEFAULT CHARACTER SET utf8;
USE sienasel_iat;

-- Might want to add drops here
CREATE TABLE IF NOT EXISTS `subjects` (
  `subject_id`  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `gender`      VARCHAR(6) DEFAULT NULL,
  `age`         TINYINT UNSIGNED DEFAULT NULL,
  `ethnicity`   VARCHAR(45) DEFAULT NULL,
  `number_iats` TINYINT UNSIGNED DEFAULT NULL,
  `country`     VARCHAR(3) DEFAULT NULL,
  `field`       VARCHAR(45) DEFAULT NULL,
  `background`  TINYINT UNSIGNED DEFAULT NULL,
  `reg_date`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  -- I think we are missing a field for education level

  PRIMARY KEY (`subject_id`)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS `iats` (
  `iat_id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject_id`        BIGINT UNSIGNED NOT NULL,
  `reg_date`          TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `score`             DOUBLE DEFAULT NULL,
  `cheat_type`        TINYINT NOT NULL,

  PRIMARY KEY (`iat_id`),
  FOREIGN KEY (`subject_id`)
    REFERENCES subjects(`subject_id`)
    ON DELETE CASCADE

) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS `trials` (
  `iat_id`        BIGINT UNSIGNED NOT NULL,
  `trial_number`  BIGINT UNSIGNED NOT NULL,
  `response_time` DOUBLE NOT NULL,
  `item`          VARCHAR(45) NOT NULL,
  `category`      VARCHAR(45) NOT NULL,
  `error`         TINYINT UNSIGNED NOT NULL,
  `block`         TINYINT UNSIGNED NOT NULL,

  PRIMARY KEY (`iat_id`,`block`,`trial_number`),
  FOREIGN KEY (`iat_id`)
    REFERENCES iats(`iat_id`)
    ON DELETE CASCADE
) ENGINE=INNODB;
