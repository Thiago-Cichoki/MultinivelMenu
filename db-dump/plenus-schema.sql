CREATE DATABASE IF NOT EXISTS plenus;
Use plenus;

CREATE TABLE IF NOT EXISTS `categories` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(64) NOT NULL,
    `idParentCategory` INT DEFAULT NULL
)ENGINE = INNODB CHARSET = utf8 COLLATE = utf8_general_ci ;
