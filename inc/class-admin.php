<?php
declare(strict_types = 1);

namespace epiphyt\Multisite_Auto_Language_Switcher;

/**
 * Admin-related functionality
 * 
 * @author	Epiphyt
 * @license	GPL2
 * @package	epiphyt\Multisite_Auto_Language_Switcher
 */
final class Admin {
	/**
	 * Initialize functionality.
	 */
	public static function init(): void {
		\add_filter( 'plugin_row_meta', [ self::class, 'render_plugin_documentation_link' ], 10, 2 );
	}
	
	/**
	 * Add plugin meta links.
	 * 
	 * @param	string[]	$input Registered links.
	 * @param	string		$file  Current plugin file.
	 * @return	string[] Merged links
	 */
	public static function render_plugin_documentation_link( array $input, string $file ): array {
		if ( ! \str_ends_with( \EPI_MULTISITE_AUTO_LANGUAGE_SWITCHER_FILE, $file ) ) {
			return $input;
		}
		
		return \array_merge(
			$input,
			[
				/* translators: plugin version */
				'<a href="' . \esc_url( \sprintf( \__( 'https://docs.epiph.yt/multisite-auto-language-switcher/?version=%s', 'multisite-auto-language-switcher' ), \get_plugin_data( \EPI_MULTISITE_AUTO_LANGUAGE_SWITCHER_FILE )['Version'] ) ) . '" target="_blank" rel="noopener noreferrer">' . \esc_html__( 'Documentation', 'multisite-auto-language-switcher' ) . '</a>',
			]
		);
	}
}
