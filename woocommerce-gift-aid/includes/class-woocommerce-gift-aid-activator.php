<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/mkdo/woocommerce-gift-aid
 * @since      1.0.0
 *
 * @package    WooCommerce_Gift_Aid
 * @subpackage WooCommerce_Gift_Aid/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WooCommerce_Gift_Aid
 * @subpackage WooCommerce_Gift_Aid/includes
 * @author     Make Do <hello@makedo.in>
 */
class WooCommerce_Gift_Aid_Activator {

	/**
	 * Activate
	 * @since    1.0.0
	 */
	public static function activate() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-gift-aid-admin.php';
	}
}


