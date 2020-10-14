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
 * User: Antonio Gatta
 * Date: 18/05/18
 * Time: 14:24
 */
class XeaderPlugin_Routing_Router {

	/**
	 * All registered routes.
	 *
	 * @var XeaderPlugin_Routing_Route[]
	 */
	private $routes;
	/**
	 * Query variable used to identify routes.
	 *
	 * @var string
	 */
	private $route_variable;
	/**
	 * Constructor.
	 *
	 * @param string  $route_variable
	 * @param XeaderPlugin_Routing_Route[] $routes
	 */
	public function __construct($route_variable = 'route_name', array $routes = array())
	{
		$this->routes = array();
		$this->route_variable = $route_variable;
		foreach ($routes as $name => $route) {
			$this->add_route($name, $route);
		}
	}
	/**
	 * Add a route to the router. Overwrites a route if it shares the same name as an already registered one.
	 *
	 * @param string $name
	 * @param XeaderPlugin_Routing_Route  $route
	 */
	public function add_route($name, XeaderPlugin_Routing_Route $route)
	{
		$this->routes[$name] = $route;
	}
	/**
	 * Compiles the router into WordPress rewrite rules.
	 */
	public function compile()
	{
		add_rewrite_tag('%'.$this->route_variable.'%', '(.+)');
		foreach ($this->routes as $name => $route) {
			$this->add_rule($name, $route);
		}
	}
	/**
	 * Flushes all WordPress routes.
	 *
	 * @uses flush_rewrite_rules()
	 */
	public function flush()
	{
		flush_rewrite_rules();
	}
	/**
	 * Tries to find a matching route using the given query variables. Returns the matching route
	 * or a WP_Error.
	 *
	 * @param array $query_variables
	 *
	 * @return XeaderPlugin_Routing_Route|WP_Error
	 */
	public function match(array $query_variables)
	{
		if (empty($query_variables[$this->route_variable])) {
			return new WP_Error('missing_route_variable');
		}
		$route_name = $query_variables[$this->route_variable];
		if (!isset($this->routes[$route_name])) {
			return new WP_Error('route_not_found');
		}
		return $this->routes[$route_name];
	}
	/**
	 * Adds a new WordPress rewrite rule for the given Route.
	 *
	 * @param string $name
	 * @param XeaderPlugin_Routing_Route  $route
	 * @param string $position
	 */
	private function add_rule($name, XeaderPlugin_Routing_Route $route, $position = 'top')
	{
		add_rewrite_rule($this->generate_route_regex($route), 'index.php?'.$this->route_variable.'='.$name, $position);
	}
	/**
	 * Generates the regex for the WordPress rewrite API for the given route.
	 *
	 * @param XeaderPlugin_Routing_Route $route
	 *
	 * @return string
	 */
	private function generate_route_regex(XeaderPlugin_Routing_Route $route)
	{
		return '^'.ltrim(trim($route->get_path()), '/').'$';
	}
}