<?php
declare(strict_types = 1);

namespace epiphyt\Multisite_Auto_Language_Switcher;

/*
Plugin Name:		Multisite Auto Language Switcher
Description:		Automatically switch to a user's preferred language if Multisite Language Switcher is enabled and active for the current page.
Author:				Epiphyt
Author URI:			https://epiph.yt/en/
Version:			1.0.0
License:			GPL2
License URI:		https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:		multisite-auto-language-switcher
Requires Plugins:	multisite-language-switcher

Multisite Auto Language Switcher is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Multisite Auto Language Switcher is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Multisite Auto Language Switcher. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/
\defined( 'ABSPATH' ) || exit;

\define( 'EPI_MULTISITE_AUTO_LANGUAGE_SWITCHER_VERSION', '1.0.0' );

if ( ! \defined( 'EPI_MULTISITE_AUTO_LANGUAGE_SWITCHER_BASE' ) ) {
	\define( 'EPI_MULTISITE_AUTO_LANGUAGE_SWITCHER_BASE', \WP_PLUGIN_DIR . '/multisite-auto-language-switcher/' );
}

if ( ! \defined( 'EPI_MULTISITE_AUTO_LANGUAGE_SWITCHER_FILE' ) ) {
	\define( 'EPI_MULTISITE_AUTO_LANGUAGE_SWITCHER_FILE', \EPI_MULTISITE_AUTO_LANGUAGE_SWITCHER_BASE . \basename( __FILE__ ) );
}

if ( ! \defined( 'EPI_MULTISITE_AUTO_LANGUAGE_SWITCHER_URL' ) ) {
	\define( 'EPI_MULTISITE_AUTO_LANGUAGE_SWITCHER_URL', \plugin_dir_url( \EPI_MULTISITE_AUTO_LANGUAGE_SWITCHER_FILE ) );
}

/**
 * Autoload all necessary classes.
 * 
 * @param	string	$class_name The class name of the auto-loaded class
 */
\spl_autoload_register( static function( string $class_name ): void {
	$namespace = \strtolower( __NAMESPACE__ . '\\' );
	$path = \explode( '\\', $class_name );
	$filename = \str_replace( '_', '-', \strtolower( \array_pop( $path ) ) );
	$class_name = \str_replace(
		[ $namespace, '\\', '_' ],
		[ '', '/', '-' ],
		\strtolower( $class_name )
	);
	$string_position = \strrpos( $class_name, $filename );
	
	if ( $string_position !== false ) {
		$class_name = \substr_replace( $class_name, 'class-' . $filename, $string_position, \strlen( $filename ) );
	}
	
	$maybe_file = __DIR__ . '/inc/' . $class_name . '.php';
	
	if ( \file_exists( $maybe_file ) ) {
		require_once $maybe_file;
	}
} );

\add_action( 'plugins_loaded', [ Plugin::class, 'init' ] );
