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

/**
 * A shortcode represents the shortcode registered with the WordPress shortcode API.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
interface XeaderPlugin_Shortcode_ShortcodeInterface
{
	/**
	 * Get the tag name used by the shortcode.
	 *
	 * @return string
	 */
	public static function get_name();

	/**
	 * Generate the output of the shortcode.
	 *
	 * @param array|string  $attributes
	 * @param string        $content
	 *
	 * @return string
	 */
	public function generate_output($attributes, $content = '');
}
