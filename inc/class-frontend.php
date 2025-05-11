<?php
declare(strict_types = 1);

namespace epiphyt\Multisite_Auto_Language_Switcher;

/**
 * Frontend functionality.
 * 
 * @author	Epiphyt
 * @license	GPL2
 * @package	epiphyt\Multisite_Auto_Language_Switcher
 */
final class Frontend {
	/**
	 * Initialize functionality.
	 */
	public static function init(): void {
		if ( \is_admin() ) {
			return;
		}
		
		\add_action( 'wp_footer', [ self::class, 'add_inline_script' ] );
	}
	
	/**
	 * Add inline script.
	 */
	public static function add_inline_script(): void {
		/**
		 * This filter is documented in inc/class-switcher.php.
		 */
		$parameter_name = (string) \apply_filters( 'multisite_auto_language_switcher_redirected_parameter_name', 'redirected-locale' );
		
		if ( ! empty( $_GET[ $parameter_name ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			echo '<script id="multisite-auto-language-switcher-parameter-name">var multisiteAutoLanguageSwitcherParameterName = \'' . \esc_js( $parameter_name ) . '\';</script>';
			include_once \EPI_MULTISITE_AUTO_LANGUAGE_SWITCHER_BASE . 'templates/inline-script-remove-parameter.html';
		}
	}
}
