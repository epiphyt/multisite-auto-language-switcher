<?php
declare(strict_types = 1);

namespace epiphyt\Multisite_Auto_Language_Switcher;

/**
 * Switcher functionality.
 * 
 * @author	Epiphyt
 * @license	GPL2
 * @package	epiphyt\Multisite_Auto_Language_Switcher
 */
final class Switcher {
	/**
	 * Initialize functions.
	 */
	public static function init(): void {
		\add_action( 'init', [ self::class, 'set_cookie' ] );
		\add_action( 'wp', [ self::class, 'maybe_redirect' ] );
		\add_filter( 'msls_options_get_permalink', [ self::class, 'add_redirected_parameter' ] );
	}
	
	/**
	 * Add the redirected parameter to prevent redirect loop.
	 * 
	 * @param	string	$link Link to add parameter to
	 * @return	string Link with added parameter
	 */
	public static function add_redirected_parameter( string $link ): string {
		if ( empty( $link ) ) {
			return $link;
		}
		
		/**
		 * Filter redirected parameter name.
		 * 
		 * @param	string	$parameter_name Current parameter name
		 */
		$parameter_name = (string) \apply_filters( 'multisite_auto_language_switcher_redirected_parameter_name', 'redirected-locale' );
		
		$parameter = $parameter_name . '=1';
		$query_string_start = \strpos( $link, '?' );
		
		if ( $query_string_start === false ) {
			$link .= '?' . $parameter;
		}
		else if ( ! \str_contains( $link, $parameter ) ) {
			$link = \substr_replace( $link, $parameter . '&', $query_string_start + 1, 0 );
		}
		
		return $link;
	}
	
	/**
	 * Get a permalink to redirect to.
	 * 
	 * @param	string	$locale Locale to redirect to
	 * @return	string Permalink to redirect to
	 */
	private static function get_permalink( string $locale ): string {
		if ( ! \function_exists( 'get_msls_permalink' ) ) {
			return '';
		}
		
		$permalink = \get_msls_permalink( $locale );
		
		if ( empty( $permalink ) ) {
			return '';
		}
		
		return self::add_redirected_parameter( $permalink );
	}
	
	/**
	 * Maybe redirect a user to another language.
	 */
	public static function maybe_redirect(): void {
		if ( \is_admin() || \wp_doing_ajax() || \wp_doing_cron() ) {
			return;
		}
		
		/**
		 * This filter is documented in inc/class-switcher.php.
		 */
		$parameter_name = (string) \apply_filters( 'multisite_auto_language_switcher_redirected_parameter_name', 'redirected-locale' );
		
		if ( ! empty( $_GET[ $parameter_name ] ) || ! empty( $_COOKIE[ $parameter_name ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended, SlevomatCodingStandard.ControlStructures.RequireMultiLineCondition.RequiredMultiLineCondition
			return;
		}
		
		$accept_languages = Language::get_accepted();
		
		if ( empty( $accept_languages ) ) {
			return;
		}
		
		$current_permalink = \get_permalink();
		
		if ( $current_permalink === false ) {
			return;
		}
		
		foreach ( $accept_languages as $accept_language ) {
			if ( $accept_language['language'] === '*' ) {
				return;
			}
			
			$locale = Language::get_nearest_match( $accept_language['language'] );
			
			if ( empty( $locale ) ) {
				continue;
			}
			
			$permalink = self::get_permalink( $locale );
			
			if ( empty( $permalink ) ) {
				continue;
			}
			
			if ( $permalink !== self::add_redirected_parameter( $current_permalink ) ) {
				\wp_safe_redirect( $permalink );
				exit;
			}
			
			// a valid permalink exists and is identical to the current URL
			break;
		}
	}
	
	/**
	 * Set the redirect cookie.
	 */
	public static function set_cookie(): void {
		/**
		 * This filter is documented in inc/class-switcher.php.
		 */
		$parameter_name = (string) \apply_filters( 'multisite_auto_language_switcher_redirected_parameter_name', 'redirected-locale' );
		
		if ( empty( $_GET[ $parameter_name ] ) || ! empty( $_COOKIE[ $parameter_name ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended, SlevomatCodingStandard.ControlStructures.RequireMultiLineCondition.RequiredMultiLineCondition
			return;
		}
		
		/**
		 * Filter the cookie options for the redirect.
		 */
		$cookie_options = (array) \apply_filters(
			'multisite_auto_language_switcher',
			[
				'expires' => 0,
				'httponly' => true,
				'secure' => true,
			]
		);
		
		\setcookie( $parameter_name, '1', $cookie_options );
	}
}
