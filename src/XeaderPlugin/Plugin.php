<?php
/**
 * Xeader Studios
 *
 * NOTICE OF LICENCE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt
 * It is also available through th world-wide-web at this URL:
 * https://xeader.com/LICENCE-CE.txt
 *
 * @category  bluelabs.cesvi.regalisolidali
 * @package   bluelabs.cesvi.regalisolidali
 *
 * @author    Antonio Gatta <a.gatta@xeader.com>
 * @url http://xeader.com
 * @copyright Copyright (c) 2018 Xeader Studios
 * @license   All right reserved
 */

class XeaderPlugin_Plugin {

	const PREFIX = 'xeader_plugin_';

	const CLASS_PREFIX = 'XeaderPlugin';

	/**
	 * Absolute path to the directory where WordPress installed the plugin.
	 *
	 * @var string
	 */
	protected $plugin_path;

	/**
	 * URL to the directory where WordPress installed the plugin.
	 *
	 * @var string
	 */
	protected $plugin_url;

	/**
	 * The basename of the plugin.
	 *
	 * @var string
	 */
	protected $basename;

	/**
	 * The plugin event manager.
	 *
	 * @var XeaderPlugin_EventManagement_EventManager
	 */
	protected $event_manager;

	/**
	 * Flag to track if the plugin is loaded.
	 *
	 * @var bool
	 */
	protected $loaded;

	/**
	 * The plugin router.
	 *
	 * @var XeaderPlugin_Routing_Router
	 */
	protected $router;

	/**
	 * Constructor.
	 *
	 * @param string $file
	 */
	public function __construct( $file ) {
		$this->loaded      = false;
		$this->basename    = plugin_basename( $file );
		$this->plugin_path = plugin_dir_path( $file );
		$this->plugin_url  = plugin_dir_url( $file );

		if ( ! $this->event_manager ) {
			$this->event_manager = new XeaderPlugin_EventManagement_EventManager();
		}
		if ( ! $this->router ) {
			$this->router = new XeaderPlugin_Routing_Router();
		}
	}

	/**
	 * Checks if the plugin is loaded.
	 *
	 * @return bool
	 */
	public function is_loaded() {
		return $this->loaded;
	}

	/**
	 * Loads the plugin into WordPress.
	 */
	public function load() {
		if ( $this->is_loaded() ) {
			return;
		}

		// Subscribers
		if ( $this->event_manager ) {
			foreach ( $this->get_subscribers() as $subscriber ) {
				$this->event_manager->add_subscriber( $subscriber );
			}
		}

		// Routes
		if ( $this->router && $routes = $this->get_routes() ) {
			XeaderPlugin_Routing_Processor::init($this->router, $routes,static::PREFIX);
		}

		// Shortcodes
		foreach ( $this->get_shortcodes() as $shortcode ) {
			$this->register_shortcode( $shortcode );
		}

		// Settings Page
		// $settings_page = new XeaderPlugin_Admin_Settings();
		// $settings_page->run();

		$this->loaded = true;
		do_action( static::PREFIX . 'loaded' );
	}

	/**
	 * Get the plugin routes.
	 *
	 * @return XeaderPlugin_Routing_Route[]
	 */
	protected function get_routes() {
		return $this->event_manager->filter( static::PREFIX . 'routes', array(// Our plugin routes
		) );
	}

	/**
	 * Get the plugin event subscribers.
	 *
	 * @return XeaderPlugin_EventManagement_SubscriberInterface[]
	 */
	protected function get_subscribers() {
		return $this->event_manager->filter( static::PREFIX . 'subscribers', array(
			// Our plugin event subscribers
			// new XeaderPlugin_Subscriber_CustomPostTypeSubscriber(),
		) );
	}

	/**
	 * Get the plugin shortcodes.
	 *
	 * @return XeaderPlugin_Shortcode_ShortcodeInterface[]
	 */
	protected function get_shortcodes() {
		return array(
			// Our Shortcodes
			// new XeaderPlugin_Shortcode_XeaderShortcode($this->get_xeader_shortcode_generator(), $this->get_supported_post_types()),
		);
	}

	/**
	 * Register the given shortcode with the WordPress shortcode API.
	 *
	 * @param XeaderPlugin_Shortcode_ShortcodeInterface $shortcode
	 */
	protected function register_shortcode( XeaderPlugin_Shortcode_ShortcodeInterface $shortcode ) {
		add_shortcode( $shortcode::get_name(), array( $shortcode, 'generate_output' ) );
	}

	public function get_plugin_path() {
		return $this->plugin_path;
	}
}
