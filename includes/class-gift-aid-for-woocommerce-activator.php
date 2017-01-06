<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/mkdo/woocommerce-gift-aid
 * @since      1.0.0
 *
 * @package    Gift_Aid_for_WooCommerce
 * @subpackage Gift_Aid_for_WooCommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Gift_Aid_for_WooCommerce
 * @subpackage Gift_Aid_for_WooCommerce/includes
 * @author     Make Do <hello@makedo.in>
 */
class Gift_Aid_for_WooCommerce_Activator {

	/**
	 * Activate
	 * @since    1.0.0
	 */
	public static function activate() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-gift-aid-for-woocommerce-admin.php';
	}
}
