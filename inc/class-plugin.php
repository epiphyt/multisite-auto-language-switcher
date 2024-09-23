<?php
declare(strict_types = 1);

namespace epiphyt\Multisite_Auto_Language_Switcher;

/**
 * The main plugin class.
 * 
 * @author	Epiphyt
 * @license	GPL2
 * @package	epiphyt\Multisite_Auto_Language_Switcher
 */
final class Plugin {
	/**
	 * Initialize functions.
	 */
	public static function init(): void {
		Switcher::init();
	}
}
