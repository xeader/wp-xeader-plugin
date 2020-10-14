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

/**
 * A Route describes a route and its parameters.
 */
class XeaderPlugin_Routing_Route {
	/**
	 * The hook called when this route is matched.
	 *
	 * @var string
	 */
	private $hook;
	/**
	 * The URL path that the route needs to match.
	 *
	 * @var string
	 */
	private $path;
	/**
	 * The template that the route wants to load.
	 *
	 * @var string
	 */
	private $template;

	/**
	 * Constructor.
	 *
	 * @param string $path
	 * @param string $hook
	 * @param string $template
	 */
	public function __construct( $path, $hook = '', $template = '' ) {
		$this->hook     = $hook;
		$this->path     = $path;
		$this->template = $template;
	}

	/**
	 * Get the hook called when this route is matched.
	 *
	 * @return string
	 */
	public function get_hook() {
		return $this->hook;
	}

	/**
	 * Get the URL path that the route needs to match.
	 *
	 * @return string
	 */
	public function get_path() {
		return $this->path;
	}

	/**
	 * Get the template that the route wants to load.
	 *
	 * @return string
	 */
	public function get_template() {
		return $this->template;
	}

	/**
	 * Checks if this route want to call a hook when matched.
	 *
	 * @return bool
	 */
	public function has_hook() {
		return ! empty( $this->hook );
	}

	/**
	 * Checks if this route want to load a template when matched.
	 *
	 * @return bool
	 */
	public function has_template() {
		return ! empty( $this->template );
	}

}