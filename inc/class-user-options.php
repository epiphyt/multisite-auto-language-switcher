<?php
declare(strict_types = 1);

namespace epiphyt\Multisite_Auto_Language_Switcher;

use WP_User;

/**
 * User options.
 * 
 * @author	Epiphyt
 * @license	GPL2
 * @package	epiphyt\Multisite_Auto_Language_Switcher
 */
final class User_Options {
	/**
	 * Initialize functionality.
	 */
	public static function init(): void {
		\add_action( 'personal_options', [ self::class, 'add_personal_options' ], 20 );
		\add_action( 'edit_user_profile_update', [ self::class, 'save' ] );
		\add_action( 'personal_options_update', [ self::class, 'save' ] );
	}
	
	/**
	 * Add personal options to user profile.
	 * 
	 * @param	\WP_User	$user Current user object
	 */
	public static function add_personal_options( WP_User $user ): void {
		?>
		<tr class="user-multisite-auto-language-switcher-redirect-wrap">
			<th scope="row"><?php \esc_html_e( 'Auto-redirect', 'multisite-auto-language-switcher' ); ?></th>
			<td>
				<label for="multisite_auto_language_switcher_redirect">
					<input name="multisite_auto_language_switcher_redirect" type="checkbox" id="multisite_auto_language_switcher_redirect" value="1"<?php \checked( \get_user_option( 'multisite_auto_language_switcher_redirect', $user->ID ) ); ?>>
					<?php \esc_html_e( 'Auto-redirect to preferred language', 'multisite-auto-language-switcher' ); ?>
				</label>
			</td>
		</tr>
		<?php
	}
	
	/**
	 * Save user options.
	 * 
	 * @param	int		$user_id Current user ID
	 */
	public static function save( int $user_id ): void {
		if (
			empty( $_POST['_wpnonce'] )
			|| ! \wp_verify_nonce( \sanitize_text_field( \wp_unslash( $_POST['_wpnonce'] ) ), 'update-user_' . $user_id )
		) {
			return;
		}
		
		if ( ! \current_user_can( 'edit_user', $user_id ) ) {
			return;
		}
		
		if ( isset( $_POST['multisite_auto_language_switcher_redirect'] ) ) {
			$data = (bool) \sanitize_text_field( \wp_unslash( $_POST['multisite_auto_language_switcher_redirect'] ) );
			
			\update_user_option( $user_id, 'multisite_auto_language_switcher_redirect', $data, true );
		}
		else {
			\delete_user_option( $user_id, 'multisite_auto_language_switcher_redirect', true );
		}
	}
}
