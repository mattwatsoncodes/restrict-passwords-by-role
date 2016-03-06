<?php

namespace mkdo\restrict_passwords_by_role;

/**
 * Class LoginErrors
 *
 * Errors on the Login Screen for the Plugin
 *
 * @package mkdo\restrict_passwords_by_role
 */
class LoginErrors {

	/**
	 * Constructor
	 */
	public function __construct( ) {
	}

	/**
	 * Do Work
	 */
	public function run() {
		add_action( 'login_message', array( $this, 'error_no_access' ), 99 );
	}

	/**
	 * Error to show if no access is granted
	 */
	public function error_no_access() {
		if( isset( $_GET['error'] ) && $_GET['error'] == 'mkdo-rpbr-no-access' ) {

			$error   = esc_html__( 'Sorry, we were unable to change your password, please contact your system administrator.', MKDO_RPBR_TEXT_DOMAIN );

			$message = '';
			$message .= '<p class="message">';
			$message .= $error;
			$message .= '</p>';

			return $message;
		}
	}
}
