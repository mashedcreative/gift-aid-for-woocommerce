<?php
/**
 * Assets Controller Class.
 *
 * @since	0.1.0
 *
 * @package dtg\plugin_name
 */

namespace dtg\plugin_name;

/**
 * Class Assets_Controller
 *
 * Enqueues JS and CSS dependencies.
 *
 * @since	0.1.0
 *
 * @package dtg\plugin_name
 */
class Assets_Controller {

	/**
	 * Path to the root plugin file.
	 *
	 * @var 	string
	 * @access	private
	 * @since	0.1.0
	 */
	private $plugin_root;

	/**
	 * Plugin name.
	 *
	 * @var 	string
	 * @access	private
	 * @since	0.1.0
	 */
	private $plugin_name;

	/**
	 * Plugin text-domain.
	 *
	 * @var 	string
	 * @access	private
	 * @since	0.1.0
	 */
	private $plugin_textdomain;

	/**
	 * Plugin prefix.
	 *
	 * @var 	string
	 * @access	private
	 * @since	0.1.0
	 */
	private $plugin_prefix;

	/**
	 * Debug mode status
	 *
	 * @var 	bool
	 * @access	private
	 * @since	0.1.0
	 */
	private $debug_mode;

	/**
	 * Asset Suffix
	 *
	 * @var 	string
	 * @access	private
	 * @since	0.1.0
	 */
	private $asset_suffix;

	/**
	 * Constructor.
	 *
	 * @since	0.1.0
	 */
	public function __construct() {
		$this->plugin_root 		 = DTG_PLUGIN_NAME_ROOT;
		$this->plugin_name		 = DTG_PLUGIN_NAME_NAME;
		$this->plugin_textdomain = DTG_PLUGIN_NAME_TEXT_DOMAIN;
		$this->plugin_prefix     = DTG_PLUGIN_NAME_PREFIX;

		// Determine whether we're in debug mode, and what the
		// asset suffix should be.
		$this->debug_mode   = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? true : false;
		$this->asset_suffix = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? '' : '.min';
	}

	/**
	 * Unleash Hell.
	 *
	 * @since	0.1.0
	 */
	public function run() {
		// Enqueue Front-end JS.
		add_action( 'public_enqueue_scripts', array( $this, 'public_enqueue_scripts' ), 10 );

		// Enqueue Admin JS.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10 );

		// Enqueue Customizer JS.
		add_action( 'customize_preview_init', array( $this, 'customizer_preview_js' ), 10 );
	}

	/**
	 * Enqueue Public Scripts.
	 *
	 * @since	0.1.0
	 */
	public function public_enqueue_scripts() {

		$do_public_enqueue     = apply_filters( $this->plugin_prefix . 'do_public_enqueue', true );
		$do_public_css_enqueue = apply_filters( $this->plugin_prefix . 'do_public_css_enqueue', true );
		$do_public_js_enqueue  = apply_filters( $this->plugin_prefix . 'do_public_js_enqueue', true );

		// Public CSS.
		if ( $do_public_enqueue && $do_public_css_enqueue ) {
			$public_css_url  = plugins_url( '/assets/prod/css/public' . $this->asset_suffix . '.css', $this->plugin_root );
			$public_css_path = dirname( $this->plugin_root ) . '/assets/prod/public' . $this->asset_suffix . '.css';

			wp_enqueue_style(
				$this->plugin_textdomain . '-public-css',
				$public_css_url,
				array(),
				filemtime( $public_css_path ),
				true
			);
		}

		// Public JS.
		if ( $do_public_enqueue && $do_public_js_enqueue ) {
			$public_js_url   = plugins_url( '/assets/prod/js/public' . $this->asset_suffix . '.js', $this->plugin_root );
			$public_js_path  = dirname( $this->plugin_root ) . '/assets/prod/js/public' . $this->asset_suffix . '.js';

			wp_enqueue_script(
				$this->plugin_textdomain . '-public-js',
				$public_js_url,
				array( 'jquery' ),
				filemtime( $public_js_path ),
				true
			);
		}
	}

	/**
	 * Enqueue Admin Scripts.
	 *
	 * @since	0.1.0
	 */
	public function admin_enqueue_scripts() {

		$do_admin_enqueue     = apply_filters( $this->plugin_prefix . 'do_admin_enqueue', true );
		$do_admin_css_enqueue = apply_filters( $this->plugin_prefix . 'do_admin_css_enqueue', true );
		$do_admin_js_enqueue  = apply_filters( $this->plugin_prefix . 'do_admin_js_enqueue', true );

		if ( $do_admin_enqueue && $do_admin_css_enqueue ) {
			$admin_css_url  = plugins_url( '/assets/prod/css/admin' . $this->asset_suffix . '.css', $this->plugin_root );
			$admin_css_path = dirname( $this->plugin_root ) . '/assets/prod/css/admin' . $this->asset_suffix . '.css';

			wp_enqueue_style(
				$this->plugin_textdomain . '-admin-css',
				$admin_css_url,
				array(),
				filemtime( $admin_css_path ),
				true
			);
		}

		if ( $do_admin_enqueue && $do_admin_js_enqueue ) {
			$admin_js_url   = plugins_url( '/assets/prod/js/admin' . $this->asset_suffix . '.js', $this->plugin_root );
			$admin_js_path  = dirname( $this->plugin_root ) . '/assets/prod/js/admin' . $this->asset_suffix . '.js';

			wp_enqueue_script(
				$this->plugin_textdomain . '-admin-js',
				$admin_js_url,
				array( 'jquery' ),
				filemtime( $admin_js_path ),
				true
			);
		}
	}

	/**
	 * Enqueue live preview JS handlers.
	 *
	 * @since	0.1.0
	 */
	function customizer_preview_js() {
		$do_customizer_js_enqueue  = apply_filters( $this->plugin_prefix . 'do_customizer_js_enqueue', true );

		if ( $do_customizer_js_enqueue ) {
			$customizer_js_url  = plugins_url( '/assets/prod/js/customizer' . $this->asset_suffix . '.js', $this->plugin_root );
			$customizer_js_path = dirname( $this->plugin_root ) . '/assets/prod/js/customizer' . $this->asset_suffix . '.js';

			wp_enqueue_script( $this->plugin_textdomain . '-customizer', $customizer_js_url, array( 'customize-preview' ), filemtime( $customizer_js_path ), true );
		}
	}
}
