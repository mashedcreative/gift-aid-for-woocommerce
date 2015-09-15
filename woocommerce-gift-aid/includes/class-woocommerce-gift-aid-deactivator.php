<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/mkdo/woocommerce-gift-aid
 * @since      1.0.0
 *
 * @package    WooCommerce_Gift_Aid
 * @subpackage WooCommerce_Gift_Aid/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    WooCommerce_Gift_Aid
 * @subpackage WooCommerce_Gift_Aid/includes
 * @author     Make Do <hello@makedo.in>
 */
class WooCommerce_Gift_Aid_Deactivator {

	/**
	 * Deactivate
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// Remove the option we used to prevent the notice showing more than once.
		if ( get_option( 'woocommerce_gift_aid_notice' ) ) {
			delete_option( 'woocommerce_gift_aid_notice' );
		}
	}
}
