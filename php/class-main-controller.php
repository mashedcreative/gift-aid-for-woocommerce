<?php
/**
 * Main Controller Class.
 *
 * @since	0.1.0
 *
 * @package dtg\plugin_name
 */

namespace dtg\plugin_name;

/**
 * Class Main_Controller
 *
 * @since	0.1.0
 *
 * @package dtg\plugin_name
 */
class Main_Controller {

	/**
	 * Take action on plugin activation.
	 *
	 * @var 	object
	 * @access	private
	 * @since	0.1.0
	 */
	private $activator;

	/**
	 * Take action on plugin deactivation.
	 *
	 * @var 	object
	 * @access	private
	 * @since	0.1.0
	 */
	private $deactivator;

	/**
	 * Take action on plugin uninstall.
	 *
	 * @var 	object
	 * @access	private
	 * @since	0.1.0
	 */
	private $uninstaller;

	/**
	 * Enqueue the public and admin assets.
	 *
	 * @var 	object
	 * @access	private
	 * @since	0.1.0
	 */
	private $assets_controller;

	/**
	 * Define the settings page.
	 *
	 * @var 	object
	 * @access	private
	 * @since	0.1.0
	 */
	private $settings;

	/**
	 * Define the Customizer options.
	 *
	 * @var 	object
	 * @access	private
	 * @since	0.1.0
	 */
	private $customizer;

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
	 * Constructor.
	 *
	 * @param 	Settings		  $settings          Define the settings page.
	 * @param 	Activator		  $activator		 Take action on plugin activation.
	 * @param 	Deactivator		  $deactivator		 Take action on plugin deactivation.
	 * @param 	Uninstaller		  $uninstaller		 Take action on plugin uninstall.
	 * @param 	Notices			  $notices           Display notices in various conditions.
	 * @param 	Assets_Controller $assets_controller Enqueue the public and admin assets.
	 * @param 	Customizer		  $customizer        Define the customizer options.
	 *
	 * @since 0.1.0
	 */
	public function __construct(
		Settings $settings,
		Activator $activator,
		Deactivator $deactivator,
		Uninstaller $uninstaller,
		Notices $notices,
		Assets_Controller $assets_controller,
		Customizer $customizer
		) {

		$this->plugin_root 		 	= DTG_PLUGIN_NAME_ROOT;
		$this->plugin_name		 	= DTG_PLUGIN_NAME_NAME;
		$this->plugin_textdomain 	= DTG_PLUGIN_NAME_TEXT_DOMAIN;
		$this->plugin_prefix     	= DTG_PLUGIN_NAME_PREFIX;

		$this->settings				= $settings;
		$this->activator			= $activator;
		$this->deactivator			= $deactivator;
		$this->uninstaller			= $uninstaller;
		$this->notices				= $notices;
		$this->assets_controller	= $assets_controller;
		$this->customizer			= $customizer;
	}

	/**
	 * Unleash Hell.
	 *
	 * @since		0.1.0
	 */
	public function run() {
		load_plugin_textdomain(
			$this->plugin_textdomain,
			false,
			$this->plugin_root . '/../languages'
		);

		$this->settings->run();
		$this->activator->run();
		$this->deactivator->run();
		$this->uninstaller->run();
		$this->notices->run();
		$this->assets_controller->run();
		$this->customizer->run();
	}
}
