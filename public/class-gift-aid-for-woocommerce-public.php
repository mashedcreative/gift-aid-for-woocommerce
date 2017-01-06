<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/mkdo/woocommerce-gift-aid
 * @since      1.0.0
 *
 * @package    Gift_Aid_for_WooCommerce
 * @subpackage Gift_Aid_for_WooCommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gift_Aid_for_WooCommerce
 * @subpackage Gift_Aid_for_WooCommerce/public
 * @author     Make Do <hello@makedo.in>
 */
class Gift_Aid_for_WooCommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $gift_aid_for_woocommerce    The ID of this plugin.
	 */
	private $gift_aid_for_woocommerce;

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
	 * @param      string $gift_aid_for_woocommerce       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $gift_aid_for_woocommerce, $version ) {

		$this->gift_aid_for_woocommerce = $gift_aid_for_woocommerce;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->gift_aid_for_woocommerce, plugin_dir_url( __FILE__ ) . 'css/gift-aid-for-woocommerce-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->gift_aid_for_woocommerce, plugin_dir_url( __FILE__ ) . 'js/gift-aid-for-woocommerce-public.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->gift_aid_for_woocommerce, 'gift_aid_html', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'security' => wp_create_nonce( 'giftaid_ajax_security' ) ) );
	}

	/**
	 * Re-insert the checkbox when the country is changed back to UK.
	 * @since    1.0.0
	 */
	function add_to_checkout() {
		$checkout = WC()->checkout();

		// Fetch the selected country from the checkout object.
		$country = $checkout->get_value( 'billing_country' );

		// If the country code is 'GB'.
		if ( 'GB' === $country ) {

			// Add the HTML.
			$this->insert_html();

			// Check the nonce.
			check_ajax_referer( 'giftaid_ajax_security', 'security' );

			exit();
		}
	}

	/**
	 * Add a checkbox to choose Gift Aid at the checkout
	 * @since    1.2.1
	 */
	function insert_html() {

		$checkout = WC()->checkout();

		// Fetch our settings data.
		$gift_aid_checkbox    = get_option( 'gift_aid_checkbox' );
		$gift_aid_heading     = get_option( 'gift_aid_heading' );
		$gift_aid_description = get_option( 'gift_aid_info' );
		$gift_aid_label       = get_option( 'gift_aid_label' );

		// If the country code is 'GB' and all the settings have been configured.
		if ( ! empty( $gift_aid_checkbox ) && ! empty( $gift_aid_label ) && ! empty( $gift_aid_description ) ) {

			// If no heading has been set, we'll need a sensible default.
			if ( empty( $gift_aid_heading ) ) {
				$gift_aid_heading = __( 'Reclaim Gift Aid', WC_GIFTAID_TEXTDOMAIN );
			}

			// Create a new section.
			echo '<section id="woocommerce-gift-aid" class="gift-aid-section" aria-labelledby="gift-aid-heading" aria-describedby="gift-aid-description">';

			// Output the heading.
			echo '<h3 id="gift-aid-heading">' . esc_html( $gift_aid_heading ) . '</h3>';

			// Output the information.
			if ( ! empty( $gift_aid_description ) ) {
				echo '<p id="gift-aid-description">' . esc_html( $gift_aid_description ) . '</p>';
			}

			// Echo the checkbox field with label text.
			woocommerce_form_field( 'gift_aid_reclaimed', array(
				'type'      => 'checkbox',
				'class'     => array( 'input-checkbox' ),
				'label'     => esc_html( $gift_aid_label ),
				'required'  => false,
			), $checkout->get_value( 'gift_aid_reclaimed' ) );

			// Create a nonce that we can use in update_order_meta().
			wp_nonce_field( 'giftaidnonce_order', 'giftaid_order_security' );

			echo '</section>';
		}
	}

	/**
	 * Update order post meta if the donor has chosen to reclaim Gift Aid
	 * @param object $order_id The order ID.
	 * @since    1.0.0
	 */
	public static function update_order_meta( $order_id ) {
		// Check for our nonce to ensure we're processing a valid order submission.
		$nonce = check_ajax_referer( 'giftaidnonce_order', 'giftaid_order_security', false );

		if ( isset( $_POST['gift_aid_reclaimed'] ) && $nonce ) {

			// Get our checkbox value.
			$reclaimed = sanitize_text_field( wp_unslash( $_POST['gift_aid_reclaimed'] ) );

			if ( $reclaimed ) {
				// Convert the default checkbox value to something more readable.
				$status = ( '1' === $reclaimed ? __( 'Yes', WC_GIFTAID_TEXTDOMAIN ) : __( 'No', WC_GIFTAID_TEXTDOMAIN ) );

				// Update the order post meta.
				update_post_meta( $order_id, 'gift_aid_reclaimed', esc_attr( $status ) );
			}
		}
	}

	/**
	 * Add confirmation of the donor's choice to reclaim Gift Aid to the thank you page.
	 * @param integer $order_id Order ID.
	 * @since    1.0.0
	 */
	public static function add_to_thank_you( $order_id ) {
		// Get the post meta containing the Gift Aid status.
		$status = get_post_meta( $order_id, 'gift_aid_reclaimed', true );

		// If Gift Aid is to be reclaimed, confirm this at the top of the page.
		if ( 'Yes' === $status ) {
			echo '<p class="gift-aid-thank-you"><strong>' . esc_html__( 'You have chosen to reclaim Gift Aid.', WC_GIFTAID_TEXTDOMAIN ) . '</strong></p>';
		}
	}
}
