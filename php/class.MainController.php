<?php

namespace mkdo\restrict_passwords_by_role;

/**
 * Class MainController
 *
 * The main loader for this plugin
 *
 * @package mkdo\restrict_passwords_by_role
 */
class MainController {

	private $options;
	private $assets_controller;
	private $access_controller;

	/**
	 * Constructor
	 *
	 * @param Options            $options              Object defining the options page
	 * @param AssetsController   $assets_controller    Object to load the assets
	 */
	public function __construct( Options $options, AssetsController $assets_controller, AccessController $access_controller ) {
		$this->options              = $options;
		$this->assets_controller    = $assets_controller;
		$this->access_controller    = $access_controller;
	}

	/**
	 * Do Work
	 */
	public function run() {
		load_plugin_textdomain( MKDO_RPBR_TEXT_DOMAIN, false, MKDO_RPBR_ROOT . '\languages' );

		$this->options->run();
		$this->assets_controller->run();
		$this->access_controller->run();
	}
}
