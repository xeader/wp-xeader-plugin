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
 * @category bluelabs.telethon.b2b
 * @package bluelabs.telethon.b2b
 *
 * @author Antonio Gatta <a.gatta@xeader.com>
 * @url http://xeader.com
 * @copyright Copyright (c) 2018 Xeader Studios
 * @license All right reserved
 */

abstract class XeaderPlugin_Data_Meta_Renderer_Product_Attribute implements XeaderPlugin_Data_Meta_Renderer_Interface {

	const attribute = 'pa_'; //

	/**
	 * Return Term name from value
	 *
	 * @param $display_value
	 * @param $meta
	 *
	 * @return string
	 */
	public function render( $display_value, $meta ) {

		/** @var WP_Term[] $terms */
		if ( $terms = get_terms( static::attribute ) ) {
			foreach ( $terms as $term ) {
				if ( $term->slug === $display_value ) {
					return $term->name;
				}
			}

		}

		return $display_value;
	}

}
