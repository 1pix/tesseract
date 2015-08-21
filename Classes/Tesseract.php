<?php
namespace Tesseract\Tesseract;

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

use Tesseract\Tesseract\Component\DataControllerOutputInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Tesseract\Tesseract\Exception\MissingComponentException;
use Tesseract\Tesseract\Service\Component;

/**
 * Base class for the Tesseract Project.
 *
 * Contains a couple of constants and a factory class
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_tesseract
 */
class Tesseract {

	// Define class constants for structure types
	const RECORDSET_STRUCTURE_TYPE = 'recordset';
	const IDLIST_STRUCTURE_TYPE = 'idlist';

	/**
	 * Returns the right Tesseract component given the input values
	 * and performs additional, common initializations on the component
	 *
	 * @param string $type Type of component
	 * @param string $subtype Specific subtype of component
	 * @param array $componentData Data for the component
	 * @param DataControllerOutputInterface $controller Reference to the calling controller
	 * @throws MissingComponentException
	 * @return Component
	 */
	public static function getComponent($type, $subtype, $componentData, DataControllerOutputInterface $controller) {
		// Get the correct service instance
		/** @var $component Component */
		$component = GeneralUtility::makeInstanceService($type, $subtype);
		// Check if a service was found and returned an appropriate type
		if (!($component instanceof Component)) {
			throw new MissingComponentException(
				'No service found for type: '. $type .', subtype: ' . $subtype,
				1341692083
			);
		} else {
				// Load the component's data
			$component->loadData($componentData);
				// Set the reference to the controller
			$component->setController($controller);
		}
		return $component;
	}
}
