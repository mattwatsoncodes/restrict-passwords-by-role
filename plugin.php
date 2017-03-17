<?php

/**
 * @link              https://github.com/mkdo/restrict-passwords-by-role
 * @package           mkdo\restrict_passwords_by_role
 *
 * Plugin Name:       Restrict Passwords by Role
 * Plugin URI:        https://github.com/mkdo/restrict-passwords-by-role
 * Description:       Restrict users with certain User Roles from changing or resetting their password.
 * Version:           1.0.3
 * Author:            Make Do <hello@makedo.net>
 * Author URI:        http://www.makedo.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       restrict-passwords-by-role
 * Domain Path:       /languages
 */

// Constants
define( 'MKDO_RPBR_ROOT', __FILE__ );
define( 'MKDO_RPBR_TEXT_DOMAIN', 'restrict-passwords-by-role' );

// Load Classes
require_once "php/class.MainController.php";
require_once "php/class.Options.php";
require_once "php/class.AssetsController.php";
require_once "php/class.AccessController.php";
require_once "php/class.LoginErrors.php";

// Use Namespaces
use mkdo\restrict_passwords_by_role\MainController;
use mkdo\restrict_passwords_by_role\Options;
use mkdo\restrict_passwords_by_role\AssetsController;
use mkdo\restrict_passwords_by_role\AccessController;
use mkdo\restrict_passwords_by_role\LoginErrors;

// Initialize Classes
$options           = new Options();
$assets_controller = new AssetsController();
$login_errors      = new LoginErrors();
$access_controller = new AccessController( $login_errors );
$controller        = new MainController( $options, $assets_controller, $access_controller );

// Run the Plugin
$controller->run();
