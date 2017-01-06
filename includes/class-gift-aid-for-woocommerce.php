<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/mkdo/woocommerce-gift-aid
 * @since      1.0.0
 *
 * @package    Gift_Aid_for_WooCommerce
 * @subpackage Gift_Aid_for_WooCommerce/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Gift_Aid_for_WooCommerce
 * @subpackage Gift_Aid_for_WooCommerce/includes
 * @author     Make Do <hello@makedo.in>
 */
class Gift_Aid_for_WooCommerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Gift_Aid_for_WooCommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $gift_aid_for_woocommerce    The string used to uniquely identify this plugin.
	 */
	protected $gift_aid_for_woocommerce;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->gift_aid_for_woocommerce = WC_GIFTAID_TEXTDOMAIN;
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Gift_Aid_for_WooCommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Gift_Aid_for_WooCommerce_i18n. Defines internationalization functionality.
	 * - Gift_Aid_for_WooCommerce_Admin. Defines all hooks for the admin area.
	 * - Gift_Aid_for_WooCommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gift-aid-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gift-aid-for-woocommerce-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-gift-aid-for-woocommerce-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-gift-aid-for-woocommerce-public.php';

		$this->loader = new Gift_Aid_for_WooCommerce_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Gift_Aid_for_WooCommerce_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Gift_Aid_for_WooCommerce_i18n();
		$plugin_i18n->set_domain( $this->get_gift_aid_for_woocommerce() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Gift_Aid_for_WooCommerce_Admin( $this->get_gift_aid_for_woocommerce(), $this->get_version() );

		// Enqueue CSS & JS assets.
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles', 10 );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts', 10 );

		// Admin notice hooks.
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'admin_notice', 10 );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'admin_init', 10 );

		// Add a section and populate it with our settings.
		// TO DO: Change this to a different tab - presuming the tab isn't broken in core!
		$this->loader->add_filter( 'woocommerce_get_sections_products', $plugin_admin, 'add_section' , 10 );
		$this->loader->add_filter( 'woocommerce_get_settings_products', $plugin_admin, 'add_settings', 10, 2 );

		// Add a sortable Gift Aid column, populated with the status for each order.
		$this->loader->add_filter( 'manage_edit-shop_order_columns', $plugin_admin, 'add_orders_column', 10 );
		$this->loader->add_action( 'manage_shop_order_posts_custom_column', $plugin_admin, 'add_column_data', 10 );

		// Add the Gift Aid meta to the order details screen.
		$this->loader->add_action( 'woocommerce_admin_order_data_after_order_details', $plugin_admin, 'add_order_details', 10 );

		// Add the Gift Aid meta to the order confirmation email.
		$this->loader->add_action( 'woocommerce_email_before_order_table', $plugin_admin, 'add_order_email_meta', 10, 3 );

		// Add a Gift Aid column to the output of the WooCommerce CSV Export plugin if it is active.
		if ( in_array( 'woocommerce-customer-order-csv-export/woocommerce-customer-order-csv-export.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$this->loader->add_filter( 'wc_customer_order_csv_export_order_headers', $plugin_admin, 'wc_csv_export_modify_column_headers', 10 );
			$this->loader->add_filter( 'wc_customer_order_csv_export_order_row', $plugin_admin, 'wc_csv_export_modify_row_data', 10, 3 );
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Gift_Aid_for_WooCommerce_Public( $this->get_gift_aid_for_woocommerce(), $this->get_version() );

		// Enqueue CSS & JS assets.
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Add the fields to the checkout.
		$this->loader->add_action( 'woocommerce_after_order_notes', $plugin_public, 'insert_html', 10 );

		// Update the meta data for the order.
		$this->loader->add_action( 'woocommerce_checkout_update_order_meta', $plugin_public, 'update_order_meta', 10 );

		// Add the meta data to the thank you page.
		$this->loader->add_action( 'woocommerce_thankyou', $plugin_public, 'add_to_thank_you', 10 );

		// AJAX hooks for front-end HTML generation.
		$this->loader->add_action( 'wp_ajax_add_to_checkout', $plugin_public, 'add_to_checkout', 10 );
		$this->loader->add_action( 'wp_ajax_nopriv_add_to_checkout', $plugin_public, 'add_to_checkout', 10 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_gift_aid_for_woocommerce() {
		return $this->gift_aid_for_woocommerce;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Gift_Aid_for_WooCommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
