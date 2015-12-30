<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/mkdo/woocommerce-gift-aid
 * @since      1.0.0
 *
 * @package    Gift_Aid_for_WooCommerce
 * @subpackage Gift_Aid_for_WooCommerce/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Gift_Aid_for_WooCommerce
 * @subpackage Gift_Aid_for_WooCommerce/includes
 * @author     Make Do <hello@makedo.in>
 */
class Gift_Aid_for_WooCommerce_Deactivator {

	/**
	 * Deactivate
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// Remove the option we used to prevent the notice showing more than once.
		if ( get_option( 'gift_aid_for_woocommerce_notice' ) ) {
			delete_option( 'gift_aid_for_woocommerce_notice' );
		}
	}
}
