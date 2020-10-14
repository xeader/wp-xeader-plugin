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

abstract class XeaderPlugin_EventManagement_SubscriberAbstract {
	/** @var XeaderPlugin_Plugin */
	protected $plugin;

	/**
	 * Class constructor.
	 *
	 * @param XeaderPlugin_Plugin $plugin
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}
}
