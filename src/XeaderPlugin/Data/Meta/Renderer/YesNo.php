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

class XeaderPlugin_Data_Meta_Renderer_YesNo extends XeaderPlugin_Data_Meta_Renderer_Text {

	public function render( $display_value, $meta ) {

		$display_value = (bool) $display_value ? __( 'Yes' ) : __( 'No' );

		return parent::render( $display_value, $meta );
	}

}