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
		wp_enqueue_style( $this->woocommerce_gift_aid, plugin_dir_url( __FILE__ ) . 'css/woocommerce-gift-aid-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->woocommerce_gift_aid, plugin_dir_url( __FILE__ ) . 'js/woocommerce-gift-aid-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Add the necessary action and filter hooks
	 * @since    1.0.0
	 */
	public function add_hooks() {
		// Register our activation hook for the admin notice.
		register_activation_hook( __FILE__, array( $this, 'add_notice' ) );

		// Hook into admin notices action.
		add_action( 'admin_notices', array( $this, 'add_notice' ) );

		// Add a section and populate it with our settings.
		add_filter( 'woocommerce_get_sections_tax', array( $this, 'add_section' ) , 10 );
		add_filter( 'woocommerce_get_settings_tax',  array( $this, 'add_settings' ), 10 );

		// Add a sortable Gift Aid column, populated with the status for each order.
		add_filter( 'manage_edit-shop_order_columns', array( $this, 'add_orders_column' ), 10 );
		add_action( 'manage_shop_order_posts_custom_column', array( $this, 'add_column_data' ), 10 );

		// Add the Gift Aid status to the order details screen.
		add_action( 'woocommerce_admin_order_data_after_order_details', array( $this, 'add_order_details' ), 10 );

		// Add a Gift Aid column to the output of the WooCommerce CSV Export plugin if it is active.
		if ( in_array( 'woocommerce-customer-order-csv-export/woocommerce-customer-order-csv-export.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			add_filter( 'wc_customer_order_csv_export_order_headers', array( $this, 'wc_csv_export_modify_column_headers' ), 10 );
			add_filter( 'wc_customer_order_csv_export_order_row', array( $this, 'wc_csv_export_modify_row_data' ), 10, 3 );
		}
	}

	/**
	 * Generate an admin notice on activation
	 * @since    1.0.0
	 **/
	public static function add_notice() {

		// Prepare our notice.
		$notice = apply_filters( 'woocommerce_gift_aid_activation_notice', __( 'WooCommerce Gift Aid has been installed and can be configured in the Tax tab of your WooCommerce settings.' , 'woocommerce-gift-aid' ) );

		// Ensure the notice is shown only once.
		if ( 1 != get_option( 'woocommerce_gift_aid_notice' ) ) {

			// Save the fact the plugin is active in an option.
			add_option( 'woocommerce_gift_aid_notice', 1 );

			// Output the HTML to create the notice.
			echo '<div class="updated"><p>' . esc_html( $notice ) . '</p></div>';
		}
	}

	/**
	 * Create a Gift Aid section in the tab
	 * @param array $sections An array of sections.
	 * @since    1.0.0
	 **/
	public static function add_section( $sections ) {
		$sections['gift_aid'] = apply_filters( 'woocommerce_gift_aid_section_name', __( 'Gift Aid', 'woocommerce-gift-aid' ) );

		return $sections;
	}

	/**
	 * Add settings to our section
	 * @param array $settings An array of settings.
	 * @since    1.0.0
	 */
	public static function add_settings( $settings ) {
		global $current_section;

		if ( 'gift_aid' === $current_section ) {

			$settings_gift_aid = array();

			$settings_gift_aid[] = array(
				'name' => __( 'Gift Aid', 'woocommerce-gift-aid' ),
				'type' => 'title',
				'desc' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vestibulum ornare odio non pulvinar! Donec at neque quam.' ),
				'id'   => 'gift_aid_section_title',
			);

			$settings_gift_aid[] = array(
				'name' => __( 'Enable Gift Aid', 'woocommerce-gift-aid' ),
				'type' => 'checkbox',
				'desc' => __( 'Whether or not to enable Gift Aid at the checkout.', 'woocommerce-gift-aid' ),
				'id'   => 'gift_aid_checkbox',
			);

			$settings_gift_aid[] = array(
				'name'  => __( 'Gift Aid Section Heading', 'woocommerce-gift-aid' ),
				'type'  => 'text',
				'id'    => 'gift_aid_heading',
				'class' => 'gift_aid_heading',
			);

			$settings_gift_aid[] = array(
				'name'  => __( 'Gift Aid Description', 'woocommerce-gift-aid' ),
				'type'  => 'textarea',
				'desc'  => __( 'Text explaining Gift Aid to the donor.', 'woocommerce-gift-aid' ),
				'id'    => 'gift_aid_info',
				'class' => 'gift_aid_text',
			);

			$settings_gift_aid[] = array(
				'type' => 'sectionend',
				'id'   => 'gift_aid_section_end',
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
		// Add columns into our new array if $columns is an array.
		$new_columns = (is_array( $columns )) ? $columns : array();

		// Remove the order actions column.
		unset( $new_columns['order_actions'] );

		// Create our column.
		$new_columns['gift_aid'] = apply_filters( 'woocommerce_gift_aid_orders_column_name', __( 'Gift Aid', 'woocommerce-gift-aid' ) );

		// Put the order actions column back.
		$new_columns['order_actions'] = $columns['order_actions'];

		return $new_columns;
	}

	/**
	 * Add a Gift Aid column to the shop orders screen
	 * @param string $column Column name.
	 * @since    1.0.0
	 */
	public static function add_column_data( $column ) {
		// Get the Gift Aid post meta.
		global $post;
		$status = get_post_meta( $post->ID, 'gift_aid_enabled', true );

		// Output the Gift Aid status in our column.
		if ( 'gift_aid' === $column  ) {
			echo esc_html( $status ? __( 'Yes', 'woocommerce-gift-aid' ) : __( 'No', 'woocommerce-gift-aid' ) );
		}
	}

	/**
	 * Add the Gift Aid status for each order on the shop orders screen
	 * @param object $order Current order object.
	 * @since    1.0.0
	 */
	public static function add_order_details( $order ) {
		// Get the post meta and set the status text accordingly.
		$giftaid = ( '1' === get_post_meta( $order->id, 'gift_aid_enabled', true ) ? __( 'Yes', 'woocommerce-gift-aid' ) : __( 'No', 'woocommerce-gift-aid' ) );

		// Output the HTML.
		?>

	    <div class="order_data_column">
	        <h4><?php esc_html_e( 'Gift Aid', 'woocommerce-gift-aid' ); ?></h4>
	        <?php
	            echo '<p><strong>' . esc_html( __( 'Donated', 'woocommerce-gift-aid' ) ) . ':</strong> ' . esc_html( $giftaid ) . '</p>';
	        ?>
	    </div>

	<?php
	}

	/**
	 * Create a CSV column for the Gift Aid status
	 * @param array $column_headers Array of column headers.
	 * @since    1.0.0
	 */
	public static function wc_csv_export_modify_column_headers( $column_headers ) {

		// Add the new Gift Aid column.
		$new_headers = array(
			'gift_aid' => 'gift_aid',
		);

		return array_merge( $column_headers, $new_headers );
	}

	/**
	 * Populate the CSV column with the Gift Aid status.
	 * @param array  $order_data Array of column headers.
	 * @param array  $order Array of column headers.
	 * @param object $csv_generator Array of column headers.
	 * @since    1.0.0
	 */
	public static function wc_csv_export_modify_row_data( $order_data, $order, $csv_generator ) {
		// Get the post meta and set the status text accordingly.
		$giftaid = ( '1' === get_post_meta( $order->id, 'gift_aid_enabled', true ) ? __( 'Yes', 'woocommerce-gift-aid' ) : __( 'No', 'woocommerce-gift-aid' ) );

		// Prepare our data to be added to the column.
		$custom_data = array(
			'gift_aid' => $giftaid,
		);

		// Merge our data with the existing row data.
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


