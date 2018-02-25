<?php
/**
 * HMRC Report Class.
 *
 * @since   1.4.0
 *
 * @package dtg\gift_aid_for_woocommerce
 *
 * @todo Add settings
 */

namespace dtg\gift_aid_for_woocommerce;

/**
 * Class HMRC_Report
 *
 * Provide a facility to export a .csv
 * file suitable for importing into a
 * spreadsheet that can be sent to HMRC.
 *
 * @since   1.4.0
 *
 * @package dtg\gift_aid_for_woocommerce
 */
class HMRC_Report {

	/**
	 * Path to the root plugin file.
	 *
	 * @var     string
	 * @access  private
	 * @since   1.4.0
	 */
	private $plugin_root;

	/**
	 * Plugin name.
	 *
	 * @var     string
	 * @access  private
	 * @since   1.4.0
	 */
	private $plugin_name;

	/**
	 * Plugin prefix.
	 *
	 * @var     string
	 * @access  private
	 * @since   1.4.0
	 */
	private $plugin_prefix;

	/**
	 * Constructor.
	 *
	 * @since   1.4.0
	 */
	public function __construct() {
		$this->plugin_root       = DTG_GIFT_AID_ROOT;
		$this->plugin_name       = DTG_GIFT_AID_NAME;
		$this->plugin_prefix     = DTG_GIFT_AID_PREFIX;
	}

	/**
	 * Unleash Hell.
	 *
	 * @since   1.4.0
	 */
	public function run() {

	}

	/**
	 * AJAX function that build the
	 * report using the other methods
	 * before returning a download URL
	 * to the browser.
	 *
	 * @since   1.4.0
	 */
	public function request_report() {

	}

	/**
	 * Retrieve the order data.
	 *
	 * @since   1.4.0
	 */
	public function retrieve_data() {

	}

	/**
	 * Prepare the order data.
	 *
	 * @since   1.4.0
	 */
	public function prepare_data() {

	}

	/**
	 * Format the order data.
	 *
	 * @since   1.4.0
	 */
	public function format_data() {

	}

	/**
	 * Generate the report as a CSV.
	 *
	 * @since   1.4.0
	 */
	public function generate_report() {

	}

	/**
	 * Email the report to the specified
	 * recipient as an attachment.
	 *
	 * @since   1.4.0
	 */
	public function email_report() {

	}

	/**
	 * Render the options on the settings
	 * page using a view.
	 *
	 * This should utilise the settings filter:
	 * apply_filters( $this->plugin_prefix . '_settings', $settings_gift_aid );
	 *
	 * @since   1.4.0
	 */
	public function render_settings() {

	}
}
