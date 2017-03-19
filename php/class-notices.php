<?php
/**
 * Notices Class.
 *
 * @since	0.1.0
 *
 * @package dtg\plugin_name
 */

namespace dtg\plugin_name;

/**
 * Class Notices
 *
 * Generates various plugin notices, including on activation.
 *
 * @since	0.1.0
 *
 * @package dtg\plugin_name
 */
class Notices {

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
	 * Constructor
	 *
	 * @since	0.1.0
	 */
	function __construct() {
		$this->plugin_root 		 = DTG_PLUGIN_NAME_ROOT;
		$this->plugin_name		 = DTG_PLUGIN_NAME_NAME;
		$this->plugin_textdomain = DTG_PLUGIN_NAME_TEXT_DOMAIN;
		$this->plugin_prefix     = DTG_PLUGIN_NAME_PREFIX;
	}

	/**
	 * Unleash Hell.
	 *
	 * @since	0.1.0
	 */
	public function run() {
		// Hook in specific functionality such as adding notices etc.
		add_action( 'admin_notices', array( $this, 'display_activation_notices' ), 10 );
	}

	/**
	 * Display notice(s) on plugin activation.
	 *
	 * @since	0.1.0
	 */
	public function display_activation_notices() {

		// Does the activation transient exist?
		if ( ! empty( get_transient( $this->plugin_prefix . '_activated' ) ) ) {

			$activation_notices = array();

			// Add a successful activation notice.
			$activation_text      = __( sprintf( '%s has been successfully activated.', $this->plugin_name ), $this->plugin_textdomain );
			$activation_notice    = apply_filters( $this->plugin_prefix . '_activation_notice', $activation_text );
			$activation_notices[] = $activation_notice;

			// Have we got any notices to display?
			if ( ! empty( $activation_notices ) ) {

				// Loop through the array and generate the notices.
				foreach ( $activation_notices as $notice ) {
					echo '<div class="updated notice is-dismissible"><p>' . esc_html( $notice ) . '</p></div>';
				}
			}

			// Delete the activated/deactivated transients.
			delete_transient( $this->plugin_prefix . '_activated' );
			delete_transient( $this->plugin_prefix . '_deactivated' );
		}
	}
}
