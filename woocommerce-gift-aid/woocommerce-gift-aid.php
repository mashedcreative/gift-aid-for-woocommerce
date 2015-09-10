<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/mkdo/woocommerce-gift-aid
 * @since             1.0.0
 * @package           WooCommerce_Gift_Aid
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Gift Aid
 * Plugin URI:        https://github.com/mkdo/woocommerce-gift-aid/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Make Do <hello@makedo.in>
 * Author URI:        http://www.makedo.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-gift-aid
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-gift-aid-activator.php
 */
function activate_woocommerce_gift_aid() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-gift-aid-activator.php';
	WooCommerce_Gift_Aid_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-gift-aid-deactivator.php
 */
function deactivate_woocommerce_gift_aid() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-gift-aid-deactivator.php';
	WooCommerce_Gift_Aid_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woocommerce_gift_aid' );
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_gift_aid' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-gift-aid.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_gift_aid() {

	$plugin = new WooCommerce_Gift_Aid();
	$plugin->run();

}
run_woocommerce_gift_aid();
