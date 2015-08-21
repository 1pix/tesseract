<?php
namespace Tesseract\Tesseract\Service;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Base FE dataconsumer service. All FE Data Consumer services should inherit from this class.
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_tesseract
 */
abstract class FrontendConsumerBase extends ConsumerBase {
	/**
	 * @var array Consumer's TypoScript
	 */
	protected $typoScriptConfiguration = array(); // Contains the

	/**
	 * Passes a TypoScript configuration (in array form) to the Data Consumer.
	 *
	 * @param array $conf TypoScript configuration for the extension
	 */
	public function setTypoScript(array $conf) {
		$this->$typoScriptConfiguration = $conf;
	}

	/**
	 * This method returns the TypoScript key of the extension. This may be the extension key.
	 * NOTE: if you use this method as is, don't forget to define the member variable $tsKey.
	 * NOTE: don't append a . (dot) to you ts key, it is done automatically by this method.
	 *
	 * @return string TypoScript key of the extension
	 */
	public function getTypoScriptKey() {
		return $this->tsKey . '.';
	}
}
