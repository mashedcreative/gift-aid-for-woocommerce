<?php
/**
 * Gift Aid for WooCommerce
 *
 * @link              https://github.com/davetgreen/gift-aid-for-woocommerce
 *
 * @since			  1.3.0
 *
 * @package           dtg\gift-aid-for-woocommerce
 *
 * Plugin Name:       Gift Aid for WooCommerce
 * Plugin URI:        https://github.com/davetgreen/gift-aid-for-woocommerce
 * Description:       A plugin for WooCommerce that empowers donors to elect to reclaim Gift Aid at the checkout.
 * Version:           1.3.5
 * Contributors:	  davetgreen, mkdo
 * Author:            Dave Green <hello@davetgreen.me>
 * Author URI:        http://www.davetgreen.me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gift-aid-for-woocommerce
 * Domain Path:       /languages
 */

// Abort if this file is called directly.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Constants.
define( 'DTG_GIFT_AID_ROOT', __FILE__ );
define( 'DTG_GIFT_AID_NAME', 'Gift Aid for WooCommerce' );
define( 'DTG_GIFT_AID_SLUG', 'gift-aid-for-woocommerce' ); // Not for use as the textdomain!
define( 'DTG_GIFT_AID_PREFIX', 'gift_aid_for_woocommerce' );

// Classes.
require_once 'php/class-settings.php';
require_once 'php/class-helpers.php';
require_once 'php/class-activator.php';
require_once 'php/class-deactivator.php';
require_once 'php/class-uninstaller.php';
require_once 'php/class-notices.php';
require_once 'php/class-assets-controller.php';
require_once 'php/class-customizer.php';
require_once 'php/class-orders.php';
require_once 'php/class-checkout.php';
require_once 'php/class-csv-export.php';
require_once 'php/class-main-controller.php';

// Namespaces.
use dtg\gift_aid_for_woocommerce\Settings;
use dtg\gift_aid_for_woocommerce\Helpers;
use dtg\gift_aid_for_woocommerce\Activator;
use dtg\gift_aid_for_woocommerce\Deactivator;
use dtg\gift_aid_for_woocommerce\Uninstaller;
use dtg\gift_aid_for_woocommerce\Notices;
use dtg\gift_aid_for_woocommerce\Assets_Controller;
use dtg\gift_aid_for_woocommerce\Customizer;
use dtg\gift_aid_for_woocommerce\Orders;
use dtg\gift_aid_for_woocommerce\Checkout;
use dtg\gift_aid_for_woocommerce\CSV_Export;
use dtg\gift_aid_for_woocommerce\Main_Controller;

// Bootstrap the plugin if WooCommerce is active.
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	// Instances.
	$settings                 = new Settings();
	$activator    			  = new Activator();
	$deactivator  			  = new Deactivator();
	$uninstaller  			  = new Uninstaller();
	$notices	  			  = new Notices();
	$assets_controller  	  = new Assets_Controller();
	$customizer               = new Customizer();
	$orders            		  = new Orders();
	$checkout            	  = new Checkout();
	$csv_export				  = new CSV_Export();
	$main_controller          = new Main_Controller(
		$settings,
		$activator,
		$deactivator,
		$uninstaller,
		$notices,
		$assets_controller,
		$customizer,
		$orders,
		$checkout,
		$csv_export
	);

	// Go.
	$main_controller->run();
}
