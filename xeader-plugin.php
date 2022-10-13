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
 * @category bluelabs.cesvi.regalisolidali
 * @package bluelabs.cesvi.regalisolidali
 *
 * @author Antonio Gatta <a.gatta@xeader.com>
 * @url http://xeader.com
 * @copyright Copyright (c) 2018 Xeader Studios
 * @license All right reserved
 */

/*
Plugin Name: Xeader Plugin
Description: Xeader Abstract plugin
Author: Xeader
Version: 1.0.5
Author URI: https://xeader.com
License: GPL2
Text Domain: xeader-plugin
Domain Path: /languages
*/

// Setup class autoloader
require_once dirname( __FILE__ ) . '/src/XeaderPlugin/Autoloader.php';
XeaderPlugin_Autoloader::register();
$xeaderPlugin = new XeaderPlugin_Plugin( __FILE__ );
add_action( 'init', array( $xeaderPlugin, 'load' ));
