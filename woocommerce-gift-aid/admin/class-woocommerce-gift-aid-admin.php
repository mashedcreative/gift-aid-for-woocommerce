<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/mkdo/woocommerce-gift-aid
 * @since      1.0.0
 *
 * @package    WooCommerce_Gift_Aid
 * @subpackage WooCommerce_Gift_Aid/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WooCommerce_Gift_Aid
 * @subpackage WooCommerce_Gift_Aid/admin
 * @author     Make Do <hello@makedo.in>
 */
class WooCommerce_Gift_Aid_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $woocommerce_gift_aid    The ID of this plugin.
	 */
	private $woocommerce_gift_aid;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $woocommerce_gift_aid       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $woocommerce_gift_aid, $version ) {

		$this->woocommerce_gift_aid = $woocommerce_gift_aid;
		$this->version = $version;

		// Let's add our filters.
		$this->add_hooks();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WooCommerce_Gift_Aid_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WooCommerce_Gift_Aid_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->woocommerce_gift_aid, plugin_dir_url( __FILE__ ) . 'css/woocommerce-gift-aid-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WooCommerce_Gift_Aid_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WooCommerce_Gift_Aid_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->woocommerce_gift_aid, plugin_dir_url( __FILE__ ) . 'js/woocommerce-gift-aid-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add the necessary action and filter hooks
	 * @since    1.0.0
	 */
	public function add_hooks() {
		// Add a section and populate it with our settings.
		add_filter( 'woocommerce_get_sections_products', __CLASS__ . '::add_section', 10 );
		add_filter( 'woocommerce_get_settings_products', __CLASS__ . '::add_settings', 10, 2 );

		// Add a sortable Gift Aid column, populated with the status.
		add_filter( 'manage_edit-shop_order_columns', __CLASS__ . '::add_orders_column', 10 );
		add_action( 'manage_shop_order_posts_custom_column', __CLASS__ . '::add_column_data', 10 );

		// Add Gift Aid column to the output of the WooCommerce CSV Export plugin if active.
		if ( class_exists( 'WC_Customer_Order_CSV_Export' ) ) {
			add_filter( 'wc_customer_order_csv_export_order_headers', 'wc_csv_export_modify_column_headers' );
			add_filter( 'wc_customer_order_csv_export_order_row', 'wc_csv_export_modify_row_data', 10, 3 );
		}
	}

	/**
	 * Create a sub-section for Gift Aid.
	 * @param array $sections An array of sections.
	 * @since    1.0.0
	 **/
	public static function add_section( $sections ) {
		$sections['gift_aid'] = __( 'Gift Aid', 'woocommerce-gift-aid' );

		return $sections;
	}

	/**
	 * Add settings to the specific section we created before
	 * @param array $settings An array of settings.
	 * @since    1.0.0
	 */
	public static function add_settings( $settings ) {
		global $current_section;

		if ( 'gift_aid' === $current_section ) {

			$settings_gift_aid = array();

			$settings_gift_aid[] = array(
				'name'     => __( 'Gift Aid', 'woocommerce-gift-aid' ),
				'type'     => 'title',
				'desc'     => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vestibulum ornare odio non pulvinar! Donec at neque quam.
				Quisque libero leo; congue sit amet eros nec, ornare faucibus ex. Vivamus imperdiet, sem a aliquam rhoncus, tortor turpis accumsan tellus,
				eu cursus ex erat at quam.',
				'id'       => 'gift_aid_section_title',
			);

			$settings_gift_aid[] = array(
				'name' => __( 'Gift Aid', 'woocommerce-gift-aid' ),
				'type' => 'checkbox',
				'desc' => __( 'Enable Gift Aid at the checkout.', 'woocommerce-gift-aid' ),
				'id'   => 'gift_aid_checkbox',
			);

			$settings_gift_aid[] = array(
				'name' => __( 'Gift Aid Text', 'woocommerce-gift-aid' ),
				'type' => 'textarea',
				'desc' => __( 'Descriptive text explaining the concept of Gift Aid.', 'woocommerce-gift-aid' ),
				'id'   => 'gift_aid_info',
				'class' => 'gift_aid_text',
			);

			$settings_gift_aid[] = array(
				'type' => 'sectionend',
				'id' => 'gift_aid_section_end',
			);

			return apply_filters( 'woocommerce_gift_aid_settings', $settings_gift_aid );
		} else {
			return apply_filters( 'woocommerce_gift_aid_settings', $settings );
		}
	}

	/**
	 * Add a Gift Aid column to the order screen.
	 * @param array $columns An array of column names.
	 * @since    1.0.0
	 */
	public static function add_orders_column( $columns ) {
		$new_columns = (is_array( $columns )) ? $columns : array();

		unset( $new_columns['order_actions'] );

		$new_columns['gift_aid'] = __( 'Gift Aid', 'woocommerce-gift-aid' );

		$new_columns['order_actions'] = $columns['order_actions'];

		return $new_columns;
	}

	/**
	 * Add a Gift Aid column to the orders screen
	 * @param string $column Column name.
	 * @since    1.0.0
	 */
	public static function add_column_data( $column ) {
		global $post;

		$status = get_post_meta( $post->ID, 'gift_aid_enabled', true );

		if ( 'gift_aid' === $column  ) {
			echo esc_html_e( $status ? 'Yes' : 'No', 'woocommerce-gift-aid' );
		}
	}

	/**
	 * Add a Gift Aid column to the orders screen
	 * @param array $column_headers Array of column headers.
	 * @since    1.0.0
	 */
	public static function wc_csv_export_modify_column_headers( $column_headers ) {

		$new_headers = array(
			'gift_aid' => 'gift_aid',
		);

		return array_merge( $column_headers, $new_headers );
	}

	/**
	 * Add a Gift Aid column to the orders screen
	 * @param array  $order_data Array of column headers.
	 * @param array  $order Array of column headers.
	 * @param object $csv_generator Array of column headers.
	 * @since    1.0.0
	 */
	public static function wc_csv_export_modify_row_data( $order_data, $order, $csv_generator ) {

		$giftaid = ( '1' === get_post_meta( $order->id, 'gift_aid_enabled', true ) ? 'Yes' : 'No');

		$custom_data = array(
			'gift_aid' => $giftaid,
		);

		$new_order_data = array();

		if ( isset( $csv_generator->order_format ) && ( 'default_one_row_per_item' == $csv_generator->order_format || 'legacy_one_row_per_item' == $csv_generator->order_format ) ) {

			foreach ( $order_data as $data ) {
				$new_order_data[] = array_merge( (array) $data, $custom_data );
			}
		} else {
			$new_order_data = array_merge( $order_data, $custom_data );
		}

		return $new_order_data;
	}
}
