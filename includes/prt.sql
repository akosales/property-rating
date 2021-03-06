CREATE TABLE IF NOT EXISTS `wp_prt_requests` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(45) NOT NULL,
  `salutation` VARCHAR(45) NOT NULL,
  `firstname` VARCHAR(150) NULL,
  `lastname` VARCHAR(150) NULL,
  `phone` VARCHAR(60) NULL,
  `email` VARCHAR(150) NULL,
  `address` VARCHAR(300) NULL,
  `wohnflache` INT NULL,
  `zimmer` DECIMAL(1) NULL,
  `baujahr` VARCHAR(45) NULL,
  `grundflache` INT NULL,
  `etage` INT NULL,
  `erschlossen` VARCHAR(45) NULL,
  `bebauung` VARCHAR(45) NULL,
  `zuschnitt` VARCHAR(45) NULL,
  `resultAbsolute` DECIMAL(12,2) NULL,
  `lowAbsolute` DECIMAL(12,2) NULL,
  `highAbsolute` DECIMAL(12,2) NULL,
  `resultPerSqm` DECIMAL(12,2) NULL,
  `lowPerSqm` DECIMAL(12,2) NULL,
  `highPerSqm` DECIMAL(12,2) NULL
  PRIMARY KEY (`id`));