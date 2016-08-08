<?php

namespace mkdo\restrict_passwords_by_role;

/**
 * Class Options
 *
 * Options page for the plugin
 *
 * @package mkdo\restrict_passwords_by_role
 */
class Options {

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * Do Work
	 */
	public function run() {
		add_action( 'admin_init', array( $this, 'init_options_page' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'plugin_action_links_' . plugin_basename( MKDO_RPBR_ROOT ) , array( $this, 'add_setings_link' ) );
	}

	/**
	 * Initialise the Options Page
	 */
	public function init_options_page() {

		// Register Settings
		register_setting( 'MKDO_RPBR_settings_group', 'mkdo_rpbr_select_user_roles' );

		// Add sections
		add_settings_section( 'mkdo_rpbr_select_user_roles_section', esc_html__( 'Select User Roles', MKDO_RPBR_TEXT_DOMAIN  ), array( $this, 'mkdo_rpbr_select_user_roles_section_cb' ), 'MKDO_RPBR_settings' );

    	// Add fields to a section
		add_settings_field( 'mkdo_rpbr_select_user_roles_select', esc_html__( 'Restricted Roles:', MKDO_RPBR_TEXT_DOMAIN  ), array( $this, 'mkdo_rpbr_select_user_roles_cb' ), 'MKDO_RPBR_settings', 'mkdo_rpbr_select_user_roles_section' );
	}

	/**
	 * Call back for the removed public roles section
	 */
	public function mkdo_rpbr_select_user_roles_section_cb() {
		echo '<p>';
		esc_html_e( 'Check the user roles that you wish to prevent from changing or resetting their password.', MKDO_RPBR_TEXT_DOMAIN );
		echo '</p>';
	}


	/**
	 * Call back for the removed public roles selector
	 */
	public function mkdo_rpbr_select_user_roles_cb() {

		global $wp_roles;

        $roles                       = $wp_roles->roles;
        $mkdo_rpbr_select_user_roles = get_option( 'mkdo_rpbr_select_user_roles', array() );

		if ( ! is_array( $mkdo_rpbr_select_user_roles ) ) {
			$mkdo_rpbr_select_user_roles = array();
		}

		?>
		<div class="field field-checkbox field-removed-public-roles">
			<ul class="field-input">
				<?php
				foreach ( $roles as $key => $role ) {
					?>
					<li>
						<label>
							<input type="checkbox" name="mkdo_rpbr_select_user_roles[]" value="<?php echo $key; ?>" <?php if ( in_array( $key, $mkdo_rpbr_select_user_roles ) ) { echo ' checked="checked"'; } ?> />
							<?php _e( $role['name'] );?>
						</label>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
		<?php
	}

	/**
	 * Add the options page
	 */
	public function add_options_page() {
		add_submenu_page( 'options-general.php', esc_html__( 'Restrict Passwords by Role', MKDO_RPBR_TEXT_DOMAIN ), esc_html__( 'Restrict Passwords by Role', MKDO_RPBR_TEXT_DOMAIN ), 'manage_options', 'restrict_passwords_by_role', array( $this, 'render_options_page' ) );
	}

	/**
	 * Render the options page
	 */
	public function render_options_page() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Restrict Passwords by Role', MKDO_RPBR_TEXT_DOMAIN );?></h2>
			<form action="options.php" method="POST">
	            <?php settings_fields( 'MKDO_RPBR_settings_group' ); ?>
	            <?php do_settings_sections( 'MKDO_RPBR_settings' ); ?>
	            <?php submit_button(); ?>
	        </form>
		</div>
	<?php
	}

	/**
	 * Add 'Settings' action on installed plugin list
	 */
	function add_setings_link( $links ) {
		array_unshift( $links, '<a href="options-general.php?page=restrict_passwords_by_role">' . esc_html__( 'Settings', MKDO_RPBR_TEXT_DOMAIN ) . '</a>');
		return $links;
	}
}
