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
 * Xeader Plugin Autoloader.
 */
class XeaderPlugin_Autoloader {

	const PLUGIN_PREFIX = 'XeaderPlugin';

	/**
	 * Handles auto-loading of XeaderPlugin classes.
	 *
	 * @param string $class
	 */
	public static function autoload( $class ) {
		$classpath = str_replace( array( '_', "\0" ), array( '/', '' ), $class );
		if ( is_file( $file = __DIR__ . '/../' . $classpath . '.php' )
		     || is_file( $file = __DIR__ . '/Global/' . $classpath . '.php' )
		) {
			require $file;
		}
	}

	/**
	 * Registers XeaderPlugin_Autoloader as an SPL autoloader.
	 *
	 * @param bool $prepend
	 */
	public static function register( $prepend = false ) {
		if ( version_compare( phpversion(), '5.3.0', '>=' ) ) {
			spl_autoload_register( array( new self(), 'autoload' ), true, $prepend );
		} else {
			spl_autoload_register( array( new self(), 'autoload' ) );
		}
	}
}
