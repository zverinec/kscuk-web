DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
	`id_question` INT(25) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'identifikator',
	`question` TEXT NOT NULL,
	`info` TEXT NULL,
	`required` TINYINT(1) NOT NULL,
	`category` ENUM('personal', 'interesting', 'organization') NOT NULL,
	`form_type` ENUM('checkbox', 'text', 'radiobox', 'selectbox', 'textarea') NOT NULL,
	`choices` TEXT NULL COMMENT 'jednotlive moznosti se oddeluji svislitkem',
	`inserted` TIMESTAMP NOT NULL COMMENT 'cas, kdy byla polozka vlozena do systemu'
) ENGINE = InnoDB COMMENT = 'Otazky' COLLATE = utf8_czech_ci;


DROP TABLE IF EXISTS `registered`;
CREATE TABLE `registered` (
	`id_registered` INT(25) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'identifikator',
	`inserted` TIMESTAMP NOT NULL COMMENT 'cas, kdy byla polozka vlozena do systemu'
) ENGINE = InnoDB COMMENT = 'Registrovani' COLLATE = utf8_czech_ci;

DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
	`id_answer` INT(25) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'identifikator',
	`id_question` INT(25) UNSIGNED NOT NULL,
	`id_registered` INT(25) UNSIGNED NOT NULL,
	`answer` TEXT NULL,
	`inserted` TIMESTAMP NOT NULL COMMENT 'cas, kdy byla polozka vlozena do systemu',
	FOREIGN KEY (`id_question`) REFERENCES  `question` (`id_question`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`id_registered`) REFERENCES  `registered` (`id_registered`) ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE(`id_question`, `id_registered`)
) ENGINE = InnoDB COMMENT = 'Odpovedi' COLLATE = utf8_czech_ci;

CREATE TABLE `health_declaration` (
  `id_health_declaration` int(11) NOT NULL AUTO_INCREMENT,
  `code` tinytext NOT NULL,
  `course` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `date` date NOT NULL,
  `birth_date` tinytext NOT NULL,
  `no_gp` tinyint(1) NOT NULL,
  `gp` text NOT NULL,
  `informing` text NOT NULL,
  `no_sporting` tinyint(1) NOT NULL,
  `sporting` text NOT NULL,
  `swimming` tinyint(1) NOT NULL,
  `no_medicine` tinyint(1) NOT NULL,
  `medicine` text NOT NULL,
  `no_allergy` tinyint(1) NOT NULL,
  `allergy` text NOT NULL,
  `signature` text NOT NULL,
  `food_problems` text NOT NULL,
  `no_food_problems` tinyint(1) NOT NULL,
  `heart1` tinyint(1) NOT NULL,
  `heart2` tinyint(1) NOT NULL,
  `heart3` tinyint(1) NOT NULL,
  `heart4` tinyint(1) NOT NULL,
  `heart5` tinyint(1) NOT NULL,
  `heart6` tinyint(1) NOT NULL,
  `profile` text NOT NULL,
  `profile1` tinyint(1) NOT NULL,
  `profile2` tinyint(1) NOT NULL,
  `profile3` tinyint(1) NOT NULL,
  `profile4` tinyint(1) NOT NULL,
  `profile5` tinyint(1) NOT NULL,
  `profile6` tinyint(1) NOT NULL,
  `profile7` tinyint(1) NOT NULL,
  `profile13` tinyint(1) NOT NULL,
  `profile12` tinyint(1) NOT NULL,
  `profile9` tinyint(1) NOT NULL,
  `profile10` tinyint(1) NOT NULL,
  `profile11` tinyint(1) NOT NULL,
  `profile8` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_health_declaration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
