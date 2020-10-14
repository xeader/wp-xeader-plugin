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

use XeaderPlugin_Routing_Route as Route;
use XeaderPlugin_Routing_Router as Router;

/**
 * The Processor is in charge of the interaction between the routing system and
 * the rest of WordPress.
 */
class XeaderPlugin_Routing_Processor {
	/**
	 * The router prefix
	 *
	 * @var string
	 */
	private $prefix;
	/**
	 * The matched route found by the router.
	 *
	 * @var Route
	 */
	private $matched_route;
	/**
	 * The router.
	 *
	 * @var Router
	 */
	private $router;
	/**
	 * The routes we want to register with WordPress.
	 *
	 * @var Route[]
	 */
	private $routes;

	/**
	 * Constructor.
	 *
	 * @param Router  $router
	 * @param Route[] $routes
	 * @param string  $prefix
	 */
	public function __construct( Router $router, array $routes = [], $prefix ) {
		$this->router = $router;
		$this->routes = $routes;
		$this->prefix = $prefix;
		$this->register_routes();
	}

	/**
	 * Initialize processor with WordPress.
	 *
	 * @param Router  $router
	 * @param Route[] $routes
	 * @param string  $prefix
	 */
	public static function init( Router $router, array $routes = [], $prefix ) {
		$self = new self( $router, $routes, $prefix );
		add_action( 'parse_request', [ $self, 'match_request' ] );
		add_action( 'template_include', [ $self, 'load_route_template' ] );
		add_action( 'template_redirect', [ $self, 'call_route_hook' ] );
		//add_action( 'init', [ $self, 'register_routes' ] );
	}

	/**
	 * Checks to see if a route was found. If there's one, it calls the route hook.
	 */
	public function call_route_hook() {
		if ( ! $this->matched_route instanceof Route || ! $this->matched_route->has_hook() ) {
			return;
		}
		do_action( $this->matched_route->get_hook() );
	}

	/**
	 * Checks to see if a route was found. If there's one, it loads the route template.
	 *
	 * @param string $template
	 *
	 * @return string
	 */
	public function load_route_template( $template ) {
		if ( ! $this->matched_route instanceof Route || ! $this->matched_route->has_template() ) {
			return $template;
		}
		$route_template = get_query_template( $this->matched_route->get_template() );
		if ( ! empty( $route_template ) ) {
			$template = $route_template;
		}

		return $template;
	}

	/**
	 * Attempts to match the current request to a route.
	 *
	 * @param WP $environment
	 */
	public function match_request( WP $environment ) {
		$matched_route = $this->router->match( $environment->query_vars );
		if ( $matched_route instanceof Route ) {
			$this->matched_route = $matched_route;
		}
//		if ( $matched_route instanceof \WP_Error && in_array( 'route_not_found', $matched_route->get_error_codes() ) ) {
//			wp_die( $matched_route, 'Route Not Found', [ 'response' => 404 ] );
//		}
	}

	/**
	 * Register all our routes into WordPress.
	 */
	public function register_routes() {
		$routes = apply_filters( $this->prefix . 'routes', $this->routes );
		foreach ( $routes as $name => $route ) {
			$this->router->add_route( $name, $route );
		}
		$this->router->compile();
		$routes_hash = md5( serialize( $routes ) );
		if ( $routes_hash != get_option( $this->prefix . 'routes_hash' ) ) {
			flush_rewrite_rules();
			update_option( $this->prefix . 'routes_hash', $routes_hash );
		}
	}
}
