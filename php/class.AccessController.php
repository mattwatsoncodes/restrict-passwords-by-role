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

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * Do Work
	 */
	public function run() {
		add_filter( 'show_password_fields', array( $this, 'access_control' ) );
		add_filter( 'allow_password_reset', array( $this, 'access_control' ) );
	}

	/**
	 * Check if user has access
	 */
	public function access_control() {

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
}
