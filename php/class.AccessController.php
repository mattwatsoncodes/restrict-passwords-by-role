<?php

namespace mkdo\restrict_passwords_by_role;

/**
 * Class PasswordAccess
 *
 * Class AccessController
 *
 * @package mkdo\restrict_passwords_by_role
 */
class AccessController {

	private $login_errors;

	/**
	 * Constructor
	 */
	public function __construct( LoginErrors $login_errors ) {
		$this->login_errors = $login_errors;
	}

	/**
	 * Do Work
	 */
	public function run() {
		add_filter( 'show_password_fields', array( $this, 'password_field_access_control' ) );
		add_filter( 'allow_password_reset', array( $this, 'password_field_access_control' ) );
		add_filter( 'lostpassword_post', array( $this, 'password_reset_access_control' ) );

		$this->login_errors->run();
	}

	/**
	 * Check if user has access to change password
	 */
	public function password_field_access_control() {

		if ( is_admin() ) {
            $mkdo_rdbr_admin_restrict = get_option( 'mkdo_rpbr_select_user_roles' );

			if( ! is_array( $mkdo_rdbr_admin_restrict ) ) {
				$mkdo_rdbr_admin_restrict = array();
			}

			foreach( $mkdo_rdbr_admin_restrict as $restricted_role ) {
				if ( current_user_can( $restricted_role ) ) {
					return false;
				}
			}
		}

		return true;
	}

	/**
	 *Check if user has access to reset password
	 */
	public function password_reset_access_control() {

		if( isset( $_POST['user_login'] ) ) {

            $login                    = $_POST['user_login'];
            $user                     = FALSE;
            $mkdo_rdbr_admin_restrict = get_option( 'mkdo_rpbr_select_user_roles' );
            $redirect_url             = wp_login_url() . '?error="mkdo-rpbr-no-access"';

			if( ! is_array( $mkdo_rdbr_admin_restrict ) ) {
				$mkdo_rdbr_admin_restrict = array();
			}

			if( is_email( $login ) ) {
				$user = get_user_by( 'email', $login );
			} else {
				$user = get_user_by( 'login', $login );
			}

			if( FALSE !== $user ) {

				foreach( $mkdo_rdbr_admin_restrict as $restricted_role ) {
					if ( user_can( $user, $restricted_role ) ) {
						wp_redirect( $redirect_url, 302 );
						exit;
					}
				}

			// If the user has no role, just send them back to the form
			} else if( empty( $user->roles ) ) {
				wp_redirect( wp_login_url() . '?action=lostpassword', 302 );
				exit;
			}
		}
	}
}
