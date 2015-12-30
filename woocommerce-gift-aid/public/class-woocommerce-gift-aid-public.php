<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/mkdo/woocommerce-gift-aid
 * @since      1.0.0
 *
 * @package    WooCommerce_Gift_Aid
 * @subpackage WooCommerce_Gift_Aid/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WooCommerce_Gift_Aid
 * @subpackage WooCommerce_Gift_Aid/public
 * @author     Make Do <hello@makedo.in>
 */
class WooCommerce_Gift_Aid_Public {

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
	 * @param      string $woocommerce_gift_aid       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $woocommerce_gift_aid, $version ) {

		$this->woocommerce_gift_aid = $woocommerce_gift_aid;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->woocommerce_gift_aid, plugin_dir_url( __FILE__ ) . 'css/woocommerce-gift-aid-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->woocommerce_gift_aid, plugin_dir_url( __FILE__ ) . 'js/woocommerce-gift-aid-public.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->woocommerce_gift_aid, 'giftaidhtml', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'security' => wp_create_nonce( 'giftaidnonce' ) ) );
	}

	/**
	 * Add a checkbox to choose Gift Aid at the checkout
	 */
	function add_to_checkout() {

		$checkout = WC()->checkout();

		// Fetch the selected country from the checkout object.
		$country = $checkout->get_value( 'billing_country' );

		// Fetch our settings data.
		$gift_aid_checkbox    = get_option( 'gift_aid_checkbox' );
		$gift_aid_heading     = get_option( 'gift_aid_heading' );
		$gift_aid_description = get_option( 'gift_aid_info' );
		$gift_aid_label       = get_option( 'gift_aid_label' );

		// If the country code is 'GB' and all the settings have been configured.
		if ( 'GB' === $country && ! empty( $gift_aid_checkbox ) && ! empty( $gift_aid_label ) && ! empty( $gift_aid_description ) ) {

			// If no heading has been set, we'll need a sensible default.
			if ( empty( $gift_aid_heading ) ) {
				$gift_aid_heading = __( 'Reclaim Gift Aid', 'woocommerce-gift-aid' );
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
			wp_nonce_field( 'giftaidnonce_order', 'security_order' );

			echo '</section>';

			// Check the nonce.
			$nonce = check_ajax_referer( 'giftaidnonce', 'security', false );

			// If the nonce exists, it's an AJAX call
			// and therefore we need to exit.
			if ( $nonce ) {
				exit();
			}
		}
	}

	/**
	 * Update order post meta if the donor has chosen to reclaim Gift Aid
	 * @param object $order_id The order ID.
	 */
	public static function update_order_meta( $order_id ) {

		$nonce = check_ajax_referer( 'giftaidnonce_order', 'security_order', false );

		if ( isset( $_POST['gift_aid_reclaimed'] ) && $nonce ) {

			// Get our checkbox value.
			$reclaimed = sanitize_text_field( wp_unslash( $_POST['gift_aid_reclaimed'] ) );

			if ( $reclaimed ) {
				// Convert the default checkbox value to something more readable.
				$status = ( '1' === $reclaimed ? __( 'Yes', 'woocommerce-gift-aid' ) : __( 'No', 'woocommerce-gift-aid' ) );

				// Update the order post meta.
				update_post_meta( $order_id, 'gift_aid_reclaimed', esc_attr( $status ) );
			}
		}
	}

	/**
	 * Add confirmation of the donor's choice to reclaim Gift Aid to the thank you page.
	 * @param integer $order_id Order ID.
	 */
	public static function add_to_thank_you( $order_id ) {
		// Get the post meta containing the Gift Aid status.
		$status = get_post_meta( $order_id, 'gift_aid_reclaimed', true );

		// If Gift Aid is to be reclaimed, confirm this at the top of the page.
		if ( 'Yes' === $status ) {
			echo '<p class="gift-aid-thank-you"><strong>' . esc_html__( 'You have chosen to reclaim Gift Aid.', 'woocommerce-gift-aid' ) . '</strong></p>';
		}
	}
}
