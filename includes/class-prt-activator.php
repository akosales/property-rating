<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.makler-anfragen.immo
 * @since      1.0.0
 *
 * @package    Prt
 * @subpackage Prt/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Prt
 * @subpackage Prt/includes
 * @author     Andreas Konopka <info@makler-anfragen.immo>
 */
class Prt_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}prt_requests (
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
			`highPerSqm` DECIMAL(12,2) NULL,
			PRIMARY KEY (`id`));");
	}

}
