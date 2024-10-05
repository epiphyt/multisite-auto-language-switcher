<?php
declare(strict_types = 1);

namespace epiphyt\Multisite_Auto_Language_Switcher;

/**
 * Language functionality.
 * 
 * @author	Epiphyt
 * @license	GPL2
 * @package	epiphyt\Multisite_Auto_Language_Switcher
 */
final class Language {
	/**
	 * Get a list of accepted languages, sorted by their weight.
	 * 
	 * @return	string[][]	List of accepted languages
	 */
	public static function get_accepted(): array {
		$http_accept_language = \sanitize_text_field( \wp_unslash( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '' ) );
		
		if ( empty( $http_accept_language ) ) {
			return [];
		}
		
		$languages = \explode( ',', $http_accept_language );
		$languages = \array_map( static function( string $language ): array {
			$list = \explode( ';', $language );
			
			return [
				'language' => \trim( $list[0] ),
				'weight' => \trim( $list[1] ?? '' ),
			];
		}, $languages );
		
		\usort( $languages, [ self::class, 'sort_by_priority_callback' ] );
		
		/**
		 * Filter the accepted and sorted languages.
		 * 
		 * @param	array	$languages List of accepted and sorted languages
		 */
		$languages = (array) \apply_filters( 'multisite_auto_language_switcher_accepted_languages', $languages );
		
		return $languages;
	}
	
	/**
	 * Get the nearest matching locale.
	 * 
	 * @param	string	$locale Locale to match
	 * @return	string Matched available locale
	 */
	public static function get_nearest_match( string $locale ): string {
		$locale = \str_replace( '-', '_', $locale );
		$locales = \array_merge(
			[ 'en_US' ],
			\get_available_languages()
		);
		
		if ( \in_array( $locale, $locales, true ) ) {
			return $locale;
		}
		
		foreach ( $locales as $installed_locale ) {
			if ( \str_starts_with( $installed_locale, $locale ) ) {
				return $installed_locale;
			}
		}
		
		return '';
	}
	
	/**
	 * Sort two given languages by their weight as callback.
	 * 
	 * @param	string[]	$language1 First language
	 * @param	string[]	$language2 Second language
	 * @return	int Order of the languages
	 */
	private static function sort_by_priority_callback( array $language1, array $language2 ): int {
		if ( empty( $language1['weight'] ) ) {
			return -1;
		}
		
		if ( empty( $language2['weight'] ) ) {
			return 1;
		}
		
		$language1_weight = (float) \substr( $language1['weight'], \strpos( $language1['weight'], '=' ) + 1 );
		$language2_weight = (float) \substr( $language2['weight'], \strpos( $language2['weight'], '=' ) + 1 );
		
		return $language2_weight <=> $language1_weight;
	}
}
